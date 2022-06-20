@extends('layouts.table_kia')
@section('title', 'Tambah Data Dasar')
@section('judultable', 'Tambah Data Dasar')
{{-- @section('subjudul', '(Data Dasar)') --}}
@section('menu1', 'Master')
@section('menu2', 'Tambah Data Dasar')
@section('table_kia')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3 bg-primary">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah Data Dasar</h3>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('datadasar.index') }}"
                                class="btn btn-default btn-circle text-center text-dark"><i
                                    class="fa fa-chevron-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" action="#">
                        <div class="row px-3">
                            <div class="col-sm-8">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Desa</label>
                                        <div class="form-group col-md">
                                            <select class="select2_desa form-control">
                                                <option value="">Masukan Nama Desa ....</option>
                                                <option value="1">Desa 1</option>
                                                <option value="2">Desa 2</option>
                                                <option value="3">Desa 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-6 col-sm-6 col-form-label">Periode Tahun</label>
                                        <div class="form-group col-md" id="periode_bln">
                                            <div class="input-group date">
                                                <input type="text" class="form-control input-group-addon rounded py-2"
                                                    name="periode" id="periode" name="periode" autocomplete="off"
                                                    value="2022">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">JUMLAH PENDUDUK</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki</label>
                                                <input type="text" class="form-control rounded" id="jml_penduduk_l"
                                                    name="jml_penduduk_l" placeholder="" value="0.00">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan</label>
                                                <input type="text" class="form-control rounded" id="jml_penduduk_p"
                                                    name="jml_penduduk_p" placeholder="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">CBR</label>
                                                <input type="text" class="form-control rounded" id="cbr" name="cbr"
                                                    placeholder="" value="0.00">
                                                <small class="form-text text-small text-danger text-right">NIlai CBR di
                                                    teteapkan oleh
                                                    Kabupaten</small>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">PUS</label>
                                                <input type="text" class="form-control rounded" id="pus" name="pus"
                                                    placeholder="" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">REMAJA</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-Laki Usia 10 - 14 Th</label>
                                                <input type="text" class="form-control rounded" id="remaja_10_14_l"
                                                    name="remaja_10_14_l" placeholder="" value="0.00">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan Usia 10 - 14 Th</label>
                                                <input type="text" class="form-control rounded" id="remaja_10_14_p"
                                                    name="remaja_10_14_p" placeholder="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-Laki Usia 15 - &lt;18 Th</label>
                                                <input type="text" class="form-control rounded" id="remaja_15_18_l"
                                                    name="remaja_15_18_l" placeholder="" value="0.00">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan Usia 15 - &lt;18 Th</label>
                                                <input type="text" class="form-control rounded" id="remaja_15_18_p"
                                                    name="remaja_15_18_p" placeholder="" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 b-r-xl border p-3">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">SASARAN</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Bumil</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="bumil" name="bumil"
                                                placeholder="" value="0.00" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Bulin</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="bulin" name="bulin"
                                                placeholder="" value="0.00" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Bayi</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="bayi" name="bayi"
                                                placeholder="" value="0.00" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">∑ Sasaran Bayi</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="sum_sasaran_bayi"
                                                name="sasaran_bayi" placeholder="" value="0.00" disabled>
                                            <small class="form-text text-small text-danger text-right">(0 - 11
                                                Bln)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">∑ Anak Balita</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="_sum_anak_balita"
                                                name="anak_balita" placeholder="" value="0.00" disabled>
                                            <small class="form-text text-small text-danger text-right">(12 - 59
                                                Bln)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-12 col-sm-12 col-form-label">∑ Anak Pra Sekolah</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="sum_anak_pra_sekolah"
                                                name="sum_anak_pra_sekolah" placeholder="" value="0.00">
                                            <small class="form-text text-small text-danger text-right">(60 - 72 Bln
                                                [Data Riil])</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 ">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">∑ SISWA</label>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Siswa TK/RA</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_siswa_tk_ra"
                                                name="jml_siswa_tk_ra" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Siswa SD/MI</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_siswa_sd_mi"
                                                name="jml_siswa_sd_mi" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Siswa SMP/MTs</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_siswa_smp_mts"
                                                name="jml_siswa_smp_mts" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Siswa SMA/MA/SMK</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_siswa_sma_ma_smk"
                                                name="jml_siswa_sma_ma_smk" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">∑ SEKOLAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Sekolah TK/RA</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_sekolah_tk_ra"
                                                name="jml_sekolah_tk_ra" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Sekolah SD/MI</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_sekolah_sd_mi"
                                                name="jml_sekolah_sd_mi" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Sekolah SMP/MTs</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_sekolah_smp_mts"
                                                name="jml_sekolah_smp_mts" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-sm-12 col-sm-12 col-form-label">Jml Sekolah SMA/MA/SMK</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control rounded" id="jml_sekolah_sma_ma_smk"
                                                name="jml_sekolah_sma_ma_smk" placeholder="" value="0.00">
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
                    minViewMode: 2,
                    keyboardNavigation: false,
                    forceParse: false,
                    forceParse: false,
                    autoclose: true,
                    todayHighlight: true,
                    format: "yyyy"
                });
                $(".select2_desa").select2();
            });
        </script>
        @endpush
