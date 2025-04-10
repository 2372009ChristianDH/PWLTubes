<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\Karyawan;
use App\Models\Mahasiswa;


class TuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::id();

        $tu = Karyawan::where('id_users', $id_user)->first();
        $program_studi = $tu->id_program_studi;

        $user_ids = Mahasiswa::where('id_program_studi', $program_studi)->pluck('id_users');

        // Ambil semua surat mahasiswa prodi ini
        $allSurat = Surat::whereIn('id_users', $user_ids)->with('suratDetail', 'user')->get();

        // Hitung total dan status surat
        $totalSurat = $allSurat->count();
        $pendingSurat = $allSurat->where('suratDetail.status_persetujuan', 'Sedang Diproses Tata Usaha')->count();
        $approvedSurat = $allSurat->where('suratDetail.status_persetujuan', 'Disetujui')->count();
        $rejectedSurat = $allSurat->where('suratDetail.status_persetujuan', 'Surat Ditolak')->count();

        // 5 surat terbaru yang masih dalam proses TU
        $suratTerbaru = $allSurat
            ->where('suratDetail.status_persetujuan', 'Sedang Diproses Tata Usaha')
            ->sortBy('created_at')
            ->take(5);

        return view('tu.index', compact(
            'totalSurat',
            'pendingSurat',
            'approvedSurat',
            'rejectedSurat',
            'suratTerbaru'
        ));
    }


    public function kelolaSurat()
    {
        $id_user = Auth::id();

        $tu = Karyawan::where('id_users', $id_user)->first();

        $program_studi = $tu->id_program_studi;

        $user_ids = Mahasiswa::where('id_program_studi', $program_studi)->pluck('id_users');

        $suratKeaktifan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'keaktifan')->with('suratDetail')->get();
        $suratLaporanHasilStudi = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lhs')->with('suratDetail')->get();
        $suratPengantarTugas = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'ptmk')->with('suratDetail')->get();
        $suratKelulusan = Surat::whereIn('id_users', $user_ids)->where('jenis_surat', 'lulus')->with('suratDetail')->get();

        return view('tu.kelolaSurat.index', compact('suratKeaktifan', 'suratLaporanHasilStudi', 'suratPengantarTugas', 'suratKelulusan'));
    }


    // Menampilkan form kirim
    public function create($id)
    {
        $surat = Surat::with('user', 'suratDetail')->findOrFail($id);
        return view('tu/create', compact('surat'));
    }


    public function store(Request $request, $id)
    {
        $request->validate([
            'file_pdf' => ['required', 'mimes:pdf', 'max:2048'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);
    
        $surat = Surat::with('suratDetail')->findOrFail($id);
    
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
    
            // Nama file baru
            $newFileName = 'surat_' . $surat->id . '_' . time() . '.' . $file->getClientOriginalExtension();
    
            // Simpan file ke storage/app/public/surat_pdf
            $file->storePubliclyAs('surat_pdf', $newFileName, 'public');
    
            // Update database (simpan nama file, bukan file isi)
            $surat->suratDetail->update([
                'status_persetujuan' => 'Disetujui',
                'file_surat' => $newFileName,
                'keterangan' => $request->keterangan,
                'tgl_disetujui' => now(),
            ]);
        }

        if (!$request->hasFile('file_pdf')) {
            return back()->withErrors(['File belum diupload atau gagal diunggah.']);
        }
    
        return redirect()->route('tu.kelolaSurat')
            ->with('success', 'File PDF berhasil dikirim ke mahasiswa!');
    }
     
}
