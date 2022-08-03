{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Nama : {{ $data['pasien']['nama_pasien'] }}</h1>
<h1>Jenis Kelamin {{ $data['pasien']['jenis_kelamin'] }}</h1>
<h1>Umur {{ hitung_umur($data['pasien']['tanggal_lahir']) }}</h1>
<h1>Alamat {{ $data['pasien']['alamat'] }}</h1>
<h1>Hari Tanggal {{ hari_sekarang() }}</h1>

<table>
    <tr>
        <td>Pemeriksaan</td>
        <td>Hasil</td>
        <td>Nilai Normal</td>
    </tr>
    @foreach ($data['pelayanan_poli_lab'] as $key => $lab)
    <tr>
        <td>{{ $lab['pelayananlaboratorium']['name'] }}</td>
        <td>{!! $nilai[$key] !!}</td>
        <td>{{ $lab['pelayananlaboratorium']['min'] }} - {{ $lab['pelayananlaboratorium']['max'] }} {{ $lab['pelayananlaboratorium']['satuan'] }}</td>
    </tr>

    @endforeach
</table>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pemeriksaan Laboratorium</title>
</head>
<style>
    @page {
    margin-left: 0.5in;
    margin-right: 0.5in;
    margin-top: 0;
    margin-bottom: 0;
    size: landscape;
  }
  @media print{@page {size: landscape}}
    body {
        height: 230mm;
        width: 100%;
        margin: 0 auto;
        padding: 0;
        font-size: 12pt;
    }
    .text-red{
        color: red;
    }

    hr{
        padding:0;
        margin:2;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .table3 {
        border: 1px solid;
    }

    .table3 td {
        border: 1px solid black;
        font-size: 12px;
    }

    .table2 td {
        font-size: 12px;
    }


    .table3 th {
        border: 1px solid black;
    }

    .table3 {
        width: 100%;
        border-collapse: collapse;
    }

    .table1 {
        width: 100%;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }
</style>

<body class="" style="max-height: 50px">
    <table  style="width:30%;float: right;">
        <tr>
            <td style="text-right">
                <table class="text-center table1" >
                    <tr>
                        <td class="text-right">
                            <img src="{{ asset('assets/img/logo_kudus.png') }}" alt="logo-kudus" width="40">
                        </td>
                        <td>
                            <h6>DINAS KESEHATAN</h6>
                            <h4>UPTD PUSKESMAS JEPANG</h4>
                            <p style="font-size: 12px;">
                                Jl.budi Utomo Ds. GUlang RT.1/4 Telp. (0291) 4248860 <br>
                                Email : puskesmasjepang@gmail.com <br>
                                Kode Pos : 59381 Kudus
                            </p>
                        </td>
                        <td class="text-right">
                            <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="logo-puskesmas" width="50">
                        </td>
                    </tr>

                </table>
                <hr>
                <hr>
                <h5 style="text-decoration: underline; font-weight: bold; text-align:center;">
                    HASIL PEMERIKSAAN LABORATORIUM
                </h5>
                <table class="table2">
                    <tr>
                        <td> Nama</td>
                        <td>&nbsp;&nbsp;&nbsp; : </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ strtoupper($data['pasien']['nama_pasien']) }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td> &nbsp;&nbsp;&nbsp; : </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ $data['pasien']['jenis_kelamin'] }}</td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td> &nbsp;&nbsp;&nbsp; : </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ hitung_umur($data['pasien']['tanggal_lahir']) }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> &nbsp;&nbsp;&nbsp; : </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ $data['pasien']['alamat'] }}</td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td> &nbsp;&nbsp;&nbsp; : </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ hari_sekarang() }}</td>
                    </tr>
                </table>
                <table class="table3">
                    <tr>
                        <td class="text-center">Pemeriksaan</td>
                        <td class="text-center">Hasil</td>
                        <td class="text-center">Nilai Normal</td>
                    </tr>
                    @foreach ($data['pelayanan_poli_lab'] as $key => $lab)
                    <tr>
                        <td style="padding:0">{{ $lab['pelayananlaboratorium']['name'] }}</td>
                        @if($red[$key] == 1)
                        <td class="text-center text-red">{!! $nilai[$key] !!}</td>
                        @else
                        <td class="text-center">{!! $nilai[$key] !!}</td>
                        @endif

                        <td>{{ $lab['pelayananlaboratorium']['min'] }} - {{ $lab['pelayananlaboratorium']['max'] }} {{ $lab['pelayananlaboratorium']['satuan'] }}</td>
                    </tr>
                    {{-- <tr>
                        <td>{{ $lab['pelayananlaboratorium']['name'] }}</td>
                        <td class="text-center">{!! $nilai[$key] !!}</td>
                        <td>{{ $lab['pelayananlaboratorium']['min'] }} - {{ $lab['pelayananlaboratorium']['max'] }} {{ $lab['pelayananlaboratorium']['satuan'] }}</td>
                    </tr> --}}

                    @endforeach
                </table>
                <table width="100%" style="font-size:12px;">
                    <tr>
                        <td style="text-align: right">
                        Petugas Laboratorium
                        </td>
                    </tr>
                    <tr>
                    <td style="padding:20px 0 20px 0;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">(....................)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        window.print()
        window.onafterprint = function(){ setTimeout(function () { window.close(); }, 500);};
    });
</script>

</html>
