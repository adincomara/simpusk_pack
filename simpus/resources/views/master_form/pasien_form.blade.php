@extends('layouts.table')
@section('title', 'Form Pasien')
@section('menu1', 'Master')
@section('menu2', 'Data Pasien')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Pasien</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pasien)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No. KTP <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_ktp" id="no_ktp"
                                value="{{isset($pasien)? $pasien->no_ktp : ''}}">
                              <a href="#" class="btn btn-outline-success my-2 my-sm-0" id="cek_ktp">
                                <i class="fa fa-search"></i>
                              </a>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No Rekam Medis <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_rekamedis" id="no_rekamedis"
                                value="{{isset($pasien)? $pasien->no_rekamedis : $no_rekam}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Pasien <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_pasien" id="nama_pasien"
                                value="{{isset($pasien)? $pasien->nama_pasien : ''}}">
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Status Pasien <span>*</span></label>
                              <select class="form-control mb-1" name="status_pasien" id="status_pasien"
                                onchange="pilihStatusPasien()" value="{{isset($pasien)? $pasien->status_pasien : ''}}">
                                <?php
                              if(isset($pasien)){
                                ?>
                                <option value="BPJS" <?php if($pasien->status_pasien == "BPJS"){echo "selected";}else{}?>>BPJS
                                </option>
                                <option value="UMUM" <?php if($pasien->status_pasien == "UMUM"){echo "selected";}else{}?>>UMUM
                                </option>
                                <?php
                              }else{?>
                                <option value="" selected disabled="">Pilih Status Pasien</option>
                                <option value="BPJS">BPJS</option>
                                <option value="UMUM">UMUM</option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">No BPJS <span>*</span></label>
                                  <input type="text" class="form-control mb-1" name="no_bpjs" id="no_bpjs"
                                    value="{{isset($pasien)? $pasien->no_bpjs : ''}}">
                                    <a href="#" class="btn btn-outline-success my-2 my-sm-0" id="cek_bpjs">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Jenis Kelamin<span>*</span></label>
                                  <select class="form-control mb-1" name="jenis_kelamin" id="jenis_kelamin">
                                    <?php
                                    if(isset($pasien)){
                                        ?>
                                    <option value="L" <?php if($pasien->jenis_kelamin == "L"){echo "selected";}else{}?>>Laki-laki
                                    </option>
                                    <option value="P" <?php if($pasien->jenis_kelamin == "P"){echo "selected";}else{}?>>Perempuan
                                    </option>
                                    <?php
                                    }else{?>
                                    <option value="" selected disabled="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">No Telp <span>*</span></label>
                                  <input type="text" class="form-control mb-1" name="telp" id="telp" onkeypress="return onlyNumberKey(event)"
                                    value="{{isset($pasien)? $pasien->telp : ''}}">
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Tempat Lahir <span>*</span></label>
                                  <input type="text" class="form-control mb-1" name="tempat_lahir" id="tempat_lahir"
                                    value="{{isset($pasien)? $pasien->tempat_lahir : ''}}">
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Tanggal Lahir <span>*</span></label>
                                  <input type="date" class="form-control mb-1" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{isset($pasien)? date('Y-m-d',strtotime($pasien->tanggal_lahir)) : ''}}">
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Alamat KTP<span>*</span></label>
                                  <textarea class="form-control mb-1" rows="5" name="alamat" id="alamat">{{isset($pasien)? $pasien->alamat : null}}</textarea>
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Alamat Domisili<span>*</span></label>
                                  <textarea class="form-control mb-1" rows="5" name="alamat_domisili" id="alamat_domisili">{{isset($pasien)? $pasien->alamat_domisili: null}}</textarea>
                                </div>
                              </div>
                              <div class="form-row d-flex flex-row-reverse">
                                <div class="form-group col-md-12">
                                  <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                    <a href="{{route('pasien.index')}}" class="btn btn-default">Kembali</a>
                                  </div>
                                </div>
                            </div>


                    </div>
                    </form>
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
      nama_pasien:{
        required: true
      },
      status_pasien:{
        required: true
      },
      no_bpjs:{
        required: true
      },
    //   no_ktp:{
    //     required: true
    //   },
      jenis_kelamin:{
        required: true
      },
      alamat:{
        required: true
      },
      tempat_lahir:{
        required: true
      },
      tanggal_lahir:{
        required: true
      },
      alamat_domisili:{
          required: true
      },
      no_rekamedis:{
          required: true
      },
      telp:{
          required: true
      },
    },
    messages: {
      nama_pasien: {
        required: "Nama pasien tidak boleh kosong"
      },
       status_pasien: {
        required: "Status pasien belum dipilih"
      },
       no_bpjs: {
        required: "No BPJS tidak boleh kosong"
      },
    //    no_ktp: {
    //     required: "No KTP tidak boleh kosong"
    //   },
       jenis_kelamin: {
        required: "Jenis Kelamin pasien belum dipilih"
      },
       alamat: {
        required: "Alamat pasien tidak boleh kosong"
      },
       tempat_lahir: {
        required: "Tempat lahir pasien tidak boleh kosong"
      },
       tanggal_lahir: {
        required: "Tanggal lahir pasien tidak boleh kosong"
      },
      alamat_domisili: {
          required:"Alamat domisili tidak boleh kosong"
      },
      no_rekamedis: {
          required: "Nomor rekamedis tidak boleh kosong"
      },
      telp: {
          required: "Nomor telp tidak boleh kosong"
      },
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
         var enc_id            =$('#enc_id').val();
         var nama_pasien       =$('#nama_pasien').val();
         var status_pasien     =$('#status_pasien').val();
         var no_bpjs           =$('#no_bpjs').val();
         var no_ktp            =$('#no_ktp').val();
         var jenis_kelamin     =$('#jenis_kelamin').val();
         var alamat            =$('#alamat').val();
         var telp            =$('#telp').val();
         var alamat_domisili   =$('#alamat_domisili').val();
         var tempat_lahir      =$('#tempat_lahir').val();
         var tanggal_lahir    =$('#tanggal_lahir').val();
         var no_rekamedis    =$('#no_rekamedis').val();

         var dataFile = new FormData()

         dataFile.append('nama_pasien', nama_pasien);
         dataFile.append('enc_id', enc_id);
         dataFile.append('status_pasien', status_pasien);
         dataFile.append('no_bpjs', no_bpjs);
         dataFile.append('no_ktp', no_ktp);
         dataFile.append('jenis_kelamin', jenis_kelamin);
         dataFile.append('telp', telp);
         dataFile.append('alamat', alamat);
         dataFile.append('alamat_domisili', alamat_domisili);
         dataFile.append('tempat_lahir', tempat_lahir);
         dataFile.append('tanggal_lahir', tanggal_lahir);
         dataFile.append('no_rekamedis', no_rekamedis);
        $.ajax({
          type: 'POST',
          url : "{{route('pasien.simpan')}}",
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
                window.location.href="{{ route('pasien.index') }}";
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

    $('#cek_ktp').click(function() {
      var nik = $('#no_ktp').val();

      $.ajax({
          url:"{{ route('pasien.validate') }}",
          type:'POST',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          data: {
            'nik': nik
          },
          beforeSend:function(){
            Swal.showLoading();
          },
          success: function (data) {
            console.log(data.datas);
            if(data.datas != null){

              var date = data.datas.response.tglLahir;
              var tglLahir = date.split("-").reverse().join("-");

              $('#nama_pasien').val(data.datas.response.nama);
              $('#status_pasien').val('BPJS');
              $('#no_bpjs').val(data.datas.response.noKartu);
              $('#jenis_kelamin').val(data.datas.response.sex);
              $('#telp').val(data.datas.response.noHP);
              $('#tanggal_lahir').val(tglLahir);
            //   $('#no_ktp').val(data.datas.response.noKTP);

            }else{
              console.log('Kosong');
              Swal.fire("Ups!", "NIK Belum terdaftar di BPJS.", "error");
            }
            // swal.hideLoading();
            // swal.close();
          },
          complete: function(){
            Swal.hideLoading();
            Swal.close();
          }
      })
    });
    $('#cek_bpjs').click(function() {
      var nik = $('#no_bpjs').val();

      $.ajax({
          url:"{{ route('pasien.validate') }}",
          type:'POST',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          data: {
            'nik': nik
          },
          beforeSend:function(){
            Swal.showLoading();
          },
          success: function (data) {
            console.log(data.datas);
            if(data.datas != null){

              var date = data.datas.response.tglLahir;
              var tglLahir = date.split("-").reverse().join("-");

              $('#nama_pasien').val(data.datas.response.nama);
              $('#status_pasien').val('BPJS');
              $('#no_bpjs').val(data.datas.response.noKartu);
              $('#jenis_kelamin').val(data.datas.response.sex);
              $('#telp').val(data.datas.response.noHP);
              $('#tanggal_lahir').val(tglLahir);
              $('#no_ktp').val(data.datas.response.noKTP);

            }else{
              console.log('Kosong');
              Swal.fire("Ups!", "NIK Belum terdaftar di BPJS.", "error");
            }
            // swal.hideLoading();
            // swal.close();
          },
          complete: function(){
            Swal.hideLoading();
            Swal.close();
          }
      })
    });
  </script>


  <script>
    function pilihStatusPasien(){
    var status_pasien = $('#status_pasien').val();
    if(status_pasien == "BPJS"){
      $('#no_bpjs').prop('readonly', false);
      $('#no_bpjs').val('');
    }else{
      $('#no_bpjs').prop('readonly', true);
      $('#no_bpjs').val('-');
    }
  }
  </script>
@endpush


