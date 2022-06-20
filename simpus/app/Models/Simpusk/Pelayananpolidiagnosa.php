<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayananpolidiagnosa extends Model
{
    use HasFactory;
    protected $table = 'tbl_pelayanan_poli_diagnosa';
    public $timestamps = false;

    public function nama_diagnosa(){
        return $this->hasOne(DiagnosaPenyakit::class,'kode_diagnosa' ,'diagnosa');
    }

}
