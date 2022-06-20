<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
</head>
<style>
    #tabel1 {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #tabel1 td,
    #tabel1 th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #tabel1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tabel1 tr:hover {
        background-color: #ddd;
    }

    #tabel1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #1ab394;
        color: white;
    }
</style>

<body>
    <center> <h1>Laporan kasus PTM</h1></center>
    <center> <h1>Puskesmas : {{ $data[0]['nama_puskesmas'] }}</h1></center>
    <table id="tabel1">
        <thead>

            <tr>
                <th class="align-middle" rowspan="3">No</th>
                <th class="align-middle" rowspan="3">Bulan</th>
                <th colspan="9">IMA</th>
                <th colspan="9">DECOMP. CORDIS</th>
                <th colspan="9">HIPERTENSI</th>
                <th colspan="9">STROKE</th>
                <th colspan="9">DM TGT INSULIN</th>
                <th colspan="9">DM TAK TGT INSULIN</th>
                <th colspan="9">CA MAMMAE</th>
                <th colspan="9">CA SERVIKS</th>
                <th colspan="9">LEUKIMIA</th>
                <th colspan="9">RETINIBLASTOMA</th>
                <th colspan="9">CA KOLORECTAL</th>
                <th colspan="9">TALASEMIA</th>
                <th colspan="9">PPOK</th>
                <th colspan="9">ASMA BRONKHIALE</th>
                <th colspan="9">GAGAL GINJAL KRONIK</th>
                <th colspan="9">OSTEOPOROSIS</th>
                <th colspan="9">OBESITAS</th>
            </tr>
            <tr>
                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>

                <th colspan="3">Laki-laki</th>
                <th colspan="3">Perempuan</th>
                <th rowspan="2">L</th>
                <th rowspan="2">P</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                <th style="z-index: 50">0-14</th>
                <th style="z-index: 50">15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>

                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
                <th>0-14</th>
                <th>15-59</th>
                <th>&gt;=60</th>
            </tr>


        </thead>
        <tbody>
            @foreach($data as $key => $value)
            <tr>
                <td>{{ $value['no'] }}</td>
                <td>{{ $value['bulan'] }}</td>
                <td>{{ $value['ima_l_14'] }}</td>
                <td>{{ $value['ima_l_15'] }}</td>
                <td>{{ $value['ima_l_60'] }}</td>
                <td>{{ $value['ima_p_14'] }}</td>
                <td>{{ $value['ima_p_15'] }}</td>
                <td>{{ $value['ima_p_60'] }}</td>
                <td>{{ $value['ima_l_total'] }}</td>
                <td>{{ $value['ima_p_total'] }}</td>
                <td>{{ $value['ima_total'] }}</td>
                <td>{{ $value['decompcordis_l_14'] }}</td>
                <td>{{ $value['decompcordis_l_15'] }}</td>
                <td>{{ $value['decompcordis_l_60'] }}</td>
                <td>{{ $value['decompcordis_p_14'] }}</td>
                <td>{{ $value['decompcordis_p_15'] }}</td>
                <td>{{ $value['decompcordis_p_60'] }}</td>
                <td>{{ $value['decompcordis_l_total'] }}</td>
                <td>{{ $value['decompcordis_p_total'] }}</td>
                <td>{{ $value['decompcordis_total'] }}</td>
                <td>{{ $value['hipertensi_l_14'] }}</td>
                <td>{{ $value['hipertensi_l_15'] }}</td>
                <td>{{ $value['hipertensi_l_60'] }}</td>
                <td>{{ $value['hipertensi_p_14'] }}</td>
                <td>{{ $value['hipertensi_p_15'] }}</td>
                <td>{{ $value['hipertensi_p_60'] }}</td>
                <td>{{ $value['hipertensi_l_total'] }}</td>
                <td>{{ $value['hipertensi_p_total'] }}</td>
                <td>{{ $value['hipertensi_total'] }}</td>
                <td>{{ $value['stroke_l_14'] }}</td>
                <td>{{ $value['stroke_l_15'] }}</td>
                <td>{{ $value['stroke_l_60'] }}</td>
                <td>{{ $value['stroke_p_14'] }}</td>
                <td>{{ $value['stroke_p_15'] }}</td>
                <td>{{ $value['stroke_p_60'] }}</td>
                <td>{{ $value['stroke_l_total'] }}</td>
                <td>{{ $value['stroke_p_total'] }}</td>
                <td>{{ $value['stroke_total'] }}</td>
                <td>{{ $value['dmtgtinsulin_l_14'] }}</td>
                <td>{{ $value['dmtgtinsulin_l_15'] }}</td>
                <td>{{ $value['dmtgtinsulin_l_60'] }}</td>
                <td>{{ $value['dmtgtinsulin_p_14'] }}</td>
                <td>{{ $value['dmtgtinsulin_p_15'] }}</td>
                <td>{{ $value['dmtgtinsulin_p_60'] }}</td>
                <td>{{ $value['dmtgtinsulin_l_total'] }}</td>
                <td>{{ $value['dmtgtinsulin_p_total'] }}</td>
                <td>{{ $value['dmtgtinsulin_total'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_l_14'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_l_15'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_l_60'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_p_14'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_p_15'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_p_60'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_l_total'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_p_total'] }}</td>
                <td>{{ $value['dmtdktgtinsulin_total'] }}</td>
                <td>{{ $value['camammae_l_14'] }}</td>
                <td>{{ $value['camammae_l_15'] }}</td>
                <td>{{ $value['camammae_l_60'] }}</td>
                <td>{{ $value['camammae_p_14'] }}</td>
                <td>{{ $value['camammae_p_15'] }}</td>
                <td>{{ $value['camammae_p_60'] }}</td>
                <td>{{ $value['camammae_l_total'] }}</td>
                <td>{{ $value['camammae_p_total'] }}</td>
                <td>{{ $value['camammae_total'] }}</td>
                <td>{{ $value['caserviks_l_14'] }}</td>
                <td>{{ $value['caserviks_l_15'] }}</td>
                <td>{{ $value['caserviks_l_60'] }}</td>
                <td>{{ $value['caserviks_p_14'] }}</td>
                <td>{{ $value['caserviks_p_15'] }}</td>
                <td>{{ $value['caserviks_p_60'] }}</td>
                <td>{{ $value['caserviks_l_total'] }}</td>
                <td>{{ $value['caserviks_p_total'] }}</td>
                <td>{{ $value['caserviks_total'] }}</td>
                <td>{{ $value['leukimia_l_14'] }}</td>
                <td>{{ $value['leukimia_l_15'] }}</td>
                <td>{{ $value['leukimia_l_60'] }}</td>
                <td>{{ $value['leukimia_p_14'] }}</td>
                <td>{{ $value['leukimia_p_15'] }}</td>
                <td>{{ $value['leukimia_p_60'] }}</td>
                <td>{{ $value['leukimia_l_total'] }}</td>
                <td>{{ $value['leukimia_p_total'] }}</td>
                <td>{{ $value['leukimia_total'] }}</td>
                <td>{{ $value['retiniblastoma_l_14'] }}</td>
                <td>{{ $value['retiniblastoma_l_15'] }}</td>
                <td>{{ $value['retiniblastoma_l_60'] }}</td>
                <td>{{ $value['retiniblastoma_p_14'] }}</td>
                <td>{{ $value['retiniblastoma_p_15'] }}</td>
                <td>{{ $value['retiniblastoma_p_60'] }}</td>
                <td>{{ $value['retiniblastoma_l_total'] }}</td>
                <td>{{ $value['retiniblastoma_p_total'] }}</td>
                <td>{{ $value['retiniblastoma_total'] }}</td>
                <td>{{ $value['cakolorectal_l_14'] }}</td>
                <td>{{ $value['cakolorectal_l_15'] }}</td>
                <td>{{ $value['cakolorectal_l_60'] }}</td>
                <td>{{ $value['cakolorectal_p_14'] }}</td>
                <td>{{ $value['cakolorectal_p_15'] }}</td>
                <td>{{ $value['cakolorectal_p_60'] }}</td>
                <td>{{ $value['cakolorectal_l_total'] }}</td>
                <td>{{ $value['cakolorectal_p_total'] }}</td>
                <td>{{ $value['cakolorectal_total'] }}</td>
                <td>{{ $value['talasemia_l_14'] }}</td>
                <td>{{ $value['talasemia_l_15'] }}</td>
                <td>{{ $value['talasemia_l_60'] }}</td>
                <td>{{ $value['talasemia_p_14'] }}</td>
                <td>{{ $value['talasemia_p_15'] }}</td>
                <td>{{ $value['talasemia_p_60'] }}</td>
                <td>{{ $value['talasemia_l_total'] }}</td>
                <td>{{ $value['talasemia_p_total'] }}</td>
                <td>{{ $value['talasemia_total'] }}</td>
                <td>{{ $value['ppok_l_14'] }}</td>
                <td>{{ $value['ppok_l_15'] }}</td>
                <td>{{ $value['ppok_l_60'] }}</td>
                <td>{{ $value['ppok_p_14'] }}</td>
                <td>{{ $value['ppok_p_15'] }}</td>
                <td>{{ $value['ppok_p_60'] }}</td>
                <td>{{ $value['ppok_l_total'] }}</td>
                <td>{{ $value['ppok_p_total'] }}</td>
                <td>{{ $value['ppok_total'] }}</td>
                <td>{{ $value['asmabronkhiale_l_14'] }}</td>
                <td>{{ $value['asmabronkhiale_l_15'] }}</td>
                <td>{{ $value['asmabronkhiale_l_60'] }}</td>
                <td>{{ $value['asmabronkhiale_p_14'] }}</td>
                <td>{{ $value['asmabronkhiale_p_15'] }}</td>
                <td>{{ $value['asmabronkhiale_p_60'] }}</td>
                <td>{{ $value['asmabronkhiale_l_total'] }}</td>
                <td>{{ $value['asmabronkhiale_p_total'] }}</td>
                <td>{{ $value['asmabronkhiale_total'] }}</td>
                <td>{{ $value['gagalginjalkronik_l_14'] }}</td>
                <td>{{ $value['gagalginjalkronik_l_15'] }}</td>
                <td>{{ $value['gagalginjalkronik_l_60'] }}</td>
                <td>{{ $value['gagalginjalkronik_p_14'] }}</td>
                <td>{{ $value['gagalginjalkronik_p_15'] }}</td>
                <td>{{ $value['gagalginjalkronik_p_60'] }}</td>
                <td>{{ $value['gagalginjalkronik_l_total'] }}</td>
                <td>{{ $value['gagalginjalkronik_p_total'] }}</td>
                <td>{{ $value['gagalginjalkronik_total'] }}</td>
                <td>{{ $value['osteoporosis_l_14'] }}</td>
                <td>{{ $value['osteoporosis_l_15'] }}</td>
                <td>{{ $value['osteoporosis_l_60'] }}</td>
                <td>{{ $value['osteoporosis_p_14'] }}</td>
                <td>{{ $value['osteoporosis_p_15'] }}</td>
                <td>{{ $value['osteoporosis_p_60'] }}</td>
                <td>{{ $value['osteoporosis_l_total'] }}</td>
                <td>{{ $value['osteoporosis_p_total'] }}</td>
                <td>{{ $value['osteoporosis_total'] }}</td>
                <td>{{ $value['obesitas_l_14'] }}</td>
                <td>{{ $value['obesitas_l_15'] }}</td>
                <td>{{ $value['obesitas_l_60'] }}</td>
                <td>{{ $value['obesitas_p_14'] }}</td>
                <td>{{ $value['obesitas_p_15'] }}</td>
                <td>{{ $value['obesitas_p_60'] }}</td>
                <td>{{ $value['obesitas_l_total'] }}</td>
                <td>{{ $value['obesitas_p_total'] }}</td>
                <td>{{ $value['obesitas_total'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-center text-white">
                <th>Total</th>
                <th id="nama_puskesmas">{{ $sum_data['nama_puskesmas'] }}</th>
                <th id="ima_l_14">{{ $sum_data['ima_l_14'] }}</th>
                <th id="ima_l_15">{{ $sum_data['ima_l_15'] }}</th>
                <th id="ima_l_60">{{ $sum_data['ima_l_60'] }}</th>
                <th id="ima_p_14">{{ $sum_data['ima_p_14'] }}</th>
                <th id="ima_p_15">{{ $sum_data['ima_p_15'] }}</th>
                <th id="ima_p_60">{{ $sum_data['ima_p_60'] }}</th>
                <th id="ima_l_total">{{ $sum_data['ima_l_total'] }}</th>
                <th id="ima_p_total">{{ $sum_data['ima_p_total'] }}</th>
                <th id="ima_total">{{ $sum_data['ima_total'] }}</th>
                <th id="decompcordis_l_14">{{ $sum_data['decompcordis_l_14'] }}</th>
                <th id="decompcordis_l_15">{{ $sum_data['decompcordis_l_15'] }}</th>
                <th id="decompcordis_l_60">{{ $sum_data['decompcordis_l_60'] }}</th>
                <th id="decompcordis_p_14">{{ $sum_data['decompcordis_p_14'] }}</th>
                <th id="decompcordis_p_15">{{ $sum_data['decompcordis_p_15'] }}</th>
                <th id="decompcordis_p_60">{{ $sum_data['decompcordis_p_60'] }}</th>
                <th id="decompcordis_l_total">{{ $sum_data['decompcordis_l_total'] }}</th>
                <th id="decompcordis_p_total">{{ $sum_data['decompcordis_p_total'] }}</th>
                <th id="decompcordis_total">{{ $sum_data['decompcordis_total'] }}</th>
                <th id="hipertensi_l_14">{{ $sum_data['hipertensi_l_14'] }}</th>
                <th id="hipertensi_l_15">{{ $sum_data['hipertensi_l_15'] }}</th>
                <th id="hipertensi_l_60">{{ $sum_data['hipertensi_l_60'] }}</th>
                <th id="hipertensi_p_14">{{ $sum_data['hipertensi_p_14'] }}</th>
                <th id="hipertensi_p_15">{{ $sum_data['hipertensi_p_15'] }}</th>
                <th id="hipertensi_p_60">{{ $sum_data['hipertensi_p_60'] }}</th>
                <th id="hipertensi_l_total">{{ $sum_data['hipertensi_l_total'] }}</th>
                <th id="hipertensi_p_total">{{ $sum_data['hipertensi_p_total'] }}</th>
                <th id="hipertensi_total">{{ $sum_data['hipertensi_total'] }}</th>
                <th id="stroke_l_14">{{ $sum_data['stroke_l_14'] }}</th>
                <th id="stroke_l_15">{{ $sum_data['stroke_l_15'] }}</th>
                <th id="stroke_l_60">{{ $sum_data['stroke_l_60'] }}</th>
                <th id="stroke_p_14">{{ $sum_data['stroke_p_14'] }}</th>
                <th id="stroke_p_15">{{ $sum_data['stroke_p_15'] }}</th>
                <th id="stroke_p_60">{{ $sum_data['stroke_p_60'] }}</th>
                <th id="stroke_l_total">{{ $sum_data['stroke_l_total'] }}</th>
                <th id="stroke_p_total">{{ $sum_data['stroke_p_total'] }}</th>
                <th id="stroke_total">{{ $sum_data['stroke_total'] }}</th>
                <th id="dmtgtinsulin_l_14">{{ $sum_data['dmtgtinsulin_l_14'] }}</th>
                <th id="dmtgtinsulin_l_15">{{ $sum_data['dmtgtinsulin_l_15'] }}</th>
                <th id="dmtgtinsulin_l_60">{{ $sum_data['dmtgtinsulin_l_60'] }}</th>
                <th id="dmtgtinsulin_p_14">{{ $sum_data['dmtgtinsulin_p_14'] }}</th>
                <th id="dmtgtinsulin_p_15">{{ $sum_data['dmtgtinsulin_p_15'] }}</th>
                <th id="dmtgtinsulin_p_60">{{ $sum_data['dmtgtinsulin_p_60'] }}</th>
                <th id="dmtgtinsulin_l_total">{{ $sum_data['dmtgtinsulin_l_total'] }}</th>
                <th id="dmtgtinsulin_p_total">{{ $sum_data['dmtgtinsulin_p_total'] }}</th>
                <th id="dmtgtinsulin_total">{{ $sum_data['dmtgtinsulin_total'] }}</th>
                <th id="dmtdktgtinsulin_l_14">{{ $sum_data['dmtdktgtinsulin_l_14'] }}</th>
                <th id="dmtdktgtinsulin_l_15">{{ $sum_data['dmtdktgtinsulin_l_15'] }}</th>
                <th id="dmtdktgtinsulin_l_60">{{ $sum_data['dmtdktgtinsulin_l_60'] }}</th>
                <th id="dmtdktgtinsulin_p_14">{{ $sum_data['dmtdktgtinsulin_p_14'] }}</th>
                <th id="dmtdktgtinsulin_p_15">{{ $sum_data['dmtdktgtinsulin_p_15'] }}</th>
                <th id="dmtdktgtinsulin_p_60">{{ $sum_data['dmtdktgtinsulin_p_60'] }}</th>
                <th id="dmtdktgtinsulin_l_total">{{ $sum_data['dmtdktgtinsulin_l_total'] }}</th>
                <th id="dmtdktgtinsulin_p_total">{{ $sum_data['dmtdktgtinsulin_p_total'] }}</th>
                <th id="dmtdktgtinsulin_total">{{ $sum_data['dmtdktgtinsulin_total'] }}</th>
                <th id="camammae_l_14">{{ $sum_data['camammae_l_14'] }}</th>
                <th id="camammae_l_15">{{ $sum_data['camammae_l_15'] }}</th>
                <th id="camammae_l_60">{{ $sum_data['camammae_l_60'] }}</th>
                <th id="camammae_p_14">{{ $sum_data['camammae_p_14'] }}</th>
                <th id="camammae_p_15">{{ $sum_data['camammae_p_15'] }}</th>
                <th id="camammae_p_60">{{ $sum_data['camammae_p_60'] }}</th>
                <th id="camammae_l_total">{{ $sum_data['camammae_l_total'] }}</th>
                <th id="camammae_p_total">{{ $sum_data['camammae_p_total'] }}</th>
                <th id="camammae_total">{{ $sum_data['camammae_total'] }}</th>
                <th id="caserviks_l_14">{{ $sum_data['caserviks_l_14'] }}</th>
                <th id="caserviks_l_15">{{ $sum_data['caserviks_l_15'] }}</th>
                <th id="caserviks_l_60">{{ $sum_data['caserviks_l_60'] }}</th>
                <th id="caserviks_p_14">{{ $sum_data['caserviks_p_14'] }}</th>
                <th id="caserviks_p_15">{{ $sum_data['caserviks_p_15'] }}</th>
                <th id="caserviks_p_60">{{ $sum_data['caserviks_p_60'] }}</th>
                <th id="caserviks_l_total">{{ $sum_data['caserviks_l_total'] }}</th>
                <th id="caserviks_p_total">{{ $sum_data['caserviks_p_total'] }}</th>
                <th id="caserviks_total">{{ $sum_data['caserviks_total'] }}</th>
                <th id="leukimia_l_14">{{ $sum_data['leukimia_l_14'] }}</th>
                <th id="leukimia_l_15">{{ $sum_data['leukimia_l_15'] }}</th>
                <th id="leukimia_l_60">{{ $sum_data['leukimia_l_60'] }}</th>
                <th id="leukimia_p_14">{{ $sum_data['leukimia_p_14'] }}</th>
                <th id="leukimia_p_15">{{ $sum_data['leukimia_p_15'] }}</th>
                <th id="leukimia_p_60">{{ $sum_data['leukimia_p_60'] }}</th>
                <th id="leukimia_l_total">{{ $sum_data['leukimia_l_total'] }}</th>
                <th id="leukimia_p_total">{{ $sum_data['leukimia_p_total'] }}</th>
                <th id="leukimia_total">{{ $sum_data['leukimia_total'] }}</th>
                <th id="retiniblastoma_l_14">{{ $sum_data['retiniblastoma_l_14'] }}</th>
                <th id="retiniblastoma_l_15">{{ $sum_data['retiniblastoma_l_15'] }}</th>
                <th id="retiniblastoma_l_60">{{ $sum_data['retiniblastoma_l_60'] }}</th>
                <th id="retiniblastoma_p_14">{{ $sum_data['retiniblastoma_p_14'] }}</th>
                <th id="retiniblastoma_p_15">{{ $sum_data['retiniblastoma_p_15'] }}</th>
                <th id="retiniblastoma_p_60">{{ $sum_data['retiniblastoma_p_60'] }}</th>
                <th id="retiniblastoma_l_total">{{ $sum_data['retiniblastoma_l_total'] }}</th>
                <th id="retiniblastoma_p_total">{{ $sum_data['retiniblastoma_p_total'] }}</th>
                <th id="retiniblastoma_total">{{ $sum_data['retiniblastoma_total'] }}</th>
                <th id="cakolorectal_l_14">{{ $sum_data['cakolorectal_l_14'] }}</th>
                <th id="cakolorectal_l_15">{{ $sum_data['cakolorectal_l_15'] }}</th>
                <th id="cakolorectal_l_60">{{ $sum_data['cakolorectal_l_60'] }}</th>
                <th id="cakolorectal_p_14">{{ $sum_data['cakolorectal_p_14'] }}</th>
                <th id="cakolorectal_p_15">{{ $sum_data['cakolorectal_p_15'] }}</th>
                <th id="cakolorectal_p_60">{{ $sum_data['cakolorectal_p_60'] }}</th>
                <th id="cakolorectal_l_total">{{ $sum_data['cakolorectal_l_total'] }}</th>
                <th id="cakolorectal_p_total">{{ $sum_data['cakolorectal_p_total'] }}</th>
                <th id="cakolorectal_total">{{ $sum_data['cakolorectal_total'] }}</th>
                <th id="talasemia_l_14">{{ $sum_data['talasemia_l_14'] }}</th>
                <th id="talasemia_l_15">{{ $sum_data['talasemia_l_15'] }}</th>
                <th id="talasemia_l_60">{{ $sum_data['talasemia_l_60'] }}</th>
                <th id="talasemia_p_14">{{ $sum_data['talasemia_p_14'] }}</th>
                <th id="talasemia_p_15">{{ $sum_data['talasemia_p_15'] }}</th>
                <th id="talasemia_p_60">{{ $sum_data['talasemia_p_60'] }}</th>
                <th id="talasemia_l_total">{{ $sum_data['talasemia_l_total'] }}</th>
                <th id="talasemia_p_total">{{ $sum_data['talasemia_p_total'] }}</th>
                <th id="talasemia_total">{{ $sum_data['talasemia_total'] }}</th>
                <th id="ppok_l_14">{{ $sum_data['ppok_l_14'] }}</th>
                <th id="ppok_l_15">{{ $sum_data['ppok_l_15'] }}</th>
                <th id="ppok_l_60">{{ $sum_data['ppok_l_60'] }}</th>
                <th id="ppok_p_14">{{ $sum_data['ppok_p_14'] }}</th>
                <th id="ppok_p_15">{{ $sum_data['ppok_p_15'] }}</th>
                <th id="ppok_p_60">{{ $sum_data['ppok_p_60'] }}</th>
                <th id="ppok_l_total">{{ $sum_data['ppok_l_total'] }}</th>
                <th id="ppok_p_total">{{ $sum_data['ppok_p_total'] }}</th>
                <th id="ppok_total">{{ $sum_data['ppok_total'] }}</th>
                <th id="asmabronkhiale_l_14">{{ $sum_data['asmabronkhiale_l_14'] }}</th>
                <th id="asmabronkhiale_l_15">{{ $sum_data['asmabronkhiale_l_15'] }}</th>
                <th id="asmabronkhiale_l_60">{{ $sum_data['asmabronkhiale_l_60'] }}</th>
                <th id="asmabronkhiale_p_14">{{ $sum_data['asmabronkhiale_p_14'] }}</th>
                <th id="asmabronkhiale_p_15">{{ $sum_data['asmabronkhiale_p_15'] }}</th>
                <th id="asmabronkhiale_p_60">{{ $sum_data['asmabronkhiale_p_60'] }}</th>
                <th id="asmabronkhiale_l_total">{{ $sum_data['asmabronkhiale_l_total'] }}</th>
                <th id="asmabronkhiale_p_total">{{ $sum_data['asmabronkhiale_p_total'] }}</th>
                <th id="asmabronkhiale_total">{{ $sum_data['asmabronkhiale_total'] }}</th>
                <th id="gagalginjalkronik_l_14">{{ $sum_data['gagalginjalkronik_l_14'] }}</th>
                <th id="gagalginjalkronik_l_15">{{ $sum_data['gagalginjalkronik_l_15'] }}</th>
                <th id="gagalginjalkronik_l_60">{{ $sum_data['gagalginjalkronik_l_60'] }}</th>
                <th id="gagalginjalkronik_p_14">{{ $sum_data['gagalginjalkronik_p_14'] }}</th>
                <th id="gagalginjalkronik_p_15">{{ $sum_data['gagalginjalkronik_p_15'] }}</th>
                <th id="gagalginjalkronik_p_60">{{ $sum_data['gagalginjalkronik_p_60'] }}</th>
                <th id="gagalginjalkronik_l_total">{{ $sum_data['gagalginjalkronik_l_total'] }}</th>
                <th id="gagalginjalkronik_p_total">{{ $sum_data['gagalginjalkronik_p_total'] }}</th>
                <th id="gagalginjalkronik_total">{{ $sum_data['gagalginjalkronik_total'] }}</th>
                <th id="osteoporosis_l_14">{{ $sum_data['osteoporosis_l_14'] }}</th>
                <th id="osteoporosis_l_15">{{ $sum_data['osteoporosis_l_15'] }}</th>
                <th id="osteoporosis_l_60">{{ $sum_data['osteoporosis_l_60'] }}</th>
                <th id="osteoporosis_p_14">{{ $sum_data['osteoporosis_p_14'] }}</th>
                <th id="osteoporosis_p_15">{{ $sum_data['osteoporosis_p_15'] }}</th>
                <th id="osteoporosis_p_60">{{ $sum_data['osteoporosis_p_60'] }}</th>
                <th id="osteoporosis_l_total">{{ $sum_data['osteoporosis_l_total'] }}</th>
                <th id="osteoporosis_p_total">{{ $sum_data['osteoporosis_p_total'] }}</th>
                <th id="osteoporosis_total">{{ $sum_data['osteoporosis_total'] }}</th>
                <th id="obesitas_l_14">{{ $sum_data['obesitas_l_14'] }}</th>
                <th id="obesitas_l_15">{{ $sum_data['obesitas_l_15'] }}</th>
                <th id="obesitas_l_60">{{ $sum_data['obesitas_l_60'] }}</th>
                <th id="obesitas_p_14">{{ $sum_data['obesitas_p_14'] }}</th>
                <th id="obesitas_p_15">{{ $sum_data['obesitas_p_15'] }}</th>
                <th id="obesitas_p_60">{{ $sum_data['obesitas_p_60'] }}</th>
                <th id="obesitas_l_total">{{ $sum_data['obesitas_l_total'] }}</th>
                <th id="obesitas_p_total">{{ $sum_data['obesitas_p_total'] }}</th>
                <th id="obesitas_total">{{ $sum_data['obesitas_total'] }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
