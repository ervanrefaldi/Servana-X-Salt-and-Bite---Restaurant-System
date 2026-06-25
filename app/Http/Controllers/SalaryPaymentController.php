<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FinancialTransaction;
use App\Models\SalaryPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryPaymentController extends Controller
{
    private const PAYROLL_DAYS = 30;
    private const BONUS_PERCENTAGE = 0.10;

    private function canManageSalaries(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'keuangan'], true);
    }

    public function index(Request $request)
    {
        $month = (int) ($request->month ?? now()->month);
        $year = (int) ($request->year ?? now()->year);

        $period = $this->getPayrollPeriod($month, $year);
        $canManage = $this->canManageSalaries();

        if ($canManage) {
            /*
            |--------------------------------------------------------------------------
            | Ambil karyawan aktif yang sudah masuk kerja paling lambat tanggal tutup buku.
            |--------------------------------------------------------------------------
            | Contoh:
            | Tutup buku 25 Juni 2026.
            | Karyawan masuk 25 Juni 2026 tetap muncul dan dihitung 1 hari.
            */

            $employees = Employee::where('employment_status', 'active')
                ->whereNotNull('hire_date')
                ->whereDate('hire_date', '<=', $period['period_end'])
                ->orderBy('name')
                ->get();

            foreach ($employees as $employee) {
            $existingSalary = SalaryPayment::where('employee_id', $employee->id)
                ->where('salary_month', $month)
                ->where('salary_year', $year)
                ->first();

            $absentDays = $existingSalary ? (int) $existingSalary->absent_days : 0;

            $calculation = $this->calculateSalary(
                $employee,
                $absentDays,
                $period['period_start'],
                $period['period_end']
            );

            if (! $existingSalary) {
                SalaryPayment::create([
                    'employee_id' => $employee->id,
                    'salary_month' => $month,
                    'salary_year' => $year,
                    'period_start' => $period['period_start']->toDateString(),
                    'period_end' => $period['period_end']->toDateString(),
                    'basic_salary' => $employee->basic_salary,
                    'daily_salary' => $calculation['daily_salary'],
                    'payable_days' => $calculation['payable_days'],
                    'base_salary_for_period' => $calculation['base_salary_for_period'],
                    'absent_days' => $absentDays,
                    'bonus' => $calculation['bonus'],
                    'deduction' => $calculation['deduction'],
                    'bonus_status' => $calculation['bonus_status'],
                    'bonus_note' => $calculation['bonus_note'],
                    'amount' => $calculation['total_salary'],
                    'status' => 'unpaid',
                    'payment_date' => null,
                    'note' => null,
                    'created_by' => auth()->id(),
                ]);
            } elseif ($existingSalary->status === 'unpaid') {
                /*
                |--------------------------------------------------------------------------
                | Jika gaji belum dibayar, data masih boleh disinkronkan.
                |--------------------------------------------------------------------------
                | Misalnya gaji pokok berubah atau absent_days berubah.
                */

                $existingSalary->update([
                    'period_start' => $period['period_start']->toDateString(),
                    'period_end' => $period['period_end']->toDateString(),
                    'basic_salary' => $employee->basic_salary,
                    'daily_salary' => $calculation['daily_salary'],
                    'payable_days' => $calculation['payable_days'],
                    'base_salary_for_period' => $calculation['base_salary_for_period'],
                    'bonus' => $calculation['bonus'],
                    'deduction' => $calculation['deduction'],
                    'bonus_status' => $calculation['bonus_status'],
                    'bonus_note' => $calculation['bonus_note'],
                    'amount' => $calculation['total_salary'],
                    'created_by' => auth()->id(),
                ]);
            }
            }
        }

        $salaryPayments = SalaryPayment::with(['employee', 'creator'])
            ->where('salary_month', $month)
            ->where('salary_year', $year)
            ->latest()
            ->get();

        $totalPayroll = $salaryPayments->sum('amount');
        $paidPayroll = $salaryPayments->where('status', 'paid')->sum('amount');
        $unpaidPayroll = $salaryPayments->where('status', 'unpaid')->sum('amount');

        $periodStart = $period['period_start'];
        $periodEnd = $period['period_end'];

        return view('salary_payments.index', compact(
            'salaryPayments',
            'month',
            'year',
            'periodStart',
            'periodEnd',
            'totalPayroll',
            'paidPayroll',
            'unpaidPayroll',
            'canManage'
        ));
    }

    public function updateAttendance(Request $request, SalaryPayment $salaryPayment)
    {
        if (! $this->canManageSalaries()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola gaji.');
        }

        if ($salaryPayment->status === 'paid') {
            return back()->withErrors([
                'attendance' => 'Jumlah tidak masuk tidak dapat diubah karena gaji sudah dibayar.',
            ]);
        }

        $request->validate([
            'absent_days' => 'required|integer|min:0|max:30',
        ]);

        $employee = $salaryPayment->employee;

        if (! $employee) {
            return back()->withErrors([
                'employee' => 'Data karyawan tidak ditemukan.',
            ]);
        }

        $periodStart = $salaryPayment->period_start
            ? Carbon::parse($salaryPayment->period_start)->startOfDay()
            : $this->getPayrollPeriod(
                (int) $salaryPayment->salary_month,
                (int) $salaryPayment->salary_year
            )['period_start'];

        $periodEnd = $salaryPayment->period_end
            ? Carbon::parse($salaryPayment->period_end)->startOfDay()
            : $this->getPayrollPeriod(
                (int) $salaryPayment->salary_month,
                (int) $salaryPayment->salary_year
            )['period_end'];

        $calculation = $this->calculateSalary(
            $employee,
            (int) $request->absent_days,
            $periodStart,
            $periodEnd
        );

        $salaryPayment->update([
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
            'basic_salary' => $employee->basic_salary,
            'daily_salary' => $calculation['daily_salary'],
            'payable_days' => $calculation['payable_days'],
            'base_salary_for_period' => $calculation['base_salary_for_period'],
            'absent_days' => (int) $request->absent_days,
            'bonus' => $calculation['bonus'],
            'deduction' => $calculation['deduction'],
            'bonus_status' => $calculation['bonus_status'],
            'bonus_note' => $calculation['bonus_note'],
            'amount' => $calculation['total_salary'],
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Data kehadiran dan perhitungan gaji berhasil diperbarui.');
    }

    public function markAsPaid(SalaryPayment $salaryPayment)
    {
        if (! $this->canManageSalaries()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola gaji.');
        }

        if ($salaryPayment->status === 'paid') {
            return back()->with('success', 'Gaji karyawan ini sudah dibayar.');
        }

        DB::beginTransaction();

        try {
            $salaryPayment->update([
                'status' => 'paid',
                'payment_date' => now()->toDateString(),
                'created_by' => auth()->id(),
            ]);

            $employee = $salaryPayment->employee;

            $employee->update([
                'salary_status' => 'paid',
                'salary_payment_date' => now()->toDateString(),
            ]);

            FinancialTransaction::create([
                'order_id' => null,
                'type' => 'expense',
                'category' => 'salary',
                'title' => 'Pembayaran gaji ' . $employee->name . ' periode ' .
                    optional($salaryPayment->period_start)->format('d-m-Y') . ' s/d ' .
                    optional($salaryPayment->period_end)->format('d-m-Y'),
                'amount' => $salaryPayment->amount,
                'transaction_date' => now()->toDateString(),
                'description' => 'Pembayaran gaji karyawan posisi ' . $employee->position .
                    '. Hari digaji: ' . $salaryPayment->payable_days .
                    ' hari. Tidak masuk: ' . $salaryPayment->absent_days .
                    ' hari. Bonus: Rp' . number_format($salaryPayment->bonus, 0, ',', '.') .
                    '. Potongan: Rp' . number_format($salaryPayment->deduction, 0, ',', '.') .
                    '. Status bonus: ' . ($salaryPayment->bonus_note ?? '-'),
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return back()->with('success', 'Gaji berhasil ditandai sudah dibayar dan masuk ke laporan keuangan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function markAsUnpaid(SalaryPayment $salaryPayment)
    {
        if (! $this->canManageSalaries()) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola gaji.');
        }

        if ($salaryPayment->status === 'unpaid') {
            return back()->with('success', 'Gaji karyawan ini sudah berstatus belum dibayar.');
        }

        $salaryPayment->update([
            'status' => 'unpaid',
            'payment_date' => null,
        ]);

        $salaryPayment->employee->update([
            'salary_status' => 'unpaid',
            'salary_payment_date' => null,
        ]);

        return back()->with('success', 'Status gaji berhasil dikembalikan menjadi belum dibayar.');
    }

    private function getPayrollPeriod(int $month, int $year): array
    {
        /*
        |--------------------------------------------------------------------------
        | Contoh:
        | Bulan tutup buku Juni 2026
        | period_start = 26 Mei 2026
        | period_end   = 25 Juni 2026
        |--------------------------------------------------------------------------
        */

        $periodEnd = Carbon::create($year, $month, 25)->startOfDay();

        $periodStart = $periodEnd
            ->copy()
            ->subMonthNoOverflow()
            ->day(26)
            ->startOfDay();

        return [
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
        ];
    }

    private function calculateSalary(Employee $employee, int $absentDays, Carbon $periodStart, Carbon $periodEnd): array
    {
        $basicSalary = (float) $employee->basic_salary;

        $dailySalary = $basicSalary / self::PAYROLL_DAYS;

        $hireDate = $employee->hire_date
            ? Carbon::parse($employee->hire_date)->startOfDay()
            : null;

        /*
        |--------------------------------------------------------------------------
        | Tentukan tanggal mulai hitung gaji
        |--------------------------------------------------------------------------
        | Jika karyawan masuk setelah tanggal buka buku, maka gaji dihitung
        | mulai tanggal masuk.
        |
        | Jika karyawan sudah masuk sebelum/sama dengan tanggal buka buku,
        | maka gaji dihitung mulai tanggal buka buku.
        */

        if (! $hireDate) {
            $effectiveStart = $periodStart->copy();
        } elseif ($hireDate->greaterThan($periodStart)) {
            $effectiveStart = $hireDate->copy();
        } else {
            $effectiveStart = $periodStart->copy();
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung hari digaji secara inklusif
        |--------------------------------------------------------------------------
        | Contoh:
        | Masuk 25 Juni, tutup buku 25 Juni = 1 hari.
        | Masuk 24 Juni, tutup buku 25 Juni = 2 hari.
        | Masuk 20 Juni, tutup buku 25 Juni = 6 hari.
        */

        if ($effectiveStart->greaterThan($periodEnd)) {
            $payableDays = 0;
        } else {
            $payableDays = $effectiveStart->diffInDays($periodEnd) + 1;
        }

        $baseSalaryForPeriod = $dailySalary * $payableDays;

        /*
        |--------------------------------------------------------------------------
        | Potongan
        |--------------------------------------------------------------------------
        | Potongan mengikuti gaji masing-masing:
        | potongan = absent_days x gaji harian.
        */

        $deduction = $absentDays * $dailySalary;

        /*
        |--------------------------------------------------------------------------
        | Bonus
        |--------------------------------------------------------------------------
        | Bonus hanya jika:
        | - karyawan sudah bekerja dari awal buka buku
        | - tidak ada hari tidak masuk
        */

        $isFullPeriodEmployee = $hireDate && $hireDate->lessThanOrEqualTo($periodStart);
        $isFullAttendance = $absentDays === 0;
        $isEligibleBonus = $isFullPeriodEmployee && $isFullAttendance;

        if ($isEligibleBonus) {
            $bonus = $basicSalary * self::BONUS_PERCENTAGE;
            $bonusStatus = 'eligible';
            $bonusNote = 'Dapat bonus karena bekerja dari awal buka buku dan tidak ada tidak masuk.';
        } elseif (! $isFullPeriodEmployee) {
            $bonus = 0;
            $bonusStatus = 'not_eligible_hire_date';
            $bonusNote = 'Tidak dapat bonus karena masuk setelah awal buka buku.';
        } else {
            $bonus = 0;
            $bonusStatus = 'not_eligible_absent';
            $bonusNote = 'Tidak dapat bonus karena memiliki hari tidak masuk.';
        }

        $totalSalary = $baseSalaryForPeriod + $bonus - $deduction;

        if ($totalSalary < 0) {
            $totalSalary = 0;
        }

        return [
            'daily_salary' => round($dailySalary, 2),
            'payable_days' => $payableDays,
            'base_salary_for_period' => round($baseSalaryForPeriod, 2),
            'bonus' => round($bonus, 2),
            'deduction' => round($deduction, 2),
            'bonus_status' => $bonusStatus,
            'bonus_note' => $bonusNote,
            'total_salary' => round($totalSalary, 2),
        ];
    }
}