@extends('layouts.table')
@section('title', 'Laporan Pasien Diagnosa')
@section('judultable', 'Laporan Pasien Diagnosa')
@section('menu1', 'Laporan')
@section('menu2', 'Laporan Pasien Diagnosa')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Laporan Pasien Berdasarkan Diagnosa</h3>
                <div class="ibox-tools">
                    <a href="{{ route('report.cetakDiagnosa',$enc_id)}}" target="_blank"><button class="btn btn-primary"><i class="fa fa-file-pdf"></i></button></a>
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


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_jabatan" >
                <thead>
                    <tr>
                      <th>No Rekam Medis</th>
                      <th>Alamat</th>
                      <th>Nama Pasien</th>
                      <th>Tempat, Tanggal Lahir</th>
                      <th>Status Pasien</th>
                      <th>No BPJS</th>
                    </tr>
                  </thead>
                    <tr>
                      <td>{{$no_rekamedis}}</td>
                      <td>{{$poli->alamat}}</td>
                      <td>{{$poli->nama_pasien}}</td>
                      <td>{{$poli->tempat_lahir}}, {{$poli->tanggal_lahir}}</td>
                      <td>{{$poli->status_pasien}}</td>
                      <td>{{$poli->no_bpjs}}</td>
                    </tr>

            </table>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">

    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        nama_dokter:{
          required: true
        },
        id_poli:{
          required: true
        },
        no_rekamedis:{
          required: true
        },
        nama_pasien:{
          required: true
        },
        tanggal_lahir:{
          required: true
        },
        nama_penanggung_jawab:{
          required: true
        },
        hubungan_dengan_penanggung_jawab:{
          required: true
        },
        alamat_penanggung_jawab:{
          required: true
        },
        status_pasien:{
          required: true
        },
        no_bpjs:{
          required: true
        },
      },
      messages: {
        nama_dokter: {
          required: "Nama Dokter tidak boleh kosong"
        },
         id_poli: {
          required: "Pilih salah satu Poli"
        },
         no_rekamedis: {
          required: "No Rekam Medis tidak boleh kosong"
        },
         nama_pasien: {
          required: "Nama Pasien tidak boleh kosong"
        },
         tanggal_lahir: {
          required: "Tanggal Lahir pasien tidak boleh kosong"
        },
         nama_penanggung_jawab: {
          required: "Nama Penanggung Jawab pasien tidak boleh kosong"
        },
         hubungan_dengan_penanggung_jawab: {
          required: "Hubungan Penanggung Jawab pasien tidak boleh kosong"
        },
        alamat_penanggung_jawab: {
          required: "Alamat Penanggung Jawab pasien tidak boleh kosong"
        },
         status_pasien: {
          required: "Pilih salah satu status pasien"
        },
        no_bpjs: {
          required: "No BPJS pasien tidak boleh kosong"
        }
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
        SimpanData();
      }
    });

     function SimpanData(){
          $('#simpan').addClass("disabled");
          var formAdd  = $('#submitData').serialize();
          //alert(formAdd);
          if($("#submitData").valid()){
          $.ajax({
            type: 'POST',
            url : "{{route('pelayanan_poli.simpan')}}",
            data: $('#submitData').serialize(),
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            dataType: "json",

            success: function(data){
              //console.log(formAdd);
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                  window.location.href="{{ route('pelayanan_poli.index') }}";
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
               $('#simpan').removeClass("disabled");
               $('#Loading').modal('hide');
            },
            error: function(data){
                 $('#simpan').removeClass("disabled");
                 $('#Loading').modal('hide');
                console.log(data);
            }
          });
        }
      }

  </script>
@endpush
