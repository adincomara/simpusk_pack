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

    <title>KIA | @yield('title')</title>
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
                    <a class="btn redirect" href="{{route('manage.beranda.ptm')}}">PTM</a>
                    <a class="btn redirect active" href="{{route('manage.beranda.kia')}}">KIA</a>
                </li>
            </div>

            <li class="{{  request()->routeIs('manage.beranda.kia') ? 'active' : '' }}">
                <a href="{{ route('manage.beranda.kia') }}"><i class="fa fa-home" style="font-size:16px"
                        aria-hidden="true"></i> <span class="nav-label">Beranda</span></a>
            </li>

            <li class="{{  request()->routeIs('datadasar.index') ? 'active' : '' }}">
                <a href="{{ route('datadasar.index') }}"><i class="fa fa-database" style="font-size:16px"
                        aria-hidden="true"></i> <span class="nav-label">Data Dasar</span></a>
            </li>

            <li
                class="{{  request()->routeIs('anc.index') || request()->routeIs('kematian_ibu.index') || request()->routeIs('komplikasi_ibu.index') || request()->routeIs('pws.index') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-female" style="font-size:16px"></i> <span class="nav-label">Kesehatan
                        Ibu</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('anc.index') ? 'active' : '' }}"><a
                            href="{{ route('anc.index') }}">ANC Terintegrasi</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('kematian_ibu.index') ? 'active' : '' }}"><a
                            href="{{ route('kematian_ibu.index') }}">Kematian Ibu</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('komplikasi_ibu.index') ? 'active' : '' }}"><a
                            href="{{ route('komplikasi_ibu.index') }}">Komplikasi Ibu</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('pws.index') ? 'active' : '' }}"><a href="
                        {{ route('pws.index') }}">PWS</a></li>
                </ul>
            </li>

            <li
                class="{{  request()->routeIs('cakupan_program_a.index') || request()->routeIs('cakupan_program_b.index') || request()->routeIs('cakupan_program_c.index') || request()->routeIs('data_sarana_program.index') || request()->routeIs('kematian_bayi_lh.index') || request()->routeIs('sdm_program_anak.index') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-child" style="font-size:16px"></i> <span class="nav-label">Kesehatan
                        Anak</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('cakupan_program_a.index') ? 'active' : '' }}"><a href="
                        {{ route('cakupan_program_a.index') }}">Cakupan Program 1</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('cakupan_program_b.index') ? 'active' : '' }}"><a
                            href="{{ route('cakupan_program_b.index') }}">Cakupan Program 2</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('cakupan_program_c.index') ? 'active' : '' }}"><a
                            href="{{ route('cakupan_program_c.index') }}">Cakupan Program 3</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('data_sarana_program.index') ? 'active' : '' }}"><a
                            href="{{ route('data_sarana_program.index') }}">Data Sarana Program</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('kematian_bayi_lh.index') ? 'active' : '' }}"><a
                            href="{{ route('kematian_bayi_lh.index') }}">Kematian Bayi dan Lahir Hidup</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('sdm_program_anak.index') ? 'active' : '' }}"><a
                            href="{{ route('sdm_program_anak.index') }}">SDM Program Anak</a></li>
                </ul>
            </li>

            <li
                class="{{  request()->routeIs('bufas_vitamin_a.index') || request()->routeIs('bumil_fe_1.index') || request()->routeIs('bumil_fe_3.index') || request()->routeIs('dukun_bayi.index') || request()->routeIs('ibu_bersalin.index') || request()->routeIs('kehamilan_tidak_diinginkan.index') || request()->routeIs('kunjungan_nifas.index')|| request()->routeIs('persalinan_nakes.index')|| request()->routeIs('status_tt_bumil.index') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-bed" style="font-size:16px"></i> <span class="nav-label">Menu
                        Lainnya</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('bufas_vitamin_a.index') ? 'active' : '' }}"><a
                            href="{{ route('bufas_vitamin_a.index') }}">Bufas Vitamin A</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('bumil_fe_1.index') ? 'active' : '' }}"><a
                            href="{{ route('bumil_fe_1.index') }}">Bumil Mendapatkan Fe 1</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('bumil_fe_3.index') ? 'active' : '' }}"><a
                            href="{{ route('bumil_fe_3.index') }}">Bumil Mendapatkan Fe 3</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('dukun_bayi.index') ? 'active' : '' }}"><a
                            href="{{ route('dukun_bayi.index') }}">Dukun Bayi</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('ibu_bersalin.index') ? 'active' : '' }}"><a
                            href="{{ route('ibu_bersalin.index') }}">Ibu Bersalin</a></li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('kehamilan_tidak_diinginkan.index') ? 'active' : '' }}"><a
                            href="{{ route('kehamilan_tidak_diinginkan.index') }}">Kehamilan Yang tidak diinginkan</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('kunjungan_nifas.index') ? 'active' : '' }}"><a
                            href="{{ route('kunjungan_nifas.index') }}">Kunjungan Nifas</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('persalinan_nakes.index') ? 'active' : '' }}"><a
                            href="{{ route('persalinan_nakes.index') }}">Persalinan Nakes</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{  request()->routeIs('status_tt_bumil.index') ? 'active' : '' }}"><a
                            href="{{ route('status_tt_bumil.index') }}">Status TT Bumil</a>
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

        @yield('konten_kia')

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
    @stack('scripts')
</body>

</html>
