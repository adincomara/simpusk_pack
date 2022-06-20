<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'tbl_obat';
    public $timestamps = false;
}
