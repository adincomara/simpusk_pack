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
    {{-- <div class="text-right">Hal. [{PAGENO}/{nb}]</div> --}}
<h2 style="margin-bottom: 0;text-align: center;"> DATA 10 BESAR PENYAKIT</h2>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<div>
<table width="100%" cellspacing="0" cellpadding="3" class="table-bordered" style="border: 1px solid #000;">

    <thead>
        <tr>
            {{-- <th width="6%" style="border-bottom: 1px solid #000;">No</th> --}}
            <th width="15%" style="text-align: left; border-bottom: 1px solid #000;">Kode Diagnosa</th>
            <th width="13%" style="text-align: left; border-bottom: 1px solid #000;">Nama Diagnosa</th>
            <th width="30%" style="text-align: left;border-bottom: 1px solid #000;">Jumlah</th>
            {{-- <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Jenis Kelamin</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">NPWP</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">TTL</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Alamat</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Jabatan</th>
            <th width="20%" style="text-align: left;border-bottom: 1px solid #000;">Bidang</th> --}}
        </tr>
    </thead>
    <tbody><tr role="row" class="odd"><td class="reorder sorting_1">A19.0</td><td>Acute miliary tuberculosis of a single specified site</td><td>50</td></tr><tr role="row" class="even"><td class="reorder sorting_1">A19.8</td><td>Other miliary tuberculosis</td><td>40</td></tr><tr role="row" class="even"><td class="reorder sorting_1">A20.8</td><td>Other forms of plague</td><td>
        38</td></tr><tr role="row" class="even"><td class="reorder sorting_1">A20.3</td><td>Plague meningitis</td><td>35</td></tr><tr role="row" class="even"><td class="reorder sorting_1">A21.0</td><td>Ulceroglandular tularaemia</td><td>31</td></tr><tr role="row" class="even"><td class="reorder sorting_1">B15.9</td><td>Hepatitis A without hepatic coma</td><td>30</td></tr><tr role="row" class="even"><td class="reorder sorting_1">B08.2</td><td>Exanthema subitum [sixth disease]</td><td>28</td></tr><tr role="row" class="even"><td class="reorder sorting_1">C04.0</td><td>Malignant neoplasm of anterior floor of mouth</td><td>25</td></tr><tr role="row" class="even"><td class="reorder sorting_1">B83.4</td><td>Internal hirudiniasis</td><td>10</td></tr><tr role="row" class="even"><td class="reorder sorting_1">B71.0</td><td>Hymenolepiasis</td><td>2</td></tr></tbody>
    {{-- <tbody>
        <tr>
            <td width="6%" style="text-align:center">A19.0</td>
            <td style="text-align: left;">Acute miliary tuberculosis of a single specified site</td>
            <td style="text-align: left;">50</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">A19.8</td>
            <td style="text-align: left;">Other miliary tuberculosis</td>
            <td style="text-align: left;">40</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">A20.8</td>
            <td style="text-align: left;">Other forms of plague</td>
            <td style="text-align: left;">38</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">A20.3</td>
            <td style="text-align: left;">Plague meningitis</td>
            <td style="text-align: left;">35</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">A21.0</td>
            <td style="text-align: left;">Ulceroglandular tularaemia	</td>
            <td style="text-align: left;">31</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">B15.9</td>
            <td style="text-align: left;">Hepatitis A without hepatic coma	</td>
            <td style="text-align: left;">30</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">B08.2</td>
            <td style="text-align: left;">Exanthema subitum [sixth disease]	</td>
            <td style="text-align: left;">28</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">C04.0</td>
            <td style="text-align: left;">Malignant neoplasm of anterior floor of mouth</td>
            <td style="text-align: left;">25</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">B83.4</td>
            <td style="text-align: left;">Internal hirudiniasis</td>
            <td style="text-align: left;">10</td>
        </tr>
        <tr>
            <td width="6%" style="text-align:center">B71.0</td>
            <td style="text-align: left;">Hymenolepiasis</td>
            <td style="text-align: left;">2</td>
        </tr>


    </tbody> --}}
</table>
</div>

<htmlpagefooter name="MyFooter">
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter" value="on" show-this-page="1"/>
</body>
</html>
