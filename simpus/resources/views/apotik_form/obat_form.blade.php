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
                    <h3>Tambah Obat</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($obat)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_obat" id="kode_obat" value="{{isset($obat)? $obat->kode_obat : ''}}" {{isset($obat)? 'readonly' : ''}}>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Barcode Obat</label>
                              <input type="text" class="form-control mb-1" name="barcode_obat" id="barcode_obat" value="{{isset($obat)? $obat->barcode_obat : ''}}" {{isset($obat)? 'readonly' : ''}}>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Obat<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_obat" id="nama_obat" value="{{isset($obat)? $obat->nama_obat : ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Obat</label>
                            <textarea class="form-control" rows="3" name="jenis_obat" id="jenis_obat">{{isset($obat)? $obat->jenis_obat : ''}}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Satuan <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="satuan" id="satuan" value="{{isset($obat)? $obat->satuan : ''}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('obat.index')}}"  class="btn btn-default">Kembali</a>
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
        kode_obat:{
          required: true
        },
        nama_obat:{
          required: true
        },
        satuan:{
          required: true
        },
      },
      messages: {
        kode_obat: {
          required: "Kode tidak boleh kosong"
        },
         nama_obat: {
          required: "Nama tidak boleh kosong"
        },
         satuan: {
          required: "Satuan tidak boleh kosong"
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

           var kode_obat   =$('#kode_obat').val();
           var nama_obat   =$('#nama_obat').val();
           var jenis_obat          =$('#jenis_obat').val();
           var dosis_aturan_obat       =$('#dosis_aturan_obat').val();
           var satuan       =$('#satuan').val();
           var barcode_obat = $('#barcode_obat').val();

           var dataFile = new FormData()

           dataFile.append('kode_obat', kode_obat);
           dataFile.append('nama_obat', nama_obat);
           dataFile.append('enc_id', enc_id);
           dataFile.append('jenis_obat', jenis_obat);
           dataFile.append('barcode_obat', barcode_obat);
           dataFile.append('dosis_aturan_obat', dosis_aturan_obat);
           dataFile.append('satuan', satuan);

          $.ajax({
            type: 'POST',
            url : "{{route('obat.simpan')}}",
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
                  window.location.href="{{ route('obat.index') }}";
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


