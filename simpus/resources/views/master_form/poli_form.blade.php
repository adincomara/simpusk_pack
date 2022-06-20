@extends('layouts.table')
@section('title', 'Form Poli')
@section('menu1', 'Master')
@section('menu2', 'Data Poli')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Poli</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($poli)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Parent <span>*</span></label>
                              <select class="form-control" id="parent" name="parent">
                                 <option value="">Induk</option>
                                 @foreach($induk as $key => $value)
                                   <option value="{{$value->id}}" {{$selectedinduk==$value->id?'selected':''}}>{{$value->nama_poli}}</option>
                                 @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_poli" id="nama_poli" value="{{isset($poli)? $poli->nama_poli : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Poli (Untuk BPJS) <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kdpoli" id="kdpoli" value="{{isset($poli)? $poli->kdpoli : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Ruang <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="ruang_poli" id="ruang_poli" value="{{isset($poli)? $poli->ruang_poli : ''}}">
                            </div>
                          </div>



                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('poli.index')}}"  class="btn btn-default">Kembali</a>
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
        nama_poli:{
          required: true
        },
        ruang_poli:{
          required: true
        }
      },
      messages: {
        nama_poli: {
          required: "Nama Poli tidak boleh kosong"
        },
         ruang_poli: {
          required: "Ruang Poli tidak boleh kosong"
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

           var nama_poli       =$('#nama_poli').val();
           var ruang_poli      =$('#ruang_poli').val();
           var parent          =$('#parent').val();
           var kdpoli          =$('#kdpoli').val();


           var dataFile = new FormData()

           dataFile.append('nama_poli', nama_poli);
           dataFile.append('enc_id', enc_id);
           dataFile.append('ruang_poli', ruang_poli);
           dataFile.append('kdpoli', kdpoli);
           dataFile.append('parent', parent);

          $.ajax({
            type: 'POST',
            url : "{{route('poli.simpan')}}",
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
                  window.location.href="{{ route('poli.index') }}";
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


