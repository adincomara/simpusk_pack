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
                    <h3>Tambah Pengadaan Obat</h3>
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
                        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($pengadaan_obat)? $enc_id : ''}}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label class="form-label">No Transaksi <span>*</span></label>
                              <input type="text" class="form-control mb-1" name="no_trans" id="no_trans" value="{{isset($pengadaan_obat)? $pengadaan_obat->no_trans : $noTrans}}" readonly>
                            </div>
                        </div>

                        <div class="card mb-3">
                              <div class="card-body pb-2">
                                  <h4 class="font-weight-bold py-3 mb-4">
                                      <span class="text-muted">Data Obat</span>
                                  </h4>
                                  <table class="table table-bordered" id="tableObat">
                                      <tr>
                                          <th width="20%">Nama/Kode Obat</th>
                                          <th width="20%">Suplier</th>
                                          <th width="14%">Batch Obat</th>
                                          <th width="14%">Tgl Expired Obat</th>
                                          <th width="10%">Jumlah</th>
                                          <th width="10%">Harga</th>
                                          <th width="10%">Total</th>
                                          <th width="2%"></th>
                                      </tr>
                                      <tr>
                                          <td><select id="obat_1" name="obat_1" class="select2_obat_1 form-control mb-1 obat-select" style="width:100%" required>
                                            <option value="0" selected disabled>Pilih Obat</option>
                                          {{-- @foreach($obats as $obat)
                                                <option value="{{$obat->id}}">{{$obat->kode_obat}} - {{$obat->nama_obat}}</option>
                                            @endforeach --}}
                                        </select></td>
                                          <td><select id="supplier_1" name="supplier_1" class="select2_suplier_1 form-control mb-1" style="width:100%" required>
                                            <option value="0" selected disabled>Pilih Supplier</option>
                                          {{-- @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->kode_supplier}}">{{$supplier->kode_supplier}} - {{$supplier->nama_supplier}}</option>
                                            @endforeach --}}
                                        </select></td>
                                        <td><div id="input_batch_1">
                                            <select name="batch_obat" id="batch_obat" class="form-control select2" style="width:100%">
                                                <option value="tambah">Tambah batch</option>
                                            </select>
                                        </div></td>
                                        <td><input type="date" class="form-control" name="tgl_expired_obat_1"
                                            id="tgl_expired_obat_1" readonly></td>
                                          <td><input type="number" class="form-control hitung-jumlah" min="1" name="jumlah_1" id="jumlah_1" value="1"/></td>
                                          <td><input type="number" class="form-control hitung-harga" min="0" name="harga_1" id="harga_1" value="1"/></td>
                                          <td><input type="number" class="form-control hitung-total" name="total_1" id="total_1" value="0" readonly/></td>
                                          <td></td>
                                      </tr>
                                  </table>
                                  <button type="button" id="tambahObat" class="btn btn-default" title="Tambah Obat"><i class="fa fa-plus-square"></i> Tambah Kolom</button>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-6">
                              <label class="form-label">Total Jumlah<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="total_jumlah" id="total_jumlah" value="0" readonly>
                              </div>
                              <div class="form-group col-md-6">
                              <label class="form-label">Total Harga<span>*</span></label>
                              <input type="text" class="form-control mb-1" name="total_harga" id="total_harga" value="0" readonly>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="form-group col-md-12">
                                  <label class="form-label">Keterangan</label>
                                  <textarea type="text" class="form-control mb-1" name="keterangan" id="keterangan">{{isset($pengadaan_obat)? $pengadaan_obat->keterangan : ''}}</textarea>
                              </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <div class="text-right mt-3">
                                  <input type="hidden" name="count" id="count" value="3"/>
                                  <input type="hidden" name="id_pengadaan" id="id_pengadaan" value="{{isset($pengadaan_obat)? $pengadaan_obat->id_pengadaan : $noPengadaan}}"/>
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>&nbsp;
                                <a href="{{route('pengadaan_obat.index')}}"  class="btn btn-default">Kembali</a>
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
var count = 2;
$('#obat_1').change(function(){
    $.ajax({
                type: 'POST',
                url: "{{ route('stok_obat.batch_obat') }}",
                headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                data: {id_obat : this.value, index: 1},
                success: function(data){
                    console.log(data.tgl);
                    $('#input_batch_1').html(data.batch);
                    $('#tgl_expired_obat_1').val(data.tgl);
                }
            });
});

