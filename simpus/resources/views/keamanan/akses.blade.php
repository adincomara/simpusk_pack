@extends('layouts.table')
@section('title', 'Data Akses')
@section('judultable', 'Data Akses')
@section('menu1', 'Keamanan')
@section('menu2', 'Akses')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Akses</h3>
                <div class="ibox-tools">
                    @can('role.tambah')
                        <a href="{{ route('role.tambah') }}"><button class="btn btn-primary">Tambah Akses</button></a>
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
                <th>No</th>
                <th>Nama Akses</th>
                <th>Action</th>
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
    var table,tabledata,table_index;
       $(document).ready(function(){
           table= $('#table1').DataTable({
           "processing": true,
           "serverSide": true,
           "stateSave"  : true,
           "deferRender": true,
           "pageLength": 10,
           "select" : true,
           "ajax":{
                    "url": "{{ route("role.getdata") }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                      _token: "{{csrf_token()}}",
                      }
                  },
           "columns": [
               {
                 "data": "no",
                 "orderable" : false,
                 "width":"5%",
               },
               { "data": "name" },

               { "data" : "action",
                 "orderable" : false,
                 "width":"10%",
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
         table.search('').draw();
        $("input[type='search']").on("keyup", function () {

            var val = $(this).val();
            console.log(val);

            table.search(val).draw();
            //console.log(table);
        });

         tabledata = $('#orderData').DataTable({
           dom     : 'lrtp',
           paging    : false,
           columnDefs: [ {
                 "targets": 'no-sort',
                 "orderable": false,
           } ]
         });
       });
       function deleteData(e,enc_id){
           @cannot('role.hapus')
               swal('Ups!', "Anda tidak memiliki HAK AKSES! Hubungi ADMIN Anda.",'error'); return false;
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
               url: '{{route("role.hapus",[null])}}/' + enc_id,
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
