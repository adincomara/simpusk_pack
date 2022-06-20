@extends('layouts.table')
@section('title', 'Form Pengeluaran Obat')
@section('menu1', 'Master')
@section('menu2', 'Data Pengeluaran Obat')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Periksa Resep Obat</h3>
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
                    <form class="form-horizontal" id="submitData">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">No Rawat</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->no_rawat }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">No Rekam Medis</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->pasien->no_rekamedis }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Tanggal Pendaftaran</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->tanggal_daftar }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->pasien->nama_pasien }}" readonly>
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label class="form-label">Nama Penanggung Jawab</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->pasien->nama_penanggung_jawab }}" readonly>
                            </div> --}}
                            <div class="form-group col-md-2">
                                <label class="form-label">Status Pasien</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->pasien->status_pasien }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Poli</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->poli->nama_poli }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Dokter</label>
                                <input type="text" class="form-control mb-1" value="{{ isset($pendaftaran->nama_penanggung_jawab)? $pendaftaran->nama_penanggung_jawab : ''}}" readonly>
                            </div>
                        </div>
                        {{-- <div class="form-row">

                        </div> --}}
                        <div class="form-row">
                            <div class="form-group col-md-12">
                            @if(isset($pendaftaran->pelayanan_poli->poli_diagnosa))
                              <label class="form-label">Diagnosa</label>
                              <table class="table table-bordered">
                                <tr>
                                    <th>Diagnosa</th>
                                    <th>Nama Diagnosa</th>
                                </tr>

                                  @foreach ($pendaftaran->pelayanan_poli->poli_diagnosa as $item)
                                  <tr>
                                      <td>{{ $item->nama_diagnosa->kode_diagnosa }}</td>
                                      <td>{{ $item->nama_diagnosa->nama_penyakit }}</td>
                                  </tr>
                                  @endforeach
                                @endif
                              </table>
                          </div>
                        </div>
                        <input type="hidden" class="form-control mb-1" name="total_obat" id="total_obat" value="{{ isset($pendaftaran->pelayanan_poli->poli_resep)? count($pendaftaran->pelayanan_poli->poli_resep) : '0' }}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Resep</label>
                                <table class="table table-bordered" id="table_obat">
                                    <thead>
                                    <tr>
                                        {{-- <th>Kode Obat</th> --}}
                                        <th>Nama Obat</th>
                                        {{-- <th>Stok</th> --}}
                                        {{-- <th>Jenis Obat</th>
                                        <th>Satuan</th> --}}
                                        <th>Jumlah</th>
                                        {{-- <th>Cara Pakai</th> --}}
                                        <th>Aturan Pakai</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="obat_tambahan">
                                    @if(isset($pendaftaran->pelayanan_poli->poli_resep))
                                    @foreach ($pendaftaran->pelayanan_poli->poli_resep as $key => $item)
                                    @if(isset($item->obat_id))
                                    <tr>
                                        {{-- <td>{{ $item->obat->kode_obat }}</td> --}}
                                        <input type="hidden" name="" id="index" value="{{ $key+1 }}">
                                        <td width="30%"><select name="obat_{{ $key+1 }}" id="obat_{{ $key+1 }}" class="select2 form-control form-control-sm" disabled>
                                            @foreach($obat as $obt)
                                                <option value="{{ $obt->id }}" {{ ($item->obat->nama_obat == $obt->nama_obat)?'selected' :'' }}>{{ $obt->nama_obat }}</option>
                                            @endforeach

                                        </select></td>
                                        {{-- <td width="30%">
                                            @foreach($batch_obat as $index => $batch) --}}
                                            {{-- {{ $batch }} --}}
                                                {{-- <select name="batch_obat_{{ $key+1 }}_{{ $index+1 }}" id="batch_obat_{{ $key+1 }}_{{ $index+1 }}" class="select2 form-control mb-4"> --}}
                                                {{-- <option value="0">Pilih Stok Obat</option> --}}
                                                {{-- @foreach($batch as $k => $b)
                                                <option value="{{ $b->id }}" {{ ($k == $index)? 'selected' : '' }}>{{ $b->batch_obat }} | {{ $b->tgl_expired_obat }} | {{ $b->stok_obat }}</option> --}}

                                                {{-- @endforeach
                                                </select>
                                                <br>
                                                <br>

                                            @endforeach


                                        </td> --}}
                                        {{-- <td>{{ $item->obat->jenis_obat }}</td>
                                        <td>{{ $item->obat->satuan }}</td> --}}
                                        <td width="100px"><input type='number' min='1' class="form-control form-control-sm" name="jumlah_{{ $key+1 }}" id="" value="{{ $item->jumlah }}" readonly></td>
                                        {{-- <td>{{ $item->cara_pakai }}</td> --}}
                                        <td><input type="text" class="form-control form-control-sm" name="aturan_pakai_obat_{{ $key+1 }}" id="" value="{{ $item->aturan_pakai }}" readonly></td>
                                        <td></td>
                                    </tr>

                                    @endif

                                    @endforeach

                                    @endif
                                    </tbody>

                                </table>

                                <a href="#!" style="float: left" id="tambah_obat" class="btn btn-success lg-btn-flat product-tooltip" title="Tambah Obat"><i class="ion ion-md-add"></i> &nbsp; Tambah Obat</a>
                            </div>
                        </div>

                </div>
            </div>
            @if(session('message'))
            <div class="alert alert-{{session('message')['status']}}">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('message')['desc'] }}
            </div>
            @endif
            <div class="ibox">
                <div class="ibox-title">
                    <h3>{{isset($pengeluaran_obat) ? 'Edit Pengeluaran Obat' : 'Tambah Pengeluaran Obat'}}</h3>
                </div>
                <div class="ibox-content">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pengeluaran_obat)? $enc_id : ''}}">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label class="form-label">No Terima Obat <span>*</span></label>
                            <input type="text" class="form-control mb-1" name="no_terima_obat" id="no_terima_obat" value="{{isset($pengeluaran_obat)? $pengeluaran_obat->no_terima_obat : $noTrans}}" readonly>
                          </div>
                          <div class="form-group col-md-6">
                          <label class="form-label">Tanggal Pengeluaran <span>*</span></label>
                          <input type="text" class="form-control mb-1" name="tgl_serah_obat" id="tgl_serah_obat" value="{{isset($pengeluaran_obat)? $pengeluaran_obat->tgl_serah_obat : date("d-m-Y")}}" readonly>
                          </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                            <label class="form-label">Keterangan </label>
                            <textarea type="text" class="form-control mb-1" name="keterangan" id="keterangan">{{isset($pengeluaran_obat)? $pengeluaran_obat->keterangan : ''}}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <div class="text-right mt-3">
                                <input type="hidden" name="id_pengeluaran" id="id_pengeluaran" value="{{isset($pengeluaran_obat)? $pengeluaran_obat->id_pengeluaran : $noPengeluaran}}"/>
                                <input type="hidden" name="id_pendaftaran" id="id_pendaftaran" value="{{ $pendaftaran->id }}">
                                <input type="hidden" name="no_rawat" value="{{ $pendaftaran->no_rawat }}">
                              <button type="submit" class="btn btn-primary" id="submitData">Simpan</button>&nbsp;
                              <a href="{{route('pengeluaran_obat.index')}}"  class="btn btn-default">Kembali</a>
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
    $('.select2').select2({
            placeholder: "Pilih obat"
    });

});
$(document).on('click', '#tambah_obat', function(){
    var total_obat = $('#total_obat').val();
    var total = 1 + parseInt(total_obat);
    $('#total_obat').val(total);
    $.ajax({
        type: 'POST',
        data: 'total='+total,
        url: '{{route("pengeluaran_obat.addObat")}}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        success: function(msg) {
            // console.log(msg);
          $('#obat_tambahan').append(msg);
        }
    });
  })


    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        kode_obat:{
          required: true
        },
        jumlah:{
          required: true
        },
        dosis_aturan_pengeluaran_obat:{
          required: true
        },
      },
      messages: {
        kode_obat: {
          required: "Kode tidak boleh kosong"
        },
         jumlah: {
          required: "Nama tidak boleh kosong"
        },
         dosis_aturan_pengeluaran_obat: {
          required: "No Telp tidak boleh kosong"
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
        $(document).find(':input').prop('disabled', false);
        SimpanData();
      }
    });
     function SimpanData(){

        var formAdd  = $('#submitData').serialize();
        //console.log(formAdd);
          $('#simpan').addClass("disabled");

           var enc_id          =$('#enc_id').val();

           var id_pengeluaran   =$('#id_pengeluaran').val();
           var id_pendaftaran   =$('#id_pendaftaran').val();
           var no_terima_obat   =$('#no_terima_obat').val();
           var keterangan       =$('#keterangan').val();
           var tgl_serah_obat       =$('#tgl_serah_obat').val();

           var dataFile = new FormData()

           dataFile.append('id_pengeluaran', id_pengeluaran);
           dataFile.append('id_pendaftaran', id_pendaftaran);
           dataFile.append('no_terima_obat', no_terima_obat);
           dataFile.append('enc_id', enc_id);
           dataFile.append('keterangan', keterangan);
           dataFile.append('tgl_serah_obat', tgl_serah_obat);

          $.ajax({
            type: 'POST',
            url : "{{route('pengeluaran_obat.simpan')}}",
            data: formAdd,
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            // processData: false,
            // contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#Loading').modal('show');
            },
            success: function(data){
              //   console.log(data);
              if (data.success) {
                  Swal.fire('Yes',data.message,'success');
                  window.location.href="{{ route('pengeluaran_obat.index') }}";
              } else {
                 Swal.fire('Peringatan',data.message,'info');
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
      function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

      function count(){

  var a = parseInt($("#harga_beli").val());
  var b = parseInt($("#jumlah").val());
  c = a * b;

  if (!isNaN(c)) {
      $("#dosis_aturan_obat").val(c);
  }
  }

  function autonama_pasien(){

      $("#nama_pasien").autocomplete({
          source: "{{ route('pasien.autocomplete') }}",
          minLength: 1,
          autoFill: true,
      });
  }

  function autoobat(){
       //autocomplete
      $("#nama_obat").autocomplete({
          source: "{{ route('obat.autocomplete') }}",
          minLength: 1,
          autoFill: true,
          select: function (event, ui) {
              autofill();
          }
      });
  }

  function autofill(){

      var nama_obat = $("#nama_obat").val();
      $.ajax({
          url: "{{ route('obat.autofill') }}",
          data : "nama_obat="+nama_obat,
          success : function(data){
              if(data != null){
                  var obj = JSON.parse(data);
                  $('#kode_obat').val(obj.kode_obat);
                  $('#jenis_obat').val(obj.jenis_obat);
                  $('#satuan').val(obj.satuan);
                  $('#dosis_aturan_obat').val(obj.dosis_aturan_obat);
              }
          },
          error : function(xhr){
              console.log(xhr.responseText());
          }
      });
  }

</script>
@endpush


