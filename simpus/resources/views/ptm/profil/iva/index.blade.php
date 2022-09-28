@extends('layouts.table_ptm')
@section('title', 'IVA-SADANIS')
@section('judultable', 'IVA-SADANIS')
{{-- @section('subjudul', '(IVA-SADANIS)') --}}
@section('menu1', 'Profil')
@section('menu2', 'IVA-SADANIS')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">IVA-SADANIS</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('profil_sdm.form') }}" class="btn btn-primary b-r-xl"><i
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
                                <p class="font-bold">Periode</p>
                                <div class="input-group date">
                                    <span class="input-group-addon px-3 bg-primary rounded-left"><i
                                            class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control input-group-addon rounded-right py-2"
                                        name="periode" id="periode" name="periode" autocomplete="off" value="Apr-2022">
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
                                    <th width="5%" class="align-middle bg-primary" rowspan="2" style="z-index: 9999">No
                                    </th>
                                    <th class="align-middle bg-primary" rowspan="2" style="z-index: 9999">PUSKESMAS</th>
                                    <th class="align-middle bg-primary" rowspan="2">PEREMPUAN USIA 30-50 TAHUN*</th>
                                    <th class="align-middle bg-primary" colspan="2">PEMERIKSAAN LEHER RAHIM DAN PAYUDARA
                                    </th>
                                    <th class="align-middle bg-primary" colspan="2">IVA POSISIF</th>
                                    <th class="align-middle bg-primary" colspan="2">CURIGA KANKER</th>
                                    <th class="align-middle bg-primary" colspan="2">TUMOR/BEJOLAN</th>
                                    <th class="align-middle" rowspan="2">Action</th>
                                </tr>
                                <tr class="text-white bg-primary">
                                    <th class="align-middle bg-primary">JUMLAH</th>
                                    <th class="align-middle bg-primary">%</th>
                                    <th class="align-middle bg-primary">JUMLAH</th>
                                    <th class="align-middle bg-primary">%</th>
                                    <th class="align-middle bg-primary">JUMLAH</th>
                                    <th class="align-middle bg-primary">%</th>
                                    <th class="align-middle bg-primary">JUMLAH</th>
                                    <th class="align-middle bg-primary">%</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>nama puskesmas</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
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
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td></td>
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
