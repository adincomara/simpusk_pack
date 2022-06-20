<!DOCTYPE html>
<html>
    <head>
        <title>DATA PENGADAAN OBAT</title>
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
<h2 style="margin-bottom: 0;text-align: center;"> DATA PENGADAAN OBAT</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3" style="border: 1px solid #000;">

    <thead>
        <tr>
            <th width="5%" rowspan="2" style="border-bottom: 1px solid #000;">No</th>
            <th width="10%" rowspan="2" style="text-align: left; border-bottom: 1px solid #000;border-left: 1px solid #000;">No Transaksi</th>
            <th width="35%" colspan="5" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Obat</th>
            <th width="35%" colspan="2" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Supplier</th>
            <th width="10%" rowspan="2" style="text-align: left;border-bottom: 1px solid #000;border-left: 1px solid #000;">Total Jumlah</th>
            <th width="10%" rowspan="2" style="text-align: left;border-bottom: 1px solid #000;border-left: 1px solid #000;">Total Harga</th>
            <th width="10%" rowspan="2" style="text-align: left;border-bottom: 1px solid #000;border-left: 1px solid #000;">Tangal Transaksi</th>
            <th width="20%" rowspan="2" style="text-align: left; border-bottom: 1px solid #000;border-left: 1px solid #000;">Keterangan</th>
        </tr>
        <tr>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Kode</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Nama</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Jumlah</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Harga</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Total</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Kode</th>
            <th width="10%" style="text-align: center; border-bottom: 1px solid #000;border-left: 1px solid #000;">Nama</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengadaan_obat as $no => $result)
        @if(isset($result) && count($result->detailPengadaan)>0)
        <tr>
            <td rowspan="{{ $result->length_detail }}" width="6%" style="text-align: center;">{{$no + 1}}</td>
            <td rowspan="{{ $result->length_detail }}" style="text-align: left;border-left: 1px solid #000;">{!! $result->no_trans !!}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->obat->kode_obat}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->obat->nama_obat}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->jumlah}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->harga_beli}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->total_harga}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->supplier->kode_supplier}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$result->detailPengadaan[0]->supplier->nama_supplier}}</td>
            <td rowspan="{{ $result->length_detail }}" style='text-align:left;border-left: 1px solid #000;'>{!! $result->total_jumlah !!}</td>
            <td rowspan="{{ $result->length_detail }}" style='text-align:left;border-left: 1px solid #000;'>{!! $result->total_harga !!}</td>
            <td rowspan="{{ $result->length_detail }}" style='text-align:left;border-left: 1px solid #000;'>{!! $result->tgl_transaksi !!}</td>
            <td rowspan="{{ $result->length_detail }}" style='text-align:left;border-left: 1px solid #000;'>{{$result->keterangan}}</td>

        </tr>
        @endif
            @foreach ($result->detailPengadaan as $key => $item)
            @if ($key > 0)
            <tr>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->obat->kode_obat}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->obat->nama_obat}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->jumlah}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->harga_beli}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->total_harga}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->supplier->kode_supplier}}</td>
            <td style='text-align:left;border-left: 1px solid #000;'>{{$item->supplier->nama_supplier}}</td>
            </tr>
            @endif
            @endforeach
        @endforeach
    </tbody>
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
