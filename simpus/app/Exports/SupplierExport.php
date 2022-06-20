<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class SupplierExport implements FromCollection, WithHeadings, WithColumnFormatting,WithMapping
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
            'Kode',
            'Nama',
            'Alamat',
            'No Telp',
        ];
    }
    public function map($supplier) : array
    {   
        
        return [
            $supplier->no,
            $supplier->kode_supplier,
            $supplier->nama_supplier,
            $supplier->alamat,
            $supplier->no_telpon,
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
        $datasupplier = Supplier::all();
        
        foreach($datasupplier as $key=> $supplier){
            $supplier->no = $key+1;
        }

        return $datasupplier;
    }
}
