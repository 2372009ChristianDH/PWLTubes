<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login_mahasiswa')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika tidak ada batasan peran (misalnya hanya 'auth' middleware), langsung lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Ubah role ke string jika perlu (untuk menangani tipe data yang berbeda)
        $userRole = strval($user->id_roles);

        // Jika role yang diminta adalah mahasiswa atau karyawan, sesuaikan halaman login
        if (!in_array($userRole, $roles)) {
            if ($userRole == '4') {
                return redirect()->route('login_mahasiswa')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengakses halaman ini.']);
            } else {
                return redirect()->route('login_karyawan')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengakses halaman ini.']);
            }
        }

        return $next($request);
    }
}
