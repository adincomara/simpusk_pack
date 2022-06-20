<!DOCTYPE html>
<html>
    <head>
        <title>DATA LAPORAN TINDAKAN PASIEN</title>
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
 <h2 style="margin-bottom: 0;text-align: center;"> DATA LAPORAN TINDAKAN PASIEN </h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
    <table width="100%" cellspacing="0" cellpadding="3" class="table-bordered" style="border: 1px solid #000;">

    <thead>
        <tr>
            <th width="25%" style="border-bottom: 1px solid #000;">Tindakan</th>
            <th width="10%" style="text-align: left; border-bottom: 1px solid #000;">Tanggal</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Pasien</th>
        </tr>
    </thead>
    <tbody>
        <?php
                  echo $data;
                  ?>
    </tbody>
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
