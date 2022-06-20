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
                    <h3>Detail Pengadaan Obat</h3>
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
                            <div class="form-group col-md-12">
                              <label class="form-label">No Transaksi <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_trans" id="no_trans" value="{{isset($pengadaan_obat)? $pengadaan_obat->no_trans : $noTrans}}" readonly>
                            </div>
                          </div>

                          <div class="card mb-3">
                              <div class="card-body pb-2">
                                  <h4 class="font-weight-bold py-3 mb-4">
                                      <span class="text-muted">Data Obat</span>
                                  </h4>
                                  <table class="table table-bordered" id="tableObat">
                                    <tr>
                                        <th width="20%">Nama/Kode Obat</th>
                                        <th width="20%">Suplier</th>
                                        <th width="14%">Batch Obat</th>
                                        <th width="14%">Tgl Expired Obat</th>
                                        <th width="10%">Jumlah</th>
                                        <th width="10%">Harga</th>
                                        <th width="10%">Total</th>
                                        <th width="2%"></th>
                                    </tr>
                                      @foreach ($pengadaan_obat->detailPengadaan as $item)
                                      <tr>
                                          <td><input type="text" class="form-control" value="{{$item->obat->kode_obat}} - {{$item->obat->nama_obat}}" readonly/></td>
                                          <td><input type="text" class="form-control" value="{{$item->supplier->kode_supplier}} - {{$item->supplier->nama_supplier}}" readonly/></td>
                                          <td><input type="text" name="" id="" value="{{isset($item->batch_obat->batch_obat)?$item->batch_obat->batch_obat:''}}" class="form-control" readonly></td>
                                          <td><input type="text" name="" id="" value="{{isset($item->batch_obat->tgl_expired_obat)?$item->batch_obat->tgl_expired_obat:''}}" class="form-control" readonly></td>
                                          <td><input type="number" class="form-control hitung-jumlah" min="1" name="jumlah_1" id="jumlah_1" value="{{$item->jumlah}}" readonly/></td>
                                          <td><input type="number" class="form-control hitung-harga" min="0" name="harga_1" id="harga_1" value="{{$item->harga_beli}}" readonly/></td>
                                          <td><input type="number" class="form-control hitung-total" name="total_1" id="total_1" value="{{$item->total_harga}}" readonly/></td>
                                      </tr>
                                      @endforeach
                                  </table>
                              </div>
                          </div>

                          <div class="form-row">
                              <div class="form-group col-md-6">
                              <label class="form-label">Total Jumlah<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="total_jumlah" id="total_jumlah" value="{{ $pengadaan_obat->total_jumlah }}" readonly>
                              </div>
                              <div class="form-group col-md-6">
                              <label class="form-label">Total Harga<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="total_harga" id="total_harga" value="{{ $pengadaan_obat->total_harga }}" readonly>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-12">
                                  <label class="form-label">Keterangan</label>
                                  <textarea type="text" class="form-control mb-1" name="keterangan" id="keterangan" readonly>{{isset($pengadaan_obat)? $pengadaan_obat->keterangan : ''}}</textarea>
                              </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <a href="{{route('pengadaan_obat.index')}}"  class="btn btn-default">Kembali</a>
                              </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
@endpush


