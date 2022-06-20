<!DOCTYPE html>
<html>
    <head>
        <title>DATA LAPORAN PASIEN BERDASARKAN DIAGNOSA</title>
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
 <h2 style="margin-bottom: 0;text-align: center;"> DATA LAPORAN PASIEN BERDASARKAN DIAGNOSA</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
    <br>
    <br>
    <br>
    <br>

    <table width="100%" cellspacing="0" cellpadding="3" class="table-bordered mt-5" style="border: 1px solid #000;">

    <thead>
        <tr>
            <th width="15%" style="border-bottom: 1px solid #000;">No Rekam Medis</th>
            <th width="20%" style="text-align: left; border-bottom: 1px solid #000;">Alamat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Pasien</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">Tempat, Tanggal Lahir</th>
            <th width="10%" style="text-align: left;border-bottom: 1px solid #000;">Status Pasien</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">No BPJS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;">{{$no_rekamedis}}</td>
            <td style="text-align: left;">{{$poli->alamat}}</td>
            <td style="text-align: left;">{{$poli->nama_pasien}}</td>
            <td style="text-align: left;">{{$poli->tempat_lahir}}, {{$poli->tanggal_lahir}}</td>
            <td style="text-align: left;">{{$poli->status_pasien}}</td>
            <td style="text-align: left;">{{$poli->no_bpjs}}</td>
        </tr>
    </tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="3" class="table-bordered" style="border: 1px solid #000;">
                <thead>
                  <tr>
                    <th width='5%'>No</th>
                    <th>Nama Diagnosis</th>
                    <th>No Rawat</th>
                  </tr>
                </thead>
                @foreach($records as $key => $data)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$data->diagnosa}}</td>
                    <td>{{$data->no_rawat}}</td>
                  </tr>
                @endforeach
            </table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
