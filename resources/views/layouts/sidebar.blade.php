<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/kaiadmin/surat.logo.png') }}" alt="SmartLetter Logo"
                    class="navbar-brand" style="width : 70px" />
                <span class="text-white fw-bold fs-5">SmartLetter</span>
            </a>
            
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                @if (Auth::user()->id_roles == 1)
                    <li class="nav-item">
                        <a href="{{ route('admin.index') }}" role="button" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @elseif(Auth::user()->id_roles == 2)
                    <li class="nav-item">
                        <a href="{{ route('kaprodi.index') }}" role="button" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @elseif(Auth::user()->id_roles == 3)
                    <li class="nav-item">
                        <a href="{{ route('tu.index') }}" role="button" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @elseif (Auth::user()->id_roles == 4)
                    <li class="nav-item">
                        <a href="{{ route('mahasiswaList') }}" role="button" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif




                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

                @if (Auth::user()->id_roles == 4)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base">
                            <i class="fas fa-file-alt"></i>
                            <p>Pengajuan Surat</p>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse" id="base">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/create_keaktifan?jenis_surat=keaktifan') }}">
                                        <span class="sub-item">Surat Keaktifan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/create_lhs?jenis_surat=lhs') }}">
                                        <span class="sub-item">Laporan Hasil Studi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/create_ptmk?jenis_surat=ptmk') }}">
                                        <span class="sub-item">Surat Pengantar Tugas Mata Kuliah</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/create_lulus?jenis_surat=lulus') }}">
                                        <span class="sub-item">Surat Keterangan Lulus</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (Auth::user()->id_roles == 1)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayoutsMahasiswa">
                            <i class="fas fa-file-alt"></i>
                            <p>Data Mahasiswa</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsMahasiswa">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('data.mahasiswaTI') }}">
                                        <span class="sub-item">Teknik Informatika</span>
                                    </a>
                                </li>
                                <li>
                                    <a href=" {{ route('data.mahasiswaSI') }} ">
                                        <span class="sub-item">Sistem Informasi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.mahasiswaIK') }}">
                                        <span class="sub-item">Ilmu Komputer</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayoutsKaryawan">
                            <i class="fas fa-file-alt"></i>
                            <p>Data Karyawan</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsKaryawan">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('data.kaprodiTI') }}">
                                        <span class="sub-item">Ketua Program Studi TI</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.kaprodiSI') }}">
                                        <span class="sub-item">Ketua Program Studi SI</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.kaprodiIK') }}">
                                        <span class="sub-item">Ketua Program Studi IK</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.tuTI') }}">
                                        <span class="sub-item">Tata Usaha TI</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.tuSI') }}">
                                        <span class="sub-item">Tata Usaha SI</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('data.tuIK') }}">
                                        <span class="sub-item">Tata Usaha IK</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayoutsLainnya">
                            <i class="fas fa-th-list"></i>
                            <p>Lainnya</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsLainnya">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="sidebar-style-2.html">
                                        <span class="sub-item">Histori Pengajuan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="icon-menu.html">
                                        <span class="sub-item">Status Surat</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                @endif


                @if (Auth::user()->id_roles == 2)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayoutsMahasiswa">
                            <i class="fas fa-file-alt"></i>
                            <p>Surat</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsMahasiswa">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('kaprodi.kelolaSurat') }}">
                                        <span class="sub-item">Kelola Surat</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                @if (Auth::user()->id_roles == 3)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayoutsMahasiswa">
                            <i class="fas fa-file-alt"></i>
                            <p>Surat</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayoutsMahasiswa">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('tu.kelolaSurat') }}">
                                        <span class="sub-item">Kelola Surat</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (Auth::user()->id_roles == 4)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayouts">
                            <i class="fas fa-th-list"></i>
                            <p>Lainnya</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="/mahasiswa/histori/index">
                                        <span class="sub-item">Histori Pengajuan</span>
                                    </a>                                    
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
