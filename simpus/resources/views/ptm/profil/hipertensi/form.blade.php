@extends('layouts.table_ptm')
@section('title', 'Tambah SDM Terlatih')
@section('judultable', 'Tambah SDM Terlatih')
{{-- @section('subjudul', ' SDM Terlatih)') --}}
@section('menu1', 'Profil')
@section('menu2', 'Tambah SDM Terlatih')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah SDM Terlatih</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('profil_sdm.index') }} "
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
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">PANDU</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Pelatihan</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="pandu_pelatihan" name="pandu_pelatihan" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded" id="pandu_ojt"
                                                            name="pandu_ojt" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">POSBINDU</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">Kader Terlatih</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="posbindu_kader" name="posbindu_kader" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Posbindu KIT</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="posbindu_kit" name="posbindu_kit" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="posbindu_ojt" name="posbindu_ojt" placeholder=""
                                                            value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">IVA- SADANIS</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">Dokter</label>
                                                        <input type="text" class="form-control rounded" id="iva_"
                                                            name="iva_" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Bidan Terlatih</label>
                                                        <input type="text" class="form-control rounded" id="iva_bidan"
                                                            name="iva_bidan" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Jumlah Alat Krio</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="iva_alat_krio" name="iva_alat_krio" placeholder=""
                                                            value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">UBM</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">Tenaga terlatih</label>
                                                        <input type="text" class="form-control rounded" id="ubm_"
                                                            name="ubm_" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Sirometri/Peakflow</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="ubm_sirometri" name="ubm_sirometri" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded" id="ubm_ojt"
                                                            name="ubm_ojt" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">INDERA</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Pelatihan</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="indera_pelatihan" name="indera_pelatihan" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded" id="indera_ojt"
                                                            name="indera_ojt" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">KESWA</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Pelatihan</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="keswa_pelatihan" name="keswa_pelatihan" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">SDQ</label>
                                                        <input type="text" class="form-control rounded" id="keswa_sdq"
                                                            name="keswa_sdq" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">SRQ</label>
                                                        <input type="text" class="form-control rounded" id="keswa_srq"
                                                            name="keswa_srq" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Penatalaksana Gangguan Jiwa</label>
                                                        <input type="text" class="form-control rounded" id="keswa_jiwa"
                                                            name="keswa_jiwa" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded" id="keswa_ojt"
                                                            name="keswa_ojt" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">ASIST</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Pelatihan</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="assist_pelatihan" name="assist_pelatihan" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">OJT/Workshop</label>
                                                        <input type="text" class="form-control rounded" id="assist_ojt"
                                                            name="assist_ojt" placeholder="" value="0">
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
