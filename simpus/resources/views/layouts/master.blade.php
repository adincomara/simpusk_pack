<!--
*
*  INSPINIA - Responsive Admin Theme
*  version 2.8
*
-->

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SIMPUS | @yield('title')</title>
    <link href="{{ asset('/inspinia/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css')}}">

    <!-- Toastr style -->
    <link href="{{ asset('/inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('/inspinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/css/style.css') }}" rel="stylesheet">

    {{-- <style>
        body{
            font-family: "open sans", "Helvetica Neue", Arial, Helvetica, sans-serif;
            background-color: #275783;
            font-size: 13px;
            color: #676a6c;
            overflow-x: hidden
        }
        .nav-header{
            padding:33px 25px;
            background-color: #275783;
            background-image: none;
        }
        .nav > li.active{
            border-left:4px solid #0d8f94;
            background: #293864;
        }
    </style> --}}
    <style>
        ul.pagination {
            display: inline-flex;
        }

        .select2-selection {
            height: 34px !important;
            border-color: #ced4da !important;
        }
    </style>
    <style>
        .redirect {
            color: inherit;
            color: #a7b1c2;
        }

        .redirect:hover {
            background-color: #293846;
            color: #ffff;
        }

        .redirect.active {
            background-color: #19aa8d;
            color: #ffff;
        }
    </style>
    @stack('stylesheets')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="{{session('profile')}}" />
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">{{auth()->user()->name}}</span>
                                {{-- <span class="text-muted text-xs block">{{ auth()->user()->role[0]->name }} <b
                                    class="caret"></b></span> --}}
                                <span class="text-muted text-xs block">{{ auth()->user()->role[0]->name }} </span>
                            </a>
                            {{-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('manage.logout') }}">Logout</a>
                    </li>
                </ul> --}}
            </div>
            <div class="logo-element">
                RTI
            </div>

            </li>
            <div style="padding:3px">
                <li>
                    <a class="btn redirect active" href="{{route('manage.beranda')}}">SIMPUSK</a>
                    <a class="btn redirect" href="{{route('manage.beranda.ptm')}}">PTM</a>
                    <a class="btn redirect" href="{{route('manage.beranda.kia')}}">KIA</a>
                </li>
            </div>

            <li class="{{  request()->routeIs('manage.beranda') ? 'active' : '' }}">
                <a href="{{ route('home') }}"><i class="fa fa-home" style="font-size:16px" aria-hidden="true"></i> <span
                        class="nav-label">Beranda</span></a>
            </li>
            @can('master.index')
            <li
                class="{{  request()->routeIs('jabatan.*') || request()->routeIs('bidang.*') || request()->routeIs('pegawai.*') || request()->routeIs('kk.*') || request()->routeIs('pasien.*') || request()->routeIs('poli.*') || request()->routeIs('jenisoperasi.*') || request()->routeIs('penyakit.*') || request()->routeIs('tindakan.*') || request()->routeIs('diagnosa_penyakit.*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-database" style="font-size:16px"></i> <span class="nav-label">Master</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('jabatan.index')
                    <li class="{{  request()->routeIs('jabatan.*') ? 'active' : '' }}"><a
                            href="{{ route('jabatan.index') }}">Data Jabatan</a></li>
                    @endcan
                    @can('bidang.index')
                    <li class="{{  request()->routeIs('bidang.*') ? 'active' : '' }}"><a
                            href="{{ route('bidang.index') }}">Data Bidang</a></li>
                    @endcan
                    @can('pegawai.index')
                    <li class="{{  request()->routeIs('pegawai.*') ? 'active' : '' }}"><a
                            href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
                    @endcan
                    @can('kk.index')
                    <li class="{{  request()->routeIs('kk.*') ? 'active' : '' }}"><a href="{{ route('kk.index') }}">Data
                            Kartu Keluarga</a></li>
                    @endcan
                    @can('pasien.index')
                    <li class="{{  request()->routeIs('pasien.*') ? 'active' : '' }}"><a
                            href="{{ route('pasien.index') }}">Data Pasien</a></li>
                    @endcan
                    @can('poli.index')
                    <li class="{{  request()->routeIs('poli.*') ? 'active' : '' }}"><a
                            href="{{ route('poli.index') }}">Data Poli</a></li>
                    @endcan
                    @can('jenisoperasi.index')
                    <li class="{{  request()->routeIs('jenisoperasi.*') ? 'active' : '' }}"><a
                            href="{{ route('jenisoperasi.index') }}">Data Jenis Operasi</a></li>
                    @endcan
                    @can('penyakit.index')
                    <li class="{{  request()->routeIs('penyakit.*') ? 'active' : '' }}"><a
                            href="{{ route('penyakit.index') }}">Data Penyakit</a></li>
                    @endcan
                    @can('tindakan.index')
                    <li class="{{  request()->routeIs('tindakan.*') ? 'active' : '' }}"><a
                            href="{{ route('tindakan.index') }}">Data Tindakan</a></li>
                    @endcan
                    @can('diagnosa_penyakit.index')
                    <li class="{{  request()->routeIs('diagnosa_penyakit.*') ? 'active' : '' }}"><a
                            href="{{ route('diagnosa_penyakit.index') }}">Data Diagnosis Penyakit</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('pelayanan.index')
            <li
                class="{{ request()->routeIs('pendaftaran.*') || request()->routeIs('pelayanan_poli.*') || request()->routeIs('laboratorium.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-handshake" style="font-size:16px"></i> <span
                        class="nav-label">Pelayanan</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('pendaftaran.index')
                    <li class="{{ request()->routeIs('pendaftaran.*')? 'active' : '' }}"><a
                            href="{{ route('pendaftaran.index') }}">Pendaftaran</a></li>
                    @endcan
                    @can('pelayanan_poli.index')
                    <li class="{{ request()->routeIs('pelayanan_poli.*')? 'active' : '' }}"><a
                            href="{{ route('pelayanan_poli.index') }}">Poli</a></li>
                    @endcan
                    @can('laboratorium.index')
                    <li class="{{ request()->routeIs('laboratorium.*')? 'active' : '' }}"><a
                            href="{{ route('laboratorium.index') }}">Laboratorium</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('apotik.index')
            <li
                class="{{ request()->routeIs('supplier.*') || request()->routeIs('obat.*')||request()->routeIs('stok_obat.*')||request()->routeIs('pengadaan_obat.*')||request()->routeIs('pengeluaran_obat.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-medkit" style="font-size:16px"></i> <span class="nav-label">Apotik</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('supplier.index')
                    <li class="{{ request()->routeIs('supplier.*')? 'active' : '' }}"><a
                            href="{{ route('supplier.index') }}">Data Suplier</a></li>
                    @endcan
                    @can('obat.index')
                    <li class="{{ request()->routeIs('obat.*')? 'active' : '' }}"><a
                            href="{{ route('obat.index') }}">Data Obat</a></li>
                    @endcan
                    @can('stok_obat.index')
                    <li class="{{ request()->routeIs('stok_obat.*')? 'active' : '' }}"><a
                            href="{{ route('stok_obat.index') }}">Data Stok Obat</a></li>
                    @endcan
                    @can('pengadaan_obat.index')
                    <li class="{{ request()->routeIs('pengadaan_obat.*')? 'active' : '' }}"><a
                            href="{{ route('pengadaan_obat.index') }}">Pengadaan Obat</a></li>
                    @endcan
                    @can('pengeluaran_obat.index')
                    <li class="{{ request()->routeIs('pengeluaran_obat.*')? 'active' : '' }}"><a
                            href="{{ route('pengeluaran_obat.index') }}">Pengeluaran Obat</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li
                class="{{ request()->routeIs('report.*') || request()->routeIs('report.pasienDiagnosa') || request()->routeIs('report.pasienTindakan.*') || request()->routeIs('report.tindakanPasien.*')|| request()->routeIs('pegawai.cetak')||request()->routeIs('pegawai.cetaknakes')||request()->routeIs('pengeluaran_obat.cetakberiobat') || request()->routeIs('tenagakesehatan.*') || request()->routeIs('jabatannakes.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-sticky-note" style="font-size:16px"></i> <span
                        class="nav-label">Laporan</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li
                        class="{{ request()->routeIs('report.pasienDiagnosa') || request()->routeIs('report.detailDiagnosis')? 'active' : '' }}">
                        <a href="{{route('report.pasienDiagnosa')}}">Laporan Pasien Berdasarkan Diagnosa</a></li>
                    <li
                        class="{{ request()->routeIs('report.pasienTindakan') || request()->routeIs('report.detailTindakan')? 'active' : '' }}">
                        <a href="{{route('report.pasienTindakan')}}">Laporan Pasien Berdasarkan Tindakan</a></li>
                    <li
                        class="{{ request()->routeIs('report.tindakanPasien') ||request()->routeIs('report.tindakanPasien_*')||request()->routeIs('report.tindakanpasien_*')? 'active' : '' }}">
                        <a href="{{route('report.tindakanpasien_index')}}">Laporan Tindakan Pasien</a></li>
                    <li
                        class="{{ request()->routeIs('pegawai.cetak') || request()->routeIs('tenagakesehatan.*')? 'active' : '' }}">
                        <a href="{{route('tenagakesehatan.index')}}">Tenaga Puskesmas</a></li>
                    <li class="{{ request()->routeIs('jabatannakes.*')? 'active' : '' }}"><a
                            href="{{route('jabatannakes.index')}}">Jabatan Nakes</a></li>
                    <li class="{{ request()->routeIs('report.pemberianobat.*')? 'active' : '' }}"><a
                            href="{{route('report.pemberianobat.index')}}">Pemberian Obat</a></li>
                    <li class="{{ request()->routeIs('report.kunjunganpasien.*')? 'active' : '' }}"><a
                            href="{{route('report.kunjunganpasien.index')}}">Kunjungan Pasien (Baru dan Lama)</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-ambulance" style="font-size:16px"></i> <span class="nav-label">Integrasi
                        BPJS</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="active"><a href="index.html">Pasien BPJS (PCARE)</a></li>
                    <li><a href="dashboard_2.html">Rujukan Pasien BPJS (PCARE)</a></li>
                </ul>
            </li>
            @can('pengguna.index')
            <li class="{{ request()->routeIs('staff.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-users" style="font-size:16px"></i> <span class="nav-label">Pengguna</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('staff.index')
                    <li class="{{ request()->routeIs('staff.*')? 'active' : '' }}"><a
                            href="{{ route('staff.index') }}">Staff</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('company.index')
            <li class="{{ request()->routeIs('about.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-cogs" style="font-size:16px"></i> <span class="nav-label">Pengaturan</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('about.index')
                    <li class="{{ request()->routeIs('about.*')? 'active' : '' }}"><a
                            href="{{ route('about.index') }}">Tentang</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('security.index')
            <li class="{{ request()->routeIs('permission.*')||request()->routeIs('role.*')? 'active' : '' }}">
                <a href="#"><i class="fa fa-lock" style="font-size:16px"></i> <span class="nav-label">Keamanan</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('permission.index')
                    <li class="{{ request()->routeIs('permission.*')? 'active' : '' }}"><a
                            href="{{ route('permission.index') }}">Modul</a></li>
                    @endcan
                    @can('role.index')
                    <li class="{{ request()->routeIs('role.*')? 'active' : '' }}"><a
                            href="{{ route('role.index') }}">Akses</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('log.index')
            <li class="{{ request()->routeIs('log.*')?'active' : '' }}">
                <a href="{{ route('log.index') }}"><i class="fa fa-lock" style="font-size:16px"></i> <span
                        class="nav-label">Log Aktivitas</span> <span class="fa arrow"></span></a>
            </li>
            @endcan
            </ul>

    </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">



                    <li>
                        <a href="{{ route('manage.logout') }}">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>

                </ul>

            </nav>
        </div>

        {{-- Content --}}

        @yield('konten')

        <div class="footer">
            <div>
                <strong>2020</strong>© SIMPUS Support By <a href="#" style="color: red">Rapier</a>
            </div>
        </div>
    </div>
    <div class="small-chat-box fadeInRight animated">

        <div class="heading" draggable="true">
            <small class="chat-date float-right">
                02.19.2015
            </small>
            Small chat
        </div>

        <div class="content">

            <div class="left">
                <div class="author-name">
                    Monica Jackson <small class="chat-date">
                        10:02 am
                    </small>
                </div>
                <div class="chat-message active">
                    Lorem Ipsum is simply dummy text input.
                </div>

            </div>
            <div class="right">
                <div class="author-name">
                    Mick Smith
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    Lorem Ipsum is simpl.
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Alice Novak
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    Check this stock char.
                </div>
            </div>
            <div class="right">
                <div class="author-name">
                    Anna Lamson
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    The standard chunk of Lorem Ipsum
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Mick Lane
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    I belive that. Lorem Ipsum is simply dummy text.
                </div>
            </div>


        </div>
        <div class="form-chat">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control">
                <span class="input-group-btn"> <button class="btn btn-primary" type="button">Send
                    </button> </span></div>
        </div>

    </div>
    {{-- <div id="small-chat">

            <span class="badge badge-warning float-right">5</span>
            <a class="open-small-chat" href="">
                <i class="fa fa-comments"></i>

            </a>
        </div> --}}
    <div id="right-sidebar" class="animated">
        <div class="sidebar-container">

            <ul class="nav nav-tabs navs-3">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab-1"> Notes </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-2"> Projects </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                </li>
            </ul>

            <div class="tab-content">


                <div id="tab-1" class="tab-pane active">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                        <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                    </div>

                    <div>

                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a1.jp') }}g">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">

                                    There are many variations of passages of Lorem Ipsum available.
                                    <br>
                                    <small class="text-muted">Today 4:21 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a2.jp') }}g">
                                </div>
                                <div class="media-body">
                                    The point of using Lorem Ipsum is that it has a more-or-less normal.
                                    <br>
                                    <small class="text-muted">Yesterday 2:45 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a3.jp') }}g">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    Mevolved over the years, sometimes by accident, sometimes on purpose (injected
                                    humour and the like).
                                    <br>
                                    <small class="text-muted">Yesterday 1:10 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a4.jp') }}g">
                                </div>

                                <div class="media-body">
                                    Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                    <br>
                                    <small class="text-muted">Monday 8:37 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a8.jp') }}g">
                                </div>
                                <div class="media-body">

                                    All the Lorem Ipsum generators on the Internet tend to repeat.
                                    <br>
                                    <small class="text-muted">Today 4:21 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a7.jp') }}g">
                                </div>
                                <div class="media-body">
                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes
                                    from a line in section 1.10.32.
                                    <br>
                                    <small class="text-muted">Yesterday 2:45 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a3.jp') }}g">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                    <br>
                                    <small class="text-muted">Yesterday 1:10 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="float-left text-center">
                                    <img alt="image" class="rounded-circle message-avatar"
                                        src="{{ asset('/inspinia/img/a4.jp') }}g">
                                </div>
                                <div class="media-body">
                                    Uncover many web sites still in their infancy. Various versions have.
                                    <br>
                                    <small class="text-muted">Monday 8:37 pm</small>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <div id="tab-2" class="tab-pane">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                    </div>

                    <ul class="sidebar-list">
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Business valuation</h4>
                                It is a long established fact that a reader will be distracted.

                                <div class="small">Completion with: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Contract with Company </h4>
                                Many desktop publishing packages and web page editors.

                                <div class="small">Completion with: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Meeting</h4>
                                By the readable content of a page when looking at its layout.

                                <div class="small">Completion with: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary float-right">NEW</span>
                                <h4>The generated</h4>
                                There are many variations of passages of Lorem Ipsum available.
                                <div class="small">Completion with: 22%</div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Business valuation</h4>
                                It is a long established fact that a reader will be distracted.

                                <div class="small">Completion with: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Contract with Company </h4>
                                Many desktop publishing packages and web page editors.

                                <div class="small">Completion with: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Meeting</h4>
                                By the readable content of a page when looking at its layout.

                                <div class="small">Completion with: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary float-right">NEW</span>
                                <h4>The generated</h4>
                                <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                There are many variations of passages of Lorem Ipsum available.
                                <div class="small">Completion with: 22%</div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>

                    </ul>

                </div>

                <div id="tab-3" class="tab-pane">

                    <div class="sidebar-title">
                        <h3><i class="fa fa-gears"></i> Settings</h3>
                        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                    </div>

                    <div class="setings-item">
                        <span>
                            Show notifications
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                <label class="onoffswitch-label" for="example">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Disable Chat
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox"
                                    id="example2">
                                <label class="onoffswitch-label" for="example2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Enable history
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                <label class="onoffswitch-label" for="example3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Show charts
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                <label class="onoffswitch-label" for="example4">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Offline users
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                    id="example5">
                                <label class="onoffswitch-label" for="example5">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Global search
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                    id="example6">
                                <label class="onoffswitch-label" for="example6">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            Update everyday
                        </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                <label class="onoffswitch-label" for="example7">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <h4>Settings</h4>
                        <div class="small">
                            I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                            the 1500s.
                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('/inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/popper.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js') }}/bootstrap.js"></script>
    <script src="{{ asset('/inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.full.min.js')}}"></script>

    {{-- DataTables --}}
    <script src="{{ asset('/inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.dataTables-examplee').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

    <!-- Flot -->
    <script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/flot/jquery.flot.pie.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('/inspinia/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('/inspinia/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- GITTER -->
    <script src="{{ asset('/inspinia/js/plugins/gritter/jquery.gritter.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('/inspinia/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('/inspinia/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('/inspinia/js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('/inspinia/js/plugins/toastr/toastr.min.js') }}"></script>




    @stack('scripts')
</body>

</html>
