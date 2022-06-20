@extends('layouts.table_ptm')
@section('title', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
@section('judultable', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
{{-- @section('subjudul', '(Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E))') --}}
@section('menu1', 'Master')
@section('menu2', 'Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Rekapitulasi Deteksi Dini Kanker Leher Rahim & Kanker Payudara di Puskesmas (Form E)
                            </h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('form_e.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" action="#">
                        <div class="row px-3">
                            <div class="col-sm-12">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Kabupaten</label>
                                        <div class="form-group col-md">
                                            <select class="select2_kab form-control" disabled>
                                                <option value="1">Kabupaten 1</option>
                                                <option value="2">Kabupaten 2</option>
                                                <option value="3">Kabupaten 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Puskesmas</label>
                                        <div class="form-group col-md">
                                            <select class="select2_pusk form-control" disabled>
                                                <option value="1">Puskesmas 1</option>
                                                <option value="2">Puskesmas 2</option>
                                                <option value="3">Puskesmas 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-6 col-sm-6 col-form-label">Periode Input</label>
                                        <div class="form-group col-md" id="periode_bln">
                                            <div class="input-group date">
                                                <span class="input-group-addon" style="">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control input-group-addon rounded py-2"
                                                    name="periode" id="periode" name="periode" autocomplete="off"
                                                    value="Apr-2022">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label font-bold">No.Reg</label>
                                        <div class="col-sm-12 form-group row">
                                            <div class="col-sm-12 row ">
                                                <div class="col-sm-12 ">
                                                    <input type="text" class="form-control rounded" id="jml_penduduk_l"
                                                        name="jml_penduduk_l" placeholder="" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-form-label font-bold">Nama</label>
                                        <div class="col-sm-12 form-group row">
                                            <div class="col-sm-12 row ">
                                                <div class="col-sm-12 ">
                                                    <input type="text" class="form-control rounded" id="jml_penduduk_l"
                                                        name="jml_penduduk_l" placeholder="" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-form-label font-bold">Umur</label>
                                        <div class="col-sm-12 form-group row">
                                            <div class="col-sm-12 row ">
                                                <div class="col-sm-12 ">
                                                    <input type="text" class="form-control rounded" id="jml_penduduk_l"
                                                        name="jml_penduduk_l" placeholder="" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-form-label font-bold">Alamat</label>
                                        <div class="col-sm-12 form-group row">
                                            <div class="col-sm-12 row ">
                                                <div class="col-sm-12 ">
                                                    <textarea name="" id="" cols="30" rows="5"
                                                        class="form-control rounded"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-6 col-form-label">Tanggal Berkunjung</label>
                                        <div class="col-sm-12 form-group row">
                                            <div class="col-sm-12 row ">
                                                <div class="col-sm-12 ">
                                                    <div class="form-group" id="tgl_berkunjung">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon" style="">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <input type="text"
                                                                class="form-control input-group-addon rounded py-2"
                                                                name="periode" id="periode" name="periode"
                                                                autocomplete="off" value="11-Apr-2022">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label font-bold">Keterangan</label>
                                        <div class="col-sm-12 ">
                                            <textarea name="" id="" cols="30" rows="5"
                                                class="form-control rounded"></textarea>
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label class="font-bold">Hasil IVA</label>
                                            <fieldset>
                                                <label class=" font-bold">Positif</label>
                                                <div class="checkbox checkbox-circle">
                                                    <input id="checkbox7" type="checkbox">
                                                    <label for="checkbox7">
                                                        Positif
                                                    </label>
                                                    <input id="checkbox7" type="checkbox">
                                                    <label for="checkbox7">
                                                        Negatif
                                                    </label>
                                                </div>
                                                <label class=" font-bold">Negatif</label>
                                                <div class="checkbox checkbox-circle">
                                                    <input id="checkbox7" type="checkbox">
                                                    <label for="checkbox7">
                                                        Simply Rounded
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="checkbox8" type="checkbox" checked="">
                                                    <label for="checkbox8">
                                                        Me too
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row px-4">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-sm" type="submit">Batal</button>
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
        <script>
            $(document).ready(function () {
                $('#periode_bln .input-group.date').datepicker({
                    minViewMode: 1,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "M-yyyy"
                });
                $(".select2_kab").select2();
                $(".select2_pusk").select2();
            });
        </script>
        @endpush
