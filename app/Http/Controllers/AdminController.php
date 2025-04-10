<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Karyawan;

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

// controller Mahasiswa TI
    public function DataMahasiswaTI()
    {
        $dataMahasiswa = Mahasiswa::with(['user', 'programStudi'])
            ->whereHas('user', function ($query) {
                $query->where('id_roles', 4);
            })
            ->where('id_program_studi', 1)
            ->get();

        return view('admin/mahasiswaTI/index', compact('dataMahasiswa'));
    }


    public function createMahasiswaTI()
    {
        $programStudi = ProgramStudi::all();
        return view('admin/mahasiswaTI/create', compact('programStudi'));
    }


    public function storeMahasiswaTI(Request $request)
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

    /**
     * Menampilkan form edit mahasiswa TI
     */
    public function editMahasiswaTI($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
        
        // Ambil data mahasiswa berdasarkan id_users
        $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
    
        return view('admin.mahasiswaTI.edit', compact('user', 'mahasiswa'));
    }
    

    /**
     * Menyimpan perubahan data mahasiswa TI
     */
    public function updateMahasiswaTI(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id', // Perbaikan validasi email
            'nrp' => 'required|unique:mahasiswa,nrp,' . $id . ',id',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->id_users); // Pastikan ini sesuai dengan nama kolom yang benar

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $mahasiswa->update([
            'nrp' => $request->nrp,
        ]);

        return redirect()->route('data.mahasiswaTI')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    /**
     * Menghapus data mahasiswa TI
     */
    public function deleteMahasiswaTI($id)
    {
        try {
            // Cari mahasiswa berdasarkan id_users
            $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
            $user = User::findOrFail($id);
    
            // Hapus data
            $mahasiswa->delete();
            $user->delete();
    
            return redirect()->route('data.mahasiswaTI')->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
    



    
    // Mahasiswa SI
    public function DataMahasiswaSI()
    {
        $dataMahasiswa = Mahasiswa::with(['user', 'programStudi'])
            ->whereHas('user', function ($query) {
                $query->where('id_roles', 4);
            })
            ->where('id_program_studi', 2)
            ->get();

        return view('admin/mahasiswaSI/index', compact('dataMahasiswa'));
    }


    public function createMahasiswaSI()
    {
        $programStudi = ProgramStudi::all();
        return view('admin/mahasiswaSI/create', compact('programStudi'));
    }


    public function storeMahasiswaSI(Request $request)
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
                'id_program_studi' => 2,
            ]);

            return redirect()->route('data.mahasiswaSI')->with('success', 'Data mahasiswa berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }


    /**
     * Menampilkan form edit mahasiswa SI
     */
    public function editMahasiswaSI($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
        
        // Ambil data mahasiswa berdasarkan id_users
        $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
    
        return view('admin.mahasiswaSI.edit', compact('user', 'mahasiswa'));
    }
    

    /**
     * Menyimpan perubahan data mahasiswa SI
     */
    public function updateMahasiswaSI(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id', // Perbaikan validasi email
            'nrp' => 'required|unique:mahasiswa,nrp,' . $id . ',id',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->id_users); // Pastikan ini sesuai dengan nama kolom yang benar

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $mahasiswa->update([
            'nrp' => $request->nrp,
        ]);

        return redirect()->route('data.mahasiswaSI')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    /**
     * Menghapus data mahasiswa SI
     */
    public function deleteMahasiswaSI($id)
    {
        try {
            // Cari mahasiswa berdasarkan id_users
            $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
            $user = User::findOrFail($id);
    
            // Hapus data
            $mahasiswa->delete();
            $user->delete();
    
            return redirect()->route('data.mahasiswaSI')->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }








    // Mahasiswa IK
    public function DataMahasiswaIK()
    {
        $dataMahasiswa = Mahasiswa::with(['user', 'programStudi'])
            ->whereHas('user', function ($query) {
                $query->where('id_roles', 4);
            })
            ->where('id_program_studi', 3)
            ->get();

        return view('admin/mahasiswaIK/index', compact('dataMahasiswa'));
    }


    public function createMahasiswaIK()
    {
        $programStudi = ProgramStudi::all();
        return view('admin/mahasiswaIK/create', compact('programStudi'));
    }


    public function storeMahasiswaIK(Request $request)
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
                'id_program_studi' => 3,
            ]);

            return redirect()->route('data.mahasiswaIK')->with('success', 'Data mahasiswa berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan form edit mahasiswa IK
     */
    public function editMahasiswaIK($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
        
        // Ambil data mahasiswa berdasarkan id_users
        $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
    
        return view('admin.mahasiswaIK.edit', compact('user', 'mahasiswa'));
    }
    

    /**
     * Menyimpan perubahan data mahasiswa IK
     */
    public function updateMahasiswaIK(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id', // Perbaikan validasi email
            'nrp' => 'required|unique:mahasiswa,nrp,' . $id . ',id',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->id_users); // Pastikan ini sesuai dengan nama kolom yang benar

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $mahasiswa->update([
            'nrp' => $request->nrp,
        ]);

        return redirect()->route('data.mahasiswaIK')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    /**
     * Menghapus data mahasiswa IK
     */
    public function deleteMahasiswaIK($id)
    {
        try {
            // Cari mahasiswa berdasarkan id_users
            $mahasiswa = Mahasiswa::where('id_users', $id)->firstOrFail();
            $user = User::findOrFail($id);
    
            // Hapus data
            $mahasiswa->delete();
            $user->delete();
    
            return redirect()->route('data.mahasiswaIK')->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }



    // Kaprodi TI
    public function DataKaprodiTI()
    {
        $dataKaprodiTI = Karyawan::with(['user', 'programStudi'])  
            ->whereHas('user', function ($query) {
                $query->where('id_roles', 2);
            })
            ->where('id_program_studi', 1)
            ->get();

        return view('admin/kaprodiTI/index', compact('dataKaprodiTI'));
    }


    public function createKaprodiTI()
    {
        $programStudi = ProgramStudi::all();
        return view('admin/kaprodiTI/create', compact('programStudi'));
    }


    public function storeKaprodiTI(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8',
            'tahun_mulai' => 'required|date',

        ]);

        // Mulai proses penyimpanan ke database
        try {
            // Simpan data ke tabel `users`
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_roles' => 2,
            ]);

            Karyawan::create([
                'nik' => $request->nik,
                'id_program_studi' => 1,
                'id_users' => $user->id,
                'tahun_mulai' => $request->tahun_mulai,
            ]);

            return redirect()->route('data.kaprodiTI')->with('success', 'Data mahasiswa berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

}


