@extends('layouts.table_kia')
@section('title', 'Tambah Data Kematian IBU')
@section('judultable', 'Tambah Data Kematian IBU')
{{-- @section('subjudul', '(Data Kematian IBU)') --}}
@section('menu1', 'Master')
@section('menu2', 'Tambah Data Kematian IBU')
@section('table_kia')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3 bg-primary">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah Data Kematian IBU</h3>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('kematian_ibu.index') }}"
                                class="btn btn-default btn-circle text-center text-dark"><i
                                    class="fa fa-chevron-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" action="#">
                        <div class="row px-3">
                            <div class="col-sm-8 b-r-xl border p-3" style="background: #f3f3f4">
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">BIODATA SUAMI DAN
                                    ISTRI</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">Nama Ibu</label>
                                                <input type="text" class="form-control rounded" id="nama_ibu"
                                                    name="nama_ibu" placeholder="" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Nama Suami</label>
                                                <input type="text" class="form-control rounded" id="nama_suami"
                                                    name="nama_suami" placeholder="" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Umur</label>
                                                <input type="text" class="form-control rounded" id="umur" name="umur"
                                                    placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-4">
                                                <label class="">TK Pendidikan</label>
                                                <select class="select2_pendidikan form-control">
                                                    <option value="">Pilih Pendidikan ....</option>
                                                    <option value="BELUM/TIDAK SEKOLAH">BELUM/TIDAK SEKOLAH</option>
                                                    <option value="SD">SD</option>
                                                    <option value="SMP/Sederajat">SMP/Sederajat</option>
                                                    <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                                    <option value="Diploma">Diploma</option>
                                                    <option value="Sarjana">Sarjana</option>
                                                    <option value="Magister">Magister</option>
                                                    <option value="Doktor">Doktor</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Tanggal Kematian</label>
                                                <div class="form-group" id="tgl_kematian">
                                                    <div class="input-group date">
                                                        <input type="text"
                                                            class="form-control input-group-addon rounded py-2"
                                                            name="tgl_kematian" id="tgl_kematian" autocomplete="off"
                                                            value="07-04-2022">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="">Umur Kehamilan</label>
                                                <input type="text" class="form-control rounded" id="umur_kehamilan"
                                                    name="umur_kehamilan" placeholder="" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-12">
                                                <label class="">Wilayah Puskesmas</label>
                                                <input type="text" class="form-control rounded" id="wilayah_pusk"
                                                    name="wilayah_pusk" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-12">
                                                <label class="">Alamat</label>
                                                <textarea class="form-control rounded" name="alamat" id="alamat"
                                                    cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">DATA KASUS</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto">
                                        <div class="col-sm-12 d-flex justify-content-between">
                                            <div class="pr-2">
                                                <label class="">Paritas G</label>
                                                <input type="text" class="form-control rounded" id="paritas_g"
                                                    name="paritas_g" placeholder="" value="">
                                            </div>
                                            <div class="px-2">
                                                <label class="">Paritas P</label>
                                                <input type="text" class="form-control rounded" id="paritas_p"
                                                    name="paritas_p" placeholder="" value="">
                                            </div>
                                            <div class="pl-2">
                                                <label class="">Paritas A</label>
                                                <input type="text" class="form-control rounded" id="paritas_a"
                                                    name="paritas_a" placeholder="" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">ANC</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-12 my-2">
                                            <label class="">ANC Frek</label>
                                            <input type="text" class="form-control rounded" id="anc_frek"
                                                name="anc_frek" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-12 my-2 ">
                                            <label class="">ANC Lokasi</label>
                                            <input type="text" class="form-control rounded" id="anc_lokasi"
                                                name="anc_lokasi" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-12 my-2">
                                            <label class="">Jarak Kehamilan Terakhir</label>
                                            <input type="text" class="form-control rounded" id="jarak_kehamilan"
                                                name="jarak_kehamilan" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-12 my-2 ">
                                            <label class="">Status Perkawinan Ke</label>
                                            <input type="text" class="form-control rounded" id="status_perkawinan"
                                                name="status_perkawinan" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">KELUHAN + RUJUKAN</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-4">
                                            <label class="">Penyebab</label>
                                            <input type="text" class="form-control rounded" id="penyebab"
                                                name="penyebab" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="">Rujukan Ke</label>
                                            <input type="text" class="form-control rounded" id="rujuk_ke"
                                                name="rujuk_ke" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="">Bidan 24 Jam Desa</label>
                                            <input type="text" class="form-control rounded" id="bidan_desa"
                                                name="bidan_desa" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-6">
                                            <label class="">Sebab Kematian</label>
                                            <select class="select2_sebab_kematian form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Pendarahan">Pendarahan</option>
                                                <option value="Infeksi">Infeksi</option>
                                                <option value="Preklampsi Eklampsi">Preklampsi Eklampsi</option>
                                                <option value="Lain-lain">Lain-lain</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="">Meninggal Saat</label>
                                            <select class="select2_meninggal_saat form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Hamil">Hamil</option>
                                                <option value="Bersalin">Bersalin</option>
                                                <option value="Nifas">Nifas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-6">
                                            <label class="">Penyakit Penyerta Sebelumnya</label>
                                            <input type="text" class="form-control rounded" id="remaja_10_14_l"
                                                name="remaja_10_14_l" placeholder="" value="">
                                        </div>
                                        <div class="col-sm-6 ">
                                            <label class="">Saat ANC Terakhir Sebelum Inpartu</label>
                                            <input type="text" class="form-control rounded" id="remaja_10_14_l"
                                                name="remaja_10_14_l" placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-4">
                                            <label class="">Penolong Persalinan</label>
                                            <select class="select2_sebab_kematian form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Belum Melahirkan">Belum Melahirkan</option>
                                                <option value="Dukun">Dukun</option>
                                                <option value="Bidan">Bidan</option>
                                                <option value="Dokter">Dokter </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="">Tempat Persalinan</label>
                                            <select class="select2_meninggal_saat form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Rumah">Rumah</option>
                                                <option value="Jalan">Jalan</option>
                                                <option value="BPM">BPM</option>
                                                <option value="RB">RB</option>
                                                <option value="Puskesmas">Puskesmas</option>
                                                <option value="Rumah Sakit">Rumah Sakit</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="">Tempat Kematian</label>
                                            <select class="select2_meninggal_saat form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Rumah">Rumah</option>
                                                <option value="Jalan">Jalan</option>
                                                <option value="BPM">BPM</option>
                                                <option value="RB">RB</option>
                                                <option value="Puskesmas">Puskesmas</option>
                                                <option value="Rumah Sakit">Rumah Sakit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-4">
                                            <label class="">Wakti Kematian di RS</label>
                                            <select class="select2_sebab_kematian form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="<45">&lt;45</option>
                                                <option value=">45">&gt;45</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="">Cara Persalinan</label>
                                            <select class="select2_meninggal_saat form-control">
                                                <option value="">Pilih ....</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Vacum Ext">Vacum Ext</option>
                                                <option value="SC/Operasi">SC/Operasi</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="">KTD</label>
                                            <input type="text" class="form-control rounded" id="ktd" name="ktd"
                                                placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-12">
                                            <label class="">Penyebab tidak masuk kematian</label>
                                            <input type="text" class="form-control rounded" id="penyebab_tidak_kematian"
                                                name="penyebab_tidak_kematian" placeholder="" value="">
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
                $('#tgl_kematian .input-group.date').datepicker({
                    minViewMode: 0,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "dd-mm-yyyy"
                });
                $(".select2_pendidikan").select2();
                $(".select2_sebab_kematian").select2();
                $(".select2_meninggal_saat").select2();
            });
        </script>
        @endpush
