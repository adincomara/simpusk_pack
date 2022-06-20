@extends('layouts.table_ptm')
@section('title', 'Register Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form D)')
@section('judultable', 'Register Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form D)')
{{-- @section('subjudul', '(Register Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form D))') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Register Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form D)')
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
                            <h3 class="ml-3">Register Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas
                                (Form D)</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('form_d.form') }}" class="btn btn-primary b-r-xl"><i
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
                                <div class="input-group date">
                                    <span class="input-group-addon px-3 bg-primary rounded-left"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-group-addon rounded-right py-2"
                                        name="periode" id="periode" name="periode" autocomplete="off" value="Apr-2022">
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
                                <tr class="text-white text-center bg-green">
                                    <th width="5%" class="align-middle text-center" rowspan="3">No</th>
                                    <th class="align-middle" rowspan="3">Tgl</th>
                                    <th class="align-middle" rowspan="3">No. Reg</th>
                                    <th class="align-middle" rowspan="3">Nama</th>
                                    <th class="align-middle" rowspan="3">Umur</th>
                                    <th class="align-middle" rowspan="3">Alamat</th>
                                    <th class="align-middle" colspan="6">Hasil Pemeriksaan Leher Rahim</th>
                                    <th class="align-middle" colspan="4">Hasil Pemeriksaan Payudara</th>
                                    <th class="align-middle" rowspan="3">Keterangan</th>
                                    <th class="align-middle" rowspan="3">Action</th>
                                    {{-- <th class="align-middle" rowspan="3"><i class="fas fa-th"></i></th> --}}
                                </tr>
                                <tr class="text-white text-center bg-green fw-600">
                                    <th class="align-middle" colspan="3"> Hasil IVA</th>
                                    <th class="align-middle" colspan="3">Dirujuk </th>
                                    <th class="align-middle" rowspan="2">Normal</th>
                                    <th class="align-middle" colspan="3">Dirujuk</th>
                                </tr>
                                <tr class="text-white text-center bg-green fw-600">
                                    <th class="align-middle">Positif</th>
                                    <th class="align-middle"> Negatif</th>
                                    <th class="align-middle">IVA Ragu2</th>
                                    <th class="align-middle">Lesi Luas </th>
                                    <th class="align-middle"> Curiga Ca </th>
                                    <th class="align-middle"> Kel Gyn </th>
                                    <th class="align-middle"> Benjolan </th>
                                    <th class="align-middle"> Curiga Ca </th>
                                    <th class="align-middle"> Lain2 </th>
                                </tr>
                                <tr class="text-white text-center bg-green font-weight-light">
                                    <?php
                                                                for($i = 1; $i <= 18; $i++ ) {
                                                                ?>
                                    <th class="align-middle" style="opacity: 0.8;">[<?= $i ?>]</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="18">
                                        <ul class="pagination float-right"></ul>
                                    </td>
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
                    pageLength: 25,
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                    "select" : true,
                    "ajax":{
                             "url": "{{ route("form_d.getdata") }}",
                             "dataType": "json",
                             "type": "POST",
                             data: function ( d ) {
                               d._token= "{{csrf_token()}}";
                               d.kabupaten = $('#select_kab option:selected').val()
                               d.puskesmas = $('#select_pusk option:selected').val()
                               d.periode = $('#periode').val()
                             }
                           },
                    "columns": [
                        {
                          "data": "no",
                          "orderable" : false,
                        },
                        {"data":"tgl"},
                        {"data":"no_registrasi"},
                        {"data":"nama"},
                        {"data":"umur"},
                        {"data":"alamat"},
                        {"data":"negatif"},
                        {"data":"positif"},
                        {"data":"raguragu"},
                        {"data":"lesu"},
                        {"data":"curiga"},
                        {"data":"kelgyn"},
                        {"data":"p_normal"},
                        {"data":"benjolan"},
                        {"data":"curigaca"},
                        {"data":"lainlain"},
                        {"data":"keterangan"},
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

                $(document).on('change','#periode_bln', function(){
                    table.ajax.reload(null, false);
                })

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

                $(document).on('change','#periode_bln', function(){
                    table.ajax.reload(null, false);
                })
                $("#select_kab").select2({
                    placeholder: "Pilih Kabupaten .....",
                    allowClear: true
                });
                $("#select_pusk").select2({
                    placeholder: "Pilih Puskesmas .....",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('kasus_jiwa.filter_puskesmas') }}",
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
                            url: '{{route("form_d.hapus",[null])}}/' + enc_id,
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

        </script>
        @endpush
