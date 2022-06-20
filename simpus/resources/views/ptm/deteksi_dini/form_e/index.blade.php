@extends('layouts.table_ptm')
@section('title', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
@section('judultable', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
{{-- @section('subjudul', '(Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E))') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
@section('table_ptm')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="ml-3">Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas
                                (Form E)</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('form_e.form') }}" class="btn btn-primary b-r-xl"><i
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
                                <tr class="bg-primary">
                                    <th width="5%" class="align-middle bg-primary text-center" rowspan="3">No</th>
                                    <th class="align-middle bg-primary" rowspan="3">No. Reg</th>
                                    <th class="align-middle bg-primary" rowspan="3">Nama</th>
                                    <th class="align-middle bg-primary" rowspan="3">Umur</th>
                                    <th class="align-middle bg-primary" rowspan="3">Alamat</th>
                                    <th class="align-middle bg-primary" rowspan="3">Tgl. IVA</th>
                                    <th class="align-middle bg-primary" rowspan="1" colspan="2">IVA ulang Pra Krio</th>
                                    <th class="align-middle bg-primary" colspan="3">Pelaksanaan Krio</th>
                                    <th class="align-middle bg-primary" colspan="5">Alasan Kunjungan Ulang</th>
                                    <th class="align-middle bg-primary" rowspan="3">Keterangan</th>
                                    <th class="align-middle bg-primary" rowspan="3">Action</th>
                                    {{-- <th class="align-middle bg-primary" rowspan="3"><i class="fas fa-th"></i></th> --}}
                                </tr>
                                <tr class="bg-primary">
                                    <td class="align-middle bg-primary" rowspan="2">Positif</td>
                                    <td class="align-middle bg-primary" rowspan="2">Negatif</td>
                                    <td class="align-middle bg-primary" rowspan="2">Hari Ini</td>
                                    <td class="align-middle bg-primary" rowspan="2">
                                        < 1 bln </td> <td class="align-middle bg-primary" rowspan="2">> 1 bln
                                    </td>
                                    <td class="align-middle bg-primary" rowspan="2">Ada Keluhan</td>
                                    <td class="align-middle bg-primary" colspan="2">IVA Pasca krio 6 bln</td>
                                    <td class="align-middle bg-primary" colspan="2">IVA Pasca krio 1 thn</td>
                                </tr>
                                <tr class="bg-primary">
                                    <td class="align-middle bg-primary">Positif</td>
                                    <td class="align-middle bg-primary">Negatif</td>
                                    <td class="align-middle bg-primary">Positif</td>
                                    <td class="align-middle bg-primary">Negatif</td>
                                </tr>
                                <tr class="bg-primary font-weight-light">
                                    <?php
                                                                                                                                                            for($i = 1; $i <= 18; $i++ ) {
                                                                                                                                                            ?>
                                    <td class="align-middle bg-primary" style="opacity: 0.8;">[<?= $i ?>]</td>
                                    <?php } ?>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>11-Apr-2022</td>
                                    <td>A123123ZCD</td>
                                    <td>Panji</td>
                                    <td>23</td>
                                    <td>Jl.Kemiri 12</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
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
                    pageLength: 100,
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
