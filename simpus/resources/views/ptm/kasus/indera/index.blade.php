@extends('layouts.table_ptm')
@section('title', 'Kasus Ganguan Indera Penglihatan dan Pendengaran')
@section('judultable', 'Kasus Ganguan Indera Penglihatan dan Pendengaran')
{{-- @section('subjudul', '(Kasus Ganguan Penglihatan dan Pendengaran)') --}}
@section('menu1', 'Kasus')
@section('menu2', 'Kasus Ganguan Penglihatan dan Pendengaran')
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
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Jenis Gangguan Penglihatan dan Kebutaan (H00-H59)</h3>
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
                    <div class="d-flex justify-content-between my-3">
                        <div class="form-group row">
                            <label for="periode" class="col-md-3 col-form-label">Periode</label>
                            <div class="col-md-9">
                                <div class="form-group" id="range_periode">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control-sm form-control rounded-left periode"
                                            id="start" name="start" value="{{ date('M-Y') }}" />
                                        <span class="input-group-addon px-3 bg-primary">to</span>
                                        <input type="text"
                                            class="form-control-sm form-control rounded-right periode" id="end"
                                            name="end" value="{{ date('M-Y') }}" />
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
                        <table id="table1" class="table p-0 table-bordered table-hover nowrap"
                            style="overflow-x: auto;">
                            <thead>
                                <tr class="text-white text-center bg-green">
                                    <th width="5%" class="align-middle" rowspan="3">No</th>
                                    <th width="20%" class="align-middle" rowspan="3">KEGIATAN</th>
                                    <th class="align-middle" colspan="20">JUMLAH KASUS BARU MENURUT GOLONGAN
                                        UMUR</th>
                                    <th class="align-middle" colspan="3">JUMLAH</th>
                                    <th class="align-middle" colspan="3">JUMLAH</th>
                                    <th class="align-middle" colspan="3">TOTAL</th>
                                    <th class="align-middle" rowspan="3">JUMLAH KASUS DIRUJUK</th>
                                </tr>
                                <tr class="text-white text-center bg-green">
                                    <th class="align-middle" colspan="2">0-7hr</th>
                                    <th class="align-middle" colspan="2">2-28hr</th>
                                    <th class="align-middle" colspan="2">1-11bln</th>
                                    <th class="align-middle" colspan="2">1-4thn</th>
                                    <th class="align-middle" colspan="2">5-9thn</th>
                                    <th class="align-middle" colspan="2">10-14thn</th>
                                    <th class="align-middle" colspan="2">15-19thn</th>
                                    <th class="align-middle" colspan="2">20-44thn</th>
                                    <th class="align-middle" colspan="2">45-59thn</th>
                                    <th class="align-middle" colspan="2">>59thn</th>
                                    <th class="align-middle" colspan="3">KASUS BARU</th>
                                    <th class="align-middle" colspan="3">KASUS LAMA</th>
                                    <th class="align-middle" colspan="3">KUNJUNGAN</th>
                                </tr>
                                <tr class="text-white text-center bg-green">
                                    <th class="align-middle" style="z-index: 55">L</th>
                                    <th class="align-middle" style="z-index: 55">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <td colspan="30">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr> --}}
                                <tr class="text-white text-center bg-green">
                                    <th></th>
                                    <th>Total</th>
                                    <th id="lihatumur_0_7hr_l"> 0</th>
                                    <th id="lihatumur_0_7hr_p"> 0</th>
                                    <th id="lihatumur_2_28hr_l"> 0</th>
                                    <th id="lihatumur_2_28hr_p"> 0</th>
                                    <th id="lihatumur_1_11bln_l"> 0</th>
                                    <th id="lihatumur_1_11bln_p"> 0</th>
                                    <th id="lihatumur_1_4thn_l"> 0</th>
                                    <th id="lihatumur_1_4thn_p"> 0</th>
                                    <th id="lihatumur_5_9thn_l"> 0</th>
                                    <th id="lihatumur_5_9thn_p"> 0</th>
                                    <th id="lihatumur_10_14thn_l"> 0</th>
                                    <th id="lihatumur_10_14thn_p"> 0</th>
                                    <th id="lihatumur_15_19thn_l"> 0</th>
                                    <th id="lihatumur_15_19thn_p"> 0</th>
                                    <th id="lihatumur_20_44thn_l"> 0</th>
                                    <th id="lihatumur_20_44thn_p"> 0</th>
                                    <th id="lihatumur_45_59thn_l"> 0</th>
                                    <th id="lihatumur_45_59thn_p"> 0</th>
                                    <th id="lihatumur_lebih_59thn_l"> 0</th>
                                    <th id="lihatumur_lebih_59thn_p"> 0</th>
                                    <th id="lihatkasus_baru_l"> 0</th>
                                    <th id="lihatkasus_baru_p"> 0</th>
                                    <th id="lihatkasus_baru_total"> 0</th>
                                    <th id="lihatkasus_lama_l"> 0</th>
                                    <th id="lihatkasus_lama_p"> 0</th>
                                    <th id="lihatkasus_lama_total"> 0</th>
                                    <th id="lihatkunjungan_l"> 0</th>
                                    <th id="lihatkunjungan_p"> 0</th>
                                    <th id="lihattotal_kunjungan"> 0</th>
                                    <th id="lihatkasus_dirujuk"> 0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Jenis Gangguan Pendengaran dan Ketulia (H60 - H95)</h3>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-3">
                    <div class="table-responsive">
                        <table id="table2" class="table p-0 table-bordered table-hover nowrap"
                            style="overflow-x: auto;">
                            <thead>
                                <tr class="text-white text-center bg-green">
                                    <th width="5%" class="align-middle" rowspan="3">No</th>
                                    <th width="20%" class="align-middle" rowspan="3">KEGIATAN</th>
                                    <th class="align-middle" colspan="20">JUMLAH KASUS BARU MENURUT GOLONGAN
                                        UMUR</th>
                                    <th class="align-middle" colspan="3">JUMLAH</th>
                                    <th class="align-middle" colspan="3">JUMLAH</th>
                                    <th class="align-middle" colspan="3">TOTAL</th>
                                    <th class="align-middle" rowspan="3">JUMLAH KASUS DIRUJUK</th>
                                </tr>
                                <tr class="text-white text-center bg-green">
                                    <th class="align-middle" colspan="2">0-7hr</th>
                                    <th class="align-middle" colspan="2">2-28hr</th>
                                    <th class="align-middle" colspan="2">1-11bln</th>
                                    <th class="align-middle" colspan="2">1-4thn</th>
                                    <th class="align-middle" colspan="2">5-9thn</th>
                                    <th class="align-middle" colspan="2">10-14thn</th>
                                    <th class="align-middle" colspan="2">15-19thn</th>
                                    <th class="align-middle" colspan="2">20-44thn</th>
                                    <th class="align-middle" colspan="2">45-59thn</th>
                                    <th class="align-middle" colspan="2">>59thn</th>
                                    <th class="align-middle" colspan="3">KASUS BARU</th>
                                    <th class="align-middle" colspan="3">KASUS LAMA</th>
                                    <th class="align-middle" colspan="3">KUNJUNGAN</th>
                                </tr>
                                <tr class="text-white text-center bg-green">
                                    <th class="align-middle" style="z-index: 55">L</th>
                                    <th class="align-middle" style="z-index: 55">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">L</th>
                                    <th class="align-middle">P</th>
                                    <th class="align-middle">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <td colspan="30">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr> --}}
                                <tr class="text-white text-center bg-green">
                                    <th></th>
                                    <th>Total</th>
                                    <th id="dengarumur_0_7hr_l"> 0</th>
                                    <th id="dengarumur_0_7hr_p"> 0</th>
                                    <th id="dengarumur_2_28hr_l"> 0</th>
                                    <th id="dengarumur_2_28hr_p"> 0</th>
                                    <th id="dengarumur_1_11bln_l"> 0</th>
                                    <th id="dengarumur_1_11bln_p"> 0</th>
                                    <th id="dengarumur_1_4thn_l"> 0</th>
                                    <th id="dengarumur_1_4thn_p"> 0</th>
                                    <th id="dengarumur_5_9thn_l"> 0</th>
                                    <th id="dengarumur_5_9thn_p"> 0</th>
                                    <th id="dengarumur_10_14thn_l"> 0</th>
                                    <th id="dengarumur_10_14thn_p"> 0</th>
                                    <th id="dengarumur_15_19thn_l"> 0</th>
                                    <th id="dengarumur_15_19thn_p"> 0</th>
                                    <th id="dengarumur_20_44thn_l"> 0</th>
                                    <th id="dengarumur_20_44thn_p"> 0</th>
                                    <th id="dengarumur_45_59thn_l"> 0</th>
                                    <th id="dengarumur_45_59thn_p"> 0</th>
                                    <th id="dengarumur_lebih_59thn_l"> 0</th>
                                    <th id="dengarumur_lebih_59thn_p"> 0</th>
                                    <th id="dengarkasus_baru_l"> 0</th>
                                    <th id="dengarkasus_baru_p"> 0</th>
                                    <th id="dengarkasus_baru_total"> 0</th>
                                    <th id="dengarkasus_lama_l"> 0</th>
                                    <th id="dengarkasus_lama_p"> 0</th>
                                    <th id="dengarkasus_lama_total"> 0</th>
                                    <th id="dengarkunjungan_l"> 0</th>
                                    <th id="dengarkunjungan_p"> 0</th>
                                    <th id="dengartotal_kunjungan"> 0</th>
                                    <th id="dengarkasus_dirujuk"> 0</th>
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
                table1 = $('#table1').DataTable({
                    fixedColumns: {
                        left: 2
                    },
                    "pagingType": "full_numbers",
                    pageLength: 25,
                    // "processing": true,
                    // "serverSide": true,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "select" : true,
                    "ajax":{
                             "url": "{{ route('kasus_indera.getdata_penglihatan') }}",
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
                                $('#lihatumur_0_7hr_l').text(json.sum_data.umur_0_7hr_l);
                                $('#lihatumur_0_7hr_p').text(json.sum_data.umur_0_7hr_p);
                                $('#lihatumur_2_28hr_l').text(json.sum_data.umur_2_28hr_l);
                                $('#lihatumur_2_28hr_p').text(json.sum_data.umur_2_28hr_p);
                                $('#lihatumur_1_11bln_l').text(json.sum_data.umur_1_11bln_l);
                                $('#lihatumur_1_11bln_p').text(json.sum_data.umur_1_11bln_p);
                                $('#lihatumur_1_4thn_l').text(json.sum_data.umur_1_4thn_l);
                                $('#lihatumur_1_4thn_p').text(json.sum_data.umur_1_4thn_p);
                                $('#lihatumur_5_9thn_l').text(json.sum_data.umur_5_9thn_l);
                                $('#lihatumur_5_9thn_p').text(json.sum_data.umur_5_9thn_p);
                                $('#lihatumur_10_14thn_l').text(json.sum_data.umur_10_14thn_l);
                                $('#lihatumur_10_14thn_p').text(json.sum_data.umur_10_14thn_p);
                                $('#lihatumur_15_19thn_l').text(json.sum_data.umur_15_19thn_l);
                                $('#lihatumur_15_19thn_p').text(json.sum_data.umur_15_19thn_p);
                                $('#lihatumur_20_44thn_l').text(json.sum_data.umur_20_44thn_l);
                                $('#lihatumur_20_44thn_p').text(json.sum_data.umur_20_44thn_p);
                                $('#lihatumur_45_59thn_l').text(json.sum_data.umur_45_59thn_l);
                                $('#lihatumur_45_59thn_p').text(json.sum_data.umur_45_59thn_p);
                                $('#lihatumur_lebih_59thn_l').text(json.sum_data.umur_lebih_59thn_l);
                                $('#lihatumur_lebih_59thn_p').text(json.sum_data.umur_lebih_59thn_p);
                                $('#lihatkasus_baru_l').text(json.sum_data.kasus_baru_l);
                                $('#lihatkasus_baru_p').text(json.sum_data.kasus_baru_p);
                                $('#lihatkasus_baru_total').text(json.sum_data.kasus_baru_total);
                                $('#lihatkasus_lama_l').text(json.sum_data.kasus_lama_l);
                                $('#lihatkasus_lama_p').text(json.sum_data.kasus_lama_p);
                                $('#lihatkasus_lama_total').text(json.sum_data.kasus_lama_total);
                                $('#lihatkunjungan_l').text(json.sum_data.kunjungan_l);
                                $('#lihatkunjungan_p').text(json.sum_data.kunjungan_p);
                                $('#lihattotal_kunjungan').text(json.sum_data.total_kunjungan);
                                $('#lihatkasus_dirujuk').text(json.sum_data.kasus_dirujuk);
                                return json.data
                             }
                    },
                    "createdRow": function(row, data, index){

                        // $('td:eq(1)', row).attr('colspan', 3);
                        // $('td:eq(2)', row).css('display', 'none');
                        // $('td:eq(3)', row).css('display', 'none');

                        // // Update cell data
                        // this.api().cell($('td:eq(1)', row)).data('N/A');
                        // console.log(data);
                        if(data.id == 1){
                            $('td:eq(1)', row).attr('colspan', 31);
                            for(i=2;i<=31;i++){
                                $('td:eq('+i+')', row).css('display', 'none');

                            }
                            // $('td:eq(3)', row).css('display', 'none');

                            // Update cell data
                            this.api().cell($('td:eq(1)', row)).data('<b>'+data.kegiatan+'</b>');
                        }
                    },
                    "columns": [
                        {"data": "no",
                            render: function(data, type, row) {
                                // console.log(data);
                                if(type === 'export'){
                                    return data;
                                }else{
                                    if(data != 1){
                                        var txt = '<p style="display:none">1</p>'
                                        return txt;
                                    }else{
                                        return 1;
                                    }
                                }
                            }
                        },
                        {"data": "kegiatan",
                            "className": "text-nowrap",
                        },
                        {"data": "umur_0_7hr_l",
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
                                        ' id="' + row.id + '-umur_0_7hr_l"' +
                                        ' name="' + row.id + '-umur_0_7hr_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_0_7hr_p",
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
                                        ' id="' + row.id + '-umur_0_7hr_p"' +
                                        ' name="' + row.id + '-umur_0_7hr_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_2_28hr_l",
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
                                        ' id="' + row.id + '-umur_2_28hr_l"' +
                                        ' name="' + row.id + '-umur_2_28hr_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_2_28hr_p",
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
                                        ' id="' + row.id + '-umur_2_28hr_p"' +
                                        ' name="' + row.id + '-umur_2_28hr_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_11bln_l",
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
                                        ' id="' + row.id + '-umur_1_11bln_l"' +
                                        ' name="' + row.id + '-umur_1_11bln_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_11bln_p",
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
                                        ' id="' + row.id + '-umur_1_11bln_p"' +
                                        ' name="' + row.id + '-umur_1_11bln_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_4thn_l",
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
                                        ' id="' + row.id + '-umur_1_4thn_l"' +
                                        ' name="' + row.id + '-umur_1_4thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_4thn_p",
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
                                        ' id="' + row.id + '-umur_1_4thn_p"' +
                                        ' name="' + row.id + '-umur_1_4thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_5_9thn_l",
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
                                        ' id="' + row.id + '-umur_5_9thn_l"' +
                                        ' name="' + row.id + '-umur_5_9thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_5_9thn_p",
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
                                        ' id="' + row.id + '-umur_5_9thn_p"' +
                                        ' name="' + row.id + '-umur_5_9thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_10_14thn_l",
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
                                        ' id="' + row.id + '-umur_10_14thn_l"' +
                                        ' name="' + row.id + '-umur_10_14thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_10_14thn_p",
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
                                        ' id="' + row.id + '-umur_10_14thn_p"' +
                                        ' name="' + row.id + '-umur_10_14thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_15_19thn_l",
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
                                        ' id="' + row.id + '-umur_15_19thn_l"' +
                                        ' name="' + row.id + '-umur_15_19thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_15_19thn_p",
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
                                        ' id="' + row.id + '-umur_15_19thn_p"' +
                                        ' name="' + row.id + '-umur_15_19thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_20_44thn_l",
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
                                        ' id="' + row.id + '-umur_20_44thn_l"' +
                                        ' name="' + row.id + '-umur_20_44thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_20_44thn_p",
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
                                        ' id="' + row.id + '-umur_20_44thn_p"' +
                                        ' name="' + row.id + '-umur_20_44thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_45_59thn_l",
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
                                        ' id="' + row.id + '-umur_45_59thn_l"' +
                                        ' name="' + row.id + '-umur_45_59thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_45_59thn_p",
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
                                        ' id="' + row.id + '-umur_45_59thn_p"' +
                                        ' name="' + row.id + '-umur_45_59thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_lebih_59thn_l",
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
                                        ' id="' + row.id + '-umur_lebih_59thn_l"' +
                                        ' name="' + row.id + '-umur_lebih_59thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_lebih_59thn_p",
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
                                        ' id="' + row.id + '-umur_lebih_59thn_p"' +
                                        ' name="' + row.id + '-umur_lebih_59thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_l",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        @can('provinsi. ')
                                        'disabled'+
                                        @endcan
                                        @can('kabupaten.index')
                                        'disabled'+
                                        @endcan
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-kasus_baru_l"' +
                                        ' name="' + row.id + '-kasus_baru_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_p",
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
                                        ' id="' + row.id + '-kasus_baru_p"' +
                                        ' name="' + row.id + '-kasus_baru_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-kasus_baru_total"' +
                                        ' name="' + row.id + '-kasus_baru_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_l",
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
                                        ' id="' + row.id + '-kasus_lama_l"' +
                                        ' name="' + row.id + '-kasus_lama_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_p",
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
                                        ' id="' + row.id + '-kasus_lama_p"' +
                                        ' name="' + row.id + '-kasus_lama_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-kasus_lama_total"' +
                                        ' name="' + row.id + '-kasus_lama_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kunjungan_l",
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
                                        ' id="' + row.id + '-kunjungan_l"' +
                                        ' name="' + row.id + '-kunjungan_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kunjungan_p",
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
                                        ' id="' + row.id + '-kunjungan_p"' +
                                        ' name="' + row.id + '-kunjungan_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "total_kunjungan",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-total_kunjungan"' +
                                        ' name="' + row.id + '-total_kunjungan">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_dirujuk",
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
                                        ' id="' + row.id + '-kasus_dirujuk"' +
                                        ' name="' + row.id + '-kasus_dirujuk">';
                                    return txt;
                                }
                            }
                        },
                    ],
                    "drawCallback": function(setting){
                        $('.text-datatable').blur(function(e){
                            var attr = $(this).attr('id')
                            var nilai = $(this).val();
                            // console.log('tes');
                            simpan_nilai(attr, nilai)
                        })
                    },
                    responsive: true,
                    language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Cari data",
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

                table2 = $('#table2').DataTable({
                    fixedColumns: {
                        left: 2
                    },
                    "pagingType": "full_numbers",
                    pageLength: 25,
                    // "processing": true,
                    // "serverSide": true,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "select" : true,
                    "ajax":{
                             "url": "{{ route('kasus_indera.getdata_pendengaran') }}",
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
                                $('#dengarumur_0_7hr_l').text(json.sum_data.umur_0_7hr_l);
                                $('#dengarumur_0_7hr_p').text(json.sum_data.umur_0_7hr_p);
                                $('#dengarumur_2_28hr_l').text(json.sum_data.umur_2_28hr_l);
                                $('#dengarumur_2_28hr_p').text(json.sum_data.umur_2_28hr_p);
                                $('#dengarumur_1_11bln_l').text(json.sum_data.umur_1_11bln_l);
                                $('#dengarumur_1_11bln_p').text(json.sum_data.umur_1_11bln_p);
                                $('#dengarumur_1_4thn_l').text(json.sum_data.umur_1_4thn_l);
                                $('#dengarumur_1_4thn_p').text(json.sum_data.umur_1_4thn_p);
                                $('#dengarumur_5_9thn_l').text(json.sum_data.umur_5_9thn_l);
                                $('#dengarumur_5_9thn_p').text(json.sum_data.umur_5_9thn_p);
                                $('#dengarumur_10_14thn_l').text(json.sum_data.umur_10_14thn_l);
                                $('#dengarumur_10_14thn_p').text(json.sum_data.umur_10_14thn_p);
                                $('#dengarumur_15_19thn_l').text(json.sum_data.umur_15_19thn_l);
                                $('#dengarumur_15_19thn_p').text(json.sum_data.umur_15_19thn_p);
                                $('#dengarumur_20_44thn_l').text(json.sum_data.umur_20_44thn_l);
                                $('#dengarumur_20_44thn_p').text(json.sum_data.umur_20_44thn_p);
                                $('#dengarumur_45_59thn_l').text(json.sum_data.umur_45_59thn_l);
                                $('#dengarumur_45_59thn_p').text(json.sum_data.umur_45_59thn_p);
                                $('#dengarumur_lebih_59thn_l').text(json.sum_data.umur_lebih_59thn_l);
                                $('#dengarumur_lebih_59thn_p').text(json.sum_data.umur_lebih_59thn_p);
                                $('#dengarkasus_baru_l').text(json.sum_data.kasus_baru_l);
                                $('#dengarkasus_baru_p').text(json.sum_data.kasus_baru_p);
                                $('#dengarkasus_baru_total').text(json.sum_data.kasus_baru_total);
                                $('#dengarkasus_lama_l').text(json.sum_data.kasus_lama_l);
                                $('#dengarkasus_lama_p').text(json.sum_data.kasus_lama_p);
                                $('#dengarkasus_lama_total').text(json.sum_data.kasus_lama_total);
                                $('#dengarkunjungan_l').text(json.sum_data.kunjungan_l);
                                $('#dengarkunjungan_p').text(json.sum_data.kunjungan_p);
                                $('#dengartotal_kunjungan').text(json.sum_data.total_kunjungan);
                                $('#dengarkasus_dirujuk').text(json.sum_data.kasus_dirujuk);
                                return json.data;
                             }
                    },
                    "createdRow": function(row, data, index){

                    // $('td:eq(1)', row).attr('colspan', 3);
                    // $('td:eq(2)', row).css('display', 'none');
                    // $('td:eq(3)', row).css('display', 'none');

                    // // Update cell data
                    // this.api().cell($('td:eq(1)', row)).data('N/A');
                    // console.log(data);
                        if(data.id == 15){
                            $('td:eq(1)', row).attr('colspan', 31);
                            for(i=2;i<=31;i++){
                                $('td:eq('+i+')', row).css('display', 'none');

                            }
                            // $('td:eq(3)', row).css('display', 'none');

                            // Update cell data
                            this.api().cell($('td:eq(1)', row)).data('<b>'+data.kegiatan+'</b>');
                        }
                    },
                    "columns": [
                        {"data": "no",
                            render: function(data, type, row) {
                                // console.log(data);
                                if(type === 'export'){
                                    return data;
                                }else{
                                    if(data != 1){
                                        var txt = '<p style="display:none">1</p>'
                                        return txt;
                                    }else{
                                        return 1;
                                    }
                                }
                            }
                        },
                        {"data": "kegiatan",
                            "className": "text-nowrap",
                        },
                        {"data": "umur_0_7hr_l",
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
                                        ' id="' + row.id + '-umur_0_7hr_l"' +
                                        ' name="' + row.id + '-umur_0_7hr_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_0_7hr_p",
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
                                        ' id="' + row.id + '-umur_0_7hr_p"' +
                                        ' name="' + row.id + '-umur_0_7hr_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_2_28hr_l",
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
                                        ' id="' + row.id + '-umur_2_28hr_l"' +
                                        ' name="' + row.id + '-umur_2_28hr_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_2_28hr_p",
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
                                        ' id="' + row.id + '-umur_2_28hr_p"' +
                                        ' name="' + row.id + '-umur_2_28hr_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_11bln_l",
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
                                        ' id="' + row.id + '-umur_1_11bln_l"' +
                                        ' name="' + row.id + '-umur_1_11bln_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_11bln_p",
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
                                        ' id="' + row.id + '-umur_1_11bln_p"' +
                                        ' name="' + row.id + '-umur_1_11bln_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_4thn_l",
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
                                        ' id="' + row.id + '-umur_1_4thn_l"' +
                                        ' name="' + row.id + '-umur_1_4thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_1_4thn_p",
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
                                        ' id="' + row.id + '-umur_1_4thn_p"' +
                                        ' name="' + row.id + '-umur_1_4thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_5_9thn_l",
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
                                        ' id="' + row.id + '-umur_5_9thn_l"' +
                                        ' name="' + row.id + '-umur_5_9thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_5_9thn_p",
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
                                        ' id="' + row.id + '-umur_5_9thn_p"' +
                                        ' name="' + row.id + '-umur_5_9thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_10_14thn_l",
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
                                        ' id="' + row.id + '-umur_10_14thn_l"' +
                                        ' name="' + row.id + '-umur_10_14thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_10_14thn_p",
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
                                        ' id="' + row.id + '-umur_10_14thn_p"' +
                                        ' name="' + row.id + '-umur_10_14thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_15_19thn_l",
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
                                        ' id="' + row.id + '-umur_15_19thn_l"' +
                                        ' name="' + row.id + '-umur_15_19thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_15_19thn_p",
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
                                        ' id="' + row.id + '-umur_15_19thn_p"' +
                                        ' name="' + row.id + '-umur_15_19thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_20_44thn_l",
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
                                        ' id="' + row.id + '-umur_20_44thn_l"' +
                                        ' name="' + row.id + '-umur_20_44thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_20_44thn_p",
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
                                        ' id="' + row.id + '-umur_20_44thn_p"' +
                                        ' name="' + row.id + '-umur_20_44thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_45_59thn_l",
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
                                        ' id="' + row.id + '-umur_45_59thn_l"' +
                                        ' name="' + row.id + '-umur_45_59thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_45_59thn_p",
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
                                        ' id="' + row.id + '-umur_45_59thn_p"' +
                                        ' name="' + row.id + '-umur_45_59thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_lebih_59thn_l",
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
                                        ' id="' + row.id + '-umur_lebih_59thn_l"' +
                                        ' name="' + row.id + '-umur_lebih_59thn_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "umur_lebih_59thn_p",
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
                                        ' id="' + row.id + '-umur_lebih_59thn_p"' +
                                        ' name="' + row.id + '-umur_lebih_59thn_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_l",
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
                                        ' id="' + row.id + '-kasus_baru_p"' +
                                        ' name="' + row.id + '-kasus_baru_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_p",
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
                                        ' id="' + row.id + '-kasus_baru_p"' +
                                        ' name="' + row.id + '-kasus_baru_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_baru_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-kasus_baru_total"' +
                                        ' name="' + row.id + '-kasus_baru_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_l",
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
                                        ' id="' + row.id + '-kasus_lama_l"' +
                                        ' name="' + row.id + '-kasus_lama_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_p",
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
                                        ' id="' + row.id + '-kasus_lama_p"' +
                                        ' name="' + row.id + '-kasus_lama_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_lama_total",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-kasus_lama_total"' +
                                        ' name="' + row.id + '-kasus_lama_total">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kunjungan_l",
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
                                        ' id="' + row.id + '-kunjungan_l"' +
                                        ' name="' + row.id + '-kunjungan_l">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kunjungan_p",
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
                                        ' id="' + row.id + '-kunjungan_p"' +
                                        ' name="' + row.id + '-kunjungan_p">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "total_kunjungan",
                        render: function(data, type, row) {
                                if (type === 'export') {
                                    return data;
                                } else {
                                    var txt =
                                        '<input type="text" class="text-datatable"' +
                                        'disabled'+
                                        ' value="' + data + '"' +
                                        ' id="' + row.id + '-total_kunjungan"' +
                                        ' name="' + row.id + '-total_kunjungan">';
                                    return txt;
                                }
                            }
                        },
                        {"data": "kasus_dirujuk",
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
                                        ' id="' + row.id + '-kasus_dirujuk"' +
                                        ' name="' + row.id + '-kasus_dirujuk">';
                                    return txt;
                                }
                            }
                        },
                    ],
                    "drawCallback": function(setting){
                        $('.text-datatable').blur(function(e){
                            var attr = $(this).attr('id')
                            var nilai = $(this).val();

                            simpan_nilai(attr, nilai)
                        })
                    },
                    responsive: true,
                    language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Cari data",
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

                $(document).on('change','#select_pusk', function(){
                    var kabupaten = $('#select_kab option:selected').val()
                    console.log(kabupaten);
                    if(kabupaten != ''){
                        console.log('reload');
                        table1.ajax.reload(null, false);
                        table2.ajax.reload(null, false);
                    }else{
                        Swal.fire("Ups", "Pilih kabupaten terlebih dahulu", "info");
                    }
                })
                @can('provinsi.index')
                $(document).on('change', '#select_kab', function(){
                    table1.ajax.reload(null, false);
                    table2.ajax.reload(null, false);
                    console.log(this.value);
                    if(this.value != ""){
                        $("#select_pusk").select2({
                            placeholder: "Pilih Puskesmas .....",
                            allowClear: true,
                            ajax: {
                                url: "{{ route('jiwa.filter_puskesmas') }}",
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
                    }else{
                        $('#select_pusk').select2();
                    }
                });
                @endcan
                @can('balkesmas.index')
                $(document).on('change', '#select_kab', function(){
                    table1.ajax.reload(null, false);
                    table2.ajax.reload(null, false);
                    console.log(this.value);
                    if(this.value != ""){
                        $("#select_pusk").select2({
                            placeholder: "Pilih Puskesmas .....",
                            allowClear: true,
                            ajax: {
                                url: "{{ route('jiwa.filter_puskesmas') }}",
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
                    }else{
                        $('#select_pusk').select2();
                    }
                });
                @endcan
                $('#select_pusk').select2();
                @can('kabupaten.index')
                $("#select_pusk").select2({
                    placeholder: "Pilih Puskesmas .....",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('jiwa.filter_puskesmas') }}",
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
                @endcan


                $(document).on('change','#start, #end ', function(){
                    // console.log('tes');
                    table1.ajax.reload(null, false);
                    table2.ajax.reload(null, false);
                })
                // $(document).on('change','#periode', function(){
                //     table.ajax.reload(null, false);
                // })

                $('#start, #end').datepicker({
                        minViewMode: 1,
                        keyboardNavigation: false,
                        forceParse: false,
                        forceParse: false,
                        autoclose: true,
                        todayHighlight: true,
                        format: "M-yyyy"
                });

                $("#select_kab").select2();

            });
        </script>

        <script>
            function simpan_nilai(id, nilai){
                let start = $('#start').val();
                let end = $('#end').val();
                if(start != end){
                    Swal.fire('Ups!', 'Periode yang dipilih tidak sama', 'warning');
                    return;
                }
                var tahun = $('#start').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('kasus_indera.simpan') }}",
                    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                    data:{
                        id: id,
                        nilai: nilai,
                        tahun: tahun,
                    },
                    success: function(resp){
                        console.log(resp);
                    }
                });

            }

            function cetak(){
                console.log($('#table1').html());
            }
        </script>
        @endpush
