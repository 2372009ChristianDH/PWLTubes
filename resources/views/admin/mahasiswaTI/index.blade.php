@extends('layouts.index')

@section('content')
    <div class="container py-5">
        <h3 class="fw-bold mb-4" style="text-align: center; font-size: 40px; padding-top:50px; color:rgb(0, 0, 112);">Data Mahasiswa Teknik Informatika</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('mahasiswa.createMahasiswaTI') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Tambah Mahasiswa
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="table-keaktifan" class="table table-hover table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>NRP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataMahasiswa as $data)
                                <tr>
                                    <td>{{ $data->nrp }}</td>
                                    <td>{{ $data->user->nama }}</td>
                                    <td>{{ $data->user->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('mahasiswa.editMahasiswaTI', ['id' => $data->user->id]) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                                                <i class="fa fa-edit me-1"></i> Edit
                                            </a>

                                            <form action="{{ route('mahasiswa.deleteMahasiswaTI', ['id' => $data->user->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                                                    <i class="fa fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($dataMahasiswa->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data mahasiswa.</td>
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
