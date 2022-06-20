<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nomor Antrian Puskesmas</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="{{ asset('/inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/inspinia/css/style.css') }}" rel="stylesheet">
</head>

<body id="page-top" class="landing-page no-skin-config">
    <div class="header">
        <nav class="bg-dark">
            <div class="container-fluid ">
                <div class="row my-auto">
                    <nav class="navbar navbar-dark bg-danavbar-dark">
                        <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="logo_puskesmas" style="height: 70px;" class="" />
                        <h1 class="text-white font-weight-bold mt-3 m-l-lg">PUSKESMAS KUDUS</h1>
                    </nav>
                    <div class="col-lg-8 text-left my-auto">
                        <h2 class="text-white font-weight-bold">
                            <marquee behavior="" direction="">
                                Syarat pendaftaran Puskesmas KTP Asli - Istirahat Pukul
                                12.00-1300
                            </marquee>
                        </h2>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <section id="pricing" class="">
        <div class="container-fluid">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1 class="font-weight-bold"> NOMOR ANTRIAN</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-center my-auto">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/HT4k8PxJMf4"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row" id="allpoli">
                        <div class="col-lg-6">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading">
                                    <h1 class="font-weight-bold">Poli Gami</h1>
                                </div>
                                <div class="panel-body">
                                    <h1 class="font-weight-bold" style="font-size: 100px;" id="nomor_poli1">
                                        20
                                        <div class="navy-line mt-0"></div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading">
                                    <h1 class="font-weight-bold">Poli Gami</h1>
                                </div>
                                <div class="panel-body">
                                    <h1 class="font-weight-bold" style="font-size: 100px;">
                                        20
                                        <div class="navy-line mt-0"></div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading">
                                    <h1 class="font-weight-bold">Poli Gami</h1>
                                </div>
                                <div class="panel-body">
                                    <h1 class="font-weight-bold" style="font-size: 100px;">
                                        20
                                        <div class="navy-line mt-0"></div>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading">
                                    <h1 class="font-weight-bold">Poli Gami</h1>
                                </div>
                                <div class="panel-body">
                                    <h1 class="font-weight-bold" style="font-size: 100px;">
                                        20
                                        <div class="navy-line mt-0"></div>
                                    </h1>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="contact" class="gray-section contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center m-t-lg m-b-lg">
                    <p><strong>&copy; 2021 Puskesmas Kudus</strong><br /> support by <span class="text-info">Rapier
                            Teknologi Nasional</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mainly scripts -->
    <script src="{{ asset('/inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/popper.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('/inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/wow/wow.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script>
        var i = 1;
        $(document).ready(function(){

            allpoli();

            // $('#nomor_poli1').text('1');
        });
        function allpoli(){
            $('#allpoli').html('');
            $.ajax({
                type: 'GET',
                url: '{{route("getallpoli")}}',
                success: function(data){
                    // console.log(data);
                    for(i=0;i<data.length;i++){
                        $('#allpoli').append('<div class="col-lg-6">'
                            +'<div class="panel panel-primary text-center">'
                                +'<div class="panel-heading">'
                                    +'<h1 class="font-weight-bold">'+data[i].nama_poli+'</h1>'
                                +'</div>'
                                +'<div class="panel-body">'
                                    +'<h1 class="font-weight-bold" style="font-size: 100px;" id="nomor_poli'+data[i].kdpoli+'">'
                                        +'0'
                                        +'<div class="navy-line mt-0"></div>'
                                    +'</h1>'
                                +'</div>'
                            +'</div>'
                        +'</div>')
                    }
                    time();
                },
                error: function(data){
                    console.log(data);
                    Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                }
            });
        }
        function time(){
                setTimeout(function () {
                    $.ajax({
                        type: 'GET',
                        url: '{{route("getDataOperator")}}',
                        success: function(data){
                            for(i=0;i<data.length;i++){
                                $('#nomor_poli'+data[i].poli.kdpoli).text(data[i].antrian);
                            }
                            console.log(data);
                        },
                        error: function(data){
                            console.log(data);
                            Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                        }
                    });
                    time();
                }, 1500);

            }

    </script>



</body>

</html>
