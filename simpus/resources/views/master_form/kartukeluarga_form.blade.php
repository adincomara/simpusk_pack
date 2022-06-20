@extends('layouts.table')
@section('title', 'Form Kartu Keluarga')
@section('menu1', 'Master')
@section('menu2', 'Data Kartu Keluarga')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Kartu Keluarga</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($kk)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No. KK <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_kk" id="no_kk" value="{{isset($kk)? $kk->no_kk : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama Kepala Keluarga <span>*</span></label>
                              @if(isset($kk))
                              <input type="text" class="form-control mb-1" name="nama_kepala_keluarga" id="nama_kepala_keluarga" value="{{isset($kk)? $kk->nama_kepala_keluarga : ''}}">
                              @else
                              <input type="text" class="form-control mb-1" name="nama_kepala_keluarga" id="nama_kepala_keluarga" value="{{isset($kk)? $kk->nama_kepala_keluarga : ''}}" onkeyup="ketikNama()">
                              @endif
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Alamat <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="alamat" id="alamat" value="{{isset($kk)? $kk->alamat : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label class="form-label">RT <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="rt" id="rt" value="{{isset($kk)? $kk->rt : ''}}">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">RW <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="rw" id="rw" value="{{isset($kk)? $kk->rw : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label class="form-label">Kabupaten / Kota <span>*</span></label>
                              <select class="form-control select2" id="cmbKabkot"  name="cmbKabkot" onchange="pilihKabkot()">
                                    <option value="0" selected disabled>Pilih Kabupaten/Kota</option>
                                    @if(isset($kk))
                                      @foreach($getKabupaten as $kabupaten)
                                        <option value="{{$kabupaten->id}}"
                                          @if ($kabupaten->id == $kk->kabkot_id)
                                              selected="selected"
                                          @endif
                                        >{{$kabupaten->name}}</option>
                                      @endforeach
                                      @else
                                      @foreach($getKabupaten as $kabupaten)
                                        <option value="{{$kabupaten->id}}">{{$kabupaten->name}}</option>
                                      @endforeach
                                    @endif
                                  </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Kecamatan <span>*</span></label>
                              <select class="form-control select2" id="cmbKec"  name="cmbKec" onchange="pilihKec()">
                                  @if(isset($kk))
                                      @foreach($getKecamatan as $kecamatan)
                                        <option value="{{$kecamatan->id}}"
                                          @if ($kecamatan->id == $kk->kec_id)
                                              selected="selected"
                                          @endif
                                        >{{$kecamatan->name}}</option>
                                      @endforeach
                                      @else
                                    <option value="0" selected disabled>Pilih Kecamatan</option>
                                    @endif
                                  </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label class="form-label">Kelurahan <span>*</span></label>
                              <select class="form-control select2" id="cmbKel"  name="cmbKel">
                                    @if(isset($kk))
                                      @foreach($getKelurahan as $kelurahan)
                                        <option value="{{$kelurahan->id}}"
                                          @if ($kelurahan->id == $kk->kel_id)
                                              selected="selected"
                                          @endif
                                        >{{$kelurahan->name}}</option>
                                      @endforeach
                                      @else
                                    <option value="0" selected disabled>Pilih Kelurahan</option>
                                    @endif
                                  </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Kode Pos <span>*</span></label>
                              <input type="text" class="form-control" id="kode_pos"  name="kode_pos" value="{{isset($kk)? $kk->kode_pos : ''}}">
                            </div>
                          </div>
                          <hr>
                          <h4 class="font-weight-bold py-3 mb-4">
                          <center>Data Anggota Keluarga</center>
                          </h4>
                          <hr>
                <div id="formkk">
                    @if(isset($kk))
                              @foreach($getDataDetail as $index => $dataDetail)
                          <div class="form-row data_{{ $index }}">
                            <div class="form-group col-md-2">
                              <label class="form-label">NIK<span>*</span></label>
                              <input type="text" class="form-control" id="nik_{{$index}}" name="nik_{{$index}}" value="{{$dataDetail->nik}}" onkeypress="return onlyNumberKey(event)" minlength="16" required>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="form-label">Nama Lengkap<span>*</span></label>
                              <input type="text" class="form-control" id="nama_kk_{{$index}}" name="nama_kk_{{$index}}" value="{{$dataDetail->nama_lengkap}}" required>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">JK <span>*</span></label>
                              <select class="form-control" id="jk_{{$index}}" name="jk_{{$index}}">
                                <option value="" disabled="">Pilih Jenis Kelamin</option>
                                <option value="L" @if ($dataDetail->jenis_kelamin == 'L') selected="selected" @endif>Laki-laki</option>
                                <option value="P" @if ($dataDetail->jenis_kelamin == 'P') selected="selected" @endif>Perempuan</option>
                              </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="form-label">Tanggal Lahir <span>*</span></label>
                              <input type="date" class="form-control" id="tanggal_lahir_{{$index}}" name="tanggal_lahir_{{$index}}" value="{{$dataDetail->tanggal_lahir}}">
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Agama <span>*</span></label>
                              <select class="form-control" id="agama_{{$index}}"  name="agama_{{$index}}">
                                <option value="" selected disabled="">Pilih Agama</option>
                                <option value="Islam" @if ($dataDetail->agama == 'Islam') selected="selected" @endif>Islam</option>
                                <option value="Kristen" @if ($dataDetail->agama == 'Kristen') selected="selected" @endif>Kristen</option>
                                <option value="Katholik" @if ($dataDetail->agama == 'Katholik') selected="selected" @endif>Katholik</option>
                                <option value="Hindu" @if ($dataDetail->agama == 'Hindu') selected="selected" @endif>Hindu</option>
                                <option value="Budha" @if ($dataDetail->agama == 'Budha') selected="selected" @endif>Budha</option>
                                <option value="Konghucu" @if ($dataDetail->agama == 'Konghucu') selected="selected" @endif>Konghucu</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Pndkn <span>*</span></label>
                              <select class="form-control" id="pendidikan_{{$index}}"  name="pendidikan_{{$index}}">
                                <option value="" selected disabled="">Pilih Pendidikan</option>
                                <option value="TK" @if ($dataDetail->pendidikan == 'TK') selected="selected" @endif>TK</option>
                                <option value="SD_MI" @if ($dataDetail->pendidikan == 'SD_MI') selected="selected" @endif>SD/MI</option>
                                <option value="SMP_MTS" @if ($dataDetail->pendidikan == 'SMP_MTS') selected="selected" @endif>SMP/MTS</option>
                                <option value="SMA_SMK" @if ($dataDetail->pendidikan == 'SMA_SMK') selected="selected" @endif>SMA/SMK</option>
                                <option value="S1" @if ($dataDetail->pendidikan == 'S1') selected="selected" @endif>S1</option>
                                <option value="S2" @if ($dataDetail->pendidikan == 'S2') selected="selected" @endif>S2</option>
                                <option value="S3" @if ($dataDetail->pendidikan == 'S3') selected="selected" @endif>S3</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Pkrjn <span>*</span></label>
                              <input type="text" class="form-control" id="jenis_pekerjaan_{{$index}}"  name="jenis_pekerjaan_{{$index}}" value="{{$dataDetail->jenis_pekerjaan}}">
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">GolDarah <span>*</span></label>
                              <select class="form-control" id="golongan_darah_{{$index}}"  name="golongan_darah_{{$index}}">
                                <option value="" selected disabled="">Pilih Golongan Darah</option>
                                <option value="-" @if ($dataDetail->golongan_darah == '-') selected="selected" @endif>-</option>
                                <option value="A" @if ($dataDetail->golongan_darah == 'A') selected="selected" @endif>A</option>
                                <option value="B" @if ($dataDetail->golongan_darah == 'B') selected="selected" @endif>B</option>
                                <option value="AB" @if ($dataDetail->golongan_darah == 'AB') selected="selected" @endif>AB</option>
                                <option value="O" @if ($dataDetail->golongan_darah == 'O') selected="selected" @endif>O</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Hbngn <span>*</span></label>
                              <input type="text" id="status_hubungan_{{$index}}"  name="status_hubungan_{{$index}}" class="form-control" value="{{$dataDetail->status_hubungan}}">
                            </div>
                            <div class="form-group col-md-1">
                                <button type="button" onclick="removeAnggota({{ $index }})" class="btn btn-danger"><i class="fa fa-close"></i></button>
                            </div>
                          </div>
                              @endforeach
                    @else
                          <div class="form-row data_{{ isset($kk)?count($getDataDetail) : '1' }}">
                            <div class="form-group col-md-2">
                              <label class="form-label">NIK<span>*</span></label>
                              <input type="text" class="form-control" id="nik_1" minlength="16" onkeypress="return onlyNumberKey(event)" name="nik_{{ isset($kk)?count($getDataDetail):'1' }}" required>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="form-label">Nm Lngkp<span>*</span></label>
                              <input type="text" class="form-control" id="nama_kk_{{ isset($kk)?count($getDataDetail):'1' }}"  name="nama_kk_{{ isset($kk)?count($getDataDetail):'1' }}" required>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">JK <span>*</span></label>
                              <select class="form-control" id="jk_1"  name="jk_1">
                                <option value="" selected disabled="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                              </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="form-label">Tgl Lhr <span>*</span></label>
                              <input type="date" class="form-control" id="tanggal_lahir_1"  name="tanggal_lahir_1">
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Agama <span>*</span></label>
                              <select class="form-control" id="agama_1"  name="agama_1">
                                <option value="" selected disabled="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katholik">Katholik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Pndkn <span>*</span></label>
                              <select class="form-control" id="pendidikan_1"  name="pendidikan_1">
                                <option value="" selected disabled="">Pilih Pendidikan</option>
                                <option value="TK">TK</option>
                                <option value="SD_MI">SD/MI</option>
                                <option value="SMP_MTS">SMP/MTS</option>
                                <option value="SMA_SMK">SMA/SMK</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Pkrjn <span>*</span></label>
                              <input type="text" class="form-control" id="jenis_pekerjaan_1"  name="jenis_pekerjaan_1">
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">GolDarah <span>*</span></label>
                              <select class="form-control" id="golongan_darah_1"  name="golongan_darah_1">
                                <option value="" selected disabled="">Pilih Golongan Darah</option>
                                <option value="-">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                              </select>
                            </div>
                            <div class="form-group col-md-1">
                              <label class="form-label">Hbngn <span>*</span></label>
                              <input type="text" class="form-control" id="status_hubungan_1"  name="status_hubungan_1">
                            </div>
                            <div class="form-group col-md-1">
                                <button type="button" onclick="removeAnggota({{ isset($kk)?count($getDataDetail) : '1' }})" class="btn btn-danger"><i class="fa fa-close"></i></button>
                              </div>
                          </div>
                          @endif
                          <div id="ajaxAdd">
                          </div>
                </div>

                          <input type="hidden" id="total" name="total" value="{{ isset($kk)?count($getDataDetail) : '1' }}">
                          <div class="form-row">
                            <a href="#!" class="btn btn-success" onclick="addAnggota()">Tambah Anggota Keluarga</a>
                          </div>
                          <div class="form-row d-flex flex-row-reverse">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('kk.index')}}"  class="btn btn-default">Kembali</a>
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
$(document).ready(function(){
    $('.select2').select2();
});
function onlyNumberKey(evt) {

          // Only ASCII character in that range allowed
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
      }
