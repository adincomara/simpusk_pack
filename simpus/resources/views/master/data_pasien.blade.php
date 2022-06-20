@extends('layouts.table')
@section('title', 'Data Pasien')
@section('judultable', 'Data Pasien')
@section('menu1', 'Master')
@section('menu2', 'Data Pasien')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Pasien</h3>
                <div class="ibox-tools">
                    @can('pasien.tambah')
                        <a href="{{ route('pasien.tambah') }}"><button class="btn btn-primary">Tambah Pasien</button></a>
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


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_pasien" >
            <thead>

            <tr>
                <th>No</th>
                <th>No Rekam Medis</th>
                <th>NIK / BPJS</th>
                <th>Nama Pasien</th>
                <th>Gender</th>
                <th>Kota Asal   </th>
                <th>Status Pasien</th>
                <th>Action</th>
            </tr>
            </thead>

            </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalData">
        <div class="modal-dialog modal-md">
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
                    <center><h3 id="title_modal"> Pasien</h3></center>
                    <br>
                    <table id="orderData" class="table" width="100%">
                      <tbody id="tbodyOrderDetailData">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between d-flex flex-row-reverse">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalDataRiwayat">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Riwayat Kunjungan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-bodyRiwayat">
              <div class="row">
                <div class="col-md-12">
                  <div class="card-body table-responsive p-3">
                    <center><h3 id="title_modalRiwayat"> Pasien</h3></center>
                    <br>
                    <table id="orderDataRiwayat" class="table" width="100%">
                    <thead>
                        <th width="15%">Pelayanan</th>
                        <th width="15%">Tgl.Pelayanan</th>
                        <th class="text-left">      Diagnosa</th>
                    </thead>
                      <tbody id="tbodyOrderDetailDataRiwayat">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between d-flex flex-row-reverse">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
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
   var tabledata,table_index;
      $(document).ready(function(){
        $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
          });
          table= $('#table_pasien').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("pasien.getdata") }}",
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
              { "data": "no_rekamedis" },
              { "data": "ktpbpjs",
              "width" : "20%",
              },

              { "data": "nama_pasien",},
              { "data": "jenis_kelamin",

            },

              { "data": "alamat",},
              { "data": "status_pasien",},
              { "data" : "action",
                "orderable" : false,
                "className" : "text-center",
                "width" : "10%",
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
          @cannot('pasien.hapus')
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
              url: '{{route("pasien.hapus",[null])}}/' + enc_id,
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
    function detail_data(id, nama){

      $('#modalData').modal('show');
      $('#orderData').html('Loading');
      $('#title_modal').text(nama);
      var token = '{{ csrf_token() }}';
          $.ajax({
            type: 'POST',
            url : "{{route('pasien.detail_data')}}",
            data: 'id='+id,
            headers: {'X-CSRF-TOKEN': token},
            beforeSend: function(){
                Swal.showLoading();
            },
            success: function(data){
              Swal.hideLoading();
              Swal.close();
              $('#orderData').html(data);
              console.log(data);
            }
          });
    }
    function riwayat_kunjungan(no_kartu, nama){
        console.log(no_kartu);

        $('#tbodyOrderDetailDataRiwayat').html('Loading');
        $('#title_modalRiwayat').text(nama);
        var token = '{{ csrf_token() }}';
        $.ajax({
            type: 'POST',
            url : "{{route('pasien.riwayat_kunjungan')}}",
            data: 'no_kartu='+no_kartu,
            headers: {'X-CSRF-TOKEN': token},
            beforeSend: function(){
                Swal.showLoading();
            },
            success: function(data){
                console.log(data);
              if(data.success == true){
                Swal.hideLoading();
                Swal.close();
                $('#modalDataRiwayat').modal('show');
                $('#tbodyOrderDetailDataRiwayat').html(data.message);
              }else{
                Swal.hideLoading();
                Swal.close();
                Swal.fire('Ups',data.message,'info');
              }
            //   $('#orderData').html(data);
              console.log(data.message);
            }
        });
    }
</script>
@endpush
