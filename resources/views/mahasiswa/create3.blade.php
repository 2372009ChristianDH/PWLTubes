@extends('layouts.index')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Pengajuan Surat Pengantar Tugas Mata Kuliah</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home"><a href="#http://127.0.0.1:8000/mahasiswa"><i class="icon-home"></i></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="form-group">
                  <label for="dituju">Surat Ditujukan Kepada</label>
                  <input type="text" id="dituju" maxlength="100" placeholder="e.g. PT. X" class="form-control" required>
                </div>  
                <div class="form-group">
                  <label for="mk">Nama Mata Kuliah</label>
                  <input type="text" id="mk" maxlength="100" placeholder="e.g. Proses Bisnis - IN255" class="form-control" required>
                </div> 
                <div class="form-group">
                  <label for="semester">Semester</label>
                  <input type="text" id="semester" maxlength="2" placeholder="e.g. 5" class="form-control" required>
                </div>   
                <div class="form-group">
                  <label for="data">Data Mahasiswa</label>
                  <input type="text" id="data" maxlength="100" placeholder="e.g. John Doe - 23720xx" class="form-control" required>
                </div>  
                <div class="form-group">
                  <label for="tujuan">Tujuan</label>
                  <textarea id="tujuan" maxlength="300" placeholder="" rows="6" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <label for="topik">Topik</label>
                  <textarea id="topik" maxlength="100" placeholder="" rows="3" class="form-control" required></textarea>
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