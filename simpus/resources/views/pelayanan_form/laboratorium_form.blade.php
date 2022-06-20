@extends('layouts.table')
@section('title', 'Periksa Laboratorium')
@section('menu1', 'Pelayanan')
@section('menu2', 'Laboratorium')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Periksa Laboratorium</h3>
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
                        <div class="row">

                            <div class="col-md-4">
                              <div class="card-header">DATA PENDAFTARAN</div>
                               <div class="card-body">
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">No Rekam Medis <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="no_rawat" id="no_rawat" readonly="" value="{{$poli->no_rawat}}">
                                      <input type="hidden" class="form-control mb-1" name="pelayanan_poli_id" id="pelayanan_poli_id" readonly="" value="{{$poli->pelayanan_poli->id}}">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Dokter Penanggung Jawab <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="nama_dokter" id="nama_dokter" readonly="" value="{{$poli->nama_penanggung_jawab}}">
                                    </div>
                                  </div>
                                   <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Poli Tujuan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="id_dokter" id="id_dokter" readonly="" value="{{$poli->poli->nama_poli}}">
                                    </div>
                                  </div>
                               </div>
                            </div>
                            <div class="col-md-8">
                               <div class="card-header">DATA PASIEN</div>
                               <div class="card-body">

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Nama Pasien <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="nama_pasien" id="nama_pasien" value="{{isset($poli)? $poli->pasien->nama_pasien : ''}}" readonly="">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Tanggal Lahir <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="tanggal_lahir" id="tanggal_lahir"  value="{{isset($poli)? $poli->pasien->tanggal_lahir : ''}}" readonly="">
                                    </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Status Pasien <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="nama_penanggung_jawab" id="nama_penanggung_jawab" value="{{isset($poli)? $poli->pasien->status_pasien : ''}}" readonly="">
                                    </div>
                                  </div>
                                   <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">No BPJS <span>*</span></label><br/>
                                      <span>Isi dengan (-) jika tidak ada No BPJS</span>
                                      <input type="text" class="form-control mb-1" name="no_bpjs" id="no_bpjs" value="{{isset($poli)? $poli->pasien->no_bpjs : ''}}" readonly="">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Penunjang <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="no_bpjs" id="no_bpjs" value="{{isset($poli)? $poli->pelayanan_poli->penunjang : ''}}" readonly="">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Catatan Dokter<span></span></label>
                                      <textarea class="form-control mb-1" rows="5" name="note" id="note" value="{{isset($poli)? $poli->kunjungan->catatan : ''}}" readonly="">{{isset($poli)? $poli->kunjungan->catatan : ''}}</textarea>
                                    </div>
                                  </div>

                               </div>
                            </div>
                            <div class="col-md-12">
                               <div class="card-header"><center><h3>PEMERIKSAAN LABORATORIUM</h3></center></div>
                               <div class="card-body">
                                @foreach($PelayananLab as $lab)
                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label class="form-label">Pemeriksaan</label>
                                    <input type="text" class="form-control mb-1" name="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" id="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" value="{{$lab->pelayananlaboratorium->name}}" readonly="">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" class="form-control mb-1" name="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" id="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" value="{{$lab->pelayananlaboratorium->satuan}}" readonly="">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label class="form-label">Min</label>
                                    <input type="text" class="form-control mb-1" name="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" id="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" value="{{$lab->pelayananlaboratorium->min}}" readonly="">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label class="form-label">Max</label>
                                    <input type="text" class="form-control mb-1" name="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" id="nama_pemeriksaan_{{$lab->pelayananlaboratorium->id}}" value="{{$lab->pelayananlaboratorium->max}}" readonly="">
                                  </div>
                                  <div class="form-group col-md-2">
                                    <label class="form-label">Nilai</label>
                                    <input type="text" class="form-control mb-1" name="nilai_{{$lab->pelayananlaboratorium->id}}" id="nilai_{{$lab->pelayananlaboratorium->id}}" value="0">
                                  </div>
                                </div>
                                @endforeach
                             </div>
                            </div>

                            <div class="col-md-12">
                              <div class="card-body">
                                  <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <div class="text-right mt-3">
                                      <button type="submit" class="btn btn-primary" id="submitData">Simpan</button>&nbsp;
                                      <a href="{{route('pendaftaran.index')}}"  class="btn btn-default">Kembali</a>
                                    </div>
                                  </div>
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
        nama_dokter:{
          required: true
        },
        id_poli:{
          required: true
        },
        no_rekamedis:{
          required: true
        },
        nama_pasien:{
          required: true
        },
        tanggal_lahir:{
          required: true
        },
        nama_penanggung_jawab:{
          required: true
        },
        hubungan_dengan_penanggung_jawab:{
          required: true
        },
        alamat_penanggung_jawab:{
          required: true
        },
        status_pasien:{
          required: true
        },
        no_bpjs:{
          required: true
        },
      },
      messages: {
        nama_dokter: {
          required: "Nama Dokter tidak boleh kosong"
        },
         id_poli: {
          required: "Pilih salah satu Poli"
        },
         no_rekamedis: {
          required: "No Rekam Medis tidak boleh kosong"
        },
         nama_pasien: {
          required: "Nama Pasien tidak boleh kosong"
        },
         tanggal_lahir: {
          required: "Tanggal Lahir pasien tidak boleh kosong"
        },
         nama_penanggung_jawab: {
          required: "Nama Penanggung Jawab pasien tidak boleh kosong"
        },
         hubungan_dengan_penanggung_jawab: {
          required: "Hubungan Penanggung Jawab pasien tidak boleh kosong"
        },
        alamat_penanggung_jawab: {
          required: "Alamat Penanggung Jawab pasien tidak boleh kosong"
        },
         status_pasien: {
          required: "Pilih salah satu status pasien"
        },
        no_bpjs: {
          required: "No BPJS pasien tidak boleh kosong"
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
          var formAdd  = $('#submitData').serialize();
          //alert(formAdd);
          if($("#submitData").valid()){
          $.ajax({
            type: 'POST',
            url : "{{route('laboratorium.simpan')}}",
            data: $('#submitData').serialize(),
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            dataType: "json",

            success: function(data){
              //console.log(formAdd);
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                  window.location.href="{{ route('laboratorium.index') }}";
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
      }

</script>
@endpush


