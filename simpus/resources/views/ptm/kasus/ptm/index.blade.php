@extends('layouts.table_ptm')
@section('title', 'Kasus PTM')
@section('judultable', 'Kasus PTM')
{{-- @section('subjudul', '(Kasus PTM)') --}}
@section('menu1', 'Kasus')
@section('menu2', 'Kasus PTM')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Kasus PTM</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="javascript:void(0);"
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-refresh"></i>&nbsp; Refresh</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-3">
                    <form action="{{ route('kasus_ptm.cetak_pdf') }}" method="POST">
                        {{ csrf_field() }}
                    <div class="d-flex justify-content-between my-3">
                        <div class="p-0">
                            <div class="form-group col-md" id="periode_bln">
                                <p class="font-bold">Range Periode</p>
                                <div class="form-group" id="range_periode">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class=" form-control rounded-left periode" id="start"
                                            name="start" value="{{ date('M-Y') }}" />
                                        <span class="input-group-addon px-3 bg-primary">to</span>
                                        <input type="text" class=" form-control rounded-right periode" id="end"
                                            name="end" value="{{ date('M-Y') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 my-auto">

                            <p>
                                <a class="btn btn-default" href=""> <i class=" fa fa-print"></i>
                                    &nbsp; Print</a>
                                <button type="submit" name="cetakan" value="pdf" class="btn btn-danger" href="#"> <i class=" fa fa-file-pdf-o"></i>
                                    &nbsp; PDF</button>
                                <button type="submit" name="cetakan" value="excel" class="btn btn-primary" href="#"> <i class=" fa fa-file-excel-o"></i>
                                    &nbsp; Excel</button>
                            </p>
                        </div>
                    </form>
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table p-0 table-bordered text-center table-hover"
                            style="overflow-x: auto;">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="align-middle bg-primary" rowspan="2">NO</th>
                                    <th class="align-middle" rowspan="2">GOLONGAN UMUR
                                    </th>
                                    <th class="bg-primary" colspan="3">IMA</th>
                                    <th class="bg-primary" colspan="3">Decom Cordis</th>
                                    <th class="bg-primary" colspan="3">Hipertensi</th>
                                    <th class="bg-primary" colspan="3">Stroke</th>
                                    <th class="bg-primary" colspan="3">DM Tgt Insulin</th>
                                    <th class="bg-primary" colspan="3">DM Tdk Tgt Insulin</th>
                                    <th class="bg-primary" colspan="3">Ca Mammae</th>
                                    <th class="bg-primary" colspan="3">Ca Cerviks</th>
                                    <th class="bg-primary" colspan="3">Leukimia</th>
                                    <th class="bg-primary" colspan="3">Retinoblastoma</th>
                                    <th class="bg-primary" colspan="3">Ca Colorektal</th>
                                    <th class="bg-primary" colspan="3">Thalasemia</th>
                                    <th class="bg-primary" colspan="3">PPOK</th>
                                    <th class="bg-primary" colspan="3">Asma Bronkhial</th>
                                    <th class="bg-primary" colspan="3">Gagal Ginjal Kronik</th>
                                    <th class="bg-primary" colspan="3">Osteoporosis</th>
                                    <th class="bg-primary" colspan="3">Obesitas</th>
                                </tr>
                                <tr class="bg-primary">
                                    <th style="z-index:50">L</th>
                                    <th style="z-index:50">P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                            <tfoot>
                                <tr class="text-center text-white bg-primary">
                                    <th></th>
                                    <th>Total</th>
                                    <th id="ima_l"></th>
                                    <th id="ima_p"></th>
                                    <th id="ima_total"></th>
                                    <th id="decompcordis_l"></th>
                                    <th id="decompcordis_p"></th>
                                    <th id="decompcordis_total"></th>
                                    <th id="hipertensi_l"></th>
                                    <th id="hipertensi_p"></th>
                                    <th id="hipertensi_total"></th>
                                    <th id="stroke_l"></th>
                                    <th id="stroke_p"></th>
                                    <th id="stroke_total"></th>
                                    <th id="dmtgtinsulin_l"></th>
                                    <th id="dmtgtinsulin_p"></th>
                                    <th id="dmtgtinsulin_total"></th>
                                    <th id="dmtdktgtinsulin_l"></th>
                                    <th id="dmtdktgtinsulin_p"></th>
                                    <th id="dmtdktgtinsulin_total"></th>
                                    <th id="camammae_l"></th>
                                    <th id="camammae_p"></th>
                                    <th id="camammae_total"></th>
                                    <th id="caserviks_l"></th>
                                    <th id="caserviks_p"></th>
                                    <th id="caserviks_total"></th>
                                    <th id="leukimia_l"></th>
                                    <th id="leukimia_p"></th>
                                    <th id="leukimia_total"></th>
                                    <th id="retiniblastoma_l"></th>
                                    <th id="retiniblastoma_p"></th>
                                    <th id="retiniblastoma_total"></th>
                                    <th id="cakolorectal_l"></th>
                                    <th id="cakolorectal_p"></th>
                                    <th id="cakolorectal_total"></th>
                                    <th id="talasemia_l"></th>
                                    <th id="talasemia_p"></th>
                                    <th id="talasemia_total"></th>
                                    <th id="ppok_l"></th>
                                    <th id="ppok_p"></th>
                                    <th id="ppok_total"></th>
                                    <th id="asmabronkhiale_l"></th>
                                    <th id="asmabronkhiale_p"></th>
                                    <th id="asmabronkhiale_total"></th>
                                    <th id="gagalginjalkronik_l"></th>
                                    <th id="gagalginjalkronik_p"></th>
                                    <th id="gagalginjalkronik_total"></th>
                                    <th id="osteoporosis_l"></th>
                                    <th id="osteoporosis_p"></th>
                                    <th id="osteoporosis_total"></th>
                                    <th id="obesitas_l"></th>
                                    <th id="obesitas_p"></th>
                                    <th id="obesitas_total"></th>
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
                // getsumdata();
                $(".btn-refresh").click(function() {
                    table.ajax.reload();
                });
                $.ajaxSetup({
                    headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
                });

                table = $('#table1').DataTable({
                    fixedColumns: {
                        left: 2
                    },
                    paginate:false,
                    "pagingType": "full_numbers",
                    pageLength: 50,
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
                    "ajax":{
                            "url": "{{ route("kasus_ptm.getdata") }}",
                            "dataType": "json",
                            "type": "POST",
                            data: function ( d ) {
                            d._token= "{{csrf_token()}}";
                            d.kabupaten = $('#select_kab option:selected').val()
                            d.puskesmas = $('#select_pusk option:selected').val()
                            d.periode_start = $('#start').val()
                            d.periode_end = $('#end').val()
                            },
                            "dataSrc": function(json){
                                //  console.log(json.sum_data);
                                $('#ima_l').text(json.sum_data.ima_l);
                                $('#ima_p').text(json.sum_data.ima_p);
                                $('#ima_total').text(json.sum_data.ima_total);
                                $('#decompcordis_l').text(json.sum_data.decompcordis_l);
                                $('#decompcordis_p').text(json.sum_data.decompcordis_p);
                                $('#decompcordis_total').text(json.sum_data.decompcordis_total);
                                $('#hipertensi_l').text(json.sum_data.hipertensi_l);
                                $('#hipertensi_p').text(json.sum_data.hipertensi_p);
                                $('#hipertensi_total').text(json.sum_data.hipertensi_total);
                                $('#stroke_l').text(json.sum_data.stroke_l);
                                $('#stroke_p').text(json.sum_data.stroke_p);
                                $('#stroke_total').text(json.sum_data.stroke_total);
                                $('#dmtgtinsulin_l').text(json.sum_data.dmtgtinsulin_l);
                                $('#dmtgtinsulin_p').text(json.sum_data.dmtgtinsulin_p);
                                $('#dmtgtinsulin_total').text(json.sum_data.dmtgtinsulin_total);
                                $('#dmtdktgtinsulin_l').text(json.sum_data.dmtdktgtinsulin_l);
                                $('#dmtdktgtinsulin_p').text(json.sum_data.dmtdktgtinsulin_p);
                                $('#dmtdktgtinsulin_total').text(json.sum_data.dmtdktgtinsulin_total);
                                $('#camammae_l').text(json.sum_data.camammae_l);
                                $('#camammae_p').text(json.sum_data.camammae_p);
                                $('#camammae_total').text(json.sum_data.camammae_total);
                                $('#caserviks_l').text(json.sum_data.caserviks_l);
                                $('#caserviks_p').text(json.sum_data.caserviks_p);
                                $('#caserviks_total').text(json.sum_data.caserviks_total);
                                $('#leukimia_l').text(json.sum_data.leukimia_l);
                                $('#leukimia_p').text(json.sum_data.leukimia_p);
                                $('#leukimia_total').text(json.sum_data.leukimia_total);
                                $('#retiniblastoma_l').text(json.sum_data.retiniblastoma_l);
                                $('#retiniblastoma_p').text(json.sum_data.retiniblastoma_p);
                                $('#retiniblastoma_total').text(json.sum_data.retiniblastoma_total);
                                $('#cakolorectal_l').text(json.sum_data.cakolorectal_l);
                                $('#cakolorectal_p').text(json.sum_data.cakolorectal_p);
                                $('#cakolorectal_total').text(json.sum_data.cakolorectal_total);
                                $('#talasemia_l').text(json.sum_data.talasemia_l);
                                $('#talasemia_p').text(json.sum_data.talasemia_p);
                                $('#talasemia_total').text(json.sum_data.talasemia_total);
                                $('#ppok_l').text(json.sum_data.ppok_l);
                                $('#ppok_p').text(json.sum_data.ppok_p);
                                $('#ppok_total').text(json.sum_data.ppok_total);
                                $('#asma_bronkhiale_l').text(json.sum_data.asmabronkhiale_l);
                                $('#asmabronkhiale_p').text(json.sum_data.asmabronkhiale_p);
                                $('#asmabronkhiale_total').text(json.sum_data.asmabronkhiale_total);
                                $('#gagalginjalkronik_l').text(json.sum_data.gagalginjalkronik_l);
                                $('#gagalginjalkronik_p').text(json.sum_data.gagalginjalkronik_p);
                                $('#gagalginjalkronik_total').text(json.sum_data.gagalginjalkronik_total);
                                $('#osteoporosis_l').text(json.sum_data.osteoporosis_l);
                                $('#osteoporosis_p').text(json.sum_data.osteoporosis_p);
                                $('#osteoporosis_total').text(json.sum_data.osteoporosis_total);
                                $('#obesitas_l').text(json.sum_data.obesitas_l);
                                $('#obesitas_p').text(json.sum_data.obesitas_p);
                                $('#obesitas_total').text(json.sum_data.obesitas_total);
                                return json.data;
                            }
                        },
                    "columns": [
                        {"data": "id"},
                        {"data": "golumur"},
                        {"data": "ima_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ima_l"' +
                                        ' name="' + row.id + 'ima_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "ima_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ima_p"' +
                                        ' name="' + row.id + 'ima_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "ima_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ima_total" disabled' +
                                        ' name="' + row.id + 'ima_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "decompcordis_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_decompcordis_l"' +
                                        ' name="' + row.id + 'decompcordis_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "decompcordis_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_decompcordis_p"' +
                                        ' name="' + row.id + 'decompcordis_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "decompcordis_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_decompcordis_total" disabled' +
                                        ' name="' + row.id + 'decompcordis_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "hipertensi_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_hipertensi_l"' +
                                        ' name="' + row.id + 'hipertensi_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "hipertensi_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_hipertensi_p"' +
                                        ' name="' + row.id + 'hipertensi_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "hipertensi_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_hipertensi_total" disabled' +
                                        ' name="' + row.id + 'hipertensi_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "stroke_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_stroke_l"' +
                                        ' name="' + row.id + 'stroke_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "stroke_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_stroke_p"' +
                                        ' name="' + row.id + 'stroke_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "stroke_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_stroke_total" disabled' +
                                        ' name="' + row.id + 'stroke_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtgtinsulin_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtgtinsulin_l"' +
                                        ' name="' + row.id + 'dmtgtinsulin_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtgtinsulin_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtgtinsulin_p"' +
                                        ' name="' + row.id + 'dmtgtinsulin_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtgtinsulin_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtgtinsulin_total" disabled' +
                                        ' name="' + row.id + 'dmtgtinsulin_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtdktgtinsulin_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtdktgtinsulin_l"' +
                                        ' name="' + row.id + 'dmtdktgtinsulin_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtdktgtinsulin_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtdktgtinsulin_p"' +
                                        ' name="' + row.id + 'dmtdktgtinsulin_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "dmtdktgtinsulin_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_dmtdktgtinsulin_total" disabled' +
                                        ' name="' + row.id + 'dmtdktgtinsulin_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "camammae_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_camammae_l"' +
                                        ' name="' + row.id + 'camammae_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "camammae_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_camammae_p"' +
                                        ' name="' + row.id + 'camammae_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "camammae_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_camammae_total" disabled' +
                                        ' name="' + row.id + 'camammae_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "caserviks_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_caserviks_l"' +
                                        ' name="' + row.id + 'caserviks_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "caserviks_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_caserviks_p"' +
                                        ' name="' + row.id + 'caserviks_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "caserviks_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_caserviks_total" disabled' +
                                        ' name="' + row.id + 'caserviks_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "leukimia_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_leukimia_l"' +
                                        ' name="' + row.id + 'leukimia_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "leukimia_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_leukimia_p"' +
                                        ' name="' + row.id + 'leukimia_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "leukimia_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_leukimia_total" disabled' +
                                        ' name="' + row.id + 'leukimia_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "retiniblastoma_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_retiniblastoma_l"' +
                                        ' name="' + row.id + 'retiniblastoma_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "retiniblastoma_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_retiniblastoma_p"' +
                                        ' name="' + row.id + 'retiniblastoma_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "retiniblastoma_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_retiniblastoma_total" disabled' +
                                        ' name="' + row.id + 'retiniblastoma_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "cakolorectal_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_cakolorectal_l"' +
                                        ' name="' + row.id + 'cakolorectal_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "cakolorectal_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_cakolorectal_p"' +
                                        ' name="' + row.id + 'cakolorectal_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "cakolorectal_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_cakolorectal_total" disabled' +
                                        ' name="' + row.id + 'cakolorectal_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "talasemia_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_talasemia_l"' +
                                        ' name="' + row.id + 'talasemia_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "talasemia_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_talasemia_p"' +
                                        ' name="' + row.id + 'talasemia_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "talasemia_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_talasemia_total" disabled' +
                                        ' name="' + row.id + 'talasemia_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "ppok_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ppok_l"' +
                                        ' name="' + row.id + 'ppok_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "ppok_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ppok_p"' +
                                        ' name="' + row.id + 'ppok_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "ppok_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_ppok_total" disabled' +
                                        ' name="' + row.id + 'ppok_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "asmabronkhiale_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_asmabronkhiale_l"' +
                                        ' name="' + row.id + 'asmabronkhiale_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "asmabronkhiale_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_asmabronkhiale_p"' +
                                        ' name="' + row.id + 'asmabronkhiale_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "asmabronkhiale_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_asmabronkhiale_total" disabled' +
                                        ' name="' + row.id + 'asmabronkhiale_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "gagalginjalkronik_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_gagalginjalkronik_l"' +
                                        ' name="' + row.id + 'gagalginjalkronik_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "gagalginjalkronik_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_gagalginjalkronik_p"' +
                                        ' name="' + row.id + 'gagalginjalkronik_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "gagalginjalkronik_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_gagalginjalkronik_total" disabled' +
                                        ' name="' + row.id + 'gagalginjalkronik_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "osteoporosis_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_osteoporosis_l"' +
                                        ' name="' + row.id + 'osteoporosis_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "osteoporosis_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_osteoporosis_p"' +
                                        ' name="' + row.id + 'osteoporosis_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "osteoporosis_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_osteoporosis_total" disabled' +
                                        ' name="' + row.id + 'osteoporosis_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "obesitas_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_obesitas_l"' +
                                        ' name="' + row.id + 'obesitas_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "obesitas_p",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_obesitas_p"' +
                                        ' name="' + row.id + 'obesitas_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "obesitas_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi.index')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '_obesitas_total" disabled' +
                                        ' name="' + row.id + 'obesitas_total">';
                                    return txt;
                                }
                            }
                        },
                    ],
                    buttons: [
                        {
                            extend: 'copy',
                            exportOptions: {
                                orthogonal: 'export'
                            },
                            header: true,
                            footer: true,
                            className: 'btn bg-default text-black',
                        },
                    ],
                    "drawCallback": function(setting){
                        $('.text-datatable').blur(function(e){
                            var attr = $(this).attr('id')
                            var nilai = $(this).val();

                            simpan_nilai(attr, nilai)
                        })
                    },
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
                $('.periode').on('change', function(){
                    table.ajax.reload(null, false);
                });

                $('.periode').datepicker({
                    minViewMode: 1,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "M-yyyy"
                });


            });
            function simpan_nilai(id, nilai){
                var periode_start = $('#start').val();
                var periode_end = $('#end').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('kasus_ptm.simpan') }}",
                    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                    data:{
                        id: id,
                        nilai: nilai,
                        periode_start: periode_start,
                        periode_end: periode_end,
                    },
                    success: function(resp){
                        console.log(resp);
                        if(resp.success == false){
                            // alert('periode tidak sama');
                            Swal.fire("Ups!", "Periode yang dipilih tidak sama.", "error");
                        }
                        table.ajax.reload(null, false);
                    }
                });
            }
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
                            url: '{{route("kasus_ptm.hapus",[null])}}/' + enc_id,
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
