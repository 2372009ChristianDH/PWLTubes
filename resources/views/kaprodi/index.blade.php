@extends('layouts.index')

@section('content')
    <div class="container py-5">
        {{-- Statistik singkat --}}
        <div class="row text-center mb-5" style="margin-top: 50px">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total Surat</h5>
                        <h2 class="text-primary">{{ $totalSurat }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Menunggu Persetujuan</h5>
                        <h2 class="text-warning">{{ $pendingSurat }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Surat Diselesaikan</h5>
                        <h2 class="text-success">{{ $approvedSurat }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Ditolak</h5>
                        <h2 class="text-danger">{{ $rejectedSurat }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel surat terbaru --}}
        <div class="card shadow-sm border-0 mb-4 container-fluid px-5 py-4">
            <div class="card-header bg-primary text-white fw-bold">
                Daftar Surat Menunggu Persetujuan Kaprodi
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Permohonan</th>
                            <th>Status</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($suratTerbaru as $surat)
                            @if ($surat->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $surat->user->nama }}</td>
                                    <td>{{ ucfirst($surat->jenis_surat) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->suratDetail->tgl_permohonan)->format('d M Y') }}</td>
                                    <td>
                                        @if ($surat->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                            <span class="text-warning">📋
                                                {{ $surat->suratDetail->status_persetujuan }}</span>
                                        @elseif ($surat->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                            <span class="text-primary">🛠️
                                                {{ $surat->suratDetail->status_persetujuan }}</span>
                                        @elseif ($surat->suratDetail->status_persetujuan == 'Disetujui')
                                            <span class="text-success">✅
                                                {{ $surat->suratDetail->status_persetujuan }}</span>
                                        @elseif ($surat->suratDetail->status_persetujuan == 'Surat Ditolak')
                                            <span class="text-danger">❌
                                                {{ $surat->suratDetail->status_persetujuan }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        

                        @if ($pendingSurat == 0)
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada Surat Menunggu Persetujuan Kaprodi.</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
                <div class="text-end">
                    <a href="{{ route('kaprodi.index') }}" class="btn btn-outline-primary">Lihat Semua Surat</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ExtraCSS')
@endsection

@section('ExtraJS')
@endsection
