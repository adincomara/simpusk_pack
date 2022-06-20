<!DOCTYPE html>
<html>
    <head>
        <title>DATA PEMBERIAN OBAT</title>
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
<h2 style="margin-bottom: 0;text-align: center;"> DATA PEMBERIAN OBAT PUSKESMAS</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3" class="table-bordered" style="border: 1px solid #000;">

    <thead>
        <tr>
            <th width="6%" style="border-bottom: 1px solid #000;">No</th>
            <th width="10%" style="text-align: left; border-bottom: 1px solid #000;">No Terima Obat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Pasien</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Kode Obat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Obat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Jenis Obat</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Dosis Aturan</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Jumlah</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Satuan</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Tgl Serah Obat</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($pengeluaran_obat as $no => $resultt)
        <tr>
            <td width="6%" style="text-align: center;" valign="top" rowspan="{{ count($resultt['detail']) }}">{{$no + 1}}</td>
            <td style="text-align: left;" rowspan="{{ count($resultt['detail']) }}">{!! $resultt['no_terima_obat ']!!}</td>
            <td style="text-align: left;" rowspan="{{ count($resultt['detail']) }}">{!! $resultt['nama_pasien ']!!}</td>
            @foreach ($resultt->detail as $result)
                <td width="6%" style="text-align: center;" valign="top" >{{$no + 1}}</td>
                <td style="text-align: left;">{!! $result->no_terima_obat !!}</td>
                <td style="text-align: left;">{!! $result->nama_pasien !!}</td>
                <td style="text-align: left;">{!! $result->kode_obat !!}</td>
                <td style='text-align:left;'>{{$result->nama_obat}}</td>
                <td style='text-align:left;'>{{$result->jenis_obat}}</td>
                <td style='text-align:left;'>{{$result->dosis_aturan_obat}}</td>
                <td style='text-align:left;'>{{$result->jumlah}}</td>
                <td style='text-align:left;'>{{$result->satuan}}</td>
                <td style='text-align:left;'>{{$result->tgl_serah_obat}}</td>

            @endforeach


        </tr>
        @endforeach --}}
        @foreach($pengeluaran_obat as $no => $value)
        <tr>
            <td rowspan="{{ count($value['detail']) }}">{{$no + 1}}</td>
            <td rowspan="{{ count($value['detail']) }}">{{ $value['no_terima_obat'] }}</td>
            <td rowspan="{{ count($value['detail']) }}">{{ $value['nama_pasien'] }}</td>
            @foreach($value['detail'] as $key => $values)
                @if($key == 0)
                <td>{{ $values['kode_obat'] }} </td>
                <td>{{ $values['nama_obat'] }} </td>
                <td>{{ $values['jenis_obat'] }} </td>
                <td>{{ $values['dosis_aturan_obat'] }} </td>
                <td>{{ $values['jumlah'] }} </td>
                <td>{{ $values['satuan'] }} </td>
                <td rowspan="{{ count($value['detail']) }}">{{ $value['tgl_serah_obat'] }}</td>
                </tr>
                @endif
                @if($key > 0)
                <tr>
                    <td>{{ $values['kode_obat'] }} </td>
                    <td>{{ $values['nama_obat'] }} </td>
                    <td>{{ $values['jenis_obat'] }} </td>
                    <td>{{ $values['dosis_aturan_obat'] }} </td>
                    <td>{{ $values['jumlah'] }} </td>
                    <td>{{ $values['satuan'] }} </td>
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
