@extends('layouts.table')
@section('title', 'Data Pelayanan Poli')
@section('judultable', 'Data Pelayanan Poli')
@section('menu1', 'Master')
@section('menu2', 'Data Pelayanan Poli')
@section('table')
<audio id="myAudio">
    {{-- <source src="horse.ogg" type="audio/ogg"> --}}
    <source src="{{ asset('assets/musik/success.mp3') }}" type="audio/mpeg">
</audio>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Pelayanan Poli</h3>
                <div class="ibox-tools">
                    <input type="date" name="tgl_search" id="tgl_search" class="date" style="min-height: 35px; margin-right:150px" value="{{ date('Y-m-d') }}">
                    <a href="#"><button class="btn btn-default text-dark border border-secondary btn-refresh">Refresh</button></a>


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


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_pelayanan_poli" >
            <thead>

            <tr>
                <th>No</th>
                <th>No Rawat</th>
                <th>No Rekmed</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>Status Pasien</th>
                <th>Dokter PJ</th>
                <th>Poli</th>
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
$('.btn-refresh').on('click', function(){
    table.ajax.reload(null, true);
})
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
          table= $('#table_pelayanan_poli').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("pelayanan_poli.getdata") }}",
                   "dataType": "json",
                   "type": "POST",
                   data: function ( d ) {
                     d._token= "{{csrf_token()}}";
                     d.search_tgl= $('#tgl_search').val();
                   }
                 },
          "columns": [
            {
                "data": "no",
                "orderable" : true,
                "className" : 'reorder',
                "targets"   : 0
              },
              { "data": "no_rawat" },
              { "data": "no_rekamedis",},
              { "data": "nama_pasien",},
              { "data": "alamat",},
              { "data": "status_pasien",},
              { "data": "nama_penanggung_jawab",},
              { "data": "nama_poli",},
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
        $('#tgl_search').on('change', function(){

            table.ajax.reload(null, true);
        });



       });
       function deleteData(e,enc_id){
          @cannot('pelayanan_poli.hapus')
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
              url: '{{route("pelayanan_poli.hapus",[null])}}/' + enc_id,
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
    $(document).ready(function(){
        toastt();

    })
    function toastt(){
        setTimeout(() => {
            toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"

            }


            $.ajax({
                url:"{{ route('pelayanan_poli.toast') }}",
                type:"GET",
                beforeSend: function(){
                // Swal.showLoading();
                },
                success:function (data) {
                    // Swal.hideLoading();
                    // console.log(data.success);
                    console.log('toast');
                    for(i=0;i<data;i++){
                        toastr.success("Halo, ada pasien yang perlu di periksa, silahkan klik tombol refresh")
                        // var audio = new Audio("{{ asset('assets/musik/success.mp3') }}");
                        // audio.play();
                        var file = "{{ asset('assets/musik/success.mp3') }}";
                        var audio = new Audio(file);
                        audio.play();
                        // audio.play();
                    }
                    // setTimeout(notif_poli(), 3000)
                },
                complete: function(){
                    // setTimeout(notif_poli(), 2000);
                    // setInterval(notif_poli(), 20000000000000000000000000000000000000);
                },
            });
            toastt();
        }, 1500);
    }
</script>
@endpush
