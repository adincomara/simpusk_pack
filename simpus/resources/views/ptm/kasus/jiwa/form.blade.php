@extends('layouts.table_ptm')
@section('title', 'Tambah Kasus Gangguan Jiwa')
@section('judultable', 'Tambah Kasus Gangguan Jiwa')
{{-- @section('subjudul', '(Kasus Gangguan Jiwa)') --}}
@section('menu1', 'Master')
@section('menu2', 'Tambah Kasus Gangguan Jiwa')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah Kasus Gangguan Jiwa</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('kasus_jiwa.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" id="submitData">
                        {{ csrf_field() }}
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($ptm)? $enc_id : ''}}">
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
                                                <input type="text" class="form-control input-group-addon rounded py-2" value="{{isset($ptm)? $ptm->date_periode : $date_now}}" name="periode" id="periode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">DEMENSIA F00</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki</label>
                                                <input type="text" class="form-control rounded" name="demensia_l"
                                                id="demensia_l" value="{{isset($ptm)? $ptm->demensia_l : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan</label>
                                                <input type="text" class="form-control rounded" name="demensia_p"
                                                id="demensia_p" value="{{isset($ptm)? $ptm->demensia_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN ANSIETAS
                                    F.40</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_0_14_l" id="g_ansietas_0_14_l" value="{{isset($ptm)? $ptm->g_ansietas_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_0_14_p" id="g_ansietas_0_14_p" value="{{isset($ptm)? $ptm->g_ansietas_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_15_59_l" id="g_ansietas_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_ansietas_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_15_59_p" id="g_ansietas_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_ansietas_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_60_l"
                                                id="g_ansietas_60_l"
                                                value="{{isset($ptm)? $ptm->g_ansietas_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_60_p"
                                                id="g_ansietas_60_p"
                                                value="{{isset($ptm)? $ptm->g_ansietas_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN CAMPURAN ANSIETAS
                                    DAN DEPRESI F41.2</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_depresi_0_14_l" id="g_ansietas_depresi_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_depresi_0_14_p" id="g_ansietas_depresi_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_depresi_15_59_l"
                                                id="g_ansietas_depresi_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_ansietas_depresi_15_59_p"
                                                id="g_ansietas_depresi_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded"  name="g_ansietas_depresi_60_l" id="g_ansietas_depresi_60_l"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded"  name="g_ansietas_depresi_60_p" id="g_ansietas_depresi_60_p"
                                                value="{{isset($ptm)? $ptm->g_ansietas_depresi_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN DEPRESI
                                    F.32</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_0_14_l"
                                                id="g_depresi_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_depresi_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_0_14_p"
                                                id="g_depresi_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_depresi_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_15_59_l" id="g_depresi_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_depresi_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_15_59_p" id="g_depresi_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_depresi_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_60_l"
                                                id="g_depresi_60_l"
                                                value="{{isset($ptm)? $ptm->g_depresi_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_depresi_60_p"
                                                id="g_depresi_60_p"
                                                value="{{isset($ptm)? $ptm->g_depresi_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN PENYALAHGUNAAN
                                    NAPZA F10#</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_0_14_l"
                                                id="g_penyalahgunaan_napza_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_0_14_p"
                                                id="g_penyalahgunaan_napza_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_15_59_l"
                                                id="g_penyalahgunaan_napza_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_15_59_p"
                                                id="g_penyalahgunaan_napza_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_60_l"
                                                id="g_penyalahgunaan_napza_60_l"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_penyalahgunaan_napza_60_p"
                                                id="g_penyalahgunaan_napza_60_p"
                                                value="{{isset($ptm)? $ptm->g_penyalahgunaan_napza_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN PERKEMBANGAN PADA
                                    ANAK DAN REMAJA F80-90#</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_0_14_l" id="g_anak_remaja_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_0_14_p" id="g_anak_remaja_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_15_59_l" id="g_anak_remaja_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_15_59_p" id="g_anak_remaja_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_60_l" id="g_anak_remaja_60_l"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_anak_remaja_60_p" id="g_anak_remaja_60_p"
                                                value="{{isset($ptm)? $ptm->g_anak_remaja_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN PSIKOTIK AKUT
                                    F21#</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_0_14_l" id="g_psikotik_akut_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_0_14_p" id="g_psikotik_akut_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_15_59_l" id="g_psikotik_akut_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_15_59_p" id="g_psikotik_akut_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_60_l" id="g_psikotik_akut_60_l"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_psikotik_akut_60_p" id="g_psikotik_akut_60_p"
                                                value="{{isset($ptm)? $ptm->g_psikotik_akut_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">SKIZOFRENIA F22</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_0_14_l" id="skizofrenia_0_14_l"
                                                value="{{isset($ptm)? $ptm->skizofrenia_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_0_14_p" id="skizofrenia_0_14_p"
                                                value="{{isset($ptm)? $ptm->skizofrenia_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_15_59_l" id="skizofrenia_15_59_l"
                                                value="{{isset($ptm)? $ptm->skizofrenia_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_15_59_p" id="skizofrenia_15_59_p"
                                                value="{{isset($ptm)? $ptm->skizofrenia_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_60_l"
                                                id="skizofrenia_60_l"
                                                value="{{isset($ptm)? $ptm->skizofrenia_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="skizofrenia_60_p"
                                                id="skizofrenia_60_p"
                                                value="{{isset($ptm)? $ptm->skizofrenia_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN SOMATOFORM
                                    F45</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_0_14_l" id="g_somatoform_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_somatoform_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_0_14_p" id="g_somatoform_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_somatoform_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_15_59_l" id="g_somatoform_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_somatoform_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_15_59_p" id="g_somatoform_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_somatoform_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_60_l" id="g_somatoform_60_l"
                                                value="{{isset($ptm)? $ptm->g_somatoform_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_somatoform_60_p" id="g_somatoform_60_p"
                                                value="{{isset($ptm)? $ptm->g_somatoform_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">INSOMNIA F51.0</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_0_14_l"
                                                id="insomnia_0_14_l"
                                                value="{{isset($ptm)? $ptm->insomnia_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_0_14_p"
                                                id="insomnia_0_14_p"
                                                value="{{isset($ptm)? $ptm->insomnia_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_15_59_l"
                                                id="insomnia_15_59_l"
                                                value="{{isset($ptm)? $ptm->insomnia_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_15_59_p"
                                                id="insomnia_15_59_p"
                                                value="{{isset($ptm)? $ptm->insomnia_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_60_l"
                                                id="insomnia_60_l"
                                                value="{{isset($ptm)? $ptm->insomnia_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="insomnia_60_p"
                                                id="insomnia_60_p"
                                                value="{{isset($ptm)? $ptm->insomnia_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">PERCOBAAN BUNUH DIRI</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_0_14_l"
                                                id="percobaan_bunuh_diri_0_14_l"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_0_14_p"
                                                id="percobaan_bunuh_diri_0_14_p"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_15_59_l"
                                                id="percobaan_bunuh_diri_15_59_l"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_15_59_p"
                                                id="percobaan_bunuh_diri_15_59_p"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_60_l" id="percobaan_bunuh_diri_60_l"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="percobaan_bunuh_diri_60_p" id="percobaan_bunuh_diri_60_p"
                                                value="{{isset($ptm)? $ptm->percobaan_bunuh_diri_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">REDARTASI MENTAL F.70 -
                                    F.79</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_0_14_l" id="redartasi_mental_0_14_l"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_0_14_p" id="redartasi_mental_0_14_p"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_15_59_l" id="redartasi_mental_15_59_l"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_15_59_p" id="redartasi_mental_15_59_p"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_60_l" id="redartasi_mental_60_l"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="redartasi_mental_60_p" id="redartasi_mental_60_p"
                                                value="{{isset($ptm)? $ptm->redartasi_mental_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">GANGGUAN KEPRIBADIAN DAN
                                    PERILAKU F.60-F.61</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_0_14_l"
                                                id="g_kepribadian_perilaku_0_14_l"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_0_14_l : 0}}">
                                                <label class="">Perempuan 0 - 14 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_0_14_p"
                                                id="g_kepribadian_perilaku_0_14_p"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_0_14_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_15_59_l"
                                                id="g_kepribadian_perilaku_15_59_l"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_15_59_l : 0}}">
                                                <label class="">Perempuan 15 - 59 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_15_59_p"
                                                id="g_kepribadian_perilaku_15_59_p"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_15_59_p : 0}}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Laki-laki >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_60_l"
                                                id="g_kepribadian_perilaku_60_l"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_60_l : 0}}">
                                                <label class="">Perempuan >= 60 th</label>
                                                <input type="text" class="form-control rounded" name="g_kepribadian_perilaku_60_p"
                                                id="g_kepribadian_perilaku_60_p"
                                                value="{{isset($ptm)? $ptm->g_kepribadian_perilaku_60_p : 0}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row px-4">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{route('kasus_jiwa.index')}}" class="btn btn-white btn-sm" type="submit">Batal</a>
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                $('#submitData').validate({
                    rules: {
                        name:{
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Departemen tidak boleh kosong"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');

                    element.closest('.error-text').append(error);

                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                    Swal.showLoading();
                    SimpanData();
                    }
                });
                function SimpanData(){
                    $('#simpan').addClass("disabled");
                        var form = $('#submitData').serializeArray()
                        var dataFile = new FormData()
                        $.each(form, function(idx, val) {
                            dataFile.append(val.name, val.value)
                        })
                    $.ajax({
                        type: 'POST',
                        url : "{{route('kasus_jiwa.simpan')}}",
                        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                        data:dataFile,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        beforeSend: function () {
                            Swal.showLoading();
                        },
                        success: function(data){
                            if (data.success) {
                                Swal.fire('Yes',data.message,'info');
                                window.location.replace('{{route("kasus_jiwa.index")}}');
                            } else {
                                Swal.fire('Ups',data.message,'info');
                            }
                            Swal.hideLoading();
                        },
                        complete: function () {
                            Swal.hideLoading();
                            $('#simpan').removeClass("disabled");
                        },
                        error: function(data){
                            $('#simpan').removeClass("disabled");
                            Swal.hideLoading();
                            Swal.fire('Ups','Ada kesalahan pada sistem','info');
                            console.log(data);
                        }
                    });
                }


                $('#periode_bln .input-group.date').datepicker({
                    minViewMode: 1,
                    keyboardNavigation: false,
                    forceparse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "M-yyyy"
                });
            });
        </script>
        @endpush
