@extends('layouts.table_ptm')
@section('title', 'Tambah Deteksi Dini Faktor Risiko PTM KESWA')
@section('judultable', 'Tambah Deteksi Dini Faktor Risiko PTM KESWA')
{{-- @section('subjudul', ' Deteksi Dini Faktor Risiko PTM KESWA)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Tambah Deteksi Dini Faktor Risiko PTM KESWA')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah Deteksi Dini Faktor Risiko PTM KESWA</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_fr_ptm_keswa.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" id="submitData">
                        {{ csrf_field() }}
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($ptm_keswa)? $enc_id : ''}}">
                        <div class="row px-3">
                            <div class="col-sm-12">
                                <label class="col-sm-2 col-sm-2 col-form-label font-bold">WILAYAH</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-2 col-sm-2 col-form-label">Kabupaten</label>
                                        <div class="form-group col-md">
                                            <input type="text" class="form-control py-2" name="kab" id="kab"
                                            value="{{ isset($puskesmas)? $puskesmas->kabupaten : ''}}" readonly>
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
                                                value="{{isset($ptm_keswa)? $ptm_keswa->date_periode : $date_now }}"
                                                name="periode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Hadir</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control rounded" name="jml_hadir" id="jml_hadir"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->jml_hadir : 0 }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jenis
                                            Kelamin</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Laki-laki</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="jml_laki" id="jml_laki"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->jml_laki : 0 }}"
                                                        onkeyup="hitung_jml_hadir()">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Perempuan</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="jml_perempuan"
                                                        id="jml_perempuan"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->jml_perempuan : 0 }}"
                                                        onkeyup="hitung_jml_hadir()">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Usia</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">15 - 59 Tahun</label>
                                                        <input type="text" class="form-control rounded" name="usia_15_59" id="usia_15_59"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->usia_15_59 : 0 }}"
                                                        onkeyup="hitung_cakupan('usia','15_59')">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">&gt; 59 tahun</label>
                                                        <input type="text" class="form-control rounded" name="usia_59" id="usia_59"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->usia_59 : 0 }}"
                                                        onkeyup="hitung_cakupan('59')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Riwayat PTM</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Diri Sendiri</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="diri_sendiri"
                                                        id="diri_sendiri"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->diri_sendiri : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Keluarga</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="keluarga" id="keluarga"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->keluarga : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Faktor
                                            Risiko</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">Merokok</label>
                                                        <input type="text" class="form-control rounded" name="merokok" id="merokok"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->merokok : 0 }}">
                                                        <label class="">Diet Tidak Seimbang</label>
                                                        <input type="text" class="form-control rounded" name="diet_tdk_seimbang"
                                                        id="diet_tdk_seimbang"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->diet_tdk_seimbang : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Kurang Aktifitas Fisik</label>
                                                        <input type="text" class="form-control rounded" name="aktifitas_fisik"
                                                        id="aktifitas_fisik"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->aktifitas_fisik : 0 }}">
                                                        <label class="">Konsumsi Alkohol</label>
                                                        <input type="text" class="form-control rounded" name="konsumsi_alkohol"
                                                        id="konsumsi_alkohol"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->konsumsi_alkohol : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Sasaran</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">15 - 59 Tahun</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="sasaran_15_59"
                                                        id="sasaran_15_59"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->sasaran_15_59 : 0 }}"
                                                        onkeyup="hitung_cakupan('15_59')">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">&gt; 59 Tahun</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="sasaran_59" id="sasaran_59"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->sasaran_59 : 0 }}"
                                                        onkeyup="hitung_cakupan('59')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Cakupan</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">15 - 59 Tahun</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="cakupan_15_59"
                                                            id="cakupan_15_59_temp"
                                                            value="{{ isset($ptm_keswa)? $ptm_keswa->cakupan_15_59 : 0 }}" disabled>
                                                        <input type="hidden" class="form-control py-2" name="cakupan_15_59"
                                                            id="cakupan_15_59"
                                                            value="{{ isset($ptm_keswa)? $ptm_keswa->cakupan_15_59 : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">&gt; 59 Tahun</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="cakupan_59"
                                                            id="cakupan_59_temp"
                                                            value="{{ isset($ptm_keswa)? $ptm_keswa->cakupan_59 : 0 }}" disabled>
                                                        <input type="hidden" class="form-control py-2" name="cakupan_59" id="cakupan_59"
                                                            value="{{ isset($ptm_keswa)? $ptm_keswa->cakupan_59 : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Pengukuran</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">TD Tinggi</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="td_tinggi" id="td_tinggi"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->td_tinggi : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Obesitas</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="obesitas" id="obesitas"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->obesitas : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">LP Lebih</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="lp_lebih" id="lp_lebih"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->lp_lebih : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Pemeriksaan</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">GDS Tinggi</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="gds_tinggi" id="gds_tinggi"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->gds_tinggi : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Kolesterol Tinggi</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="kolesterol_tinggi"
                                                        id="kolesterol_tinggi"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->kolesterol_tinggi : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Asam Urat Tinggi</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="asam_urat_tinggi"
                                                        id="asam_urat_tinggi"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->asam_urat_tinggi : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Gangguan Pengliahatan</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="gangguan_penglihatan"
                                                        id="gangguan_penglihatan"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->gangguan_penglihatan : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Gangguan Pendengaran</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="gangguan_pendengaran"
                                                        id="gangguan_pendengaran"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->gangguan_pendengaran : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">SRQ > 6</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="srw" id="srw"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->srw : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">KIE</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="kie" id="kie"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->kie : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Rujukan FKTP</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control rounded"
                                                        name="rujuk_fktp" id="rujuk_fktp"
                                                        value="{{ isset($ptm_keswa)? $ptm_keswa->rujuk_fktp : 0 }}">
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
                        url : "{{route('dd_fr_ptm_keswa.simpan')}}",
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
                                window.location.replace('{{route("dd_fr_ptm_keswa.index")}}');
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
        <script>
            function hitung_cakupan(data){
                var sasaran = $(`#sasaran_${data}`).val()
                var usia = $(`#usia_${data}`).val()
                if(sasaran != '' && usia != ''){
                    var result_cakupan = (usia / sasaran)*100
                    if(result_cakupan != 'Infinity'){
                        $(`#cakupan_${data}_temp`).val(Math.round(result_cakupan))
                        $(`#cakupan_${data}`).val(Math.round(result_cakupan))
                    }
                }else{
                    console.log(`kosong`)
                }
            }
            function hitung_jml_hadir(){
                var laki = $(`#jml_laki`).val()
                var perempuan = $(`#jml_perempuan`).val()
                var jml_hadir = parseInt(laki)+parseInt(perempuan);
                $('#jml_hadir').val(jml_hadir);
            }
        </script>
        @endpush
