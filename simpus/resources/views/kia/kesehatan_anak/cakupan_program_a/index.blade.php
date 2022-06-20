@extends('layouts.table_kia')
@section('title', 'Cakupan Program 1')
@section('judultable', 'Cakupan Program 1')
@section('subjudul', '(Laporan pencapaian indikator program kesehatan anak)')
@section('menu1', 'Kesehatan Anak')
@section('menu2', 'Cakupan Program 1')
@section('table_kia')
<style>
    .text-datatable {
        width: 50px;
        text-align: right;
        border: none;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Daftar Cakupan Program 1</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="col-sm-6 text-right">
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
                                <tr class="bg-primary text-white">
                                    <th rowspan="3" class="bg-primary">No.</th>
                                    <th rowspan="3">Puskesmas</th>
                                    <th colspan="4" class="bg-primary">Cakupan KN</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">Cakupan neonatus komplikasi yang
                                        ditangani</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">Cakupan Kunjungan Bayi</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">Cakupan Pelayanan Anak Balita</th>
                                    <th rowspan="3">∑ Balita (0-59 bulan) yang mempunyai buku KIA</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">Cakupan anak prasekolah (60 - 71
                                        bulan) dilayani SDIDTK
                                        min 2 kali/thn</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th colspan="2" class="bg-primary">KN1</th>
                                    <th colspan="2" class="bg-primary">KN Lengkap</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                    <th>∑ Absolut</th>
                                    <th>Cakupan (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Puskesmas 1</td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary">
                                    <td></td>
                                    <td>Total</td>
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
                $(".select2_desa").select2();
            });
        </script>
        @endpush
