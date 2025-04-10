@extends('layouts.index')

@section('content')
    <h1 class="fw-bold mb-3" style="padding-right: 10px; padding-top:100px; text-align:center;">Laporan Surat Mahasiswa</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white" role="alert">
            {{ session('success') }}
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
                            <th>NRP</th>
                            <th>Nama</th>
                            <th>Tanggal Permohonan</th>
                            <th>Tanggal Persetujuan/Penolakan</th>
                            <th>Status Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratKeaktifan as $item)
                            <tr>
                                <td>{{ $item->user->mahasiswa->nrp }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}</td>
                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} 📋
                                        </span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }}
                                            🛠️</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Disetujui')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ✅</span>
                                    </td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ❌</span>
                                    </td>
                                @endif
                                <td>
                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('surat.acc', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                style="font-size:15px;">Terima</button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak{{ $item->id }}"
                                            style="font-size:15px;">Tolak</button>
                                    @endif

                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        style="font-size:15px;" data-bs-target="#modalDetail{{ $item->id }}">
                                        Lihat Detail
                                    </button>
                                </td>

                                <!-- Modal untuk Lihat Detail Surat -->
                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel{{ $item->id }}">Detail
                                                    Surat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Periode:</strong> {{ $item->periode }}</p>
                                                <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
                                                <p><strong>Keperluan Pembuatan:</strong> {{ $item->keperluan_pembuatan }}</p>
                                                @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <p><strong>Keterangan:</strong> {{ $item->suratDetail->keterangan }}</p>
                                                @endif
                                                <!-- Tampilkan PDF jika ada -->
                                                {{-- @if ($item->suratDetail->pdf_path)
                                                    <a href="{{ asset('storage/' . $item->suratDetail->pdf_path) }}" target="_blank" class="btn btn-primary">Lihat PDF Surat</a>
                                                @else
                                                    <p>PDF Surat belum tersedia.</p>
                                                @endif --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Tolak -->
                                <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalTolakLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTolakLabel{{ $item->id }}">
                                                    Konfirmasi Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('surat.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mt-3">
                                                        <label for="keterangan{{ $item->id }}"
                                                            class="form-label">Masukkan alasan penolakan:</label>
                                                        <textarea name="keterangan" id="keterangan{{ $item->id }}" class="form-control" rows="3" required>{{ old('keterangan', $item->suratDetail->keterangan) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                            <th>NRP</th>
                            <th>Nama</th>
                            <th>Tanggal Permohonan</th>
                            <th>Tanggal Persetujuan/Penolakan</th>
                            <th>Status Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratLaporanHasilStudi as $item)
                            <tr>
                                <td>{{ $item->user->mahasiswa->nrp }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}</td>
                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} 📋
                                        </span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }}
                                            🛠️</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Disetujui')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ✅</span>
                                    </td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ❌</span>
                                    </td>
                                @endif
                                <td>
                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('surat.acc', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                style="font-size:15px;">Terima</button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak{{ $item->id }}"
                                            style="font-size:15px;">Tolak</button>
                                    @endif

                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        style="font-size:15px;" data-bs-target="#modalDetail{{ $item->id }}">
                                        Lihat Detail
                                    </button>
                                </td>

                                <!-- Modal untuk Lihat Detail Surat -->
                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel{{ $item->id }}">Detail
                                                    Surat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Keperluan Pengajuan:</strong> {{ $item->keperluan_pembuatan }}</p>
                                                @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <p><strong>Keterangan:</strong> {{ $item->suratDetail->keterangan }}</p>
                                                @endif
                                                <!-- Tampilkan PDF jika ada -->
                                                {{-- @if ($item->suratDetail->pdf_path)
                                                    <a href="{{ asset('storage/' . $item->suratDetail->pdf_path) }}" target="_blank" class="btn btn-primary">Lihat PDF Surat</a>
                                                @else
                                                    <p>PDF Surat belum tersedia.</p>
                                                @endif --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Tolak -->
                                <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalTolakLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTolakLabel{{ $item->id }}">
                                                    Konfirmasi Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('surat.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mt-3">
                                                        <label for="keterangan{{ $item->id }}"
                                                            class="form-label">Masukkan alasan penolakan:</label>
                                                        <textarea name="keterangan" id="keterangan{{ $item->id }}" class="form-control" rows="3" required>{{ old('keterangan', $item->suratDetail->keterangan) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                            <th>NRP</th>
                            <th>Nama</th>
                            <th>Tanggal Permohonan</th>
                            <th>Tanggal Persetujuan/Penolakan</th>
                            <th>Status Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratPengantarTugas as $item)
                            <tr>
                                <td>{{ $item->user->mahasiswa->nrp }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}</td>
                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan  }} 📋 </span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} 🛠️</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Disetujui')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ✅</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ❌</span></td>
                                @endif

                                <td>
                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('surat.acc', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                style="font-size:15px;">Terima</button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak{{ $item->id }}"
                                            style="font-size:15px;">Tolak</button>
                                    @endif

                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        style="font-size:15px;" data-bs-target="#modalDetail{{ $item->id }}">
                                        Lihat Detail
                                    </button>
                                </td>

                                <!-- Modal untuk Lihat Detail Surat -->
                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel{{ $item->id }}">Detail
                                                    Surat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Tujuan Surat:</strong> {{ $item->tujuan_surat }}</p>
                                                <p><strong>Nama Matakuliah:</strong> {{ $item->nama_mk }}</p>
                                                <p><strong>Topik:</strong> {{ $item->topik }}</p>
                                                <p><strong>Tujuan Topik:</strong> {{ $item->tujuan_topik }}</p>
                                                @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <p><strong>Keterangan:</strong> {{ $item->suratDetail->keterangan }}</p>
                                                @endif
                                                <!-- Tampilkan PDF jika ada -->
                                                {{-- @if ($item->suratDetail->pdf_path)
                                                    <a href="{{ asset('storage/' . $item->suratDetail->pdf_path) }}" target="_blank" class="btn btn-primary">Lihat PDF Surat</a>
                                                @else
                                                    <p>PDF Surat belum tersedia.</p>
                                                @endif --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Tolak -->
                                <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalTolakLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTolakLabel{{ $item->id }}">
                                                    Konfirmasi Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('surat.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mt-3">
                                                        <label for="keterangan{{ $item->id }}"
                                                            class="form-label">Masukkan alasan penolakan:</label>
                                                        <textarea name="keterangan" id="keterangan{{ $item->id }}" class="form-control" rows="3" required>{{ old('keterangan', $item->suratDetail->keterangan) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                            <th>NRP</th>
                            <th>Nama</th>
                            <th>Tanggal Permohonan</th>
                            <th>Tanggal Persetujuan/Penolakan</th>
                            <th>Status Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratKelulusan as $item)
                            <tr>
                                <td>{{ $item->user->mahasiswa->nrp }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->suratDetail->tgl_permohonan)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->suratDetail->tgl_persetujuan ? \Carbon\Carbon::parse($item->suratDetail->tgl_persetujuan)->translatedFormat('d F Y') : '-' }}</td>
                                @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan  }} 📋 </span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} 🛠️</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Disetujui')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ✅</span></td>
                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                    <td><span style="font-size: 15px">{{ $item->suratDetail->status_persetujuan }} ❌</span></td>
                                @endif

                                <td>
                                    @if ($item->suratDetail->status_persetujuan == 'Menunggu Persetujuan Kaprodi')
                                        <!-- Tombol Terima -->
                                        <form action="{{ route('surat.acc', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                style="font-size:15px;">Terima</button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak{{ $item->id }}"
                                            style="font-size:15px;">Tolak</button>
                                    @endif

                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        style="font-size:15px;" data-bs-target="#modalDetail{{ $item->id }}">
                                        Lihat Detail
                                    </button>
                                </td>

                                <!-- Modal untuk Lihat Detail Surat -->
                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDetailLabel{{ $item->id }}">Detail
                                                    Surat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Tanggal Kelulusan:</strong> {{ \Carbon\Carbon::parse($item->tgl_kelulusan)->translatedFormat('d F Y') }}</p>
                                                @if ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <p><strong>Keterangan:</strong> {{ $item->suratDetail->keterangan }}</p>
                                                @endif
                                                <!-- Tampilkan PDF jika ada -->
                                                {{-- @if ($item->suratDetail->pdf_path)
                                                    <a href="{{ asset('storage/' . $item->suratDetail->pdf_path) }}" target="_blank" class="btn btn-primary">Lihat PDF Surat</a>
                                                @else
                                                    <p>PDF Surat belum tersedia.</p>
                                                @endif --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Tolak -->
                                <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalTolakLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTolakLabel{{ $item->id }}">
                                                    Konfirmasi Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('surat.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mt-3">
                                                        <label for="keterangan{{ $item->id }}"
                                                            class="form-label">Masukkan alasan penolakan:</label>
                                                        <textarea name="keterangan" id="keterangan{{ $item->id }}" class="form-control" rows="3" required>{{ old('keterangan', $item->suratDetail->keterangan) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
