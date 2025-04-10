@extends('layouts.index')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Pengajuan Surat Keterangan Lulus</h3>
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
                  <label for="name">Nama Lengkap</label>
                  <input type="text" id="name" maxlength="100" placeholder="e.g. John Doe" class="form-control" required>
                </div>  
                <div class="form-group">
                  <label for="lulus">Tanggal Kelulusan</label>
                  <input type="date" id="lulus" class="form-control" required>
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