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

    <title>PTM & KESWA | @yield('title')</title>
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

    <!-- datepicker -->
    <link href="{{ asset('/inspinia/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

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
                    <a class="btn redirect" href="{{route('manage.beranda')}}">SIMPUSK</a>
                    <a class="btn redirect active" href="{{route('manage.beranda.ptm')}}">PTM</a>
                    <a class="btn redirect" href="{{route('manage.beranda.kia')}}">KIA</a>
                </li>
            </div>

            <li class="{{  request()->routeIs('manage.beranda.ptm') ? 'active' : '' }}">
                <a href="{{ route('manage.beranda.ptm') }}"><i class="fa fa-home" style="font-size:16px"
                        aria-hidden="true"></i> <span class="nav-label">Beranda</span></a>
            </li>

            <li
                class="{{ Route::currentRouteName() === 'kasus_ptm.index' || Route::currentRouteName() === 'kasus_indera.index' || Route::currentRouteName() === 'kasus_jiwa.index'  || Route::currentRouteName() === 'napza.index'? 'active' : '' }}">
                <a href=" #"><i class="fa fa-newspaper"></i> <span class="nav-label">Kasus</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() === 'kasus_ptm.index' ? 'active' : '' }}"><a
                            href="{{route('kasus_ptm.index')}}">Kasus PTM</a></li>
                    <li class="{{ Route::currentRouteName() === 'kasus_indera.index' ? 'active' : '' }}"><a
                            href="{{route('kasus_indera.index')}}">Kasus Gangguan Penglihatan & Pendengaran</a></li>
                    <li class="{{ Route::currentRouteName() === 'kasus_jiwa.index' ? 'active' : '' }}"><a
                            href="{{route('kasus_jiwa.index')}}">Kasus Gangguan Jiwa</a></li>
                </ul>
            </li>
            <li
                class="{{Route::currentRouteName() === 'dd_fr_ptm_keswa.index'  || Route::currentRouteName() === 'dd_sdq.index' || Route::currentRouteName() === 'dd_assist.index' || Route::currentRouteName() === 'dd_pandu.index' || Route::currentRouteName() === 'dd_ubm.index' || Route::currentRouteName() === 'form_d.index' || Route::currentRouteName() === 'form_e.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-stethoscope"></i> <span class="nav-label">Deteksi Dini</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() === 'dd_fr_ptm_keswa.index' ? 'active' : '' }}"><a
                            href="{{route('dd_fr_ptm_keswa.index')}}">Deteksi Dini Faktor Risiko PTM & KESWA</a></li>
                    <li class="{{ Route::currentRouteName() === 'dd_sdq.index' ? 'active' : '' }}"><a
                            href="{{route('dd_sdq.index')}}">SDQ</a></li>
                    <li class="{{ Route::currentRouteName() === 'dd_assist.index' ? 'active' : '' }}"><a
                            href="{{route('dd_assist.index')}}">ASSIST</a></li>
                    <li class="{{ Route::currentRouteName() === 'dd_pandu.index' ? 'active' : '' }}"><a
                            href="{{route('dd_pandu.index')}}">PANDU PTM diFKTP</a></li>
                    <li
                        class="{{Route::currentRouteName() === 'form_d.index' || Route::currentRouteName() === 'form_e.index' ? 'active' : '' }}">
                        <a href=" #"><span class="nav-label">IVA SADANIS</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li class="{{ Route::currentRouteName() === 'form_d.index' ? 'active' : '' }}"><a
                                    href="{{route('form_d.index')}}">Form D</a></li>
                            <li class="{{ Route::currentRouteName() === 'form_e.index' ? 'active' : '' }}"><a
                                    href="{{route('form_e.index')}}">Form E</a></li>
                        </ul>
                    </li>
                    <li class="{{ Route::currentRouteName() === 'dd_ubm.index' ? 'active' : '' }}"><a
                            href="{{route('dd_ubm.index')}}">Rekapitulasi UBM</a></li>
                </ul>
            </li>
            <li class="{{ Route::currentRouteName() === 'indikator_spm.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-chart-line"></i> <span class="nav-label">Indikator</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() === 'indikator_spm.index' ? 'active' : '' }}"><a
                            href="{{route('indikator_spm.index')}}">SPM</a></li>
                </ul>
            </li>
            <li class="{{ Route::currentRouteName() === 'profil_sdm.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-bars"></i> <span class="nav-label">Profil</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() === 'profil_sdm.index' ? 'active' : '' }}"><a
                            href="{{route('profil_sdm.index')}}">SDM Terlatih</a></li>
                </ul>
            </li>
            <li
                class="{{ Route::currentRouteName() === 'analisa_kasus_ptm.index' || Route::currentRouteName() === 'analisa_kasus_ptm_usia.index' || Route::currentRouteName() === 'analisa_kasus_ptm_jenis_kelamin.index' || Route::currentRouteName() === 'analisa_kasus_jiwa.index' || Route::currentRouteName() === 'analisa_kasus_jiwa_usia.index' || Route::currentRouteName() === 'analisa_kasus_jiwa_jenis_kelamin.index' || Route::currentRouteName() === 'analisa_penglihatan_pendengaran.index' || Route::currentRouteName() === 'analisa_hasil_charta.index' || Route::currentRouteName() === 'analisa_faktor_risiko.index' || Route::currentRouteName() === 'analisa_temuan_iva.index' || Route::currentRouteName() === 'analisa_temuan_sadanis.index' || Route::currentRouteName() === 'analisa_temuan_ivakrio.index' ? 'active' : '' }}">
                <a href=" #"><i class="fa fa-chart-area"></i> <span class="nav-label">Analisa</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() === 'analisa_kasus_ptm.index' ? 'active' : '' }}"><a
                            href="{{route('analisa_kasus_ptm.index')}}">Kasus PTM</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_kasus_ptm_usia.index' ? 'active' : '' }}"><a
                            href="{{route('analisa_kasus_ptm_usia.index')}}">Kasus PTM berdasrakan golongan umur</a>
                    </li>
                    <li
                        class="{{ Route::currentRouteName() === 'analisa_kasus_ptm_jenis_kelamin.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_kasus_ptm_jenis_kelamin.index')}}">Kasus PTM berdasarkan jenis
                            kelamin</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_kasus_jiwa.index' ? 'active' : '' }}"><a
                            href="{{route('analisa_kasus_jiwa.index')}}">Kasus Ganguan Jiwa</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_kasus_jiwa_usia.index' ? 'active' : '' }}"><a
                            href="{{route('analisa_kasus_jiwa_usia.index')}}">Kasus Ganguan Jiwa berdasrakan golongan
                            umur</a>
                    </li>
                    <li
                        class="{{ Route::currentRouteName() === 'analisa_kasus_jiwa_jenis_kelamin.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_kasus_jiwa_jenis_kelamin.index')}}">Kasus Ganguan Jiwa berdasarkan
                            jenis
                            kelamin</a></li>
                    <li
                        class="{{ Route::currentRouteName() === 'analisa_penglihatan_pendengaran.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_penglihatan_pendengaran.index')}}">Gangguan Penglihatan dan
                            Pendengaran</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_hasil_charta.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_hasil_charta.index')}}">Hasil Prediksi Charta PANDU</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_faktor_risiko.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_faktor_risiko.index')}}">Faktor Risiko PTM</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_temuan_iva.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_temuan_iva.index')}}">Hasil Temuan Pemeriksaan IVA</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_temuan_sadanis.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_temuan_sadanis.index')}}">Hasil Temuan Pemeriksaan SADANIS</a></li>
                    <li class="{{ Route::currentRouteName() === 'analisa_temuan_ivakrio.index' ? 'active' : '' }}">
                        <a href="{{route('analisa_temuan_ivakrio.index')}}">Temuan IVA (+) dan Tindakan Kriotherapi</a>
                    </li>
                </ul>
            </li>
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

        @yield('konten_ptm')

        <div class="footer">
            <div>
                <strong>2022</strong>© SIMPUS Support By <a href="#" style="color: red">Puskesmas Jepang</a>
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

    <!-- Toastr -->
    <script src="{{ asset('/inspinia/js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- iCheck -->
    <script src="{{ asset('/inspinia/js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{ asset('/inspinia/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('/inspinia/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- Sweet alert -->
    <script src="{{ asset('/inspinia/js/plugins/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('/inspinia/js/chart.min.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('/inspinia/js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Data picker -->
    <script src="{{ asset('/inspinia/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('/inspinia/js/plugins/fullcalendar/moment.min.js')}}"></script>

    <!-- Date range picker -->
    <script src="{{ asset('/inspinia/js/plugins/daterangepicker/daterangepicker.js')}}"></script>

    <script type="text/javascript"
        src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js">
    </script>
    <script src="{{ asset('/inspinia/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js')}}">
    </script>
    <script src="{{ asset('/inspinia/js/plugins/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
    <script>
        import {Chart} from 'chart.js';
            import ChartDataLabels from 'chartjs-plugin-datalabels';
    </script>
    @stack('scripts')
</body>

</html>
