<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('/inspinia/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.css')}}">

    <!-- Toastr style -->
    <link href="{{ asset('/inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('/inspinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ asset('/inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/inspinia/css/animate.css') }}" rel="stylesheet">

    {{-- <style>
        body{
            font-family: "open sans", "Helvetica Neue", Arial, Helvetica, sans-serif;
            background-color: #275783;
            font-size: 13px;
            color: #676a6c;
            overflow-x: hidden
        }
        .nav-header{
            padding:33px 25px;
            background-color: #275783;
            background-image: none;
        }
        .nav > li.active{
            border-left:4px solid #0d8f94;
            background: #293864;
        }
    </style> --}}
    <style>
        ul.pagination{
        display: inline-flex;
    }
    .select2-selection {
        height: 34px !important;
        border-color: #ced4da !important;
    }
    </style>
    <style>
        .redirect{
            color:inherit;
            color:#a7b1c2;
        }
        .redirect:hover{
            background-color:#293846;
            color: #ffff;
        }
        .redirect.active{
            background-color:#19aa8d;
            color: #ffff;
        }
        p{
            color: black;
        }
        tr td{
            color: black
        }
        .p-custom{
            font-size:16px;
        }
        .garis-border-dark{
            border: solid 1.5px black;
        }
        body{
            font-weight:initial;
        }

    </style>
