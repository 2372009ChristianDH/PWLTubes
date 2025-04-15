@extends('layouts.index')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center fw-semibold text-primary mb-5" style="font-size: 2.5rem; padding-top:60px;">Dashboard Admin
        </h2>

        <!-- Info Cards -->
        <div class="row g-4 justify-content-center">
            <!-- Card Mahasiswa -->
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100 card-hover" style="background-color: #0d6efd;">
                    <div
                        class="card-body d-flex flex-column justify-content-center align-items-center text-center text-white">
                        <i class="bi bi-person-fill display-4 mb-2"></i>
                        <h6 class="text-light">Jumlah Mahasiswa</h6>
                        <h3 class="fw-bold">{{ $jumlahMahasiswa ?? '0' }}</h3>
                    </div>
                </div>
            </div>

            <!-- Card Karyawan -->
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100 card-hover" style="background-color: #198754;">
                    <div
                        class="card-body d-flex flex-column justify-content-center align-items-center text-center text-white">
                        <i class="bi bi-person-lines-fill display-4 mb-2"></i>
                        <h6 class="text-light">Jumlah Karyawan</h6>
                        <h3 class="fw-bold">{{ $jumlahKaryawan ?? '0' }}</h3>
                    </div>
                </div>
            </div>
        </div>


        <!-- Grafik Statistik -->
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-header bg-gradient bg-dark text-white text-center">
                <h5 class="mb-0">Pie Diagram Mahasiswa & Karyawan</h5>
            </div>
            <div class="card-body">
                <div class="w-50 mx-auto">
                    <canvas id="statistikChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('ExtraCSS')
    <style>
        #statistikChart {
            max-height: 150px;
        }
    </style>
@endsection

@section('ExtraJS')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahMahasiswa = {{ $jumlahMahasiswa ?? 0 }};
            const jumlahKaryawan = {{ $jumlahKaryawan ?? 0 }};
            const maxValue = Math.max(jumlahMahasiswa, jumlahKaryawan);
            const stepSize = Math.ceil(maxValue / 5) || 1;

            const ctx = document.getElementById('statistikChart').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Mahasiswa', 'Karyawan'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [jumlahMahasiswa, jumlahKaryawan],
                        backgroundColor: ['#0d6efd', '#198754'],
                        borderColor: ['#0b5ed7', '#157347'],
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: stepSize
                            },
                            suggestedMax: maxValue + stepSize
                        }
                    }
                }
            });
        });
    </script>
@endsection
