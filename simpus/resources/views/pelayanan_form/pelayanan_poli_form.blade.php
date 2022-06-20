@extends('layouts.table')
@section('title', 'Form Pelayanan Poli')
@section('menu1', 'Master')
@section('menu2', 'Data Pelayanan Poli')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Pelayanan Poli</h3>
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
                <form class="form-horizontal" id="submitData">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="enc_id" id="enc_id" value="{{isset($poli)? $enc_id : ''}}">
                <div class="ibox-content">
                    {{-- <div class="card"> --}}
                        <div class="row">

                          <div class="col-md-4">
                            <div class="card-header">DATA PENDAFTARAN</div>
                            <div class="card-body">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">No Rekam Medis <span>*</span></label>
                                  <input type="text" class="form-control mb-1" name="no_rawat" id="no_rawat" readonly=""
                                    value="{{$poli->no_rawat}}">
                                  <input type="hidden" class="form-control mb-1" name="pendaftaran_id" id="pendaftaran_id" readonly=""
                                    value="{{$poli->id}}">
                                  <input type="hidden" class="form-control mb-1" name="poli_id" id="poli_id" readonly=""
                                    value="{{$poli->poliid}}">
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Dokter Penanggung Jawab <span>*</span></label>
                                  {{-- <input type="hidden" name="kdDokter" id="kdDokter" value="{{ $poli->id_dokter }}"> --}}
                                  <select name="kdDokter" id="kdDokter" style="width:100%">
                                      <option value="{{ isset($poli->id_dokter)? $poli->id_dokter: '' }}" {{ isset($poli->id_dokter)? 'selected': '' }}>{{ isset($poli->id_dokter)? $poli->nama_penanggung_jawab: 'Pilih Tenaga Medis' }}</option>
                                  </select>
                                  {{-- <input type="text" class="form-control mb-1" name="nama_dokter" id="nama_dokter"
                                    value="{{$poli->nama_penanggung_jawab}}"> --}}
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Poli Tujuan <span>*</span></label>
                                  <input type="text" class="form-control mb-1" name="nama_poli" id="nama_poli" readonly=""
                                    value="{{$poli->nama_poli}}">
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
                                    <input type="text" class="form-control mb-1" name="nama_pasien" id="nama_pasien"
                                      value="{{isset($poli)? $poli->nama_pasien : ''}}" readonly="">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label class="form-label">Tanggal Lahir <span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="tanggal_lahir" id="tanggal_lahir"
                                      value="{{isset($poli)? $poli->tanggal_lahir : ''}}" readonly="">
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label class="form-label">Status Pasien <span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="status_pasien" id="status_pasien"
                                      value="{{isset($poli)? $poli->status_pasien : ''}}" readonly="">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label class="form-label">No BPJS <span>*</span></label><br />
                                    <span>Isi dengan (-) jika tidak ada No BPJS</span>
                                    <input type="text" class="form-control mb-1" name="no_bpjs" id="no_bpjs"
                                      value="{{isset($poli)? $poli->no_bpjs : ''}}" readonly="">
                                  </div>
                                </div>

                            <div class="bpjs_form" id="bpjs_form" style="display: none">
                                  <div class="form-row">
                                    <div class="form-group col-md-4">
                                      <label class="form-label">Diagnosa 1 <span>*</span></label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="keywoard1" id="keywoard1"
                                          placeholder="masukan kode ....">
                                        <div class="input-group-prepend">
                                          <a class="btn btn-outline-success" id="searchDiagnosa1" onclick="searchdiagnosa(1)" style="border-radius:0 3px 3px 0;">
                                            <i class="fa fa-search"></i>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group col-md my-auto pt-2">
                                      <select name="diagnosa1" class="custom-select" id="diagnosa1" style="width: 100%">
                                        <option value="">Pilih Diagnosa</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-4">
                                      <label class="form-label">Diagnosa 2 <span>(Optional)</span></label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="keywoard2" id="keywoard2"
                                          placeholder="masukan kode ....">
                                        <div class="input-group-prepend">
                                          <a class="btn btn-outline-success" id="searchDiagnosa2" onclick="searchdiagnosa(2)" style="border-radius:0 3px 3px 0;">
                                            <i class="fa fa-search"></i>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group col-md my-auto pt-2">
                                      <select name="diagnosa2" class="custom-select" id="diagnosa2" style="width: 100%">
                                        <option value="">Pilih Diagnosa</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-4">
                                      <label class="form-label">Diagnosa 3 <span>(Optional)</span></label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" name="keywoard3" id="keywoard3"
                                          placeholder="masukan kode ....">
                                        <div class="input-group-prepend">
                                          <a class="btn btn-outline-success" id="searchDiagnosa3" onclick="searchdiagnosa(3)" style="border-radius:0 3px 3px 0;">
                                            <i class="fa fa-search"></i>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group col-md my-auto pt-2">
                                      <select name="diagnosa3" class="custom-select" id="diagnosa3" style="width: 100%">
                                        <option value="">Pilih Diagnosa</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Kesadaran <span>*</span></label>
                                      <select name="kesadaran" class="custom-select" id="kesadaran">
                                        <option value="">Pilih Kesadaran</option>
                                        <option value="01">Compos Mentis</option>
                                        <option value="02">Somolence</option>
                                        <option value="03">Sopor</option>
                                        <option value="04">Coma</option>
                                      </select>
                                    </div>
                                  </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Sistole <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="sistole" id="sistole">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Diastole <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="diastole" id="diastole">
                                    </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tingkat Pernapasan <span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="resp" id="resp">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tekanan Nadi<span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="heart" id="heart">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Berat Badan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="berat" id="berat">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Tinggi Badan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="tinggi" id="tinggi">
                                    </div>
                                  </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Status Pulang <span>*</span></label>
                                    <select name="status_pulang" class="custom-select" id="status_pulang" onchange="rujukform()">
                                      <option value="">Pilih</option>
                                      {{-- <option value="0">Sembuh</option> --}}
                                      <option value="1">Meninggal</option>
                                      <option value="3">Rawat Jalan</option>
                                      <option value="4">Rujuk</option>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Pulang <span>*</span></label>
                                    <input type="date" class="form-control mb-1" name="tglpulang" id="tglpulang">
                                  </div>
                                </div>

                                <div id="form_rujukan">
                                  <div class="form-row">
                                    <div class="form-group col-md-6" id="spesialisshowselect">
                                      <input type="radio" name="kasus" id="spesialis_select">
                                      <label for="spesialis">Spesialis <span>*</span></label>
                                    </div>
                                    <div class="form-group col-md-6" id="khususshowselect">
                                      <input type="radio" name="kasus" id="khusus_select">
                                      <label for="khusus">Khusus <span>*</span></label>
                                    </div>
                                  </div>
                                  <div id="formrujukjenis">
                                    <div class="form-row" id="spesialisshow">
                                      <div class="form-group col-md-6">
                                        <label class="form-label">Spesialis <span>*</span></label>
                                        <select name="spesialis" class="custom-select" id="spesialis">
                                          <option value="">Pilih Spesialis</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label class="form-label">Spesialis <span>*</span></label>
                                        <select name="subspesialis" class="custom-select" id="subspesialis">
                                          <option value="">Pilih SubSpesialis</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label class="form-label">Sarana <span>*</span></label>
                                        <select name="sarana" class="custom-select" id="sarana">
                                          <option value="">Pilih Sarana</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="form-row" id="khususshow">
                                      <div class="form-group col-md-6">
                                        <label class="form-label">Khusus <span>*</span></label>
                                        <select name="khusus" class="custom-select" id="khusus">
                                          <option value="">Pilih Khusus</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6" id="subkhususshow">
                                          <label class="form-label">Sub Khusus <span>*</span></label>
                                          <select name="subkhusus" class="custom-select" id="subkhusus">
                                            <option value="">Pilih Sub Khusus</option>
                                            <option value="3">PENYAKIT DALAM</option>
                                            <option value="8">HEMATOLOGI - ONKOLOGI MEDIK</option>
                                            <option value="26">ANAK</option>
                                            <option value="30">ANAK HEMATOLOGI ONKOLOGI</option>
                                          </select>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-row" id="terapishow">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Terapi <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="terapi" id="terapi">
                                    </div>
                                  </div>
                                </div>
                                {{-- <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label class="form-label">Tenaga Medis <span>*</span></label>
                                    <select name="kdDokter" class="custom-select" id="kdDokter">
                                      <option value="">Pilih Tenaga medis</option>
                                    </select>
                                  </div>
                                </div> --}}

                                <div id="form_rujukan_detail">
                                  <div class="form-row" id="keluhanshow">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Keluhan <span></span></label>
                                      <textarea class="form-control mb-1" rows="5" name="keluhan" id="keluhan"></textarea>
                                    </div>
                                  </div>
                                  <div class="form-row" id="tglrujukshow">
                                    <div class="form-group col-md-8">
                                      <label class="form-label">Tanggal Rujuk <span>*</span></label>
                                      <input type="date" class="form-control mb-1" name="tglrujuk" id="tglrujuk">
                                    </div>
                                    <div class="form-group col-md-4 my-auto pt-1">
                                      <a class="btn btn-outline-success" id="searchRujuk">
                                        <i class="fa fa-search"></i>
                                        Cari Rujukan
                                      </a>
                                    </div>
                                  </div>
                                  <div class="form-row" id="tglrujuktableshow">
                                    <div class="col-md-12 pt-2 pb-2">
                                      <div class="card">
                                        <table id="table1" class="table table-striped table-bordered">
                                          <thead>
                                            <tr>
                                              <th>FasKes</th>
                                              <th>Kelas</th>
                                              <th>Kantor Cabang</th>
                                              <th>Alamat</th>
                                              <th>Telp</th>
                                              <th>Jarak</th>
                                              <th>Total Rujukan</th>
                                              <th>Pilih</th>
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <select name="tacc" class="custom-select" id="taccselect" onchange="taccform()">
                                        <option value="">Pilih TACC</option>
                                        <option value="-1">Tanpa TACC</option>
                                        <option value="0">Dengan TACC</option>
                                      </select>
                                    </div>
                                  {{-- </div> --}}
                                    <div class="form-group col-md-6" id="kondisishow">
                                      <select name="taccselected" class="custom-select" id="taccselected" onchange="taccalasan()">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="1">Time</option>
                                        <option value="2">Age</option>
                                        <option value="3">Complication</option>
                                        <option value="4">Comorbidity</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row" id="kondisitime">
                                    <div class="form-group col-md-6">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <select name="tacc_time" class="custom-select" id="tacc_time">
                                        <option value="">Pilih Waktu</option>
                                        <option value="< 3 Hari">
                                          < 3 Hari</option> <option value=">= 3 - 7 Hari">>= 3 - 7 Hari
                                        </option>
                                        <option value=">= 7 Hari">>= 7 Hari</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row" id="kondisiage">
                                    <div class="form-group col-md-6">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <select name="tacc_age" class="custom-select" id="tacc_age">
                                        <option value="">Pilih Umur</option>
                                        <option value="< 1 Bulan">
                                          < 1 Bulan</option> <option value=">= 1 Bulan s/d 12 Bulan">>= 1 Bulan s/d 12 Bulan
                                        </option>
                                        <option value=">= 1 Tahun s/d < 5 Tahun">>= 1 Tahun s/d < 5 Tahun</option> <option
                                            value=">= 5 Tahun s/d < 12 Tahun">>= 5 Tahun s/d < 12 Tahun</option> <option
                                              value=">= 12 Tahun s/d < 55 Tahun">>= 12 Tahun s/d < 55 Tahun</option> <option
                                                value=">= 55 Tahun">>= 55 Tahun</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row" id="kondisicomor">
                                    <div class="form-group col-md-6">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <select name="tacc_comorbidity" class="custom-select" id="tacc_comorbidity">
                                        <option value="">Pilih Comorbidity</option>
                                        <option value="< 3 Hari">
                                          < 3 Hari</option> <option value=">= 3 - 7 Hari">>= 3 - 7 Hari
                                        </option>
                                        <option value=">= 7 Hari">>= 7 Hari</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="form-row" id="catatanshow">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Catatan <span></span></label>
                                  <textarea class="form-control mb-1" rows="5" name="catatan" id="catatan"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Penunjang <span>*</span></label>
                                  <select id="penunjang" name="penunjang" class="select2 form-control mb-1"
                                    onchange="pilihPenunjang()">
                                    <option value="Y">Ya</option>
                                    <option value="T">Tidak</option>

                                  </select>
                                </div>
                              </div>
                              <div class="form-row" id="tmpPemeriksaanLab">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Pemeriksaan Laboratorium</label>
                                  @foreach($Lab as $lab)
                                  <div class="checkbox col-md-4">
                                    <label>
                                      <input type="checkbox" id="cek_lab_{{$lab->id}}" onclick="pilih_pemeriksaan_lab({{$lab->id}})">
                                      {{$lab->name}}
                                    </label>
                                    <input type="hidden" id="lab_pemeriksaan_{{$lab->id}}" name="lab_pemeriksaan_{{$lab->id}}"
                                      value="0">
                                  </div>
                                  @endforeach
                                </div>
                              </div>
                          </div>
                        </div>
                        {{-- <div class="col-md-12" id="tmpDiagnosis" style="display:none">
                          <div class="card-header">
                            <center>
                              <h3>DIAGNOSIS & TINDAKAN</h3>
                            </center>
                          </div>
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" class="form-control mb-1" name="total_diagnosa" id="total_diagnosa" value="0">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <label class="form-label">Resep</label>
                                      </div>
                                      <div class="col-md-6 mb-2">
                                          <a href="#!" style="float: right" id="tambah_diagnosis" onclick="tambahDiagnosis()" class="btn btn-success lg-btn-flat product-tooltip" title="Tambah Obat"><i class="ion ion-md-add"></i> &nbsp; Tambah Diagnosa</a>
                                      </div>
                                  </div>
                                  <table class="table table-bordered">
                                      <tr>
                                          <th>Diagnosa</th>
                                          <th>Tindakan</th>
                                          <th>Action</th>
                                      </tr>
                                      <tbody id="ajax_tambahan">
                                      </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>

                        </div> --}}
                        <div class="col-md-12" id="tmpResep" style="display:none">
                          <div class="card-header">
                            <center>
                              <h3>RESEP / OBAT</h3>
                            </center>
                          </div>
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" class="form-control mb-1" name="total_obat" id="total_obat" value="0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Resep</label>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <a href="#!" style="float: right" id="tambah_obat" class="btn btn-success lg-btn-flat product-tooltip" title="Tambah Obat"><i class="ion ion-md-add"></i> &nbsp; Tambah Obat</a>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Kode Obat</th>
                                        <th>Jumlah</th>
                                        {{-- <th>Cara Pemakaian</th> --}}
                                        <th>Aturan Pakai</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="obat_tambahan">
                                    </tbody>
                                </table>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <div class="text-right mt-3">
                                  <button type="submit" class="btn btn-primary" id="submitData">Simpan</button>&nbsp;
                                  <a href="{{route('pendaftaran.index')}}" class="btn btn-default">Kembali</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                    {{-- </div> --}}
                </div>
            </div>



        </div>


