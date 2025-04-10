@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3" style="padding-right: 10px">Tambah Mahasiswa Baru Sistem Informasi</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="#http://127.0.0.1:8000/mahasiswa"><i class="icon-home"></i></a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('mahasiswa.storeMahasiswaSI') }}" method="POST">
                                @csrf
                                <!-- Input NRP -->
                                <div class="mb-3">
                                    <label for="nrp" class="form-label">NRP</label>
                                    <input type="text" name="nrp" class="form-control @error('nrp') is-invalid @enderror" id="nrp" value="{{ old('nrp') }}">
                                    @error('nrp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Input Nama -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                        
                                <!-- Input Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                        
                                <!-- Input Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                                    @error('password')
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
