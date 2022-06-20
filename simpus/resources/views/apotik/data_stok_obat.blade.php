@extends('layouts.table')
@section('title', 'Data Stok Obat')
@section('judultable', 'Data Stok Obat')
@section('menu1', 'Master')
@section('menu2', 'Data Stok Obat')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Stok Obat</h3>
                <div class="ibox-tools">
                    @can('stok_obat.tambah')
                    <div class="form-row">



                        <form method="POST" action="{{ route('stok_obat.excel') }}">
                            {{ csrf_field() }}
                            {{-- <input type="hidden" name="_token" value="{{ csrf_field() }}"> --}}
                            <input type="hidden" name="search" id="excel">
                            <button type="submit" class="btn btn-warning ml-1"><i class="fa fa-file-excel"></i> Download</button>
                        </form>
                            {{-- <a href="" target="_blank"><button class="btn btn-warning"><i class="fa fa-file-excel"></i> Download</button></a> --}}
                        <form method="POST" action="{{ route('stok_obat.cetak') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="search" id="print" value="">
                            <button type="submit" class="btn btn-success ml-1"><i class="fa fa-file-pdf"></i> Cetak PDF</button>
                        </form>
                            <a href="{{ route('stok_obat.tambah') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i>Tambah Stok Obat </button></a>
                            <a href="#" id="barcode"><button class="btn btn-secondary" data-toggle="modal" data-target="#modal_barcode"><i class="fa fa-barcode"></i> Barcode</button></a>




                        {{-- <a href="{{ route('stok_obat.cetak') }}"  target="_blank"><button class="btn btn-success"><i class="fa fa-file-pdf"></i> Cetak PDF</button></a> --}}
                    </div>
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
                </form>-->

                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_stok_obat" >
            <thead>

            <tr>
                <th>No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Action</th>
            </tr>
            </thead>

            </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalData">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Obat</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="card-body table-responsive p-0">
                      <center><h3 id="title_modal"> Title</h3></center>
                      <br>
                    <table id="orderData" class="table table-bordered" width="100%">
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

    <div class="modal fade" id="modal_barcode"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLongTitle">Barcode Obat</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="text" name="barcode_obat" id="barcode_obat" class="form-control" autofocus>
              <label style="color: red; display:none" id="labeldanger"><span>Barcode tidak ditemukan</span> </label>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal_tambah_obat" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <form method="POST" id="submitData">
            {{ csrf_field() }}

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalLongTitle">Stok Obat</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="isi_modal">

                </div>
              {{-- <input type="text" name="barcode_obat" id="barcode_obat" class="form-control" autofocus> --}}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
            </div>
          </div>
        </div>
    </form>
    </div>
@endsection
@push('scripts')
<script>
    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        id_obat:{
          required: true
        },
        batch_obat:{
          required: true
        },
        tgl_expired_obat:{
          required: true
        },
        stok_obat:{
          required: true
        },
      },
      messages: {
        id_obat:{
          required: "Obat harus diisi"
        },
        batch_obat:{
          required: ""
        },
        tgl_expired_obat:{
          required: "Tanggal expired obat harus diisi"
        },
        stok_obat:{
          required: "Stok obat harus diisi"
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        console.log(element.closest('.form-group').append(error));
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        SimpanData()
        // if(bpjs != 'BPJS'){
        //   SimpanData()
        // }else{
        //   SimpanBpjs()
        //   // SimpanData()
        // }
      }
    });

     function SimpanData(){
          $('#simpan').addClass("disabled");
          var formAdd  = $('#submitData').serialize();
        //   alert(formAdd);
        //   return;
          if($("#submitData").valid()){
          $.ajax({
            type: 'POST',
            url : "{{route('stok_obat.simpan')}}",
            data: $('#submitData').serialize(),
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            dataType: "json",

            success: function(data){
              //console.log(formAdd);
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                //   window.location.href="{{ route('pelayanan_poli.index') }}";
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
               $('#simpan').removeClass("disabled");
               $('#Loading').modal('hide');
               $('#modal_tambah_obat').modal('hide');
               table.search('').draw();
            },
            error: function(data){
                 $('#simpan').removeClass("disabled");
                 $('#Loading').modal('hide');
                // console.log(data);
            }
          });
        }
    }
</script>
<script>
    $(document).ready(function(){
        $('#modal_barcode').on('shown.bs.modal', function () {
            $('#labeldanger').hide();
            $('#barcode_obat').focus();
            $('#barcode_obat').val("");

        });
        $('#barcode_obat').on('keyup', function(){
            $('#labeldanger').hide();
            var barcode = this.value;
            // setTimeout(function(){
                $.ajax({
                    type: 'POST',
                    url: "{{ route('stok_obat.modal_obat') }}",
                    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                    data: {barcode_obat : barcode},
                    success: function(data){
                        //console.log(data);
                        if(data != "null"){

                            $('#isi_modal').html(data);
                            $('#modal_barcode').modal('hide');
                            setTimeout(function(){

                                $('#modal_tambah_obat').modal('show');

                            },500);
                        }
                        else{
                            $('#labeldanger').show();

                            return;
                        }

                    }
                });


            // },500);


            // $('#modal_tambah_obat').modal('focus');
        });


    });
    // $('body').on('shown.bs.modal', '#modal_barcode', function () {
    //     $('input:visible:enabled:first', this).focus();
    // })
</script>
<script>
    function detail_data(id){
        //console.log(id);
      $('#modalData').modal('show');
      $('#orderData').html('Loading');
    //   var tes = $('#title_modal').text(nama);
    //   console.log(tes);
      var token = '{{ csrf_token() }}';
          $.ajax({
            type: 'POST',
            url : "{{route('stok_obat.detail')}}",
            data: 'enc_id='+id,
            headers: {'X-CSRF-TOKEN': token},
            success: function(data){
               $('#orderData').html(data);
            //   console.log(data);
            }
          });
    }
</script>
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
          table= $('#table_stok_obat').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("stok_obat.getdata") }}",
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
                "width":"5%",
                "targets"   : 0
              },
              { "data": "kode_obat" },
              { "data": "nama_obat" },
              { "data": "stok_obat",},
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
                "previous": "Sebelum",
                "className" : "d-flex flex-row-reverse",
              },
          }
        });
        table.search('').draw();
        $("input[type='search']").on("keyup", function () {

            var val = $(this).val();
            console.log(val);
            $('#print').val(val);
            $('#excel').val(val);

            table.search(val).draw();
            //console.log(table);
        });




       });
       function deleteData(e,enc_id){
          @cannot('stok_obat.hapus')
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
              url: '{{route("stok_obat.hapus",[null])}}/' + enc_id,
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
