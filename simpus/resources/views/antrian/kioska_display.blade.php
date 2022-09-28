<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KIOSKA | DISPLAY</title>

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
    <style>
.marquee-wrapper{
  /* background:#2F394C; */
  text-align:center;
}
.marquee-wrapper .container{
  overflow:hidden;
  max-width: 50000px;
}
.marquee-inner span{
  float:left;
  width:50%;
}
.marquee-wrapper .marquee-block{
  --total-marquee-items:{{ count($poli) }};
  height: 150px;
  width: calc(280px * (var(--total-marquee-items)));
  overflow: hidden;
  box-sizing: border-box;
  position: relative;
  margin: 20px auto;
  background:#ffffff;
  padding: 30px 0;
  border-radius: 10px;
}
.marquee-inner{
  display: block;
  width: 200%;
  position: absolute;
}
.marquee-inner p{
  font-weight: 800;
  font-size: 30px;
  font-family: cursive;
}
.marquee-inner.to-left{
  animation: marqueeLeft 25s linear infinite;
}
.marquee-inner.to-right{
  animation: marqueeRight 25s linear infinite;
}
.marquee-item{
  width: 260px;
  height: 75px;
  display: inline-block;
  margin: 0 10px;
  float: left;
  transition: all .2s ease-out;
  /* background:#00cc00; */
  border-radius: 10px
}
@keyframes marqueeLeft{
  0% {
    left: 0;
  }
  100% {
    left: -100%;
  }
}
@keyframes marqueeRight{
  0% {
    left: -100%;
  }
  100% {
   left: 0;
  }
}
    </style>



</head>

<body>
    @php
$color[0] = 'black';
$color[1] = '#1c84c6';
$color[2] = '#23c6c8';
$color[3] = '#f8ac59';
$color[4] = '#1ab394';

@endphp
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
                                    <h3 class="font-bold text-center">ANTRIAN SEKARANG</h3>
                                </div>
                                <div class="ibox-content b-r-lg">
                                    <div class="m-t-md">
                                        <h1 class="text-center font-bold fadeInDown" id="no_antrian" style="font-size: 100px;">
                                            -</h1>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h2 id="poli_now">-</h2>
                                            {{-- <h3 class="stats-label font-bold">dr.Comara</h3> --}}
                                            <hr style="background-color:#1ab394;">
                                            <h1 class="font-bold" id="pasien_now">-</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <iframe width="100%" height="400px"
                                src="https://www.youtube.com/embed/INkcZrjRUvo">
                            </iframe>
                        </div>
                        <div class="col-lg-12">
                            {{-- <div class="ibox ">
                                <div class="ibox-content b-r-lg">
                                    <div class="row">
                                        <div class="col-md mx-1 text-center border bg-primary rounded">
                                            <h2 class="stats-label font-bold">A123</h2>
                                            <h3>POLI UMUM 1</h3>
                                        </div>
                                        <div class="col-md mx-1 text-center boder bg-success rounded">
                                            <h2 class="stats-label font-bold">B123</h2>
                                            <h3>POLI KIA 1</h3>
                                        </div>
                                        <div class="col-md mx-1 text-center boder bg-info rounded">
                                            <h2 class="stats-label font-bold">C1451</h2>
                                            <h3>POLI GIGI 1</h3>
                                        </div>
                                        <div class="col-md mx-1 text-center boder bg-warning rounded">
                                            <h2 class="stats-label font-bold">D1203</h2>
                                            <h3>POLI ANAK</h3>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="marquee-wrapper">
                                <div class="container">
                                    <div class="marquee-block">
                                        <div class="marquee-inner to-left">
                                            <span>
                                                @foreach($poli as $key => $value)
                                                    <div class="marquee-item" style="background: {{ $color[$key%5] }}">
                                                        <h2 class="stats-label font-bold text-white no_{{ $value->kdpoli }}" style="margin-top: 10px" id="">{{ $value->no_antrian }}</h2>
                                                        <h3 class="text-white" id="nm_{{ $value->kdpoli }}">{{ $value->nama_poli }}</h3>
                                                    </div>

                                                @endforeach
                                                {{-- <div class="marquee-item" style="background: #1c84c6 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div>
                                                <div class="marquee-item" style="background: #23c6c8 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div>
                                                <div class="marquee-item" style="background: #f8ac59 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div> --}}

                                            </span>
                                            <span>
                                                @foreach($poli as $key => $value)
                                                    <div class="marquee-item" style="background: {{ $color[$key%5] }}">
                                                        <h2 class="stats-label font-bold text-white no_{{ $value->kdpoli }}" style="margin-top: 10px" id="">{{ $value->no_antrian }}</h2>
                                                        <h3 class="text-white" id="nm_{{ $value->kdpoli }}">{{ $value->nama_poli }}</h3>
                                                    </div>

                                                @endforeach
                                                {{-- <div class="marquee-item" style="background:#1ab394 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div>
                                                <div class="marquee-item" style="background: #1c84c6 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div>
                                                <div class="marquee-item" style="background: #23c6c8 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div>
                                                <div class="marquee-item" style="background: #f8ac59 !important">
                                                    <h2 class="stats-label font-bold text-white" style="margin-top: 10px">A123</h2>
                                                    <h3 class="text-white">POLI UMUM 1</h3>
                                                </div> --}}

                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
    <script src="{{ asset('assets/js/jquery.validate.js')}}"></script>
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
    <script type='text/javascript' src='//cdn.jsdelivr.net/jquery.marquee/1.4.0/jquery.marquee.min.js'></script>


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
        $(document).ready(function(){
            $('.marquee').marquee({
                direction: 'left'
            });
            let z = 0;
            setInterval(() => {
                $.ajax({
                    type: 'GET',
                    url : "{{route('antrian.antrian_all')}}",
                    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                    dataType: "json",
                    success: function(data){
                        // console.log(data);
                        if(data.success == true){
                            for(i=0;i<data.poli.length;i++){
                                $('.no_'+data.poli[i].kdpoli).text(data.poli[i].no_antrian);
                            }
                            $('#no_antrian, #poli_now, #pasien_now').fadeOut('slow', function(){
                                $('#no_antrian').html(data.poli[z].no_antrian).fadeIn('slow');
                                $('#poli_now').html(data.poli[z].nama_poli ).fadeIn('slow');
                                $('#pasien_now').html(data.poli[z].pasien).fadeIn('slow');
                            });
                            // console.log(data.poli[z].no_antrian)
                            if(z == data.poli.length-1 || z >= data.poli.length-1){
                                z = 0;
                            }else{
                                z++;
                            }
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

            }, 5000);
        });
        // $(document).ready(function(){
        // })
    </script>
</body>

</html>
