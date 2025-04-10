<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\ProgramStudi;
use App\Models\Karyawan;
use App\Models\Mahasiswa;

class KaprodiController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil ID user yang sedang login
        $id_user = Auth::id();


        // Cari data Kaprodi di tabel Karyawan berdasarkan ID User
        $kaprodi = Karyawan::where('id_users', $id_user)->first();

        // Ambil ID program studi Kaprodi dari tabel Karyawan 
        $program_studi = $kaprodi->id_program_studi;

        // Ambil semua ID user mahasiswa yang ada dalam program studi tersebut
        $user_ids = Mahasiswa::where('id_program_studi', $program_studi)->pluck('id_users');

        // Ambil data surat berdasarkan jenis surat & program studi Kaprodi
        $suratKeaktifan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'keaktifan')->with('suratDetail')->get();
    
        $suratLaporanHasilStudi = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lhs')->with('suratDetail')->get();
        $suratPengantarTugas = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'ptmk')->with('suratDetail')->get();
        $suratKelulusan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lulus')->with('suratDetail')->get();

        // Kirim data ke tampilan kaprodi.index
        return view('kaprodi.index', compact('suratKeaktifan', 'suratLaporanHasilStudi', 'suratPengantarTugas', 'suratKelulusan'));
    }

    public function acc($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->suratDetail()->update(['status_persetujuan' => 'Sedang Diproses Tata Usaha']);

        return redirect()->back()->with('success', 'Surat berhasil disetujui kaprodi.');
    }


    public function tolakSurat(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        
        // Update status surat menjadi Ditolak
        $surat->suratDetail->update(['status_persetujuan' => 'Surat Ditolak']);
        $surat->suratDetail->update(['keterangan' => $request->keterangan]);
        $surat->suratDetail->update(['tgl_persetujuan' => now()]);

        return redirect()->back()->with('success', 'Surat berhasil ditolak.');
    }
    
    
}   
