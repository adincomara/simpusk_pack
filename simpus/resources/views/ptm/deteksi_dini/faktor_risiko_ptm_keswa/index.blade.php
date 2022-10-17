@extends('layouts.layout')
<style>
    #table1 th {
        background: white !important;
        /* background: #1ab394 !important; */
    }

    td {
        background: white !important;
    }

    tr th:nth-child(1),
    tr th:nth-child(2) {
        z-index: 56;
    }
</style>
@section('title', 'Deteksi Dini Faktor Risiko PTM dan Keswa')

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="fw-600"> @yield('title')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('manage.beranda')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="">Deteksi Dini</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> @yield('title')</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('keswa.cetak_pdf') }}" method="POST">
                {{ csrf_field() }}
                <div class="ibox">
                    <div class="ibox-title b-r-xl">
                        <div class="d-flex justify-content-between">
                            <div class="p-0">
                                <h3 class="ml-3">@yield('title')</h3>
                            </div>
                            <div class="ibox-tools">
                                <div class="p-0 text-right">
                                    @can('jiwa.tambah')
                                    <a href="{{ route('keswa.tambah')}}" class="btn btn-primary b-r-xl"><i
                                            class="fa fa-plus-circle"></i>&nbsp;
                                        Tambah</a>
                                    @endcan
                                    <a href="javascript:void(0);"
                                        class="btn btn-default b-r-xl border border-secondary btn-refresh">
                                        <i class="fa fa-refresh"></i>&nbsp; Refresh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content p-5 b-r-xl mt-2">
                        <div class="mt-4 d-flex justify-content-between">
                            <div class="p-0 row">
                                @can('provinsi.index')
                                <div class="col-md">
                                    <p>
                                        Kabupaten
                                    </p>
                                    <select class="form-control" id="select_kab" name="kabupaten">
                                        <option value="">Pilih Kabupaten .....</option>
                                        @foreach($kabupaten as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md">
                                    <div class="form-group row">
                                        <label for="pusk" class="col-md-12 col-form-label"><strong> Puskesmas
                                            </strong></label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="select_pusk" name="puskesmas">
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                @endcan
                                @can('balkesmas.index')
                                <div class="col-md">
                                    <p>
                                        Kabupaten
                                    </p>
                                    <select class="form-control" id="select_kab" name="kabupaten">
                                        <option value="">Pilih Kabupaten .....</option>
                                        @foreach($kabupaten as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @endcan

                                @can('kabupaten.index')
                                <div class="col-md">
                                    <p>
                                        Kabupaten
                                    </p>
                                    <select class="form-control select2_demo_3" id="select_kab" name="kabupaten"
                                        @can('kabupaten.index') disabled @endcan>
                                        <option value="{{ isset($user)? $user->id : '' }}">
                                            {{ isset($user)? $user->name : '' }}</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <p>
                                        Puskesmas
                                    </p>
                                    <select class="select2_demo_3 form-control" id="select_pusk" name="puskesmas">
                                    </select>
                                </div>
                                @endcan
                                @can('puskesmas.index')
                                {{-- <div class="col-md">
                                    <div class="form-group row">
                                        <label for="pusk" class="col-md-12 col-form-label"><strong> Puskesmas
                                            </strong></label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="select_kab" name="select_kab" disabled>
                                                <option value="{{ isset($user)? $user->puskesmas_id : '' }}">
                                                    {{ isset($user)? ucfirst($user->name) : '' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                @endcan
                                <div class="col-md">
                                    <p>
                                        Range Periode
                                    </p>
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
                                <p class="text-right">
                                    <button type="submit" name="cetakan" value="excel"
                                        class="btn btn-primary b-r-xl px-3 my-2"><i class="fa fa-file-excel"></i>
                                        &nbsp;
                                        Cetak Excel</button>
                                    {{-- <input type="submit" value="Cetak PDF" class="btn btn-danger b-r-xl px-3">
                                    --}}
                                    {{-- <button type="submit" name="cetakan" value="pdf"
                                        class="btn btn-danger b-r-xl px-3 my-2"><i class="fa fa-file-pdf"></i>
                                        &nbsp;
                                        Cetak Pdf</button> --}}

                                </p>
                            </div>
            </form>
        </div>
        <div class="table-responsive mt-4">
            <table id="table1" class="table p-0 table-sm table-bordered nowrap">
                <thead>
                    <tr class="text-white text-center bg-green">
                        <th width="5%" class="align-middle bg-primary" rowspan="2">No</th>
                        @can('provinsi.index')
                        <th class="align-middle bg-primary" rowspan="2">KABUPATEN</th>
                        @endcan
                        @can('balkesmas.index')
                        <th class="align-middle bg-primary" rowspan="2">KABUPATEN</th>
                        @endcan
                        @can('kabupaten.index')
                        <th class="align-middle bg-primary" rowspan="2">PUSKESMAS</th>
                        @endcan
                        @can('puskesmas.index')
                        <th class="align-middle bg-primary" rowspan="2">PUSKESMAS</th>
                        @endcan
                        <th class="align-middle bg-primary" rowspan="2">Jumlah Hadir </th>
                        <th class="align-middle bg-primary" colspan="2">SASARAN</th>
                        <th class="align-middle bg-primary" colspan="2">JENIS <br> KELAMIN</th>
                        <th class="align-middle bg-primary" colspan="2">USIA</th>
                        <th class="align-middle bg-primary" colspan="2">RIWAYAT PTM</th>
                        <th class="align-middle bg-primary" colspan="4">FAKTOR RISIKO</th>
                        <th class="align-middle bg-primary" colspan="3">PENGUKURAN</th>
                        <th class="align-middle bg-primary" colspan="7">PEMERIKSAAN</th>
                        <th class="align-middle bg-primary" colspan="2">CAKUPAN</th>
                        <th class="align-middle bg-primary" rowspan="2">RUJUK KE FKTP</th>
                        @can('puskesmas.index')
                        <th class="bg-primary" rowspan="2">Action</th>
                        @endcan
                    </tr>
                    <tr class="text-white text-center bg-green">
                        <th class="align-middle bg-primary" style="z-index: 50">15 - 59 TH</th>
                        <th class="align-middle bg-primary" style="z-index: 50">> 59 TH</th>
                        <th class="align-middle bg-primary">L</th>
                        <th class="align-middle bg-primary">P</th>
                        <th class="align-middle bg-primary">15 - 59 TH</th>
                        <th class="align-middle bg-primary">> 59 TH</th>
                        <th class="align-middle bg-primary">DIRI SENDIRI</th>
                        <th class="align-middle bg-primary">KELUARGA</th>
                        <th class="align-middle bg-primary">MEROKOK</th>
                        <th class="align-middle bg-primary">KURANG AKTIFITAS <br> FISIK</th>
                        <th class="align-middle bg-primary">DIET TIDAK <br>SEIMBANG</th>
                        <th class="align-middle bg-primary">KONSUMSI <br> ALKOHOL</th>
                        <th class="align-middle bg-primary">TD TINGGI</th>
                        <th class="align-middle bg-primary">OBESITAS</th>
                        <th class="align-middle bg-primary">LP LEBIH</th>
                        <th class="align-middle bg-primary">GDS TINGGI</th>
                        <th class="align-middle bg-primary">KOLESTEROL TINGGI</th>
                        <th class="align-middle bg-primary">ASAM URAT TINGGI</th>
                        <th class="align-middle bg-primary">GANGGUAN <br>PENGLIHATAN</th>
                        <th class="align-middle bg-primary">GANGGUAN <br>PENDENGARAN</th>
                        <th class="align-middle bg-primary">SRQ > 6</th>
                        <th class="align-middle bg-primary">KIE</th>
                        <th class="align-middle bg-primary">15 - 59 TH</th>
                        <th class="align-middle bg-primary">> 59 TH</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr class="text-white text-center bg-primary">
                        <th class="bg-primary">Total</th>
                        <th class="bg-primary" style="z-index: 50" id="puskesmas"></th>
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
                        @can('puskesmas.index')
                        <th id="action"></th>
                        @endcan
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
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
            fixedHeader:true,
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
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
                     "url": "{{ route("keswa.getdata") }}",
                     "dataType": "json",
                     "type": "POST",
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
                     data: function ( d ) {
                       d._token= "{{csrf_token()}}";
                       d.kabupaten = $('#select_kab option:selected').val()
                       d.puskesmas = $('#select_pusk option:selected').val()
                       d.periode_start = $('#start').val()
                       d.periode_end   = $('#end').val()
                     },
                    //  "dataSrc": function(json){
                    //     if(Object.keys(json.sum_data).length > 0 ){
                    //         $("#puskesmas").text(json.sum_data.puskesmas);
                    //         $("#jml_hadir").text(json.sum_data.jml_hadir);
                    //         $("#sasaran_15_59").text(json.sum_data.sasaran_15_59);
                    //         $("#sasaran_59").text(json.sum_data.sasaran_59);
                    //         $("#jml_laki").text(json.sum_data.jml_laki);
                    //         $("#jml_perempuan").text(json.sum_data.jml_perempuan);
                    //         $("#usia_15_59").text(json.sum_data.usia_15_59);
                    //         $("#usia_59").text(json.sum_data.usia_59);
                    //         $("#diri_sendiri").text(json.sum_data.diri_sendiri);
                    //         $("#keluarga").text(json.sum_data.keluarga);
                    //         $("#merokok").text(json.sum_data.merokok);
                    //         $("#aktifitas_fisik").text(json.sum_data.aktifitas_fisik);
                    //         $("#diet_tdk_seimbang").text(json.sum_data.diet_tdk_seimbang);
                    //         $("#konsumsi_alkohol").text(json.sum_data.konsumsi_alkohol);
                    //         $("#td_tinggi").text(json.sum_data.td_tinggi);
                    //         $("#obesitas").text(json.sum_data.obesitas);
                    //         $("#lp_lebih").text(json.sum_data.lp_lebih);
                    //         $("#gds_tinggi").text(json.sum_data.gds_tinggi);
                    //         $("#kolesterol_tinggi").text(json.sum_data.kolesterol_tinggi);
                    //         $("#asam_urat_tinggi").text(json.sum_data.asam_urat_tinggi);
                    //         $("#gangguan_penglihatan").text(json.sum_data.gangguan_penglihatan);
                    //         $("#gangguan_pendengaran").text(json.sum_data.gangguan_pendengaran);
                    //         $("#srw").text(json.sum_data.srw);
                    //         $("#kie").text(json.sum_data.kie);
                    //         $("#cakupan_15_59").text(json.sum_data.cakupan_15_59);
                    //         $("#cakupan_59").text(json.sum_data.cakupan_59);
                    //         $("#rujuk_fktp").text(json.sum_data.rujuk_fktp);
                    //     }else{
                    //         $("#puskesmas").text('');
                    //         $("#jml_hadir").text('');
                    //         $("#sasaran_15_59").text('');
                    //         $("#sasaran_59").text('');
                    //         $("#jml_laki").text('');
                    //         $("#jml_perempuan").text('');
                    //         $("#usia_15_59").text('');
                    //         $("#usia_59").text('');
                    //         $("#diri_sendiri").text('');
                    //         $("#keluarga").text('');
                    //         $("#merokok").text('');
                    //         $("#aktifitas_fisik").text('');
                    //         $("#diet_tdk_seimbang").text('');
                    //         $("#konsumsi_alkohol").text('');
                    //         $("#td_tinggi").text('');
                    //         $("#obesitas").text('');
                    //         $("#lp_lebih").text('');
                    //         $("#gds_tinggi").text('');
                    //         $("#kolesterol_tinggi").text('');
                    //         $("#asam_urat_tinggi").text('');
                    //         $("#gangguan_penglihatan").text('');
                    //         $("#gangguan_pendengaran").text('');
                    //         $("#srw").text('');
                    //         $("#kie").text('');
                    //         $("#cakupan_15_59").text('');
                    //         $("#cakupan_59").text('');
                    //         $("#rujuk_fktp").text('');
                    //     }
                    //      return json.data;
                    //  },
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
                {"data":"puskesmas"},
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
                @can('puskesmas.index')
                { "data" : "action",
                  "orderable" : false,
                  "className" : "text-right",
                },
                @endcan
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
            "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // console.log(Object.keys(data[0]).length);
                    // console.log(table.columns(':visible').count());
                    var all = [];
                    for(i=2; i<table.columns(':visible').count(); i++){
                        let tamp = api
                                .column( i )
                                .data()
                                .reduce( function (a, b) {
                                    // console.log(a);
                                    return intVal(a) + intVal(b);
                                }, 0 );
                        all.push(tamp);
                    }
                    let k = 2
                    $( api.column( 1 ).footer() ).html(Object.keys(data).length);
                    for(i=0; i<Object.keys(all).length; i++ ){
                        $( api.column( k ).footer() ).html(all[i]);
                        k++;
                    }
                    let kol25 = (all[5]/all[1])*100;

                    $( api.column( 25 ).footer() ).html((isNaN(kol25) === false && kol25 >= 0 && kol25 != 'Infinity')? kol25.toFixed(3)+'%' : '0%');
                    // $( api.column( 25 ).footer() ).html((isNaN(kol25) === false && kol25 >= 0)?kol25.toFixed(3)+'%' : '0%');
                    let kol26 = (all[6]/all[2])*100;
                    $( api.column( 26 ).footer() ).html((isNaN(kol26) === false && kol26 >= 0 && kol26 != 'Infinity')? kol26.toFixed(3)+'%' : '0%');
                    // $( api.column( 26 ).footer() ).html((isNaN(kol26) === false && kol26 >= 0)?kol26.toFixed(3)+'%' : '0%');
                    // $( api.column( 25 ).footer() ).html();


                    // return;

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
                url: "{{ route('ptm.filter_puskesmas') }}",
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

    function editData(enc_id){
        $start = $('#start').val();
        $end = $('#end').val();
        if($start != $end){
            Swal.fire('Ups','Periode yang dipilih tidak sama','info');
        }else{
            window.location.href = '{{route("keswa.ubah", [null])}}/'+enc_id;
        }
        return;
    }

    function deleteData(e,enc_id){
        var token = '{{ csrf_token() }}';
        $start = $('#start').val();
        $end = $('#end').val();
        if($start != $end){
            Swal.fire('Ups','Periode yang dipilih tidak sama','info');
        }else{
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
                        url: '{{route("keswa.hapus",[null])}}/' + enc_id,
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
    }
    $(document).ready(function(){
        @if(!empty($alert))
            Swal.fire('Ups','Maaf gagal','error');
        @endif
    });
</script>
@endpush
