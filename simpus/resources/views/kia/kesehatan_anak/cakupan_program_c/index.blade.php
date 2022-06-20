@extends('layouts.table_kia')
@section('title', 'Cakupan Program 3')
@section('judultable', 'Cakupan Program 3')
@section('subjudul', '(Data kasus kekerasan dan perlindungan kesehatan anak)')
@section('menu1', 'Kesehatan Anak')
@section('menu2', 'Cakupan Program 3')
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
                            <h3 class="ml-3">Daftar Cakupan Program 3</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class=" text-right">
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
                                <tr class="text-white">
                                    <th rowspan="3" class="bg-primary">No.</th>
                                    <th rowspan="3" class="bg-primary">Puskesmas</th>
                                    <th colspan="25" class="bg-primary">Jenis Kekerasan</th>
                                    <th rowspan="3" class="bg-primary">∑ SLB Yang Dibina</th>
                                    <th rowspan="3" class="bg-primary">∑ LAPAS/RUTAN ANAK yang Dibina</th>
                                    <th rowspan="3" class="bg-primary">∑ LAPAS/RUTAN yang Dibina</th>
                                </tr>
                                <tr class="text-white">
                                    <th colspan="5" class="bg-primary">∑ Kekerasan Seksual</th>
                                    <th colspan="5" class="bg-primary">∑ Kekerasan Fisik</th>
                                    <th colspan="5" class="bg-primary">∑ Kekerasan Emosional</th>
                                    <th colspan="5" class="bg-primary">∑ Kekerasan Penelantaran</th>
                                    <th colspan="5" class="bg-primary">∑ Kekerasan Trafiking</th>
                                </tr>
                                <tr class="text-white">
                                    <th class="bg-primary">0-11 bln</th>
                                    <th class="bg-primary">1-4 thn</th>
                                    <th class="bg-primary">5-9 thn</th>
                                    <th class="bg-primary">10-14 thn</th>
                                    <th class="bg-primary">15-18 thn</th>

                                    <th class="bg-primary">0-11 bln</th>
                                    <th class="bg-primary">1-4 thn</th>
                                    <th class="bg-primary">5-9 thn</th>
                                    <th class="bg-primary">10-14 thn</th>
                                    <th class="bg-primary">15-18 thn</th>

                                    <th class="bg-primary">0-11 bln</th>
                                    <th class="bg-primary">1-4 thn</th>
                                    <th class="bg-primary">5-9 thn</th>
                                    <th class="bg-primary">10-14 thn</th>
                                    <th class="bg-primary">15-18 thn</th>

                                    <th class="bg-primary">0-11 bln</th>
                                    <th class="bg-primary">1-4 thn</th>
                                    <th class="bg-primary">5-9 thn</th>
                                    <th class="bg-primary">10-14 thn</th>
                                    <th class="bg-primary">15-18 thn</th>

                                    <th class="bg-primary">0-11 bln</th>
                                    <th class="bg-primary">1-4 thn</th>
                                    <th class="bg-primary">5-9 thn</th>
                                    <th class="bg-primary">10-14 thn</th>
                                    <th class="bg-primary">15-18 thn</th>
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
