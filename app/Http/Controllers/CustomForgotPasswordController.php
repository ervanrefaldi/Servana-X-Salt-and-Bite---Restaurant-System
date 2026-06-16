<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomForgotPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem.',
        ]);

        PasswordResetCode::where('email', $request->email)
            ->whereNull('used_at')
            ->update([
                'used_at' => now(),
            ]);

        $code = random_int(100000, 999999);

        PasswordResetCode::create([
            'email' => $request->email,
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
            'used_at' => null,
        ]);

        Mail::raw(
            "Kode reset password Servana Anda adalah: {$code}\n\nKode ini berlaku selama 10 menit.\n\nJika Anda tidak meminta reset password, abaikan email ini.",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Kode Reset Password Servana');
            }
        );

        session([
            'reset_email' => $request->email,
        ]);

        return redirect()->route('password.code.form')
            ->with('success', 'Kode reset password sudah dikirim ke email Anda.');
    }

    public function showCodeForm()
    {
        if (! session('reset_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan masukkan email terlebih dahulu.']);
        }

        return view('auth.verify-reset-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi reset password telah habis. Silakan ulangi lagi.']);
        }

        $resetCode = PasswordResetCode::where('email', $email)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (! $resetCode) {
            return back()->withErrors([
                'code' => 'Kode reset tidak ditemukan. Silakan kirim ulang kode.',
            ]);
        }

        if (now()->greaterThan($resetCode->expires_at)) {
            return back()->withErrors([
                'code' => 'Kode reset sudah kedaluwarsa. Silakan kirim ulang kode.',
            ]);
        }

        if (! Hash::check($request->code, $resetCode->code)) {
            return back()->withErrors([
                'code' => 'Kode reset yang Anda masukkan salah.',
            ]);
        }

        session([
            'reset_code_verified' => true,
        ]);

        return redirect()->route('password.reset.form')
            ->with('success', 'Kode berhasil diverifikasi. Silakan buat password baru.');
    }

    public function showResetForm()
    {
        if (! session('reset_email') || ! session('reset_code_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan verifikasi kode terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = session('reset_email');

        if (! $email || ! session('reset_code_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi reset password telah habis. Silakan ulangi lagi.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        PasswordResetCode::where('email', $email)
            ->whereNull('used_at')
            ->update([
                'used_at' => now(),
            ]);

        session()->forget([
            'reset_email',
            'reset_code_verified',
        ]);

        return redirect()->route('login')
            ->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}