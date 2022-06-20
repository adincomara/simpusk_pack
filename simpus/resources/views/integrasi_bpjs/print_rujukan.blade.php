@extends('layouts.backend')
@section('pageTitle', "Laporan Pasien Berdasarkan Rujukan | $perusahaan->nama")
@push('stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/users.css')}}">
<style type="text/css" media="print">
  @page {
    margin-left: 0.5in;
    margin-right: 0.5in;
    margin-top: 0;
    margin-bottom: 0;
    size: landscape;
  }
  @media print{@page {size: landscape}}
</style>


@endpush

@section('main_container')
<div class="layout-content">
  <div class="container-fluid flex-grow-1 container-p-y">

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{route('manage.beranda')}}">Beranda</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Laporan Pasien Berdasarkan Rujukan</a>
      </li>
    </ol>

    @if(session('message'))
    <div class="alert alert-{{session('message')['status']}}">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
          aria-hidden="true">&times;</span></button>
      {{ session('message')['desc'] }}
    </div>
    @endif
    <div class="nav-tabs-top">
      <form class="form-horizontal" id="submitData">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="enc_id" id="enc_id" value="{{isset($data)? $nokunjungan : ''}}">
        <button type="button" class="btn btn-info" id="print" onclick="printareacard()"><i
            class="fas fa-print"></i></button>
        <div class=" printable" id="print-area">
          <div class="card-body p-0">
            <table class="mx-auto p-0" style="width: 100%">
              <tr>
                <span id="enc_id" value="015909240421P000004"></span>
                <td style="width: 50% ;">
                  <img style="width:200px;" src="{{asset('assets/img/logo_bpjs.png')}}" alt="logo_bpjs">
                </td>
                <td class="fs-14" style="margin-left:25%; line-height:28px;">
                  <b>
                    Kedeputian Wilayah
                  </b>
                  <span style="padding-left: 40px" id="nmdeputiwilayah" style=""></span>
                  <br>
                  <b>
                    Kantor Cabang
                  </b>
                  <span style="padding-left: 75px" id="nmKc"></span>
                </td>
              </tr>
              <tr>
                <td class="text-center h4 p-2" style="" colspan="2">
                  <b>
                    Surat Rujukan FKTP
                  </b>
                </td>
              </tr>
            </table>
            <div class="border border-dark ml-3" style="font-size: 14px; ">
              <div class="border border-dark" style="margin:10px 70px 10px 40px;">
                <table class="" style="width: 100%">
                  <tr>
                    <td class="p-2">
                      <span style="padding-right: 170px">No. Rujukan</span>
                      : &nbsp; <span id="noRujukan">12345678910</span>
                    </td>
                    <td rowspan="3" class="text-center">
                      <?php
                                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($nokunjungan, 'C39',0.8,30,) . '" alt="barcode"   />';
                                ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="p-2">
                      <span style="padding-right: 215px">FKTP</span>
                      : &nbsp; <span id="nmPpk">12345675657565</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="p-2 pb-4">
                      <span style="padding-right: 130px">Kabupaten / Kota</span>
                      : &nbsp; <span id="kabupaten">Kab. Kendal</span>
                    </td>
                  </tr>
                </table>
              </div>
              <table style="width: 100%;font-size:12;">
                <tr>
                  <td class="pt-3 pl-5">
                    <span style="padding-right: 60px">Kepada Yth. TS Dokter</span>
                    : &nbsp; <span id="nmPoli"></span>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5 pt-3">
                    <span style="padding-right: 170px">Di</span>
                    : &nbsp; <span id="nmDokter"></span>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5 pt-5" style="padding-top: 20px; padding-bottom:20px;">
                    Mohon pemeriksaan dan penanganan lebih lanjut :
                  </td>
                </tr>
                <tr>
                  <td class="pl-5 py-3" style="width: 50%;">
                    <span style="padding-right: 80px">Nama </span>
                    : &nbsp; <span id="nmPasien"></span>
                  </td>
                  <td>
                    <div>
                      <table style="width: 100% ">
                        <tr>
                          <td>Umur : </td>
                          <td id="umur"></td>
                          <td>Tahun : </td>
                          <td id="tgllahir"></td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5" style="width: 50%;">
                    <span style="padding-right: 30px">No. Kartu BPJS </span>
                    : &nbsp; <span id="nokartu"></span>
                  </td>
                  <td>
                    <div>
                      <table style="width: 100%">
                        <tr>
                          <td>Status : </td>
                          <td colspan="2">
                            <span class="p-1 border border-dark">
                              &nbsp;<span id="jenispeserta"></span>&nbsp;
                            </span>
                            &nbsp;Utama/Tanggunan</td>
                          <td>
                            <span class="p-1 border border-dark">
                              &nbsp;<span id="jnskelamin"></span>&nbsp;
                            </span>&nbsp;(P/L)
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5" style="width: 50%;">
                    <span style="padding-right: 60px">Diagnosa </span>
                    : &nbsp; <span id="diagnosa"></span>
                  </td>
                  <td class="py-3">
                    <div>
                      <table style="width: 100%">
                        <tr>
                          <td class="">Catatan : </td>
                          <td colspan="2">
                            &nbsp;<span class="pl-4" id="catatan"></span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5 pb-5" style="padding-top: 20px; padding-bottom:20px;">
                    Telah diberikan :
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="pl-5 pb-5" style="padding-top: 15px; padding-bottom:15px; color:red;">
                    #Alasan Rujuk Diagnosa-Non-Spesialistik : <span id="nmtacc"> </span> <span id="alasanTacc"></span>
                  </td>
                </tr>
                <tr>
                  <td class="pl-5 py-3" style="padding-top: 20px; padding-bottom:20px;">
                    Atas bantuannya,diucapkan terimakasih
                  </td>
                  <td class="pl-5 text-center">
                    Salam Sejawat,<br>
                    <span id="tglkunjungan"></span>
                  </td>
                </tr>
                <tr>
                  <td class="pl-3 py-2">
                    Tgl.Rencana Berkunjung : &nbsp; <span id="tglrujuk">
                  </td>
                </tr>
                <tr>
                  <td class="pl-3 py-2">
                    Jadwal Praktek :
                  </td>
                </tr>
                <tr>
                  <td class="pl-3 p-2 pb-4" style="margin:10px 0 0 10px">
                    Surat Rujukan Berlaku 1(satu) kali kunjungan, berlaku sampai dengan : &nbsp;
                    <span id="akhirRujuk"></span>
                  </td>
                  <td class="pl-5 p-2 pb-4 text-center">
                    <span id="dokterkunjungan"></span>
                  </td>
                </tr>
              </table>

            </div>

            {{-- <div class="border border-dark ml-3 border-top-0" style="font-size: 14px;">
              <table style="width: 100%">
                <tr>
                  <td class="h4 text-center py-3" style="text-decoration: underline;" colspan="2">
                    <b>
                      SURAT RUJUKAN BALIK
                    </b>
                  </td>
                </tr>
                <tr>
                  <td class="p-4 ">
                    Teman Sejawat Yth <br>
                    Mohon kontrol selanjutnya penderita :
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table style="width: 80%; margin-left:80px;">
                      <tr>
                        <td class="p-2 ">
                          Nama
                        </td>
                        <td class="" style="padding-left:50px;">: <span id="nmPasienRujukBalik"></span>
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2">
                          Diagnosa
                        </td>
                        <td class="" style="padding-left:50px;">
                          :
                          .....................................................................................................................................
                        </td>
                      </tr>
                      <tr>
                        <td class="p-2">
                          Terapi
                        </td>
                        <td class="" style="padding-left:50px;">
                          :
                          .....................................................................................................................................
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td class="p-4">
                    Tindakan lanjut yang dianjurkan
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%" class="p-3">
                    <table style=" width: 100%" class="">
                      <tr>
                        <td class="py-2 px-4">
                          <span class="p-1 border border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </span>&nbsp;
                          Pengobatan dengan Obat-obatan :
                        </td>
                      </tr>
                      <tr>
                        <td class="py-2 px-4 px-auto text-right">
                          ...........................................................................................
                        </td>
                      </tr>
                      <tr>
                        <td class="py-2 px-4">
                          <span class="p-1 border border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </span>&nbsp;
                          Kontrol kembali ke RS tanggal : .....................................
                        </td>
                      </tr>
                      <tr>
                        <td class="py-2 px-4">
                          <span class="p-1 border border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </span>&nbsp;
                          Lain-lain : ..........................................................................
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table style=" width:100%;">
                      <tr>
                        <td class="py-3 px-4">
                          <span class="p-1 border border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </span>&nbsp;
                          Perlu rawat inap
                        </td>
                      </tr>
                      <tr>
                        <td class="py-3 px-4">
                          <span class="p-1 border border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </span>&nbsp;
                          Konsultasi selesai
                        </td>
                      </tr>
                      <tr>
                        <td class="py-2 px-4">
                          ...................tgl.....................................
                        </td>
                      </tr>

                    </table>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td class=" text-center pb-5" colspan="2">Dokter RS,</td>
                </tr>

                <tr>
                  <td></td>
                  <td class=" text-center p-4" style=";" colspan="2">
                    (......................................)</td>
                </tr>
              </table>
            </div> --}}

        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function(){
    var nokunjungan = $('#enc_id').val();
    var token = '{{ csrf_token() }}';
    $.ajaxSetup({
      headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
    });
    $.ajax({
      type: 'POST',
      headers: {'X-CSRF-TOKEN': token},
      url: '{{ route("report.getdetailrujukanBPJS") }}',
      datType: 'json',
      data: {
        enc_id: nokunjungan
      },
      success: function(response){
        console.log(response)
        if(response.data.metaData.code != 200){
          Swal.fire('Error','Maaf Server Sedang Bermasalah','info');
        }else{
          var nokartu = response.data.response.nokaPst
          getriwayatrujuk(nokartu, token, nokunjungan)
          $('#nmdeputiwilayah').html(response.data.response.ppk.kc.kdKR.nmKR)
          $('#nmKc').html(response.data.response.ppk.kc.nmKC)
          $('#noRujukan').html(nokunjungan)
          $('#nmPpk').html(response.data.response.ppk.nmPPK + "(" + response.data.response.ppk.kdPPK + ")" )
          $('#kabupaten').html(response.data.response.ppk.kc.dati.nmDati + " (" +response.data.response.ppk.kc.dati.kdDati +")")
          $('#nmPoli').html(response.data.response.poli.nmPoli)
          $('#nmPasien').html(response.data.response.nmPst)
          $('#nokartu').html(response.data.response.nokaPst)
          $('#diagnosa').html(response.data.response.diag1.nmDiag+" (" + response.data.response.diag1.kdDiag+")")
          var lahir = response.data.response.tglLahir
          var tgllahirraw = lahir.split('-').reverse().join('-')
          var umur = Math.floor((new Date() - new Date(tgllahirraw).getTime()) / 3.15576e+10)
          $('#umur').html(umur)
          $('#jenispeserta').html(response.data.response.pisa)
          $('#tgllahir').html(response.data.response.tglLahir)
          $('#jnskelamin').html(response.data.response.sex)
          $('#catatan').html(response.data.response.catatanRujuk)
          $('#nmtacc').html( "("+response.data.response.tacc.nmTacc+")")
          $('#alasanTacc').html(response.data.response.tacc.alasanTacc)
          $('#tglrujuk').html(response.data.response.tglEstRujuk)
          $('#akhirRujuk').html(response.data.response.tglAkhirRujuk)
          $('#jadwal_praktek').html(response.data.response.jadwal)
          $('#tglkunjungan').html(response.data.response.tglKunjungan)
          $('#dokterkunjungan').html(response.data.response.dokter.nmDokter)
          $('#nmPasienRujukBalik').html(response.data.response.nmPst)
        }
      },
      complete: function(){
          window.print();
        console.log('tes');
        //  window.location.href = "http://simpusk.rapierteknologi.com/manage/laporan/laporan_rujukan/"+nokunjungan;
        //  window.open('http://simpusk.rapierteknologi.com/manage/laporan/laporan_rujukan/');
        // window.open('http://www.smkproduction.eu5.org', '_blank');
        //  window.location.replace("http://simpusk.rapierteknologi.com/manage/laporan/laporan_rujukan/"+nokunjungan);
        //   window.open("http://simpusk.rapierteknologi.com/manage/laporan/laporan_rujukan/"+nokunjungan, '_blank');
      }
    });
  });
</script>
<script>
  function printareacard(){
      var mode = 'iframe'
      var close = mode == "popup"
      var title = 'Surat Rujukan'
      var popx = 0
      var popy = 0
      var popTitle = "Surat Rujukan"
      var extraHead = ''
      var retainAttr = [
        "class"
      ]
      var option = {
        mode: mode,
        popClose: close,
        popx: popx,
        popy: popy,
        extraHead: extraHead,
        retainAttr: retainAttr
      }
      $('#print-area').printArea( option )
    }
  function getriwayatrujuk(nokartu, token, nokunjungan){
    $.ajax({
      type: 'POST',
      headers: {'X-CSRF-TOKEN': token},
      datType: 'json',
      url: '{{ route("report.riwayatrujukanBPJS") }}',
      data: {
        nokartu : nokartu
      },
      success: function(response){
        var data = response.datas.response.list
        for (let index = 0; index < data.length; index++) {
          if(data[index].noKunjungan == nokunjungan){
            $('#nmDokter').html(data[index].providerRujukLanjut.nmProvider)
          }
        }
      }
    });
  }


</script>

@endpush
