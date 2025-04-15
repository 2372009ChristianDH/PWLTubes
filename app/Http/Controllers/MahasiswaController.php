<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Surat;
use App\Models\User;
use App\Models\SuratDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $tanggalAwal = $request->input('tanggal_awal');
        
    
        // Ambil semua surat user yang termasuk 4 jenis itu
        $allSurat = Surat::with('suratDetail')
            ->whereIn('jenis_surat', ['keaktifan', 'lhs', 'ptmk', 'lulus'])
            ->where('id_users', $userId)
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereHas('suratDetail', function ($subQuery) use ($tanggalAwal) {
                    $subQuery->whereDate('tgl_permohonan', '=', $tanggalAwal);
                });
            })
            ->get();
    
        // Pisahkan datanya berdasarkan jenis_surat
        $suratKeaktifan = $allSurat->where('jenis_surat', 'keaktifan');
        $suratLaporanHasilStudi = $allSurat->where('jenis_surat', 'lhs');
        $suratPengantarTugas = $allSurat->where('jenis_surat', 'ptmk');
        $suratKelulusan = $allSurat->where('jenis_surat', 'lulus');
    
        return view('mahasiswa.index', compact(
            'suratKeaktifan',
            'suratLaporanHasilStudi',
            'suratPengantarTugas',
            'suratKelulusan',
        ));
    }


    public function histori(Request $request)
    {
        $userId = Auth::user()->id;
        $tanggalAwal = $request->input('tanggal_awal');
    
        // Ambil semua surat user yang termasuk 4 jenis itu
        $allSurat = Surat::with('suratDetail')
            ->whereIn('jenis_surat', ['keaktifan', 'lhs', 'ptmk', 'lulus'])
            ->where('id_users', $userId)
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereHas('suratDetail', function ($subQuery) use ($tanggalAwal) {
                    $subQuery->whereDate('tgl_permohonan', '=', $tanggalAwal);
                });
            })
            ->get();
    
        // Pisahkan datanya berdasarkan jenis_surat
        $suratKeaktifan = $allSurat->where('jenis_surat', 'keaktifan');
        $suratLaporanHasilStudi = $allSurat->where('jenis_surat', 'lhs');
        $suratPengantarTugas = $allSurat->where('jenis_surat', 'ptmk');
        $suratKelulusan = $allSurat->where('jenis_surat', 'lulus');
    
        return view('mahasiswa.histori.index', compact(
            'suratKeaktifan',
            'suratLaporanHasilStudi',
            'suratPengantarTugas',
            'suratKelulusan'
        ));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    // Store Surat_Keaktifan

    public function store_keaktifan(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_surat' => 'required|string|max:100',
            'periode' => 'required|string|max:20',
            'alamat' => 'required|string|max:150',
            'keperluan_pembuatan' => 'required|string|max:700',
        ]);

        $user = Auth::user();

        // Simpan data ke tabel surat
        $surat = new Surat();
        $surat->id_users = $user->id;
        $surat->jenis_surat = $validatedData['jenis_surat'];
        $surat->nama = $user->mahasiswa->nama ?? $user->nama;
        $surat->periode = $validatedData['periode'];
        $surat->alamat = $validatedData['alamat'];
        $surat->keperluan_pembuatan = $validatedData['keperluan_pembuatan'];
        $surat->save(); // Simpan ke database


        $surat_detail = new SuratDetail();
        $surat_detail->id_surat = $surat->id;
        $surat_detail->jenis_surat = $validatedData['jenis_surat'];
        $surat_detail->tgl_permohonan = now();
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database


        return redirect(route('mahasiswaList'))->with('success', 'Surat keaktifan berhasil diajukan.');
    }


    // Mengupdate data surat yang telah diedit
    public function update_keaktifan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'periode' => 'required|string|max:20',
            'alamat' => 'required|string|max:150',
            'keperluan_pembuatan' => 'required|string|max:700',
        ]);
    
        // Cari surat berdasarkan ID
        $surat = Surat::findOrFail($id);
    
        // Update data surat
        $surat->periode = $request->periode;
        $surat->alamat = $request->alamat;
        $surat->keperluan_pembuatan = $request->keperluan_pembuatan;
        // Update field lainnya sesuai kebutuhan
    
        // Simpan perubahan
        $surat->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('mahasiswaList')->with('success', 'Surat berhasil diperbarui.');
    }    


    // Store Surat_Lhs
    public function store_lhs(Request $request)
    {
        $jenisSurat = $request->input('jenis_surat', 'kosong');

        $validatedData = $request->validate([
            'jenis_surat' => 'required|string|max:100',
            'keperluan_pembuatan' => 'required|string',
        ]);

        $user = Auth::user();

        $surat = new Surat();
        $surat->id_users = $user->id;
        $surat->jenis_surat = $jenisSurat;
        $surat->nama = $user->mahasiswa->nama ?? $user->nama;
        $surat->keperluan_pembuatan = $validatedData['keperluan_pembuatan'];

        $surat->save();

        $surat_detail = new SuratDetail();
        $surat_detail->id_surat = $surat->id;
        $surat_detail->jenis_surat = $validatedData['jenis_surat'];
        $surat_detail->tgl_permohonan = now();
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Laporan Hasil Studi berhasil diajukan.');
    }

    public function update_lhs(Request $request, $id)
    {
        $request->validate([
            'keperluan_pembuatan' => 'required|string|max:700',
        ]);

        $surat = Surat::findOrFail($id);
        $surat->keperluan_pembuatan = $request->keperluan_pembuatan;
        $surat->save();
    
        return redirect()->route('mahasiswaList')->with('success', 'Surat berhasil diperbarui.');
    } 


    // Store Surat_Ptmk
    public function store_ptmk(Request $request)
    {
        $jenisSurat = $request->input('jenis_surat', 'kosong');

        $validatedData = $request->validate([
            'jenis_surat' => 'required|string|max:100',
            'tujuan_surat' => 'required|string|max:100',
            'nama_mk' => 'required|string|max:100',
            'periode' => 'required|string|max:20',
            'topik' => 'required|string|max:255',
            'tujuan_topik' => 'required|string',
        ]);

        $user = Auth::user();

        $surat = new Surat();
        $surat->id_users = $user->id;
        $surat->jenis_surat = $jenisSurat;
        $surat->tujuan_surat = $validatedData['tujuan_surat'];
        $surat->nama_mk = $validatedData['nama_mk'];
        $surat->periode = $validatedData['periode'];
        $surat->nama = $user->mahasiswa->nama ?? $user->nama;
        $surat->topik = $validatedData['topik'];
        $surat->tujuan_topik = $validatedData['tujuan_topik'];

        $surat->save();

        $surat_detail = new SuratDetail();
        $surat_detail->id_surat = $surat->id;
        $surat_detail->jenis_surat = $validatedData['jenis_surat'];
        $surat_detail->tgl_permohonan = now();
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Pengantar Tugas Mata Kuliah berhasil disimpan.');
    }

    public function update_ptmk(Request $request, $id)
    {
        $request->validate([
            'tujuan_surat' => 'required|string|max:100',
            'nama_mk' => 'required|string|max:100',
            'periode' => 'required|string|max:20',
            'topik' => 'required|string|max:255',
            'tujuan_topik' => 'required|string',
        ]);

        $surat = Surat::findOrFail($id);
        $surat->tujuan_surat = $request->tujuan_surat;
        $surat->nama_mk = $request->nama_mk;
        $surat->periode = $request->periode;
        $surat->topik = $request->topik;
        $surat->tujuan_topik = $request->tujuan_topik;
        $surat->save();
    
        return redirect()->route('mahasiswaList')->with('success', 'Surat berhasil diperbarui.');
    } 


    // Store Surat_Lulus
    public function store_lulus(Request $request)
    {
        $jenisSurat = $request->input('jenis_surat', 'kosong');

        $validatedData = $request->validate([
            'jenis_surat' => 'required|string|max:100',
            'tgl_kelulusan' => 'required|date',
        ]);

        $user = Auth::user();

        $surat = new Surat();
        $surat->id_users = $user->id;
        $surat->jenis_surat = $jenisSurat;
        $surat->nama = $user->mahasiswa->nama ?? $user->nama;
        $surat->tgl_kelulusan = $validatedData['tgl_kelulusan'];

        $surat->save();

        $surat_detail = new SuratDetail();
        $surat_detail->id_surat = $surat->id;
        $surat_detail->jenis_surat = $validatedData['jenis_surat'];
        $surat_detail->tgl_permohonan = now();
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Kelulusan berhasil diajukan.');
    }

    public function update_lulus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tgl_kelulusan' => 'required|date',
        ]);
    
        // Cari surat berdasarkan ID
        $surat = Surat::findOrFail($id);
    
        // Update data surat
        $surat->tgl_kelulusan = $request->tgl_kelulusan;
        // Update field lainnya sesuai kebutuhan
    
        // Simpan perubahan
        $surat->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('mahasiswaList')->with('success', 'Surat berhasil diperbarui.');
    }    
}