</head>
<body style="padding-right: 10px; font-weight:500">
    <div class="printable" id="print-area">
        <div class="card-body p-0">
          <table class="mx-auto p-0" style="width: 100%" >
            <tr>
              <span id="enc_id" value="015909240421P000004"></span>
              <td style="width: 50% ;">
                <img style="width:200px;" src="{{asset('assets/img/logo_bpjs.png')}}" alt="logo_bpjs">
              </td >
              <td width="15%">
                <b>
                  Kedeputian Wilayah
                </b>

                <br>
                <b>
                  Kantor Cabang
                </b>

              </td>
              <td class="text-left">
                <span id="nmdeputiwilayah" style="">{{ $databpjs['ppk']['kc']['kdKR']['nmKR'] }}</span>
                <br>
                <span id="nmKc">{{ $databpjs['ppk']['kc']['dati']['nmDati'] }}</span>

              </td>
            </tr>
            <tr>
              <td class="text-center h4 p-2" style="" colspan="3">
                <b style="color: black">
                  Surat Rujukan FKTP
                </b>
              </td>
            </tr>
          </table>
          <div class="ml-3 garis-border-dark" style="font-size: 12px; min-height:730px;">
            <div class="garis-border-dark" style="margin:10px 70px 10px 40px;">
                <table style="width:100%; font-size:16px; font-weight:500" >
                    <tr>
                        <td class="p-2" width="15%">No. Rujukan</td>
                        <td width="1%" class="text-center p-2">:</td>
                        <td class="p-2">{{ $databpjs['noRujukan'] }}</td>
                        <td class="p-2 text-center" rowspan="3"> <?php
                            echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($databpjs['noRujukan'], 'C39',0.8,30,) . '" alt="barcode"   />';
                            ?></td>
                    </tr>
                    <tr>
                        <td class="p-2">FKTP</td>
                        <td  class="text-center p-2">:</td>
                        <td class="p-2" >{{ $databpjs['ppk']['nmPPK'] }} ({{ $databpjs['ppk']['kdPPK'] }})</td>

                    </tr>
                    <tr>
                        <td class="p-2">Kabupaten / Kota</td>
                        <td class="text-center p-2">:</td>
                        <td class="p-2">{{ $databpjs['ppk']['kc']['dati']['nmDati']  }} ({{ $databpjs['ppk']['kc']['dati']['kdDati']  }})</td>

                    </tr>
                </table>
              {{-- <table class="" style="width: 100%">
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
              </table> --}}
            </div>
            <table style="width: 50%; font-size:16px">
                <tr>
                    <td class="pl-5 pt-2 pt-2" width="40%">Kepada Yth. TS Dokter</td>
                    <td class="pl-3 pt-2 text-center" width="1%">:</td>
                    <td class="pl-2 pt-2 text-left" >{{ $databpjs['poli']['nmPoli'] }}</td>
                </tr>
                <tr>
                    <td class="pl-5 pt-2" >Di</td>
                    <td class="pl-3 pt-2 text-center">:</td>
                    <td class="pl-2 pt-2 text-left">{{ $data->faskes_rujuk->nama_faskes }}</td>
                </tr>
            </table>
            <br>
            <p class="pl-5 p-custom">  Mohon pemeriksaan dan penanganan lebih lanjut :</p>
            <div style="width: 50%; float: left;">
                <table style="width: 100%; font-size:16px" >
                    <tr>
                        <td class="pl-5 pt-2 pt-2" width="40%">Nama</td>
                        <td class="pl-3 pt-2 text-center" width="1%">:</td>
                        <td class="pl-2 pt-2 text-left" >{{ $databpjs['nmPst'] }}</td>
                    </tr>
                    <tr>
                        <td class="pl-5 pt-2" >No. Kartu BPJS</td>
                        <td class="pl-3 pt-2 text-center">:</td>
                        <td class="pl-2 pt-2 text-left">{{ $databpjs['nokaPst'] }}</td>
                    </tr>
                    <tr>
                        <td class="pl-5 pt-2" >Diagnosa</td>
                        <td class="pl-3 pt-2 text-center">:</td>
                        <td class="pl-2 pt-2 text-left">{{ $databpjs['diag1']['nmDiag'] }} ({{ $databpjs['diag1']['kdDiag'] }})
                        @if(isset($databpjs['diag2']))
                            <br>{{ $databpjs['diag2']['nmDiag'] }} ({{ $databpjs['diag2']['kdDiag'] }})
                        @elseif(isset($databpjs['diag3']))
                            <br>{{ $databpjs['diag3']['nmDiag'] }} ({{ $databpjs['diag3']['kdDiag'] }})
                        @endif

                        </td>
                    </tr>
                </table>
            </div>
            <div style="width: 50%; float: right;">
                <table style="width: 100%; font-size:16px" >
                    <tr>
                        <td class="pr-5 pt-2 pt-2" width="1%">Umur :</td>
                        @php
                            $now = Carbon\Carbon::now(); // Tanggal sekarang
                            $b_day = Carbon\Carbon::parse($databpjs['tglLahir']); // Tanggal Lahir
                            $age = $b_day->diffInYears($now);  // Menghitung umur
                        @endphp
                        <td class="pr-3 pt-2 text-center" width="1%">{{ $age }}</td>
                        <td class="pr-2 pt-2 text-left" width="1%">Tahun :</td>
                        @php
                            $tgl_lahir = Carbon\Carbon::parse($databpjs['tglLahir'])->isoFormat('DD-MMM-Y');
                        @endphp
                        <td class="pr-2 pt-2 text-left" width="10%">{{ $tgl_lahir }}</td>
                    </tr>
                    <tr>
                        <td class="pr-5 pt-2 pt-2">Status :</td>
                        <td class="pr-2 pt-2 text-center"><span class="garis-border-dark" style="width: 40px; height:20px;"> &nbsp; &nbsp;{{ $databpjs['pisa'] }}&nbsp; &nbsp;</span></td>
                        <td class="pr-2 pt-2 text-left" > Utama/Tanggunan</td>
                        <td class="pr-2 pt-2 text-left" ><span class="garis-border-dark" style="width: 40px; height:20px;"> &nbsp; &nbsp;{{ $databpjs['sex'] }}&nbsp; &nbsp;</span> (L/P)</td>
                    </tr>
                    <tr>
                        <td class="pr-5 pt-2" >Catatan :</td>
                        {{-- <td class="pr-3 pt-2 text-center">:</td> --}}
                        <td class="pr-2 pt-2 text-left" colspan="3">{{ $databpjs['catatan'] }}</td>
                    </tr>
                </table>
            </div>
            <p>&nbsp;</p>
            <p class="pl-5 p-custom">Telah Diberikan :</p>
            <br>
            <div style="width: 65%; float: left;">
                <p class="pl-5 p-custom">Atas bantuannya,diucapkan terimakasih</p>
                <br>
                <br>
                @php
                    $tgl_est_rujuk = Carbon\Carbon::parse($databpjs['tglEstRujuk'])->isoFormat('DD-MMM-Y');
                @endphp
                <p class="pl-4 p-custom">Tgl. Rencana Berkunjung : {{ $tgl_est_rujuk }}</p>
                <p class="pl-4 p-custom">Jadwal Praktek : {{ $databpjs['jadwal'] }}</p>
                @php
                    $tgl_akhir_rujuk = Carbon\Carbon::parse($databpjs['tglAkhirRujuk'])->isoFormat('DD-MMM-Y');
                @endphp
                <p class="pl-4 p-custom">Surat rujukan berlaku 1[satu] kali kunjungan, berlaku sampai dengan : {{ $tgl_akhir_rujuk }}</p>
            </div>
            <div style="width=50%; float:right; padding-right:150px">

                    <center>
                        @php
                            $tgl_tanda_tangan = Carbon\Carbon::parse($databpjs['tglEstRujuk'])->isoFormat('DD MMMM Y');
                        @endphp
                    <p style="" class="p-custom">Salam sejawat,<br> {{ $tgl_tanda_tangan }}</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p class="p-custom">{{ $databpjs['dokter']['nmDokter'] }}</p>
                </center>



            </div>



            {{-- <table style="width: 100%;font-size:12;">
              <tr>
                <td class="pt-3 pl-5">
                  <span style="padding-right: 60px">Kepada Yth. TS Dokter</span>
                  : &nbsp; <span id="nmPoli"></span>
                </td>
              </tr>
              <tr>
                <td class="pl-5 pt-2">
                  <span style="padding-right: 170px">Di</span>
                  : &nbsp; <span id="nmDokter"></span>
                </td>
              </tr>
              <tr>
                <td class="pl-5 pt-4" style="padding-top: 20px; padding-bottom:20px;">
                  Mohon pemeriksaan dan penanganan lebih lanjut :
                </td>
              </tr>
              <tr>
                <td class="pl-5 py-2" style="width: 50%;">
                  <span style="padding-right: 80px">Nama </span>
                  : &nbsp; <span id="nmPasien"></span>
                </td>
                <td>
                  <div>
                    <table style="width: 50% ">
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
            </table> --}}

          </div>

          <div class="garis-border-dark ml-3 border-top-0" style="font-size: 15px;">
            <table style="width: 100%; font-size:15px">
              <tr>
                <td class="h4 text-center py-3" style="text-decoration: underline;" colspan="2">
                  <b>
                    SURAT RUJUKAN BALIK
                  </b>
                </td>
              </tr>
              <tr>
                <td class="p-4">
                  Teman Sejawat Yth <br>
                  Mohon kontrol selanjutnya penderita :
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <table style="width: 80%; margin-left:80px; font-size:15px">
                    <tr>
                      <td class="p-2 ">
                        Nama
                      </td>
                      <td class="" style="padding-left:50px;">: <span id="nmPasienRujukBalik">   {{ $databpjs['nmPst'] }}  </span>
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
                        <span class="p-1 garis-border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <span class="p-1 garis-border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>&nbsp;
                        Kontrol kembali ke RS tanggal : .....................................
                      </td>
                    </tr>
                    <tr>
                      <td class="py-2 px-4">
                        <span class="p-1 garis-border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>&nbsp;
                        Lain-lain : ..........................................................................
                      </td>
                    </tr>
                  </table>
                </td>
                <td>
                  <table style=" width:100%; font-size:15px">
                    <tr>
                      <td class="py-3 px-4">
                        <span class="p-1 garis-border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>&nbsp;
                        Perlu rawat inap
                      </td>
                    </tr>
                    <tr>
                      <td class="py-3 px-4">
                        <span class="p-1 garis-border-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                <td class=" text-center pb-5" colspan="2"><p style="margin-left: 25%">Dokter RS,</p></td>
              </tr>
              <tr>
                <td></td>
                <td class=" text-center pt-2" style=";" colspan="2">
                  <p style="margin-left: 30%">(.........................................................................)</p></td>
              </tr>
            </table>
          </div>

    </div>
</body>
<script>

// var css = '@page { size:landscape; } body{font-family: "open sans", "Helvetica Neue", Arial, Helvetica, sans-serif;background-color: #275783;font-size: 13px;color: #676a6c;overflow-x: hidden}',
//     head = document.head || document.getElementsByTagName('head')[0],
//     style = document.createElement('style');

// style.type = 'text/css';
// style.media = 'print';

// if (style.styleSheet){
//   style.styleSheet.cssText = css;
// } else {
//   style.appendChild(document.createTextNode(css));
// }

// head.appendChild(style);

window.print();
// window.onafterprint = function(){ setTimeout(function () { window.close(); }, 500);};
</script>
</html>
