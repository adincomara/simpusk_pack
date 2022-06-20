<!DOCTYPE html>
<html>
    <head>
        <title>DATA STOK OBAT</title>
        <style type="text/css">

            .text-center {
                text-align: center
            }
            .text-right {
                text-align: right
            }
            table {
                border-left: 0.01em solid #000;
                border-right: 0;
                border-top: 0.01em solid #000;
                border-bottom: 0;
                border-collapse: collapse;
            }
            table td,
            table th {
                border-left: 0;
                border-right: 0.01em solid #000;
                border-top: 0;
                border-bottom: 0.01em solid #000;
            }

        </style>

    </head>
    <body>
<htmlpageheader name="MyHeader1">
    <br/>
    <div class="text-right">Hal. [{PAGENO}/{nb}]</div>
<h2 style="margin-bottom: 0;text-align: center;"> DATA STOK OBAT</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" class="table-bordered" cellspacing="0" cellpadding="3"  style="border-bottom: 1px solid #000;">

    <thead>
        <tr>
            <th width="6%" style="border-bottom: 1px solid #000;">No</th>
            <th width="10%" style="text-align: left; border-bottom: 1px solid #000;">Kode Obat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Obat</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">Nama Batch</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">Stok Obat</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">Tanggal Expired Obat</th>
        </tr>
    </thead>
    @php
        $i = 1;
    @endphp
    <tbody>
    @foreach($obats as $index => $obat){
        <tr>
            <td rowspan="{{ count($stok_obat[$index]) }}">{{ $i++ }}</td>
            <td rowspan="{{ count($stok_obat[$index]) }}">{{ $obat->kode_obat }}</td>
            <td rowspan="{{ count($stok_obat[$index]) }}">{{ $obat->nama_obat }}</td>
                @foreach($stok_obat[$index] as $stok)
                <td>{{ $stok->batch_obat }}</td>
                <td>{{ number_format($stok->stok_obat,0,'','.') }}</td>
                <td>{{ $stok->tgl_expired_obat }}</td>
                </tr>
                    <tr>
                @endforeach

        </tr>
    }
    @endforeach
        {{-- @for($i=1;$i<5;$i++)
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        @endfor --}}
    </tbody>
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
