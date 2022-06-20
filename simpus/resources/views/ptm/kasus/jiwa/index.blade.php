@extends('layouts.table_ptm')
@section('title', 'Kasus Gangguan Jiwa')
@section('judultable', 'Kasus Gangguan Jiwa')
{{-- @section('subjudul', '(Kasus Gangguan Jiwa)') --}}
@section('menu1', 'Kasus')
@section('menu2', 'Kasus Gangguan Jiwa')
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
                            <h3 class="ml-3">Kasus Gangguan Jiwa</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('kasus_jiwa.tambah') }}" class="btn btn-primary b-r-xl"><i
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
                                        name="periode" id="periode" name="periode" autocomplete="off" value="{{ date('M-Y') }}">
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
                                <tr class="text-white bg-green">
                                    <th width="5%" class="align-middle" rowspan="4">No</th>


                                    <th class="align-middle" rowspan="4">PUSKESMAS</th>


                                    <th class="align-middle text-center" colspan="74">D I A G N O S A</th>
                                    <th class="align-middle text-center" rowspan="4">JUMLAH KASUS</th>

                                    <th class="align-middle" rowspan="4">Action</th>

                                </tr>
                                <tr class="text-white bg-green">
                                    <th class="align-middle text-center" colspan="2" rowspan="2">DEMENSIA F00</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN ANSIETAS F.40</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN CAMPURAN ANSIETAS DAN DEPRESI
                                        F41.2</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN DEPRESI F.32</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN PENYALAHGUNAAN NAPZA F10#</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN PERKEMBANGAN PADA ANAK DAN REMAJA
                                        F80-90#</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN PSIKOTIK AKUT F23#</th>
                                    <th class="align-middle text-center" colspan="6">SKIZOFRENIA F20</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN SOMATOFORM F45</th>
                                    <th class="align-middle text-center" colspan="6">INSOMNIA F51.0</th>
                                    <th class="align-middle text-center" colspan="6">PERCOBAAN BUNUH DIRI</th>
                                    <th class="align-middle text-center" colspan="6">REDARTASI MENTAL F.70 - F.79</th>
                                    <th class="align-middle text-center" colspan="6">GANGGUAN KEPRIBADIAN DAN PERILAKU F.60-F.61
                                    </th>
                                </tr>
                                <tr class="text-white bg-green">
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center" colspan="2">>=60 th</th>
                                </tr>
                                <tr class="text-white bg-green">
                                    <th class="align-middle text-center" style="z-index: 55">L</th>
                                    <th class="align-middle text-center" style="z-index: 55">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr class="text-white text-center bg-primary">
                                    <th>Total</th>
                                    <th id="puskesmas"></th>
                                    <th id="demensia_l"></th>
                                    <th id="demensia_p"></th>
                                    <th id="g_ansietas_0_14_l"></th>
                                    <th id="g_ansietas_0_14_p"></th>
                                    <th id="g_ansietas_15_59_l"></th>
                                    <th id="g_ansietas_15_59_p"></th>
                                    <th id="g_ansietas_60_l"></th>
                                    <th id="g_ansietas_60_p"></th>
                                    <th id="g_ansietas_depresi_0_14_l"></th>
                                    <th id="g_ansietas_depresi_0_14_p"></th>
                                    <th id="g_ansietas_depresi_15_59_l"></th>
                                    <th id="g_ansietas_depresi_15_59_p"></th>
                                    <th id="g_ansietas_depresi_60_l"></th>
                                    <th id="g_ansietas_depresi_60_p"></th>
                                    <th id="g_depresi_0_14_l"></th>
                                    <th id="g_depresi_0_14_p"></th>
                                    <th id="g_depresi_15_59_l"></th>
                                    <th id="g_depresi_15_59_p"></th>
                                    <th id="g_depresi_60_l"></th>
                                    <th id="g_depresi_60_p"></th>
                                    <th id="g_penyalahgunaan_napza_0_14_l"></th>
                                    <th id="g_penyalahgunaan_napza_0_14_p"></th>
                                    <th id="g_penyalahgunaan_napza_15_59_l"></th>
                                    <th id="g_penyalahgunaan_napza_15_59_p"></th>
                                    <th id="g_penyalahgunaan_napza_60_l"></th>
                                    <th id="g_penyalahgunaan_napza_60_p"></th>
                                    <th id="g_anak_remaja_0_14_l"></th>
                                    <th id="g_anak_remaja_0_14_p"></th>
                                    <th id="g_anak_remaja_15_59_l"></th>
                                    <th id="g_anak_remaja_15_59_p"></th>
                                    <th id="g_anak_remaja_60_l"></th>
                                    <th id="g_anak_remaja_60_p"></th>
                                    <th id="g_psikotik_akut_0_14_l"></th>
                                    <th id="g_psikotik_akut_0_14_p"></th>
                                    <th id="g_psikotik_akut_15_59_l"></th>
                                    <th id="g_psikotik_akut_15_59_p"></th>
                                    <th id="g_psikotik_akut_60_l"></th>
                                    <th id="g_psikotik_akut_60_p"></th>
                                    <th id="skizofrenia_0_14_l"></th>
                                    <th id="skizofrenia_0_14_p"></th>
                                    <th id="skizofrenia_15_59_l"></th>
                                    <th id="skizofrenia_15_59_p"></th>
                                    <th id="skizofrenia_60_l"></th>
                                    <th id="skizofrenia_60_p"></th>
                                    <th id="g_somatoform_0_14_l"></th>
                                    <th id="g_somatoform_0_14_p"></th>
                                    <th id="g_somatoform_15_59_l"></th>
                                    <th id="g_somatoform_15_59_p"></th>
                                    <th id="g_somatoform_60_l"></th>
                                    <th id="g_somatoform_60_p"></th>
                                    <th id="insomnia_0_14_l"></th>
                                    <th id="insomnia_0_14_p"></th>
                                    <th id="insomnia_15_59_l"></th>
                                    <th id="insomnia_15_59_p"></th>
                                    <th id="insomnia_60_l"></th>
                                    <th id="insomnia_60_p"></th>
                                    <th id="percobaan_bunuh_diri_0_14_l"></th>
                                    <th id="percobaan_bunuh_diri_0_14_p"></th>
                                    <th id="percobaan_bunuh_diri_15_59_l"></th>
                                    <th id="percobaan_bunuh_diri_15_59_p"></th>
                                    <th id="percobaan_bunuh_diri_60_l"></th>
                                    <th id="percobaan_bunuh_diri_60_p"></th>
                                    <th id="redartasi_mental_0_14_l"></th>
                                    <th id="redartasi_mental_0_14_p"></th>
                                    <th id="redartasi_mental_15_59_l"></th>
                                    <th id="redartasi_mental_15_59_p"></th>
                                    <th id="redartasi_mental_60_l"></th>
                                    <th id="redartasi_mental_60_p"></th>
                                    <th id="g_kepribadian_perilaku_0_14_l"></th>
                                    <th id="g_kepribadian_perilaku_0_14_p"></th>
                                    <th id="g_kepribadian_perilaku_15_59_l"></th>
                                    <th id="g_kepribadian_perilaku_15_59_p"></th>
                                    <th id="g_kepribadian_perilaku_60_l"></th>
                                    <th id="g_kepribadian_perilaku_60_p"></th>
                                    <th id="jumlah_kasus"></th>

                                    <th></th>

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
                    fixedColumns: {
                        left: 2
                    },
                    "pagingType": "full_numbers",
                    pageLength: 50,
                    "processing": true,
                    "serverSide": true,
                    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                    "select" : true,
                    "ajax":{
                             "url": "{{ route("kasus_jiwa.getdata") }}",
                             "dataType": "json",
                             "type": "POST",
                             data: function ( d ) {
                               d._token= "{{csrf_token()}}";
                               d.kabupaten = $('#select_kab option:selected').val()
                               d.puskesmas = $('#select_pusk option:selected').val()
                               d.periode = $('#periode').val()
                             },
                             beforeSend: function(){
                                 Swal.showLoading();
                             },
                             "dataSrc": function(json){
                                $('#puskesmas').text(json.sum_data.puskesmas)
                                $('#demensia_l').text(json.sum_data.demensia_l)
                                $('#demensia_p').text(json.sum_data.demensia_p)
                                $('#g_ansietas_0_14_l').text(json.sum_data.g_ansietas_0_14_l)
                                $('#g_ansietas_0_14_p').text(json.sum_data.g_ansietas_0_14_p)
                                $('#g_ansietas_15_59_l').text(json.sum_data.g_ansietas_15_59_l)
                                $('#g_ansietas_15_59_p').text(json.sum_data.g_ansietas_15_59_p)
                                $('#g_ansietas_60_l').text(json.sum_data.g_ansietas_60_l)
                                $('#g_ansietas_60_p').text(json.sum_data.g_ansietas_60_p)
                                $('#g_ansietas_depresi_0_14_l').text(json.sum_data.g_ansietas_depresi_0_14_l)
                                $('#g_ansietas_depresi_0_14_p').text(json.sum_data.g_ansietas_depresi_0_14_p)
                                $('#g_ansietas_depresi_15_59_l').text(json.sum_data.g_ansietas_depresi_15_59_l)
                                $('#g_ansietas_depresi_15_59_p').text(json.sum_data.g_ansietas_depresi_15_59_p)
                                $('#g_ansietas_depresi_60_l').text(json.sum_data.g_ansietas_depresi_60_l)
                                $('#g_ansietas_depresi_60_p').text(json.sum_data.g_ansietas_depresi_60_p)
                                $('#g_depresi_0_14_l').text(json.sum_data.g_depresi_0_14_l)
                                $('#g_depresi_0_14_p').text(json.sum_data.g_depresi_0_14_p)
                                $('#g_depresi_15_59_l').text(json.sum_data.g_depresi_15_59_l)
                                $('#g_depresi_15_59_p').text(json.sum_data.g_depresi_15_59_p)
                                $('#g_depresi_60_l').text(json.sum_data.g_depresi_60_l)
                                $('#g_depresi_60_p').text(json.sum_data.g_depresi_60_p)
                                $('#g_penyalahgunaan_napza_0_14_l').text(json.sum_data.g_penyalahgunaan_napza_0_14_l)
                                $('#g_penyalahgunaan_napza_0_14_p').text(json.sum_data.g_penyalahgunaan_napza_0_14_p)
                                $('#g_penyalahgunaan_napza_15_59_l').text(json.sum_data.g_penyalahgunaan_napza_15_59_l)
                                $('#g_penyalahgunaan_napza_15_59_p').text(json.sum_data.g_penyalahgunaan_napza_15_59_p)
                                $('#g_penyalahgunaan_napza_60_l').text(json.sum_data.g_penyalahgunaan_napza_60_l)
                                $('#g_penyalahgunaan_napza_60_p').text(json.sum_data.g_penyalahgunaan_napza_60_p)
                                $('#g_anak_remaja_0_14_l').text(json.sum_data.g_anak_remaja_0_14_l)
                                $('#g_anak_remaja_0_14_p').text(json.sum_data.g_anak_remaja_0_14_p)
                                $('#g_anak_remaja_15_59_l').text(json.sum_data.g_anak_remaja_15_59_l)
                                $('#g_anak_remaja_15_59_p').text(json.sum_data.g_anak_remaja_15_59_p)
                                $('#g_anak_remaja_60_l').text(json.sum_data.g_anak_remaja_60_l)
                                $('#g_anak_remaja_60_p').text(json.sum_data.g_anak_remaja_60_p)
                                $('#g_psikotik_akut_0_14_l').text(json.sum_data.g_psikotik_akut_0_14_l)
                                $('#g_psikotik_akut_0_14_p').text(json.sum_data.g_psikotik_akut_0_14_p)
                                $('#g_psikotik_akut_15_59_l').text(json.sum_data.g_psikotik_akut_15_59_l)
                                $('#g_psikotik_akut_15_59_p').text(json.sum_data.g_psikotik_akut_15_59_p)
                                $('#g_psikotik_akut_60_l').text(json.sum_data.g_psikotik_akut_60_l)
                                $('#g_psikotik_akut_60_p').text(json.sum_data.g_psikotik_akut_60_p)
                                $('#skizofrenia_0_14_l').text(json.sum_data.skizofrenia_0_14_l)
                                $('#skizofrenia_0_14_p').text(json.sum_data.skizofrenia_0_14_p)
                                $('#skizofrenia_15_59_l').text(json.sum_data.skizofrenia_15_59_l)
                                $('#skizofrenia_15_59_p').text(json.sum_data.skizofrenia_15_59_p)
                                $('#skizofrenia_60_l').text(json.sum_data.skizofrenia_60_l)
                                $('#skizofrenia_60_p').text(json.sum_data.skizofrenia_60_p)
                                $('#g_somatoform_0_14_l').text(json.sum_data.g_somatoform_0_14_l)
                                $('#g_somatoform_0_14_p').text(json.sum_data.g_somatoform_0_14_p)
                                $('#g_somatoform_15_59_l').text(json.sum_data.g_somatoform_15_59_l)
                                $('#g_somatoform_15_59_p').text(json.sum_data.g_somatoform_15_59_p)
                                $('#g_somatoform_60_l').text(json.sum_data.g_somatoform_60_l)
                                $('#g_somatoform_60_p').text(json.sum_data.g_somatoform_60_p)
                                $('#insomnia_0_14_l').text(json.sum_data.insomnia_0_14_l)
                                $('#insomnia_0_14_p').text(json.sum_data.insomnia_0_14_p)
                                $('#insomnia_15_59_l').text(json.sum_data.insomnia_15_59_l)
                                $('#insomnia_15_59_p').text(json.sum_data.insomnia_15_59_p)
                                $('#insomnia_60_l').text(json.sum_data.insomnia_60_l)
                                $('#insomnia_60_p').text(json.sum_data.insomnia_60_p)
                                $('#percobaan_bunuh_diri_0_14_l').text(json.sum_data.percobaan_bunuh_diri_0_14_l)
                                $('#percobaan_bunuh_diri_0_14_p').text(json.sum_data.percobaan_bunuh_diri_0_14_p)
                                $('#percobaan_bunuh_diri_15_59_l').text(json.sum_data.percobaan_bunuh_diri_15_59_l)
                                $('#percobaan_bunuh_diri_15_59_p').text(json.sum_data.percobaan_bunuh_diri_15_59_p)
                                $('#percobaan_bunuh_diri_60_l').text(json.sum_data.percobaan_bunuh_diri_60_l)
                                $('#percobaan_bunuh_diri_60_p').text(json.sum_data.percobaan_bunuh_diri_60_p)
                                $('#redartasi_mental_0_14_l').text(json.sum_data.redartasi_mental_0_14_l)
                                $('#redartasi_mental_0_14_p').text(json.sum_data.redartasi_mental_0_14_p)
                                $('#redartasi_mental_15_59_l').text(json.sum_data.redartasi_mental_15_59_l)
                                $('#redartasi_mental_15_59_p').text(json.sum_data.redartasi_mental_15_59_p)
                                $('#redartasi_mental_60_l').text(json.sum_data.redartasi_mental_60_l)
                                $('#redartasi_mental_60_p').text(json.sum_data.redartasi_mental_60_p)
                                $('#g_kepribadian_perilaku_0_14_l').text(json.sum_data.g_kepribadian_perilaku_0_14_l)
                                $('#g_kepribadian_perilaku_0_14_p').text(json.sum_data.g_kepribadian_perilaku_0_14_p)
                                $('#g_kepribadian_perilaku_15_59_l').text(json.sum_data.g_kepribadian_perilaku_15_59_l)
                                $('#g_kepribadian_perilaku_15_59_p').text(json.sum_data.g_kepribadian_perilaku_15_59_p)
                                $('#g_kepribadian_perilaku_60_l').text(json.sum_data.g_kepribadian_perilaku_60_l)
                                $('#g_kepribadian_perilaku_60_p').text(json.sum_data.g_kepribadian_perilaku_60_p)
                                $('#jumlah_kasus').text(json.sum_data.jumlah_kasus);
                                return json.data;
                             },
                             complete: function(){
                                 Swal.hideLoading();
                                 Swal.close();
                             },
                    },

                    "columns": [
                        {
                          "data": "no",
                          "orderable" : false,
                        },

                        {"data":"puskesmas"},
                        {"data":"demensia_l"},
                        {"data":"demensia_p"},
                        {"data":"g_ansietas_0_14_l"},
                        {"data":"g_ansietas_0_14_p"},
                        {"data":"g_ansietas_15_59_l"},
                        {"data":"g_ansietas_15_59_p"},
                        {"data":"g_ansietas_60_l"},
                        {"data":"g_ansietas_60_p"},
                        {"data":"g_ansietas_depresi_0_14_l"},
                        {"data":"g_ansietas_depresi_0_14_p"},
                        {"data":"g_ansietas_depresi_15_59_l"},
                        {"data":"g_ansietas_depresi_15_59_p"},
                        {"data":"g_ansietas_depresi_60_l"},
                        {"data":"g_ansietas_depresi_60_p"},
                        {"data":"g_depresi_0_14_l"},
                        {"data":"g_depresi_0_14_p"},
                        {"data":"g_depresi_15_59_l"},
                        {"data":"g_depresi_15_59_p"},
                        {"data":"g_depresi_60_l"},
                        {"data":"g_depresi_60_p"},
                        {"data":"g_penyalahgunaan_napza_0_14_l"},
                        {"data":"g_penyalahgunaan_napza_0_14_p"},
                        {"data":"g_penyalahgunaan_napza_15_59_l"},
                        {"data":"g_penyalahgunaan_napza_15_59_p"},
                        {"data":"g_penyalahgunaan_napza_60_l"},
                        {"data":"g_penyalahgunaan_napza_60_p"},
                        {"data":"g_anak_remaja_0_14_l"},
                        {"data":"g_anak_remaja_0_14_p"},
                        {"data":"g_anak_remaja_15_59_l"},
                        {"data":"g_anak_remaja_15_59_p"},
                        {"data":"g_anak_remaja_60_l"},
                        {"data":"g_anak_remaja_60_p"},
                        {"data":"g_psikotik_akut_0_14_l"},
                        {"data":"g_psikotik_akut_0_14_p"},
                        {"data":"g_psikotik_akut_15_59_l"},
                        {"data":"g_psikotik_akut_15_59_p"},
                        {"data":"g_psikotik_akut_60_l"},
                        {"data":"g_psikotik_akut_60_p"},
                        {"data":"skizofrenia_0_14_l"},
                        {"data":"skizofrenia_0_14_p"},
                        {"data":"skizofrenia_15_59_l"},
                        {"data":"skizofrenia_15_59_p"},
                        {"data":"skizofrenia_60_l"},
                        {"data":"skizofrenia_60_p"},
                        {"data":"g_somatoform_0_14_l"},
                        {"data":"g_somatoform_0_14_p"},
                        {"data":"g_somatoform_15_59_l"},
                        {"data":"g_somatoform_15_59_p"},
                        {"data":"g_somatoform_60_l"},
                        {"data":"g_somatoform_60_p"},
                        {"data":"insomnia_0_14_l"},
                        {"data":"insomnia_0_14_p"},
                        {"data":"insomnia_15_59_l"},
                        {"data":"insomnia_15_59_p"},
                        {"data":"insomnia_60_l"},
                        {"data":"insomnia_60_p"},
                        {"data":"percobaan_bunuh_diri_0_14_l"},
                        {"data":"percobaan_bunuh_diri_0_14_p"},
                        {"data":"percobaan_bunuh_diri_15_59_l"},
                        {"data":"percobaan_bunuh_diri_15_59_p"},
                        {"data":"percobaan_bunuh_diri_60_l"},
                        {"data":"percobaan_bunuh_diri_60_p"},
                        {"data":"redartasi_mental_0_14_l"},
                        {"data":"redartasi_mental_0_14_p"},
                        {"data":"redartasi_mental_15_59_l"},
                        {"data":"redartasi_mental_15_59_p"},
                        {"data":"redartasi_mental_60_l"},
                        {"data":"redartasi_mental_60_p"},
                        {"data":"g_kepribadian_perilaku_0_14_l"},
                        {"data":"g_kepribadian_perilaku_0_14_p"},
                        {"data":"g_kepribadian_perilaku_15_59_l"},
                        {"data":"g_kepribadian_perilaku_15_59_p"},
                        {"data":"g_kepribadian_perilaku_60_l"},
                        {"data":"g_kepribadian_perilaku_60_p"},
                        {"data":"jumlah_kasus"},

                        { "data" : "action",
                          "orderable" : false,
                          "className" : "text-right",
                        },

                    ],
                    dom: '<"html5buttons"B>lTfgitp',
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

                $(document).on('change','#periode_bln', function(){
                    table.ajax.reload(null, false);
                })
                $("#select_kab").select2();
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
                            url: '{{route("kasus_jiwa.hapus",[null])}}/' + enc_id,
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
