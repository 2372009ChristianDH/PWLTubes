@extends('layouts.index')

@section('content')
    <div class="container py-5">
    <h3 class="fw-bold mb-4" style="text-align: center; font-size: 40px; padding-top:50px; color:rgb(0, 0, 112);">Data Tata Usaha Sistem Informasi</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('tu.createtuSI') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Tambah TU
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="table-tu" class="table table-hover table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tahun Mulai</th>
                                <th>Tahun Selesai</th>
                                <th style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datatuSI as $data)
                                <tr style="text-align: center">
                                    <td>{{ $data->nik }}</td>
                                    <td>{{ $data->user->nama }}</td>
                                    <td>{{ $data->user->email }}</td>
                                    <td>{{ $data->status_karyawan }}</td>
                                    <td>{{ $data->tahun_mulai }}</td>
                                    <td>{{ $data->tahun_selesai }}</td>
                                    <td class="text-center">
                                        @if ($data->user->id_roles == 3)
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('tu.edittuSI', ['id' => $data->user->id]) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('tu.deletetuSI', ['id' => $data->user->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut jabatan TU ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                                                        <i class="fa fa-trash me-1"></i> Cabut
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if ($datatuSI->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data Tata Usaha.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ExtraCSS')
@endsection

@section('ExtraJS')
@endsection
