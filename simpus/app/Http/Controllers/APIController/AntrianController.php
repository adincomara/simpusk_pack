<?php

namespace App\Http\Controllers\APIController;

// use App\Http\Controllers\Controller;

use App\Http\Controllers\Simpusk\APIBpjsController;
use App\Http\Controllers\Simpusk\Controller;
use App\Models\Simpusk\AntrianBPJS;
use App\Models\Kk;
use App\Models\Simpusk\DokterBPJS;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\PasienBPJS;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\P;
use Throwable;

class AntrianController extends Controller
{
    public function __construct()
    {
    //   $this->middleware('auth:api', ['except' => ['login']]);
      $this->middleware('check');
    }
    public function generateNoRekam()
    {
        $next_no = '';
        $max_order = Pasien::max('id');
        if ($max_order) {
        $data = Pasien::find($max_order);
        $ambil = substr($data->no_rekamedis, -6);
        }
        if ($max_order == null) {
        $next_no = '000001';
        } elseif (strlen($ambil) < 6) {
        $next_no = '000001';
        } elseif ($ambil == '999999') {
        $next_no = '000001';
        } else {
        $next_no = substr('000000', 0, 6 - strlen($ambil + 1)) . ($ambil + 1);
        }
        return $next_no;
    }
    public function status_antrean($kdpoli, $tgl_periksa){
        $poli = Poli::where('kdpoli', $kdpoli)->first();
        $antrean = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime($tgl_periksa)))->get();
        $antrian_now = AntrianBPJS::where('code_poli',$poli->kdpoli)->where('status', 1)->orderBy('no_antrian', 'DESC')->where('tgl_daftar', date('Y-m-d'))->first();
        // return $antrian_now;
        if(isset($antrian_now)){
            $no_antrian_now = $antrian_now->no_antrian;
        }else{
            $no_antrian_now = $poli->kode_poli.'1';
        }
        $sisaantrean = (int)count($antrean) - (int)substr($no_antrian_now, 1);
        if($sisaantrean < 0 ){
            $sisaantrean = 0;
            $no_antrian_now = $poli->kode_poli.'0';
        }
        return response()->json([
            'response' => array(
                'namapoli' => $poli->nama_poli,
                'totalantrean' => "".count($antrean),
                'sisaantrean' => "".$sisaantrean,
                'antreanpanggil' => "".$no_antrian_now,
                'keterangan' => '',
            ),
            'metadata' => array(
                'message' => 'Ok',
                'code' => 200
            ),
        ]);
    }
    public function create_antrean(Request $request){
        $pasien = Pasien::where(function($q) use ($request){
            $q->orwhere('no_bpjs', $request['nomorkartu']);
            $q->orwhere('no_ktp', $request['nik']);
        })->first();
        if(!isset($pasien)){
            return response()->json([
                'response' => 'Pasien belum terdaftar kedalam sistem',
                'metadata' => array(
                    'message' => 'Pasien belum terdaftar kedalam sistem',
                    'code' => 202
                )
            ]);
        }
        if(date('Y-m-d',strtotime($request->tanggalperiksa)) != date('Y-m-d')){
            return response()->json([
                'response' => 'Tanggal yang dimasukkan bukan tanggal hari ini',
                'metadata' => array(
                    'message' => 'Tanggal yang dimasukkan bukan tanggal hari ini',
                    'code' => 201
                )
            ]);
        }
        $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d'))
        ->where('no_kartu', $request['nomorkartu'])
        ->where('no_ktp', $request['nik'])
        ->where('code_poli',$request['kodepoli'])
        ->where('status_daftar', 0)
        ->whereNotNull('id_pendaftaran')
        ->orderBy('created_at', 'DESC')
        ->first();
        // return $antrian;
        if(isset($antrian)){
            if($antrian->status == 0){
                return response()->json([
                    'metadata' => array(
                        'message' => 'Pasien sudah pernah didaftarkan, dan antrian belum terlewati',
                        'code' => 201
                    )
                ]);
            }
        }
        return $this->simpan_antrian_bpjs($request);
    }
    public function simpan_antrian_bpjs($req){
        // return $req;
        $no_kartu = $req->nomorkartu;
        $poli = Poli::where('kdpoli', $req->kodepoli)->first();
        $dokter = DokterBPJS::first();
        // return $dokter;
        $pasien = Pasien::where('no_ktp', $req->nik)->where('no_bpjs',$req->nomorkartu)->first();
        if(!isset($pasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien belum terdaftar pada sistem Puskesmas'
            ]);
        }
        $getbpjs = $this->getBPJS($no_kartu);
        if(empty($getbpjs['response']['ketAktif'])){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Gagal mengambil data dari BPJS'
            ]);
        }

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
        })->where('id_poli', $req->kodepoli)->where('flag_antrian', 0)->first();
        // return $cekpendaftaranpasien;
        if(isset($cekpendaftaranpasien)){
            if($cekpendaftaranpasien->flag_periksa == 1){
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'Pasien sudah pernah didaftarkan, dan dilayani'
                ]);
            }
        }
        try{
            DB::beginTransaction();
            if(isset($cekpendaftaranpasien)){
                $cekpendaftaranpasien->created_at = date('Y-m-d h:i:s');
                $cekpendaftaranpasien->save();
                $antrian = AntrianBPJS::where('id_pendaftaran', $cekpendaftaranpasien->id)->first();
                $antrian = $this->updateantrian($poli, $cekpendaftaranpasien, $antrian->no_antrian_bpjs);
            }else{
                // return 'tes';
                $result = $this->post_pendaftaran_bpjs($poli, $getbpjs);
                // if(empty($result['response']['message'])){
                //     $noKartu = $getbpjs['response']['noKartu'];
                //     $url = '/pendaftaran/peserta/'.$noKartu.'/tglDaftar/'.date('d-m-Y').'/noUrut/'.$antrian->no_antrian_bpjs.'/kdPoli/'.$antrian->code_poli;
                //     $result = APIBpjsController::delete($url);
                // }
                $no_antrian_bpjs = $result['response']['message'];
                $pendaftaran = Pendaftaran::where('no_rekamedis', $req->no_rekamedis)->where('no_bpjs',$req->no_bpjs)->where('flag_antrian', 1)->whereDate('tanggal_daftar', Carbon::today())->where('id_poli', $poli->kdpoli)->first();
                if(!isset($pendaftaran)){
                    $pendaftaran = new Pendaftaran;
                }
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
                $pendaftaran->no_bpjs                           = $getbpjs['response']['noKartu'];
                $pendaftaran->sumber_pendaftaran                = 1;
                $pendaftaran->flag_antrian                      = 0;
                $pendaftaran->save();
                $antrian = $this->updateantrian($poli, $pendaftaran, $no_antrian_bpjs);

            }
            $antrian_now = AntrianBPJS::where('code_poli',$poli->kdpoli)->where('status', 1)->orderBy('no_antrian', 'DESC')->where('tgl_daftar', date('Y-m-d'))->first();
            if(isset($antrian_now)){
                $no_antrian_now = $antrian_now->no_antrian;
            }else{
                $no_antrian_now = $poli->kode_poli.'1';
            }
            $sisaantrean = (int)substr($antrian->no_antrian,1) - (int)substr($no_antrian_now, 1);
            DB::commit();
            return response()->json([
                'response' => array(
                    'nomorantrean'      => $antrian->no_antrian,
                    'angkaantrean'      => substr($antrian->no_antrian, 1),
                    'nama_poli'         => $poli->nama_poli,
                    'sisaantrean'       => $sisaantrean,
                    'antrianpanggil'    => $no_antrian_now,
                    'keterangan'        => 'Apabila antrean terlewati harap mengambil antrean kembali',
                ),
                'metadata' => array(
                    'message'   => 'Ok',
                    'code'      => 200
                )
            ]);


        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'response' => 'Gagal, '.$th->getMessage(),
                'metadata' => array(
                    'message'   => 'Gagal, '.$th->getMessage(),
                    'code'      => 201
                )
            ]);

        }
    }
    public function updateantrian($poli, $pendaftaran, $no_antrian_bpjs){
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
        $antrian->status_daftar = 0;
        $antrian->save();
        return $antrian;
    }
    public function post_pendaftaran_bpjs($poli, $getbpjs){
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
        return $result;
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
    public function sisa_antrean($nokartu, $kdpoli, $tgl_periksa){
        $poli = Poli::where('kdpoli',$kdpoli)->first();
        // return $poli;
        $antrian = AntrianBPJS::where('no_kartu', $nokartu)
        ->where('code_poli',$kdpoli)
        ->where('tgl_daftar', date('Y-m-d', strtotime($tgl_periksa)))
        ->whereNotNull('id_pendaftaran')
        ->where('status_daftar', 0)
        ->first();

        // VALIDATOR
        if(date('Y-m-d') != date('Y-m-d', strtotime($tgl_periksa))){
            return response()->json([
                'response' => array(
                    'message' => 'Tanggal periksa yang dimasukkan bukan tanggal hari ini'
                ),
                'metadata' => array(
                    'message' => 'Tanggal periksa yang dimasukkan bukan tanggal hari ini',
                    'code' => 201,
                ),
            ]);
        }
        if(!isset($poli)){
            return response()->json([
                'response' => array(
                    'message' => 'Poli tidak terdaftar',
                ),
                'metadata' => array(
                    'message' => 'Poli yang dimasukkan tidak terdaftar',
                    'code' => 201,
                ),
            ]);
        }
        if(!isset($antrian)){
            return response()->json([
                'response' => array(
                    'message' => 'Pasien belum terdaftar',
                ),
                'metadata' => array(
                    'message' => 'Ok',
                    'code' => 201,
                ),
            ]);
        }
        //END VALIDATOR
        $antrian_now = AntrianBPJS::where('code_poli',$poli->kdpoli)
        ->where('status', 1)
        ->orderBy('no_antrian', 'DESC')
        ->where('tgl_daftar', date('Y-m-d'))
        ->first();
            if(isset($antrian_now)){
                $no_antrian_now = $antrian_now->no_antrian;
            }else{
                $no_antrian_now = $poli->kode_poli.'1';
            }
            $sisaantrean = (int)substr($antrian->no_antrian,1) - (int)substr($no_antrian_now, 1);
            if($sisaantrean < 0){
                $sisaantrean = 'Antrean sudah terlewati';
            }
        return response()->json([
            'response' => array(
                'message' => array(
                    'nomorantrean' => "".$antrian->no_antrian,
                    'namapoli' => $poli->nama_poli,
                    'sisaantrean' => "".$sisaantrean,
                    'antreanpanggil' => $no_antrian_now,
                    'keterangan' => '',
                )
            ),
            'metadata' => array(
                'message' => 'Ok',
                'code' => 201,
            ),
        ]);
    }
    public function batal_antrean_(Request $request){
        $antrian = AntrianBPJS::where('no_kartu', $request->nomorkartu)
        ->where('tgl_daftar', date('Y-m-d', strtotime($request->tanggalperiksa)))
        ->where('code_poli', $request->kodepoli);
        // return $antrian;
        $getantrian = $antrian->get();
        if(isset($getantrian)){
            $pendaftaranbpjs = $this->get_pendaftaranbpjs($antrian->get()[0]['no_antrian_bpjs'], date('d-m-Y', strtotime($request->tanggalperiksa)));
            if($pendaftaranbpjs['response']['status'] == 'Baru'){
                $deletebpjs = $this->deleteBPJS($antrian->get()[0]);
                $pendaftaran = Pendaftaran::find($antrian->get()[0]['id_pendaftaran']);
                if($deletebpjs['metaData']['code'] == 304){
                    if($antrian->delete() && $pendaftaran->delete()){
                        return response()->json([
                            'metadata' => array(
                                'message' => 'Ok',
                                'code' => 200,
                            ),
                        ]);
                    }else{
                        return response()->json([
                            'metadata' => array(
                                'message' => 'Gagal dibatalkan, gagal menghapus data di database SIMPUSK',
                                'code' => 201,
                            ),
                        ]);
                    }
                }else{
                    return response()->json([
                        'metadata' => array(
                            'message' => 'Gagal dibatalkan, gagal menghapus di database BPJS',
                            'code' => 201,
                        ),
                    ]);
                }
            }else{
                return response()->json([
                    'metadata' => array(
                        'message' => 'Gagal dibatalkan, Pasien sudah dilayani',
                        'code' => 201,
                    ),
                ]);
            }
            return $pendaftaranbpjs['response']['status'];
        }else{
            return response()->json([
                'metadata' => array(
                    'message' => 'Gagal dibatalkan, Pasien belum pernah mengambil antrean',
                    'code' => 201,
                ),
            ]);
        }
    }
    public function create_pasien(Request $request){
        // return "tes";
        $cek_pasien = Pasien::where('no_ktp', $request->nik)
        ->where('no_bpjs', $request->nomorkartu)
        ->first();
        // return $cek_pasien;
        //VALIDASI
        if(isset($cek_pasien)){
            return response()->json([
                'metadata' => array(
                    'message' => 'Pasien sudah terdaftar di sistem SIMPUSK',
                    'code' => 201
                )
            ]);
        }
        $alamat_domisili = "Kel ".$request->namakel." RT ".$request->rt."/RW ".$request->rw." kec ".$request->namakec." ".$request->namakel." ".$request->namaprop;
        $pasien = new Pasien;
        $pasien->no_rekamedis   = $this->generateNoRekam();
        $pasien->no_ktp         = $request->nik;
        $pasien->no_bpjs        = $request->nomorkartu;
        $pasien->no_kk          = $request->nomorkk;
        $pasien->nama_pasien    = str_replace("'","",$request->nama);
        $pasien->jenis_kelamin  = $request->jeniskelamin;
        $pasien->tempat_lahir   = $request->namadati2;
        $pasien->tanggal_lahir  = date('d-m-Y', strtotime($request->tanggallahir));
        $pasien->alamat         = $request->alamat;
        $pasien->alamat_domisili = $alamat_domisili;
        $pasien->kode_prov      = $request->kodeprop;
        $pasien->kode_kab       = $request->kodedati2;
        $pasien->kode_kec       = $request->kodekec;
        $pasien->kode_kel       = $request->kodekel;
        $pasien->prov           = $request->namaprop;
        $pasien->kab            = $request->namadati2;
        $pasien->kec            = $request->namakec;
        $pasien->kel            = $request->namakel;
        $pasien->rt             = $request->rt;
        $pasien->rw             = $request->rw;
        $pasien->telp           = null;
        $pasien->status_pasien  = "BPJS";
        $pasien->media_pendaftaran = 1;
        if($pasien->save()){
            return response()->json([
                'metadata' => array(
                    'message' => 'Ok',
                    'code' => 200
                )
            ]);
        }else{
            return response()->json([
                'metadata' => array(
                    'message' => 'Gagal menyimpan ke database SIMPUSK',
                    'code' => 201
                )
            ]);
        }
        // return $pasien;
    }
    // public function batal_antrean(Request $req){
    //     // return $antrian;
    //     $antrian = AntrianBPJS::where('no_kartu',$req->nomorkartu)->where('code_poli', $req->kodepoli)->where('tgl_daftar', $req->tanggalperiksa)->first();
    //     $pendaftaran = Pendaftaran::where('id',$antrian->id_pendaftaran)->first();
    //     if($pendaftaran->flag_periksa != 0){
    //         return response()->json([
    //             'success' => false,
    //             'code'   => 204,
    //             'message' => 'Gagal dihapus, Pasien sudah dilayani'
    //         ]);
    //     }
    //     try{
    //         DB::beginTransaction();
    //         if($pendaftaran->status_pasien == "BPJS"){
    //             $deletebpjs = $this->deleteBPJS($antrian);
    //             if($deletebpjs['metaData']['code'] != 200){
    //                 return response()->json([
    //                     'success' => false,
    //                     'code'   => 304,
    //                     'message' => 'Gagal dihapus'
    //                 ]);
    //             }
    //         }
    //         $antrian->id_pendaftaran    = null;
    //         // $antrian->no_kartu          = null;
    //         // $antrian->no_ktp            = null;
    //         // $antrian->code_poli         = null;
    //         // $antrian->no_antrian_bpjs   = null;
    //         $antrian->save();
    //         $pendaftaran->delete();
    //         DB::commit();
    //         return response()->json([
    //             'success' => true,
    //             'code'   => 200,
    //             'message' => 'Berhasil dihapus'
    //         ]);
    //     }catch(\Throwable $th){
    //         DB::rollback();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data Gagal dihapus, '.$th->getMessage()
    //         ]);
    //     }

    //     return $pendaftaran;

    // }
    public function batal_antrean(Request $request){
        // return $request->all();
        $antrian = AntrianBPJS::where('no_kartu', $request->nomorkartu)
        ->where('code_poli', $request->kodepoli)
        ->whereNotNull('id_pendaftaran')
        ->where('tgl_daftar', date('Y-m-d', strtotime($request->tanggalperiksa)))
        ->first();
        $poli = Poli::where('kdpoli', $request->kodepoli)->first();


        //VALIDASI
        if(!isset($antrian)){
            return response()->json([
                'metadata' => array(
                    'message'   => 'Pasien tidak terdaftar',
                    'code'      =>  201
                )
            ]);
        }
        if(!isset($poli)){
            return response()->json([
                'metadata' => array(
                    'message'   => 'Poli tidak terdaftar',
                    'code'      =>  201
                )
            ]);
        }
        $pendaftaran = Pendaftaran::where('id',$antrian->id_pendaftaran)->where('flag_antrian', 0)->first();
        $pendaftaran->flag_antrian = 1;
        if($pendaftaran->flag_periksa != 0){
            return response()->json([
                'metadata'  => array(
                    'message'   => 'Gagal dihapus, Pasien sudah dilayani',
                    'code'      => 201,
                )
            ]);
        }
        //END VALIDASI
        try{
            DB::beginTransaction();
            $deletebpjs = $this->deleteBPJS($antrian);
            if($deletebpjs['metaData']['code'] != 200){
                return response()->json([
                    'metadata' => array(
                        'message' => 'Gagal dihapus dari server BPJS',
                        'code'   => 201,
                    )
                ]);
            }
            $antrian->id_pendaftaran    = null;
            $antrian->status    = 1;
            $antrian->waktu_panggil = date('Y-m-d h:i:s');
            // $antrian->no_kartu          = null;
            // $antrian->no_ktp            = null;
            // $antrian->code_poli         = null;
            // $antrian->no_antrian_bpjs   = null;
            $antrian->save();
            $pendaftaran->save();
            DB::commit();
            return response()->json([
                'metadata' => array(
                    'message' => 'Ok',
                    'code'   => 200,
                )
            ]);

        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'metadata' => array(
                    'message' => 'Gagal '.$th->getMessage(),
                    'code'   => 201,
                )
            ]);
        }


    }
    public function deleteBPJS($antrian){

        // $url = '/pendaftaran/peserta/0002046121615/tglDaftar/'.date('d-m-Y').'/noUrut/A1/kdPoli/001';
        $url = '/pendaftaran/peserta/'.$antrian->no_kartu.'/tglDaftar/'.date('d-m-Y',strtotime($antrian->tgl_daftar)).'/noUrut/'.$antrian->no_antrian_bpjs.'/kdPoli/'.$antrian->code_poli;
        $result = APIBpjsController::delete($url);
        return $result;
    }
}
