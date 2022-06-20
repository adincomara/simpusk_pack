<?php

namespace App\Exports;

use App\Models\PengadaanObat;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class PengadaanObatExport implements FromCollection, WithHeadings, WithColumnFormatting,WithMapping
{
   

    public function __construct()
    {
        
    }
    /**
     * Format header excel
     */
    public function headings(): array
    {
        return [
            'No',
            'No Transaksi',
            'Total Jumlah',
            'Total Harga',
            'Tangal Transaksi',
            'Keterangan',
        ];
    }
    public function map($pengadaan_obat) : array
    {   
        
        return [
            $pengadaan_obat->no,
            $pengadaan_obat->no_trans,
            $pengadaan_obat->total_jumlah,
            $pengadaan_obat->total_harga,
            $pengadaan_obat->tgl_transaksi,
            $pengadaan_obat->keterangan,
        ];
    }

    /**
     * Format colom
     */
    public function columnFormats(): array
    {
        return [
            
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $datapengadaan_obat = PengadaanObat::all();
        
        foreach($datapengadaan_obat as $key=> $pengadaan_obat){
            $pengadaan_obat->no = $key+1;
        }

        return $datapengadaan_obat;
    }
}
