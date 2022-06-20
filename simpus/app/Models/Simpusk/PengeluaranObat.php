<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranObat extends Model
{
    use HasFactory;
    protected $table = 'tbl_pengeluaran_obat';
    protected $primaryKey = 'id_pengeluaran';
    public $timestamps = false;
}
