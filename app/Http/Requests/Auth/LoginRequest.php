<?php

namespace App\Http\Requests\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = strtolower(trim($this->input('email')));
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        /*
        |--------------------------------------------------------------------------
        | 1. Coba cari akun langsung dari tabel users
        |--------------------------------------------------------------------------
        */

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        /*
        |--------------------------------------------------------------------------
        | 2. Kalau tidak ada di users, cari email di tabel employees
        |--------------------------------------------------------------------------
        | Jika ketemu employee, sistem akan mengambil akun users melalui employee.user_id.
        */

        if (! $user) {
            $employee = Employee::with('user')
                ->whereRaw('LOWER(email) = ?', [$email])
                ->first();

            if ($employee) {
                if (! $employee->user) {
                    RateLimiter::hit($this->throttleKey());

                    throw ValidationException::withMessages([
                        'email' => 'Email ditemukan di data karyawan, tetapi karyawan ini belum dibuatkan akun staff.',
                    ]);
                }

                $user = $employee->user;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Kalau tetap tidak ada user, login gagal
        |--------------------------------------------------------------------------
        */

        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan di tabel users maupun employees.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Cek password dari users.password
        |--------------------------------------------------------------------------
        */

        if (! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Password tidak sesuai.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Cek status akun
        |--------------------------------------------------------------------------
        */

        if (! $user->is_active) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi admin atau SDM.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Login manual user yang ditemukan
        |--------------------------------------------------------------------------
        */

        Auth::login($user, $remember);

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}