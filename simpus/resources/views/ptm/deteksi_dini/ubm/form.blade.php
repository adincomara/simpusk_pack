@extends('layouts.table_ptm')
@section('title', 'Tambah UBM')
@section('judultable', 'Tambah UBM')
{{-- @section('subjudul', ' UBM)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Tambah UBM')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah UBM</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_ubm.index') }} "
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
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Klien
                                            Berkunjung</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Baru</label>
                                                        <input type="text" class="form-control rounded" id="klien_baru"
                                                            name="klien_baru" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Lama</label>
                                                        <input type="text" class="form-control rounded" id="klien_lama"
                                                            name="klien_lama" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Berhasil Berhenti
                                            Merokok</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">Car 4</label>
                                                        <input type="text" class="form-control rounded" id="car_4"
                                                            name="car_4" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Car 6</label>
                                                        <input type="text" class="form-control rounded" id="car_6"
                                                            name="car_6" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Car 9</label>
                                                        <input type="text" class="form-control rounded" id="car_9"
                                                            name="car_9" placeholder="" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Status Klien
                                            Berkunjung</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Rujuk</label>
                                                        <input type="text" class="form-control rounded" id="klien_rujuk"
                                                            name="klien_rujuk" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Kambuh</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="klien_kembuh" name="klien_kembuh" placeholder=""
                                                            value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Drop</label>
                                                        <input type="text" class="form-control rounded" id="klien_drop"
                                                            name="klien_drop" placeholder="" value="0">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Sukses</label>
                                                        <input type="text" class="form-control rounded"
                                                            id="klien_sukses" name="klien_sukses" placeholder=""
                                                            value="0">
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
