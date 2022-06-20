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
                    <h3>Tambah Supplier</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($supplier)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_supplier" id="kode_supplier" {{isset($supplier)?"readonly":''}} value="{{isset($supplier)? $supplier->kode_supplier : ''}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_supplier" id="nama_supplier" value="{{isset($supplier)? $supplier->nama_supplier : ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat <span>*</span></label>
                            <textarea class="form-control" rows="3" name="alamat" id="alamat">{{isset($supplier)? $supplier->alamat : ''}}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No HP <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_telpon" id="no_telpon" value="{{isset($supplier)? $supplier->no_telpon : ''}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('supplier.index')}}"  class="btn btn-default">Kembali</a>
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
        kode_supplier:{
          required: true
        },
        nama_supplier:{
          required: true
        },
        no_telpon:{
          required: true
        },
        alamat: {
            required: true
        }
      },
      messages: {
        kode_supplier: {
          required: "Kode tidak boleh kosong"
        },
         nama_supplier: {
          required: "Nama tidak boleh kosong"
        },
         no_telpon: {
          required: "No Telp tidak boleh kosong"
        },
        alamat: {
            required: "Alamat tidak boleh kosong"
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

           var kode_supplier   =$('#kode_supplier').val();
           var nama_supplier   =$('#nama_supplier').val();
           var alamat          =$('#alamat').val();
           var no_telpon       =$('#no_telpon').val();

           var dataFile = new FormData()

           dataFile.append('kode_supplier', kode_supplier);
           dataFile.append('nama_supplier', nama_supplier);
           dataFile.append('enc_id', enc_id);
           dataFile.append('alamat', alamat);
           dataFile.append('no_telpon', no_telpon);

          $.ajax({
            type: 'POST',
            url : "{{route('supplier.simpan')}}",
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
                  window.location.href="{{ route('supplier.index') }}";
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


