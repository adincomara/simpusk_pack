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
                                  <select name="kdDokter" id="kdDokter" style="width:100%">
                                      <option value="{{ isset($poli->id_dokter)? $poli->id_dokter: '' }}" {{ isset($poli->id_dokter)? 'selected': '' }}>{{ isset($poli->id_dokter)? $poli->nama_penanggung_jawab: 'Pilih Tenaga Medis' }}</option>
                                  </select>
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

                            <div class="bpjs_form" id="bpjs_form" style="display: block">
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
                                        @if(isset($kunjungan->kd_diagnosa1))
                                        <option value="{{ $kunjungan->kd_diagnosa1 }}">{{ $kunjungan->kd_diagnosa1 }} | {{ $kunjungan->diagnosa1->nama_penyakit }}</option>
                                        @endif
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
                                        @if(isset($kunjungan->kd_diagnosa2))
                                        <option value="{{ $kunjungan->kd_diagnosa2 }}">{{ $kunjungan->kd_diagnosa2 }} | {{ $kunjungan->diagnosa2->nama_penyakit }}</option>
                                        @endif
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
                                        @if(isset($kunjungan->kd_diagnosa3))
                                        <option value="{{ $kunjungan->kd_diagnosa3 }}">{{ $kunjungan->kd_diagnosa3 }} | {{ $kunjungan->diagnosa3->nama_penyakit }}</option>
                                        @endif
                                        <option value="">Pilih Diagnosa</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Kesadaran <span>*</span></label>
                                      <select name="kesadaran" class="custom-select" id="kesadaran">
                                        <option value="">Pilih Kesadaran</option>
                                        @foreach ($kesadaran as $sadar)
                                        <option value="{{ $sadar->kdSadar }}" {{ (isset($kunjungan) && $kunjungan->code_sadar == $sadar->kdSadar)? 'selected' : '' }}>{{ $sadar->nmSadar }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Lingkar Perut <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="lingkar_perut" id="lingkar_perut" value="{{ isset($kunjungan->lingkar_perut)? $kunjungan->lingkar_perut : '' }}">
                                    </div>
                                  </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Sistole <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="sistole" id="sistole" value="{{ isset($kunjungan->sistole)? $kunjungan->sistole : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Diastole <span>*</span></label>
                                        <input type="text" class="form-control mb-1" name="diastole" id="diastole" value="{{ isset($kunjungan->diastole)? $kunjungan->diastole : '' }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tingkat Pernapasan <span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="resp" id="resp" value="{{ isset($kunjungan->resprate)? $kunjungan->resprate : '' }}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tekanan Nadi<span>*</span></label>
                                    <input type="text" class="form-control mb-1" name="heart" id="heart" value="{{ isset($kunjungan->heart_rate)? $kunjungan->heart_rate : '' }}">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Berat Badan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="berat" id="berat" value="{{ isset($kunjungan->berat_badan)? $kunjungan->berat_badan : '' }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label class="form-label">Tinggi Badan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="tinggi" id="tinggi" value="{{ isset($kunjungan->tinggi_badan)? $kunjungan->tinggi_badan : '' }}">
                                    </div>
                                    
                                  </div>
                                  <div class="form-row" id="keluhanshow">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Keluhan <span></span></label>
                                      <textarea class="form-control mb-1" rows="5" name="keluhan" id="keluhan">{{ (isset($kunjungan->rujuk_lanjut) && $kunjungan->rujuk_lanjut->catatan != null)? $kunjungan->rujuk_lanjut->catatan : '-' }}</textarea>
                                    </div>
                                  </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Status Pulang <span>*</span></label>
                                    <select name="status_pulang" class="custom-select" id="status_pulang">
                                      <option value="">Pilih</option>
                                      {{-- <option value="0">Sembuh</option> --}}
                                      @foreach ($status_pulang as $pulang)
                                        <option value="{{ $pulang->kdStatusPulang }}" {{ (isset($kunjungan) && $kunjungan->status_pulang == $pulang->kdStatusPulang)? 'selected' : '' }}>{{ $pulang->nmStatusPulang }}</option>
                                          
                                      @endforeach
                                      
                                    </select>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Pulang <span>*</span></label>
                                    <input type="date" class="form-control mb-1" name="tglpulang" id="tglpulang" value="{{ (isset($kunjungan))? date('Y-m-d', strtotime($kunjungan->tgl_pulang)) : date('Y-m-d') }}">
                                  </div>
                                </div>

                                <div id="form_rujukan" style="display: none">
                                  <div class="form-row">
                                    <div class="form-group col-md-6" id="spesialisshowselect">
                                      <input type="radio" name="kasus" id="spesialis_select" {{ (isset($kunjungan->rujuk_lanjut->spesialis))? 'checked' : '' }}>
                                      <label for="spesialis">Spesialis <span>*</span></label>
                                    </div>
                                    <div class="form-group col-md-6" id="khususshowselect">
                                      <input type="radio" name="kasus" id="khusus_select" {{ (isset($kunjungan->rujuk_lanjut->kd_khusus))? 'checked' : '' }}>
                                      <label for="khusus">Khusus <span>*</span></label>
                                    </div>
                                  </div>
                                    <div class="form-row" id="spesialisshow" style="display: none">
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
                                  
                                    <div class="form-row" id="khususshow" style="display: none">
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
                                          </select>
                                        </div>
                                    </div>
                                  <div class="form-row" id="catatanshow">
                                    <div class="form-group col-md-12">
                                      <label class="form-label">Catatan Rujukan <span>*</span></label>
                                      <input type="text" class="form-control mb-1" name="catatan" id="catatan" value="{{ (isset($kunjungan) && $kunjungan->catatan != null)? $kunjungan->catatan : '-' }}">
                                    </div>
                                  </div>
                                  <div class="form-row" id="tglrujukshow">
                                    <div class="form-group col-md-8">
                                      <label class="form-label">Tanggal Rujuk <span>*</span></label>
                                      <input type="date" class="form-control mb-1" name="tglrujuk" id="tglrujuk" value="{{ (isset($kunjungan->rujuk_lanjut) && $kunjungan->rujuk_lanjut->tgl_est_rujuk)? date('Y-m-d', strtotime($kunjungan->rujuk_lanjut->tgl_est_rujuk)) : date('Y-m-d') }}">
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
                                          <tbody id="daftar_faskes">

                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <select name="kdTacc" class="custom-select" id="taccselect" required>
                                        <option value="-1">Tanpa TACC</option>
                                        <option value="0">Dengan TACC</option>
                                      </select>
                                    </div>
                                  {{-- </div> --}}
                                    <div class="form-group col-md-6" id="kondisishow">
                                      <select name="nmTacc" class="custom-select" id="taccselected" style="display: none">
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
                                      <select name="tacc_time" class="custom-select" id="tacc_time" style="display: none">
                                        <option value="">Pilih Waktu</option>
                                        <option value="< 3 Hari">< 3 Hari</option>
                                        <option value=">= 3 - 7 Hari">>= 3 - 7 Hari</option>
                                        <option value=">= 7 Hari">>= 7 Hari</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row" id="kondisiage">
                                    <div class="form-group col-md-6">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <select name="tacc_age" class="custom-select" id="tacc_age" style="display: none">
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
                                      <select name="tacc_comorbidity" class="custom-select" id="tacc_comorbidity" style="display: none">
                                        <option value="">Pilih Comorbidity</option>
                                        <option value="< 3 Hari"> < 3 Hari</option> 
                                        <option value=">= 3 - 7 Hari">>= 3 - 7 Hari </option>
                                        <option value=">= 7 Hari">>= 7 Hari</option>
                                      </select>
                                    </div>
                                  </div>
                               
                            </div>
                            <div class="form-row" id="terapishow">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Terapi / Catatan <span></span></label>
                                  <textarea class="form-control mb-1" rows="5" name="terapi" id="terapi">{{ (isset($kunjungan)? $kunjungan->terapi : '-') }}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label class="form-label">Penunjang (Pemeriksaan Laboratorium) <span>*</span></label>
                                  <select id="penunjang" name="penunjang" class="select2 form-control mb-1">
                                    <option value="T">Tidak</option>
                                    <option value="Y">Ya</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-row" id="tmpPemeriksaanLab" style="display: none">
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
                        <div class="col-md-12" id="tmpDiagnosis" style="display:block">
                          <div class="card-header">
                            <center>
                              <h3>TINDAKAN</h3>
                            </center>
                          </div>
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="hidden" class="form-control mb-1" name="total_tindakan" id="total_tindakan" value="1">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <label class="form-label">Resep</label>
                                      </div>
                                      <div class="col-md-6 mb-2">
                                          <a href="#!" style="float: right" id="tambah_tindakan" class="btn btn-success lg-btn-flat product-tooltip" title="Tambah Obat"><i class="ion ion-md-add"></i> &nbsp; Tambah Tindakan</a>
                                      </div>
                                  </div>
                                  <table class="table table-bordered">
                                      <tr>
                                          <th>Tindakan</th>
                                          <th>Action</th>
                                      </tr>
                                      <tbody id="ajax_tambah_tindakan">
                                        <tr id="data_tambah_tindakan_1">
                                          <td width=50%>
                                            <select name="tindakan[]" id="tindakan_1" style="width: 100%">
                                            
                                            </select>
                                          </td>
                                          <td>
                                            {{--  <a href='#!' onclick='deleteTindakan(1)' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus'><i class='fa fa-close'></i></a>  --}}
                                          </td>
                                        </tr>
                                      </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>

                        </div>
                        @if(isset($PelayananLab))
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
                                 <input type="text" class="form-control mb-1" name="nilai_{{$lab->pelayananlaboratorium->id}}" id="nilai_{{$lab->pelayananlaboratorium->id}}" readonly value="{{ $lab->nilai }}">
                               </div>
                             </div>
                             @endforeach
                        </div>
                        @endif
                        <div class="col-md-12" id="tmpResep" style="display:block">
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
                                    @if(isset($kunjungan))
                                        @if($kunjungan->no_kunjungan != 'null' || $kunjungan->no_kunjungan != '-')
                                            <input type="hidden" name="no_kunjungan" value="{{ $kunjungan->no_kunjungan }}">
                                        @endif
                                    @endif
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
//DOCUMENT READY FUNCTION (TINDAKAN)
<script>
  $(document).ready(function(){
    let idx = $('#total_tindakan').val();
    for(let i = 1; i<= idx; i++){
      tindakan_select2(i);
    }
  });
  function tindakan_select2(idx){
    $('#tindakan_'+idx).select2({
      placeholder: 'Pilih Tindakan',
      ajax: {
          url: "{{ route('pelayanan_poli.searchTindakan') }}",
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
                      id: item.kode_tindakan,
                      text : item.nama_tindakan,
                  });
              });
              return{
                  results: results
              };
          }
      }
    });
  }
