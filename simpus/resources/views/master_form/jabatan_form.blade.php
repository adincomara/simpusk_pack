@extends('layouts.table')
@section('title', 'Form Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Jabatan</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($jabatan)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Jabatan <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_jabatan" id="nama_jabatan" value="{{isset($jabatan)? $jabatan->nama_jabatan : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('jabatan.index')}}"  class="btn btn-default">Kembali</a>
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
        nama_jabatan:{
          required: true
        },
        description:{
          required: true
        }
      },
      messages: {
        nama_jabatan: {
          required: "Nama jabatan tidak boleh kosong"
        },
        description: {
          required: "Deskripsi jabatan tidak boleh kosong",
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
           var enc_id         =$('#enc_id').val();
           var nama_jabatan          =$('#nama_jabatan').val();

           var dataFile = new FormData()

           dataFile.append('enc_id', enc_id);
           dataFile.append('nama_jabatan', nama_jabatan);

          $.ajax({
            type: 'POST',
            url : "{{route('jabatan.simpan')}}",
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
                 if(data.success == true){
                    window.location.href = "{{ route('jabatan.index') }}";
                 }

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
  </script>
@endpush


