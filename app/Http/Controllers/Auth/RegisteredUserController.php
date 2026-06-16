<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $memberCode = $this->generateMemberCode();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'member',
            'is_active' => true,
            'password' => Hash::make($request->password),
        ]);

        Customer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_member' => true,
            'member_code' => $memberCode,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', 'Pendaftaran member berhasil. Kode membership Anda: ' . $memberCode);
    }

    private function generateMemberCode(): string
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