<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KOISKA | PENDAFTARANs</title>

    <link href="{{ asset('/kiosk/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/kiosk/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('/kiosk/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/kiosk/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/kiosk/css/style.css') }}" rel="stylesheet">

</head>

<style>
    h3 {
        color: #E7F6F2;
    }
</style>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" style="background-color: #2C3333;">
            <div class="wrapper wrapper-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                                <!-- <a href="kioska_dashboard.html" style="color: #E7F6F2;"> <i
                                        class="fa fa-angle-double-left" aria-hidden="true"></i> Kembali</a> -->
                            </div>
                            <h1 class="text-bold" style="font-size: 50px; color: #E7F6F2; font-weight: 500">PENDAFTARAN
                            </h1>
                            <h2 class="" style="color: #E7F6F2;">Selamat datang di UPTD Puskesmas Jepang</h2>
                        </div>
                    </div>
                    <hr style="background-color:#E7F6F2;">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget style1 bg-white">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <i class="fa fa-drivers-license fa-3x text-navy pr-2 my-auto"></i>
                                        <h2 class="font-bold mb-2 text-primary ">BPJS</h2>
                                        <a type="button" href="{{ route('antrian.pendaftaran_bpjs') }}"
                                            class="ml-auto my-auto btn btn-primary b-r-xl">
                                            Klik disini ! </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 bg-white">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <i class="fa fa-user fa-3x text-danger pr-2 my-auto"></i>
                                        <h2 class="font-bold mb-2 text-primary ">UMUM</h2>
                                        <a type="button" href="{{ route('antrian.pendaftaran_umum') }}"
                                            class="ml-auto my-auto btn btn-danger b-r-xl">
                                            Klik disini ! </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 bg-white">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <i class="fa fa-gear fa-3x text-warning pr-2 my-auto"></i>
                                        <h2 class="font-bold mb-2 text-primary ">SETTING</h2>
                                        <a type="button" href="{{ route('antrian.setting') }}"
                                            class="ml-auto my-auto btn btn-warning b-r-xl">
                                            Klik disini ! </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" style=" background-color: #A5C9CA;">
                <div class="float-right">

                </div>
                <div class="text-bold " style=" color: #2C3333;">
                    <strong>Copyright</strong><span class="text-danger">
                        Rapier
                        Teknologi
                        Nasional </span> &copy;
                    2022
                </div>
            </div>

        </div>
    </div>



    <!-- Mainly scripts -->
    <script src="{{ asset('/kiosk/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/popper.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/kiosk/js/inspinia.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/pace/pace.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('/kiosk/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/flot/jquery.flot.resize.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('/kiosk/js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('/kiosk/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- Peity demo -->
    <script src="{{ asset('/kiosk/js/demo/peity-demo.js') }}"></script>


    <script>
        $(document).ready(function () {



        });
    </script>

</body>

</html>
