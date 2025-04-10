@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3" style="padding-right: 10px">Kirim PDF ke Mahasiswa</h3>
                <p class="fw-bold text-primary mb-3"
                    style="font-size: 1.25rem; line-height: 1.5; font-weight: 500; border-left: 4px solid #007bff; padding-left: 10px;">
                    {{ $surat->user->nama }} - {{ $surat->user->mahasiswa->nrp ?? '-' }}
                </p>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="{{ route('tu.index') }}"><i class="icon-home"></i></a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('tu.kirim_pdf', $surat->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="file_pdf">Upload File PDF</label>
                                    <input type="file" class="form-control" name="file_pdf" id="file_pdf"
                                        accept="application/pdf" required>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan (opsional)</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="4"
                                        placeholder="Contoh: Harap dicek dan dicetak."></textarea>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-paper-plane me-1"></i> Kirim
                                    </button>
                                    <a href="{{ route('tu.kelolaSurat') }}" class="btn btn-secondary ms-2">Kembali</a>
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
@endsection
