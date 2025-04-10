<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index_karyawan()
    {
        return view('login_karyawan');
    }

    public function index_mahasiswa()
    {
        return view('login_mahasiswa');
    }

    public function login_karyawan(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        $karyawan = Karyawan::where('nik', $request->nik)->first();

        if ($karyawan) {
            $user = User::find($karyawan->id_users);

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);

                $role = $user->id_roles;
                switch ($role) {
                    case '1':
                        return redirect()->route('admin.index');
                    case '2':
                        return redirect()->route('kaprodi.index');
                    case '3':
                        return redirect()->route('tu.index');
                    default:
                        Auth::logout();
                        return redirect()->route('login_karyawan')->withErrors(['role' => 'Role tidak valid.']);
                }
            } else {
                return back()->withErrors(['password' => 'Password is incorrect.']);
            }
        } else {
            // Return error if NIK is not found
            return back()->withErrors(['nik' => 'NIK not found.']);
        }
    }




    public function login_mahasiswa(Request $request)
    {
        // Validate input
        $request->validate([
            'nrp' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find the karyawan by NIK
        $mahasiswa = Mahasiswa::where('nrp', $request->nrp)->first();

        if ($mahasiswa) {
            // Get the corresponding user by id_users (foreign key in mah$mahasiswa table)
            $user = User::find($mahasiswa->id_users);

            // Check if the user exists and the password matches
            if ($user && Hash::check($request->password, $user->password)) {
                // Log the user in
                Auth::login($user);

                // Redirect to intended page or the employee dashboard
                return redirect()->intended('/mahasiswa/index');
            } else {
                // Return error if the password doesn't match
                return back()->withErrors(['password' => 'Password is incorrect.']);
            }
        } else {
            // Return error if NIK is not found
            return back()->withErrors(['nrp' => 'NIK not found.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        // Invalidate session untuk memastikan semua session dihapus
        $request->session()->invalidate();

        // Regenerate token untuk mencegah CSRF
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect()->route('/')->with('status', 'Anda telah berhasil logout.');
    }
}
