@extends('layouts.index')

@section('content')
    <h3 class="fw-bold mb-3" style="padding-right: 10px; padding-top:100px;">Welcome To Dashboard</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success text-white" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @endsection

    @section('ExtraCSS')
    @endsection

    @section('ExtraJS')
    @endsection
