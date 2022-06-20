@extends('layouts.table_kia')
@section('title', 'Data Sarana Program')
@section('judultable', 'Data Sarana Program')
@section('subjudul', '(Data sarana program kesehatan anak)')
@section('menu1', 'Kesehatan Anak')
@section('menu2', 'Data Sarana Program')
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
                            <h3 class="ml-3">Daftar Data Sarana Program</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
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
                                <tr class="text-white">
                                    <th rowspan="3" class="bg-primary">No.</th>
                                    <th rowspan="3" class="bg-primary">Puskesmas</th>
                                    <th rowspan="3" class="bg-primary">RS melayani Tumbuh Kembang</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">∑ Sarana Rujukan Kekerasan Terhadap
                                        Anak (KtA)</th>
                                    <th rowspan="2" colspan="2" class="bg-primary">MTBS</th>
                                    <th colspan="5" class="bg-primary">∑ Puskesmas</th>
                                    <th colspan="6" class="bg-primary">∑ Sekolah Yang Melaksanakan UKS</th>
                                </tr>
                                <tr class="text-white">
                                    <th colspan="3" class="bg-primary">Melaksanakan SDIDTK</th>
                                    <th rowspan="2" class="bg-primary">Mampu laksana PKPR</th>
                                    <th rowspan="2" class="bg-primary">Mampu Tata Laksana Kasus KtA</th>
                                    <th colspan="2" class="bg-primary">SD/MI</th>
                                    <th colspan="2" class="bg-primary">SMP/MTs</th>
                                    <th colspan="2" class="bg-primary">SMA/MA/SMK</th>
                                </tr>
                                <tr class="text-white">
                                    <th class="bg-primary">PKT/PRT di RSUD</th>
                                    <th class="bg-primary">P2TP2A</th>
                                    <th class="bg-primary">Balita Berkunjung</th>
                                    <th class="bg-primary">Melaksanakan MTBS</th>
                                    <th class="bg-primary">&lt; 50 % dari jlh sasaran Balita</th>
                                    <th class="bg-primary">50 - 75 % dari jlh sasaran Balita</th>
                                    <th class="bg-primary">50 - 75 % dari jlh sasaran Balita</th>
                                    <th class="bg-primary">∑ Absolut</th>
                                    <th class="bg-primary">Cakupan (%)</th>
                                    <th class="bg-primary">∑ Absolut</th>
                                    <th class="bg-primary">Cakupan (%)</th>
                                    <th class="bg-primary">∑ Absolut</th>
                                    <th class="bg-primary">Cakupan (%)</th>
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
                    minViewMode: 2,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy"
                });
                $(".select2_desa").select2();
            });
        </script>
        @endpush
