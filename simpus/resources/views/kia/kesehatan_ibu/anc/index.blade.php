@extends('layouts.table_kia')
@section('title', 'ANC Terintegrasi')
@section('judultable', 'ANC Terintegrasi')
{{-- @section('subjudul', 'ANC Terintegrasi') --}}
@section('menu1', 'Kesehatan Ibu')
@section('menu2', 'ANC Terintegrasi')
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
                                <tr class="text-white">
                                    <th rowspan="6" class="bg-primary">NO</th>
                                    <th rowspan="6" class="bg-primary">DESA</th>
                                    <th rowspan="2" class="bg-primary" colspan="3">Hb</th>
                                    <th rowspan="2" class="bg-primary" colspan="2">KEK</th>
                                    <th rowspan="2" class="bg-primary" colspan="2">Protein Urin</th>
                                    <th rowspan="2" class="bg-primary" colspan="2">Gula Darah (GD)</th>
                                    <th colspan="29" class="bg-primary">Integrasi Program</th>
                                    <th rowspan="2" class="bg-primary" colspan="5">Pelaksanaan kelas ibu hamil</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th colspan="7" class="bg-primary">Pencegahan Penularan HIV dari Ibu ke Anak (PPIA)
                                    </th>
                                    <th colspan="4" class="bg-primary">Pencegahan Malaria Dalam Kehamilan (PMDK)</th>
                                    <th colspan="3" class="bg-primary">TB dalam Kehamilan</th>
                                    <th colspan="3" class="bg-primary">Kecacingan dalam Kehamilan</th>
                                    <th colspan="9" class="bg-primary">Pencegahan IMS dalam Kehamilan</th>
                                    <th colspan="3" class="bg-primary">Pencegahan Hepatitis B dalam Kehamilan</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th rowspan="3" class="bg-primary">Diperiksa Hb</th>
                                    <th rowspan="3" class="bg-primary">Anemia (8-11 mg/dl)</th>
                                    <th rowspan="3" class="bg-primary">Anemia (&lt;8 mg/dl) </th>
                                    <th rowspan="3" class="bg-primary">Diperiksa LiLA</th>
                                    <th rowspan="3" class="bg-primary">KEK (LiLA &lt; 33,5 cm)</th>
                                    <th rowspan="3" class="bg-primary">Diperiksa</th>
                                    <th rowspan="3" class="bg-primary">Positif (+)</th>
                                    <th rowspan="3" class="bg-primary">Diperiksa</th>
                                    <th rowspan="3" class="bg-primary">GD >140 g/dl</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Datang dengan HIV(+)</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil ditawarkan Tes HIV</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil dites HIV</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Hasil Tes HIV (+)</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Mendapat ART</th>
                                    <th colspan="2" class="bg-primary">Ibu Hamil HIV(+)</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil mendapatkan kelambu</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Diperiksa Mikroskopis/RDT</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Malaria(+)</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil mendapatkan Kina/ ACT</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil diperiksa Dahak</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Hasil Dahak TB(+)</th>
                                    <th rowspan="3" class="bg-primary">Obat**</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil diperiksa Ankylostoma </th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Hasil Tes Ankylostoma (+) </th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil diobati</th>
                                    <th rowspan="2" class="bg-primary" colspan="3">Ibu Hamil diperiksa IMS</th>
                                    <th rowspan="2" class="bg-primary" colspan="3">Ibu Hamil Hasil Tes IMS (+)</th>
                                    <th rowspan="2" class="bg-primary" colspan="3">Ibu Hamil diobati</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil diperiksa Hepatitis B</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil Hasil Tes Hep B (+)</th>
                                    <th rowspan="3" class="bg-primary">Ibu Hamil diobati</th>
                                    <th rowspan="3" class="bg-primary">Puskesmas yang melaksanakan kelas ibu hamil</th>
                                    <th rowspan="3" class="bg-primary">Jumlah Kelas Ibu Hamil yang terbentuk</th>
                                    <th rowspan="3" class="bg-primary">Jumlah Ibu Hamil yang mengikuti kelas ibu hamil
                                    </th>
                                    <th rowspan="3" class="bg-primary">Jumlah suami/keluarga yang mengikuti kelas ibu
                                        hamil</th>
                                    <th rowspan="3" class="bg-primary">Jumlah bidan yang melakukan kelas ibu hamil</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th rowspan="2" class="bg-primary">Persalinan Pervaginam</th>
                                    <th rowspan="2" class="bg-primary">Persalinan Perabdominam (SC)</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th class="bg-primary">SIFILIS</th>
                                    <th class="bg-primary">GONORHEA</th>
                                    <th class="bg-primary">LAIN-LAIN</th>
                                    <th class="bg-primary">SIFILIS</th>
                                    <th class="bg-primary">GONORHEA</th>
                                    <th class="bg-primary">LAIN-LAIN</th>
                                    <th class="bg-primary">SIFILIS</th>
                                    <th class="bg-primary">GONORHEA</th>
                                    <th class="bg-primary">LAIN-LAIN</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <?php
                                                                    for ($i = 1; $i <= 43; $i++) {
                                                                        echo '<th class="bg-primary">' . $i . '</th>';
                                                                    }
                                                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Panunggalan</td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
                                    </td>
                                    <td><input type="text" class="text-datatable text-center" id="" name="" value="0">
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
