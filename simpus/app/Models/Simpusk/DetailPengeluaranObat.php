<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengeluaranObat extends Model
{
    use HasFactory;
    protected $table = 'tbl_detail_pengeluaran_obat';
    protected $primaryKey = 'id_detail_pengeluaran_obat';
    public $timestamps = false;
}
