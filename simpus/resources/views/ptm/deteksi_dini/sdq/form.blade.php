@extends('layouts.table_ptm')
@section('title', 'Tambah SDQ')
@section('judultable', 'Tambah SDQ')
{{-- @section('subjudul', '(SDQ)') --}}
@section('menu1', 'Deteksi Dini')
@section('menu2', 'Tambah SDQ')
@section('table_ptm')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title b-r-xl mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Tambah SDQ</h3>
                        </div>
                        <div class="ibox-tools">
                            <div class="text-right">
                                <a href="{{ route('dd_sdq.index') }} "
                                    class="btn text-dark b-r-xl border border-secondary btn-refresh">
                                    <i class="fa fa-chevron-left"></i>&nbsp; Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content b-r-xl">
                    <form class="m-t-md" id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($sdq)? $enc_id : ''}}">
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
                                        <div class="form-group" id="periode_bln">
                                            <div class="input-group date">
                                                <span class="input-group-addon" style="">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control py-2" autocomplete="off"
                                                    value="{{isset($sdq)? $sdq->date_periode : $date_now}}"
                                                    name="periode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah yang
                                    didetekdi dini (SDQ)</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki 4-10 tahun</label>
                                                <input type="text" class="form-control rounded" name="dd_sdq_4_10_l" id="ca_mammae"
                                                value="{{isset($sdq)? $sdq->dd_sdq_4_10_l : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan 4-10 tahun</label>
                                                <input type="text" class="form-control rounded" name="dd_sdq_4_10_p" id="ca_mammae"
                                                value="{{isset($sdq)? $sdq->dd_sdq_4_10_p : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki 11-18 tahun</label>
                                                <input type="text" class="form-control rounded" name="dd_sdq_11_18_l"
                                                id="ca_serviks" value="{{isset($sdq)? $sdq->dd_sdq_11_18_l : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan 11-18 tahun</label>
                                                <input type="text" class="form-control rounded" name="dd_sdq_11_18_p"
                                                id="ca_serviks" value="{{isset($sdq)? $sdq->dd_sdq_11_18_p : 0}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-12 col-sm-12 col-form-label font-bold">Jumlah yang mendapat
                                    tatalaksanan (hasil borderline/abnormal)</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 row my-2">
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki 4-10 tahun</label>
                                                <input type="text" class="form-control rounded" name="abnormal_4_10_l"
                                                id="ca_mammae" value="{{isset($sdq)? $sdq->abnormal_4_10_l : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan 4-10 tahun</label>
                                                <input type="text" class="form-control rounded" name="abnormal_4_10_p"
                                                id="ca_mammae" value="{{isset($sdq)? $sdq->abnormal_4_10_p : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Laki-laki 11-18 tahun</label>
                                                <input type="text" class="form-control rounded" name="abnormal_11_18_l"
                                                id="ca_serviks" value="{{isset($sdq)? $sdq->abnormal_11_18_l : 0}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="">Perempuan 11-18 tahun</label>
                                                <input type="text" class="form-control rounded" name="abnormal_11_18_p"
                                                id="ca_serviks" value="{{isset($sdq)? $sdq->abnormal_11_18_P : 0}}">
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
                        url : "{{route('dd_sdq.simpan')}}",
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
                                window.location.replace('{{route("dd_sdq.index")}}');
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
