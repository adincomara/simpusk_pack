<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PENDAFTARAN | BPJS</title>

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
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css')}}">


    <style>
        .table_keyboard tr td {
            padding: 10px;
            font-size: 20px;
        }
    </style>
</head>

<body class="gray-bg top-navigation"
    style="background: url('{{ asset('assets/img/bg13.png') }}') no-repeat; background-size:100%;">
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <img src="{{ asset('/kiosk/img/logo-puskesmas') }}.png" class="my-auto" alt="" width="90px"
                        height="100px">
                    <div class="text-center">
                        <h1 class="text-bold" style="font-size: 50px; font-weight: 600">SELAMAT DATANG
                        </h1>
                        <h4 class="text-navy text-uppercase">Sistem Pendaftaran BPJS UPTD
                            Puskesmas Jepang</h4>
                    </div>
                    <img src="{{ asset('/kiosk/img/logo-kudus') }}.png" class="my-auto" alt="" width="75px"
                        height="100px">
                </div>
                <div class="row">
                    <div class="middle-box loginscreen animated fadeInDown col-sm-6">
                        <!-- <div>
                            <img src="img/icon1.svg" alt="" width="300px">
                        </div> -->
                        <form class="m-t" id="submitData">
                            {{ csrf_field() }}
                            {{-- <p>Masukan Nomer BPJS/NIK</p> --}}
                            <div class="form-group input-group">
                                <input list="kartu" class="form-control" name="no_kartu" placeholder="NIK/NO KARTU BPJS"
                                    id="no_kartu" required="" autocomplete="off">
                                <datalist id="kartu" onChange="data()">
                                </datalist>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="key"><i
                                            class="fa fa-keyboard-o"></i>
                                    </button>
                                </span>
                            </div>
                            <div id="table1" style="display: none;">
                                <table class="table_keyboard mb-3" width="80%">
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="1">1</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="2">2</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="3">3</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="4">4</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="5">5</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="6">6</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="7">7</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="8">8</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="9">9</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-outline keyboard"
                                                value="0">0</button>
                                        </td>
                                        <td>
                                            <button type="button" id="hapus_text" class="btn btn-dark"
                                                style="padding: 6px 8px 6px 8px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    style="width: 20px;" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M6.707 4.879A3 3 0 018.828 4H15a3 3 0 013 3v6a3 3 0 01-3 3H8.828a3 3 0 01-2.12-.879l-4.415-4.414a1 1 0 010-1.414l4.414-4.414zm4 2.414a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                {{-- <p>Pilih Poli</p> --}}
                                <select class="form-control" name="status_pasien" id="status_pasien">
                                    <option value="">Pilih Status Pasien</option>
                                    <option value="1">BPJS</option>
                                    <option value="0">UMUM</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                {{-- <p>Pilih Poli</p> --}}
                                <select class="select2_poli form-control" name="poli">
                                    <option value=""></option>
                                    @foreach($poli as $key => $value)
                                    <option value="{{ $value['kdpoli'] }}">{{ $value['nama_poli'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {{-- <p>Pilih Dokter</p> --}}
                                <select class="select2_dokter form-control" name="dokter">
                                    <option value=""></option>
                                    @foreach($dokter as $key => $value)
                                    <option value="{{ $value['kdDokter'] }}">{{ $value['nmDokter'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-success">
                                    <input id="cek_kesehatan_awal" type="checkbox" name="cek_kesehatan">
                                    <label for="cek_kesehatan_awal">
                                        Cek Kesehatan Awal
                                    </label>
                                </div>
                            </div>
                            <div style="display: none" id="cek_kesehatan">
                                <div class="form-group">
                                    {{-- <p>Keluhan</p> --}}
                                    <textarea name="keluhan" id="" cols="30" rows="5" class="form-control"
                                        placeholder="Masukan keluhan"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="sistole" placeholder="Masukan sistol" required=""
                                        autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan diastol" required=""
                                        autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan berat badan"
                                        required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan tinggi badan"
                                        required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan resp Rate"
                                        required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan lingkar perut"
                                        required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Masukan heart Rate"
                                        required="" autocomplete="off">
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="submit" id="btn_simpan" class="btn btn-primary block full-width m-b"><i
                                        class="fa fa-paper-plane" aria-hidden="true"></i> Kirim</button>
                            </div>
                    </div>

                    </form>
                    {{--
                    <p class="text-muted text-center"><small>Tidak terdaftar di BPJS ?</small>
                        <a href="{{ route('antrian.ambil_antrian') }}">
                            <small>kembali</small></a>
                    </p> --}}
                </div>
                <div class="mt-5 loginscreen animated fadeInDown col-sm-6" style="display: none" id="kartu_peserta">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">DATA PASIEN</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0">Nomor NIK/BPJS :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="no_kartu_bpjs"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0"> Nama :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="nama_bpjs"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0"> Status Pasien :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="sts_pasien"></h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0">Kode Provider :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="kode_provider_bpjs" val=""></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0">Nama Provider :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="nama_provider_bpjs"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0">Jenis Kelamin :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="jenis_kelamin_bpjs"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0"> Jenis Peserta :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="jenis_peserta_bpjs"></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0"> No.HP :</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="no_hp_bpjs"></h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h4 class="mb-0"> Status BPJS</h4>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            <h4 id="status_bpjs"></h4>
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
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('/kiosk/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/popper.min.js') }}"></script>
    <script src="{{ asset('/kiosk/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert.js')}}"></script>


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

    <!-- Date range  moment js same as full calendar plugin -->

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

    {{--  MAIN SCRIPT  --}}
    <script>
        $(document).ready(function () {

            $('.chosen-select').chosen({
                width: "100%"
            });
            $(".select2_poli").select2({
                placeholder: "----- SEMUA POLI -----",
                allowClear: true
            });
            $(".select2_dokter").select2({
                placeholder: "----- SEMUA DOKTER -----",
                allowClear: true
            });


        });
        const btn = document.getElementById('key');
        key.addEventListener('click', () => {
            const form = document.getElementById('table1');

            if (form.style.display === 'block') {
                // 👇️ this SHOWS the form
                form.style.display = 'none';
            } else {
                // 👇️ this HIDES the form
                form.style.display = 'block';
            }
        });
    </script>
    {{--  END MAIN SCRIPT  --}}
    {{--  SCRIPT CLICK KEYBOARD DAN HAPUS   --}}
    <script>
        $('.keyboard').on('click', function(){
            let value = $('#no_kartu').val();
            $('#no_kartu').val(value+this.value)

        });
        $('#hapus_text').on('click', function(){
            let value = $('#no_kartu').val();
            $('#no_kartu').val(value.slice(0,-1));
        })
    </script>
    {{--  SUBMIT FORM  --}}
    <script>
        $('#submitData').validate({
            ignore: ":hidden:not(.editor)",
            rules: {
                no_kartu:{
                    required: true
                },
                poli:{
                    required: true
                },
                dokter:{
                    required: true
                },
            },
            messages: {
                no_kartu : {
                    required: 'No Kartu harus diisi'
                },
                poli : {
                    required: 'Poli harus dipilih'
                },
                dokter : {
                    required: 'Dokter harus dipilih'
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
                // console.log(element.closest('.form-group').append(error));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                // console.log('sini');
                SimpanData();
            }
        })
        function SimpanData(){
            $('#btn_simpan').addClass("disabled");
            let no_kartu = $('#no_kartu').val();
            let dataFile = new FormData();

            dataFile.append('no_kartu', no_kartu);
            console.log(dataFile);

            $.ajax({
                type: 'POST',
                url : "{{route('antrian.pendaftaran_bpjs_simpan')}}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data:$('#submitData').serialize(),
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: 'Mohon Tunggu !',
                        html: 'Loading',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data){
                    if(data.success == true){
                        console.log(data.antrian);
                        var link = "{{ route('antrian.cetak') }}/"+JSON.stringify(data.antrian);
                        window.open(link, "_blank");
                        window.location.href="{{ route('antrian.ambil_antrian') }}";
                    }else{
                        Swal.fire('Ups',data.message,'info');
                    }
                },
                complete: function () {
                    Swal.hideLoading();
                    $('#btn_simpan').removeClass("disabled");
                },
                error: function(data){
                    $('#btn_simpan').removeClass("disabled");
                }
            });
        }
    </script>
    {{--  SCRIPT NO KARTU  --}}
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{route("antrian.search_no_kartu")}}',
                type: "GET",
                data:{
                    search: this.value,
                    status: 'BPJS'
                },
                dataType: "json",
                success:function(data) {
                    let html = '';
                    for(let i = 0; i<data.length; i++){
                        html +='<option value="'+data[i].no_bpjs+'">Nama = '+data[i].nama_pasien+' | No KTP = '+data[i].no_ktp+'</option>';
                    }
                    $('#kartu').html(html);

                }
            });
        });
        $('#no_kartu').on('keyup', function(){
            $.ajax({
                url: '{{route("antrian.search_no_kartu")}}',
                type: "GET",
                data:{
                    search: this.value,
                },
                dataType: "json",
                success:function(data) {
                    let html = '';
                    for(let i = 0; i<data.length; i++){
                        html +='<option value="'+data[i].no_bpjs+'">Nama = '+data[i].nama_pasien+' | No KTP = '+data[i].no_ktp+'</option>';
                    }
                    $('#kartu').html(html);

                }
            });
        })
        $('#no_kartu').on('change',function(){
            let no_kartu = this.value;
            console.log(no_kartu);
            $.ajax({
                url: '{{route("antrian.data_pasien")}}',
                type: "GET",
                data:{
                    no_kartu: no_kartu,
                },
                dataType: "json",
                beforeSend: function(){
                    Swal.fire({
                        title: 'Mohon Tunggu !',
                        html: 'Loading',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success:function(data) {
                    Swal.hideLoading();
                    if(data.success == true){
                        Swal.close();
                        $("#status_pasien").val(data.status_pasien).change();
                        $("#kartu_peserta").css('display', 'block');
                        let nikbpjs = ''+data.pasien.no_ktp;
                        let nama = data.pasien.nama_pasien;
                        let status_p = data.pasien.status_pasien;
                        let kode_provider, nama_provider, jenis_kelamin, jenis_peserta, no_hp;
                        jenis_kelamin = data.pasien.jenis_kelamin, status_bpjs;
                        if(data.status_pasien == 1){
                            nikbpjs += ' / '+data.data_pasien.noKartu;
                            kode_provider = data.data_pasien.kdProviderPst.kdProvider;
                            nama_provider = data.data_pasien.kdProviderPst.nmProvider;
                            jenis_peserta = data.data_pasien.jnsPeserta.nama;
                            no_hp = data.data_pasien.noHP;
                            status_bpjs = data.data_pasien.ketAktif;
                        }else{
                            nikbpjs += ' / -';
                            kode_provider = '-';
                            nama_provider = '-';
                            jenis_peserta = '-';
                            no_hp = data.pasien.telp;
                            status_bpjs = '-';
                        }

                        $('#no_kartu_bpjs').text(nikbpjs);
                        $('#nama_bpjs').text(nama);
                        $('#sts_pasien').text(status_p);
                        $('#kode_provider_bpjs').text(kode_provider);
                        $('#nama_provider_bpjs').text(nama_provider);
                        $('#jenis_kelamin_bpjs').text(jenis_kelamin);
                        $('#jenis_peserta_bpjs').text(jenis_peserta);
                        $('#no_hp_bpjs').text(no_hp);
                        $('#status_bpjs').text(status_bpjs);


                    }else{
                        Swal.fire('Ups', data.message, 'info');
                    }
                },
                complete: function(){
                   Swal.hideLoading();
                }
            });
        })
    </script>
    {{--  SCRIPT CEK KESEHATAN AWAL  --}}
    <script>
        $('#cek_kesehatan_awal').on('click', function(){
            if($('#cek_kesehatan_awal').is(':checked')) {
                $("#cek_kesehatan").css('display', 'block');
            }else{
                $("#cek_kesehatan").css('display', 'none');
            }
        })
    </script>
</body>

</html>
