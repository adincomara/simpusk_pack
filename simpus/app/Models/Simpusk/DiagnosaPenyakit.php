<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Model;

class DiagnosaPenyakit extends Model
{
    protected $table = 'tbl_diagnosa_penyakit';
    protected $primaryKey = 'kode_diagnosa';
    public $incrementing = false;
    public $timestamps = false;
}
