<!DOCTYPE html>
<html>
    <head>
        <title>DATA PEGAWAI</title>
        <style type="text/css">
        
        .text-center {
            text-align: center
        }
        .text-right {
            text-align: right
        }
       
        </style>
       
    </head>
    <body>
<htmlpageheader name="MyHeader1">
    <br/>
    <div class="text-right">Hal. [{PAGENO}/{nb}]</div>
<h2 style="margin-bottom: 0;text-align: center;"> DATA JABATAN NAKES PUSKESMAS</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3" style="border-bottom: 1px solid #000;">

    <thead>
        <tr>
            <th width="6%" style="border-bottom: 1px solid #000;">No</th>
            <th width="10%" style="text-align: left; border-bottom: 1px solid #000;">NIP</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Pegawai</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">NIK</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Jenis Kelamin</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">NPWP</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">TTL</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Alamat</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Jabatan</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Bidang</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pegawai as $no => $result)
        <tr>
            <td width="6%" style="text-align: center;" valign="top" >{{$no + 1}}</td>
            <td style="text-align: left;">{!! $result->nip !!}</td>
            <td style='text-align:left;'>{{$result->nama_pegawai}}</td>
            <td style='text-align:left;'>{!! $result->nik !!}</td>
            <td style='text-align:left;'>{{$result->jenis_kelamin}}</td>
            <td style='text-align:left;'>{{$result->npwp}}</td>
            <td style='text-align:left;'>{{$result->tempat_lahir}}, {{$result->tanggal_lahir}}</td>
            <td style='text-align:left;'>{{$result->alamat}}</td>
            <td style='text-align:left;'>{{$result->getJabatan?$result->getJabatan->nama_jabatan:'-'}}</td>
            <td style='text-align:left;'>{{$result->getBidang?$result->getBidang->nama_bidang:'-'}}</td>
          
        </tr>
        @endforeach
        @for($i=1;$i<5;$i++)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
