<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayananpoliresep extends Model
{
    use HasFactory;
    protected $table = 'tbl_pelayanan_poli_resep';
    public $timestamps = false;

    public function obat(){
        return $this->hasOne(Obat::class, 'id', 'obat_id');
    }

}
