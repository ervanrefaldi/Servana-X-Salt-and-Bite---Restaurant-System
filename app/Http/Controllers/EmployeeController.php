<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')
            ->latest()
            ->get();

        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where('employment_status', 'active')->count();

        $unpaidSalaries = Employee::where('salary_status', 'unpaid')->count();

        return view('employees.index', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'unpaidSalaries'
        ));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'employment_status' => 'required|in:active,inactive,resigned',
        ]);

        DB::beginTransaction();

        try {
            $basicSalary = $request->basic_salary;
            $bonus = $request->bonus ?? 0;
            $deduction = $request->deduction ?? 0;
            $totalSalary = $basicSalary + $bonus - $deduction;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => true,
            ]);

            Employee::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'hire_date' => $request->hire_date,
                'position' => $request->position,
                'salary' => $basicSalary,
                'basic_salary' => $basicSalary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'total_salary' => $totalSalary,
                'employment_status' => $request->employment_status,
                'salary_status' => 'unpaid',
                'salary_payment_date' => null,
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Data karyawan dan akun login berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'salaryPayments']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $employee->load('user');

        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->load('user');

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->user_id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'employment_status' => 'required|in:active,inactive,resigned',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $basicSalary = $request->basic_salary;
            $bonus = $request->bonus ?? 0;
            $deduction = $request->deduction ?? 0;
            $totalSalary = $basicSalary + $bonus - $deduction;

            if ($employee->user) {
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'is_active' => $request->is_active,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $employee->user->update($userData);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password ?? 'password'),
                    'role' => $request->role,
                    'is_active' => $request->is_active,
                ]);

                $employee->user_id = $user->id;
            }

            $employee->update([
                'user_id' => $employee->user_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'hire_date' => $request->hire_date,
                'position' => $request->position,
                'salary' => $basicSalary,
                'basic_salary' => $basicSalary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'total_salary' => $totalSalary,
                'employment_status' => $request->employment_status,
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Data karyawan dan akun login berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}