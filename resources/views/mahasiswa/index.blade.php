@extends('layouts.index')

@section('content')
    <h1 class="fw-bold mb-3" style="padding-right: 10px; padding-top:100px; text-align: center;">Pengajuan Surat Mahasiswa
    </h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
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

    <!-- Filter tanggal -->
    <form method="GET" class="row g-2 align-items-end mb-3 px-3 py-2 rounded shadow-sm border bg-light m-3">
        <div class="col-md-4">
            <label for="tanggal_awal" class="form-label mb-1 fw-semibold">Tanggal Permohonan</label>
            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm"
                value="{{ request('tanggal_awal') }}">
        </div>
        <div class="col-md-4 d-flex gap-2 pt-3">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-filter me-1"></i> Filter
            </button>
            <a href="{{ route('mahasiswaList') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-sync me-1"></i> Reset
            </a>
        </div>
    </form>




    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Surat Keaktifan -->
        <div class="tab-pane fade show active" id="keaktifan" role="tabpanel" aria-labelledby="keaktifan-tab">
            <div class="container-fluid px-5 py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-keaktifan" class="table table-bordered table-hover align-middle"
                                style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredKeaktifan = $suratKeaktifan->filter(function ($item) {
                                            return in_array($item->suratDetail->status_persetujuan, [
                                                'Sedang Diproses Tata Usaha',
                                                'Menunggu Persetujuan Kaprodi',
                                            ]);
                                        });
                                        $no = 1;
                                    @endphp

                                    @forelse ($filteredKeaktifan as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                    <span class="text-warning">📋
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <span class="text-primary">🛠️
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                    <span class="text-success">✅
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <span class="text-danger">❌
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center w-25">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                        <!-- Tombol Edit untuk membuka modal -->
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="fa fa-edit me-1"></i> Edit
                                                        </button>
                                                    @endif
                                            
                                                    <!-- Tombol Detail -->
                                                    <button type="button"
                                                        class="btn btn-info btn-sm d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalKeaktifan{{ $item->id }}">
                                                        <i class="fa fa-eye me-1"></i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                            
                                            <!-- Modal Edit Surat -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Surat Keaktifan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit Surat -->
                                                            <form action="{{ route('update_keaktifan', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="mb-3">
                                                                    <label for="periode" class="form-label">Periode</label>
                                                                    <input type="text" class="form-control" id="periode" name="periode" value="{{ old('periode', $item->periode) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="alamat" class="form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $item->alamat) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="keperluan_pembuatan" class="form-label">Keperluan Pengajuan</label>
                                                                    <input type="text" class="form-control" id="keperluan_pembuatan" name="keperluan_pembuatan" value="{{ old('keperluan_pembuatan', $item->keperluan_pembuatan) }}" required>
                                                                </div>

                                                                <!-- Field lainnya jika diperlukan -->

                                                                <button type="submit" class="btn btn-primary">Update Surat</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Detail -->
                                            <div class="modal fade" id="modalKeaktifan{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="modalKeaktifanLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalKeaktifanLabel{{ $item->id }}">Detail Surat
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Tahun Akademik:</strong> {{ $item->periode }}</p>
                                                            <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
                                                            <p><strong>Keperluan Pengajuan:</strong>
                                                                {{ $item->keperluan_pembuatan }}</p>
                                                            @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                            @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                                <a href="{{ url('lihat-surat/' . $item->suratDetail->file_surat) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">Lihat
                                                                    Surat</a>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                keaktifan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Laporan Hasil Studi -->
        <div class="tab-pane fade" id="lhs" role="tabpanel" aria-labelledby="lhs-tab">
            <div class="container-fluid px-5 py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-laporan-hasil-studi" class="table table-bordered table-hover align-middle"
                                style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $suratLHSBelumSelesai = $suratLaporanHasilStudi->filter(function ($item) {
                                            return in_array($item->suratDetail->status_persetujuan, [
                                                'Sedang Diproses Tata Usaha',
                                                'Menunggu Persetujuan Kaprodi',
                                            ]);
                                        });
                                        $no = 1;
                                    @endphp

                                    @forelse ($suratLHSBelumSelesai as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                    <span class="text-warning">📋
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <span class="text-primary">🛠️
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center w-25">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                        <!-- Tombol Edit untuk membuka modal -->
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="fa fa-edit me-1"></i> Edit
                                                        </button>
                                                    @endif
                                            
                                                    <!-- Tombol Detail -->
                                                    <button type="button"
                                                        class="btn btn-info btn-sm d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetail{{ $item->id }}">
                                                        <i class="fa fa-eye me-1"></i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                            
                                            <!-- Modal Edit Surat -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Surat Laporan Hasil Studi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit Surat -->
                                                            <form action="{{ route('update_lhs', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="mb-3">
                                                                    <label for="keperluan_pembuatan" class="form-label">Keperluan Pengajuan</label>
                                                                    <input type="text" class="form-control" id="keperluan_pembuatan" name="keperluan_pembuatan" value="{{ old('keperluan_pembuatan', $item->keperluan_pembuatan) }}" required>
                                                                </div>

                                                                <!-- Field lainnya jika diperlukan -->

                                                                <button type="submit" class="btn btn-primary">Update Surat</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalDetailLabel{{ $item->id }}">Detail Surat</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Keperluan Pengajuan:</strong>
                                                                {{ $item->keperluan_pembuatan }}</p>
                                                            @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                            @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                                <a href="{{ url('lihat-surat/' . $item->suratDetail->file_surat) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">Lihat
                                                                    Surat</a>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat laporan
                                                hasil studi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Pengantar Tugas Mata Kuliah -->
        <div class="tab-pane fade" id="ptmk" role="tabpanel" aria-labelledby="ptmk-tab">
            <div class="container-fluid px-5 py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-pengantar-tugas" class="table table-bordered table-hover align-middle"
                                style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredPengantarTugas = $suratPengantarTugas->filter(function ($item) {
                                            return in_array($item->suratDetail->status_persetujuan, [
                                                'Sedang Diproses Tata Usaha',
                                                'Menunggu Persetujuan Kaprodi',
                                            ]);
                                        });
                                        $no = 1;
                                    @endphp

                                    @forelse ($filteredPengantarTugas as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                    <span class="text-warning">📋
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <span class="text-primary">🛠️
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                    <span class="text-success">✅
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <span class="text-danger">❌
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center w-25">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                        <!-- Tombol Edit untuk membuka modal -->
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="fa fa-edit me-1"></i> Edit
                                                        </button>
                                                    @endif
                                            
                                                    <!-- Tombol Detail -->
                                                    <button type="button"
                                                    class="btn btn-info btn-sm d-flex align-items-center"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                                </div>
                                            </td>
                                            
                                            <!-- Modal Edit Surat -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Surat Pengantar Tugas Matakuliah</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit Surat -->
                                                            <form action="{{ route('update_ptmk', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="mb-3">
                                                                    <label for="tujuan_surat" class="form-label">Tujuan Surat</label>
                                                                    <input type="text" class="form-control" id="tujuan_surat" name="tujuan_surat" value="{{ old('tujuan_surat', $item->tujuan_surat) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                                                                    <input type="text" class="form-control" id="nama_mk" name="nama_mk" value="{{ old('nama_mk', $item->nama_mk) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="periode" class="form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="periode" name="periode" value="{{ old('periode', $item->periode) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="topik" class="form-label">Topik</label>
                                                                    <input type="text" class="form-control" id="topik" name="topik" value="{{ old('topik', $item->topik) }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="tujuan_topik" class="form-label">Tujuan Topik</label>
                                                                    <input type="text" class="form-control" id="tujuan_topik" name="tujuan_topik" value="{{ old('tujuan_topik', $item->tujuan_topik) }}" required>
                                                                </div>

                                                                <!-- Field lainnya jika diperlukan -->

                                                                <button type="submit" class="btn btn-primary">Update Surat</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Detail -->
                                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalDetailLabel{{ $item->id }}">Detail Surat</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Tujuan Surat:</strong> {{ $item->tujuan_surat }}</p>
                                                            <p><strong>Nama Matakuliah:</strong> {{ $item->nama_mk }}</p>
                                                            <p><strong>Topik:</strong> {{ $item->topik }}</p>
                                                            <p><strong>Tujuan Topik:</strong> {{ $item->tujuan_topik }}</p>
                                                            @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                            @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                                <a href="{{ url('lihat-surat/' . $item->suratDetail->file_surat) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">Lihat
                                                                    Surat</a>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                pengantar tugas mata kuliah.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Surat Kelulusan -->
        <div class="tab-pane fade" id="kelulusan" role="tabpanel" aria-labelledby="kelulusan-tab">
            <div class="container-fluid px-5 py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-kelulusan" class="table table-bordered table-hover align-middle"
                                style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredKelulusan = $suratKelulusan->filter(function ($item) {
                                            return in_array($item->suratDetail->status_persetujuan, [
                                                'Sedang Diproses Tata Usaha',
                                                'Menunggu Persetujuan Kaprodi',
                                            ]);
                                        });
                                        $no = 1;
                                    @endphp

                                    @forelse ($filteredKelulusan as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                    <span class="text-warning">📋
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <span class="text-primary">🛠️
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                    <span class="text-success">✅
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <span class="text-danger">❌
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center w-25">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                                        <!-- Tombol Edit untuk membuka modal -->
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="fa fa-edit me-1"></i> Edit
                                                        </button>
                                                    @endif
                                            
                                                    <!-- Tombol Detail -->
                                                    <button type="button"
                                                    class="btn btn-info btn-sm d-flex align-items-center"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                                </div>
                                            </td>
                                            
                                            <!-- Modal Edit Surat -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Surat Kelulusan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit Surat -->
                                                            <form action="{{ route('update_lulus', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <div class="mb-3">
                                                                    <label for="tgl_kelulusan" class="form-label">Tanggal Kelulusan</label>
                                                                    <input type="date" class="form-control" id="tgl_kelulusan" name="tgl_kelulusan" value="{{ old('tgl_kelulusan', $item->tgl_kelulusan) }}" required>
                                                                </div>
                                                                <!-- Field lainnya jika diperlukan -->

                                                                <button type="submit" class="btn btn-primary">Update Surat</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Detail -->
                                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalDetailLabel{{ $item->id }}">Detail Surat</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Tanggal Kelulusan:</strong>
                                                                {{ \Carbon\Carbon::parse($item->tgl_kelulusan)->translatedFormat('d F Y') }}
                                                            </p>
                                                            @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                            @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                                                <p><strong>Keterangan:</strong>
                                                                    {{ $item->suratDetail->keterangan }}</p>
                                                                <a href="{{ url('lihat-surat/' . $item->suratDetail->file_surat) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">Lihat
                                                                    Surat</a>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                kelulusan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('ExtraCSS')
@endsection

@section('ExtraJS')
@endsection
