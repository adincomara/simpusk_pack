@extends('layouts.table')
@section('title', 'Form Dokter')
@section('menu1', 'Master')
@section('menu2', 'Data Dokter')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Dokter</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($dokter)? $enc_id : ''}}">
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Kode Dokter <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="kdDokter" id="kdDokter" value="{{isset($dokter)? $dokter->kdDokter : ''}}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Nama Dokter <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="nmDokter" id="nmDokter" value="{{isset($dokter)? $dokter->nmDokter : ''}}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Status Dokter <span>*</span></label>
                            <select name="status" class="form-control" id="status">
                              <option value="1" {{ ($selectedstatus != '' && $selectedstatus == 1)? 'selected' : '' }}>Aktif</option>
                              <option value="0" {{ ($selectedstatus != '' && $selectedstatus == 0)? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                          </div>
                        </div>



                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('dokter.index')}}"  class="btn btn-default">Kembali</a>
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
        nmDokter:{
          required: true
        },
        kdDokter:{
          required: true
        }
      },
      messages: {
        nmDokter: {
          required: "Nama Dokter tidak boleh kosong"
        },
         kdDokter: {
          required: "Ruang Dokter tidak boleh kosong"
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

          $.ajax({
            type: 'POST',
            url : "{{route('dokter.simpan')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:$('#submitData').serialize(),
            dataType: "json",
            beforeSend: function () {
                $('#Loading').modal('show');
            },
            success: function(data){
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                  window.location.href="{{ route('dokter.index') }}";
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


