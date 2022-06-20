<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .header tr{
            line-height: 25px;
        }
        h1, h2, h3, h4{
            margin: 0px;
        }
       .header h1{
            font-size: 2rem;
        }
        .header h2{
            font-size: 1.75rem;
        }
        .header h3{
            font-size: 1.5rem;
        }
        .header h4{
            font-size: 1.25rem;
        }
        .p19{
            font-size: 24px;
            text-align: justify;
            margin-left: 50px;
            margin-right: 50px;
        }
        @page {
            size: auto;
            size: F4;

        }


    </style>
    {{-- <link href="{{ asset('/inspinia/css/all.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('/inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}
</head>
<body style="font-family: 'Times New Roman', Times, serif; font-weight:500">
    <div class="header">
        <table style="width: 80%">
            <tr>

                <td rowspan="4" class="text-right" style="width: 35%"><img style="width: 110px" src="{{ asset('assets/img/logo_kudus.png') }}" alt=""></td>
                <td class="text-center"><h3> PEMERINTAH KABUPATEN KUDUS</h3></td>
            </tr>
            <tr>
                <td class="text-center"><h3>DINAS KESEHATAN</h3></td>
            </tr>
            <tr>

                <td class="text-center"><h1>BLUD UPT PUSKESMAS JEPANG</h1></td>
            </tr>
            <tr>

                <td class="text-center"><h4>Jl. Budi Utomo Telp. (0291) 4248860 Kudus 59381</h4></td>
            </tr>
        </table>
    </div>
    <hr style="border:1px solid black; margin-bottom:0px; padding:0">
    <p class="text-center font-weight-bold font-weight-underline" style="font-size: 25px; margin-top:5px"><u> SURAT RUJUKAN </u></p>
    <p class="text-center font-weight-bold" style="font-size: 20px; margin-top:0px">NOMOR : 440/{{ $no_rujuk }}/{{ date('m') }}/{{ date('Y') }}</p>
    @php
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        $hari_ini = \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y');
    @endphp
    <p style="float: right;" class="p19">{{ $hari_ini }}</p>
    <br>
    <p style="margin-bottom:0px" class="p19">Yth. T.S. Dokter Sp. {{ ucwords(strtolower($kunjungan->pendaftaran->poli->nama_poli)) }}</p>
    <p style="margin-top: 0px" class="p19">RS: {{ $kunjungan->rujuk_lanjut->nama_faskes->nama_faskes }}</p>
    <p class="p19">Mohon pemeriksaan/pengobatan lebih lanjut terdapat penderita :</p>
    <table style="width: 90%; font-size:24px; margin-left:75px; margin-right:75px">
        <tr>
            <td width="25%">Nama Pasien</td>
            <td width="1%">:</td>
            <td colspan="2">{{ strtoupper($kunjungan->pendaftaran->pasien->nama_pasien) }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td width="25%">{{ $kunjungan->pendaftaran->pasien->jenis_kelamin }}</td>
            @php
                $tanggal = new DateTime($kunjungan->pendaftaran->pasien->tanggal_lahir);

                // tanggal hari ini
                $today = new DateTime('today');

                // tahun
                $umur = $today->diff($tanggal)->y;
            @endphp
            <td class="text-right" style="padding-right: 100px">Umur : {{ $umur }} Th</td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>:</td>
            <td colspan="2">{{ $kunjungan->pendaftaran->pasien->alamat }}</td>
        </tr>
    </table>
    <br>
    <br>
    <p class="p19">Anamnesa :</p>
    <p class="p19" style="min-height: 140px"></p>
    <p class="p19">Diagnosa Sementara :</p>
    <p class="p19" style="min-height: 100px">
        @for($i=0;$i<count($pelayanan_poli->poli_diagnosa);$i++)

        {{ $i+1 }}. {{ $pelayanan_poli->poli_diagnosa[$i]->diagnosa }} | {{ $pelayanan_poli->poli_diagnosa[$i]->nama_diagnosa->nama_penyakit }}
            <br>
        @endfor
    </p>
    <p class="p19">Terapi/obat yang telah diberikan :</p>
    <p class="p19" style="min-height: 140px">
    Terapi : {{ $kunjungan->terapi }}
    <br>
    Obat :
    <br>
    {{-- @for($i=0;$i<7;$i++)
        {{ $i+1 }}. Anexamol
        <br>
    @endfor --}}
    </p>
    <br>
    <br>
    <p class="p19" style="float: right; margin-right:60px">Tanda tangan yang merujuk</p>
    <br>
    <br>
    <br><br><br><br><br>
    <p class="p19" style="float: right">(...................................................)</p>

</body>
<script>
     window.print();
     window.onafterprint = function(){ setTimeout(function () { window.close(); }, 500);};



</script>
</html>
