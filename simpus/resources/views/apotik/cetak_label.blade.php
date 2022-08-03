<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        margin: 10px;
        padding: 10px;
        position: absolute;
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

    .font-content {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 7px;
    }

    .text-bold {
        font-weight: bold;
    }

    .bordered {
        border: 1px solid black;
    }
</style>

<body>
    @foreach($detail_obat as $key => $allobat)
        @if($key != 0)
            <div style="margin-top: 20px"></div>
        @endif
        <div style="width: 6.5cm; height: 4cm; padding:0 10px 10px 10px;" class="bordered">
            <div style="font-size: 9px;" class="text-center">
                <p>INSTALASI FARMASI</p>
                <p style="padding-top: 0;">UPTD PUSKESMAS JEPANG</p>
            </div>
            <hr style="border:1px solid black; padding-top: 0;">
            <table style="font-size:7px; width: 100%;" class="font-content">
                <tr>
                    <td>No Resep</td>
                    <td>:</td>
                    <td>{{ $detail_pengeluaran['no_terima_obat'] }}</td>
                    <td class="text-right">{{ date('d-m-Y', strtotime($detail_pengeluaran['tgl_serah_obat']))}}</td>
                </tr>
                <tr>
                    <td>No RM</td>
                    <td>:</td>
                    <td>{{ $detail_pengeluaran['pendaftaran']['no_rekamedis'] }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $detail_pengeluaran['nama_pasien'] }}</td>
                </tr>
            </table>
            <div class="text-center font-content">
                <p>{{ $allobat['nama_obat'] }} ({{ $allobat['jumlah'] }})</p>
                <p class="text-bold"> {{ $allobat['dosis_aturan_obat'] }}</p>
                {{-- <p>Sesudah makan</p> --}}
            </div>
            <p class="text-right font-content">Print D/T : {{ date('d/M/Y') }} {{ date("h:i:sa") }}</p>
        </div>
    @endforeach

</body>

</html>
