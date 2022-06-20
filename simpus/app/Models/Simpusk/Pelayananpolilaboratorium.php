<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayananpolilaboratorium extends Model
{
    use HasFactory;
    protected $table = 'tbl_pelayanan_poli_laboratorium';
    public $timestamps = false;

    public function pelayananlaboratorium(){
        return $this->hasOne(Pelayananlaboratorium::class, 'id', 'pelayanan_laboratorium_id');
    }

}
