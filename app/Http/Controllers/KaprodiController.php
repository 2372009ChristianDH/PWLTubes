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
        $id_user = Auth::id();
        $kaprodi = Karyawan::where('id_users', $id_user)->first();
        $program_studi = $kaprodi->id_program_studi;

        $user_ids = Mahasiswa::where('id_program_studi', $program_studi)->pluck('id_users');

        // Semua surat mahasiswa di prodi ini
        $allSurat = Surat::whereIn('id_users', $user_ids)->with('suratDetail', 'user')->get();

        $totalSurat = $allSurat->count();
        $pendingSurat = $allSurat->where('suratDetail.status_persetujuan', 'Disetujui')->count();
        $approvedSurat = $allSurat->where('suratDetail.status_persetujuan', 'Sedang Diproses Tata Usaha')->count();
        $rejectedSurat = $allSurat->where('suratDetail.status_persetujuan', 'Surat Ditolak')->count();

        // 5 surat terbaru
        $suratTerbaru = $allSurat
        ->where('suratDetail.status_persetujuan', 'Menunggu Persetujuan Kaprodi')
        ->sortBy('created_at')
        ->take(5);

        return view('kaprodi.index', compact(
            'totalSurat',
            'pendingSurat',
            'approvedSurat',
            'rejectedSurat',
            'suratTerbaru',
        ));
    }

    public function kelolaSurat() {
        $id_user = Auth::id();

        $tu = Karyawan::where('id_users', $id_user)->first();

        $program_studi = $tu->id_program_studi;

        $user_ids = Mahasiswa::where('id_program_studi', $program_studi)->pluck('id_users');

        $suratKeaktifan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'keaktifan')->with('suratDetail')->get();
        $suratLaporanHasilStudi = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lhs')->with('suratDetail')->get();
        $suratPengantarTugas = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'ptmk')->with('suratDetail')->get();
        $suratKelulusan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lulus')->with('suratDetail')->get();

        return view('kaprodi.kelolaSurat.index', compact('suratKeaktifan', 'suratLaporanHasilStudi', 'suratPengantarTugas', 'suratKelulusan'));
    }

    public function kaprodi_acc($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->suratDetail()->update(['status_persetujuan' => 'Sedang Diproses Tata Usaha']);
        $surat->suratDetail->update(['tgl_persetujuan' => now()]);
        return redirect()->back()->with('success', 'Surat Berhasil Disetujui Kaprodi.');
    }


    public function kaprodi_tolakSurat(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        // Update status surat menjadi Ditolak
        $surat->suratDetail->update(['status_persetujuan' => 'Surat Ditolak']);
        $surat->suratDetail->update(['keterangan' => $request->keterangan]);
        $surat->suratDetail->update(['tgl_persetujuan' => now()]);

        return redirect()->back()->with('success', 'Surat Berhasil Ditolak.');
    }
    
}
