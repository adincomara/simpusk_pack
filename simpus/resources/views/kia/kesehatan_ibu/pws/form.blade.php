@extends('layouts.table_kia')
@section('title', 'Tambah PWS')
@section('judultable', 'Tambah PWS')
{{-- @section('subjudul', '(PWS)') --}}
@section('menu1', 'Master')
@section('menu2', 'Tambah PWS')
@section('table_kia')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3 bg-primary">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah PWS</h3>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('pws.index') }}"
                                class="btn btn-default btn-circle text-center text-dark"><i
                                    class="fa fa-chevron-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" action="#">
                        <div class="row px-3">
                            <div class="col-sm-4 b-r-xl border p-4" style="background: #f3f3f4">
                                <label class="col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 mt-3">
                                        <label class="">Desa</label>
                                        <select class="select2_desa form-control">
                                            <option value="">Masukan Nama Desa ....</option>
                                            <option value="1">Desa 1</option>
                                            <option value="2">Desa 2</option>
                                            <option value="3">Desa 3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <label class="">Periode</label>
                                        <div class="form-group" id="periode">
                                            <div class="input-group date">
                                                <input type="text" class="form-control input-group-addon rounded py-2"
                                                    name="periode" id="periode" autocomplete="off" value="Apr-2022">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 p-3">
                                <label class=" col-form-label font-bold">K1 & K4</label>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="">K1</label>
                                        <input type="text" class="form-control rounded" id="k1" name="k1" placeholder=""
                                            value="0.00">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="">K4</label>
                                        <input type="text" class="form-control rounded" id="k4" name="k4" placeholder=""
                                            value="0.00">
                                    </div>
                                </div>
                                <label class=" col-form-label font-bold">Deteksi Resiko Tinggi</label>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="">Masyarakat</label>
                                        <input type="text" class="form-control rounded" id="deteksi_resiko_masyarakat"
                                            name="deteksi_resiko_masyarakat" placeholder="" value="0.00">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="">Nakes</label>
                                        <input type="text" class="form-control rounded" id="nifas_ditangani"
                                            name="nifas_ditangani" placeholder="" value="0.00">
                                    </div>
                                </div>
                                <label class=" col-form-label font-bold">Kunjungan Lengkap, Persalinan dan Akses</label>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label class="">Kunjungan Lengkap</label>
                                        <input type="text" class="form-control rounded" id="kunjungan_lengkap"
                                            name="kunjungan_lengkap" placeholder="" value="0.00">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="">Persalinan Oleh Tenaga Kesehatan</label>
                                        <input type="text" class="form-control rounded" id="persalinan_oleh"
                                            name="persalinan_oleh" placeholder="" value="0.00">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="">Akses</label>
                                        <input type="text" class="form-control rounded" id="akses" name="akses"
                                            placeholder="" value="0.00">
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
                $('#periode .input-group.date').datepicker({
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
