<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses login user dan mengarahkan sesuai role.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Autentikasi Login
        |--------------------------------------------------------------------------
        | Logic autentikasi detail ada di LoginRequest.php.
        | Di sana sistem mengecek email dan password.
        */

        $request->authenticate();

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        | Ini penting untuk keamanan setelah login berhasil.
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect Berdasarkan Role
        |--------------------------------------------------------------------------
        | Setelah berhasil login, user diarahkan ke dashboard sesuai role.
        */

        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'member' => redirect()->route('member.dashboard'),
            'resepsionis' => redirect()->route('resepsionis.dashboard'),
            'kasir' => redirect()->route('kasir.dashboard'),
            'keuangan' => redirect()->route('keuangan.dashboard'),
            'dapur' => redirect()->route('dapur.dashboard'),
            'sdm' => redirect()->route('sdm.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}