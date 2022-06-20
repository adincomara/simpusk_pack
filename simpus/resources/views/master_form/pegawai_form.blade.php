@extends('layouts.table')
@section('title', 'Form Pegawai')
@section('menu1', 'Master')
@section('menu2', 'Data Pegawai')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Pegawai</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pegawai)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Pegawai <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_pegawai" id="nama_pegawai" value="{{isset($pegawai)? $pegawai->nama_pegawai : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">NIP <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nip" id="nip" value="{{isset($pegawai)? $pegawai->nip : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">NIK <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nik" id="nik" minlength="16" onkeypress="return onlyNumberKey(event)" value="{{isset($pegawai)? $pegawai->nik : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Jenis Kelamin <span>*</span></label>
                              <select  class="form-control mb-1" name="jenis_kelamin" id="jenis_kelamin">
                                  <option value="Laki-Laki" @if (isset($pegawai)) @if ($pegawai->jenis_kelamin == "Laki-Laki") selected @endif @endif>Laki-Laki</option>
                                  <option value="Perempuan" @if (isset($pegawai)) @if ($pegawai->jenis_kelamin == "Perempuan") selected @endif @endif>Perempuan</option>
                              </select>
                          </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">NPWP <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="npwp" id="npwp" value="{{isset($pegawai)? $pegawai->npwp : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Tempat Lahir <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="tempat_lahir" id="tempat_lahir" value="{{isset($pegawai)? $pegawai->tempat_lahir : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Tanggal Lahir <span>*</span></label>
                              <input type="date" class="form-control mb-1" name="tanggal_lahir" id="tanggal_lahir" value="{{isset($pegawai)? date('Y-m-d',strtotime($pegawai->tanggal_lahir)) : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Alamat <span>*</span></label>
                              <textarea class="form-control" rows="3" name="alamat" id="alamat">{{isset($pegawai)? $pegawai->alamat : ''}}</textarea>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Jabatan <span>*</span></label>
                              <select class="form-control mb-1" name="id_jabatan" id="id_jabatan">
                                  @foreach ($arr_jabatan as $item)
                                  <option value="{{ $item->id_jabatan }}" @if (isset($pegawai)) @if ($pegawai->id_jabatan == $item->id_jabatan) selected @endif @endif>{{ $item->nama_jabatan }}</option>
                                  @endforeach
                              <select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Bidang <span>*</span></label>
                              <select class="form-control mb-1" name="id_bidang" id="id_bidang">
                                  @foreach ($arr_bidang as $item)
                                  <option value="{{ $item->id_bidang }}" @if (isset($pegawai)) @if ($pegawai->id_bidang == $item->id_bidang) selected @endif @endif>{{ $item->nama_bidang }}</option>
                                  @endforeach
                              <select>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('pegawai.index')}}"  class="btn btn-default">Kembali</a>
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
function onlyNumberKey(evt) {

          // Only ASCII character in that range allowed
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
      }

$('#submitData').validate({
    ignore: ":hidden:not(.editor)",
    rules: {
      nama_pegawai:{
        required: true
      },
      nip:{
        required: true
      },
      nik:{
        required: true
      },
      jenis_kelamin:{
        required: true
      },
      npwp:{
        required: true
      },
      tempat_lahir:{
        required: true
      },
      tanggal_lahir:{
        required: true
      },
      alamat:{
        required: true
      },
      id_jabatan:{
        required: true
      },
      id_bidang:{
        required: true
      },
    },
    messages: {
        nama_pegawai:{
            required: "Nama pegawai tidak boleh kosong"
        },
        nip:{
            required: "NIP tidak boleh kosong"
        },
        nik:{
            required: "NIK tidak boleh kosong"
        },
        jenis_kelamin:{
            required: "Jenis kelamin tidak boleh kosong"
        },
        npwp:{
            required: "NPWP tidak boleh kosong"
        },
        tempat_lahir:{
            required: "Tempat lahir tidak boleh kosong"
        },
        tanggal_lahir:{
            required: "Tanggal lahir tidak boleh kosong"
        },
        alamat:{
            required: "Alamat tidak boleh kosong"
        },
        id_jabatan:{
            required: "Jabatan tidak boleh kosong"
        },
        id_bidang:{
            required: "Bidang tidak boleh kosong"
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
           var nama_pegawai          =$('#nama_pegawai').val();
           var nip    =$('#nip').val();
           var nik    =$('#nik').val();
           var jenis_kelamin           =$('#jenis_kelamin').val();
           var npwp      =$('#npwp').val();
           var tempat_lahir=$('#tempat_lahir').val();
           var tanggal_lahir        =$('#tanggal_lahir').val();
           var id_jabatan          =$('#id_jabatan').val();
           var status          =$('#status').val();
           var id_bidang          =$('#id_bidang').val();
           var alamat          =$('#alamat').val();

           var dataFile = new FormData()

           dataFile.append('enc_id', enc_id);
           dataFile.append('nama_pegawai', nama_pegawai);
           dataFile.append('nip', nip);
           dataFile.append('jenis_kelamin', jenis_kelamin);
           dataFile.append('npwp', npwp);
           dataFile.append('tempat_lahir', tempat_lahir);
           dataFile.append('tanggal_lahir', tanggal_lahir);
           dataFile.append('id_jabatan', id_jabatan);
           dataFile.append('id_bidang', id_bidang);
           dataFile.append('nik', nik);
           dataFile.append('alamat', alamat);

          $.ajax({
            type: 'POST',
            url : "{{route('pegawai.simpan')}}",
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
                    window.location.href = "{{ route('pegawai.index') }}";
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

     $(document).ready(function(){
     $('#tanggal_lahir').bootstrapMaterialDatePicker({
      weekStart: 0,
      time: false,
      format : 'DD-MM-YYYY',
      clearButton: true
    });

   });
  </script>

@endpush


