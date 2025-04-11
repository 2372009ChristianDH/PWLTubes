@extends('layouts.index')

@section('content')
    <!-- <h1 class="fw-bold mb-3" style="padding-right: 10px; padding-top:100px; text-align:center;">Laporan Surat Mahasiswa</h1> -->
    <br>
    <br>
    <br>
    <br>

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

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Surat Keaktifan -->
        <div class="tab-pane fade show active" id="keaktifan" role="tabpanel" aria-labelledby="keaktifan-tab">
            <div class="container-fluid px-5 py-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center" style="background-color: #002855;">
                        <h4 class="text-white fw-bold m-0">Data Surat Keaktifan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-keaktifan" class="table table-bordered table-hover table-striped align-middle"
                                style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratKeaktifan as $item)
                                        <tr>
                                            <td>{{ $item->user->mahasiswa->nrp }}</td>
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
                                                @if ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <a href="{{ route('tu.form_kirim_pdf', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-paper-plane me-1"></i> Kirim PDF
                                                    </a>
                                                @endif


                                                <button type="button" class="btn btn-info btn-sm mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                            </td>

                                            <!-- Modal Detail -->
                                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="modalDetailLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="modalDetailLabel{{ $item->id }}">Detail Surat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Periode:</strong> {{ $item->periode }}</p>
                                                            <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
                                                            <p><strong>Keperluan Pembuatan:</strong>
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
                                    @endforeach
                                    @if ($suratKeaktifan->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                keaktifan.</td>
                                        </tr>
                                    @endif
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
                    <div class="card-header text-center" style="background-color: #002855;">
                        <h4 class="text-white fw-bold m-0">Data Laporan Hasil Studi</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-laporan-hasil-studi"
                                class="table table-bordered table-hover table-striped align-middle" style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratLaporanHasilStudi as $item)
                                        <tr>
                                            <td>{{ $item->user->mahasiswa->nrp }}</td>
                                            <td>{{ $item->user->nama }}</td>
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
                                                    <span class="text-success">✅ Disetujui</span>
                                                @elseif ($item->suratDetail->status_persetujuan == 'Surat Ditolak')
                                                    <span class="text-danger">❌
                                                        {{ $item->suratDetail->status_persetujuan }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center w-25">
                                                @if ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <a href="{{ route('tu.form_kirim_pdf', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-paper-plane me-1"></i> Kirim PDF
                                                    </a>
                                                @endif


                                                <button type="button" class="btn btn-info btn-sm mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                            </td>

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
                                    @endforeach
                                    @if ($suratLaporanHasilStudi->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data laporan hasil
                                                studi.</td>
                                        </tr>
                                    @endif
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
                    <div class="card-header text-center" style="background-color: #002855;">
                        <h4 class="text-white fw-bold m-0">Data Surat Pengantar Tugas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-pengantar-tugas"
                                class="table table-bordered table-hover table-striped align-middle" style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratPengantarTugas as $item)
                                        <tr>
                                            <td>{{ $item->user->mahasiswa->nrp }}</td>
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
                                                @if ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <a href="{{ route('tu.form_kirim_pdf', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-paper-plane me-1"></i> Kirim PDF
                                                    </a>
                                                @endif


                                                <button type="button" class="btn btn-info btn-sm mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                            </td>

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

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </tr>
                                    @endforeach
                                    @if ($suratPengantarTugas->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                pengantar tugas.</td>
                                        </tr>
                                    @endif
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
                    <div class="card-header text-center" style="background-color: #002855;">
                        <h4 class="text-white fw-bold m-0">Data Surat Kelulusan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-kelulusan"
                                class="table table-bordered table-hover table-striped align-middle" style="width: 100%;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Tanggal Permohonan</th>
                                        <th>Tanggal Persetujuan/Penolakan</th>
                                        <th>Status Surat</th>
                                        <th style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suratKelulusan as $item)
                                        <tr>
                                            <td>{{ $item->user->mahasiswa->nrp }}</td>
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
                                                @if ($item->suratDetail->status_persetujuan == 'Sedang Diproses Tata Usaha')
                                                    <a href="{{ route('tu.form_kirim_pdf', $item->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-paper-plane me-1"></i> Kirim PDF
                                                    </a>
                                                @endif


                                                <button type="button" class="btn btn-info btn-sm mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $item->id }}">
                                                    <i class="fa fa-eye me-1"></i> Detail
                                                </button>
                                            </td>

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
                                    @endforeach
                                    @if ($suratKelulusan->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data surat
                                                kelulusan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
