@extends('layouts.table')
@section('title', 'Data Proses Resep Obat')
@section('judultable', 'Data Proses Resep Obat')
@section('menu1', 'Pengeluaran Obat')
@section('menu2', 'Data Proses Resep Obat')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Pilih Data Pemeriksaan</h3>
                <div class="ibox-tools">
                    <input type="date" name="tgl_search" id="tgl_search" class="date" style="min-height: 35px; margin-right:300px" value="{{ date('Y-m-d') }}">

                    <a href="{{ route('pengeluaran_obat.tambah', [null]) }}/null"><button class="btn btn-primary">Tambah Proses Resep</button></a>
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

                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_supplier" >
            <thead>

            <tr>
                <th>No</th>
                <th>No Rawat</th>
                <th>No Rekmed</th>
                <th>Nama Pasien</th>
                <th>Status Pasien</th>
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
   var tabledata,table_index;
      $(document).ready(function(){
        $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
          });
          table= $('#table_supplier').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("pengeluaran_obat.getdata_pendaftaran") }}",
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
              { "data": "status_pasien",},
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

        $('#tgl_search').on('change', function(){
            table.ajax.reload(null, true);
        });


       });
       function deleteData(e,enc_id){
          @cannot('supplier.hapus')
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
              url: '{{route("supplier.hapus",[null])}}/' + enc_id,
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
        let file;
        file = "{{ asset('/inspinia/musik/success.wav') }}";
        let audio = new Audio(file);
        setTimeout(() => {
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
            $.ajax({
                url:"{{ route('pengeluaran_obat.toast') }}",
                type:"GET",
                beforeSend: function(){

                },
                success:function (data) {
                    for(i=0;i<data.jumlah;i++){
                        toastr.success("Halo, ada pasien "+data.pendaftaran[i].pasien.nama_pasien+" yang perlu di proses resep, silahkan refresh halaman ini")
                        audio.play();
                    }
                },
                complete: function(){
                    // setInterval(notif_poli(), 20000000000000000000000000000000000000);
                },
            });
            toastt();
        }, 2000);
    }
</script>
@endpush
