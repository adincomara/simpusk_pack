@extends('layouts.table')
@section('title', 'Periksa Laboratorium')
@section('menu1', 'Pelayanan')
@section('menu2', 'Laboratorium')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>Periksa Laboratorium</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_jabatan" >
                            <tr>
                                <td colspan="6" >Data Pasien</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{$pasien->pasien->nama_pasien}}</td>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{$pasien->pasien->jenis_kelamin}}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{$pasien->pasien->alamat}}</td>
                                <td>Status Pasien</td>
                                <td>:</td>
                                <td>{{$pasien->pasien->status_pasien}}</td>
                            </tr>
                            <tr>
                                <td>No BPJS</td>
                                <td>:</td>
                                <td>{{$pasien->pasien->no_bpjs}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <table id="table1" class="table display table-striped table-bordered">
                            <thead>
                              <tr>
                                <th width='1%'>No</th>
                                <th>Pemeriksaan</th>
                                <th>Satuan</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Nilai</th>
                              </tr>
                            </thead>
                                @php $no = 0 @endphp
                                @foreach($poliLab as $key => $lab)
                                @php $no++ @endphp
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$lab->pelayananlaboratorium->name}}</td>
                                  <td>{{$lab->pelayananlaboratorium->satuan}}</td>
                                  <td>{{$lab->pelayananlaboratorium->min}}</td>
                                  <td>{{$lab->pelayananlaboratorium->max}}</td>
                                  <td>{{$lab->nilai}}</td>
                                </tr>
                                @endforeach
                          </table>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" id="submitData">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>DIAGNOSIS & TINDAKAN</h3>
                </div>
                <div class="ibox-content">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="pelayanan_poli_id" id="pelayanan_poli_id" value="{{ $pasien->pelayanan_poli->id}}">
                        <div class="form-row">
                            {{-- <div class="form-group col-md-6">
                              <label class="form-label">Diagnosis</label>
                              <input type="text" class="form-control form-control-sm mb-1" name="nama_diagnosi_1" id="nama_diagnosi_1">
                            </div>
                            <div class="form-group col-md-5">
                              <label class="form-label">Tindakan</label>
                              <select id="tindakan_1" name="tindakan_1" class="select2 form-control form-control-sm mb-1">
                                  <option value="0" selected disabled>Pilih Tindakan</option>
                                @foreach($Tindakans as $tindakan)
                                      <option value="{{$tindakan->id}}">{{$tindakan->kode_tindakan}} - {{$tindakan->nama_tindakan}}</option>
                                  @endforeach
                              </select>
                            </div> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <th>Diagnosa</th>
                                    {{-- <th>Tindakan</th> --}}
                                    {{-- <th>Action</th> --}}
                                </thead>
                                <tbody id="ajax_diagnosis">
                                    @for($i = 1; $i<=3 ; $i++)
                                    @if($kunjungan['kd_diagnosa'.$i] != null)
                                        <tr>
                                            <td>{{ $kunjungan['kd_diagnosa'.$i] }} | {{ $kunjungan['diagnosa'.$i]->nama_penyakit }}</td>
                                            {{-- <td>null</td> --}}
                                            {{-- <td></td> --}}
                                        </tr>
                                    @endif
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        {{-- <div id="ajax_diagnosis">
                        </div> --}}

                        <input type="hidden" class="form-control  mb-1" name="total_diagnosis" id="total_diagnosis" value="3">
                        {{-- <div class="form-row">
                          <a href="#!" onclick="tambahDiagnosis()" class="btn btn-success btn-lg icon-btn lg-btn-flat product-tooltip" title="Tambah Diagnosis"><i class="fa fa-plus"></i> Tambah Diagnosis</a>
                        </div> --}}

                </div>

            </div>

            <div class="ibox">

                <div class="ibox-title">

                    <h3>RESEP / OBAT</h3>
                </div>

                <div class="ibox-content">


                        <div class="form-row">
                            {{-- <div class="form-group col-md-3">
                              <label class="form-label">Obat / Resep</label>
                              <select id="obat_1" name="obat_1" class="select2 form-control form-control-sm mb-1">
                                  <option value="0" selected disabled>Pilih Obat</option>
                                @foreach($Obats as $obat)
                                      <option value="{{$obat->id}}">{{$obat->kode_obat}} - {{$obat->nama_obat}}</option>
                                  @endforeach
                              </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label class="form-label">Jumlah</label>
                              <input type="number" min="1" class="form-control form-control-sm mb-1" name="jumlah_obat_1" id="jumlah_obat_1">
                            </div>
                            <div class="form-group col-md-3">
                              <label class="form-label">Cara Pakai</label>
                              <input type="text" class="form-control form-control-sm mb-1" name="cara_pakai_obat_1" id="cara_pakai_obat_1">
                            </div>
                            <div class="form-group col-md-3">
                              <label class="form-label">Aturan Pakai</label>
                              <input type="text" class="form-control form-control-sm mb-1" name="aturan_pakai_obat_1" id="aturan_pakai_obat_1" value="3x1, Setelah Makan">
                            </div> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <th>Kode Obat</th>
                                    <th>Jumlah</th>
                                    {{-- <th>Cara Pemakaian</th> --}}
                                    <th>Aturan Pakai</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="ajax_obat">
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" class="form-control mb-1" name="total_obat" id="total_obat" value="1">
                        <div class="form-row">
                          <a href="#!" onclick="tambahObat()" class="btn btn-success btn-lg icon-btn lg-btn-flat product-tooltip" title="Tambah Obat"><i class="fa fa-plus"></i> Tambah Obat</a>
                        </div>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-primary" onclick="SimpanData()">Simpan</button>&nbsp;
                        <a href="{{route('pendaftaran.index')}}"  class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
        </div>



@endsection
@push('scripts')
<script>

    function SimpanData(){
         $('#simpan').addClass("disabled");
         var formAdd  = $('#submitData').serialize();
         //alert(formAdd);
         if($("#submitData").valid()){
         $.ajax({
           type: 'POST',
           url : "{{route('laboratorium.simpanResepLab')}}",
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
 <script>

 function tambahDiagnosis(){

   var total_diagnosis = $('#total_diagnosis').val();
   var total = 1 + parseInt(total_diagnosis);
   $('#total_diagnosis').val(total);

   $.ajax({
       type: 'POST',
       data: 'total='+total,
       url: '{{route("pelayanan_poli.addDiagnosis")}}',
       headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
       success: function(msg) {
         $('#ajax_diagnosis').append(msg);
       }

   });
 }
 </script>

 <script>
 function tambahObat(){
   var total_obat = $('#total_obat').val();
   var total = 1 + parseInt(total_obat);
   $('#total_obat').val(total);
   $.ajax({
       type: 'POST',
       data: 'total='+total,
       url: '{{route("pelayanan_poli.addObat")}}',
       headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
       success: function(msg) {
         $('#ajax_obat').append(msg);
       }

   });
 }
 </script>
@endpush


