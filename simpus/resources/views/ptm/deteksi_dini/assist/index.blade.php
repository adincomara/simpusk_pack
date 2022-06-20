@extends('layouts.table_ptm')
@section('title', 'ASSIST')
@section('judultable', 'ASSIST')
{{-- @section('subjudul', '(ASSIST)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'ASSIST')
@section('table_ptm')
<style>
    #table1 th,
    #table2 th {
        background: #1ab394 !important;
    }

    #table1 td,
    #table2 td {
        background: white !important;
    }

    tr th:nth-child(1),
    tr th:nth-child(2) {
        z-index: 56;
    }

    tr th:nth-child(3) {
        z-index: 1;
    }

    #table1 thead td,
    #table1 thead th {
        border: 1px solid white;
    }

    .text-datatable {
        width: 25px;
        text-align: right;
        border: none;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">ASSIST</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_assist.tambah') }}" class="btn btn-primary b-r-xl"><i
                                        class="fa fa-plus-circle"></i>&nbsp;
                                    Tambah</a>
                                <a href="javascript:void(0);"
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-refresh"></i>&nbsp; Refresh</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content b-r-xl mt-3">
                <div class="d-flex justify-content-between my-3">
                    <div class="p-0">
                        <div class="form-group col-md" id="periode_bln">
                            <p class="font-bold">Periode</p>
                            <div class="form-group" id="range_periode">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text"
                                        class="form-control-sm form-control rounded-left periode"
                                        id="start" name="start" value="{{ $start_date }}" />
                                    <span class="input-group-addon px-3 bg-primary">to</span>
                                    <input type="text"
                                        class="form-control-sm form-control rounded-right periode"
                                        id="end" name="end" value="{{ $end_date }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-0 my-auto">
                        <p>
                            <a class="btn btn-default" href=""> <i class=" fa fa-print"></i>
                                &nbsp; Print</a>
                            <a class="btn btn-danger" href="#"> <i class=" fa fa-file-pdf-o"></i>
                                &nbsp; PDF</a>
                            <a class="btn btn-primary" href="#"> <i class=" fa fa-file-excel-o"></i>
                                &nbsp; Excel</a>
                        </p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table1" class="table p-0 table-bordered text-center table-hover"
                        style="overflow-x: auto;">
                        <thead>
                            <tr class="text-white bg-green text-center">
                                <th width="5%" class="align-bottom" rowspan="3">No</th>

                                <th class="align-bottom" rowspan="3">PUSKESMAS</th>


                                <th class="align-bottom" rowspan="3">Jumlah Sekolah yg telah dilakukan Skrining
                                    ASSIST</th>
                                <th class="align-bottom" colspan="4">Jumlah Peserta Skrining ASSIST</th>
                                <th class="align-bottom" colspan="20">Jenis Zat yang digunakan</th>
                                <th class="align-bottom" colspan="6">Hasil Skrining ASSISTT</th>
                                <th class="align-bottom" colspan="4">Tindak Lanjut Skrining ASSIST</th>

                                <th class="align-bottom" rowspan="3">Action</th>

                            </tr>
                            <tr class="text-white bg-green text-center">
                                <th class="align-bottom" colspan="2">Puskesmas</th>
                                <th class="align-bottom" colspan="2">Sekolah</th>
                                <th class="align-bottom" colspan="2">Produk tembakau (rokok, cerutu, kretek, dll.)</th>
                                <th class="align-bottom" colspan="2">Minuman beralkohol (bir, anggur, sopi, tomi, dll.)</th>
                                <th class="align-bottom" colspan="2">Kanabis (marijuana, ganja, gelek, cimengpot, dll.)</th>
                                <th class="align-bottom" colspan="2">Kokain (coke, crack, etc.)</th>
                                <th class="align-bottom" colspan="2">Stimulan jenis amfetamin (ekstasi, shabu, dll)</th>
                                <th class="align-bottom" colspan="2">Inhalansia (lem, bensin, tiner, dll)</th>
                                <th class="align-bottom" colspan="2">Sedativa atau obat tidur (Benzodiazepin, Lexotan, Rohypnol,
                                    Mogadon, dll.)</th>
                                <th class="align-bottom" colspan="2">Halusinogens (LSD, mushrooms, PCP, dll.)</th>
                                <th class="align-bottom" colspan="2">Opioida (heroin, morfin, metadon, kodein, dll.)</th>
                                <th class="align-bottom" colspan="2">Zat lain</th>
                                <th class="align-bottom" colspan="2">Ringan</th>
                                <th class="align-bottom" colspan="2">Sedang</th>
                                <th class="align-bottom" colspan="2">Berat</th>
                                <th class="align-bottom" colspan="2">Rujuk IPWL</th>
                                <th class="align-bottom" colspan="2">Pelayanan Langsung di Puskesmas</th>
                            </tr>
                            <tr class="text-white bg-green text-center">
                                <th class="align-bottom" style="z-index: 50">L</th>
                                <th class="align-bottom" style="z-index: 50">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                                <th class="align-bottom">L</th>
                                <th class="align-bottom">P</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr class="text-white text-center bg-primary">
                                <th>Total</th>
                                <th id="puskesmas"></th>
                                <th id="jml_sklh_skrining_assist"></th>
                                <th id="jml_peserta_pusk_l"></th>
                                <th id="jml_peserta_pusk_p"></th>
                                <th id="jml_peserta_sklh_l"></th>
                                <th id="jml_peserta_sklh_p"></th>
                                <th id="tembakau_l"></th>
                                <th id="tembakau_p"></th>
                                <th id="alkohol_l"></th>
                                <th id="alkohol_p"></th>
                                <th id="kanabis_l"></th>
                                <th id="kanabis_p"></th>
                                <th id="kokain_l"></th>
                                <th id="kokain_p"></th>
                                <th id="stimulan_l"></th>
                                <th id="stimulan_p"></th>
                                <th id="inhalansia_l"></th>
                                <th id="inhalansia_p"></th>
                                <th id="sedatif_l"></th>
                                <th id="sedatif_p"></th>
                                <th id="halusinogen_l"></th>
                                <th id="halusinogen_p"></th>
                                <th id="opioida_l"></th>
                                <th id="opioida_p"></th>
                                <th id="lain_l"></th>
                                <th id="lain_p"></th>
                                <th id="skrining_ringan_l"></th>
                                <th id="skrining_ringan_p"></th>
                                <th id="skrining_sedang_l"></th>
                                <th id="skrining_sedang_p"></th>
                                <th id="skrining_berat_l"></th>
                                <th id="skrining_berat_p"></th>
                                <th id="tindak_skrining_rujuk_l"></th>
                                <th id="tindak_skrining_rujuk_p"></th>
                                <th id="tindak_skrining_langsung_l"></th>
                                <th id="tindak_skrining_langsung_p"></th>
                                <th id="action"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>



    @endsection
    @push('scripts')
    <script type="text/javascript">
        var table,tabledata,table_index;
        $(document).ready(function(){
            $(".btn-refresh").click(function() {
                table.ajax.reload();
            });
            table = $('#table1').DataTable({
                fixedColumns: {
                    left: 2
                },
                "pagingType": "full_numbers",
                pageLength: 25,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "select" : true,
                "ajax":{
                         "url": "{{ route("dd_assist.getdata") }}",
                         "dataType": "json",
                         "type": "POST",
                         beforeSend: function(){
                             Swal.showLoading();
                         },
                         data: function ( d ) {
                            d._token= "{{csrf_token()}}";
                            d.kabupaten = $('#select_kab option:selected').val()
                            d.puskesmas = $('#select_pusk option:selected').val()
                            d.periode_start = $('#start').val()
                            d.periode_end   = $('#end').val()
                         },
                         complete: function(){
                             Swal.hideLoading();
                             Swal.close();
                         },
                         "dataSrc": function ( json ) {
                            $("#puskesmas").text(json.sum_data.puskesmas);
                            $("#jml_sklh_skrining_assist").text(json.sum_data.jml_sklh_skrining_assist);
                            $("#jml_peserta_pusk_l").text(json.sum_data.jml_peserta_pusk_l);
                            $("#jml_peserta_pusk_p").text(json.sum_data.jml_peserta_pusk_p);
                            $("#jml_peserta_sklh_l").text(json.sum_data.jml_peserta_sklh_l);
                            $("#jml_peserta_sklh_p").text(json.sum_data.jml_peserta_sklh_p);
                            $("#tembakau_l").text(json.sum_data.tembakau_l);
                            $("#tembakau_p").text(json.sum_data.tembakau_p);
                            $("#alkohol_l").text(json.sum_data.alkohol_l);
                            $("#alkohol_p").text(json.sum_data.alkohol_p);
                            $("#kanabis_l").text(json.sum_data.kanabis_l);
                            $("#kanabis_p").text(json.sum_data.kanabis_p);
                            $("#kokain_l").text(json.sum_data.kokain_l);
                            $("#kokain_p").text(json.sum_data.kokain_p);
                            $("#stimulan_l").text(json.sum_data.stimulan_l);
                            $("#stimulan_p").text(json.sum_data.stimulan_p);
                            $("#inhalansia_l").text(json.sum_data.inhalansia_l);
                            $("#inhalansia_p").text(json.sum_data.inhalansia_p);
                            $("#sedatif_l").text(json.sum_data.sedatif_l);
                            $("#sedatif_p").text(json.sum_data.sedatif_p);
                            $("#halusinogen_l").text(json.sum_data.halusinogen_l);
                            $("#halusinogen_p").text(json.sum_data.halusinogen_p);
                            $("#opioida_l").text(json.sum_data.opioida_l);
                            $("#opioida_p").text(json.sum_data.opioida_p);
                            $("#lain_l").text(json.sum_data.lain_l);
                            $("#lain_p").text(json.sum_data.lain_p);
                            $("#skrining_ringan_l").text(json.sum_data.skrining_ringan_l);
                            $("#skrining_ringan_p").text(json.sum_data.skrining_ringan_p);
                            $("#skrining_sedang_l").text(json.sum_data.skrining_sedang_l);
                            $("#skrining_sedang_p").text(json.sum_data.skrining_sedang_p);
                            $("#skrining_berat_l").text(json.sum_data.skrining_berat_l);
                            $("#skrining_berat_p").text(json.sum_data.skrining_berat_p);
                            $("#tindak_skrining_rujuk_l").text(json.sum_data.tindak_skrining_rujuk_l);
                            $("#tindak_skrining_rujuk_p").text(json.sum_data.tindak_skrining_rujuk_p);
                            $("#tindak_skrining_langsung_l").text(json.sum_data.tindak_skrining_langsung_l);
                            $("#tindak_skrining_langsung_p").text(json.sum_data.tindak_skrining_langsung_p);
                            $("#action").text(json.sum_data.action);
                            return json.data;
                         },
                       },
                "columns": [
                    {
                      "data": "no",
                      "orderable" : false,
                    },
                    // { "data": "kabupaten"},
                    { "data": "puskesmas"},
                    {"data":"jml_sklh_skrining_assist"},
                    {"data":"jml_peserta_pusk_l"},
                    {"data":"jml_peserta_pusk_p"},
                    {"data":"jml_peserta_sklh_l"},
                    {"data":"jml_peserta_sklh_p"},
                    {"data":"tembakau_l"},
                    {"data":"tembakau_p"},
                    {"data":"alkohol_l"},
                    {"data":"alkohol_p"},
                    {"data":"kanabis_l"},
                    {"data":"kanabis_p"},
                    {"data":"kokain_l"},
                    {"data":"kokain_p"},
                    {"data":"stimulan_l"},
                    {"data":"stimulan_p"},
                    {"data":"inhalansia_l"},
                    {"data":"inhalansia_p"},
                    {"data":"sedatif_l"},
                    {"data":"sedatif_p"},
                    {"data":"halusinogen_l"},
                    {"data":"halusinogen_p"},
                    {"data":"opioida_l"},
                    {"data":"opioida_p"},
                    {"data":"lain_l"},
                    {"data":"lain_p"},
                    {"data":"skrining_ringan_l"},
                    {"data":"skrining_ringan_p"},
                    {"data":"skrining_sedang_l"},
                    {"data":"skrining_sedang_p"},
                    {"data":"skrining_berat_l"},
                    {"data":"skrining_berat_p"},
                    {"data":"tindak_skrining_rujuk_l"},
                    {"data":"tindak_skrining_rujuk_p"},
                    {"data":"tindak_skrining_langsung_l"},
                    {"data":"tindak_skrining_langsung_p"},
                    { "data" : "action",
                      "orderable" : false,
                      "className" : "text-right",
                    },
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data",
                    emptyTable: "Belum ada data",
                    info: "Menampilkan data _START_ sampai _END_ dari _MAX_ data.",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data.",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    loadingRecords: "Loading...",
                    processing: "Mencari...",
                    paginate: {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Sesudah",
                        "previous": "Sebelum"
                    },
                },
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            orthogonal: 'export'
                        },
                        header: true,
                        footer: true,
                        className: 'btn btn-outline btn-default btn-lg',
                    },
                    // {
                    //     extend: 'excel',
                    //     exportOptions: {
                    //         orthogonal: 'export'
                    //     },
                    //     header: true,
                    //     footer: true,
                    //     className: 'btn btn-block bg-primary text-white',
                    // }
                ]
            });
            $(document).on('change','#select_kab', function(){
                table.ajax.reload(null, false);
            })

            $(document).on('change','#select_pusk', function(){
                table.ajax.reload(null, false);
            })

            $(document).on('change','#start', function(){
                if($('#end').val != ''){
                    table.ajax.reload(null, false);
                }
            })

            $(document).on('change','#end', function(){
                if($('#start').val != ''){
                    table.ajax.reload(null, false);
                }
            })

            $('.periode').datepicker({
                    minViewMode: 1,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "M-yyyy"
            });
            $("#select_prov").select2();
            $("#select_kab").select2();
            $("#select_pusk").select2({
                placeholder: "Pilih Puskesmas .....",
                allowClear: true,
                ajax: {
                    url: "{{ route('kasus_ptm.filter_puskesmas') }}",
                    dataType: 'JSON',
                    data: function(params) {
                        return {
                            search: params.term,
                            kabupaten: $('#select_kab option:selected').val()
                        }
                    },
                    processResults: function (data) {
                        var results = [];
                        $.each(data, function(index, item){
                            results.push({
                                id: item.id,
                                text : item.name,
                            });
                        });
                        return{
                            results: results
                        };
                    }
                }
            });
        });

        function deleteData(e,enc_id){
            var token = '{{ csrf_token() }}';
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
            }).then(function(result) {
                console.log(result)
                if (result.value) {
                    $.ajaxSetup({
                        headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
                    });
                    $.ajax({
                        type: 'delete',
                        url: '{{route("dd_assist.hapus",[null])}}/' + enc_id,
                        headers: {'X-CSRF-TOKEN': token},
                        success: function(data){
                        console.log(data)
                        if (data.status == 'success') {
                            Swal.fire('Yes',data.message,'success');
                            table.ajax.reload(null, true);
                        }else{
                            Swal.fire('Ups',data.message,'info');
                        }
                    },
                    error: function(data){
                        console.log(data);
                        Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
                    }});
                }
            });
        }
        $(document).ready(function(){
            @if(!empty($alert))
                Swal.fire('Ups','Maaf gagal','error');
            @endif
        });
    </script>
    @endpush
