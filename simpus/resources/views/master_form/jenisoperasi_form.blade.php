@extends('layouts.table')
@section('title', 'Form Jenis Operasi')
@section('menu1', 'Master')
@section('menu2', 'Data Jenis Operasi')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Jenis Operasi</h3>
                    {{-- <div class="ibox-tools">
                        <a class="collapse-link">
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
                        </a>
                    </div> --}}
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($jenisoperasi)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_jenis_operasi" id="kode_jenis_operasi" value="{{isset($jenisoperasi)? $jenisoperasi->kode_jenis_operasi : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_jenis_operasi" id="nama_jenis_operasi" value="{{isset($jenisoperasi)? $jenisoperasi->nama_jenis_operasi : ''}}">
                            </div>
                          </div>


                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('jenisoperasi.index')}}"  class="btn btn-default">Kembali</a>
                              </div>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')

<script type="text/javascript">

    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        kode_jenis_operasi:{
          required: true
        },
        nama_jenis_operasi:{
          required: true
        }
      },
      messages: {
        kode_jenis_operasi: {
          required: "Kode tidak boleh kosong"
        },
         nama_jenis_operasi: {
          required: "Nama tidak boleh kosong"
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
           var enc_id          =$('#enc_id').val();

           var kode_jenis_operasi   =$('#kode_jenis_operasi').val();
           var nama_jenis_operasi   =$('#nama_jenis_operasi').val();


           var dataFile = new FormData()

           dataFile.append('kode_jenis_operasi', kode_jenis_operasi);
           dataFile.append('enc_id', enc_id);
           dataFile.append('nama_jenis_operasi', nama_jenis_operasi);


          $.ajax({
            type: 'POST',
            url : "{{route('jenisoperasi.simpan')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#Loading').modal('show');
            },
            success: function(data){
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                  window.location.href="{{ route('jenisoperasi.index') }}";
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

     $(document).ready(function(){



   });
  </script>
@endpush


