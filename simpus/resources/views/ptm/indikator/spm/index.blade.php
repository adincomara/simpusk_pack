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
                                    <th width="5%" class="align-middle bg-primary" rowspan="4">No</th>
                                    <th class="align-middle" rowspan="4">PUSKESMAS</th>
                                    <th class="align-middle text-center bg-primary" colspan="74">D I A G N O S A</th>
                                    <th class="align-middle text-center" rowspan="4">JUMLAH KASUS</th>
                                    <th class="align-middle" rowspan="4">Action</th>
                                </tr>
                                <tr class="text-white bg-primary">
                                    <th class="align-middle text-center bg-primary" colspan="2" rowspan="2">DEMENSIA F00
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN ANSIETAS F.40
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN CAMPURAN
                                        ANSIETAS DAN
                                        DEPRESI
                                        F41.2</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN DEPRESI F.32
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN PENYALAHGUNAAN
                                        NAPZA F10#
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN PERKEMBANGAN
                                        PADA ANAK DAN
                                        REMAJA
                                        F80-90#</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN PSIKOTIK AKUT
                                        F23#</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">SKIZOFRENIA F20</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN SOMATOFORM F45
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">INSOMNIA F51.0</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">PERCOBAAN BUNUH DIRI
                                    </th>
                                    <th class="align-middle text-center bg-primary" colspan="6">REDARTASI MENTAL F.70 -
                                        F.79</th>
                                    <th class="align-middle text-center bg-primary" colspan="6">GANGGUAN KEPRIBADIAN DAN
                                        PERILAKU
                                        F.60-F.61
                                    </th>
                                </tr>
                                <tr class="text-white bg-primary">
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">0-14 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">15-59 th</th>
                                    <th class="align-middle text-center bg-primary" colspan="2">>=60 th</th>
                                </tr>
                                <tr class="text-white bg-primary">
                                    <th class="align-middle text-center" style="z-index: 55">L</th>
                                    <th class="align-middle text-center" style="z-index: 55">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                    <th class="align-middle text-center">L</th>
                                    <th class="align-middle text-center">P</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>nama puskesmas</td>
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
