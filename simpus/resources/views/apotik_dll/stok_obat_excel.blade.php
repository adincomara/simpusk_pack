<!DOCTYPE html>
<html>
    <head>
        <title>DATA STOK OBAT</title>

    </head>
    <body>
    <br/>



<div>
<table>

        <tr>
            <td colspan="6" style="text-align: center"><h2 style="margin-bottom: 0;text-align: center;"> DATA STOK OBAT</h2></td>
        </tr>
        <tr>
            <td>No</td>
            <td>Kode Obat</td>
            <td >Nama Obat</td>
            <td>Nama Batch</td>
            <td>Stok Obat</td>
            <td>Tanggal Expired Obat</td>
        </tr>

    @php
        $i = 1;
    @endphp
     @foreach($obats as $index => $obat)
        <tr>
            <td rowspan="{{ count($stok_obat[$index]) }}" valign="center" style='text-align:center'>{{ $i++ }}</td>
            <td rowspan="{{ count($stok_obat[$index]) }}" valign="center" style='text-align:center'>{{ $obat->kode_obat }}</td>
            <td rowspan="{{ count($stok_obat[$index]) }}" valign="center" style='text-align:center'>{{ $obat->nama_obat }}</td>
                @foreach($stok_obat[$index] as $key => $stok)
                <td>{{ $stok->batch_obat }}</td>
                <td>{{ number_format($stok->stok_obat,0,'','.') }}</td>
                <td>{{ $stok->tgl_expired_obat }}</td>
                @if(count($stok_obat[$index]) != $key+1)
                    </tr>
                    <tr>
                @endif




                @endforeach

        </tr>
        @endforeach



</table>
</div>


</body>
</html>