</script>
//ONCLICK TAMBAH TINDAKAN
<script>
  $('#tambah_tindakan').on('click', function(){
    let idx = $('#total_tindakan').val();
    idx++;
    $('#total_tindakan').val(idx);
    let html = '<tr id="data_tambah_tindakan_'+idx+'">'
      +'<td width=50%>'
        +'<select name="tindakan[]" id="tindakan_'+idx+'" style="width: 100%">'
        
        +'</select>'
      +'</td>'
      +'<td>'
        +'<a href="#!" onclick="deleteTindakan('+idx+')" class="btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip" title="Hapus"><i class="fa fa-close"></i></a>'
      +'</td>'
    +'</tr>';
    $('#ajax_tambah_tindakan').append(html);
    tindakan_select2(idx);
  })
</script>
//ONCLICK DELETE TINDAKAN
<script>
  function deleteTindakan(id){

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data akan terhapus!',

        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Ya',
        cancelButtonText:'Batal',
        confirmButtonColor: '#ec6c62',
        closeOnConfirm: false
      }).then(function(result){
        if(result.value){
            $('#data_tambah_tindakan_'+id).remove();
        }


    });

  }
</script>
//DOCUMENT READY FUNCTION DOKTER BPJS
<script>
  $(document).ready(function(){
    var id_dokter = $('#kdDokter').val();
    $.ajax({
      type: 'POST',
      url: '{{route("pelayanan_poli.dokterbpjs")}}',
      headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
      beforeSend: function(){
        Swal.fire({
            title: 'Mohon Tunggu !',
            html: 'Loading',// add html attribute if you want or remove
            allowOutsideClick: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
      },
      success: function(response) {
        Swal.hideLoading();
        if(response.success == true){
            Swal.close();

            var dokter = response.datas
            $('#kdDokter').find('option').remove().end();
            $('#kdDokter').append('<option value="">Pilih Tenaga medis</option>');
                Swal.close();
                for(var i = 0 ; i < dokter.length ; i++){
                    if(id_dokter == dokter[i].kdDokter){
                        $('#kdDokter').append('<option value="'+dokter[i].kdDokter+'" selected>' + dokter[i].nmDokter + '</option>');
                    }else{
                        $('#kdDokter').append('<option value="'+dokter[i].kdDokter+'">' + dokter[i].nmDokter + '</option>');
                    }

                }
                $('#kdDokter').select2()


        }else{
            Swal.fire('UPS','Data Tenaga Medis Tidak Ditemukan','info');
        }

      },
      complete: function(){
          Swal.hideLoading();
      },
    });
  });
</script>
//SELECT 2 DIAGNOSA 1 - 3
<script>
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
</script>
//SEARCH DIAGNOSA
<script>
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
          Swal.fire({
              title: 'Mohon Tunggu !',
              html: 'Loading',// add html attribute if you want or remove
              allowOutsideClick: false,
              showConfirmButton: false,
              onBeforeOpen: () => {
                  Swal.showLoading()
              },
          });
        },
        success: function(response){
          Swal.hideLoading();
            if(response.success == true){
              Swal.close()
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
                    Swal.fire('UPS', response.message,'info');
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
</script>
//ONCHANGE STATUS PULANG
<script>
  $('#status_pulang').on('change', function(){
    if(this.value == '4'){
      $('#form_rujukan').show();
    }else{
      $('#form_rujukan').hide();
    }
  });
 //ON CHANGE RUJUK TIPE SPESIALIS / KHUSUS
  $('#spesialis_select').on('click', function(){
    $('#spesialisshow').show();
    $('#khususshow').hide();
  //SELECT 2 SPESIALIS
    $('#spesialis').select2({
      placeholder: 'Pilih Spesialis',
      ajax: {
          url: "{{ route('pelayanan_poli.spesialisbpjs') }}",
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
                      id: item.kdSpesialis,
                      text : item.nmSpesialis,
                  });
              });
              return{
                  results: results
              };
          }
      }
    });
    $('#sarana').select2({
      placeholder: 'Pilih Sarana',
      ajax: {
          url: "{{ route('pelayanan_poli.saranabpjs') }}",
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
                      id: item.kdSarana,
                      text : item.nmSarana,
                  });
              });
              return{
                  results: results
              };
          }
      }
    });
  });
  $('#spesialis').on('change', function(){
    $('#subspesialis').val('').change()
    $('#subspesialis').select2({
      placeholder: 'Pilih Sub Spesialis',
      ajax: {
          url: "{{ route('pelayanan_poli.subspesialisbpjs') }}",
          dataType: 'JSON',
          data: function(params) {
          return {
              search: params.term,
              kdSpesialis:  $('#spesialis').val()
          }
          },
          processResults: function (data) {
              var results = [];
              $.each(data, function(index, item){
                  results.push({
                      id: item.kdSubSpesialis,
                      text : item.nmSubSpesialis,
                  });
              });
              return{
                  results: results
              };
          }
      }
    });
  });
  $('#khusus_select').on('click', function(){
    $('#spesialisshow').css('display', 'none');
    $('#khususshow').css('display', 'block');
    $('#khusus').select2({
      placeholder: 'Pilih Khusus',
      ajax: {
          url: "{{ route('pelayanan_poli.khususbpjs') }}",
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
                      id: item.kdKhusus,
                      text : item.nmKhusus,
                  });
              });
              return{
                  results: results
              };
          }
      }
    });
    $('#khusus').on('change', function(){
      $('#subkhusus').val('').change();
      $('#subkhusus').select2({
        placeholder: 'Pilih Sub Khusus',
        ajax: {
            url: "{{ route('pelayanan_poli.subkhususbpjs') }}",
            dataType: 'JSON',
            data: function(params) {
            return {
                search: params.term,
                KdKhusus: $('#khusus').val(),
            }
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function(index, item){
                    results.push({
                        id: item.kdSubSpesialis,
                        text : item.nmSubSpesialis,
                    });
                });
                return{
                    results: results
                };
            }
        }
      });
    });
  });
