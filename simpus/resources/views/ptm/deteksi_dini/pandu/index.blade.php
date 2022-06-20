@extends('layouts.table_ptm')
@section('title', 'PANDU PTM DI FKTP')
@section('judultable', 'PANDU PTM DI FKTP')
{{-- @section('subjudul', '(PANDU PTM DI FKTP)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'PANDU PTM DI FKTP')
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
                            <h3 class="ml-3">PANDU PTM DI FKTP</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_pandu.tambah') }}" class="btn btn-primary b-r-xl"><i
                                        class="fa fa-plus-circle"></i>&nbsp;
                                    Tambah</a>
                                <a href="javascript:void(0);"
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-refresh"></i>&nbsp; Refresh</a>
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
                                    <th width="5%" class="align-bottom" rowspan="2">No</th>
                                    <th class="align-bottom" rowspan="2">Puskesmas</th>
                                    <th class="align-bottom" rowspan="2">Jumlah Pasien Dilakukan Skrining</th>
                                    <th class="align-bottom" colspan="2">Jumlah Kasus</th>
                                    <th class="align-bottom" colspan="5">Hasil Prediksi Risiko PTM (Charta)</th>
                                    <th class="align-bottom" rowspan="2">Jumlah Dirujuk ke RS</th>
                                    <th class="align-bottom" rowspan="2">Action</th>
                                </tr>
                                <tr class="text-white bg-green text-center">
                                    <th class="align-bottom">PTM</th>
                                    <th class="align-bottom">Bukan PTM</th>
                                    <th class="align-bottom">
                                        < 5%</th>
                                    <th class="align-bottom">5 % - < 10 % </th>
                                    <th class="align-bottom">
                                        10
                                        % - < 20 %</th>
                                    <th class="align-bottom">20 % - < 30 % </th>
                                    <th class="align-bottom"> > =
                                        30%
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr class="text-white text-center bg-primary">
                                    <th>Total</th>
                                    <th id="puskesmas"></th>
                                    <th id="jml_pasien_skrining"></th>
                                    <th id="jml_kasus_ptm"></th>
                                    <th id="jml_kasus_non_ptm"></th>
                                    <th id="charta_5"></th>
                                    <th id="charta_5_10"></th>
                                    <th id="charta_10_20"></th>
                                    <th id="charta_20_30"></th>
                                    <th id="charta_30"></th>
                                    <th id="jml_dirujuk_rs"></th>
                                    <th id="action"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
            "pagingType": "full_numbers",
            pageLength: 50,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "select" : true,
            "ajax":{
                    "url": "{{ route("dd_pandu.getdata") }}",
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
                        $("#jml_pasien_skrining").text(json.sum_data.jml_pasien_skrining);
                        $("#jml_kasus_ptm").text(json.sum_data.jml_kasus_ptm);
                        $("#jml_kasus_non_ptm").text(json.sum_data.jml_kasus_non_ptm);
                        $("#charta_5").text(json.sum_data.charta_5);
                        $("#charta_5_10").text(json.sum_data.charta_5_10);
                        $("#charta_10_20").text(json.sum_data.charta_10_20);
                        $("#charta_20_30").text(json.sum_data.charta_20_30);
                        $("#charta_30").text(json.sum_data.charta_30);
                        $("#jml_dirujuk_rs").text(json.sum_data.jml_dirujuk_rs);
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
                { "data": "jml_pasien_skrining"},
                { "data": "jml_kasus_ptm"},
                { "data": "jml_kasus_non_ptm"},
                { "data": "charta_5"},
                { "data": "charta_5_10"},
                { "data": "charta_10_20"},
                { "data": "charta_20_30"},
                { "data": "charta_30"},
                { "data": "jml_dirujuk_rs"},

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

        $('#periode_bln .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true,
                format: "M-yyyy"
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
                    url: '{{route("dd_pandu.hapus",[null])}}/' + enc_id,
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
