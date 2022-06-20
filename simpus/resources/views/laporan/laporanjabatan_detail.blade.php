@extends('layouts.table')
@section('title', 'Jabatan Nakes Detail')
@section('judultable', 'Jabatan Nakes Detail')
@section('menu1', 'Laporan')
@section('menu2', 'Jabatan Nakes Detail')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Laporan Pasien Berdasarkan Diagnosa</h3>
                <div class="ibox-tools">
                    <a href="{{ route('jabatannakes.cetak', $id)}}" target="_blank"><button class="btn btn-primary"><i class="fa fa-file-pdf"></i></button></a>
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
                          <th>No</th>
                          <th>Nama Pegawai</th>
                          <th>NIP / NIK</th>
                          <th>Gender</th>
                          <th>NPWP</th>
                          <th>Kota Asal</th>
                          <th>Jabatan</th>
                          <th>Bidang</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($data as $row => $pegawai)
                      <tr>
                        <td>{{ $row+1 }}</td>
                        <td>{{ $pegawai->nama_pegawai }}</td>
                        <td>NIP : {{ $pegawai->nip }} <br> NIK : {{ $pegawai->nik }}</td>
                        <td>{{ $pegawai->jenis_kelamin }}</td>
                        <td>{{ $pegawai->npwp }}</td>
                        <td>{{ $pegawai->tempat_lahir }}</td>
                        <td>{{ $pegawai->nama_jabatan }}</td>
                        <td>{{ $pegawai->nama_bidang }}</td>
                      </tr>
                      @endforeach
                  </tbody>


            </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
