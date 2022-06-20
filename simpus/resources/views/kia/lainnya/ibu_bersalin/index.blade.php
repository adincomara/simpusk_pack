@extends('layouts.table_kia')
@section('title', 'Ibu Bersalin')
@section('judultable', 'Ibu Bersalin')
@section('subjudul', '(Jumlah Ibu Bersalin)')
@section('menu1', 'Menu Lainnya')
@section('menu2', 'Ibu Bersalin')
@section('table_kia')
<style>
    .text-datatable {
        width: 100px;
        text-align: right;
        border: none;
    }

    #table1 th {
        background: #1ab394 !important;
    }

    #table1 td {
        background: white !important;
    }

    #table1 thead tr th:nth-child(1),
    #table1 thead tr th:nth-child(2) {
        z-index: 100;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Daftar Ibu Bersalin</h3>
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
                                <tr class="bg-primary text-white">
                                    <th rowspan="2" class="bg-primary">NO</th>
                                    <th rowspan="2" class="bg-primary">PUSKESMAS</th>
                                    <th colspan="4" class="bg-primary">JANUARI</th>
                                    <th colspan="4" class="bg-primary">FEBRUARI</th>
                                    <th colspan="4" class="bg-primary">MARET</th>
                                    <th colspan="4" class="bg-primary">APRIL</th>
                                    <th colspan="4" class="bg-primary">MEI</th>
                                    <th colspan="4" class="bg-primary">JUNI</th>
                                    <th colspan="4" class="bg-primary">JULI</th>
                                    <th colspan="4" class="bg-primary">AGUSTUS</th>
                                    <th colspan="4" class="bg-primary">SEPTEMBER</th>
                                    <th colspan="4" class="bg-primary">OKTOBER</th>
                                    <th colspan="4" class="bg-primary">NOVEMBER</th>
                                    <th colspan="4" class="bg-primary">DESEMBER</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <?php
                                                                        for($i=1;$i<=12;$i++){
                                                                    ?>
                                    <th class="bg-primary" style="z-index: 90">TOTAL</th>
                                    <th class="bg-primary" style="z-index: 90">NAKES</th>
                                    <th class="bg-primary">DUKUN</th>
                                    <th class="bg-primary">SENDIRI</th>
                                    <?php
                                                                        }
                                                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Puskesmas 1</td>
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
                                    <td><input type="text" class="text-datatable text-center" style="background:#f3f3f4"
                                            id="" name="" value="0">
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
                    fixedColumns: {
                        left: 2
                    },
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
