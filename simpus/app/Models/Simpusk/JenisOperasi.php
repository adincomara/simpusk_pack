<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisOperasi extends Model
{
    use HasFactory;
    protected $table = 'tbl_jenis_operasi';
    public $timestamps = false;

}
