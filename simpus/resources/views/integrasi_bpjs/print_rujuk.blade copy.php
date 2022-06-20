@extends('layouts.table')
@section('title', 'Data Jabatan')
@section('judultable', 'Data Jabatan')
@section('menu1', 'Master')
@section('menu2', 'Data Jabatan')
@section('table')
@push('stylesheets')
    <style>
       @media print{@page {size: landscape}}
    </style>
@endpush
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h3>Data Jabatan</h3>
                <div class="ibox-tools">
                    @can('jabatan.tambah')
                        <a href="javascript:void(0);" onclick="printPageArea()"><button class="btn btn-primary">print</button></a>
                    @endcan
                    {{-- <a class="collapse-link">
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
                    </a> --}}
                </div>
            </div>
            <div class="ibox-content">
                <div class="printable" id="print-area">
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



            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function printPageArea(){
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
</script>
@endpush
