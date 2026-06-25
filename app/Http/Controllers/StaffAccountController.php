<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffAccountController extends Controller
{
    private array $staffRoles = [
        'resepsionis',
        'kasir',
        'keuangan',
        'dapur',
        'sdm',
    ];

    public function index()
    {
        $staffAccounts = User::with('employee')
            ->whereIn('role', $this->staffRoles)
            ->latest()
            ->get();

        $totalStaffAccounts = $staffAccounts->count();
        $activeStaffAccounts = $staffAccounts->where('is_active', true)->count();
        $inactiveStaffAccounts = $staffAccounts->where('is_active', false)->count();

        return view('staff_accounts.index', compact(
            'staffAccounts',
            'totalStaffAccounts',
            'activeStaffAccounts',
            'inactiveStaffAccounts'
        ));
    }

    public function create()
    {
        $employees = Employee::where('employment_status', 'active')
            ->whereNull('user_id')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->orderBy('email')
            ->get();

        return view('staff_accounts.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_email' => 'required|email|exists:employees,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'is_active' => 'required|boolean',
        ]);

        $email = strtolower(trim($request->employee_email));

        $employee = Employee::whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $employee) {
            return back()
                ->withErrors(['employee_email' => 'Email karyawan tidak ditemukan.'])
                ->withInput();
        }

        if ($employee->employment_status !== 'active') {
            return back()
                ->withErrors(['employee_email' => 'Karyawan tidak aktif tidak dapat dibuatkan akun staff.'])
                ->withInput();
        }

        if ($employee->user_id !== null) {
            return back()
                ->withErrors(['employee_email' => 'Karyawan ini sudah memiliki akun staff.'])
                ->withInput();
        }

        if (User::whereRaw('LOWER(email) = ?', [$email])->exists()) {
            return back()
                ->withErrors(['employee_email' => 'Email ini sudah digunakan pada tabel users.'])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $employee->name,
                'email' => $email,
                'phone' => $employee->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => (bool) $request->is_active,
            ]);

            $employee->update([
                'user_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('staff-accounts.index')
                ->with('success', 'Akun staff berhasil dibuat. Staff sudah dapat login sesuai role.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        $staffAccount->load('employee');

        return view('staff_accounts.show', compact('staffAccount'));
    }

    public function edit(User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        $staffAccount->load('employee');

        return view('staff_accounts.edit', compact('staffAccount'));
    }

    public function update(Request $request, User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        $request->validate([
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'role' => $request->role,
            'is_active' => (bool) $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staffAccount->update($data);

        return redirect()->route('staff-accounts.index')
            ->with('success', 'Akun staff berhasil diperbarui.');
    }

    public function destroy(User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        if (auth()->id() === $staffAccount->id) {
            return back()->withErrors([
                'delete' => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
            ]);
        }

        DB::beginTransaction();

        try {
            $employee = Employee::where('user_id', $staffAccount->id)->first();

            if ($employee) {
                $employee->update([
                    'user_id' => null,
                ]);
            }

            $staffAccount->delete();

            DB::commit();

            return redirect()->route('staff-accounts.index')
                ->with('success', 'Akun staff berhasil dihapus. Data karyawan tetap tersimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'delete' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    private function ensureStaffAccount(User $user): void
    {
        if (! in_array($user->role, $this->staffRoles)) {
            abort(403, 'Akun ini bukan akun staff internal.');
        }
    }
}