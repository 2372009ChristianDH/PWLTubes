<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Surat;
use App\Models\User;
use App\Models\SuratDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan user ID dari user yang sedang login
        $userId = Auth::user()->id;
    
        // Memisahkan surat berdasarkan jenis dan user ID yang login
        $suratKeaktifan = Surat::where('jenis_surat', 'keaktifan')->where('id_users', $userId)->get();
        $suratLaporanHasilStudi = Surat::where('jenis_surat', 'lhs')->where('id_users', $userId)->get();
        $suratPengantarTugas = Surat::where('jenis_surat', 'ptmk')->where('id_users', $userId)->get();
        $suratKelulusan = Surat::where('jenis_surat', 'lulus')->where('id_users', $userId)->get();
    
        // Mengirimkan data terpisah ke view
        return view('mahasiswa.index', compact('suratKeaktifan', 'suratLaporanHasilStudi', 'suratPengantarTugas', 'suratKelulusan'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $surat_detail->status_persetujuan = 'pending';
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database


        return redirect(route('mahasiswaList'))->with('success', 'Surat keaktifan berhasil disimpan.');
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
        $surat_detail->status_persetujuan = 'pending';
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Laporan Hasil Studi berhasil disimpan.');
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
        $surat_detail->status_persetujuan = 'pending';
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Pengantar Tugas Mata Kuliah berhasil disimpan.');
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
        $surat_detail->status_persetujuan = 'pending';
        $surat_detail->keterangan = null;
        $surat_detail->tgl_persetujuan = null;
        $surat_detail->save(); // Simpan ke database

        return redirect(route('mahasiswaList'))->with('success', 'Surat Kelulusan berhasil disimpan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
