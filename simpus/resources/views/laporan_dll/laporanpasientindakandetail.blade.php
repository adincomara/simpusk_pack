@extends('layouts.table')
@section('title', 'Laporan Pasien Tindakan')
@section('judultable', 'Laporan Pasien Tindakan')
@section('menu1', 'Laporan')
@section('menu2', 'Laporan Pasien Tindakan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Laporan Pasien Berdasarkan Tindakan</h3>
                <div class="ibox-tools">
                    <a href="{{ route('report.cetakTindakan',$enc_id)}}"><button class="btn btn-primary"><i class="fa fa-file-pdf"></i></button></a>
                    {{-- <a class="collapse-link">
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
                    </a> --}}
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover dataTables-example coba" id="table_jabatan" >
                <thead>
                    <tr>
                      <th>No Rekam Medis</th>
                      <th>Alamat</th>
                      <th>Nama Pasien</th>
                      <th>Tempat, Tanggal Lahir</th>
                      <th>Status Pasien</th>
                      <th>No BPJS</th>
                    </tr>
                  </thead>
                    <tr>
                      <td>{{$no_rekamedis}}</td>
                      <td>{{$poli->alamat}}</td>
                      <td>{{$poli->nama_pasien}}</td>
                      <td>{{$poli->tempat_lahir}}, {{$poli->tanggal_lahir}}</td>
                      <td>{{$poli->status_pasien}}</td>
                      <td>{{$poli->no_bpjs}}</td>
                    </tr>

            </table>

                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example coba">
                        <thead>
                          <tr>
                            <th width='1%'>No</th>
                            <th>Nama Diagnosis</th>
                             <th>Kode Tindakan</th>
                            <th>Nama Tindakan</th>
                            <th>No Rawat</th>
                          </tr>
                        </thead>
                        @foreach($records as $key => $data)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->diagnosa}}</td>
                            <td>{{$data->kode_tindakan}}</td>
                            <td>{{$data->nama_tindakan}}</td>
                            <td>{{$data->no_rawat}}</td>
                          </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
