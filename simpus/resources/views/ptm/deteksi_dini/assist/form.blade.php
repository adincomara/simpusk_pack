@extends('layouts.table_ptm')
@section('title', 'Tambah ASSIST')
@section('judultable', 'Tambah ASSIST')
{{-- @section('subjudul', '(ASSIST)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Tambah ASSIST')
@section('table_ptm')
<style>
    .text_clamp {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah ASSIST</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_assist.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($assist)? $enc_id : ''}}">
                        <div class="row px-3">
                            <div class="col-sm-12">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Kabupaten</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control py-2" name="kab" id="kab"
                                        value="{{ isset($puskesmas)? $puskesmas->kabupaten : ''}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Puskesmas</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control py-2" name="pusk" id="pusk"
                                        value="{{ isset($puskesmas)? $puskesmas->name : ''}}" disabled>
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
                                                autocomplete="off"
                                                value="{{isset($assist)? $assist->date_periode : $date_now}}"
                                                name="periode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Sekolah yang
                                            telah dilakukan Skrining ASSIST</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control rounded"
                                                        name="jml_sklh_skrining_assist"
                                                        id="jml_sklh_skrining_assist"
                                                        value="{{ isset($assist)? $assist->jml_sklh_skrining_assist : 0  }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Peserta
                                            Skrining ASSIST</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Puskesmas | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="jml_peserta_pusk_l" id="jml_peserta_pusk_l"
                                                        value="{{ isset($assist)? $assist->jml_peserta_pusk_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Puskesmas | Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="jml_peserta_pusk_p" id="jml_peserta_pusk_p"
                                                        value="{{ isset($assist)? $assist->jml_peserta_pusk_p : 0 }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Sekolah | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="jml_peserta_sklh_l" id="jml_peserta_sklh_l"
                                                        value="{{ isset($assist)? $assist->jml_peserta_sklh_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Sekolah |Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="jml_peserta_sklh_p" id="jml_peserta_sklh_p"
                                                        value="{{ isset($assist)? $assist->jml_peserta_sklh_p : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Hasil Skrining
                                            ASSIST</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Ringan | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="skrining_ringan_l" id="skrining_ringan_l"
                                                        value="{{ isset($assist)? $assist->skrining_ringan_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Ringan | Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="skrining_ringan_p" id="skrining_ringan_p"
                                                        value="{{ isset($assist)? $assist->skrining_ringan_p : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Sedang | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="skrining_sedang_l" id="skrining_sedang_l"
                                                        value="{{ isset($assist)? $assist->skrining_sedang_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Sedang | Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="skrining_sedang_p" id="skrining_sedang_p"
                                                        value="{{ isset($assist)? $assist->skrining_sedang_p : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Berat | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="skrining_berat_l" id="skrining_berat_l"
                                                        value="{{ isset($assist)? $assist->skrining_berat_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Berat | Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="skrining_berat_p" id="skrining_berat_p"
                                                        value="{{ isset($assist)? $assist->skrining_berat_p : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Tindak lanjut
                                            Skrining ASSIST</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Rujuk | Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="tindak_skrining_rujuk_l" id="tindak_skrining_rujuk_l"
                                                        value="{{ isset($assist)? $assist->tindak_skrining_rujuk_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Rujuk | Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="tindak_skrining_rujuk_p" id="tindak_skrining_rujuk_p"
                                                        value="{{ isset($assist)? $assist->tindak_skrining_rujuk_p : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Pelayanan Langsung | Laki-laki</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="tindak_skrining_langsung_l"
                                                        id="tindak_skrining_langsung_l"
                                                        value="{{ isset($assist)? $assist->tindak_skrining_langsung_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Pelayanan Langsung | Perempuan</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="tindak_skrining_langsung_p"
                                                        id="tindak_skrining_langsung_p"
                                                        value="{{ isset($assist)? $assist->tindak_skrining_langsung_p : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jenis Zat Yang
                                            digunakan</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12 text_clamp">Produk tembakau (rokok,cerutu,
                                                    kretek, dll.)
                                                </label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="tembakau_l"
                                                            id="tembakau_l"
                                                            value="{{ isset($assist)? $assist->tembakau_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="tembakau_p"
                                                            id="tembakau_p"
                                                            value="{{ isset($assist)? $assist->tembakau_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Minuman beralkohol
                                                    (bir, anggur, sopi, tomi, dll.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="alkohol_l"
                                                            id="alkohol_l"
                                                            value="{{ isset($assist)? $assist->alkohol_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="alkohol_p"
                                                            id="alkohol_p"
                                                            value="{{ isset($assist)? $assist->alkohol_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Kanabis
                                                    (marijuana, ganja, gelek,
                                                    cimengpot, dll.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="kanabis_l"
                                                            id="kanabis_l"
                                                            value="{{ isset($assist)? $assist->kanabis_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="kanabis_p"
                                                            id="kanabis_p"
                                                            value="{{ isset($assist)? $assist->kanabis_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Kokain
                                                    (coke, crack, etc.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="kokain_l"
                                                            id="kokain_l"
                                                            value="{{ isset($assist)? $assist->kokain_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="kokain_p"
                                                            id="kokain_p"
                                                            value="{{ isset($assist)? $assist->kokain_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Stimulan jenis amfetamin
                                                    (ekstasi, shabu, dll)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="stimulan_l"
                                                            id="stimulan_l"
                                                            value="{{ isset($assist)? $assist->stimulan_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="stimulan_p"
                                                            id="stimulan_p"
                                                            value="{{ isset($assist)? $assist->stimulan_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Inhalansia
                                                    (lem, bensin, tiner, dll)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="inhalansia_l"
                                                            id="inhalansia_l"
                                                            value="{{ isset($assist)? $assist->inhalansia_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="inhalansia_p"
                                                            id="inhalansia_p"
                                                            value="{{ isset($assist)? $assist->inhalansia_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Sedativa atau obat tidur
                                                    (Benzodiazepin, Lexotan,
                                                    Rohypnol, Mogadon, dll.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="sedatif_l"
                                                            id="sedatif_l"
                                                            value="{{ isset($assist)? $assist->sedatif_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="sedatif_p"
                                                            id="sedatif_p"
                                                            value="{{ isset($assist)? $assist->sedatif_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Halusinogens
                                                    (LSD, mushrooms, PCP, dll.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="halusinogen_l" id="halusinogen_l"
                                                            value="{{ isset($assist)? $assist->halusinogen_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="halusinogen_p" id="halusinogen_p"
                                                            value="{{ isset($assist)? $assist->halusinogen_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Opioida
                                                    (heroin, morfin, metadon,
                                                    kodein, dll.)</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="opioida_l"
                                                            id="opioida_l"
                                                            value="{{ isset($assist)? $assist->opioida_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="opioida_p"
                                                            id="opioida_p"
                                                            value="{{ isset($assist)? $assist->opioida_p : 0 }}">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 text_clamp">Zat lain</label>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Laki-laki</label>
                                                        <input type="text" class="form-control rounded" name="lain_l"
                                                            id="lain_l"
                                                            value="{{ isset($assist)? $assist->lain_l : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="text_clamp">Perempuan</label>
                                                        <input type="text" class="form-control rounded" name="lain_p"
                                                            id="lain_p"
                                                            value="{{ isset($assist)? $assist->lain_p : 0 }}">
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
                                <a href="{{route('dd_assist.index')}}" class="btn btn-white btn-sm">Batal</a>
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
            var table,tabledata,table_index;
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
                        url : "{{route('dd_assist.simpan')}}",
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
                                window.location.replace('{{route("dd_assist.index")}}');
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
