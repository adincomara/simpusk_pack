@extends('layouts.table_ptm')
@section('title', 'Deteksi Dini Faktor Risiko PTM dan KESWA')
@section('judultable', 'Deteksi Dini Faktor Risiko PTM dan KESWA')
{{-- @section('subjudul', '(Deteksi Dini Faktor Risiko PTM dan KESWA)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Deteksi Dini Faktor Risiko PTM dan KESWA')
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
                            <h3 class="ml-3">Deteksi Dini Faktor Risiko PTM dan KESWA</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_fr_ptm_keswa.tambah') }}" class="btn btn-primary b-r-xl"><i
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
                                <a class="btn btn-danger" href="#"> <i class=" fa fa-file-pdf-o"></i>
                                    &nbsp; PDF</a>
                                <a class="btn btn-primary" href="#"> <i class=" fa fa-file-excel-o"></i>
                                    &nbsp; Excel</a>
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table p-0 table-bordered text-center table-hover nowrap"
                            style="overflow-x: auto;">
                            <thead>
                                <tr class="text-white bg-green text-center">
                                    <th width="5%" class="align-middle" rowspan="2">No</th>
                                    <th class="align-middle" rowspan="2">PUSKESMAS</th>
                                    {{-- <th class="align-middle" rowspan="2">PUSKESMAS</th> --}}
                                    <th class="align-middle" rowspan="2">Jumlah Hadir </th>
                                    <th class="align-start" colspan="2">SASARAN</th>
                                    <th class="align-start" colspan="2">JENIS <br> KELAMIN</th>
                                    <th class="align-start" colspan="2">USIA</th>
                                    <th class="align-start" colspan="2">RIWAYAT PTM</th>
                                    <th class="align-start" colspan="4">FAKTOR RISIKO</th>
                                    <th class="align-start" colspan="3">PENGUKURAN</th>
                                    <th class="align-start" colspan="7">PEMERIKSAAN</th>
                                    <th class="align-start" colspan="2">CAKUPAN</th>
                                    <th class="align-start rotate-text" rowspan="2">RUJUK KE FKTP</th>
                                    <th rowspan="2">Action</th>
                                    {{-- <th rowspan="2"><i class="fas fa-th"></i></th> --}}
                                </tr>
                                <tr class="text-white bg-green">
                                    <th class="align-start rotate-text" style="z-index: 50">15 - 59 TH</th>
                                    <th class="align-start rotate-text" style="z-index: 50">> 59 TH</th>
                                    <th class="align-bottom">L</th>
                                    <th class="align-bottom">P</th>
                                    <th class="align-start rotate-text">15 - 59 TH</th>
                                    <th class="align-start rotate-text">> 59 TH</th>
                                    <th class="align-start rotate-text">DIRI SENDIRI</th>
                                    <th class="align-start rotate-text">KELUARGA</th>
                                    <th class="align-start rotate-text">MEROKOK</th>
                                    <th class="align-start rotate-text">KURANG AKTIFITAS <br> FISIK</th>
                                    <th class="align-start rotate-text">DIET TIDAK <br>SEIMBANG</th>
                                    <th class="align-start rotate-text">KONSUMSI <br> ALKOHOL</th>
                                    <th class="align-start rotate-text">TD TINGGI</th>
                                    <th class="align-start rotate-text">OBESITAS</th>
                                    <th class="align-start rotate-text">LP LEBIH</th>
                                    <th class="align-start rotate-text">GDS TINGGI</th>
                                    <th class="align-start rotate-text">KOLESTEROL TINGGI</th>
                                    <th class="align-start rotate-text">ASAM URAT TINGGI</th>
                                    <th class="align-start rotate-text">GANGGUAN <br>PENGLIHATAN</th>
                                    <th class="align-start rotate-text">GANGGUAN <br>PENDENGARAN</th>
                                    <th class="align-start rotate-text">SRQ > 6</th>
                                    <th class="align-start rotate-text">KIE</th>
                                    <th class="align-start rotate-text">15 - 59 TH</th>
                                    <th class="align-start rotate-text">> 59 TH</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                {{-- <tr>
                                    <td colspan="28">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr> --}}
                                <tr class="text-white text-center bg-primary">
                                    <th>Total</th>
                                    <th id="puskesmas"></th>
                                    <th id="jml_hadir"></th>
                                    <th id="sasaran_15_59"></th>
                                    <th id="sasaran_59"></th>
                                    <th id="jml_laki"></th>
                                    <th id="jml_perempuan"></th>
                                    <th id="usia_15_59"></th>
                                    <th id="usia_59"></th>
                                    <th id="diri_sendiri"></th>
                                    <th id="keluarga"></th>
                                    <th id="merokok"></th>
                                    <th id="aktifitas_fisik"></th>
                                    <th id="diet_tdk_seimbang"></th>
                                    <th id="konsumsi_alkohol"></th>
                                    <th id="td_tinggi"></th>
                                    <th id="obesitas"></th>
                                    <th id="lp_lebih"></th>
                                    <th id="gds_tinggi"></th>
                                    <th id="kolesterol_tinggi"></th>
                                    <th id="asam_urat_tinggi"></th>
                                    <th id="gangguan_penglihatan"></th>
                                    <th id="gangguan_pendengaran"></th>
                                    <th id="srw"></th>
                                    <th id="kie"></th>
                                    <th id="cakupan_15_59"></th>
                                    <th id="cakupan_59"></th>
                                    <th id="rujuk_fktp"></th>
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
                             "url": "{{ route("dd_fr_ptm_keswa.getdata") }}",
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
                             "dataSrc": function(json){
                                $("#puskesmas").text(json.sum_data.puskesmas);
                                $("#jml_hadir").text(json.sum_data.jml_hadir);
                                $("#sasaran_15_59").text(json.sum_data.sasaran_15_59);
                                $("#sasaran_59").text(json.sum_data.sasaran_59);
                                $("#jml_laki").text(json.sum_data.jml_laki);
                                $("#jml_perempuan").text(json.sum_data.jml_perempuan);
                                $("#usia_15_59").text(json.sum_data.usia_15_59);
                                $("#usia_59").text(json.sum_data.usia_59);
                                $("#diri_sendiri").text(json.sum_data.diri_sendiri);
                                $("#keluarga").text(json.sum_data.keluarga);
                                $("#merokok").text(json.sum_data.merokok);
                                $("#aktifitas_fisik").text(json.sum_data.aktifitas_fisik);
                                $("#diet_tdk_seimbang").text(json.sum_data.diet_tdk_seimbang);
                                $("#konsumsi_alkohol").text(json.sum_data.konsumsi_alkohol);
                                $("#td_tinggi").text(json.sum_data.td_tinggi);
                                $("#obesitas").text(json.sum_data.obesitas);
                                $("#lp_lebih").text(json.sum_data.lp_lebih);
                                $("#gds_tinggi").text(json.sum_data.gds_tinggi);
                                $("#kolesterol_tinggi").text(json.sum_data.kolesterol_tinggi);
                                $("#asam_urat_tinggi").text(json.sum_data.asam_urat_tinggi);
                                $("#gangguan_penglihatan").text(json.sum_data.gangguan_penglihatan);
                                $("#gangguan_pendengaran").text(json.sum_data.gangguan_pendengaran);
                                $("#srw").text(json.sum_data.srw);
                                $("#kie").text(json.sum_data.kie);
                                $("#cakupan_15_59").text(json.sum_data.cakupan_15_59);
                                $("#cakupan_59").text(json.sum_data.cakupan_59);
                                $("#rujuk_fktp").text(json.sum_data.rujuk_fktp);
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
                        // { "data": "kabupaten"},
                        { "data": "puskesmas"},
                        {"data":"jml_hadir"},
                        {"data":"sasaran_15_59"},
                        {"data":"sasaran_59"},
                        {"data":"jml_laki"},
                        {"data":"jml_perempuan"},
                        {"data":"usia_15_59"},
                        {"data":"usia_59"},
                        {"data":"diri_sendiri"},
                        {"data":"keluarga"},
                        {"data":"merokok"},
                        {"data":"aktifitas_fisik"},
                        {"data":"diet_tdk_seimbang"},
                        {"data":"konsumsi_alkohol"},
                        {"data":"td_tinggi"},
                        {"data":"obesitas"},
                        {"data":"lp_lebih"},
                        {"data":"gds_tinggi"},
                        {"data":"kolesterol_tinggi"},
                        {"data":"asam_urat_tinggi"},
                        {"data":"gangguan_penglihatan"},
                        {"data":"gangguan_pendengaran"},
                        {"data":"srw"},
                        {"data":"kie"},
                        {"data":"cakupan_15_59"},
                        {"data":"cakupan_59"},
                        {"data":"rujuk_fktp"},

                        { "data" : "action",
                          "orderable" : false,
                          "className" : "text-right",
                        },

                    ],
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
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
                            url: '{{route("dd_fr_ptm_keswa.hapus",[null])}}/' + enc_id,
                            headers: {'X-CSRF-TOKEN': token},
                            success: function(data){
                            console.log(data)
                            if (data.success == true) {
                                Swal.fire('Yes',data.message,'success');
                                // table.ajax.reload(null, true);
                                table.ajax.reload(null, false);
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
