<!DOCTYPE html>
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
</html>
