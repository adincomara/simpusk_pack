@extends('layouts.table')
@section('title', 'Form Diagnosa Penyakit')
@section('menu1', 'Master')
@section('menu2', 'Data Diagnosa Penyakit')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Diagnosa Penyakit</h3>
                    <div class="ibox-tools">
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
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($diagnosa_penyakit)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Diagnosa <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_diagnosa" id="kode_diagnosa" value="{{isset($diagnosa_penyakit)? $diagnosa_penyakit->kode_diagnosa : ''}}" {{isset($diagnosa_penyakit)? 'readonly' : ''}}>
                            </div>
                          </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Nama Penyakit <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="nama_penyakit" id="nama_penyakit" value="{{isset($diagnosa_penyakit)? $diagnosa_penyakit->nama_penyakit : ''}}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Ciri Ciri Penyakit <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="ciri_ciri_penyakit" id="ciri_ciri_penyakit" value="{{isset($diagnosa_penyakit)? $diagnosa_penyakit->ciri_ciri_penyakit : ''}}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Keterangan <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="keterangan" id="keterangan" value="{{isset($diagnosa_penyakit)? $diagnosa_penyakit->keterangan : ''}}">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label class="form-label">Ciri Ciri Umum <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="ciri_ciri_umum" id="ciri_ciri_umum" value="{{isset($diagnosa_penyakit)? $diagnosa_penyakit->ciri_ciri_umum : ''}}">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <div class="text-right mt-3">
                              <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                              <a href="{{route('diagnosa_penyakit.index')}}"  class="btn btn-default">Kembali</a>
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
      kode_diagnosa:{
        required: true
      },
      nama_penyakit:{
        required: true
      },
      ciri_ciri_penyakit:{
        required: true
      },
      keterangan:{
        required: true
      },
      ciri_ciri_umum:{
        required: true
      },

    },
    messages: {
      kode_diagnosa: {
        required: "Kode diagnosa tidak boleh kosong"
      },
      nama_penyakit: {
        required: "Nama penyakit tidak boleh kosong",
      },
      ciri_ciri_penyakit: {
          required: "Ciri-ciri umum tidak boleh kosong",
      },
      keterangan: {
          required: "Keterangan tidak boleh kosong",
      },
      ciri_ciri_umum: {
          required: "Ciri-ciri umum tidak boleh koson",
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
         var kode_diagnosa          =$('#kode_diagnosa').val();
         var nama_penyakit    =$('#nama_penyakit').val();
         var ciri_ciri_penyakit           =$('#ciri_ciri_penyakit').val();
         var keterangan      =$('#keterangan').val();
         var ciri_ciri_umum=$('#ciri_ciri_umum').val();

         var dataFile = new FormData()

         dataFile.append('enc_id', enc_id);
         dataFile.append('kode_diagnosa', kode_diagnosa);

         dataFile.append('nama_penyakit', nama_penyakit);
         dataFile.append('ciri_ciri_penyakit', ciri_ciri_penyakit);
         dataFile.append('keterangan', keterangan);
         dataFile.append('ciri_ciri_umum', ciri_ciri_umum);

        $.ajax({
          type: 'POST',
          url : "{{route('diagnosa_penyakit.simpan')}}",
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
               window.location.href = "{{ route('diagnosa_penyakit.index') }}";
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


