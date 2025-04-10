@extends('layouts.index')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show bg-success text-white" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <h3 class="fw-bold mb-3" style="text-align: center; font-size: 40px; padding-top:100px; color:rgb(0, 0, 112);">Data Ketua Program Studi</h3>


    <div class="card-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('kaprodi.createKaprodiTI') }}" class="btn btn-primary btn-round ms-auto" style="margin-right: 100px; font-size: 17px;">
                <i class="fa fa-plus"></i> Tambah Kaprodi
            </a>
        </div>
    </div>
    

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="keaktifan" role="tabpanel" aria-labelledby="keaktifan-tab">
            <div class="table-responsive mt-4">
                <table id="table-keaktifan" class="table table-bordered table-hover table-striped"
                    style="width: 90%; margin: auto;">
                    <thead class="thead-dark">
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tahun Mulai</th></th>
                            <th>Tahun Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                    @foreach ($dataKaprodiTI as $data)
                        <tr>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->user->nama }}</td>
                            <td>{{ $data->user->email }}</td>
                            <td>{{ $data->tahun_mulai }}</td>
                            <td>{{ $data->tahun_selesai }}</td>
                            <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('mahasiswa.editMahasiswaTI', ['id' => $data->user->id]) }}" class="btn btn-warning btn-sm">
                            Edit                                             
                            </a>


                            <!-- Tombol Hapus -->
                            <form action="{{ route('mahasiswa.deleteMahasiswaTI', ['id' => $data->user->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>

                        </td>
                        </tr>
                    @endforeach                    
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

    @section('ExtraCSS')
    @endsection

    @section('ExtraJS')
    @endsection
