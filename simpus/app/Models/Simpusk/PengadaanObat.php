<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Model;

class PengadaanObat extends Model
{
    protected $table = 'tbl_pengadaan_obat';
    protected $primaryKey = 'id_pengadaan';
    public $timestamps = false;
}
