@extends('layouts.index')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show bg-success text-white" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <h3 class="fw-bold mb-3" style="text-align: center; font-size: 40px; padding-top:100px; color:rgb(0, 0, 112);">Dashboard Tata Usaha/h3>


    
    

    @endsection

    @section('ExtraCSS')
    @endsection

    @section('ExtraJS')
    @endsection
