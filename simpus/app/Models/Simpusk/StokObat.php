<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;
    protected $table = 'tbl_stok_obat';
    public $timestamps = false;

    public function get_obat(){
        return $this->hasOne(Obat::class, 'id', 'id_obat');
    }
}
