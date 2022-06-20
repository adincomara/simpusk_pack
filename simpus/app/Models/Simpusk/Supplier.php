<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'tbl_supplier';
    protected $primaryKey = 'kode_supplier';
    public $timestamps = false;
    public $incrementing = false;
}
