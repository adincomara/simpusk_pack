@extends('layouts.table')
@section('title', 'Data Antrian')
@section('judultable', 'Data Antrian')
@section('menu1', 'Antrian')
@section('menu2', 'Data Antrian')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row">
                    <div class="ml-3">
                        <h3>Antrian Saat ini <span style="margin-left: 50px" id="antrian_now">0</span></h3>
                    </div>
                    <div class="ml-5">
                        <a href="#" id="bt_panggil" onclick="panggil(0,0)" class="btn btn-success panggil"><i class="fa fa-bullhorn"></i> Panggil</a>
                        <a href="#" id="bt_lanjut" onclick="selesai(0,0)" class="btn btn-primary ml-1"><i class="fa fa-forward"></i> Lanjut</a>
                    </div>
                </div>
                <div class="ibox-tools">

                    @can('jabatan.tambah')
                        {{-- <a href="{{ route('jabatan.tambah') }}"><button class="btn btn-primary">Tambah Jabatan</button></a> --}}
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
                {{ csrf_field() }}
                <!--<form action="#" method="post">
                    <div class="form-row">


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


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_antrian" >
            <thead>

            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Total Antrian</th>
                <th>Antrian Saat ini</th>
                <th>Sisa Antrian</th>
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
    var tabledata,table_index;
      $(document).ready(function(){
        $.ajaxSetup({
              headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
          });
          table= $('#table_antrian').DataTable({
          "processing": true,
          "serverSide": true,
          "stateSave"  : true,
          "deferRender": true,
          "pageLength": 10,
          "select" : true,
          "ajax":{
                   "url": "{{ route("antrian.getdata") }}",
                   "dataType": "json",
                   "type": "POST",
                   data: function ( d ) {
                     d._token= "{{csrf_token()}}";
                   }
                 },
          "columns": [
              {
                "data": "no",
                "orderable" : false,
                "width": "5%",
              },
              { "data": "nama_poli",
              },
              { "data": "total_antrian",
              },
              { "data": "antrian_saat_ini",
              },
              { "data": "sisa_antrian",
              },
            //   { "data": "action",
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
    function selesai(nomor){
        //console.log(kdpoli);
        nomor = $('#antrian_now').text();
        if(nomor == 0){
            return;
        }
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:{
              'nomor' : nomor,
            },
            url: '{{ route("antrian.antrianselesai") }}',
            beforeSend: function(){
                Swal.showLoading();
            },
            success: function(response){
                if(response.success == true){
                    table.ajax.reload(null, true);
                    getantrian();
                }else{
                    Swal.fire('UPS', response.message, 'info');
                }
              console.log(response);
            },
            complete: function(){
              Swal.hideLoading();
              Swal.close();
            },
          })

    }
    var total;
    function get_index(plus){
        if(plus == 1){
            if(this.total >= 0){
                this.total++;
                return this.total;
            }else{
                this.total = 0
                return 0;
            }
        }else{
            return this.total;
        }

    }
    function play(file, button){
        console.log(get_index());
        if(get_index(1) < file.length){
            // console.log(get_index());
            var audio = new Audio(file[get_index()]);
            audio.play();
            audio.addEventListener('ended', function(e){
                play(file, button);
            });
        }else{
            this.total = undefined;
            button.css('pointer-events','auto');
            button.attr('class', 'btn btn-success btn-xs icon-btn md-btn-flat product-tooltip');
            $('.panggil').css('pointer-events','auto');
            // $('.panggil').attr('class', 'btn btn-success btn-xs icon-btn md-btn-flat product-tooltip');
            // console.log(button);
            return;
        }

    }
    function panggil(e, antrian){
        // console.log(antrian);
        antrian = $('#antrian_now').text();
        if(antrian == 0){
            return;
        }
        var button = $('#'+e.id);
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:{
              'antrian' : antrian,
            },
            url: '{{ route("antrian.audio_panggil") }}',
            beforeSend: function(){
                Swal.showLoading();
                // e.prop('disabled', true);

                // console.log(e.id);
                $('.panggil').css('pointer-events','none');
                // $('.panggil').attr('class', 'btn btn-default btn-xs icon-btn md-btn-flat product-tooltip');
                button.css('pointer-events','none');
                button.attr('class', 'btn btn-default btn-xs icon-btn md-btn-flat product-tooltip');
            },
            success: function(response){
                var file = [];
                var audio = [];
                for(var i=0; i<response.length; i++){
                     file[i] = response[i].file;
                     audio[i] = new Audio(file[i]);
                     console.log(file[i]);
                }
                // for(var x=0; x<response.length;x++){
                //     console.log(get_index());
                // }
                    play(file, button);

                // for(var x=0; x <response.length;x+=2){

                //     // audio[get_index(1)].play();
                //     (function(){
                //         audio[get_index(1)].play();
                //         console.log(get_index());
                //         audio[get_index()].addEventListener('ended', function(e){
                //             console.log(get_index());



                //                 audio[get_index(1)].play();



                //         });
                //     }())
                // }

            //   console.log(response.length);
            },
            complete: function(){
              Swal.hideLoading();
              Swal.close();
            },
        })

        var file = "{{ asset('/inspinia/2.wav') }}";
        console.log(file);
        // var file2 = "{{ asset('/inspinia/3.wav') }}";
        // var audio = new Audio(file);
        // var audio2 = new Audio(file2);
        // audio.play();
        //     audio.addEventListener('ended',function(e){
        //         audio2.play();

        //     });
        //     audio2.addEventListener('ended',function(e){
        //         audio3.play();
        //     });
        //     audio3.addEventListener('ended',function(e){
        //         audio3.play();
        //     });

    }
    $(document).ready(function(){
       getantrian();
    });
    function getantrian(){
        $.ajax({
            type: 'GET',
            url: '{{ route("antrian.antriannow") }}',
            beforeSend: function(){
                Swal.showLoading();
            },
            success: function(response){
                console.log(response);
                $('#antrian_now').text(response.no_antrian);
            },
            complete: function(){
              Swal.hideLoading();
              Swal.close();
            },
        })
    }
</script>
@endpush
