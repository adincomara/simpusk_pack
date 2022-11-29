@extends('layouts.table')
@section('title', 'Integrasi BPJS')
@section('judultable', 'Integrasi BPJS')
@section('menu1', 'Integrasi')
@section('menu2', 'BPJS')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Integrasi BPJS</h3>
                <div class="ibox-tools">
                    {{--  @can('jabatan.tambah')
                        <a href="{{ route('jabatan.tambah') }}"><button class="btn btn-primary">Tambah Jabatan</button></a>
                    @endcan  --}}
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
                        </select>

                        </div>
                        <div class="col-md-6 mb-4 ml-4">

                            <div id="input" class="input-group">
                                <input type="search" name="search" class="form-control" id="key">
                            </div>
                        </div>


                        <div class="col mb-4">

                        </div>
                    </div>
                </form> -->

                <div class="table-responsive">

                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Master Data</a>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="panel-group">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Dokter
                                                            </h5>
                                                            <p id="time_dokter">{{ $time_dokter }}</p>
                                                            <div>
                                                                <a href="{{ route('dokter.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="master_dokter" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Poli
                                                            </h5>
                                                            <p id="time_poli">{{ $time_poli }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="master_poli" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Pelayanan Pasien</a>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="panel-group">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Spesialis (Rujukan)
                                                            </h5>
                                                            <p id="time_spesialis">{{ $time_spesialis }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_spesialis" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Sub Spesialis (Rujukan)
                                                            </h5>
                                                            <p id="time_subspesialis">{{ $time_subspesialis }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_subspesialis" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Sarana (Rujukan)
                                                            </h5>
                                                            <p id="time_sarana">{{ $time_sarana }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_sarana" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Khusus (Rujukan)
                                                            </h5>
                                                            <p id="time_khusus">{{ $time_khusus }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_khusus" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Status Pulang
                                                            </h5>
                                                            <p id="time_status_pulang">{{ $time_status_pulang }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_status_pulang" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading d-flex justify-content-between">
                                                            <h5 class="panel-title">
                                                                Kesadaran
                                                            </h5>
                                                            <p id="time_kesadaran">{{ $time_kesadaran }}</p>
                                                            <div>
                                                                <a href="{{ route('poli.index') }}" id="" class="btn btn-success">Lihat Data</a>
                                                                <a href="#" id="pelayanan_kesadaran" class="btn btn-primary">Sinkronasi</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
        
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
//SCRIPT MASTER DOKTER
<script>
    $('#master_dokter').on('click', function(){
        $('#master_dokter').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.master_dokter')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              if (data.success == true) {
                  $('#time_dokter').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#master_dokter').removeClass("disabled");
            },
            error: function(data){
                console.log(data.response);
                Swal.hideLoading();
                $('#master_dokter').removeClass("disabled");
                Swal.fire('Error!', data.message,'error');
            }
        });
    });
</script>
//SCRIPT MASTER POLI
<script>
    $('#master_poli').on('click', function(){
        $('#master_poli').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.master_poli')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_poli').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#master_poli').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#master_poli').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN SPESIALIS
<script>
    $('#pelayanan_spesialis').on('click', function(){
        $('#pelayanan_spesialis').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_spesialis')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_spesialis').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_spesialis').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_spesialis').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN SUBSPESIALIS
<script>
    $('#pelayanan_subspesialis').on('click', function(){
        $('#pelayanan_subspesialis').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_subspesialis')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_subspesialis').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_subspesialis').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_subspesialis').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN SARANA
<script>
    $('#pelayanan_sarana').on('click', function(){
        $('#pelayanan_sarana').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_sarana')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_sarana').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_sarana').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_sarana').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN KHUSUS
<script>
    $('#pelayanan_khusus').on('click', function(){
        $('#pelayanan_khusus').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_khusus')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_khusus').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_khusus').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_khusus').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN KESADARAN
<script>
    $('#pelayanan_kesadaran').on('click', function(){
        $('#pelayanan_kesadaran').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_kesadaran')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_kesadaran').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_kesadaran').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_kesadaran').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>
//SCRIPT PELAYANAN STATUS PULANG
<script>
    $('#pelayanan_status_pulang').on('click', function(){
        $('#pelayanan_status_pulang').addClass("disabled");
        $.ajax({
            type: 'GET',
            url : "{{route('integrasi.bpjs.pelayanan_status_pulang')}}",
            dataType: "json",
            beforeSend: function () {
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
            success: function(data){
              console.log(data);
              console.log('tes');
              if (data.success == true) {
                  $('#time_status_pulang').text(data.time)
                  Swal.fire('Yes',data.message,'info');
              } else {
                  Swal.fire('Ups',data.message,'info');
              }
  
            },
            complete: function () {
              Swal.hideLoading();
              $('#pelayanan_status_pulang').removeClass("disabled");
            },
            error: function(data){
                console.log(data);
                console.log('tes');
                Swal.hideLoading();
                $('#pelayanan_status_pulang').removeClass("disabled");
                Swal.fire('Error!',data.message,'error');
            }
        });
    });
</script>

@endpush
