@extends('layouts.table_ptm')
@section('title', 'SPM')
@section('judultable', 'SPM')
{{-- @section('subjudul', '(SPM)') --}}
@section('menu1', 'Indikator')
@section('menu2', 'SPM')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">SPM</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('indikator_spm.form') }}" class="btn btn-primary b-r-xl"><i
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
                                <p class="font-bold">Range Periode</p>
                                <div class="form-group" id="range_periode">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class=" form-control rounded-left periode" id="start"
                                            name="start" value="Apr-2022" />
                                        <span class="input-group-addon px-3 bg-primary">to</span>
                                        <input type="text" class=" form-control rounded-right periode" id="end"
                                            name="end" value="Apr-2022" />
                                    </div>
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
                                <tr class="text-white bg-primary">
                                    <th width="5%" class="align-middle bg-primary text-center" rowspan="2">No</th>
                                    <th class="align-middle " rowspan="2" id="header_puskesmas">PUSKESMAS</th>
                                    {{-- <th class="align-middle " rowspan="2">PUSKESMAS</th> --}}
                                    <th class="align-middle bg-primary" colspan="3">PELAYANAN KESEHATAN USIA PRODUKTIF
                                    </th>
                                    <th class="align-middle bg-primary" colspan="3">PELAYANAN KESEHATAN PENDERITA
                                        HIPERTENSI</th>
                                    <th class="align-middle bg-primary" colspan="3">PELAYANAN KESEHATAN PENDERITA DM
                                    </th>
                                    <th class="align-middle bg-primary" colspan="3">PELAYANAN KESEHATAN ODGJ</th>
                                    <th class="align-middle bg-primary" rowspan="2">Action</th>
                                </tr>
                                <tr class="text-white bg-primary">
                                    <th class="align-middle" style="z-index: 50">SASARAN</th>
                                    <th class="align-middle" style="z-index: 50">REALISASI</th>
                                    <th class="align-middle">%</th>
                                    <th class="align-middle">SASARAN</th>
                                    <th class="align-middle">REALISASI</th>
                                    <th class="align-middle">%</th>
                                    <th class="align-middle">SASARAN</th>
                                    <th class="align-middle">REALISASI</th>
                                    <th class="align-middle">%</th>
                                    <th class="align-middle">SASARAN</th>
                                    <th class="align-middle">REALISASI</th>
                                    <th class="align-middle">%</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
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
                $('.periode').datepicker({
                    minViewMode: 1,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "M-yyyy"
                });
            });
        </script>
        @endpush
