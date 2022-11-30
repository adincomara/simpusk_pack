<?php

namespace App\Http\Controllers\Simpusk;

// use App\Http\Controllers\Controller;
use App\Models\Simpusk\AntrianBPJS;
use App\Models\Simpusk\Dokter;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\PasienBPJS;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function index(){
        $poli = Poli::where('status',1)->get();
        $dokterbpjs = $this->getDokterBpjs();
        $dokter = Dokter::all();
        return view('antrian/dashboard', ['poli' => $poli, 'dokter' => $dokter]);
    }
    public function generateNoRawat()
    {
      $date = date('Y-m-d');
      $next_no = '';
      $max_order = Pendaftaran::max('id');
      if ($max_order) {
          $data = Pendaftaran::find($max_order);
          $ambil = substr($data->no_rawat, -4);
      }
      if ($max_order==null) {
        $next_no = '0001';
      }elseif (strlen($ambil)<4) {
        $next_no = '0001';
      }elseif ($ambil == '9999') {
        $next_no = '0001';
      }else {
        $next_no = substr('0000', 0, 4-strlen($ambil+1)).($ambil+1);
      }
      return $date.'-'.$next_no;
    }
    public function petugas_panggil(Request $req){
        $poli = Poli::where('kdpoli', $req->poli)->first();
        $selectedPoli = $req->poli;
        $selectedDokter = $req->dokter;
        $dokter = Dokter::where('kdDokter', $req->dokter)->first();
        $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d'))->where('code_poli', $req->poli)->get();

        $antrian_now = AntrianBPJS::where('code_poli',$req->poli)->where('status', 1)->orderBy('no_antrian', 'DESC')->where('tgl_daftar', date('Y-m-d'))->first();
        // return $antrian_now;
        if(isset($antrian_now)){
            $no_antrian_now = $antrian_now->no_antrian;
        }else{
            $no_antrian_now = $poli->kode_poli.'1';
        }
        // $no_antrian_now = $poli->kode_poli.''.$antrian_now;
        // return $no_antrian_now;
        $antrian_pasien = AntrianBPJS::where('no_antrian', $no_antrian_now)->where('tgl_daftar', date('Y-m-d'))->where(function($q){
            $q->orwhere('id_pendaftaran', '!=', NULL);
            $q->orwhere('no_kartu', '!=', NULL);
            $q->orwhere('no_ktp', '!=', NULL);
        })->first();
        // return $antrian_pasien;
        if(isset($antrian_pasien)){
            $pasien = Pasien::where(function($q) use($antrian_pasien){
                if($antrian_pasien->no_ktp != '-'){
                    $q->orwhere('no_ktp', $antrian_pasien->no_ktp);
                }
                if($antrian_pasien->no_kartu != '-'){
                    $q->orwhere('no_bpjs', $antrian_pasien->no_kartu);
                }
            })->first();
            // return $pasien;
            $pendaftaran = Pendaftaran::where('no_rekamedis', $pasien->no_rekamedis)->where('tanggal_daftar', date('Y-m-d'))->first();
            // return $pasien;
        }else{
            // $no_antrian_now = $poli->kode_poli.'0';
            $pasien = null;
            $pendaftaran = null;
            $antrian_pasien = null;
        }
        // return $pendaftaran;
        return view('antrian/kioska_panggil', [
            'poli' => $poli,
            'dokter' => $dokter,
            'antrian_now' => $no_antrian_now,
            'pasien' => $pasien,
            'pendaftaran' => $pendaftaran,
            'antrian' => $antrian_pasien,
            'selectedPoli' => $selectedPoli,
            'selectedDokter' => $selectedDokter,
        ]);
    }
    public function antrian_selanjutnya($antrian){
        $kode = substr($antrian, 0, 1);
        $count = substr($antrian, 1);
        $no_antrian = $kode.''.$count;
        $antrian = AntrianBPJS::where('no_antrian',$no_antrian)->where('status', 0)->orderBy('created_at', 'ASC')->where('tgl_daftar', date('Y-m-d'))->where('waktu_panggil', NULL)->first();
        if(isset($antrian)){
            return response()->json([
                'success' => false,
                'message' => 'Antrian belum dipanggil'
            ]);
        }
        $count +=1;
        $no_antrian = $kode.''.$count;
        $antrian_next = AntrianBPJS::where('no_antrian', $no_antrian)->where('status', 0)->orderBy('created_at', 'ASC')->where('tgl_daftar', date('Y-m-d'))->whereNotNull('id_pendaftaran')->first();
        // return $antrian_next;
        if(isset($antrian_next)){
            $antrian_next->waktu_panggil = date('Y-m-d H:i:s');
            $antrian_next->status = 1;
            $antrian_next->save();
            $pasien = Pasien::orwhere('no_ktp', $antrian_next->no_ktp)->orwhere('no_bpjs', $antrian_next->no_kartu)->first();
            $pendaftaran = Pendaftaran::where('id', $antrian_next->id_pendaftaran)->where('tanggal_daftar', date('Y-m-d'))->first();
            return response()->json([
                'success' => true,
                'pasien' => $pasien,
                'pendaftaran' => $pendaftaran,
                'antrian' => $antrian_next
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada Antrian',
                'pasien' => null,
                'pendaftaran' => null
            ]);
        }
    }
    public function panggil($antrian){
        $pasien_antrian = AntrianBPJS::where('no_antrian', $antrian)->where(function($q){
            $q->where('id_pendaftaran', '!=', NULL);
            $q->where('no_kartu', '!=', NULL);
            $q->where('no_ktp', '!=', NULL);
        })->where('tgl_daftar',date('Y-m-d'))->first();
        if(!isset($pasien_antrian)){
            return response()->json([
                'success' => false,
                'message' => 'Belum ada pasien / Pasien telah membatalkan antrian',
            ]);
        }
        $pendaftaran = Pendaftaran::where('id', $pasien_antrian->id_pendaftaran)->first();
        $pasien = Pasien::where('no_rekamedis', $pendaftaran->no_rekamedis)->first();
        if($pasien_antrian->waktu_panggil == null){
            $pasien_antrian->waktu_panggil = date('Y-m-d H:i:s');
        }
        $pasien_antrian->status = 1;
        if($pasien_antrian->save()){
            return response()->json([
                'success' => true,
                'antrian' => $pasien_antrian,
                'pendaftaran' => $pendaftaran,
                'pasien' => $pasien
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'antrian gagal di simpan'
            ]);

        }
    }
    public function display(){
        $poli = Poli::where('status', 1)->get();
        // return $poli;
        foreach($poli as $key => $value){
            $value->no_antrian = $this->cek_antrian_now($value->kdpoli);
        }
        // return $poli;
        return view('antrian/kioska_display',['poli' => $poli]);
    }
    public function antrian_all(){
        $poli = Poli::where('status', 1)->get();
        foreach($poli as $key => $value){
            $value->no_antrian = $this->cek_antrian_now($value->kdpoli);
            $antrian = AntrianBPJS::where('no_antrian', $value->no_antrian)->where('tgl_daftar', date('Y-m-d'))->where(function($q){
                $q->orwhere('id_pendaftaran', '!=', NULL);
                $q->orwhere('no_kartu', '!=', NULL);
                $q->orwhere('no_ktp', '!=', NULL);
            })->first();
            if(isset($antrian)){
                $pendaftaran = Pendaftaran::where('id', $antrian->id_pendaftaran)->first();
                $pasien = Pasien::where('no_rekamedis', $pendaftaran->no_rekamedis)->first()->nama_pasien;
            }else{
                $pasien = '-';
            }
            $value->pasien = $pasien;
        }
        return response()->json([
            'success' => true,
            'poli' => $poli,
            // 'pendaftaran' => $pendaftaran
        ]);
    }
    public function cek_antrian_now($poli){
        $poli = Poli::where('kdpoli', $poli)->first();
        $antrian_now = AntrianBPJS::where('code_poli',$poli->kdpoli)->where('status', 1)->orderBy('no_antrian', 'DESC')->where('tgl_daftar', date('Y-m-d'))->first();
        if(isset($antrian_now)){
            $no_antrian_now = $antrian_now->no_antrian;
        }else{
            $no_antrian_now = $poli->kode_poli.'0';
        }
        return $no_antrian_now;
    }
    public function pendaftaran_bpjs(){
        $poli = Poli::where('status',1)->get();
        $dokter = Dokter::all();
        return view('antrian/pendaftaran_bpjs', ['poli' => $poli, 'dokter' => $dokter]);
    }
    public function search_no_kartu(Request $request){
        $search = $request->search;
        // $status = $request->status;
        $pasien = Pasien::select('*');
        if($search != ''){
            $pasien->where(function($query) use ($search){
                $query->orwhere('nama_pasien', 'LIKE', $search.'%');
                $query->orwhere('no_bpjs', 'LIKE', $search.'%');
                $query->orwhere('no_rekamedis', 'LIKE', $search.'%');
                $query->orwhere('no_ktp', 'LIKE', $search.'%');
            });
        }
        $pasien = $pasien->limit(10)->get();
        return $pasien;
    }
    public function pendaftaran_umum(){
        $poli = Poli::where('status',1)->get();
        $dokter = Dokter::all();
        return view('antrian/pendaftaran_umum', ['poli' => $poli, 'dokter' => $dokter]);
    }
    public function simpan_pendaftaran_bpjs(Request $req){
        $no_kartu = $req->no_kartu;
        $poli = Poli::where('kdpoli', $req->poli)->first();
        $dokter = Dokter::where('kdDokter', $req->dokter)->first();
        $pasien = Pasien::orwhere('no_ktp', $no_kartu)->orwhere('no_bpjs',$no_kartu)->orwhere('no_rekamedis', $no_kartu)->first();
        if(!isset($pasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien belum terdaftar pada sistem Puskesmas'
            ]);
        }
        $getbpjs = $this->getBPJS($no_kartu);
        if($getbpjs['response']['ketAktif'] != 'AKTIF'){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Status BPJS Pasien tidak aktif'
            ]);
        }
        $cekpendaftaranpasien = Pendaftaran::whereDate('tanggal_daftar', Carbon::today())->where(function($q) use ($pasien){
            $q->orwhere('no_rekamedis', $pasien->no_rekamedis);
            $q->orwhere('no_bpjs',$pasien->no_bpjs);
        })->first();
        if(isset($cekpendaftaranpasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien sudah pernah didaftarkan'
            ]);
        }
        try{
            DB::beginTransaction();
            $kdProviderPeserta = $getbpjs["response"]["kdProviderPst"]["kdProvider"];
            $noKartu = $getbpjs['response']['noKartu'];
            $pasien_bpjs = PasienBPJS::where('noKartu', $noKartu)
            ->where('kdProviderPeserta', $kdProviderPeserta)
            ->where(function($q){
                $q->whereNotNull('sistole');
                $q->whereNotNull('diastole');
                $q->whereNotNull('beratBadan');
                $q->whereNotNull('tinggiBadan');
                $q->whereNotNull('respRate');
                $q->whereNotNull('lingkarPerut');
                $q->whereNotNull('heartRate');
                $q->whereNotNull('rujukBalik');
            })->first();
            if($poli->kunjungan_sakit == 0){
                $kjsakit = false;
            }else{
                $kjsakit = true;
            }
            $url = '/pendaftaran';
            $post = [
                "kdProviderPeserta"=> $kdProviderPeserta,
                "tglDaftar"=> date('d-m-Y'),
                "noKartu"=> $noKartu,
                "kdPoli"=> $poli->kdpoli,
                "keluhan"=> null,
                "kunjSakit"=> $kjsakit,
                "sistole"=> 120,
                "diastole"=> 80,
                "beratBadan"=> 70,
                "tinggiBadan"=> 150,
                "respRate"=> 24,
                "lingkarPerut" => 56,
                "heartRate"=> 60,
                "rujukBalik"=> 0,
                "kdTkp"=> "10"
            ];
            if(isset($pasien_bpjs)){
                $post = [
                    "kdProviderPeserta"=> $kdProviderPeserta,
                    "tglDaftar"=> date('d-m-Y'),
                    "noKartu"=> $noKartu,
                    "kdPoli"=> $poli->kdpoli,
                    "keluhan"=> null,
                    "kunjSakit"=> $kjsakit,
                    "sistole"=> (int)$pasien_bpjs['sistole'],
                    "diastole"=> (int)$pasien_bpjs['diastole'],
                    "beratBadan"=> (int)$pasien_bpjs['beratBadan'],
                    "tinggiBadan"=> (int)$pasien_bpjs['tinggiBadan'],
                    "respRate"=> (int)$pasien_bpjs['respRate'],
                    "lingkarPerut" => (int)$pasien_bpjs['lingkarPerut'],
                    "heartRate"=> (int)$pasien_bpjs['heartRate'],
                    "rujukBalik"=> (int)$pasien_bpjs['rujukBalik'],
                    "kdTkp"=> "10"
                ];
            }
            $post = json_encode($post);
            $result = APIBpjsController::post($url, $post);
            // return $result;
            $no_antrian_bpjs = $result['response']['message'];
            $pendaftaran = new Pendaftaran;
            $pendaftaran->no_rawat                          = $this->generateNoRawat();
            $pendaftaran->no_rekamedis                      = $pasien->no_rekamedis;
            $pendaftaran->tanggal_daftar                    = date('Y-m-d');
            $pendaftaran->id_poli                           = $poli->kdpoli;
            $pendaftaran->id_dokter                         = $dokter['kdDokter'];
            $pendaftaran->nama_penanggung_jawab             = $dokter['nmDokter'];
            $pendaftaran->id_poli_sub                       = null;
            $pendaftaran->hubungan_dengan_penanggung_jawab  = '-';
            $pendaftaran->alamat_penanggung_jawab           = '-';
            $pendaftaran->status_pasien                     = 'BPJS';
            $pendaftaran->no_bpjs                           = $noKartu;
            $pendaftaran->sumber_pendaftaran                = 0;
            $pendaftaran->save();
            $antrian = $this->updateantrian($poli, $pendaftaran, $no_antrian_bpjs);
            $array = array(
                'poli' => $poli->nama_poli,
                'no_antrian' => $antrian->no_antrian
            );
            DB::commit();
            return response()->json([
                'antrian' => $array,
                'success' => true,
                'code' => 201,
                'message' => 'Pasien berhasil didaftarkan'
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien gagal didaftarkan '.$th->getMessage()
            ]);

        }
    }

    public function simpan_pendaftaran_umum(Request $req){
        $no_kartu = $req->no_kartu;
        $poli = Poli::where('kdpoli', $req->poli)->first();
        $dokter = Dokter::where('kdDokter', $req->dokter)->first();
        $pasien = Pasien::orwhere('no_ktp', $no_kartu)->orwhere('no_bpjs',$no_kartu)->orwhere('no_rekamedis', $no_kartu)->first();
        // return $pasien;
        if(!isset($pasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien belum terdaftar pada sistem Puskesmas'
            ]);
        }
        $cekpendaftaranpasien = Pendaftaran::whereDate('tanggal_daftar', Carbon::today())->where(function($q) use ($pasien){
            $q->orwhere('no_rekamedis', $pasien->no_rekamedis);
            $q->orwhere('no_bpjs',$pasien->no_bpjs);
        })->first();
        if(isset($cekpendaftaranpasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien sudah pernah didaftarkan'
            ]);
        }
        try{
            DB::beginTransaction();
            $pendaftaran = new Pendaftaran;
            $pendaftaran->no_rawat                          = $this->generateNoRawat();
            $pendaftaran->no_rekamedis                      = $pasien->no_rekamedis;
            $pendaftaran->tanggal_daftar                    = date('Y-m-d');
            $pendaftaran->id_poli                           = $poli->kdpoli;
            $pendaftaran->id_dokter                         = $dokter['kdDokter'];
            $pendaftaran->nama_penanggung_jawab             = $dokter['nmDokter'];
            $pendaftaran->id_poli_sub                       = null;
            $pendaftaran->hubungan_dengan_penanggung_jawab  = '-';
            $pendaftaran->alamat_penanggung_jawab           = '-';
            $pendaftaran->status_pasien                     = 'Umum';
            $pendaftaran->no_bpjs                           = '-';
            $pendaftaran->sumber_pendaftaran                = 0;
            $pendaftaran->save();
            $antrian = $this->updateantrian($poli, $pendaftaran, null);
            // return $antrian;
            $array = array(
                'poli' => $poli->nama_poli,
                'no_antrian' => $antrian->no_antrian
            );
            DB::commit();
            return response()->json([
                'antrian' => $array,
                'success' => true,
                'code' => 201,
                'message' => 'Pasien berhasil didaftarkan'
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien gagal didaftarkan '.$th->getMessage()
            ]);

        }
    }

    public function updateantrian($poli, $pendaftaran, $no_antrian_bpjs){
        // $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime($pendaftaran->tanggal_daftar)))
        // ->where('no_antrian', 'LIKE', $poli->kode_poli.'%')
        // ->where('status', 0)
        // ->where('status_daftar', 0)
        // ->orderBy('id', 'ASC')
        // ->first();
        // if(!isset($antrian)){

        // }
        $antrian_now = AntrianBPJS::where('tgl_daftar', date('Y-m-d'))->where('code_poli', $poli->kdpoli)->get();
        $no_antrian = $poli->kode_poli.''.(count($antrian_now)+1);
        $antrian = new AntrianBPJS();
        $antrian->id_pendaftaran = $pendaftaran->id;
        $antrian->no_kartu  = $pendaftaran->no_bpjs;
        $antrian->no_ktp    = $pendaftaran->pasien->no_ktp;
        $antrian->code_poli = $poli->kdpoli;
        $antrian->no_antrian = $no_antrian;
        $antrian->no_antrian_bpjs = $no_antrian_bpjs;
        $antrian->tgl_daftar = $pendaftaran->tanggal_daftar;
        $antrian->status_daftar = 1;
        $antrian->save();
        return $antrian;
    }
    public function getBPJS($no_bpjs){
        $cek = substr($no_bpjs,0,1);
        if($cek == '0'){
            $url = '/peserta/'.$no_bpjs;
        }else{
            $url = '/peserta/nik/'.$no_bpjs;
        }
        $result = APIBpjsController::get($url);
        return $result;
    }
    public function getDokterBpjs(){
        $url = '/dokter/0/100';
        $data = APIBpjsController::get($url);
        if($data['metaData']['code'] == 200){
            foreach($data['response']['list'] as $dokter){
                $dkt = Dokter::where('kdDokter', $dokter['kdDokter'])->first();
                if(!isset($dkt)){
                    $dkt = new Dokter();
                    $dkt->nmDokter = $dokter['nmDokter'];
                    $dkt->kdDokter = $dokter['kdDokter'];
                    $dkt->save();
                }
            }
        }
        return $data;
  }
    public function antriancetak($antrian){
        // return $antrian;
        return view('antrian.cetak', ['antrian' => json_decode($antrian,true)]);
    }
    public function cek_pendaftaran($key){
        $pasien = Pasien::where(function($q) use ($key){
            $q->orwhere('no_rekamedis', 'LIKE', $key.'%');
            $q->orwhere('no_ktp', 'LIKE', $key.'%');
            $q->orwhere('no_bpjs', 'LIKE', $key.'%');
        })->first();
        // return $pasien;
        $antrian = AntrianBPJS::where(function($q) use ($key){
            $q->orwhere('no_antrian', $key);
        })->where('tgl_daftar', date('Y-m-d'))->first();
        if(isset($pasien) || isset($antrian)){
            // return $pasien;
            $pendaftaran = Pendaftaran::where(function($q) use ($pasien, $antrian){
                if(isset($pasien)){
                    $q->orwhere('no_rekamedis', $pasien['no_rekamedis']);
                }elseif(isset($antrian)){
                    $q->orwhere('id', $antrian['id_pendaftaran']);
                }
            })->where('tanggal_daftar', date('Y-m-d'))->first();
        }
        if(isset($pendaftaran)){
            $pasien = Pasien::where('no_rekamedis', $pendaftaran->no_rekamedis)->first();
            $antrian = AntrianBPJS::where('id_pendaftaran', $pendaftaran->id)->where('tgl_daftar', date('Y-m-d'))->first();
            $poli = Poli::where('kdpoli', $antrian->code_poli)->first();
            $array = array(
                'poli' => $poli->nama_poli,
                'no_antrian' => $antrian->no_antrian
            );
            return response()->json([
                'success' => true,
                'pasien' => $pasien,
                'antrian' => $antrian,
                'cetak_antrian' => $array,
                'flag_periksa' => $pendaftaran->flag_periksa
            ]);
        }else{
            return response()->json([
                'success' => false,
                'pasien' => null,
                'antrian' => null,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    public function hapus($antrian){
        // return $antrian;
        $antrian = AntrianBPJS::where('id',$antrian)->first();
        $pendaftaran = Pendaftaran::where('id',$antrian->id_pendaftaran)->first();
        if($pendaftaran->flag_periksa != 0){
            return response()->json([
                'success' => false,
                'code'   => 204,
                'message' => 'Gagal dihapus, Pasien sudah dilayani'
            ]);
        }
        try{
            DB::beginTransaction();
            if($pendaftaran->status_pasien == "BPJS"){
                $deletebpjs = $this->deleteBPJS($antrian);
                if($deletebpjs['metaData']['code'] != 200){
                    return response()->json([
                        'success' => false,
                        'code'   => 304,
                        'message' => 'Gagal dihapus'
                    ]);
                }
            }
            $antrian->id_pendaftaran    = null;
            $antrian->status    = 1;
            $antrian->waktu_panggil = date('Y-m-d h:i:s');
            // $antrian->no_kartu          = null;
            // $antrian->no_ktp            = null;
            // $antrian->code_poli         = null;
            // $antrian->no_antrian_bpjs   = null;
            $antrian->save();
            $pendaftaran->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'code'   => 200,
                'message' => 'Berhasil dihapus'
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal dihapus, '.$th->getMessage()
            ]);
        }

        return $pendaftaran;

    }
    public function deleteBPJS($antrian){

        $url = '/pendaftaran/peserta/'.$antrian->no_kartu.'/tglDaftar/'.date('d-m-Y',strtotime($antrian->tgl_daftar)).'/noUrut/'.$antrian->no_antrian_bpjs.'/kdPoli/'.$antrian->code_poli;
        // $url = '/pendaftaran/peserta/0002046121615/tglDaftar/'.date('d-m-Y').'/noUrut/A1/kdPoli/001';
        $result = APIBpjsController::delete($url);
        return $result;
    }
    public function data_pasien(Request $req){
        $pasien = Pasien::where(function($q) use ($req){
            $q->orwhere('no_rekamedis', $req->no_kartu);
            $q->orwhere('no_ktp', $req->no_kartu);
            $q->orwhere('no_bpjs', $req->no_kartu);
        })->first();
        if(!isset($pasien)){
            return response()->json([
                'success' => false,
                'message' => 'Pasien tidak ditemukan',
            ]);
        }
        $url = '';
        $nik = $req->no_kartu;
        if($pasien->status_pasien == 'BPJS'){
            $url = '/peserta/'.$nik;
            $status_pasien = 1;
        }else{
            $url = '/peserta/nik/'.$nik;
            $status_pasien = 0;
        }
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari server BPJS',
            ]);
        }
        return response()->json([
            'success' => true,
            'status_pasien' => $status_pasien,
            'data_pasien' => $result['response'],
            'pasien' => $pasien,
        ]);
        return $result;
    }
}
