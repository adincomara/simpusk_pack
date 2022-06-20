@extends('layouts.table')
@section('title', 'Tenaga Puskesmas')
@section('judultable', 'Tenaga Puskesmas')
@section('menu1', 'Master')
@section('menu2', 'Tenaga Puskesmas')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Tenaga Puskesmas</h3>
                <div class="ibox-tools">
                    {{-- <button class="btn btn-primary" id="pdf"><i class="fa fa-file-pdf"></i></button> --}}

                    {{-- @can('pegawai.tambah')
                        <a href="{{ route('pegawai.tambah') }}"><button class="btn btn-primary">Tambah Pegawai</button></a>
                    @endcan --}}
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
                    <form action="{{ route('report.tenagakesehatan.cetak') }}" method="post">
                        <div class="form-row">
                            {{ csrf_field() }}

                            <input type="hidden" name="search" id="print" value="">
                            <button type="submit" id="btn" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button>

                        </div>
                    </form>
                </div>
            </div>
            <div class="ibox-content">




                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_pegawai" >
            <thead>

            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>NIP / NIK</th>
                <th>Gender</th>
                <th>NPWP</th>
                <th>Kota Asal</th>
                {{-- <th>Tanggal Lahir</th> --}}
                {{-- <th>Alamat</th> --}}
                <th>Jabatan</th>
                <th>Bidang</th>

            </tr>
            </thead>

            </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalData">
        <div class="modal-dialog modal-lg" style="max-width: 1140px">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="card-body table-responsive p-0">
                    <table id="orderData" class="table table-bordered" width="100%">
                      <tbody id="tbodyOrderDetailData">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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
   var tabledata,table_index,data_table;

   var inputs = $(document).find('input[type="search"]');
    inputs.keyup(function() {
        console.log('sadfsa');
        // console.log($(this));
        // $('#print').val($(this));

    });

      $(document).ready(function(){
        $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
          });
          table= $('#table_pegawai').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("tenagakesehatan.getdata") }}",
                   "dataType": "json",
                   "type": "POST",
                   data: function ( d ) {
                     d._token= "{{csrf_token()}}";
                   },
                   "dataSrc": function ( json ) {
                        //Make your callback here.

                        return json.data;
                    }
                 },
          "columns": [
            {
            "data": "no",
            "orderable" : false,
            },
            { "data": "nama_pegawai" },
            { "data": "nipnik",
              "width" : "20%",
             },
            { "data": "jenis_kelamin" },
            { "data": "npwp" },
            { "data": "tempat_lahir" },
            // { "data": "tanggal_lahir" },
            // { "data": "alamat" },
            { "data": "nama_jabatan" },
            { "data": "nama_bidang" },
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
            $('#print').val(val);
            console.log(val);

            table.search(val).draw();
            //console.log(table);
        });




       });
       function deleteData(e,enc_id){
          @cannot('pegawai.hapus')
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
              url: '{{route("pegawai.hapus",[null])}}/' + enc_id,
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
<script>
    function detail_data(id){
      $('#modalData').modal('show');
      $('#orderData').html('Loading');
      var token = '{{ csrf_token() }}';
          $.ajax({
            type: 'POST',
            url : "{{route('pegawai.detail_data')}}",
            data: 'id='+id,
            headers: {'X-CSRF-TOKEN': token},
            success: function(data){
              $('#orderData').html(data);
            //   console.log(data);
            }
          });
    }
</script>
@endpush
