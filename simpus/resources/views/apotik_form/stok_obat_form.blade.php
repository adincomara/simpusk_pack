@extends('layouts.table')
@section('title', 'Form Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Obat</h3>
                    {{-- <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div> --}}
                </div>
                <div class="ibox-content">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($stok_obat)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Obat <span>*</span></label>
                                <select id="id_obat" name="obat" class="select2 form-control mb-1 obat-select" {{ isset($stok_obat)? 'disabled' : '' }}>
                                <option value="0" @if (!isset($stok_obat))
                                selected disabled
                            @endif >Pilih Obat</option>
                                  @foreach($obats as $obat)
                                        <option value="{{$obat->id}}" @if (isset($stok_obat))
                                            @if ($stok_obat[0]->id_obat == $obat->id)
                                                selected
                                            @endif
                                        @endif>{{$obat->kode_obat}} - {{$obat->nama_obat}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Batch Obat <span>*</span></label>
                            <div id="input_batch">
                                @if(isset($stok_obat))
                                <select name="batch_obat" id="batch_obat" class="select2 form-control">
                                    @foreach($stok_obat as $stok)
                                    <option value="{{ $stok->id }}">{{ $stok->batch_obat }} | expired {{ date('d-m-Y',strtotime($stok->tgl_expired_obat))}}</option>
                                    @endforeach
                                    <option value="tambah">Tambah Batch </option>
                                </select>
                                @else
                              <select name="batch_obat" id="batch_obat" class="select2 form-control">
                                <option value="tambah">Tambah Batch </option>
                              </select>
                              @endif
                            </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Tanggal Expired Obat <span>*</span></label>
                              <input type="date" class="form-control form-control-sm mb-1" name="tgl_expiret_obat" id="tgl_expired_obat" value="{{ date('Y-m-d') }}" {{ isset($stok_obat)?'readonly' : '' }}>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Stok Obat <span>*</span></label>
                              <input type="number" class="form-control form-control-sm mb-1" name="stok_obat" id="stok_obat" value="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('stok_obat.index')}}"  class="btn btn-default">Kembali</a>
                              </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
<script type="text/javascript">

    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        obat:{
          required: true
        },
        batch_obat:{
          required: true
        },
        tgl_expired_obat:{
          required: true
        },
        stok_obat:{
          required: true
        },
      },
      messages: {
        obat: {
          required: "Obat tidak boleh kosong"
        },
         batch_obat: {
          required: "Batch obat tidak boleh kosong"
        },
         tgl_expired_obat: {
          required: "Tanggal expired obat tidak boleh kosong"
        },
        stok_obat:{
            required: "Stok obat tidak boleh kosong"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        console.log(element.closest('.form-group').append(error));
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        SimpanData();
      }
    });
     function SimpanData(){
          $('#simpan').addClass("disabled");
           var enc_id          =$('#enc_id').val();
           var id_obat      =$('#id_obat').val();
           //var kode_obat   =$('#kode_obat').val();
           var batch_obat   =$('#batch_obat').val();
           var tgl_expired_obat = $('#tgl_expired_obat').val();
           var stok_obat   =$('#stok_obat').val();
           var jenis_stok_obat          =$('#jenis_stok_obat').val();
           var dosis_aturan_stok_obat       =$('#dosis_aturan_stok_obat').val();

           var dataFile = new FormData()

           dataFile.append('id_obat', id_obat);
           dataFile.append('stok_obat', stok_obat);
           dataFile.append('batch_obat', batch_obat);
           dataFile.append('tgl_expired_obat', tgl_expired_obat);
           dataFile.append('enc_id', enc_id);
           dataFile.append('jenis_stok_obat', jenis_stok_obat);
           dataFile.append('dosis_aturan_stok_obat', dosis_aturan_stok_obat);

          $.ajax({
            type: 'POST',
            url : "{{route('stok_obat.simpan')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $('#Loading').modal('show');
            },
            success: function(data){
              if (data.success) {
                  Swal.fire('Yes',data.message,'info');
                  window.location.href="{{ route('stok_obat.index') }}";
              } else {
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
               $('#simpan').removeClass("disabled");
               $('#Loading').modal('hide');
            },
            error: function(data){
                 $('#simpan').removeClass("disabled");
                 $('#Loading').modal('hide');
                console.log(data);
            }
          });
      }
      function datenow() {
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
      $('#id_obat').on('change', function(){
        $('#stok_obat').val('0');
        var date = new Date();

        $('#tgl_expired_obat').val(datenow());
       // $('#tgl_expired_obat').val(""+date.toString());
        //document.getElementById('batch_obat').innerHTML = "<p>coba</p>";
            $.ajax({
                type: 'POST',
                url: "{{ route('stok_obat.batch_obat') }}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data: {id_obat : this.value},
                success: function(data){
                    $('#input_batch').html(data);
                    var id_obat = $('#id_obat').val();
                    var input_batch = $('#batch_obat').val();
                    console.log(id_obat);
                    console.log(input_batch);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('stok_obat.get_stok') }}",
                        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                        data: {id_obat : id_obat, batch_obat : input_batch},
                        success: function(data){

                            if(data.stok_obat){
                                $('#stok_obat').val(data.stok_obat);
                            }



                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('stok_obat.get_tgl') }}",
                        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                        data: {id_obat : id_obat, batch_obat : input_batch},
                        success: function(data){
                            if(data.tgl_expired_obat){
                                $('#tgl_expired_obat').val(data.tgl_expired_obat);
                                $('#tgl_expired_obat').prop('readonly', true);
                            }


                            //console.log(tes);


                        }
                    });


                }
            });

        });

        $('#batch_obat').on('change', function(){
            var input_batch = $('#batch_obat').val();


            if(this.value == "tambah"){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();

                if(dd<10) {
                    dd = '0'+dd
                }

                if(mm<10) {
                    mm = '0'+mm
                }

                today = yyyy + '-' + mm + '-' + dd;
                $('#input_batch').html("<input type='text' id='batch_obat' name='batch_obat' class='form-control form-control-sm'>");
                $('#stok_obat').val("");
                console.log(today);
                $('#tgl_expired_obat').val(""+today);
                $('#tgl_expired_obat').prop('readonly', false);
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: "{{ route('stok_obat.get_stok') }}",
                    headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                    data: {batch_obat : input_batch},
                    success: function(data){
                        if(data.stok_obat){
                            $('#stok_obat').val(data.stok_obat);
                            $('#tgl_expired_obat').val(data.tgl_expired_obat);
                        }



                    }
                });
            }
        });
     $(document).ready(function(){
        $(function () {
                $('.select2').select2();
        });

        var input_batch = $('#batch_obat').val();
        console.log(input_batch);
        if(input_batch != "tambah"){
             $.ajax({
                type: 'POST',
                url: "{{ route('stok_obat.get_stok') }}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data: {batch_obat : input_batch},
                success: function(data){
                    $('#stok_obat').val(data.stok_obat);


                }
            });
        }


        // var batch = $('#batch_obat').val();
        // var id_obat = $('#id_obat').val();
        // var input_batch = $('#batch_obat').val();
        // console.log(id_obat);
        // console.log(input_batch);
        // if(batch == "tambah"){
        //     $('#input_batch').html("<input type='text' id='batch_obat' name='batch_obat' class='form-control form-control-sm'>");
        // }

   });
  </script>
@endpush


