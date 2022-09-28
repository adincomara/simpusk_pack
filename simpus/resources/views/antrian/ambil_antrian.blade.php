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
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css')}}">

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
                    </div>
{{ csrf_field() }}
                    <hr style="background-color:#E7F6F2;">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="" style="color: #E7F6F2;">Cek Pendaftaran</h2>
                            <div class="input-group"><input type="text" class="form-control"
                                    placeholder="NIK/NO BPJS/NO REKAM MEDIS/NO ANTRIAN" id="key"> <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="cek_pendaftaran()"><i class="fa fa-search"
                                            aria-hidden="true"></i>
                                    </button> </span>
                            </div>
                            <h2 class="text-center" id="tdk_ditemukan"  style="color: #E7F6F2; display:none">Data Tidak Ditemukan</h2>
                            <div class="table-responsive mt-4" id="table_data" style="display: none;">
                                <table id="table1" class="table p-0 text-center table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th class="bg-primary">NIK</th>
                                            <th class="bg-primary">No REKAM MEDIS</th>
                                            <th class="bg-primary">Nomor Antiran</th>
                                            <th class="bg-primary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light" id="data_cek_pendaftaran">
                                        <tr>
                                            <td>3333123123211232XXXX</td>
                                            <td>2312312313XXXX</td>
                                            <td>41</td>
                                            <td>
                                                <button class="btn btn-danger"><i class="fa fa-trash"
                                                        aria-hidden="true"></i>&nbsp; Hapus Antrian</button>
                                                <button class="btn btn-success"><i class="fa fa-ticket"
                                                        aria-hidden="true"></i>&nbsp; Cetak Nomor Antrian</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.js')}}"></script>


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
            $('#table1').DataTable();
        });
    </script>
    <script>
        function cek_pendaftaran(){
            let key = $('#key').val();
            $.ajax({
                type: 'GET',
                url : "{{route('antrian.cek_pendaftaran')}}/"+key,
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                dataType: "json",
                beforeSend: function(){
                    // $('#panggil_ulang').removeClass("disabled");
                    $('#panggil_ulang').prop("disabled", true);
                },
                success: function(data){
                    if(data.success == true){
                        let html;
                        html = "<tr>";
                        html += "<td>"+data.pasien.no_ktp;
                        html += "</td>";
                        html += "<td>"+data.pasien.no_rekamedis;
                        html += "</td>";
                        html += "<td>"+data.antrian.no_antrian;
                        html += "</td>";
                        var link = "{{ route('antrian.cetak') }}/"+JSON.stringify(data.antrian);
                        html += "<td> <button class='btn btn-danger text-white' onclick='hapus_pendaftaran("+data.antrian.id+")'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp; Hapus Pendaftaran</button> &nbsp;";
                        if(data.antrian.status == 0){
                            html += "<a href='{{ route('antrian.cetak')}}/"+JSON.stringify(data.cetak_antrian)+"' target='__blank' class='btn btn-success text-white'><i class='fa fa-ticket'"
                                    +"aria-hidden='true'></i>&nbsp; &nbsp; Cetak Nomor Antrian</a>";
                        }
                        html += "</td>";
                        html += "</tr>";
                        $('#data_cek_pendaftaran').html(html);
                        $('#table_data').css("display", "block");
                        $('#tdk_ditemukan').css("display", "none");

                    }else{
                        $('#table_data').css("display", "none");
                        $('#tdk_ditemukan').css("display", "block");
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
        function hapus_pendaftaran(id){
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan terhapus!",

                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ya",
                cancelButtonText:"Batal",
                confirmButtonColor: "#ec6c62",
                closeOnConfirm: false
            }).then(function(result){
                if(result.value){

                    $.ajax({
                        type: 'DELETE',
                        url: '{{route("antrian.hapus",[null])}}/' + id,
                        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            Swal.fire({
                                html: '<h1>Loading...</h1>',
                                showConfirmButton: false,
                                buttons: false,
                                closeOnClickOutside: false,
                            });
                        },
                        success: function(data){
                            if (data.success==true) {
                                Swal.fire('Yes',data.message,'success');
                                // table.ajax.reload(null, true);
                                cek_pendaftaran();
                            }else{
                                Swal.fire('Ups',data.message,'info');
                            }
                        },
                        complete: function(data){
                            Swal.hideLoading();
                            console.log('hideloading');
                        },
                        error: function(data){
                            console.log(data);
                            Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                        }
                    });
                }
            })
        }
    </script>
</body>

</html>
