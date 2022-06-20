<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = 'tbl_pendaftaran';
    public $timestamps = false;

    public function poli(){
        return $this->hasOne(Poli::class, 'id', 'id_poli')->withDefault([
            'nama_poli' => null
        ]);
    }
    public function pasien(){
        return $this->hasOne(Pasien::class, 'no_rekamedis', 'no_rekamedis');
    }
    public function pelayanan_poli(){
        return $this->hasOne(Pelayananpoli::class, 'pendaftaran_id', 'id');
    }
    public function kunjungan(){
        return $this->hasOne(Kunjungan::class, 'id_pendaftaran', 'id');
    }

}
