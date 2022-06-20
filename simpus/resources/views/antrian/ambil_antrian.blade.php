
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>INSPINIA - Landing Page</title>

     <!-- Bootstrap core CSS -->
     <link href="{{ asset('/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">

     <!-- Animation CSS -->
     <link href="{{ asset('/inspinia/css/animate.css') }}" rel="stylesheet">
     <link href="{{ asset('/inspinia/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

     <!-- Custom styles for this template -->
     <link href="{{ asset('/inspinia/css/style.css') }}" rel="stylesheet">
     {{-- <script async src='/cdn-cgi/bm/cv/669835187/api.js'></script></head> --}}
    <style>
        /* .bg-header {
            background-size: 10%;
            background-image: url('img/logo-puskesmas.png');
            background-repeat: no-repeat;
            background-position: left;
        } */
    </style>
</head>

<body id="page-top" class="landing-page no-skin-config">


    <section class="container">
        <div class="row bg-header">
            <div class="col-lg-12 text-center row">
                <div class="col-lg-6 text-left row">
                    <div class="col-md-2">
                        <img src="{{ asset('assets/img/logo-puskesmas.png') }}" class="mt-4" style="width:100%;" alt="">
                    </div>
                    <div class="col-md">
                        <h1><span class="navy"> Sistem Puskesmas </span></h1>
                        <h3>Silahkan Mengambil Nomor Atrian Sesuai Dengan Jenis Loket Pendaftaran.</h3>
                    </div>
                </div>
                <div class="col-lg-6 text-right row">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-center  wow zoomIn">
                <img src="{{ asset('assets/img/team.png') }}" alt="dashboard" class="img-fluid">
                <div class="text-left">
                    <div class="col-md-12 row">
                        <div class="col-md-8">
                            <h1>Nomor Antrian : <span class="navy" id="antrian_now"> Silahkan ambil antrian</span></h1>
                            <h3>Poli : <span class="navy" id="poli_now">Silahkan ambil antrian</span></h3>
                        </div>
                        <div class="col-md-4 m-auto">
                            <button type="button" class="btn btn-success btn-sm" onclick="cetak()"><i class="fa fa-print text-white "></i>
                                Cetak Kartu</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 tabs-container">
                <div class="col-md-12 text-center wow fadeInLeft">
                    <div class="row">
                        <div class="col-md-6" id="poli_kiri">
                            {{-- <div class="card  mb-3">
                                <h1 style="font-size: 40px;" class="text-dark"><strong>A <span>01</span></strong></h1>
                                <h3>Poli Umum</h3>
                                <button class="btn btn-primary">
                                    <p class="text-white">
                                        <i class="fa fa-ticket features-icon text-white "></i>
                                        Klik disini !
                                    </p>
                                </button>
                            </div>
                            <div class="card mb-3">
                                <h1 style="font-size: 40px;" class="text-dark"><strong>B <span>01</span></strong></h1>
                                <h3>Poli Umum</h3>
                                <button class="btn btn-primary">
                                    <p class="text-white">
                                        <i class="fa fa-ticket features-icon text-white "></i>
                                        Klik disini !
                                    </p>
                                </button>
                            </div> --}}

                        </div>
                        <div class="col-md-6" id="poli_kanan">
                            {{-- <div class="card mb-3">
                                <h1 style="font-size: 40px;" class="text-dark"><strong>C <span>01</span></strong></h1>
                                <h3>Poli Umum</h3>
                                <button class="btn btn-primary">
                                    <p class="text-white">
                                        <i class="fa fa-ticket features-icon text-white "></i>
                                        Klik disini !
                                    </p>
                                </button>
                            </div>
                            <div class="card  mb-3">
                                <h1 style="font-size: 40px;" class="text-dark"><strong>D <span>01</span></strong></h1>
                                <h3>Poli Umum</h3>
                                <button class="btn btn-primary">
                                    <p class="text-white">
                                        <i class="fa fa-ticket features-icon text-white "></i>
                                        Klik disini !
                                    </p>
                                </button>
                            </div> --}}
                        </div>
                    </div>

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
    <script src="{{ asset('/inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.js')}}"></script>
    <script src="{{ asset('/inspinia/js/popper.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('/inspinia/js/plugins/wow/wow.min.js') }}"></script>


    <script>

        $(document).ready(function () {

            $('body').scrollspy({
                target: '#navbar',
                offset: 80
            });

            // Page scrolling feature
            $('a.page-scroll').bind('click', function (event) {
                var link = $(this);
                $('html, body').stop().animate({
                    scrollTop: $(link.attr('href')).offset().top - 50
                }, 500);
                event.preventDefault();
                $("#navbar").collapse('hide');
            });
        });

        var cbpAnimatedHeader = (function () {
            var docElem = document.documentElement,
                header = document.querySelector('.navbar-default'),
                didScroll = false,
                changeHeaderOn = 200;
            function init() {
                window.addEventListener('scroll', function (event) {
                    if (!didScroll) {
                        didScroll = true;
                        setTimeout(scrollPage, 250);
                    }
                }, false);
            }
            function scrollPage() {
                var sy = scrollY();
                if (sy >= changeHeaderOn) {
                    $(header).addClass('navbar-scroll')
                }
                else {
                    $(header).removeClass('navbar-scroll')
                }
                didScroll = false;
            }
            function scrollY() {
                return window.pageYOffset || docElem.scrollTop;
            }
            init();

        })();

        // Activate WOW.js plugin for animation on scrol
        new WOW().init();

    </script>

