@extends('layouts.table_kia')
@section('title', 'SDM Prog Anak')
@section('judultable', 'SDM Prog Anak')
@section('subjudul', '(Data sumber daya manusia program kesehatan anak)')
@section('menu1', 'Kesehatan Anak')
@section('menu2', 'SDM Prog Anak')
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
                            <h3 class="ml-3">Daftar SDM Prog Anak</h3>
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
                                    <th rowspan="2" class="bg-primary">No.</th>
                                    <th rowspan="2" class="bg-primary">Puskesmas</th>
                                    <th colspan="3" class="bg-primary">∑ Tenaga Puskesmas terlatih Asfiksia</th>
                                    <th colspan="3" class="bg-primary">∑ Tenaga Puskesmas terlatih BBLR</th>
                                    <th rowspan="2" class="bg-primary">∑ Puskesmas yang TIDAK memiliki tenaga terlatih
                                        MTBS</th>
                                    <th colspan="3" class="bg-primary">∑ Tenaga Puskesmas terlatih MTBS</th>
                                    <th colspan="3" class="bg-primary">∑ Tenaga Puskesmas terlatih SDIDTK</th>
                                    <th rowspan="2" class="bg-primary">∑ Tenaga Puskesmas terlatih PKPR </th>
                                    <th colspan="3" class="bg-primary">∑ Tenaga Puskesmas terlatih SDIDTK</th>
                                </tr>
                                <tr class="text-white">
                                    <th class="bg-primary">Dokter</th>
                                    <th class="bg-primary">Bidan</th>
                                    <th class="bg-primary">Perawat</th>

                                    <th class="bg-primary">Dokter</th>
                                    <th class="bg-primary">Bidan</th>
                                    <th class="bg-primary">Perawat</th>

                                    <th class="bg-primary">Dokter</th>
                                    <th class="bg-primary">Bidan</th>
                                    <th class="bg-primary">Perawat</th>

                                    <th class="bg-primary">Dokter</th>
                                    <th class="bg-primary">Bidan</th>
                                    <th class="bg-primary">Perawat</th>

                                    <th class="bg-primary">Dokter</th>
                                    <th class="bg-primary">Bidan</th>
                                    <th class="bg-primary">Perawat</th>
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