</script>
//CARI FASYANKES RUJUKAN
<script>
  $('#searchRujuk').on('click', function(){
    $('#daftar_faskes').html('');
    $.ajax({
      type: 'GET',
      data: {
        subspesialis : $('#subspesialis').val(),
        sarana : $('#sarana').val(),
        tgl_est_rujuk : $('#tglrujuk').val(),
        kdKhusus : $('#khusus').val(),
        subkhusus : $('#subkhusus').val(),
        no_bpjs : $('#no_bpjs').val(),
      },
      url: '{{route("pelayanan_poli.rujukfasyankes")}}',
      headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
      beforeSend: function(){
        Swal.fire({
            title: 'Mohon Tunggu !',
            html: 'Loading',// add html attribute if you want or remove
            allowOutsideClick: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
      },
      success: function(data) {
        Swal.hideLoading();
        if(data.success == true){
          Swal.close();
          let datatable = '';
          for(var i=0;i<data.data.length;i++){
             datatable += '<tr>' +
                                // '<td>'++'</td>' +
                                '<td>'+data.data[i].nmppk +'('+data.data[i].kdppk+')'+'</td>' +
                                '<td>'+data.data[i].kelas+'</td>'+
                                '<td>'+data.data[i].nmkc+'</td>'+
                                '<td>'+data.data[i].alamatPpk+'</td>'+
                                '<td>'+data.data[i].telpPpk+'</td>'+
                                '<td>'+data.data[i].distance+'</td>'+
                                '<td>'+data.data[i].jmlRujuk+'</td>'+
                                '<td><input type="radio" name="provider" value="'+data.data[i].kdppk+'" id="'+data.data[i].kdppk+'"></td>'+
                                '</tr>';
                            
                          }
                          console.log(datatable);
              $('#daftar_faskes').append(datatable);
        }else{
          Swal.fire('Ups', data.message, 'info');
        }
      },
      complete: function(){
          Swal.hideLoading();
      },
    });
  });
</script>
//ONCHANGE PENUNJANG
<script>
  $('#penunjang').on('change', function(){
    if(this.value == 'Y'){
      $('#tmpPemeriksaanLab').css('display', 'block');
    }else{
      $('#tmpPemeriksaanLab').css('display', 'none');
    }
  })
</script>
//ONCHANGE TACC
<script>
  $('#taccselect').on('change', function(){
  $('#taccselected').val('').change();
  if(this.value == 0){
    $('#taccselected').css('display', 'block');
  }else{
    $('#taccselected').css('display', 'none');
    $('#tacc_time').css('display', 'none');
    $('#tacc_age').css('display', 'none');
    $('#tacc_comorbidity').css('display', 'none');
  }
  })
  $('#taccselected').on('change', function(){
  let tacc = [];
  tacc[1] = 'time';
  tacc[2] = 'age';
  tacc[4] = 'comorbidity';
  for(let i = 1 ; i < 5; i++){
    if(i == 3){
      continue;
    }else{
      if(this.value == i){
        $('#tacc_'+tacc[i]).css('display', 'block');
      }else{
        $('#tacc_'+tacc[i]).css('display', 'none');
      }
    }
  }
  });
</script>

{{--  <script type="text/javascript">
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
        console.log('kunjungan');
        @if(isset($kunjungan))
            @if($kunjungan['rujuk_lanjut'] != 'null' && isset($kunjungan['rujuk_lanjut']))
                rujukform();
                pilihPenunjang();
                @if($kunjungan['rujuk_lanjut']['spesialis'] != 'null')
                $.when(spesialis_select()).then(function(){
                    var subspesialis = "{{ $kunjungan['rujuk_lanjut']['subspesialis'] }}";
                    // console.log(subspesialis);
                    if(typeof subspesialis !== 'undefined'){
                        // console.log('masuk');
                        $.when(spesialis()).then(function(){
                            @if(isset($kunjungan->faskes_rujuk->kode_faskes))
                            var cekrujuk = "{{ $kunjungan->faskes_rujuk->kode_faskes }}"
                            @endif
                            if(typeof cekrujuk !== 'undefined'){
                                searchRujuk();
                            }else{
                                return;
                            }
                        })
                    }else{
                        return;
                    }
                });

                @else()
                    khusus_select();
                @endif


            @endif
        @endif
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
                        window.location.href="{{ url()->previous() }}";
                    }else{
                        Swal.fire('info',data.message,'success');
                        window.location.href="{{ url()->previous() }}";
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

                var dokter = response.datas
                $('#kdDokter').find('option').remove().end();
                $('#kdDokter').append('<option value="">Pilih Tenaga medis</option>');
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
                    Swal.fire('UPS','Data tidak ditemukan1','info');
                }
            }else{
                Swal.hideLoading();
                Swal.fire('UPS','Data tidak ditemukan2','info');
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
        var statuspulang = $('#status_pulang').val();
        console.log(statuspulang);
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
@if(isset($kunjungan))
function spesialis_select(){
    $('#khususshow').hide();
    $('#spesialisshow').show();
    $('#khusus').val('');
    $('#subkhusus').val('');
    @if(isset($kunjungan->rujuk_lanjut->spesialis))
        var kdspesialis = '{{ $kunjungan->rujuk_lanjut->spesialis }}';
    @endif;
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
            if(spesialis[i].kdSpesialis == kdspesialis){
                $('#spesialis').append('<option value="'+spesialis[i].kdSpesialis+'" selected>' + spesialis[i].nmSpesialis + '</option>');
            }else{
                $('#spesialis').append('<option value="'+spesialis[i].kdSpesialis+'">' + spesialis[i].nmSpesialis + '</option>');
            }
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
        @if(isset($kunjungan->rujuk_lanjut->kd_sarana))
        var kd_sarana = '{{ $kunjungan->rujuk_lanjut->kd_sarana }}';
        @endif
        if(response.datas.metaData.message != "OK"){
            Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
        }else{
        for(var i = 0 ; i < sarana.length ; i++){
            if(kd_sarana == sarana[i].kdSarana){
                $('#sarana').append('<option value="'+sarana[i].kdSarana+'" selected>' + sarana[i].nmSarana + '</option>');
            }else{
                $('#sarana').append('<option value="'+sarana[i].kdSarana+'">' + sarana[i].nmSarana + '</option>');
            }
        }
    }
    },
    complete: function(){

        Swal.hideLoading();
        Swal.close();


    },
    });
}
function spesialis(){
    console.log('tes spesial');
    @if(isset($kunjungan->rujuk_lanjut->subspesialis))
    var subspesialis = '{{ $kunjungan->rujuk_lanjut->subspesialis }}';
    @endif
    // console.log(subspesialis);
    $('#subspesialis').find('option').remove().end();
    $('#subspesialis').append('<option value="">Pilih SubSpesialis</option>');
    @if(isset($kunjungan['rujuk_lanjut']['spesialis']))
    var id_spesialis = "{{ $kunjungan['rujuk_lanjut']['spesialis'] }}";
    @endif
    console.log(id_spesialis);
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
            console.log(response);
            var spesialis = response.datas.response.list
            if(response.datas.metaData.message != "OK"){
                Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
            }else if(spesialis != null){
            for(var i = 0 ; i < spesialis.length ; i++){
                if(spesialis[i].kdSubSpesialis == subspesialis){
                    $('#subspesialis').append('<option value="'+spesialis[i].kdSubSpesialis+'" selected>' + spesialis[i].nmSubSpesialis + '</option>');
                }else{
                    $('#subspesialis').append('<option value="'+spesialis[i].kdSubSpesialis+'">' + spesialis[i].nmSubSpesialis + '</option>');
                }
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
}
function khusus_select(){
    $('#khususshow').show();
    $('#subkhususshow').hide();
    $('#spesialisshow').hide();
    @if(isset($kunjungan->rujuk_lanjut->kd_khusus))
    var kd_khusus = '{{ $kunjungan->rujuk_lanjut->kd_khusus }}'
    @endif
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
                if(khusus[i].kdKhusus == kd_khusus){
                    $('#khusus').append('<option value="'+khusus[i].kdKhusus+'" selected>' + khusus[i].nmKhusus + '</option>');
                }else{
                    $('#khusus').append('<option value="'+khusus[i].kdKhusus+'">' + khusus[i].nmKhusus + '</option>');
                }
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
            khusus();
        },
    });
}
function khusus(){
    var khusus = $('#khusus').val();
    if(khusus == 'THA' || khusus == 'HEM'){
        $('#subkhususshow').show();
    }else{
        $('#subkhususshow').hide();
    }
}
function searchRujuk(){
    $('#table1').find('tbody').remove().end();
    var nokartu = $('#no_bpjs').val();
    @if(isset($kunjungan['rujuk_lanjut']['spesialis']))

    var spesialis = "{{ $kunjungan['rujuk_lanjut']['spesialis'] }}";
    @endif
    @if(isset($kunjungan['rujuk_lanjut']['spesialis']))
    var kdsubspesialis = "{{ $kunjungan['rujuk_lanjut']['subspesialis'] }}";
    @endif
    var kdsarana = $('#sarana').val();
    var kdkhusus = $('#khusus').val();
    var kdsubkhusus = $('#subkhusus').val();
    var date = $('#tglrujuk').val();
    var tglrujuk = date.split("-").reverse().join("-");
    @if(isset($kunjungan->faskes_rujuk->kode_faskes))
    var kdfaskes = '{{ $kunjungan->faskes_rujuk->kode_faskes }}';
    @endif
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
                if(table[i].kdppk == kdfaskes){
                    selected = 'checked';

                }else{
                    selected = '';
                }
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
                                    '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'"'+selected+'></td>'+
                                    '</tr>' +
                                '</tbody>'
                    $('#table1').append(datatable);
                }
            }else{
                Swal.hideLoading();
                // Swal.fire('UPS','Data tidak ditemukan3','info');
            }
        }else{
            Swal.hideLoading();
            Swal.fire('UPS','Data tidak ditemukan4','info');
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
            if(table[i].kdppk == kdfaskes){
                selected = 'checked';

            }else{
                selected = '';
            }
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
                                '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'" '+selected+'></td>'+
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

        var selected = '';
        if(response.datas.metaData.code == 428){
            Swal.fire('UPS',error,'info');
        }else if(response.datas.metaData.code ==  412){
            for (let index = 0; index < error.length; index++) {
            Swal.fire(error[index].field,error[index].message,'info');
            }
        }else if(response.datas.metaData.code == 200){
            for(var i=0;i<table.length;i++){
                if(table[i].kdppk == kdfaskes){
                    selected = 'checked';

                }else{
                    selected = '';
                }
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
                                '<td><input type="radio" name="provider" value="'+table[i].kdppk+'" id="'+table[i].kdppk+'" '+selected+'></td>'+
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
}
@endif
</script>  --}}
@endpush


