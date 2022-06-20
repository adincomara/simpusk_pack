@extends('layouts.table_ptm')
@section('title', 'Tambah SPM')
@section('judultable', 'Tambah SPM')
{{-- @section('subjudul', ' SPM)') --}}
@section('menu1', 'Indikator')
@section('menu2', 'Tambah SPM')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah SPM</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('indikator_spm.index') }} "
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
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PELAYANAN KESEHATAN
                                            USIA PRODUKTIF</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="uspro_sas"
                                                            name="uspro_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="uspro_real"
                                                            name="uspro_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PELAYANAN KESEHATAN
                                            PENDERITA HIPERTENSI</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="hipertensi_sas" name="hipertensi_sas" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="hipertensi_real" name="hipertensi_real" placeholder=""
                                                            value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PELAYANAN KESEHATAN
                                            PENDERITA DM</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="dm_sas"
                                                            name="dm_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="dm_real"
                                                            name="dm_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PELAYANAN KESEHATAN
                                            ODGJ</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="odgj_sas"
                                                            name="odgj_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="odgj_real"
                                                            name="odgj_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PUSK YANG
                                            MELAKSANAKAN DETEKSI DINI FR PTM</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="fr_sas"
                                                            name="fr_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="fr_real"
                                                            name="fr_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PUSK YANG
                                            MELAKSANAKAN DETEKSI DINI PENGLIHATAN DAN PENDENGARAN</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="indera_sas"
                                                            name="indera_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="indera_real"
                                                            name="indera_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PUSK YANG
                                            MELAKSANAKAN LAYANAN POSBINDU PTM</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="posbindu_sas" name="posbindu_sas" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="posbindu_real" name="posbindu_real" placeholder=""
                                                            value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PUSK YANG
                                            MELAKSANAKAN LAYANAN DETEKSI DINI KANKER PAYUDARA DAN CA SERVIK DG METODE
                                            IVA</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="kanker_sas"
                                                            name="kanker_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="kanker_real"
                                                            name="kanker_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PUSK MELAKSANAKAN
                                            YANKES DAN ATAU NAPZA</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sasaran</label>
                                                        <input type="text" class="form-control rounded" id="napza_sas"
                                                            name="napza_sas" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Realisasi</label>
                                                        <input type="text" class="form-control rounded" id="napza_real"
                                                            name="napza_real" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
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
