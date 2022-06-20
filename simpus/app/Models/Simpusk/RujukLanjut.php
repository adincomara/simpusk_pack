<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RujukLanjut extends Model
{
    use HasFactory;
    protected $table = 'tbl_rujuk_lanjut';

    public function nama_faskes(){
        return $this->hasOne(FaskesRujuk::class, 'kode_faskes', 'kd_provider');
    }
}
