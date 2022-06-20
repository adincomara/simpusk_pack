<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianBPJS extends Model
{
    use HasFactory;
    protected $table = 'tbl_antrian_bpjs';

    public function pendaftaran(){
        return $this->hasOne(Pendaftaran::class, 'id', 'id_pendaftaran');
    }
    public function poli(){
        return $this->hasOne(Poli::class, 'kdpoli', 'code_poli');
    }
}