<script type="text/javascript">(function(){window['__CF$cv$params']={r:'6dab7ae66eea491e',m:'metnQWQaWkO9ykO5BaZ6oZM42.G31wcrklxBGieM.nU-1644392746-0-ASl9p9PxEHVkIUI8d9tPxUgWq9N9yQjZX0Wl3ovqQvrUZ1r0P0Vcg8DZ/7FdnUAfZKs8HSjzXpyaUmId0T4811jYr7h2haGgUVgTLSkPyImvnACjOXbHSWhdaXV2y4eHQBkUBvkpN+s3aEaEiV4VR2+cIhO6pp8vaq3H0FaJqwklpPAWCCFz0/I8mJ6XH+5d9Q==',s:[0x661941dea9,0xf8374aaf8a],}})();</script></body>

<script>
    $(document).ready(function(){

        allpoli();

        });
        function cetak(){
        var arr = {
            poli: $('#poli_now').text(),
            no_antrian: $('#antrian_now').text()
        };
        if(arr['poli'] == 'Silahkan ambil antrian'){
            alert('Anda belum mengambil antrian');
        }else{
            var link = "{{ route('antrian.cetak') }}/"+JSON.stringify(arr);
            window.open(link, "_blank");
        }
        }
        function tambah(kdpoli, nmpoli){
        var nomor = $('#nomor_poli'+kdpoli).text();

        if(nomor != '0'){
            var angka = parseInt(nomor.substring(1));
            angka++;
            $('#nomor_poli'+kdpoli).text(nomor.charAt(0)+''+angka);
            $('#antrian_now').text(nomor.charAt(0)+''+angka);
            $('#poli_now').text(nmpoli);
        }

        $.ajax({
            type: 'POST',
            url: '{{route("postantrian")}}',
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            data:{
            'kdpoli': kdpoli,
            },
            // beforeSend: function(){
            //     Swal.showLoading();
            // },
            success: function(data){
                Swal.hideLoading();
                Swal.close();
                console.log(data);
                $('#nomor_poli'+kdpoli).text(data.no_antrian);
                $('#antrian_now').text(data.no_antrian);
                $('#poli_now').text(data.poli.nama_poli);
            },
            complete: function(){
                Swal.hideLoading();
                Swal.close();
            },
            error: function(data){
                // console.log(data);
                // Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
            }
        });
        }
        function allpoli(){
        console.log('tes');
        $('#allpoli').html('');
        $.ajax({
            type: 'GET',
            url: '{{route("getallpoli")}}',
            success: function(data){
                // console.log(data);

                var divhead = '<div class="col-md-6">';
                var divfoot = '</div>';
                for(i=0;i<data.length;i++){

                    // $('#allpoli').append('<p id="nomor_poli'+data[i].kdpoli+'">0</p>'
                    // +'<button id="button_poli'+data[i].kdpoli+'" onclick="tambah(\''+data[i].kdpoli+'\', \''+data[i].nama_poli+'\')">'+data[i].nama_poli+'</button>')
                    var html = '<div class="card  mb-3">                                                                    '
                            +'    <h1 style="font-size: 40px;" class="text-dark"><strong id="nomor_poli'+data[i].kdpoli+'">0</strong></h1>'
                            +'    <h3>'+data[i].nama_poli+'</h3>'
                            +'    <button class="btn btn-primary" onclick="tambah(\''+data[i].kdpoli+'\', \''+data[i].nama_poli+'\')">'
                            +'        <p class="text-white">'
                            +'            <i class="fa fa-ticket features-icon text-white "></i>'
                            +'            Klik disini !'
                            +'        </p>'
                            +'    </button>'
                            +'</div>';
                    if(i % 2 == 0 ){
                        $('#poli_kiri').append(html);

                    }else{
                        $('#poli_kanan').append(html);
                    }


                }
                // console.log($('#allpoli').html())
                time();
            },
            error: function(data){
                console.log(data);
                // Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
            }
        });
        }
        function time(){
        setTimeout(function () {
            $.ajax({
                type: 'GET',
                url: '{{route("getDataAntrian")}}',
                success: function(data){
                    for(i=0;i<data.length;i++){
                        $('#nomor_poli'+data[i].kdpoli).text(data[i].no_antrian);
                    }
                    console.log(data);
                },
                error: function(data){
                    console.log(data);
                    // Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                }
            });
            time();
        }, 1500);

        }
</script>
</html>
