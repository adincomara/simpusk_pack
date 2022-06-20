<!DOCTYPE html>
<html>
    <head>
        <title>DATA PASIEN</title>
        <style type="text/css">

            .text-center {
                text-align: center
            }
            .text-right {
                text-align: right
            }
            table {
                border-left: 0.01em solid #ccc;
                border-right: 0;
                border-top: 0.01em solid #ccc;
                border-bottom: 0;
                border-collapse: collapse;
            }
            table td,
            table th {
                border-left: 0;
                border-right: 0.01em solid #ccc;
                border-top: 0;
                border-bottom: 0.01em solid #ccc;
            }

        </style>

    </head>
    <body>
<htmlpageheader name="MyHeader1">
    <br/>
    <div class="text-right">Hal. [{PAGENO}/{nb}]</div>
<h2 style="margin-bottom: 0;text-align: center;"> DATA KUNJUNGAN PASIEN PUSKESMAS</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3" class="table-bordered" style="border-bottom: 1px solid #000;">

    <thead>
        <tr>
            <th width="6%" style="border-bottom: 1px solid #000;">No</th>
            <th width="10%" style="text-align: left; border-bottom: 1px solid #000;">No Rekam Medis</th>
            <th width="20%" style="text-align: left; border-bottom: 1px solid #000;">No KTP</th>
            <th width="20%" style="text-align: left; border-bottom: 1px solid #000;">No BPJS</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Pasien</th>
            <th width="10%" style="text-align: left;border-bottom: 1px solid #000;">Jenis Kelamin</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">TTL</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Alamat</th>
            <th width="15%" style="text-align: left;border-bottom: 1px solid #000;">Telp</th>
            <th width="10%" style="text-align: left;border-bottom: 1px solid #000;">Status Pasien</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasien as $no => $result)
        <tr>
            <td width="6%" style="text-align: center;" valign="top" >{{$no + 1}}</td>
            <td style="text-align: left;">{!! $result->no_rekamedis !!}</td>
            <td style="text-align: left;">{!! $result->no_ktp !!}</td>
            <td style="text-align: left;">{!! $result->no_bpjs !!}</td>
            <td style='text-align:left;'>{{$result->nama_pasien}}</td>
            <td style='text-align:left;'>{{$result->jenis_kelamin}}</td>
            <td style='text-align:left;'>{{$result->tempat_lahir}}, {{$result->tanggal_lahir}}</td>
            <td style='text-align:left;'>{{$result->alamat}}</td>
            <td style='text-align:left;'>{{$result->telp}}</td>
            <td style='text-align:left;'>{{$result->status_pasien}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
