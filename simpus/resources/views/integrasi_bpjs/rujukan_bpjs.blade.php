@extends('layouts.table')
@section('title', 'Data Jabatan')
@section('judultable', 'Data Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Jabatan</h3>
                <div class="ibox-tools">
                    @can('jabatan.tambah')
                        <a href="{{ route('jabatan.tambah') }}"><button class="btn btn-primary">Tambah Jabatan</button></a>
                    @endcan
                    {{-- <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a> --}}
                </div>
            </div>
            <div class="ibox-content">
                <!--<form action="#" method="post">
                    <div class="form-row">
                        {{ csrf_field() }}

                            <label class="col mb-4"><p style="font-size: 20px"> Pencarian </p></label>

                        <div class="col-md-3 mb-4">
                        <select class="form-control" name="typefilter" id="filter" onchange="change_filter()">
                            <option value="search">Kata Kunci</option>
                            {{-- <option value="date">Tanggal Serah Obat</option> --}}
                        </select>

                        </div>
                        <div class="col-md-6 mb-4 ml-4">

                            <div id="input" class="input-group">
                                <input type="search" name="search" class="form-control" id="key">
                            </div>
                        </div>


                        <div class="col mb-4">

                        {{-- <button type="submit" id="btn" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button> --}}
                        </div>
                    </div>
                </form> -->

                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table1" >
            <thead>

                <tr>
                    <th width='1%'>No</th>
                    <th>No Kunjungan</th>
                    <th>No BPJS</th>
                    <th>Nama Pasien</th>
                    <th>Tgl Daftar</th>
                    <th>Tgl Rujuk</th>
                    <th>Nama Faskes</th>
                    <th>Alamat Faskes</th>
                    <th></th>
                </tr>
            </thead>

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
            $.ajaxSetup({
                headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
            });
            table= $('#table1').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave"  : true,
            "deferRender": true,
            "pageLength": 25,
            "select" : true,
            // "rowReorder": true,
            "ajax":{
                     "url": "{{ route("rujukan.getdataRujukan") }}",
                     "dataType": "json",
                     "type": "POST",
                     data: function ( d ) {
                       d._token= "{{csrf_token()}}";
                     }
                   },
              "columns": [
                {
                  "data": "no",
                  "orderable" : true,
                  "className" : 'reorder',
                  "targets"   : 0
                },
                { "data": "no_kunjungan" },
                { "data": "no_kartu",},
                { "data": "nama_pasien",},
                { "data": "tanggal_daftar"},
                { "data": "tgl_rujuk"},
                { "data": "faskes"},
                { "data": "alamat_faskes"},
                { "data" : "action",
                  "orderable" : false,
                  "className" : "text-center",
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
            }
        });

        tabledata = $('#orderData').DataTable({
              dom     : 'lrtp',
              paging    : false,
              columnDefs: [ {
                    "targets": 'no-sort',
                    "orderable": false,
              } ]
            });

            table.on('select', function ( e, dt, type, indexes ){
              table_index = indexes;
              var rowData = table.rows( indexes ).data().toArray();
            });
        });

        $(document.body).on("keydown", function(e){
          ele = document.activeElement;
            if(e.keyCode==38){
              table.row(table_index).deselect();
              table.row(table_index-1).select();
            }
            else if(e.keyCode==40){

              table.row(table_index).deselect();
              table.rows(parseInt(table_index)+1).select();
              console.log(parseInt(table_index)+1);

            }
            else if(e.keyCode==13){

            }
        });
</script>
@endpush