@endsection
@push('scripts')
<script type="text/javascript">
    $('#diagnosa1, #diagnosa2, #diagnosa3').select2({
        placeholder: 'Pilih Diagnosa',
        ajax: {
            url: "{{ route('pelayanan_poli.searchDiagnosa') }}",
            dataType: 'JSON',
            data: function(params) {
            return {
                search: params.term
            }
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function(index, item){
                    results.push({
                        id: item.kode_diagnosa,
                        text : item.kode_diagnosa+' | '+item.nama_penyakit,
                    });
                });
                return{
                    results: results
                };
            }
        }
    });
    var tamp_nokunjungan = '0';
      $(document).ready(function(){

        // getstatuspulang()
        getdokter()
        $('#bpjs_form').show();
          $('#form_rujukan').hide();
          $('#kondisishow').hide()
          $('#kondisitime').hide()
          $('#kondisiage').hide()
          $('#kondisicomor').hide()
          $('#form_rujukan').hide();
          $('#form_rujukan_detail').hide();
          $('#spesialisshow').hide();
          $('#khusushow').hide();
          $('#subkhusushow').hide();
        var nobpjs = $('#status_pasien').val()
        // if( nobpjs == "BPJS"){
        //   $('#bpjs_form').show();
        //   $('#form_rujukan').hide();
        //   $('#kondisishow').hide()
        //   $('#kondisitime').hide()
        //   $('#kondisiage').hide()
        //   $('#kondisicomor').hide()
        //   $('#form_rujukan').hide();
        //   $('#form_rujukan_detail').hide();
        //   $('#spesialisshow').hide();
        //   $('#khusushow').hide();
        //   $('#subkhusushow').hide();
        // }else{
        //   $('#bpjs_form').hide();
        //   $('#form_rujukan').hide();
        //   $('#kondisishow').hide()
        //   $('#kondisitime').hide()
        //   $('#kondisiage').hide()
        //   $('#kondisicomor').hide()
        //   $('#form_rujukan').hide();
        //   $('#form_rujukan_detail').hide();
        //   $('#spesialisshow').hide();
        //   $('#khusushow').hide();
        //   $('#subkhusushow').hide();
        // }
      })

      // var bpjs = $('#nama_penanggung_jawab').val()
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

          SimpanData()
          // if(bpjs != 'BPJS'){
          //   SimpanData()
          // }else{

          //   // SimpanData()
          // }
        //   cek_bpjs();

        }
      });
      function cek_bpjs(){
          SimpanData();
        //   var status_pasien = $('#status_pasien').val();
        //   if(status_pasien == 'BPJS'){
        //       SimpanBpjs();
        //   }else{
        //       SimpanData();
        //   }
      }



       function SimpanData(){
            $('#simpan').addClass("disabled");
            var formAdd  = $('#submitData').serialize();
            //alert(formAdd);
            if($("#submitData").valid()){
            $.ajax({
              type: 'POST',
              url : "{{route('pelayanan_poli.simpan')}}",
              data: $('#submitData').serialize(),
              headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
              dataType: "json",
              beforeSend: function(){
                  Swal.showLoading();
              },
              success: function(data){
                console.log(data);
                if (data.success == true) {
                    Swal.hideLoading();
                    Swal.close();
                    if(data.print == true){

                        if(data.status_pasien == "BPJS"){
                            var link = "{{ route('report.printRujukan',[null]) }}/"+data.nokunjungan;
                        }else{
                            var link = "{{ route('report.printRujukanUmum',[null]) }}/"+data.id_pendaftaran;
                        }
                        window.open(link, "_blank");
                        window.location.href="{{ route('pelayanan_poli.index') }}";
                    }else{
                        Swal.fire('info',data.message,'success');
                        window.location.href="{{ route('pelayanan_poli.index') }}";
                    }
                } else {
                   Swal.fire('Ups',data.message,'info');
                }

              },
              complete: function () {
                 $('#simpan').removeClass("disabled");
                //  $('#Loading').modal('hide');
                // Swal.hideLoading();
                // Swal.close();
              },
              error: function(data){
                   $('#simpan').removeClass("disabled");
                   $('#Loading').modal('hide');
                  // console.log(data);
              }
            });
          }
        }

        // function SimpanBpjs(){
        //   var nama = $('nama_pasien').val();
        //   var nokunjungan = $('#no_kunjungan').val();
        //   var nokartu = $('#no_bpjs').val();
        //   var tglstring = $('#no_rawat').val();
        //   var tglraw = tglstring.slice(0,10);
        //   var tgldaftar = tglraw.split('-').reverse().join('-')
        //   var kdpoli = ("00" + $('#poli_id').val())
        //   var keluhan = $('#keluhan').val()
        //   var kdsadar = $('#kesadaran').val()
        //   var sistol = $('#sistole').val()
        //   var diastol = $('#diastole').val()
        //   var sistol = $('#sistole').val()
        //   var berat = $('#berat').val()
        //   var tinggi = $('#tinggi').val()
        //   var resp = $('#resp').val()
        //   var heart = $('#heart').val()
        //   var terapi = $('#terapi').val()
        //   var stspulang = $('#status_pulang').val()
        //   var date = $('#tglpulang').val()
        //   var tglpulang = date.split("-").reverse().join("-")
        //   var kddokter = $('#kdDokter').val()
        //   var diagnosa1 = $('#diagnosa1').val()
        //   var diagnosa2 = $('#diagnosa2').val()
        //   var diagnosa3 = $('#diagnosa3').val()
        //   var daterujuk = $('#tglrujuk').val()
        //   var tglrujuk = daterujuk.split("-").reverse().join("-")
        //   var provider = $("input[type='radio'][name=provider]:checked").val()
        //   var spesialis = $('#spesialis').val()
        //   var subspesialis = $('#subspesialis').val()
        //   var sarana = $('#sarana').val()
        //   var khusus = $('#khusus').val()
        //   var subkhusus = $('#subkhusus').val()
        //   var catatan = $('#note').val()
        //   var tacctime = $('#tacc_time').val()
        //   var taccage = $('#tacc_age').val()
        //   var tacccomorbidity = $('#tacc_comorbidity').val()

        //   if($('#taccselect').val() != "-1"){
        //     var kdtacc = $('#taccselected').val()
        //   }else{
        //     var kdtacc = $('#taccselect').val()
        //   }

        //   if(tacctime != ""){
        //     var alasantacc = tacctime
        //   }else if(taccage != ""){
        //     var alasantacc = taccage
        //   }else if(tacccomorbidity != "") {
        //     var alasantacc = tacccomorbidity
        //   }

        //   if(kdtacc == 3){
        //     var alasantacc = $('#keywoard').val()+' - '+ $('#diagnosa option:selected').text()
        //   }

        //   $.ajax({
        //     type: 'POST',
        //     headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        //     data:{
        //       'no_kunjungan' : nokunjungan,
        //       'nokartu': nokartu,
        //       'tgldaftar': tgldaftar,
        //       'kdpoli': kdpoli,
        //       'keluhan': keluhan,
        //       'kesadaran': kdsadar,
        //       'sistole': sistol,
        //       'diastole': diastol,
        //       'berat': berat,
        //       'tinggi': tinggi,
        //       'respiration': resp,
        //       'heart': heart,
        //       'terapi': terapi,
        //       'statuspulang': stspulang,
        //       'tglpulang': tglpulang,
        //       'kddokter': kddokter,
        //       'kddiagnosa1': diagnosa1,
        //       'kddiagnosa2': diagnosa2,
        //       'kddiagnosa3': diagnosa3,
        //       'tglrujuk': tglrujuk,
        //       'provider': provider,
        //       'spesialis': spesialis,
        //       'subspesialis': subspesialis,
        //       'sarana': sarana,
        //       'kdkhusus': khusus,
        //       'subkhusus': subkhusus,
        //       'catatan': catatan,
        //       'kdTacc': kdtacc,
        //       'alasanTacc': alasantacc
        //     },
        //     url: '{{ route("pelayanan_poli.daftarkunjungan") }}',
        //     beforeSend: function(){
        //         Swal.showLoading();
        //     },
        //     success: function(response){
        //        console.log(response.datas)
        //       if(response.datas.metaData.code != 201){
        //         Swal.fire(response.datas.response[0].field,response.datas.response[0].message,'info');
        //       }else{
        //           this.tamp_nokunjungan = response.datas.response.message;
        //           SimpanData();
        //       }
        //     },
        //     complete: function(){
        //       Swal.hideLoading();
        //       Swal.close();
        //     },
        //   })
        // }

        function simpanbpjs(nokunjungan){
          var nama = $('#nama_pasien').val();
          var nokartu = $('#no_bpjs').val();
          var tglstring = $('#no_rawat').val();
          var tglraw = tglstring.slice(0,10);
          var tgldaftar = tglraw.split('-').reverse().join('-');
          $.ajax({
            type: 'POST',
            data:{
              'nokunjungan': nokunjungan,
              'nokartu': nokartu,
              'nama': nama,
              'tgldaftar': tgldaftar
            },
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            url: "{{ route('pelayanan_poli.simpanbpjsdata') }}",
            success: function(response){
              console.log(response)
            }
          })
        }

    //   function getstatuspulang(){
    //     $.ajax({
    //       type: 'POST',
    //       url: '{{route("pelayanan_poli.statuspulang")}}',
    //       headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
    //       success: function(response) {
    //         var dokter = response.datas.response.list
    //         // $('#kdDokter').find('option').remove().end();
    //         // $('#kdDokter').append('<option value="">Pilih Status Pulang</option>');
    //         if(response.datas.metaData.message != "OK"){
    //           Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
    //         }else{
    //           // for(var i = 0 ; i < dokter.length ; i++){
    //           //   // $('#kdDokter').append('<option value="'+dokter[i].kdDokter+'">' + dokter[i].nmDokter + '</option>');
    //           // }
    //         }
    //       }
    //     });
    //   }

      function getdokter(){
          var id_dokter = $('#kdDokter').val();

        $.ajax({
          type: 'POST',
          url: '{{route("pelayanan_poli.dokterbpjs")}}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          beforeSend: function(){
            Swal.showLoading();
          },
          success: function(response) {
              Swal.hideLoading();
            if(response.success == true){

                var dokter = response.datas.response.list
                $('#kdDokter').find('option').remove().end();
                $('#kdDokter').append('<option value="">Pilih Tenaga medis</option>');
                if(response.datas.metaData.message != "OK"){
                    Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
                }else{
                    Swal.close();
                    for(var i = 0 ; i < dokter.length ; i++){
                        if(id_dokter == dokter[i].kdDokter){
                            console.log(id_dokter);
                            $('#kdDokter').append('<option value="'+dokter[i].kdDokter+'" selected>' + dokter[i].nmDokter + '</option>');
                        }else{
                            $('#kdDokter').append('<option value="'+dokter[i].kdDokter+'">' + dokter[i].nmDokter + '</option>');
                        }

                    }
                    $('#kdDokter').select2()

                }
            }else{
                Swal.fire('UPS','Data Tenaga Medis Tidak Ditemukan','info');
            }

          },
          complete: function(){
              Swal.hideLoading();
          },
        });
      }

    $('#spesialis_select').click(function(){
      $('#khususshow').hide();
      $('#spesialisshow').show();
      $('#khusus').val('');
      $('#subkhusus').val('');
      // getdokter()
      $.ajax({
        type: 'POST',
        url: '{{route("pelayanan_poli.spesialisbpjs")}}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function(response) {
          // $('.option').remove();
          var spesialis = response.datas.response.list
          if(response.datas.metaData.message != "OK"){
            Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
          }else{
            for(var i = 0 ; i < spesialis.length ; i++){
              $('#spesialis').append('<option value="'+spesialis[i].kdSpesialis+'">' + spesialis[i].nmSpesialis + '</option>');
            }
          }
        },
        complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
      });
      $.ajax({
        type: 'POST',
        url: '{{route("pelayanan_poli.saranabpjs")}}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function(response) {
          var sarana = response.datas.response.list
          var spesialis = response.datas.response.list
          if(response.datas.metaData.message != "OK"){
            Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
          }else{
            for(var i = 0 ; i < sarana.length ; i++){
              $('#sarana').append('<option value="'+sarana[i].kdSarana+'">' + sarana[i].nmSarana + '</option>');
            }
          }
        },
        complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
      });
    })

    $('#spesialis').change(function(){
      $('#subspesialis').find('option').remove().end();
      $('#subspesialis').append('<option value="">Pilih SubSpesialis</option>');
      var id_spesialis = $('#spesialis').val();
      $.ajax({
        type: 'POST',
        url: '{{route("pelayanan_poli.subspesialisbpjs")}}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        data: {
          'spesialis' : id_spesialis
        },
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function(response) {
          var spesialis = response.datas.response.list
          if(response.datas.metaData.message != "OK"){
            Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
          }else if(spesialis != null){
            for(var i = 0 ; i < spesialis.length ; i++){
              $('#subspesialis').append('<option value="'+spesialis[i].kdSubSpesialis+'">' + spesialis[i].nmSubSpesialis + '</option>');
            }
          }else{
            Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
          }
        },
        complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
      });
    })

    $('#khusus_select').click(function(){
      $('#khususshow').show();
      $('#subkhususshow').hide();
      $('#spesialisshow').hide();
      getdokter()
      $.ajax({
        type: 'POST',
        url: '{{route("pelayanan_poli.khususbpjs")}}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function(response) {
          // console.log(response.datas.metaData)
          var khusus = response.datas.response.list
            for(var i = 0 ; i < khusus.length ; i++){
              $('#khusus').append('<option value="'+khusus[i].kdKhusus+'">' + khusus[i].nmKhusus + '</option>');
            }
          // if(response.datas.metaData.message != "OK"){
          //   console.log(response.datas.metaData)
          //   Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
          // }else if(response.datas.metaData.code == 200){

          // }
        },
        complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
      });
    })

    $('#khusus').click(function(){
      var khusus = $('#khusus').val();
      if(khusus == 'THA' || khusus == 'HEM'){
        $('#subkhususshow').show();
      }else{
        $('#subkhususshow').hide();
      }
    })

    $('#searchRujuk').click(function(){
        $('#table1').find('tbody').remove().end();
      var nokartu = $('#no_bpjs').val();
      var spesialis = $('#spesialis').val()
      var kdsubspesialis = $('#subspesialis').val();
      var kdsarana = $('#sarana').val();
      var kdkhusus = $('#khusus').val();
      var kdsubkhusus = $('#subkhusus').val();
      var date = $('#tglrujuk').val();
      var tglrujuk = date.split("-").reverse().join("-");
      var index = 0;
      var sarana = 0
      // console.log(kdkhusus)
      if(kdsarana == ""){
        sarana = 0
      }else{
        sarana = kdsarana
      }
      if(kdkhusus === ""){
        $.ajax({
          type: 'POST',
          data: {
              'tglrujuk': tglrujuk,
              'kdspesialis': spesialis,
              'kdsubspesialis': kdsubspesialis,
              'kdsarana': sarana
          },
          url: '{{ route("pelayanan_poli.rujukspesialisbpjs") }}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          beforeSend: function(){
                Swal.showLoading();
                // console.log('tes');
            },
          success: function(response){
            // Swal.hideLoading();
            console.log(response);
            if(response.datas){
                $('#table1').find('tbody').remove().end();
                var table = response.datas.response.list
                var error = response.datas.response
                if(response.datas.metaData.code == 428){
                    Swal.hideLoading();
                Swal.fire('UPS',error,'info');
                }else if(response.datas.metaData.code ==  412){
                for (let index = 0; index < error.length; index++) {
                    Swal.hideLoading();
                    Swal.fire(error[index].field,error[index].message,'info');
                }
                }else if(response.datas.metaData.code == 200){
                    Swal.hideLoading();
                    Swal.close();
                for(var i=0;i<table.length;i++){
                var datatable = '<tbody>' +
                                    '<tr>' +
                                    // '<td>'++'</td>' +
                                    '<td>'+table[i].nmppk +'('+table[i].kdppk+')'+'</td>' +
                                    '<td>'+table[i].kelas+'</td>'+
                                    '<td>'+table[i].nmkc+'</td>'+
                                    '<td>'+table[i].alamatPpk+'</td>'+
                                    '<td>'+table[i].telpPpk+'</td>'+
                                    '<td>'+table[i].distance+'</td>'+
                                    '<td>'+table[i].jmlRujuk+'</td>'+
                                    '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'"></td>'+
                                    '</tr>' +
                                '</tbody>'
                    $('#table1').append(datatable);
                }
                }else{
                    Swal.hideLoading();
                    Swal.fire('UPS','Data tidak ditemukan','info');
                }
            }else{
                Swal.hideLoading();
                Swal.fire('UPS','Data tidak ditemukan','info');
            }


          },
          complete: function(){
            Swal.hideLoading();
            // Swal.close();
        },
        });
      }else if(kdkhusus == "THA" || kdkhusus == "HEM"){
        $.ajax({
          type: 'POST',
          data: {
              'tglrujuk': tglrujuk,
              'kdkhusus': kdkhusus,
              'subkhusus': kdsubkhusus,
              'nokartu': nokartu
          },
          url: '{{ route("pelayanan_poli.rujuksubkhususbpjs") }}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          beforeSend: function(){
            Swal.showLoading();
        },
          success: function(response){
            $('#table1').find('tbody').remove().end();
            // console.log(response)
            var table = response.datas.response.list
            var error = response.datas.response
            if(response.datas.metaData.code == 428){
              Swal.fire('UPS',error,'info');
            }else if(response.datas.metaData.code ==  412){
              for (let index = 0; index < error.length; index++) {
                Swal.fire(error[index].field,error[index].message,'info');
              }
            }else if(response.datas.metaData.code == 200){
              for(var i=0;i<table.length;i++){
              var datatable = '<tbody>' +
                                '<tr>' +
                                  // '<td>'++'</td>' +
                                  '<td>'+table[i].nmppk +'('+table[i].kdppk+')'+'</td>' +
                                  '<td>'+table[i].kelas+'</td>'+
                                  '<td>'+table[i].nmkc+'</td>'+
                                  '<td>'+table[i].alamatPpk+'</td>'+
                                  '<td>'+table[i].telpPpk+'</td>'+
                                  '<td>'+table[i].distance+'</td>'+
                                  '<td>'+table[i].jmlRujuk+'</td>'+
                                  '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'"></td>'+
                                '</tr>' +
                              '</tbody>'
                $('#table1').append(datatable);
              }
            }
          },
          complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
        });
      }else{
        $.ajax({
          type: 'POST',
          data: {
              'kdkhusus': kdkhusus,
              'nokartu': nokartu,
              'tglrujuk': tglrujuk,
          },
          url: '{{ route("pelayanan_poli.rujukkhususbpjs") }}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          beforeSend: function(){
            Swal.showLoading();
        },
          success: function(response){
            // console.log(response)
            $('#table1').find('tbody').remove().end();
            var table = response.datas.response.list
            var error = response.datas.response
            if(response.datas.metaData.code == 428){
              Swal.fire('UPS',error,'info');
            }else if(response.datas.metaData.code ==  412){
              for (let index = 0; index < error.length; index++) {
                Swal.fire(error[index].field,error[index].message,'info');
              }
            }else if(response.datas.metaData.code == 200){
              for(var i=0;i<table.length;i++){
                var datatable = '<tbody>' +
                                '<tr>' +
                                  // '<td>'++'</td>' +
                                  '<td>'+table[i].nmppk +'('+table[i].kdppk+')'+'</td>' +
                                  '<td>'+table[i].kelas+'</td>'+
                                  '<td>'+table[i].nmkc+'</td>'+
                                  '<td>'+table[i].alamatPpk+'</td>'+
                                  '<td>'+table[i].telpPpk+'</td>'+
                                  '<td>'+table[i].distance+'</td>'+
                                  '<td>'+table[i].jmlRujuk+'</td>'+
                                  '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'"></td>'+
                                '</tr>' +
                              '</tbody>'
                $('#table1').append(datatable);
              }
            }
          },
          complete: function(){
            Swal.hideLoading();
            Swal.close();
        },
        });
      }
    })
    function searchdiagnosa(index){
        var keywoard = $('#keywoard'+index).val();
        $.ajax({
            type: 'POST',
            data: {
            'keywoard': keywoard
            },
            url: '{{ route("pelayanan_poli.diagnosabpjs") }}',
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            beforeSend: function(){
                Swal.showLoading();
            },
            success: function(response){
                console.log(response);
                if(response.success == true){

                            $('#diagnosa'+index).find('option').remove().end();
                    var diagnosa = response.datas.response.list
                    var error = response.datas.response
                    if(diagnosa != null){
                        for(var i = 0 ; i < diagnosa.length ; i++){
                        if(diagnosa[i].nonSpesialis != true){
                            var spesialisDiagnosa = 'UMUM'
                        }else{
                            var spesialisDiagnosa = 'SPESIALIS'
                        }
                        $('#diagnosa'+index).append('<option value="'+diagnosa[i].kdDiag+'">' + '<p>'+diagnosa[i].kdDiag+' | '+diagnosa[i].nmDiag+'</p></option>');
                        }
                        Swal.close();
                    }else{
                        Swal.fire('UPS',error,'info');
                    }
                }else{
                    Swal.fire('UPS',response.message,'info');
                }

            },
            complete: function(){
                Swal.hideLoading();

            },
        })
    }
    $('#searchDiagnosa').click(function(){
      var keywoard = $('#keywoard').val();
      $.ajax({
        type: 'POST',
        data: {
          'keywoard': keywoard
        },
        url: '{{ route("pelayanan_poli.diagnosabpjs") }}',
        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
        beforeSend: function(){
            Swal.showLoading();
        },
        success: function(response){
            console.log(response);
            if(response.success == true){

                        $('#diagnosa').find('option').remove().end();
                  var diagnosa = response.datas.response.list
                  var error = response.datas.response
                  if(diagnosa != null){
                    for(var i = 0 ; i < diagnosa.length ; i++){
                      if(diagnosa[i].nonSpesialis != true){
                        var spesialisDiagnosa = 'UMUM'
                      }else{
                        var spesialisDiagnosa = 'SPESIALIS'
                      }
                      $('#diagnosa').append('<option value="'+diagnosa[i].kdDiag+'">' + '<p>'+diagnosa[i].kdDiag+' | '+diagnosa[i].nmDiag+'</p></option>');
                    }
                    Swal.close();
                  }else{
                    Swal.fire('UPS',error,'info');
                  }
            }else{
                Swal.fire('UPS',response.message,'info');
            }

        },
        complete: function(){
            Swal.hideLoading();

        },
      })
    })

    function tambahDiagnosis(){
      var total_diagnosis = $('#total_diagnosa').val();
      var total = 1 + parseInt(total_diagnosis);
      $('#total_diagnosa').val(total);
      $.ajax({
          type: 'POST',
          data: 'total='+total,
          url: '{{route("pelayanan_poli.addDiagnosis")}}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          success: function(msg) {
            $('#ajax_tambahan').append(msg);
          }
      });
    }

    $(document).on('click', '#tambah_obat', function(){
      var total_obat = $('#total_obat').val();
      var total = 1 + parseInt(total_obat);
      $('#total_obat').val(total);
      $.ajax({
          type: 'POST',
          data: 'total='+total,
          url: '{{route("pelayanan_poli.addObat")}}',
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          success: function(msg) {
            $('#obat_tambahan').append(msg);
          }
      });
    })

      function pilihPenunjang(){
        var penunjang = $('#penunjang').val();
        if(penunjang == "Y"){
          $('#tmpDiagnosis').hide();
          $('#tmpResep').hide();
        //   $('.select2').select2();
          $('#tmpPemeriksaanLab').show();
        }else{
          $('#tmpDiagnosis').show();
          $('#tmpResep').show();
        //   $('.select2').select2();
          $('#tmpPemeriksaanLab').hide();
        }
      }


      function rujukform(){
        var statuspulang = $('#status_pulang').val()
        if(statuspulang == 4){
          $('#form_rujukan').show();
          $('#form_rujukan_detail').show();
          $('#spesialisshow').hide();
          $('#khususshow').hide();
        }else{
          $('#form_rujukan').hide();
          $('#form_rujukan_detail').hide();
          $('#spesialisshow').hide();
          $('#khusushow').hide();
        }
      }

      function taccform(){
        var codetacc = $('#taccselect').val()
        if(codetacc == "0"){
          $('#kondisishow').show()
          $('#kondisitime').hide()
          $('#kondisiage').hide()
          $('#kondisicomor').hide()
        }else{
          $('#kondisishow').hide()
          $('#kondisitime').hide()
          $('#kondisiage').hide()
          $('#kondisicomor').hide()
        }
      }

      function taccalasan(){
        var codetacc = $('#taccselected').val()
        // console.log(codetacc)
        if(codetacc == "1"){
          $('#kondisitime').show()
          $('#kondisiage').hide()
          $('#kondisicomor').hide()
        }else if(codetacc == "2"){
          $('#kondisitime').hide()
          $('#kondisiage').show()
          $('#kondisicomor').hide()
        }else if(codetacc == "4"){
          $('#kondisitime').hide()
          $('#kondisiage').hide()
          $('#kondisicomor').show()
        }else{
          $('#kondisitime').hide()
          $('#kondisiage').hide()
          $('#kondisicomor').hide()
        }
      }

      function pilih_pemeriksaan_lab(id){
       var checkBox = document.getElementById("cek_lab_"+id);
       var lab_pemeriksaan = $('#lab_pemeriksaan_'+id).val();
        if (checkBox.checked == true){
          $('#lab_pemeriksaan_'+id).val(1);
        } else {
          $('#lab_pemeriksaan_'+id).val(0);
        }
    }

</script>
@endpush


