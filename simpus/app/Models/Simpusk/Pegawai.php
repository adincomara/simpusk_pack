<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'tbl_pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;

    public function getJabatan()
    {
        return $this->belongsTo('App\Models\Jabatan', 'id_jabatan', 'id_jabatan');
    }

    public function getBidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'id_bidang', 'id_bidang');
    }
}
