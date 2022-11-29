<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KOISKA | DASHBOARD</title>

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

    <link href="{{ asset('/kiosk/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
        rel="stylesheet">

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

<body class="top-navigation"
    style="background: url('{{ asset('assets/img/bg13.png') }}') no-repeat; background-size:100%;">

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="wrapper wrapper-content">
                <div class="container">
                    <div class="d-flex">
                        <div class="p-0 my-auto pr-3">
                            <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="" width="90px">
                        </div>
                        <div class="p-0">
                            <h1 class="text-bold text-navy" style="font-size: 40px;">DASHBOARD</h1>
                            <h2>Selamat datang di UPTD Puskesmas Kudus</h2>
                        </div>
                        <!-- <div class="p-0 ml-auto my-auto">
                            <img src="img/logo-kudus.png" alt="" width="80px">
                        </div> -->
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-ticket fa-5x"></i>
                                    </div>
                                    <div class="col-8 text-right" style="height: 80px">
                                        <h3 class="font-bold mb-2">PENDAFTARAN</h3>
                                        <a type="button" href="{{ route('antrian.ambil_antrian') }}"
                                            class="btn btn-white b-r-xl"
                                            style="padding: 5px 45px 5px 45px ; color: #395B64;">
                                            Klik disini ! </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('antrian.petugas_panggil') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="widget style1 yellow-bg">
                                    <div class="row">
                                        <div class="col-4">
                                            <i class="fa fa-bullhorn fa-5x"></i>
                                        </div>
                                        <div class="col-8 text-right" style="height: 80px">
                                            <h3 class="font-bold mb-2">PETUGAS PANGGIL</h3>
                                            <button type="button" class="btn btn-outline" id="bt_panggil">
                                                <i class="fa fa-caret-down fa-2x"></i>
                                            </button>
                                        </div>

                                        <div class="col-lg-12  row mx-auto" id="div_panggil" style="display:none">
                                            <div class="col-lg-12 pt-3">
                                                <select class="select2_poli form-control" id="panggil_poli" name="poli"
                                                    style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach($poli as $key => $value)
                                                    <option value="{{ $value['kdpoli'] }}">{{ $value['nama_poli'] }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-12 pt-3">
                                                <select class="select2_dokter form-control" id="panggil_dokter"
                                                    name="dokter" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach($dokter as $key => $value)
                                                    <option value="{{ $value['kdDokter'] }}">{{ $value['nmDokter'] }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-12 text-center pt-3">
                                                <button type="submit" class="btn btn-white b-r-xl"
                                                    style="color: #395B64;">
                                                    Klik disini ! </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 bg-danger">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fa fa-desktop fa-5x"></i>
                                    </div>
                                    <div class="col-8 text-right" style="height: 80px">
                                        <h3 class="font-bold mb-2">DISPLAY</h3>
                                        <a type="button" href="{{ route('antrian.display') }}"
                                            class="btn btn-white b-r-xl"
                                            style="padding: 5px 45px 5px 45px ; color: #395B64;">
                                            Klik disini ! </a>
                                        {{-- <button class="btn btn-outline" id="bt_display">
                                            <i class="fa fa-caret-down fa-2x"></i>
                                        </button> --}}
                                    </div>
                                    <div class="col-lg-12  row mx-auto" id="div_display" style="display:none;">
                                        <div class="col-lg-12 pt-3">
                                            <select class="select2_poli form-control" id="display_poli"
                                                style="width: 100%">
                                                <option></option>
                                                @foreach($poli as $key => $value)
                                                <option value="{{ $value['kdpoli'] }}">{{ $value['nama_poli'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 pt-3">
                                            <select class="select2_dokter form-control" id="display_dokter"
                                                style="width: 100%">
                                                <option></option>
                                                @foreach($dokter as $key => $value)
                                                <option value="{{ $value['kdDokter'] }}">{{ $value['nmDokter'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 text-center pt-3">
                                            <a type="button" href="{{ route('antrian.display') }}"
                                                class="btn btn-white b-r-xl" style="color: #395B64;">
                                                Klik disini ! </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="footer" style=" background-color: #E7F6F2;">
                <div class="float-right">

                </div>
                <div class="text-bold">
                    <strong style="color: #395B64;">Copyright</strong><span class="text-danger" style=""> Rapier
                        Teknologi
                        Nasional </span> &copy;
                    2022
                </div>
            </div> --}}

        </div>
    </div>



    <!-- Mainly scripts -->
    <script src="{{ asset('/kiosk/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/popper.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/bootstrap.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/kiosk/js/inspinia.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Chosen -->
    <script src="{{ asset('/kiosk/js/plugins/chosen/chosen.jquery.js') }}"></script>

    <!-- JSKnob -->
    <script src="{{ asset('/kiosk/js/plugins/jsKnob/jquery.knob.js') }}"></script>

    <!-- Input Mask-->
    <script src="{{ asset('/kiosk/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <!-- Data picker -->
    <script src="{{ asset('/kiosk/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <!-- NouSlider -->
    <script src="{{ asset('/kiosk/js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>

    <!-- Switchery -->
    <script src="{{ asset('/kiosk/js/plugins/switchery/switchery.js') }}"></script>

    <!-- IonRangeSlider -->
    <script src="{{ asset('/kiosk/js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('/kiosk/js/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- MENU -->
    <script src="{{ asset('/kiosk/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

    <!-- Color picker -->
    <script src="{{ asset('/kiosk/js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>

    <!-- Clock picker -->
    <script src="{{ asset('/kiosk/js/plugins/clockpicker/clockpicker.js') }}"></script>

    <!-- Image cropper -->
    <script src="{{ asset('/kiosk/js/plugins/cropper/cropper.min.js') }}"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('/kiosk/js/plugins/fullcalendar/moment.min.js') }}"></script>

    <!-- Date range picker -->
    <script src="{{ asset('/kiosk/js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('/kiosk/js/plugins/select2/select2.full.min.js') }}"></script>

    <!-- TouchSpin -->
    <script src="{{ asset('/kiosk/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <!-- Tags Input -->
    <script src="{{ asset('/kiosk/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

    <!-- Dual Listbox -->
    <script src="{{ asset('/kiosk/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('.chosen-select').chosen({
                width: "100%"
            });
            $(".select2_poli").select2({
                placeholder: "SEMUA POLI!!!",
                allowClear: true
            });
            $(".select2_dokter").select2({
                placeholder: "SEMUA DOKTER!!!",
                allowClear: true
            });


        });
        $('#bt_display').click(function(){
            let dis = $('#div_display').css("display");
            if(dis == 'none'){
                $('#div_display').css("display", 'block');
            }else{
                $('#div_display').css("display", 'none');
            }

        });
        $('#bt_panggil').click(function(){
            let dis = $('#div_panggil').css("display");
            if(dis == 'none'){
                $('#div_panggil').css("display", 'block');
            }else{
                $('#div_panggil').css("display", 'none');
            }
        });
    </script>

</body>

</html>
