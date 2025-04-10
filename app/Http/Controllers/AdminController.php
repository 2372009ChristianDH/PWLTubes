<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }


    public function DataMahasiswa()
    {
        $dataMahasiswa = Mahasiswa::with(['user', 'programStudi'])
            ->whereHas('user', function ($query) {
                $query->where('id_roles', 4);
            })
            ->where('id_program_studi', 1)
            ->get();

        return view('admin/mahasiswaTI/index', compact('dataMahasiswa'));
    }


    public function create()
    {
        $programStudi = ProgramStudi::all();
        return view('admin/mahasiswaTI/create', compact('programStudi'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8',
            'nrp' => 'required|unique:mahasiswa,nrp',
        ]);

        // Mulai proses penyimpanan ke database
        try {
            // Simpan data ke tabel `users`
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_roles' => 4,
            ]);

            // Simpan data ke tabel `mahasiswa`
            Mahasiswa::create([
                'nrp' => $request->nrp,
                'id_users' => $user->id,
                'id_program_studi' => 1,
            ]);

            return redirect()->route('data.mahasiswaTI')->with('success', 'Data mahasiswa berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
