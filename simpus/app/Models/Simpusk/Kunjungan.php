<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'tbl_kunjungan';

    public function pasien(){
        return $this->hasOne(Pasien::class, 'no_bpjs', 'no_kartu');
    }
    public function pendaftaran(){
        return $this->hasOne(Pendaftaran::class, 'id', 'id_pendaftaran');
    }
    public function rujuk_lanjut(){
        return $this->hasOne(RujukLanjut::class, 'kunjungan_id', 'id');
    }
    public function faskes_rujuk(){
        return $this->hasOne(FaskesRujuk::class, 'kode_faskes', 'kd_faskes_rujuk');
    }
    public function diagnosa1(){
        return $this->hasOne(DiagnosaPenyakit::class, 'kode_diagnosa', 'kd_diagnosa1');
    }
    public function diagnosa2(){
        return $this->hasOne(DiagnosaPenyakit::class, 'kode_diagnosa', 'kd_diagnosa2');
    }
    public function diagnosa3(){
        return $this->hasOne(DiagnosaPenyakit::class, 'kode_diagnosa', 'kd_diagnosa3');
    }
}
