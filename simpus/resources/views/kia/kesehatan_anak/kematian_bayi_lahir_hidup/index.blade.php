@extends('layouts.table_kia')
@section('title', 'Kematian Bayi dan Lahir Hidup')
@section('judultable', 'Kematian Bayi dan Lahir Hidup')
@section('subjudul', '(Input data kematian bayi dan lahir hidup)')
@section('menu1', 'Kesehatan Anak')
@section('menu2', 'Kematian Bayi dan Lahir Hidup')
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
                            <h3 class="ml-3">Daftar Kematian Bayi dan Lahir Hidup</h3>
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
                                    <th rowspan="2" class="bg-primary">No.</th>
                                    <th rowspan="2" class="bg-primary">Puskesmas</th>
                                    <th colspan="2" class="bg-primary">Lahir Hidup</th>
                                    <th rowspan="2" class="bg-primary">∑ Lahir hidup</th>
                                    <th colspan="3" class="bg-primary">Bayi Lahir Dengan Resiko Staunting</th>
                                    <th rowspan="2" class="bg-primary">∑ Lahir mati</th>
                                    <th colspan="3" class="bg-primary">Kematian Neonatal</th>
                                    <th colspan="7" class="bg-primary">Sebab Kematian Neonatal</th>
                                    <th rowspan="2" class="bg-primary">∑ Kematian Bayi (29 hr - 11 bln)</th>
                                    <th colspan="6" class="bg-primary">Sebab Kematian Bayi</th>
                                    <th rowspan="2" class="bg-primary">∑ Kematian Anak Balita (12-59 bulan)</th>
                                    <th colspan="7" class="bg-primary">Sebab Kematian Anak Balita</th>
                                </tr>
                                <tr class="text-white">
                                    <th class="bg-primary">&lt;2500gr </th>
                                    <th class="bg-primary"> &gt;2500gr</th>
                                    <th class="bg-primary"> L (PB &lt;48 cm) </th>
                                    <th class="bg-primary"> P(PB &lt;47 cm) </th>
                                    <th class="bg-primary"> Jumlah </th>
                                    <th class="bg-primary"> ∑ Kematian 0-6 hari </th>
                                    <th class="bg-primary"> ∑ Kematian 7-28 hari </th>
                                    <th class="bg-primary"> Jumlah Kematian Neonatal </th>

                                    <th class="bg-primary"> BBLR </th>
                                    <th class="bg-primary"> Asfiksia </th>
                                    <th class="bg-primary"> Tetanus Neonaturum </th>
                                    <th class="bg-primary"> Sepsis </th>
                                    <th class="bg-primary"> Kelainan Kongenital </th>
                                    <th class="bg-primary"> Ikterus </th>
                                    <th class="bg-primary"> Lain-Lain </th>

                                    <th class="bg-primary"> Pneumonia </th>
                                    <th class="bg-primary"> Diare </th>
                                    <th class="bg-primary"> Kelainan Saluran Cerna </th>
                                    <th class="bg-primary"> Tetanus </th>
                                    <th class="bg-primary"> Kelainan Saraf </th>
                                    <th class="bg-primary"> Lain-Lain </th>

                                    <th class="bg-primary"> ISPA </th>
                                    <th class="bg-primary"> Diare </th>
                                    <th class="bg-primary"> Malaria </th>
                                    <th class="bg-primary"> Campak </th>
                                    <th class="bg-primary"> Demam Berdarah Dengue </th>
                                    <th class="bg-primary"> Difteri </th>
                                    <th class="bg-primary"> Lain-Lain </th>
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
