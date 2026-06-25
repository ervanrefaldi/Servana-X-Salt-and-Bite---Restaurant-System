<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();

        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where('employment_status', 'active')->count();

        $inactiveEmployees = Employee::where('employment_status', 'inactive')->count();

        $resignedEmployees = Employee::where('employment_status', 'resigned')->count();

        return view('employees.index', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'resignedEmployees'
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
            'email' => 'nullable|email|max:255|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'employment_status' => 'required|in:active,inactive,resigned',
        ]);

        $basicSalary = $request->basic_salary;

        Employee::create([
            'user_id' => null,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => null,
            'hire_date' => now()->toDateString(),
            'position' => $request->position,
            'salary' => $basicSalary,
            'basic_salary' => $basicSalary,
            'bonus' => 0,
            'deduction' => 0,
            'total_salary' => $basicSalary,
            'employment_status' => $request->employment_status,
            'salary_status' => 'unpaid',
            'salary_payment_date' => null,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        $employee->load('salaryPayments');

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'basic_salary' => 'required|numeric|min:0',
            'employment_status' => 'required|in:active,inactive,resigned',
        ]);

        $basicSalary = $request->basic_salary;

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'salary' => $basicSalary,
            'basic_salary' => $basicSalary,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->salaryPayments()->exists()) {
            return back()->withErrors([
                'delete' => 'Data karyawan tidak dapat dihapus karena sudah memiliki riwayat penggajian.',
            ]);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}