@extends('layouts.table')
@section('title', 'Laporan Tindakan Pasien')
@section('judultable', 'Laporan Tindakan Pasien')
@section('menu1', 'Laporan')
@section('menu2', 'Laporan Tindakan Pasien')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Laporan Pasien Berdasarkan Tindakn</h3>
                <div class="ibox-tools">
                    <a href="{{ route('report.cetakTindakanPasien_detail', $id)}}" target="_blank"><button class="btn btn-primary"><i class="fa fa-file-pdf"></i></button></a>
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
                          <th>Tindakan</th>
                          <th>Tanggal</th>
                          <th>Data Pasien</th>
                    </tr>
                  </thead>
                  <?php
                            echo $data;
                            ?>

            </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush
