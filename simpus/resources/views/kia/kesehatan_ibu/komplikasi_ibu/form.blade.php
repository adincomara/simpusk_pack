@extends('layouts.table_kia')
@section('title', 'Tambah Data Komplikasi Ibu')
@section('judultable', 'Tambah Data Komplikasi Ibu')
{{-- @section('subjudul', '(Data Komplikasi IBU)') --}}
@section('menu1', 'Master')
@section('menu2', 'Tambah Data Komplikasi IBU')
@section('table_kia')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3 bg-primary">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah Data Komplikasi IBU</h3>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('komplikasi_ibu.index') }}"
                                class="btn btn-default btn-circle text-center text-dark"><i
                                    class="fa fa-chevron-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" action="#">
                        <div class="row px-3">
                            <div class="col-sm-12 b-r-xl border pt-2" style="background: #f3f3f4">
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Desa</label>
                                                <select class="select2_desa form-control">
                                                    <option value="">Masukan Nama Desa ....</option>
                                                    <option value="1">Desa 1</option>
                                                    <option value="2">Desa 2</option>
                                                    <option value="3">Desa 3</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Periode</label>
                                                <div class="form-group" id="periode">
                                                    <div class="input-group date">
                                                        <input type="text"
                                                            class="form-control input-group-addon rounded py-2"
                                                            name="periode" id="periode" autocomplete="off"
                                                            value="Apr-2022">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">PENDARAHAN</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="pendarahan_ditemukan"
                                                name="pendarahan_ditemukan" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="pendarahan_ditangani"
                                                name="pendarahan_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="pendarahan_dirujuk"
                                                name="pendarahan_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="pendarahan_mati"
                                                name="pendarahan_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">INFEKSI</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="infeksi_ditemuakn"
                                                name="infeksi_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="infeksi_ditangani"
                                                name="infeksi_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="infeksi_dirujuk"
                                                name="infeksi_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="infeksi_mati"
                                                name="infeksi_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">PRE EKLAMPSI</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="eklampsi_ditemuakn"
                                                name="eklampsi_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="eklampsi_ditangani"
                                                name="eklampsi_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="eklampsi_dirujuk"
                                                name="eklampsi_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="eklampsi_mati"
                                                name="eklampsi_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">PARTUS LAMA</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="partus_ditemuakn"
                                                name="partus_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="partus_ditangani"
                                                name="partus_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="partus_dirujuk"
                                                name="partus_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="partus_mati"
                                                name="partus_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">KETUBAN PECAH DINI</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="ketuban_pecah_ditemuakn"
                                                name="ketuban_pecah_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="ketuban_pecah_ditangani"
                                                name="ketuban_pecah_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="ketuban_pecah_dirujuk"
                                                name="ketuban_pecah_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="ketuban_pecah_mati"
                                                name="ketuban_pecah_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">PREMATUR</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="prematur_ditemuakn"
                                                name="prematur_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="prematur_ditangani"
                                                name="prematur_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="prematur_dirujuk"
                                                name="prematur_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="prematur_mati"
                                                name="prematur_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">ABORTUS</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="abortus_ditemuakn"
                                                name="abortus_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="abortus_ditangani"
                                                name="abortus_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="abortus_dirujuk"
                                                name="abortus_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="abortus_mati"
                                                name="abortus_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">LAIN-LAIN</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="lainnya_ditemuakn"
                                                name="lainnya_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="lainnya_ditangani"
                                                name="lainnya_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="lainnya_dirujuk"
                                                name="lainnya_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="lainnya_mati"
                                                name="lainnya_mati" placeholder="" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">NIFAS</label>
                                <div class="form-group row">
                                    <div class="col-sm-12 m-auto row">
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditemukan</label>
                                            <input type="text" class="form-control rounded" id="nifas_ditemuakn"
                                                name="nifas_ditemuakn" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Ditangani</label>
                                            <input type="text" class="form-control rounded" id="nifas_ditangani"
                                                name="nifas_ditangani" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Dirujuk</label>
                                            <input type="text" class="form-control rounded" id="nifas_dirujuk"
                                                name="nifas_dirujuk" placeholder="" value="0.00">
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <label class="">Mati</label>
                                            <input type="text" class="form-control rounded" id="nifas_mati"
                                                name="nifas_mati" placeholder="" value="0.00">
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
