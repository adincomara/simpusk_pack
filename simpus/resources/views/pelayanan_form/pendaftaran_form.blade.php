@extends('layouts.table')
@section('title', 'Form Pendaftaran')
@section('menu1', 'Master')
@section('menu2', 'Data Pendaftaran')
@section('table')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6" style="max-height:450px">
            <div class="ibox" style="min-height: 525px">
                <div class="ibox-title">
                    <h3>Tambah Pendaftaran</h3>
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
                <div class="ibox-content" style="min-height: 365px">
                    <form id="submitData">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pendaftaran)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No Rawat <span>*</span></label>
                              <input type="text" class="form-control form-control-sm mb-1" name="no_rawat" id="no_rawat" value="Generate Otomatis"
                                readonly="">
                            </div>
                        </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Dokter Penanggung Jawab <span>*</span></label>
                              <select class="custom-select select2" name="dokter_penanggung_jawab" id="dokter_penanggung_jawab">
                                  @if(isset($dokter))
                                    @foreach($dokter as $dokter)
                                        <option value="{{ $dokter['kdDokter'] }},{{ $dokter['nmDokter'] }}">{{ $dokter['kdDokter'] }} | {{ $dokter['nmDokter'] }}</option>
                                    @endforeach
                                  @endif
                              </select>
                            </div>
                          </div>




                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Poli Tujuan <span>*</span></label>
                              <select class="custom-select" id="id_poli" name="id_poli">
                                <option></option>
                                @foreach($poli as $key => $result)
                                <option value="{{$result->id}}" {{ $selectedpoli == $result->id ? 'selected=""' : '' }}>
                                  {{$result->nama_poli}}</option>
                                @endforeach
                            </select>
                            <div class="checkbox">
                                <label for="konseling" style="margin-left:5px; margin-top:5px"><input type="checkbox" value="1" name="konseling" id="konseling"> Konseling (Yang tidak memerlukan diagnosa)</label>
                            </div>


                              {{-- <select name="id_poli" class="custom-select" id="id_poli">
                                <option value="">Pilih</option>
                                @foreach($poli as $key => $result)
                                <option value="{{$result->id}}" {{ $selectedpoli == $result->id ? 'selected=""' : '' }}>
                                  {{$result->nama_poli}}</option>
                                @endforeach
                              </select> --}}
                            </div>
                        </div>

                        <div class="form-row" id="SubPoliShow" style="display: none;">
                            <div class="form-group col-md-12">
                              <label class="form-label">Poli Sub <span>*</span></label>
                              <select name="id_poli_sub" class="custom-select" id="id_poli_sub">
                                <option value="">Pilih</option>
                              </select>

                            </div>
                        </div>
                        <div class="form-row">
                            <input type="hidden" class="form-control mb-1" name="kode_provider_bpjs_temp" id="kode_provider_bpjs_temp" value="">
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No Rekamedis <span>*</span></label>
                              {{-- <input type="text" class="form-control mb-1" name="no_rekamedis" id="no_rekamedis" value=""
                                autocomplete="off">
                              <div id="norekammedis_list"></div> --}}
                              <select class="custom-select" id="no_rekamedis" name="no_rekamedis">
                                <option data-row="{{ null }}"></option>
                                <div id="norekammedis_list">
                                {{-- @foreach($norekam as $data)
                                <option data-row="{{ $data }}" value="{{ $data->no_rekamedis }}">{{ $data->no_rekamedis }} | {{ $data->nama_pasien }}</option> --}}
                                </div>

                                {{-- @endforeach --}}
                            </select>
                            </div>
                          </div>
                          {{-- <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Dokter <span>*</span></label> --}}
                              {{-- <input type="hidden" name="id_dokter" id="id_dokter" value=""> --}}
                              {{-- <input type="text" class="form-control mb-1" name="nama_dokter" id="nama_dokter" value=""
                                autocomplete="off"> --}}
                                {{-- <select class="custom-select" id="id_dokter" name="id_dokter">
                                    <div id="list_dokter">
                                        <option></option>
                                        @foreach($dokter as $data)
                                            <option value="{{ $data->id_pegawai }}">{{ $data->nip }} | {{ $data->nama_pegawai }}
                                        @endforeach

                                    </div>

                                </select> --}}
                              {{-- <div id="dokter_list"></div> --}}
                            {{-- </div>
                          </div> --}}
                        </div>
                    </div>

                </div>
                <div class="col-lg-6" style="max-height:450px">
                    <div class="ibox" >
                        <div class="ibox-title">
                        <h3>Data Pasien</h3>
                        </div>
                        <div class="ibox-content" style="min-height: 365px">
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Nama Pasien <span>*</span></label>
                                <input type="text" class="form-control form-control-sm mb-1" name="nama_pasien" id="nama_pasien"
                                value="{{isset($pasien)? $pasien->nama_pasien : ''}}" readonly="">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Tanggal Lahir <span>*</span></label>
                                <input
                                type="text" class="form-control form-control-sm mb-1" name="tanggal_lahir" id="tanggal_lahir" value=""
                                readonly="">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Status Pasien <span>*</span></label>
                                <select name="status_pasien" class="form-control form-control-sm" id="status_pasien">
                                <option value="">Pilih</option>
                                @foreach($status as $key => $row)
                                <option value="{{$row}}" {{ $selectedstatus == $row ? 'selected=""' : '' }}>{{ucfirst($row)}}
                                </option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">No BPJS <span>*</span></label><br />
                                <span>Isi dengan (-) jika tidak ada No BPJS</span>
                                <input type="text" class="form-control form-control-sm mb-1" name="no_bpjs" id="no_bpjs" value="" readonly="">
                                <input type="hidden" class="form-control mb-1" name="no_bpjs_temp" id="no_bpjs_temp" value=""
                                readonly="">
                            </div>
                            </div>
                            {{-- <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Keluhan <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="keluhan_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Sistole <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="sistole_peserta" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Diastole <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="diastole_peserta" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Berat Badan <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="berat_badan_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Tinggi Badan <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="tinggi_badan_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Respiration Rate <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="resp_rate_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Tekanan Jantung <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="heart_rate_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Rujuk Balik <span>*</span></label>
                                <input type="text" class="form-control mb-1" name="no_rekamedis" id="rujuk_balik_pasien" value=""
                                autocomplete="off">
                            </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-row" id="form-bpjs" style="display: none">
                        <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">DATA BPJS</div>
                            <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0">Nomor Kartu :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="no_kartu_bpjs"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0"> Nama :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="nama_bpjs"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0">Kode Provider :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="kode_provider_bpjs" val=""></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0">Nama Provider :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="nama_provider_bpjs"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0">Jenis Kelamin :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="jenis_kelamin_bpjs"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0"> Jenis Peserta :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="jenis_peserta_bpjs"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0"> No.HP :</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="no_hp_bpjs"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                <h4 class="mb-0"> Status</h4>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                <h4 id="status_bpjs"></h4>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                            <a href="{{route('pendaftaran.index')}}" class="btn btn-default">Kembali</a>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#submitData').validate({
      ignore: ":hidden:not(.editor)",
      rules: {
        nama_dokter:{
          required: true
        },
        id_poli:{
          required: true
        },
        no_rekamedis:{
          required: true
        },
        nama_pasien:{
          required: true
        },
        tanggal_lahir:{
          required: true
        },
        nama_penanggung_jawab:{
          required: true
        },
        hubungan_dengan_penanggung_jawab:{
          required: true
        },
        alamat_penanggung_jawab:{
          required: true
        },
        status_pasien:{
          required: true
        },
        no_bpjs:{
          required: true
        },
        // id_dokter: {
        //     required: true
        // }
      },
      messages: {
        nama_dokter: {
          required: "Nama Dokter tidak boleh kosong"
        },
         id_poli: {
          required: "Pilih salah satu Poli"
        },
         no_rekamedis: {
          required: "No Rekam Medis tidak boleh kosong"
        },
         nama_pasien: {
          required: "Nama Pasien tidak boleh kosong"
        },
         tanggal_lahir: {
          required: "Tanggal Lahir pasien tidak boleh kosong"
        },
         nama_penanggung_jawab: {
          required: "Nama Penanggung Jawab pasien tidak boleh kosong"
        },
         hubungan_dengan_penanggung_jawab: {
          required: "Hubungan Penanggung Jawab pasien tidak boleh kosong"
        },
        alamat_penanggung_jawab: {
          required: "Alamat Penanggung Jawab pasien tidak boleh kosong"
        },
         status_pasien: {
          required: "Pilih salah satu status pasien"
        },
        no_bpjs: {
          required: "No BPJS pasien tidak boleh kosong"
        },
        // id_dokter: {
        //     required: "Dokter tidak boleh kosong"
        // }
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
           var enc_id               =$('#enc_id').val();
        //    var id_dokter            =$('#id_dokter').val();
           var nama_dokter          =$('#nama_dokter').val();
           var dokter_penanggung_jawab =$('#dokter_penanggung_jawab').val();
           var id_poli              =$('#id_poli').val();
           var id_poli_sub          =$('#id_poli_sub').val();
           var no_rekamedis         =$('#no_rekamedis').val();
           var nama_penanggung_jawab=$('#nama_penanggung_jawab').val();
           var hubungan_dengan_penanggung_jawab      =$('#hubungan_dengan_penanggung_jawab').val();
           var alamat_penanggung_jawab    =$('#alamat_penanggung_jawab').val();
           var status_pasien    =$('#status_pasien').val();
           var no_bpjs    =$('#no_bpjs').val();
           if($('input#konseling').is(':checked')){
                var konseling = 1;
            }else{
                var konseling = 0;
            }
           var dataFile = new FormData()

           dataFile.append('no_rekamedis', no_rekamedis);
           dataFile.append('enc_id', enc_id);
        //    dataFile.append('id_dokter', id_dokter);
           dataFile.append('nama_dokter', nama_dokter);
           dataFile.append('id_poli', id_poli);
           dataFile.append('id_poli_sub', id_poli_sub);
           dataFile.append('nama_penanggung_jawab', nama_penanggung_jawab);
           dataFile.append('hubungan_dengan_penanggung_jawab', hubungan_dengan_penanggung_jawab);
           dataFile.append('alamat_penanggung_jawab', alamat_penanggung_jawab);
           dataFile.append('status_pasien', status_pasien);
           dataFile.append('no_bpjs', no_bpjs);
           dataFile.append('konseling', konseling);
           dataFile.append('dokter_penanggung_jawab', dokter_penanggung_jawab);

          $.ajax({
            type: 'POST',
            url : "{{route('pendaftaran.simpan')}}",
            headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
            data:dataFile,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                Swal.showLoading();
            },
            success: function(data){
                console.log(data);
              if(data.success == true) {
                  Swal.fire('Yes',data.message,'success');
                //   var link = "{{ route('antrian.cetak') }}/"+JSON.stringify(data.antrian);
                //   window.open(link, "_blank");
                  window.location.href="{{ route('pendaftaran.index') }}";
              }else{
                 Swal.fire('Ups',data.message,'info');
              }

            },
            complete: function () {
                Swal.hideLoading();
            },
            error: function(data){
                 $('#simpan').removeClass("disabled");
                 $('#Loading').modal('hide');
                console.log(data);
            }
          });
      }

     $(document).ready(function(){
        $("#id_dokter").select2({
            placeholder: "Pilih Dokter",
            allowClear: true
        });
        $("#no_rekamedis").select2({
            placeholder: "No Rekamedis | Pasien",
            allowClear: true,
            ajax: {
                url: "{{ route('pendaftaran.searchRekam') }}",
                dataType: 'JSON',
                data: function(params) {
                return {
                    search: params.term
                }
                },
                processResults: function (data) {
                var results = [];
                //console.log(data);
                $.each(data, function(index, item){

                    results.push({
                        id: item.no_rekamedis,
                        //row: item,
                        text : item.no_rekamedis+' | '+item.nama_pasien,
                    });

                });
                return{
                    results: results
                };
                }
            }
        });
        $("#id_poli").select2({
            placeholder: "Pilih Poli",
            allowClear: true
        });
        $("#dokter_penanggung_jawab").select2({
            placeholder: "Pilih Dokter",
            allowClear: true
        });
        // $('#dokter').on('change',function() {
        //     alert('tes');
        //     var query = $(this).val();

        // });

      $('select[name="id_poli"]').on('change', function() {
      var id_poli = $(this).val();
      if(id_poli) {
          $.ajax({
            url: '{{route("pendaftaran.getsubpoli",[null])}}/' + id_poli,
              type: "GET",
              dataType: "json",
              success:function(data) {
                if(data.jumlah=='0'){
                  $('#SubPoliShow').hide();
                  $('select[name="id_poli_sub"]').empty();
                }else{
                  $('#SubPoliShow').show();
                  $('select[name="id_poli_sub"]').empty();
                  $.each(data.data, function(key, value) {
                       $('select[name="id_poli_sub"]').append('<option value="'+ value['id'] +'">'+ value['nama_poli'] +'</option>');
                  });
                }

                  // $('#SubPoliShow').hide();
                  // $('select[name="id_poli_sub"]').empty();
                  // $('select[name="id_poli_sub"]').append('<option value="">Pilih Kota/Kabupaten</option>');
                  // $.each(data, function(key, value) {
                  //     $('select[name="id_poli_sub"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                  // });

              }
          });
      }else{
          $('#SubPoliShow').hide();
          $('select[name="id_poli_sub"]').empty();
      }
      });
      $("#status_pasien" ).change(function() {
           var value = this.value;
           if (value=='BPJS') {
               var nobpjs = $('#no_bpjs_temp').val();
               $('#form-bpjs').css('display','block');
               $('#no_bpjs').val(nobpjs).attr("readonly", true);
           }else if (value=="Umum"){
            $('#form-bpjs').css('display','none');
               $("#no_bpjs").val("-").attr("readonly", false);
           }else{

           }
      });
    //    $('#no_rekamedis').on('keyup',function() {
    //         var query = $(this).val();

    //         $.ajax({
    //             url:"{{ route('pendaftaran.getNoRekam') }}",
    //             type:"GET",
    //             data:{'query':query},
    //             success:function (data) {
    //               console.log(data);
    //               $('#norekammedis_list').html(data);
    //             }
    //         })
    //     });


        $('#nama_dokter').on('keyup',function() {
             //alert('tes');
            var query = $(this).val();
            $.ajax({
                url:"{{ route('pendaftaran.getDokter') }}",
                type:"GET",
                data:{'query':query},
                success:function (data) {
                  $('#dokter_list').html(data);
                }
            })
        });

       $(document).on('click', '.pilihdokter', function(){

          var value = $(this).text();
          var res   = $(this).data('row');

           $('#id_dokter').val(res['id_pegawai']);
          $('#nama_dokter').val(res['nama_pegawai']);
          $('#dokter_list').html("");
      });
      $(document).on('change', '#no_rekamedis', function(){

        //   var value = $(this).text();
        //var val = $(this).find(':selected').data('row');
        $.ajax({
            type: 'GET',
            url: "{{ route('pendaftaran.searchRekam') }}",
            dataType: 'JSON',
            data: {search : this.value},
            success: function(data){
                console.log(data);
                $('#no_rekamedis').val(data[0].no_rekamedis);
                $('#nama_pasien').val(data[0].nama_pasien);
                $('#tanggal_lahir').val(data[0].tanggal_lahir);
                $('#no_bpjs').val(data[0].no_bpjs);
                console.log(data[0].no_bpjs);
                $('#no_bpjs_temp').val(data[0].no_bpjs);
                if ($('#no_bpjs').val()=='-' || $('#no_bpjs').val()=='') {
                    //console.log("tidak bpjs");
                    $('#status_pasien').val("Umum").prop("selected", true);
                    $("#form-bpjs").css("display","none");
                }else{
                    //console.log("bpjs");
                    $('#status_pasien').val(data[0].status_pasien).prop("selected", true);
                    $("#form-bpjs").css("display","block");
                }

                // get data bpjs
                pasienBPJS(data[0].no_bpjs);
                // after click is done, search results segment is made empty
                $('#norekammedis_list').html("");
            },

        });
        // return;
        //   var res   =  $(this).find(':selected').data('row');
        //   console.log(this.value);


      });
      $(document).on('change', '#status_bpjs', function(){

      })

   });

   function pasienBPJS(noKart){
     var nokartu = noKart;
      $.ajax({
          url:"{{ route('pendaftaran.getdatabpjs') }}",
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          type:"POST",
          data:{ 'noKartu':nokartu },
          beforeSend: function(){
            Swal.showLoading();
          },
          success:function (data) {
              Swal.hideLoading();
              console.log(data.success);
            if(data.success == true){
                Swal.close();
                $('#no_kartu_bpjs').html(nokartu);
                $('#nama_bpjs').html("");
                $('#kode_provider_bpjs').html("");
                $('#kode_provider_bpjs_temp').val("");
                $('#nama_provider_bpjs').html("");
                $('#jenis_kelamin_bpjs').html("");
                $('#jenis_peserta_bpjs').html("");
                $('#no_hp_bpjs').html("");
                $('#status_bpjs').html("");
                if(nokartu != null){
                $('#no_kartu_bpjs').html(nokartu);
                $('#nama_bpjs').html(data.datas.response.nama);
                $('#kode_provider_bpjs').html(data.datas.response.kdProviderPst.kdProvider);
                $('#kode_provider_bpjs_temp').val(data.datas.response.kdProviderPst.kdProvider);
                $('#nama_provider_bpjs').html(data.datas.response.kdProviderPst.nmProvider);
                $('#jenis_kelamin_bpjs').html(data.datas.response.sex);
                $('#jenis_peserta_bpjs').html(data.datas.response.jnsPeserta.nama);
                $('#no_hp_bpjs').html(data.datas.response.noHP);
                if(data.datas.response.aktif == true){
                    var status = 'AKTIF';
                }else{
                    var status = 'TIDAK AKTIF';
                }
                $('#status_bpjs').html('<span class="badge badge-primary">'+status+'</span>');
            }else{
                console.log('tes');
                Swal.fire('UPS',data.message,'info');
            }

            }else{
                console.log('tes');
                Swal.fire('UPS',data.message,'info');
            }
          },
          complete: function(){
            Swal.hideLoading();

          },
      })
   }

  function simpanantrian(noantrian, kdpoli){
    $.ajax({
      url: "{{ route('pendaftaran.simpanantrian') }}",
      headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
      type: "POST",
      data: {
        'noantrian' : noantrian,
        'idpoli'    : kdpoli,
      },
      success: function(response){
        console.log(response)
      }
    })
  }

   function daftarbpjs(noKart, kdpoli){
    var noKartu = noKart;
    var kdProvid = $('#kode_provider_bpjs_temp').val();
    var last_number = ("00" + kdpoli);

    $.ajax({
      url: "{{ route('pendaftaran.daftarbpjs') }}",
      headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
      type: "POST",
      data:{
        'kdprovider' : kdProvid,
        'nokartu'    : noKartu,
        'idpoli'     : last_number,
      },
      success: function(response){
        console.log(response.datas.response);
        if(response.datas.metaData.code == 201){
          var noantrian = response.datas.response.message
          simpanantrian(noantrian, last_number)
        }
      }
    })
   }
   $(document).ready(function(){
        var cek_dokter = '{{ $cek_dokter }}';
        if(cek_dokter == 0){
            Swal.fire('Ups', 'Maaf server BPJS tidak dapat merespon', 'error');
        }
   })

</script>
@endpush


