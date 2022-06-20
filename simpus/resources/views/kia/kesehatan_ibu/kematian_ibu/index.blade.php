@extends('layouts.table_kia')
@section('title', 'Data Kematian Ibu')
@section('judultable', 'Data Kematian Ibu')
{{-- @section('subjudul', '(Nama Data Kematian Ibu)') --}}
@section('menu1', 'Kesehatan Ibu')
@section('menu2', 'Data Kematian Ibu')
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
                            <h3 class="ml-3">ANC Terintegrasi</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class=" text-right">
                                <a href="{{ route('kematian_ibu.form') }}" class="btn btn-primary b-r-xl"><i
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
                                    <th rowspan="2" class="bg-primary">NAMA IBU</th>
                                    <th rowspan="2" class="bg-primary">NAMA SUAMI</th>
                                    <th rowspan="2" class="bg-primary">UMUR</th>
                                    <th rowspan="2" class="bg-primary">TK PENDIDIKAN</th>
                                    <th rowspan="2" class="bg-primary">WILAYAH PUSKESMAS</th>
                                    <th rowspan="2" class="bg-primary">ALAMAT LENGKAP</th>
                                    <th rowspan="2" class="bg-primary">TANGGAL KEMATIAN</th>
                                    <th rowspan="2" class="bg-primary">UMUR KEHAMILAN</th>
                                    <th colspan="3" class="bg-primary">PARITAS</th>
                                    <th colspan="2" class="bg-primary">ANC</th>
                                    <th rowspan="2" class="bg-primary">JARAK KEHAMILAN TERAKHIR</th>
                                    <th rowspan="2" class="bg-primary">STATUS PERKAWINAN KE</th>
                                    <th colspan="2" class="bg-primary">KELUHAN + RUJUKAN</th>
                                    <th rowspan="2" class="bg-primary">BIDAN 24 JAM DI DESA</th>
                                    <th colspan="4" class="bg-primary">SEBAB KEMATIAN</th>
                                    <th colspan="3" class="bg-primary">MENINGGAL SAAT</th>
                                    <th rowspan="2" class="bg-primary">PENYAKIT PENYERTA SEBELUMNYA</th>
                                    <th rowspan="2" class="bg-primary">SAAT ANC TERAKHIR SEBELUM INPARTU</th>
                                    <th colspan="3" class="bg-primary">PENOLONG PERSALINAN</th>
                                    <th colspan="6" class="bg-primary">TEMPAT PERSALINAN (SEBUTKAN )</th>
                                    <th colspan="6" class="bg-primary">TEMPAT KEMATIAN (SEBUTKAN )</th>
                                    <th colspan="2" class="bg-primary">MATI DI RS</th>
                                    <th colspan="3" class="bg-primary">Cara Persalinan</th>
                                    <th rowspan="2" class="bg-primary">KTD</th>
                                    <th rowspan="2" class="bg-primary">PENYEBAB TIDAK MASUK KEMATIAN</th>
                                    <th rowspan="2" class="bg-primary">Action</th>
                                </tr>
                                <tr class="text-white">
                                    <th class="bg-primary">G</th>
                                    <th class="bg-primary">P</th>
                                    <th class="bg-primary">A</th>
                                    <th class="bg-primary">FREK</th>
                                    <th class="bg-primary">LOKASI</th>
                                    <th class="bg-primary">SEBAB</th>
                                    <th class="bg-primary">Tujuan Rujukan</th>
                                    <th class="bg-primary">PERDARAHAN</th>
                                    <th class="bg-primary">INFEKSI</th>
                                    <th class="bg-primary">PREEKLAMPSI EKLAMPSI</th>
                                    <th class="bg-primary">LAIN-LAIN (sebutkan)</th>
                                    <th class="bg-primary">HAMIL</th>
                                    <th class="bg-primary">BERSALIN</th>
                                    <th class="bg-primary">NIFAS</th>
                                    <th class="bg-primary">DUKUN</th>
                                    <th class="bg-primary">BIDAN</th>
                                    <th class="bg-primary">DOKTER</th>
                                    <th class="bg-primary">RMH</th>
                                    <th class="bg-primary">JLN</th>
                                    <th class="bg-primary">BPM</th>
                                    <th class="bg-primary">RB</th>
                                    <th class="bg-primary">PUSK</th>
                                    <th class="bg-primary">RS</th>
                                    <th class="bg-primary">RMH</th>
                                    <th class="bg-primary">JLN</th>
                                    <th class="bg-primary">BPM</th>
                                    <th class="bg-primary">RB</th>
                                    <th class="bg-primary">PUSK</th>
                                    <th class="bg-primary">RS</th>
                                    <th class="bg-primary">&lt;48< /th> <th class="bg-primary">&gt;48</th>
                                    <th class="bg-primary">Normal</th>
                                    <th class="bg-primary">Vacum Ext</th>
                                    <th class="bg-primary">S C / Operasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Lisa Blackpink cantikku</td>
                                    <td>Panji</td>
                                    <td>23</td>
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
                                    <td>-</td>
                                    <td>-</td>
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
