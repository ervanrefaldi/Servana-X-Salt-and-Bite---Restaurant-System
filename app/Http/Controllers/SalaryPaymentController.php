<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FinancialTransaction;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryPaymentController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $employees = Employee::with(['salaryPayments' => function ($query) use ($month, $year) {
            $query->where('salary_month', $month)
                ->where('salary_year', $year);
        }])
            ->where('employment_status', 'active')
            ->orderBy('name')
            ->get();

        foreach ($employees as $employee) {
            if ($employee->salaryPayments->isEmpty()) {
                SalaryPayment::create([
                    'employee_id' => $employee->id,
                    'salary_month' => $month,
                    'salary_year' => $year,
                    'amount' => $employee->total_salary,
                    'status' => 'unpaid',
                    'payment_date' => null,
                    'note' => null,
                    'created_by' => auth()->id(),
                ]);
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

        return view('salary_payments.index', compact(
            'salaryPayments',
            'month',
            'year',
            'totalPayroll',
            'paidPayroll',
            'unpaidPayroll'
        ));
    }

    public function markAsPaid(SalaryPayment $salaryPayment)
    {
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
                'title' => 'Pembayaran gaji ' . $employee->name . ' bulan ' . $salaryPayment->salary_month . '-' . $salaryPayment->salary_year,
                'amount' => $salaryPayment->amount,
                'transaction_date' => now()->toDateString(),
                'description' => 'Pembayaran gaji karyawan posisi ' . $employee->position,
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
}