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
            return redirect('/');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika tidak ada batasan peran (misalnya hanya 'auth' middleware), langsung lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Ubah role ke string jika perlu (untuk menangani tipe data yang berbeda)
        $userRole = strval($user->id_roles);

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }
        

        return $next($request);
    }
}
