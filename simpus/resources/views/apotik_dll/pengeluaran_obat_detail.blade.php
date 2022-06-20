@extends('layouts.table')
@section('title', 'Form Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Detail Pengeluaran Obat</h3>
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
                        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($jabatan)? $enc_id : ''}}"> --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">No Rawat</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->no_rawat }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">No Rekam Medis</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->no_rekamedis }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Tanggal Pendaftaran</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->tanggal_daftar }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                        </div>
                        <div class="form-row">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->pasien->nama_pasien }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Status Pasien</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->status_pasien }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Poli</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->poli->nama_poli }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Dokter</label>
                                <input type="text" class="form-control mb-1" value="{{isset($pendaftaran->nama_penanggung_jawab) ? $pendaftaran->nama_penanggung_jawab : '' }}" readonly>
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label class="form-label">Nama Penanggung Jawab</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->nama_penanggung_jawab }}" readonly>
                            </div> --}}
                        </div>
                        <div class="form-row">
                        </div>
                        <div class="form-row">
                            {{-- <div class="form-group col-md-2">
                                <label class="form-label">Status Pasien</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->status_pasien }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">Poli</label>
                                <input type="text" class="form-control mb-1" value="{{ $pendaftaran->poli->nama_poli }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">Dokter</label>
                                <input type="text" class="form-control mb-1" value="{{isset($pendaftaran->dokter->nama_pegawai) ? $pendaftaran->dokter->nama_pegawai : '' }}" readonly>
                            </div> --}}
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Diagnosa</label>
                                <table class="table table-bordered">
                                  <tr>
                                      <th>Kode Diagnosa</th>
                                      <th>Nama Diagnosa</th>
                                  </tr>
                                  @if(isset($pendaftaran->pelayanan_poli->poli_diagnosa))
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
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Resep</label>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Jenis Obat</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        {{-- <th>Cara Pakai</th> --}}
                                        <th>Aturan Pakai</th>
                                    </tr>
                                    @if(isset($pendaftaran->detailpengeluaranobat))
                                    @foreach ($pendaftaran->detailpengeluaranobat as $item)
                                    <tr>
                                        <td>{{ $item->kode_obat }}</td>
                                        <td>{{ $item->nama_obat }}</td>
                                        <td>{{ $item->jenis_obat }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        {{-- <td>{{ $item->cara_pakai }}</td> --}}
                                        <td>{{ $item->dosis_aturan_obat }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
@endpush


