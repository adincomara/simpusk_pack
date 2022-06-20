@extends('layouts.table_ptm')
@section('title', 'Tambah PANDU PTM DI FKTP')
@section('judultable', 'Tambah PANDU PTM DI FKTP')
{{-- @section('subjudul', ' PANDU PTM DI FKTP)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Tambah PANDU PTM DI FKTP')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah PANDU PTM DI FKTP</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_pandu.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pandu)? $enc_id : ''}}">
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
                                                value="{{isset($pandu)? $pandu->date_periode : $date_now}}"
                                                name="periode" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Pasien
                                            Dilakukan Skrining</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-12   ">
                                                        <input type="text" class="form-control rounded"
                                                        name="jml_pasien_skrining"
                                                        id="jml_pasien_skrining"
                                                        value="{{isset($pandu)? $pandu->jml_pasien_skrining : 0}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Kasus</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">PTM</label>
                                                        <input type="text" class="form-control rounded" name="jml_kasus_ptm"
                                                        id="jml_kasus_ptm"
                                                        value="{{isset($pandu)? $pandu->jml_kasus_ptm : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="">Non PTM</label>
                                                        <input type="text" class="form-control rounded" name="jml_kasus_non_ptm"
                                                        id="jml_kasus_non_ptm"
                                                        value="{{ isset($pandu)? $pandu->jml_kasus_non_ptm : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Hasil Prediksi
                                            Risiko PTM (Charta)</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-4">
                                                        <label class="">&lt; 5%</label>
                                                        <input type="text" class="form-control rounded" name="charta_5" id="charta_5"
                                                        value="{{isset($pandu)? $pandu->charta_5 : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">5 -&lt; 10%</label>
                                                        <input type="text" class="form-control rounded" name="charta_5_10" id="charta_5_10"
                                                        value="{{isset($pandu)? $pandu->charta_5_10 : 0 }}">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">10 -&lt; 20%</label>
                                                        <input type="text" class="form-control rounded"
                                                        name="charta_10_20" id="charta_10_20"
                                                        value="{{isset($pandu)? $pandu->charta_10_20 : 0 }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-6">
                                                        <label class="">20 - &lt; 30%</label>
                                                        <input type="text" class="form-control rounded" name="charta_20_30" id="charta_20_30"
                                                        value="{{ isset($pandu)? $pandu->charta_20_30 : 0 }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class=""> &gt;= 30%</label>
                                                        <input type="text" class="form-control rounded" name="charta_30"
                                                        id="charta_30" value="{{ isset($pandu)? $pandu->charta_30 : 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah Dirujuk ke
                                            RS</label>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 row my-2">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control rounded" name="jml_dirujuk_rs"
                                                        id="jml_dirujuk_rs" value="{{isset($pandu)? $pandu->jml_dirujuk_rs : 0}}">
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
                                <a class="btn btn-white btn-sm" href="{{route('dd_pandu.index')}}">Batal</a>
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
                        url : "{{route('dd_pandu.simpan')}}",
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
                                window.location.replace('{{route("dd_pandu.index")}}');
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
