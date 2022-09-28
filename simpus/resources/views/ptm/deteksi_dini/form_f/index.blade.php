@extends('layouts.table_ptm')
@section('title', 'Rekapitulasi Pemeriksaan IVA-SADANIS per Golongan Umur (Form F)')
@section('judultable', 'Rekapitulasi Pemeriksaan IVA-SADANIS per Golongan Umur (Form F)')
{{-- @section('subjudul', '(Rekapitulasi Pemeriksaan IVA-SADANIS per Golongan Umur (Form F))') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Rekapitulasi Pemeriksaan IVA-SADANIS per Golongan Umur (Form F)')
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
                                {{-- <a href="{{ route('form_e.form') }}" class="btn btn-primary b-r-xl"><i
                                        class="fa fa-plus-circle"></i>&nbsp;
                                    Tambah</a> --}}
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
                                <tr>
                                    <th width="5%" class="align-middle bg-primary" rowspan="3">No</th>
                                    <th class="align-middle bg-primary" rowspan="3" style="width: 20%">Kelompok Umur
                                    </th>
                                    <th class="align-middle bg-primary" rowspan="3">Diperiksa</th>
                                    <th class="align-middle bg-primary" colspan="6">Hasil Leher Rahim</th>
                                    <th class="align-middle bg-primary" rowspan="2" colspan="4">Hasil Payudara</th>
                                    <th class="align-middle bg-primary" rowspan="2" colspan="3">Krioterapi</th>
                                    <th class="align-middle bg-primary" rowspan="2" colspan="3">Kunjungan Ulang</th>
                                    <th class="align-middle bg-primary" rowspan="4">Keterangan</th>
                                </tr>
                                <tr>
                                    <th class="align-middle bg-primary" colspan="2">Hasil IVA</th>
                                    <th class="align-middle bg-primary" colspan="4">Rujukan</th>
                                </tr>

                                <tr>
                                    <th class="align-middle bg-primary">+</th>
                                    <th class="align-middle bg-primary">-</th>
                                    <th class="align-middle bg-primary">IVA Ragu 2</th>
                                    <th class="align-middle bg-primary">Resi Luas</th>
                                    <th class="align-middle bg-primary">Curiga Ca</th>
                                    <th class="align-middle bg-primary">Kel. Gyn</th>
                                    <th class="align-middle bg-primary">Normal</th>
                                    <th class="align-middle bg-primary">Benjolan</th>
                                    <th class="align-middle bg-primary">Curiga Ca</th>
                                    <th class="align-middle bg-primary">Lain2</th>
                                    <th class="align-middle bg-primary">Hari yg sama</th>
                                    <th class="align-middle bg-primary">
                                        &lt;1bln </th>
                                    <th class="align-middle bg-primary"> >1bln
                                    </th>
                                    <th class="align-middle bg-primary">Ada Keluhan</th>
                                    <th class="align-middle bg-primary">6 bln</th>
                                    <th class="align-middle bg-primary">1 thn</th>
                                </tr>
                                <tr class="text-white text-center bg-green font-weight-light">
                                    <?php
                                                                                                                                                                                                                            for($i = 1; $i <= 19; $i++ ) {
                                                                                                                                                                                                                            ?>
                                    <td class="align-middle bg-primary" style="opacity: 0.8;">[
                                        <?= $i ?>]
                                    </td>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>&lt; 30 Tahun</td>
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
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>30 - 39 Tahun</td>
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
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>40 - 50 Tahun</td>
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
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>> 50 Tahun</td>
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
                                    <td>-</td>
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
