<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffAccountController extends Controller
{
    public function index()
    {
        $staffAccounts = User::whereIn('role', [
            'resepsionis',
            'kasir',
            'keuangan',
            'dapur',
            'sdm',
        ])
            ->latest()
            ->get();

        $totalStaffAccounts = $staffAccounts->count();
        $activeStaffAccounts = $staffAccounts->where('is_active', true)->count();

        return view('staff_accounts.index', compact(
            'staffAccounts',
            'totalStaffAccounts',
            'activeStaffAccounts'
        ));
    }

    public function create()
    {
        return view('staff_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('staff-accounts.index')
            ->with('success', 'Akun staff berhasil dibuat.');
    }

    public function show(User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        return view('staff_accounts.show', compact('staffAccount'));
    }

    public function edit(User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        return view('staff_accounts.edit', compact('staffAccount'));
    }

    public function update(Request $request, User $staffAccount)
    {
        $this->ensureStaffAccount($staffAccount);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($staffAccount->id),
            ],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:resepsionis,kasir,keuangan,dapur,sdm',
            'is_active' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->is_active,
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

        $staffAccount->delete();

        return redirect()->route('staff-accounts.index')
            ->with('success', 'Akun staff berhasil dihapus.');
    }

    private function ensureStaffAccount(User $user)
    {
        if (! in_array($user->role, ['resepsionis', 'kasir', 'keuangan', 'dapur', 'sdm'])) {
            abort(403, 'Akun ini bukan akun staff internal.');
        }
    }
}