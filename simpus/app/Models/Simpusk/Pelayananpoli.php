<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayananpoli extends Model
{
    use HasFactory;
    protected $table = 'tbl_pelayanan_poli';
    public $timestamps = false;

    public function poli_diagnosa(){
        return $this->hasMany(Pelayananpolidiagnosa::class, 'pelayanan_poli_id','id');
    }
    public function poli_resep(){
        return $this->hasMany(Pelayananpoliresep::class, 'pelayanan_poli_id', 'id');
    }
    public function pendaftaran(){
        return $this->hasOne(Pendaftaran::class, 'id', 'pendaftaran_id')->withDefault(
            function ($user, $post){
                $user->nama_poli = null;
            }
        );
    }
}
