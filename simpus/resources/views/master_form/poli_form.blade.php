@extends('layouts.table')
@section('title', 'Form Poli')
@section('menu1', 'Master')
@section('menu2', 'Data Poli')
@section('table')
@push('stylesheets')

@endpush
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Tambah Poli</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($poli)? $enc_id : ''}}">
                       
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Nama <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="nama_poli" id="nama_poli" value="{{isset($poli)? $poli->nama_poli : ''}}">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Poli (Untuk BPJS) <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kdpoli" id="kdpoli" value="{{isset($poli)? $poli->kdpoli : ''}}">
                            </div>
                          </div>
                          
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Kode Antrian Poli (Untuk Huruf Awal Antrean) <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="kode_poli" id="kode_poli" value="{{isset($poli)? $poli->kode_poli : ''}}">
                            </div>
                          </div>
                          
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Poli Kunjungan Sakit <span>*</span></label>
                              <select name="kunjungan_sakit" class="form-control" id="">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Status <span>*</span></label>
                              <select name="status" class="form-control" id="">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">Dokter Penanggung Jawab <span>*</span> <a href="#!" class="btn btn-primary ml-5" id="tambah_dokter">Tambah Dokter</a></label> 
                              <select name="dokter[]" class="form-control dokter">
                                
                              </select>
                              <table id="dokter_penanggung">
                                
                              </table>
                            </div>
                          </div>

                          

                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('poli.index')}}"  class="btn btn-default">Kembali</a>
                              </div>
                            </div>
                          </div>


                    </form>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
//SIMPAN DATA
<script type="text/javascript">
  $(document).ready(function(){
    select_dokter();
  })
  $('#submitData').validate({
    ignore: ":hidden:not(.editor)",
    rules: {
      nama_poli:{
        required: true
      },
      kdpoli:{
        required: true
      },
      kode_poli:{
        required: true
      },
      kunjungan_sakit:{
        required: true
      },
      status:{
        required: true
      },      
      "dokter[]":{
        required: true
      },
      
    },
    messages: {
      nama_poli: {
        required: "Nama Poli tidak boleh kosong"
      },
      kdpoli: {
        required: "Kode Poli tidak boleh kosong"
      },
      kode_poli: {
        required: "Kode Antrean Poli tidak boleh kosong"
      },
      kunjungan_sakit: {
        required: "Kunjungan Sakit tidak boleh kosong"
      },
      status: {
        required: "Status tidak boleh kosong"
      },
      "dokter[]": {
        required: "Dokter penanggung jawab tidak boleh kosong"
      },
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
        $.ajax({
          type: 'POST',
          url : "{{route('poli.simpan')}}",
          headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
          data:$('#submitData').serialize(),
          dataType: "json",
          beforeSend: function () {
            Swal.fire({
                title: 'Mohon Tunggu !',
                html: 'Loading',// add html attribute if you want or remove
                allowOutsideClick: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
          },
          success: function(data){
            
            if (data.success == true) {
                Swal.fire('Yes',data.message,'info');
                window.location.href="{{ route('poli.index') }}";
            } else {
                Swal.fire('Ups',data.message,'info');
            }

          },
          complete: function () {
            Swal.hideLoading();
          },
          error: function(data){
            Swal.hideLoading();
            Swal.fire('Error!',data.message,'error');
          }
        });
  }
</script>
//SCRIPT SELECT2 SEARCH DOKTER
<script>
  function select_dokter(){
    $('.dokter').select2({
      placeholder: 'Pilih Dokter',
      ajax: {
        url: "{{ route('dokter.search_dokter') }}",
        dataType: 'JSON',
        data: function(params) {
          return {
              search: params.term
          }
        },
        processResults: function (data) {
            var results = [];
            $.each(data, function(index, item){
                results.push({
                    id: item.kdDokter,
                    text : item.nmDokter,
                });
            });
            return{
                results: results
            };
        }
      }
    });
  }
</script>
//SCRIPT TAMBAH DOKTER
<script>
  var index = 0;
  $('#tambah_dokter').on('click', function(){
    let html = '<tr id="dokter_'+index+'">'
      +'<td><select name="dokter[]" class="form-control mt-3 dokter" style="width: 100%">'
        +'</select><a href="#!" class="btn btn-danger mt-1" id="delete_dokter" onclick="delete_dokter('+index+')">Delete</a></td>'
    +'</tr>';

    $('#dokter_penanggung').append(html);
    select_dokter();
    index++;

  })
</script>
//SCRIPT DELETE DOKTER
<script>
  function delete_dokter(idx){
    $('#dokter_'+idx).remove();
  }
</script>
@endpush


