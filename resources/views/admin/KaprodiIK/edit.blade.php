@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3" style="padding-right: 10px">Edit Mahasiswa Ilmu Komputer</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="#http://127.0.0.1:8000/mahasiswa"><i class="icon-home"></i></a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                        <form action="{{ route('kaprodi.updateKaprodiIK', ['id' => $karyawan->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                                <!-- Input NIK -->
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                        id="nik" value="{{ old('nik', $karyawan->nik) }}" readonly>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                
                                <!-- Input Nama -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama', $karyawan->user->nama) }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                        
                                <!-- Input Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $karyawan->user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>    

                                <!-- Input Email -->
                                <div class="mb-3">
                                    <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                                    <input type="date" name="tahun_mulai" class="form-control @error('tahun_mulai') is-invalid @enderror" id="tahun_mulai" value="{{ old('tahun_mulai', $karyawan->tahun_mulai) }}">
                                    @error('tahun_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Input Email -->
                                <div class="mb-3">
                                    <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                                    <input type="date" name="tahun_selesai" class="form-control @error('tahun_selesai') is-invalid @enderror" id="tahun_selesai" value="{{ old('tahun_selesai', $karyawan->tahun_selesai) }}">
                                    @error('tahun_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>    
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
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
    <script>
        $(document).ready(function() {
            $("#table-lecturer").DataTable({
                pageLength: 25,
            });
        });
    </script>
@endsection
