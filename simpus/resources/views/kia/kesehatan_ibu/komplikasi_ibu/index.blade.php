@extends('layouts.table_kia')
@section('title', 'Komplikasi Ibu')
@section('judultable', 'Komplikasi Ibu')
{{-- @section('subjudul', '(Komplikasi Ibu)') --}}
@section('menu1', 'Kesehatan Ibu')
@section('menu2', 'Komplikasi Ibu')
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
                            <h3 class="ml-3">Data Komplikasi Ibu </h3>
                        </div>
                        <div class="ibox-tools">
                            <div class=" text-right">
                                <a href="{{ route('komplikasi_ibu.form') }}" class="btn btn-primary b-r-xl"><i
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
                        <div class="d-flex">
                            <div class="p-0">
                                <div class="form-group col-md" id="periode_bln">
                                    <p class="font-bold">Periode</p>
                                    <div class="input-group date">
                                        <span class="input-group-addon px-3 bg-primary rounded-left"><i
                                                class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control input-group-addon rounded-right py-2   "
                                            name="periode" id="periode" name="periode" autocomplete="off"
                                            value="Apr-2022">
                                    </div>
                                </div>
                            </div>
                            <div class="p-0">
                                <div class="form-group col-md">
                                    <p class="font-bold">Desa</p>
                                    <select class="select2_desa form-control ">
                                        <option value="">Masukan Nama Desa ....</option>
                                        <option value="1">Desa 1</option>
                                        <option value="2">Desa 2</option>
                                        <option value="3">Desa 3</option>
                                    </select>
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
                                    <th rowspan="3" class="bg-primary">NO</th>
                                    <th rowspan="3" class="bg-primary">DESA</th>
                                    <th colspan="40" class="bg-primary">KOMPLIKASI IBU</th>
                                    <th rowspan="3" class="bg-primary">Action</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th colspan="4" class="bg-primary">PENDARAHAN</th>
                                    <th colspan="4" class="bg-primary">INFEKSI</th>
                                    <th colspan="4" class="bg-primary">PRE EKLAMPSI</th>
                                    <th colspan="4" class="bg-primary">PARTUS LAMA</th>
                                    <th colspan="4" class="bg-primary">KETUBAN PECAH DINI</th>
                                    <th colspan="4" class="bg-primary">PREMATUR</th>
                                    <th colspan="4" class="bg-primary">ABORTUS</th>
                                    <th colspan="4" class="bg-primary">LAIN-LAIN</th>
                                    <th colspan="4" class="bg-primary">NIFAS</th>
                                    <th colspan="4" class="bg-primary">TOTAL</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <?php
                                                                    for ($i = 1; $i <= 10; $i++) {
                                                                    ?>
                                    <th class="bg-primary">DITEMUKAN</th>
                                    <th class="bg-primary">DITANGANI</th>
                                    <th class="bg-primary">DIRUJUK</th>
                                    <th class="bg-primary">MATI</th>
                                    <?php
                                                                    }
                                                                    ?>
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
                                        <div class='btn-group'>
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
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
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
                $(".select2_desa").select2();
            });
        </script>
        @endpush
