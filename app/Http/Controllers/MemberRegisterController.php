<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register-member');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $memberCode = $this->generateMemberCode();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'member',
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        Customer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_member' => true,
            'member_code' => $memberCode,
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', 'Pendaftaran member berhasil. Kode membership Anda: ' . $memberCode);
    }

    private function generateMemberCode()
    {
        $lastCustomer = Customer::whereNotNull('member_code')
            ->latest('id')
            ->first();

        if (! $lastCustomer) {
            return 'MBR001';
        }

        $lastNumber = (int) str_replace('MBR', '', $lastCustomer->member_code);
        $newNumber = $lastNumber + 1;

        return 'MBR' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}