$('#submitData').validate({
    ignore: ":hidden:not(.editor)",
    onclick: false,
    rules: {
      no_kk:{
        required: true
      },
      nama_kepala_keluarga:{
        required: true
      },
      alamat:{
        required: true
      },
      rt:{
        required: true
      },
      rw:{
        required: true
      },
      cmbKec:{
        required: true
      },
      cmbKabkot:{
        required: true
      },
      cmbKel:{
        required: true
      },
      kode_pos:{
        required: true
      }
    },
    messages: {
      no_kk: {
        required: "No KK tidak boleh kosong"
      },
       nama_kepala_keluarga: {
        required: "Nama Kepala Keluarga tidak boleh kosong"
      },
       alamat: {
        required: "Alamat tidak boleh kosong"
      },
       rt: {
        required: "RT tidak boleh kosong"
      },
       rw: {
        required: "RW tidak boleh kosong"
      },
       cmbKec: {
        required: "Kecamatan belum dipilih"
      },
       cmbKabkot: {
        required: "Kabupaten / Kota belum dipilih"
      },
       cmbKel: {
        required: "Kelurahan belum dipilih"
      },
       kode_pos: {
        required: "Kodepos tidak boleh kosong"
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
          url : "{{route('kk.simpan')}}",
          data: $('#submitData').serialize(),
          //data: {v_status:formAdd,_token:token},
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          // processData: false,
          // contentType: false,
          dataType: "json",

          success: function(data){
            //console.log(formAdd);
            if (data.success) {
                Swal.fire('Yes',data.message,'info');
                window.location.href="{{ route('kk.index') }}";
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

function simpan(){
    let x = document.getElementById('nama_kk').value;
    let y = document.getElementById('enc_id').value;
    var $nama_kk = document.getElementById('nama_kk').value;
    var $enc_id = document.getElementById('enc_id').value;
    if(x === ""){
        Swal.fire('Ups!', "Nama kk harus diisi!!",'error'); return false;
    }
    $.ajax({
    type: "POST",
    url: "{{ route('kk.simpan') }}",
    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
    data: {
        nama_kk: $nama_kk,
        enc_id: $enc_id,
    },
    beforeSend: function() {
        console.log('load');
        Swal.showLoading();
    //     Swal.fire({
    //     title: "Please Wait",
    //     showConfirmButton: false,
    //     allowOutsideClick: false,
    //     willOpen: () => {
    //         swal.showLoading();
    //     }
    // });
    },
    success: function(html){
        Swal.close()
        if(y === ""){
            Swal.fire('SUCCESS', "Nama kk berhasil ditambahkan",'success'); return false;
        }
        else{
            Swal.fire('SUCCESS', "Nama kk berhasil diperbarui",'success'); return false;
        }

    },
    error: function (result,statusText, xhr) {
        if(y === ""){
            Swal.fire('Ups!', "Data gagal ditambahkan",'error'); return false;
        }
        else{
            Swal.fire('Ups!', "Data gagal diperbarui",'error'); return false;
        }

    }
});
}
</script>
<script>
    function pilihKabkot(){
        var cmbKabkot = $('#cmbKabkot').val();
        $.ajax({
            type: 'POST',
            data: 'cmbKabkot='+cmbKabkot,
            url: '{{route("kk.pilihKabkot")}}/'+cmbKabkot,
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            success: function(msg) {
              //$('#cmbKec').select2();
              $('#cmbKec').html("");
              $('#cmbKec').append($('<option>', {
                  value: 0,
                  text:'Pilih Kecamatan'
              }));
              $(msg).each(function (){
                $('#cmbKec').append($('<option>', {
                  value: this.id,
                  text:this.name
                }));
              })
            }

        });
    }
  </script>
  <script>
    function pilihKec(){
        var cmbKec = $('#cmbKec').val();
        $.ajax({
            type: 'POST',
            data: 'cmbKec='+cmbKec,
            url: '{{route("kk.pilihKec")}}/'+cmbKec,
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            success: function(msg) {
              //$('#cmbKel').select2();
              $('#cmbKel').html("");
              $('#cmbKel').append($('<option>', {
                  value: 0,
                  text:'Pilih Kelurahan'
              }));
              $(msg).each(function (){
                $('#cmbKel').append($('<option>', {
                  value: this.id,
                  text:this.name
                }));
              })
            }

        });
    }
  </script>

  <script>
    function addAnggota(){
        var total = parseInt($('#total').val());
        var totals = total + 1;
        $('#total').val(totals);
        $.ajax({
            type: 'POST',
            data: 'totals='+totals,
            url: '{{route("kk.addAnggota")}}',
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            success: function(msg) {
              $('#ajaxAdd').append(msg);
            }

        });
    }
    function removeAnggota(total){
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data akan terhapus!",

            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya",
            cancelButtonText:"Batal",
            confirmButtonColor: "#ec6c62",
            closeOnConfirm: false
          }).then(function(result){
              if(result.value){
                $("#formkk").find('.data_'+total).remove();
                initHitung();
              }


          });
    }
  </script>

  <script>
      function ketikNama(){
        var nama_kepala_keluarga = $('#nama_kepala_keluarga').val();
        $('#nama_kk_1').val(nama_kepala_keluarga);
      }
  </script>

@endpush



