@extends('layouts.index')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3" style="padding-right: 10px">Pengajuan Surat Pengantar Tugas Mata Kuliah</h3>
        <p class="fw-bold text-primary mb-3" style="font-size: 1.25rem; line-height: 1.5; font-weight: 500; border-left: 4px solid #007bff; padding-left: 10px;">
          {{ Auth::user()->mahasiswa->nama ?? Auth::user()->nama }} - {{ Auth::user()->mahasiswa->nrp ?? '' }}
        </p>
          <ul class="breadcrumbs mb-3">
          <li class="nav-home"><a href="#http://127.0.0.1:8000/mahasiswa"><i class="icon-home"></i></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('surat_ptmk') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_surat" value="{{ request()->query('jenis_surat') }}">
                <div class="form-group">
                  <label for="tujuan_surat">Surat Ditujukan Kepada</label>
                  <input type="text" id="tujuan_surat" name="tujuan_surat" maxlength="100" placeholder="" class="form-control" style="width: 50%" required>
                </div>  
                <div class="form-group">
                  <label for="nama_mk">Nama Mata Kuliah</label>
                  <input type="text" id="nama_mk" name="nama_mk" maxlength="100"placeholder="" class="form-control" style="width: 30%" required>
                </div> 
                <div class="form-group">
                  <label for="periode">Periode</label>
                  <input type="text" id="periode" name="periode" maxlength="20" placeholder="" class="form-control" style="width: 20%" required>
                </div>     
                <div class="form-group">
                  <label for="topik">Topik</label>
                  <textarea id="topik" name="topik" maxlength="100" placeholder="" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <label for="tujuan_topik">Tujuan_Topik</label>
                  <textarea id="tujuan_topik" name="tujuan_topik" maxlength="300" placeholder="" rows="6" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
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