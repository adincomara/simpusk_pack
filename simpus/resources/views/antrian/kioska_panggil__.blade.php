<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KIOSKA | PANGGIL</title>

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
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css')}}">


</head>

<body>
    <div class="top-navigation">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">
                    <!--<div class="navbar-header">-->
                    <!--<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">-->
                    <!--<i class="fa fa-reorder"></i>-->
                    <!--</button>-->

                    <div class="mx-auto text-center row">
                        <img src="img/logo-puskesmas.png" class="py-2" alt="" width="70px">
                        <h3 class="pt-2 my-auto pl-2 font-bold">SISTEM INFORMASI UPTD PUSKESMAS JEPANG</h3>
                    </div>
                </nav>
            </div>
            <div class="wrapper wrapper-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="ibox ">
                                <div class="ibox-content b-r-lg bg-primary">
                                    <h3 class="font-bold text-center">NOMOR ANTRIAN</h3>
                                </div>
                                <div class="ibox-content b-r-lg mt-1">
                                    <div class="m-t-md">
                                        <h1 class="text-center font-bold py-2" style="font-size: 70px;" id="no_antrian">{{ $antrian_now }}</h1>
                                    </div>
                                </div>
                                <div class="ibox-content b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <p class="stats-label font-bold">Dokter</p>
                                            <h2>{{ $dokter->nmDokter }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">Poli Tujuan</p>
                                            <h2>{{ $poli->nama_poli }}</h2>
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">Nomor Rekam Medis</p>
                                            <h2 id="no_rekamedis">{{ ($pasien != null)? $pasien->no_rekamedis : '-' }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">Waktu Daftar</p>
                                            <h2 id="waktu_daftar"> {{ ($pendaftaran != null)? date('H:i:s', strtotime($pendaftaran->created_at)).' WIB' : '-' }} </h2>
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">Waktu Panggil</p>
                                            <h2 id="waktu_panggil">{{ ($antrian->waktu_panggil != null)? date('H:i:s', strtotime($antrian->waktu_panggil)). ' WIB' : '-' }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">NIK</p>
                                            <h2 id="nik">{{ ($pasien != null)? $pasien->no_ktp : '-' }}</h2>
                                        </div>
                                        <div class="col-6 text-center">
                                            <p class="stats-label font-bold">Nama</p>
                                            <h2 id="nama_pasien">{{ ($pasien != null)? $pasien->nama_pasien : '-' }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox">
                                <div class="ibox-content b-r-lg">
                                    <div class="col-sm-12 text-left">
                                        {{-- <div class="row">
                                            <div class="col-sm-3">
                                                <label for="">Antiran</label>
                                            </div>
                                            <div class="col-sm-8 text-left font-bold">
                                                <div class="form-group">
                                                    <div class="i-checks col-md">
                                                        <label class=""> <input type="radio" checked="" value="option1"
                                                                name="a">
                                                            <i></i> Normal
                                                        </label>
                                                    </div>
                                                    <div class="i-checks col-md">
                                                        <label> <input type="radio" value="option2" name="a">
                                                            <i></i> Prioritas
                                                        </label>
                                                    </div>
                                                    <div class="i-checks col-md">
                                                        <label> <input type="radio" value="option2" name="a">
                                                            <i></i> Skip
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="form-group">
                                            <select class="select2_poli form-control" id="poli" {{ ($selectedPoli != '')? 'disabled' : ''}}>
                                                <option></option>
                                                <option value="{{ $poli->kdpoli }}" {{ ($poli->kdpoli == $selectedPoli)? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
                                                {{-- @foreach($poli as $key => $value)
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="select2_dokter form-control" id="dokter" {{ ($selectedDokter != '')? 'disabled' : ''}}>
                                                <option></option>
                                                <option value="{{ $dokter->kdDokter }}" {{ ($dokter->kdDokter == $selectedDokter)? 'selected' : '' }}>{{ $dokter->nmDokter }}</option>
                                                {{-- @foreach($dokter as $key => $value)
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="text-center">

                                            <button class="btn btn-primary " type="button" onclick="panggil()" id="panggil_ulang"><i
                                                    class="fa fa-refresh"></i>&nbsp;Panggil Ulang</button>
                                            <button class="btn btn-danger " type="button" onclick="antrian_selanjutnya()"><i
                                                    class="fa fa-bullhorn"></i>&nbsp;Panggil Antian Selanjutnya</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="ibox">
                                <div class="ibox-content  b-r-lg">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>POLI UMUM 1</h4>
                                            <p class="stats-label">dr.Comara</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="stats-label">07.00 <span> - </span></p>
                                            <p class="stats-label">10.00</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content  b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>POLI UMUM 2</h4>
                                            <p class="stats-label">dr.Comara</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="stats-label">07.00 <span> - </span></p>
                                            <p class="stats-label">10.00</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content  b-r-lg mt-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>POLI UMUM 3</h4>
                                            <p class="stats-label">dr.Comara</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="stats-label">07.00 <span> - </span></p>
                                            <p class="stats-label">10.00</p>
                                        </div>
                                    </div>
                                </div>

                            </div> --}}
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="{{ asset('/kiosk/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/popper.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.js')}}"></script>


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

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

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
    </script>
    <script>
        function antrian_selanjutnya(){
            let antrian = $('#no_antrian').text();
            $.ajax({
                type: 'GET',
                url : "{{route('antrian.antrian_selanjutnya')}}/"+antrian,
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                dataType: "json",

                success: function(data){
                    if(data.success == true){
                        let d = new Date(data.pendaftaran.created_at);

                        $('#no_antrian').text(data.antrian.no_antrian);
                        $('#no_rekamedis').text(data.pasien.no_rekamedis);
                        // $('#waktu_daftar').text(data.pendaftaran.created_at);
                        $('#waktu_daftar').text(addZero(d.getHours())+':'+addZero(d.getMinutes())+':'+addZero(d.getSeconds())+' WIB');

                        panggil();

                    }else{
                        Swal.fire('Ups',data.message,'info');
                    }
                },
                complete: function () {
                    $('#btn_simpan').removeClass("disabled");
                },
                error: function(data){
                    $('#btn_simpan').removeClass("disabled");
                }
            });
        }
        function addZero(i) {
            if (i < 10) {i = "0" + i}
            return i;
        }
        function panggil(){
            let antrian = $('#no_antrian').text();
            $.ajax({
                type: 'GET',
                url : "{{route('antrian.panggil')}}/"+antrian,
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                dataType: "json",
                beforeSend: function(){
                    // $('#panggil_ulang').removeClass("disabled");
                    $('#panggil_ulang').prop("disabled", true);
                },
                success: function(data){
                    if(data.success == true){
                        let d = new Date(data.antrian.waktu_panggil);
                        $('#waktu_panggil').text(addZero(d.getHours())+':'+addZero(d.getMinutes())+':'+addZero(d.getSeconds())+' WIB');
                        antrian = antrian.toLowerCase();
                        antrian = antrian.split("");
                        let musik = [];
                        musik[0] = "{{ asset('/inspinia/musik/in.wav') }}";
                        musik[1] = "{{ asset('/inspinia/musik/antrian.wav') }}";
                        for(i=0, x=2 ; i<antrian.length; i++,x++){
                            musik[x] = "{{ asset('/inspinia/musik') }}/"+antrian[i]+".wav";
                        }
                        play(musik, 0);
                    }else{
                        Swal.fire('Ups',data.message,'info');
                    }
                },
                complete: function () {
                    // $('#panggil_ulang').removeClass("disabled");
                    // $('#panggil_ulang').prop("disabled", false);

                },
                error: function(data){
                    $('#btn_simpan').removeClass("disabled");
                }
            });

        }
        function play(musik, index){
            if(index == (musik.length)){
                $('#panggil_ulang').prop("disabled", false);
                return;
            }else{
                let audio = new Audio(musik[index]);
                audio.play();
                audio.addEventListener('ended', function(e){
                    index++;
                    play(musik,index);
                });
            }

        }
    </script>
</body>

</html>
