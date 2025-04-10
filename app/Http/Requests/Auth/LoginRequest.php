<?php

namespace App\Http\Requests\Auth;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Redirect; // Import Redirect facade

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nrp' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
    
        // Cari NRP di tabel mahasiswa
        $mahasiswa = DB::table('mahasiswa')->where('nrp', $this->nrp)->first();
    
        // Jika NRP ditemukan, cari user berdasarkan id_users
        if ($mahasiswa) {
            // Cari user berdasarkan id_users yang ada di mahasiswa
            $user = DB::table('user')->where('id', $mahasiswa->id_users)->first();
    
            // Verifikasi password
            if ($user && Hash::check($this->password, $user->password)) {
                Auth::loginUsingId($user->id); // Login berhasil, gunakan user ID
                RateLimiter::clear($this->throttleKey());
                
                // Redirect ke halaman index mahasiswa
                Redirect::to('/mahasiswa/index')->send();
                return;
            }
        }
    
        // Jika gagal login
        RateLimiter::hit($this->throttleKey());
    
        throw ValidationException::withMessages([
            'nrp' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('nrp')).'|'.$this->ip());
    }
}
