@extends('layouts.table_kia')
@section('title', 'Data Dasar')
@section('judultable', 'Data Dasar')
{{-- @section('subjudul', '(Data Dasar)') --}}
@section('menu1', 'Master')
@section('menu2', 'Data Dasar')
@section('table_kia')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="d-flex justify-content-between">
                        <div class="p-0">
                            <h3 class="ml-3">Data Dasar</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="p-0 text-right">
                                <a href="{{ route('datadasar.form') }}" class="btn btn-primary b-r-xl"><i
                                        class="fa fa-plus-circle"></i>&nbsp;
                                    Tambah</a>
                                <a href="javascript:void(0);"
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-refresh"></i>&nbsp; Refresh</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl mt-3">
                    <div class="d-flex justify-content-between my-3">
                        <div class="p-0">
                            <div class="form-group col-md" id="periode_bln">
                                <p class="font-bold">Periode Tahun</p>
                                <div class="input-group date">
                                    <span class="input-group-addon px-3 bg-primary rounded-left"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-group-addon rounded-right py-2"
                                        name="periode" id="periode" name="periode" autocomplete="off" value="2022">
                                </div>
                            </div>
                        </div>
                        <div class="p-0 my-auto">
                            <p>
                                <a class="btn btn-default" href=""> <i class=" fa fa-print"></i>
                                    &nbsp; Print</a>
                                <a class="btn btn-danger" href="#"> <i class=" fa fa-file-pdf-o"></i>
                                    &nbsp; PDF</a>
                                <a class="btn btn-primary" href="#"> <i class=" fa fa-file-excel-o"></i>
                                    &nbsp; Excel</a>
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table p-0 table-bordered text-center table-hover"
                            style="overflow-x: auto;">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="5%" rowspan="3" class="bg-primary">No</th>
                                    <th rowspan="3">Desa</th>
                                    <th colspan="2" class="bg-primary">Jumlah Penduduk</th>
                                    <th class="bg-primary">CBR</th>
                                    <th class="bg-primary">Jumlah</th>
                                    <th colspan="6" class="bg-primary">Sasaran</th>
                                    <th colspan="4" class="bg-primary">Remaja</th>
                                    <th rowspan="3" class="bg-primary">Action</th>
                                </tr>
                                <tr class="bg-primary">
                                    <th rowspan="2">L</th>
                                    <th rowspan="2">P</th>
                                    <th rowspan="2">2022</th>
                                    <th rowspan="2">PUS</th>
                                    <th rowspan="2">BUMIL</th>
                                    <th rowspan="2">BULIN</th>
                                    <th rowspan="2">BAYI</th>
                                    <th rowspan="2">SASARAN BAYI 0-11 BLN</th>
                                    <th rowspan="2">SASARAN BALITA 12-59 BLN</th>
                                    <th rowspan="2">SASARAN ANAK PRA SEKOLAH 60-72 BLN</th>
                                    <th colspan="2" class="bg-primary">10-14 TAHUN</th>
                                    <th colspan="2" class="bg-primary">15 - &lt;18 TAHUN</th>
                                </tr>
                                <tr class="bg-primary">
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Panunggalan</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>
                                        <div class='btn-group '>
                                            <a href="#"
                                                class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip b-r-xl"
                                                title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                                            <a href="#"
                                                class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip b-r-xl"
                                                title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary">
                                    <th></th>
                                    <th>Total</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
        <script>
            $(document).ready(function () {
                $(".btn-refresh").click(function() {
                    table.ajax.reload();
                });
                table = $('#table1').DataTable({
                    pageLength: 10,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [],
                });
                $('#periode_bln .input-group.date').datepicker({
                    minViewMode: 2,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy"
                });
            });
        </script>
        @endpush
