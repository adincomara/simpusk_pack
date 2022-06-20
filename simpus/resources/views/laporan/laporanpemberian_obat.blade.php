@extends('layouts.table')
@section('title', 'Laporan Pemberian Obat')
@section('judultable', 'Laporan Pemberian Obat')
@section('menu1', 'Master')
@section('menu2', 'Laporan Pemberian Obat')
@push('stylesheets')
<style>

    .dataTables_filter, .dataTables_info { display: none; }
</style>
@endpush
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Laporan Pemberian Obat</h3>
                <div class="ibox-tools">
                    {{-- <a href="#"><button class="btn btn-primary" onclick="pdf()"><i class="fa fa-file-pdf"></i></button></a> --}}
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
                <!-- -->
                <form action="{{ route('report.pemberianobat.cetak') }}" method="post">
                <div class="form-row">
                    {{ csrf_field() }}

                        <label class="col mb-4"><p style="font-size: 20px"> Pencarian </p></label>

                    <div class="col-md-3 mb-4">
                    <select class="form-control" name="typefilter" id="filter" onchange="change_filter()">
                        <option value="search">Kata Kunci</option>
                        <option value="date">Tanggal Serah Obat</option>
                    </select>

                    </div>
                    <div class="col-md-6 mb-4 ml-4">

                        <div id="input" class="input-group">
                            <input type="search" name="search" class="form-control" id="key">
                        </div>
                    </div>


                    <div class="col mb-4">

                    <button type="submit" id="btn" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button>
                    </div>
                </div>
            </form>
                <div class="table-responsive">


            <table class="table table-bordered table-hover dataTables-example coba" id="table_pengeluaran_obat" >
            <thead>

            <tr>
                <th>No</th>
                <th>No Transaksi</th>
                <th>Nama Pasien</th>
                <th>Keterangan</th>
                <th>Tgl Serah Obat</th>
                {{-- <th>Action</th> --}}
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
   var table, tabledata,table_index;
   function change_filter(){
       var type = $('#filter').val();
    //    console.log(type);
        if(type == "date"){
            $("#input").html("<input type='date' name='min' class='form-control' onchange='change_date()'  id='min'><span class='input-group-addon'>to</span><input type='date' name='max' class='form-control' onchange='change_date()'  id='max'>");
        }
        else{
            $("#input").html("<input type='search' name='search' class='form-control' id='key' onkeyup='text()'>");
        }
        table.search('').draw();

}

function text(){

    var val = $('#key').val();
    table.search(val).draw();
}
function change_date(){
    // $('#min, #max').on('change', function () {

    //         table.draw();
    //     });
    //console.log();
    var min = $('#min').val();
            var max = $('#max').val();
            var combi =min+"&"+max+"&";
            console.log(combi);
     this.table.search(combi).draw();
}
      $(document).ready(function(){
        $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
          });
          table = $('#table_pengeluaran_obat').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,

          "ajax":{
                   "url": "{{ route("pemberianobat.getdata") }}",
                   "dataType": "json",
                   "type": "POST",
                   data: function ( d ) {
                     d._token= "{{csrf_token()}}";
                     d.min = $('#min').val();
                     d.max = $('#max').val();
                     d.type = $('#filter').val();

                   },

                   "dataSrc": function ( json ) {
                        //Make your callback here.
                       // console.log(json.data);
                        this.data_table = json.data;
                        return json.data;
                    }
                 },
          "columns": [
              {
                "data": "no",
                "orderable" : true,
                "className" : 'reorder',
                "width":"5%",
                "targets"   : 0
              },
              { "data": "no_terima_obat" },
              { "data": "nama_pasien",},
              { "data": "keterangan" },
              { "data": "tgl_serah_obat" },
            //   { "data" : "action",
            //     "orderable" : false,
            //     "width":"10%",
            //     "className" : "text-center",
            //   },
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
                "previous": "Sebelum",
                "className" : "d-flex flex-row-reverse",
              },
          }
        });
        table.search('').draw();
        $("input[type='search']").on("keyup", function () {

            var val = $(this).val();
            console.log(val);

            table.search(val).draw();
            //console.log(table);
        });


       });
       function deleteData(e,enc_id){
          @cannot('pengeluaran_obat.hapus')
              Swal.fire('Ups!', "Anda tidak memiliki HAK AKSES! Hubungi ADMIN Anda.",'error'); return false;
          @else
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
          if (result.value) {
            $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
            });
             $.ajax({
              type: 'DELETE',
              url: '{{route("pengeluaran_obat.hapus",[null])}}/' + enc_id,
              headers: {'X-CSRF-TOKEN': token},
              success: function(data){
                if (data.status=='success') {
                    Swal.fire('Yes',data.message,'success');
                    table.ajax.reload(null, true);
                 }else{
                   Swal.fire('Ups',data.message,'info');
                 }
              },
              error: function(data){
                console.log(data);
                Swal.fire("Ups!", "Terjadi kesalahan pada sistem.", "error");
              }
            });


          } else {

          }
         });
          @endcannot
      }
</script>
@endpush
