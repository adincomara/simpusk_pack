@extends('layouts.table')
@section('title', 'Form Tindakan')
@section('menu1', 'Master')
@section('menu2', 'Data Tindakan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Tindakan</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($tindakan)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Tindakan<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_tindakan" id="kode_tindakan" value="{{isset($tindakan)? $tindakan->kode_tindakan : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Tindakan<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_tindakan" id="nama_tindakan" value="{{isset($tindakan)? $tindakan->nama_tindakan : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Tindakan Oleh<span>*</span></label>
                              <select class="form-control mb-1" name="tindakan_oleh" id="tindakan_oleh">
                                <option value="" selected="" disabled="disabled">Pilih Tindakan Oleh</option>
                                <?php
                                if(isset($tindakan)){
                                  ?>

                                <option value="dokter" <?php if($tindakan->tindakan_oleh == "dokter"){echo "selected";}else{}?>>Dokter</option>
                                <option value="petugas" <?php if($tindakan->tindakan_oleh == "petugas"){echo "selected";}else{}?>>Petugas</option>
                                <option value="dokter_dan_petugas" <?php if($tindakan->tindakan_oleh == "dokter_dan_petugas"){echo "selected";}else{}?>>Dokter dan Petugas</option>
                                <?php
                                }else{?>
                                <option value="dokter">Dokter</option>
                                <option value="petugas">Petugas</option>
                                <option value="dokter_dan_petugas">Dokter dan Petugas</option>
                              <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Poliklinik<span>*</span></label>
                              <select class="form-control mb-1" name="poliklinik" id="poliklinik" value="{{isset($tindakan)? $tindakan->poliklinik : ''}}">
                                <option value="" selected="" disabled="disabled">Pilih Poliklinik</option>
                                <?php
                                foreach($dataPoli as $dpoli){
                                  if(isset($tindakan)){
                                     if($tindakan->poliklinik = $dpoli->id){
                                      $selected = "selected";
                                     }else{
                                      $selected = "";
                                     }
                                  }else{
                                    $selected = "";
                                  }
                                  echo"
                                  <option value=".$dpoli->id." ".$selected.">".$dpoli->nama_poli."</option>
                                  ";
                                }?>
                              </select>
                            </div>
                          </div>



                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('tindakan.index')}}"  class="btn btn-default">Kembali</a>
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
        kode_tindakan:{
          required: true
        },
        nama_tindakan:{
          required: true
        },
        poliklinik:{
          required: true
        },
        tindakan_oleh:{
          required: true
        }
      },
      messages: {
        kode_tindakan: {
          required: "Kode tindakan tidak boleh kosong"
        },
         nama_tindakan: {
          required: "Nama tindakan tidak boleh kosong"
        },
         poliklinik: {
          required: "Poliklinik harus dipilih"
        },
         tindakan_oleh: {
          required: "Tindakan harus dipilih"
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

           var kode_tindakan       =$('#kode_tindakan').val();
           var nama_tindakan       =$('#nama_tindakan').val();
           var poliklinik          =$('#poliklinik').val();
           var tindakan_oleh       =$('#tindakan_oleh').val();
           var dataFile = new FormData()

           dataFile.append('kode_tindakan', kode_tindakan);
           dataFile.append('enc_id', enc_id);
           dataFile.append('nama_tindakan', nama_tindakan);
           dataFile.append('poliklinik', poliklinik);
           dataFile.append('tindakan_oleh', tindakan_oleh);

          $.ajax({
            type: 'POST',
            url : "{{route('tindakan.simpan')}}",
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
                  window.location.href="{{ route('tindakan.index') }}";
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


