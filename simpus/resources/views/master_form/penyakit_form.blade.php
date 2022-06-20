@extends('layouts.table')
@section('title', 'Form Penyakit')
@section('menu1', 'Master')
@section('menu2', 'Data Penyakit')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Penyakit</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($penyakit)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Penyakit<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_penyakit" id="kode_penyakit" value="{{isset($penyakit)? $penyakit->kode_penyakit : $no_rekam}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Penyakit<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_penyakit" id="nama_penyakit" value="{{isset($penyakit)? $penyakit->nama_penyakit : ''}}">
                            </div>
                          </div>



                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('penyakit.index')}}"  class="btn btn-default">Kembali</a>
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
        kode_penyakit:{
          required: true
        },
        nama_penyakit:{
          required: true
        }
      },
      messages: {
        kode_penyakit: {
          required: "Kode Penyakit tidak boleh kosong"
        },
         nama_penyakit: {
          required: "Nama Penyakit tidak boleh kosong"
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

           var kode_penyakit       =$('#kode_penyakit').val();
           var nama_penyakit       =$('#nama_penyakit').val();


           var dataFile = new FormData()

           dataFile.append('kode_penyakit', kode_penyakit);
           dataFile.append('enc_id', enc_id);
           dataFile.append('nama_penyakit', nama_penyakit);


          $.ajax({
            type: 'POST',
            url : "{{route('penyakit.simpan')}}",
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
                  window.location.href="{{ route('penyakit.index') }}";
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


