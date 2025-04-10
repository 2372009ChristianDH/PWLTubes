@extends('layouts.index')

@section('content')
    <h3 class="fw-bold mb-3" style="padding-right: 10px; padding-top:100px;">Welcome To Dashboard</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabs navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="keaktifan-tab" data-bs-toggle="tab" data-bs-target="#keaktifan"
                type="button" role="tab" aria-controls="keaktifan" aria-selected="true">Surat Keaktifan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lhs-tab" data-bs-toggle="tab" data-bs-target="#lhs" type="button" role="tab"
                aria-controls="lhs" aria-selected="false">Laporan Hasil Studi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ptmk-tab" data-bs-toggle="tab" data-bs-target="#ptmk" type="button"
                role="tab" aria-controls="ptmk" aria-selected="false">Pengantar Tugas Mata Kuliah</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kelulusan-tab" data-bs-toggle="tab" data-bs-target="#kelulusan" type="button"
                role="tab" aria-controls="kelulusan" aria-selected="false">Surat Kelulusan</button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Surat Keaktifan -->
        <div class="tab-pane fade show active" id="keaktifan" role="tabpanel" aria-labelledby="keaktifan-tab">
            <div class="table-responsive mt-4">
                <table id="table-keaktifan" class="table table-bordered table-hover table-striped"
                    style="width: 90%; margin: auto;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Alamat</th>
                            <th>Keperluan Pembuatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratKeaktifan as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->periode }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->keperluan_pembuatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laporan Hasil Studi -->
        <div class="tab-pane fade" id="lhs" role="tabpanel" aria-labelledby="lhs-tab">
            <div class="table-responsive mt-4">
                <table id="table-laporan-hasil-studi" class="table table-bordered table-hover table-striped"
                    style="width: 90%; margin: auto;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Keperluan Pembuatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratLaporanHasilStudi as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->keperluan_pembuatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pengantar Tugas Mata Kuliah -->
        <div class="tab-pane fade" id="ptmk" role="tabpanel" aria-labelledby="ptmk-tab">
            <div class="table-responsive mt-4">
                <table id="table-pengantar-tugas"class="table table-bordered table-hover table-striped"
                    style="margin: auto; width: 90%;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tujuan Surat</th>
                            <th>Nama MK</th>
                            <th>Periode</th>
                            <th>Nama</th>
                            <th>Topik</th>
                            <th>Tujuan Topik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratPengantarTugas as $item)
                            <tr>
                                <td>{{ $item->tujuan_surat }}</td>
                                <td>{{ $item->nama_mk }}</td>
                                <td>{{ $item->periode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->topik }}</td>
                                <td>{{ $item->tujuan_topik }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Surat Kelulusan -->
        <div class="tab-pane fade" id="kelulusan" role="tabpanel" aria-labelledby="kelulusan-tab">
            <div class="table-responsive mt-4">
                <table id="table-kelulusan" class="table table-bordered table-hover table-striped"
                    style="width: 90%; margin: auto;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Kelulusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratKelulusan as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->tgl_kelulusan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('ExtraCSS')
@endsection

@section('ExtraJS')
@endsection
