<?php

namespace App\Exports;

use App\Models\StokObat;
use App\Models\Obat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;


class StokObatExport implements FromView,ShouldAutoSize
{

    protected $search;
    public function __construct($search)
    {
        $this->search = $search;
    }
    /**
     * Format header excel
     */
    public function view(): View
    {
        $stok_obat = StokObat::all();

        $search = $this->search;
        //return $search;

        $records = StokObat::distinct()->select('id_obat');


        if ($search != "") {
            $id = array();
            $key = Obat::where('nama_obat', 'LIKE', "%{$search}%")->orWhere('kode_obat', 'LIKE', "%{$search}%")->get('id');
            foreach($key as $k){
                $id[] = $k->id;
            }


            $records->where(function ($query) use ($search) {
                $query->orWhere('id_obat', 'LIKE', "%{$search}%");
            })->orWhere(function($query) use ($id){
                if($id){
                    $query->orWhereIn('id_obat', $id);
                }

            });
        }



        $data = $records->get();
        foreach ($data as $key => $record) {



            $obat = Obat::where('id', $record->id_obat)->first();


            $record->kode_obat  = $obat->kode_obat;
            $record->nama_obat  = $obat->nama_obat;
            $stokobat = number_format(StokObat::where('id_obat', $record->id_obat)->sum('stok_obat'), 0, '','.');
            $record->stok_obat  = $stokobat;

        }

       // return $records->get();
       $stok_obat = array();
        foreach($records->get() as $d){
            $stok_obat[] = StokObat::where('id_obat',$d->id_obat)->get();
        }
        $obats = array();
        foreach($records->get() as $d){
            $obats[] = Obat::where('id',$d->id_obat)->first();
        }
        return view('apotik_dll/stok_obat_excel', ['stok_obat'=>$stok_obat, 'obats'=>$obats]);
    }
    // public function headings(): array
    // {
    //     return [
    //         'No',
    //         'Kode Obat',
    //         'Nama Obat',
    //         'Nama Batch',
    //         'Stok Obat',
    //         'Tanggal Expired Obat'
    //     ];
    // }
    // public function map($stok_obat) : array
    // {

    //     return [
    //         $stok_obat->no,
    //         $stok_obat->kode_obat,
    //         $stok_obat->nama_obat,
    //         $stok_obat->batch_obat,
    //         $stok_obat->stok_obat,
    //         $stok_obat->tgl_expired_obat

    //     ];
    // }

    // /**
    //  * Format colom
    //  */
    // public function columnFormats(): array
    // {
    //     return [

    //     ];
    // }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     $datastok_obat = StokObat::all();

    //     foreach($datastok_obat as $key=> $stok_obat){
    //         $stok_obat->no = $key+1;
    //         $obat = Obat::where('id', $stok_obat->id_obat)->first();
    //         $stok_obat->kode_obat = $obat->kode_obat;
    //         $stok_obat->nama_obat = $obat->nama_obat;
    //     }

    //     return $datastok_obat;
    // }
}