$(document).ready(function(){
    create_select_obat(1);
    create_select_suplier(1);
});

    var validator;
        $(document).ready(function(){
            initHitung();
            $('#tambahObat').click(function(e){
                //$("#submitData").removeClass("invalid-feedback");
                if(validator){
                    validator.resetForm();
                    this.validator = null;
                }


                var htmlAppend = '<tr class="list_'+count+'">'
                  +'<td><select id="obat_'+count+'" name="obat_'+count+'" class="select2_obat_'+count+' form-control mb-1 obat-select" style="width:100%" required>'
                                //   +'<option value="0" selected disabled>Pilih Obat</option>'
                                // @foreach($obats as $obat)
                                //       +'<option value="{{$obat->id}}">{{$obat->kode_obat}} - {{$obat->nama_obat}}</option>'
                                //   @endforeach
                              +'</select></td>'
                                +'<td><select id="supplier_'+count+'" name="supplier_'+count+'" class="select2_suplier_'+count+' form-control mb-1" style="width:100%" required>'
                                  +'<option value="0" selected disabled>Pilih Supplier</option>'
                                // @foreach($suppliers as $supplier)
                                //       +'<option value="{{$supplier->kode_supplier}}">{{$supplier->kode_supplier}} - {{$supplier->nama_supplier}}</option>'
                                //   @endforeach
                              +'</select></td>'
                              +'<td><div id="input_batch_'+count+'"><select id="batch_obat_'+count+'" class="form-control select2" style="width:100%" name="batch_obat_'+count+'"><option value="tambah">Tambah batch</option></select></div></td>'
                              +'<td><input type="date" class="form-control" name="tgl_expired_obat_'+count+'" id="tgl_expired_obat_'+count+'" readonly></td>'
                                +'<td><input type="number" class="form-control hitung-jumlah" min="1" name="jumlah_'+count+'" id="jumlah_'+count+'" value="1"/></td>'
                                +'<td><input type="number" class="form-control hitung-harga" min="0" name="harga_'+count+'" id="harga_'+count+'" value="1"/></td>'
                                +'<td><input type="number" class="form-control hitung-total" name="total_'+count+'" id="total_'+count+'" value="1" readonly/></td>'
                                +'<td><button type="button" class="btn btn-danger hapus_obat_'+count+'" title="Hapus Obat"><i class="fa fa-close"></i></button></td>'
                                +'</tr>';
                $('#tableObat').find('tbody').append(htmlAppend);
                initHitung();
                batch(count);
                hapus_obat(count);
                create_select_obat(count);
                create_select_suplier(count);
                count++;
                $('#count').val(count);

                // $('.select2').select2();
            });
        });
    function create_select_obat(count){
        $(".select2_obat_"+count+"").select2({
            placeholder: 'Pilih Obat',
            ajax: {
                url: "{{ route('pelayanan_poli.searchObat') }}",
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
                        id: item.id,
                        text : item.kode_obat+' - '+item.nama_obat,
                    });
                });
                return{
                    results: results
                };
                }
            }
        });
    }

    function create_select_suplier(count){
        $(".select2_suplier_"+count+"").select2({
            placeholder: 'Pilih Suplier',
            ajax: {
                url: "{{ route('pengadaan_obat.searchSuplier') }}",
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
                        id: item.kode_supplier,
                        text : item.kode_supplier+' - '+item.nama_supplier,
                    });
                });
                return{
                    results: results
                };
                }
            }
        });
    }
    function batch(count){
        $('#obat_'+count+'').change(function(){
            // console.log(this.value);
            console.log('ngets');
            $.ajax({
                        type: 'POST',
                        url: "{{ route('stok_obat.batch_obat') }}",
                        headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
                        data: {id_obat : this.value, index: count},
                        success: function(data){
                            $('#input_batch_'+count+'').html(data.batch);
                            console.log(data.tgl);
                            $('#tgl_expired_obat_'+count+'').val(""+data.tgl);
                            // $('.select2').select2();
                        }
                    });
                    // $('#batch_obat_'+count+'').select2()
        });


    }
    function hapus_obat(count) {
        console.log(count);
        $('.hapus_obat_'+count).click(function(){
        console.log(count);
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data akan terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya",
            cancelButtonText:"Batal",
            confirmButtonColor: "#ec6c62",
            closeOnConfirm: false
          }).then(function(result){
              if(result.value){
                $("#tableObat tbody").find('.list_'+count).remove();
                initHitung();
              }


          });

      });

     }

     $('#simpan').click(function(){
       // $("#submitData").clearValidation();
        var rule = {};
        var message = {};
        for(let i =0;i<count;i++){
            rule['obat_'+i+''] = {
                required: true
            };
            rule['supplier_'+i+''] = {
                required: true
            };
            message['obat_'+i+'']={
                required : "Obat harus diisi"
            };
            message['supplier_'+i+'']={
                required : "Supplier harus diisi"
            };
        }
        console.log(rule);
        validate(rule, message);



     });

        function validate(rule, message){
           this.validator = $('#submitData').validate({
                // console.log('tes');
                ignore: ":hidden:not(.editor)",
                rules: rule,
                messages: message,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.addClass('invalid-feedback');
                    error.insertAfter(element);
                    //element.closest('.form-control').append(error);
                }
                //   error.addClass('invalid-feedback');
                //   element.closest('.form-group').append(error);
                //   //console.log('tes');
                //   console.log(element.closest('.form-group').append(error));
                },
                highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                //console.log('tes');
            // console.log(count);
                //return;
                SimpanData();
                }
            });
        }

       function SimpanData(){

            $('#simpan').addClass("disabled");

            var formData = $('#submitData').serialize();

            $.ajax({
              type: 'POST',
              url : "{{route('pengadaan_obat.simpan')}}",
              headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()},
              data: $('#submitData').serialize(),
              dataType: "json",
              beforeSend: function () {
                  $('#Loading').modal('show');
              },
              success: function(data){
                //   console.log(data);
                if (data.success) {
                    Swal.fire('Yes',data.message,'info');
                    window.location.href="{{ route('pengadaan_obat.index') }}";
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
                 // console.log(data.responseText);
              }
            });
        }
        function onlyNumberKey(evt) {

              // Only ASCII charactar in that range allowed
              var ASCIICode = (evt.which) ? evt.which : evt.keyCode
              if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                  return false;
              return true;
        }

        function count(){

            var a = parseInt($("#harga_beli").val());
            var b = parseInt($("#jumlah").val());
            c = a * b;

            if (!isNaN(c)) {
                $("#total").val(c);
            }
    }

    function initHitung() {
      $('.obat-select').change(function(){

      initHitungJumlah();
      initHitungHarga();
      });
      initHitungJumlah();
      initHitungHarga();
    }

    function initHitungJumlah(){
      hitungJumlah()
         //autocomplete
        $(".hitung-jumlah").change(function(){
          hitungJumlah();
        });
    }

    function hitungJumlah() {
          var total_jumlah = 0;
          var total_harga = 0;
          $('.hitung-jumlah').each(function () {
            var obatSelect = $(this).parent().parent().find('.obat-select').val();
            if(obatSelect != 0 && obatSelect != null){
              var jumlah = Number($(this).val());
              total_jumlah += jumlah;
              var harga = Number($(this).parent().parent().find('.hitung-harga').val());
              total_harga += harga*jumlah;
              $(this).parent().parent().find('.hitung-total').val(harga*jumlah);
            }
          });
          $('#total_jumlah').val(total_jumlah);
          $('#total_harga').val(total_harga);
     }

     function initHitungHarga(){
      hitungHarga()
         //autocomplete
        $(".hitung-harga").change(function(){
          hitungHarga();
        });
    }

    function hitungHarga() {
          var total_harga = 0;
          $('.hitung-harga').each(function () {
            var obatSelect = $(this).parent().parent().find('.obat-select').val();
            if(obatSelect != 0 && obatSelect != null){
              var harga = Number($(this).val());
              var jumlah = Number($(this).parent().parent().find('.hitung-jumlah').val());
              total_harga += harga*jumlah;
              $(this).parent().parent().find('.hitung-total').val(harga*jumlah);
            }
          });
          $('#total_harga').val(total_harga);
     }


</script>
@endpush


