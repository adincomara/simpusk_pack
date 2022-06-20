<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Simpusk\Pelayananlaboratorium;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\LaporanBPJS;
use App\Models\Simpusk\Kunjungan;
use App\Models\Simpusk\RujukLanjut;
use App\Models\Simpusk\Pendaftaran;

use DB;
use Carbon\Carbon;

class RujukanController extends Controller
{
    private function bpjs_api(){
        $base_url = 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0';

        $consID 	= '9243'; //customer ID anda
        $secretKey 	= '3yVE45CCBC'; //secretKey anda

        $pcareUname = '0159092404'; //username pcare
        $pcarePWD 	= '0159092404$2Pkm'; //password pcare anda

        $kdAplikasi	= "095"; //kode aplikasi

        $stamp		= time();
        $data 		= $consID.'&'.$stamp;

        $signature = hash_hmac('sha256', $data, $secretKey, true);

        $headers = array(
      "Accept: application/json",
      "X-cons-id:".$consID,
      "X-timestamp: ".$stamp,
      "X-signature: ".base64_encode($signature),
      "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
      "Content-Type:application/json",
    );

        $result = [];
        $result['base_url'] = $base_url;
        $result['headers'] = $headers;

        return $result;
    }

    protected $original_column = array(
      1 => "no_rawat",
      2 => "no_rekamedis",
    );

    public function pjj(){
        $value = array('Saudara Kandung','Orang Tua','Lain-lain');
        return $value;
    }
    public function status_pasien(){
        $value = array('BPJS','Umum');
        return $value;
    }
    public function index(){
      return view('integrasi_bpjs/rujukan_bpjs');
    }

    function safe_encode($string) {
        $data = str_replace(array('/'),array('_'),$string);
        return $data;
    }
    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }

    private function check_status_pulang($data){
        if($data == 0){
            $result = 'Sembuh';
        }else if($data == 1){
            $result = 'Meninggal';
        }else if($data == 3){
            $result = 'Rawat Jalan';
        }else if($data == '4'){
            $result = 'Rujuk';
        }

        return $result;
    }

    public function getData(Request $request){
        // return "tes";
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];

        $records = Kunjungan::select('tbl_kunjungan.no_kartu', 'tbl_kunjungan.no_kunjungan','tbl_kunjungan.tgl_daftar','tbl_kunjungan.status_pulang', 'tbl_pasien.no_ktp','tbl_pasien.nama_pasien', 'tbl_pasien.no_rekamedis','tbl_rujuk_lanjut.tgl_est_rujuk','tbl_rujuk_lanjut.kd_provider',
                                    'tbl_faskes_rujuk.nama_faskes','tbl_faskes_rujuk.alamat_faskes');
        $records->leftJoin('tbl_pasien','tbl_pasien.no_bpjs','tbl_kunjungan.no_kartu');
        $records->leftJoin('tbl_rujuk_lanjut', 'tbl_rujuk_lanjut.kunjungan_id', 'tbl_kunjungan.id');
        $records->leftJoin('tbl_faskes_rujuk', 'tbl_faskes_rujuk.kode_faskes','tbl_rujuk_lanjut.kd_provider');
        if(array_key_exists($request->order[0]['column'], $this->original_column)){
           $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        }else{
          $records->orderBy('tbl_kunjungan.id', 'DESC');
        }
         if($search) {
          $records->where(function ($query) use ($search) {
                  $query->orWhere('tbl_pendaftaran.no_rawat','LIKE',"%{$search}%");
          });
        }
        $totalData = $records->get()->count();
        $totalFiltered = $records->get()->count();
        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();

        foreach ($data as $key=> $record)
        {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->no_kunjungan));
            $action = "";

            $action.='<a href="'.route('rujukan.ubah',$enc_id).'"  class="btn btn-success" title="Periksa Dokter">Rubah Data Rujukan</a>&nbsp;';

            $record->no             = $key+$page;
            $date_now = Carbon::parse($record->tgl_est_rujuk)->locale('id');
            $date_now->settings(['formatFunction' => 'translatedFormat']);
            $record->tgl_rujuk      = $date_now->format('l, j F Y');

            $date_now = Carbon::parse($record->tgl_daftar)->locale('id');
            $date_now->settings(['formatFunction' => 'translatedFormat']);
            $record->tanggal_daftar = $date_now->format('l, j F Y');
            $record->status_pulang  = $this->check_status_pulang($record->status_pulang);
            $record->faskes         = $record->nama_faskes.' ( '.$record->kd_provider.' )';
            $record->action         = $action;
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    private function get_kunjungan($data){
        $bpjs_api = $this->bpjs_api();

        $ch = curl_init($bpjs_api['base_url'].'/kunjungan/peserta/'.$data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $bpjs_api['headers']);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        header("Content-Type: application/json");

        return json_decode($data);
    }

    public function ubah($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        $kunjungan = Kunjungan::where('no_kunjungan', $dec_id)->first();
        if($kunjungan){
            $rujuk_lanjut = RujukLanjut::where('kunjungan_id', $kunjungan->id)->first();
            $tgl = date('d/m/Y', strtotime($kunjungan->tgl_pulang));
            $kunjungan->tanggal_pulang = $tgl;

            $dokter = $this->getDokterBpjs($kunjungan->kd_dokter);
            $diagnosa = $this->getDiagnosa($kunjungan->kd_diagnosa);
            $kesadaran = $this->getKesadaran();

            $poli = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.tanggal_lahir','tbl_pendaftaran.status_pasien','tbl_poli.nama_poli','tbl_poli.id as poliid','tbl_pendaftaran.no_bpjs')
                            ->leftJoin('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')
                            ->leftJoin('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')
                            ->where('tbl_pendaftaran.no_bpjs',$kunjungan->no_kartu)
                            ->whereDate('tbl_pendaftaran.tanggal_daftar', date('Y-m-d', strtotime($kunjungan->tgl_daftar)))
                            ->first();
            $Lab = Pelayananlaboratorium::all();
        }

        // return response()->json([
        //     'kunjungan'     => $kunjungan,
        //     'rujuk_lanjut'  => $rujuk_lanjut,
        //     'diagnosa'      => $diagnosa,
        //     'dokter'        => $dokter,
        //     'kesadaran'     => $kesadaran,
        //     'pendaftaran'   => $poli
        // ]);
        return view('backend/pelayanan_poli/rujukan_bpjs/form', compact('enc_id','kunjungan', 'rujuk_lanjut','dokter','diagnosa', 'kesadaran', 'poli', 'Lab'));
    }

    public function daftarKunjungan(Request $request){
        // return $request->all();
        $bpjs_api = $this->bpjs_api();

        if($request->no_kunjungan != null){
          $nokunjungan = $request->no_kunjungan;
          $kdpoli     = null;
          $kdpoliinternal = $request->kdpoli;
        }else{
          $nokunjungan = null;
          $kdpoli     = $request->kdpoli;
          $kdpoliinternal = null;
        }

        $nokartu    = $request->nokartu;
        $tgldaftar  = date('d-m-Y');
        $keluhan    = $request->keluhan;
        $kdsadar    = $request->kesadaran;
        $sistole    = $request->sistole;
        $diastole   = $request->diastole;
        $berat      = $request->berat;
        $tinggi     = $request->tinggi;
        $resp       = $request->respiration;
        $heart      = $request->heart;
        $terapi     = $request->terapi;
        $stspulang  = $request->statuspulang;
        $tglpulang  = $request->tglpulang;
        $dokter     = $request->kddokter;
        $diagnosa   = $request->kddiagnosa;
        $tglrujuk   = $request->tglrujuk;
        $provider   = $request->provider;
        $spesialis  = $request->spesialis;
        $subspesialis = $request->subspesialis;
        $sarana     = $request->sarana;
        $kdkhusus   = $request->kdkhusus;
        $kdksubhusus= $request->subkhusus;
        $catatan    = $request->catatan;
        $kdtacc     = $request->kdTacc;
        $alasantacc = $request->alasanTacc;

        if($request->statuspulang == '4'){
          if($request->spesialis != null){
            $post = [
              "noKunjungan"   => $nokunjungan,
              "noKartu"       => $nokartu,
              "tglDaftar"     => $tgldaftar,
              "kdPoli"        => $kdpoli,
              "keluhan"       => $keluhan,
              "kdSadar"       => $kdsadar,
              "sistole"       => $sistole,
              "diastole"      => $diastole,
              "beratBadan"    => $berat,
              "tinggiBadan"   => $tinggi,
              "respRate"      => $resp,
              "heartRate"     => $heart,
              "terapi"        => $terapi,
              "kdStatusPulang"=> $stspulang,
              "tglPulang"     => $tglpulang,
              "kdDokter"      => $dokter,
              "kdDiag1"       => $diagnosa,
              "kdDiag2"       => null,
              "kdDiag3"       => null,
              "kdPoliRujukInternal"=> $kdpoliinternal,
              "rujukLanjut"=>[
                "tglEstRujuk" => $tglrujuk,
                "kdppk"       => $provider,
                "subSpesialis"=> [
                  "kdSubSpesialis1" => $subspesialis,
                  "kdSarana"        => $sarana
                ],
                "khusus"=> null
              ],
              "kdTacc"      => 0,
              "alasanTacc"  => null
            ];
          }else{
            $post = [
              "noKunjungan"   => $nokunjungan,
              "noKartu"       => $nokartu,
              "tglDaftar"     => $tgldaftar,
              "kdPoli"        => $kdpoli,
              "keluhan"       => $keluhan,
              "kdSadar"       => $kdsadar,
              "sistole"       => $sistole,
              "diastole"      => $diastole,
              "beratBadan"    => $berat,
              "tinggiBadan"   => $tinggi,
              "respRate"      => $resp,
              "heartRate"     => $heart,
              "terapi"        => $terapi,
              "kdStatusPulang"=> $stspulang,
              "tglPulang"     => $tglpulang,
              "kdDokter"      => $dokter,
              "kdDiag1"       => $diagnosa,
              "kdDiag2"       => null,
              "kdDiag3"       => null,
              "kdPoliRujukInternal"=> $kdpoliinternal,
              "rujukLanjut"=>[
                "tglEstRujuk" => $tglrujuk,
                "kdppk"       => $provider,
                "subSpesialis"=> null,
                "khusus"=> [
                  "kdKhusus"        => $kdkhusus,
                  "kdSubSpesialis"  => $kdksubhusus,
                  "catatan"         => $catatan
                ]
              ],
              "kdTacc"      => $kdtacc,
              "alasanTacc"  => $alasantacc
            ];
          }
        }else{
          $post = [
            "noKunjungan"   => $nokunjungan,
            "noKartu"       => $nokartu,
            "tglDaftar"     => $tgldaftar,
            "kdPoli"        => $kdpoli,
            "keluhan"       => $keluhan,
            "kdSadar"       => $kdsadar,
            "sistole"       => $sistole,
            "diastole"      => $diastole,
            "beratBadan"    => $berat,
            "tinggiBadan"   => $tinggi,
            "respRate"      => $resp,
            "heartRate"     => $heart,
            "terapi"        => $terapi,
            "kdStatusPulang"=> $stspulang,
            "tglPulang"     => $tglpulang,
            "kdDokter"      => $dokter,
            "kdDiag1"       => $diagnosa,
            "kdDiag2"       => null,
            "kdDiag3"       => null,
            "kdPoliRujukInternal"=> $kdpoliinternal,
            "rujukLanjut"=>[
              "tglEstRujuk" => null,
              "kdppk"       => 0,
              "subSpesialis"=> null,
              "khusus"=> null
            ],
            "kdTacc"      => 0,
            "alasanTacc"  => null
          ];
        }

        $post = json_encode($post);
        // return $this->simpan_data_bpjs(json_decode($post,true), $nokunjungan, $spesialis);
        // return response()->json(['data' => $simpan]);

        $ch = curl_init($bpjs_api['base_url'].'/kunjungan');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $bpjs_api['headers']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }

        curl_close($ch);

        header("Content-Type: application/json");
        $no_kun = json_decode($data, true);

        if($no_kun['metaData']['code'] != 201){
          $simpan = $this->simpan_data_bpjs(json_decode($post,true), $nokunjungan, $spesialis);
        }

        return response()->json([
          'datas' => json_decode($data, true),
          'provider' => $provider
        ]);
      }

      private function simpan_data_bpjs($data, $noKunjungan, $spesialis){
        // return $data;
        $check_kunjungan = Kunjungan::where('no_kartu', $data['noKartu'])->orWhere('no_kunjungan', $data['noKunjungan'])->whereDate('tgl_daftar', strtotime($data['tglDaftar']))->first();
        // return $check_kunjungan;
        if($check_kunjungan){
            $kunjungan                = Kunjungan::find($check_kunjungan->id);
            $kunjungan->no_kartu      = $data['noKartu'];
            $kunjungan->no_kunjungan  = $noKunjungan;
            $kunjungan->tgl_daftar    = date('Y-m-d', strtotime($data['tglDaftar']));
            $kunjungan->code_poli     = $data['kdPoli'];
            $kunjungan->code_sadar    = $data['kdSadar'];
            $kunjungan->sistole       = $data['sistole'];
            $kunjungan->diastole      = $data['diastole'];
            $kunjungan->berat_badan   = $data['beratBadan'];
            $kunjungan->tinggi_badan  = $data['tinggiBadan'];
            $kunjungan->resprate      = $data['respRate'];
            $kunjungan->heart_rate    = $data['heartRate'];
            $kunjungan->terapi        = $data['terapi'];
            $kunjungan->status_pulang = $data['kdStatusPulang'];
            $kunjungan->tgl_pulang    = date('Y-m-d', strtotime($data['tglPulang']));
            $kunjungan->kd_dokter     = $data['kdDokter'];
            $kunjungan->kd_diagnosa   = $data['kdDiag1'];
            $kunjungan->kd_tacc       = $data['kdTacc'];
            if($data['alasanTacc'] != null ){
              $kunjungan->alasan_tacc   = $data['alasanTacc'];
            }
            if($data['rujukLanjut']['subSpesialis'] != null){
              $kunjungan->type_rujuk  = 2;
            }else if($data['rujukLanjut']['khusus'] != null){
              $kunjungan->type_rujuk  = 1;
            }
            // $kunjungan->type_rujuk    =
            $kunjungan->save();
            // return $kunjungan;

            if($kunjungan){
              $rujuk  = RujukLanjut::where('kunjungan_id', $kunjungan->id)->first();
              if($data['rujukLanjut']['tglEstRujuk'] != null && $data['rujukLanjut']['kdppk'] != null){
                $rujuk->tgl_est_rujuk = date('Y-m-d', strtotime($data['rujukLanjut']['tglEstRujuk']));
                $rujuk->kd_provider   = $data['rujukLanjut']['kdppk'];
              }
              if($data['rujukLanjut']['subSpesialis'] != null){
                $rujuk->spesialis     = $spesialis;
                $rujuk->subspesialis  = $data['rujukLanjut']['subSpesialis']['kdSubSpesialis1'];
                $rujuk->kd_sarana     = $data['rujukLanjut']['subSpesialis']['kdSarana'];
              }
              if($data['rujukLanjut']['khusus'] != null){
                $rujuk->kd_khusus     = $data['rujukLanjut']['khusus']['kdkhusus'];
                $rujuk->kd_sub_khusus = $data['rujukLanjut']['khusus']['kdSubSpesialis'];
                $rujuk->catatan       = $data['rujukLanjut']['khusus']['catatan'];
              }
              $rujuk->save();
            //   return $rujuk;
            //   return $rujuk;
            }
        }else{
            $kunjungan                = new Kunjungan;
            $kunjungan->no_kartu      = $data['noKartu'];
            $kunjungan->no_kunjungan  = $noKunjungan;
            $kunjungan->tgl_daftar    = date('Y-m-d', strtotime($data['tglDaftar']));
            $kunjungan->code_poli     = $data['kdPoli'];
            $kunjungan->code_sadar    = $data['kdSadar'];
            $kunjungan->sistole       = $data['sistole'];
            $kunjungan->diastole      = $data['diastole'];
            $kunjungan->berat_badan   = $data['beratBadan'];
            $kunjungan->tinggi_badan  = $data['tinggiBadan'];
            $kunjungan->resprate      = $data['respRate'];
            $kunjungan->heart_rate    = $data['heartRate'];
            $kunjungan->terapi        = $data['terapi'];
            $kunjungan->status_pulang = $data['kdStatusPulang'];
            $kunjungan->tgl_pulang    = date('Y-m-d', strtotime($data['tglPulang']));
            $kunjungan->kd_dokter     = $data['kdDokter'];
            $kunjungan->kd_diagnosa   = $data['kdDiag1'];
            $kunjungan->kd_tacc       = $data['kdTacc'];
            if($data['alasanTacc'] != null ){
              $kunjungan->alasan_tacc   = $data['alasanTacc'];
            }
            if($data['rujukLanjut']['subSpesialis'] != null){
              $kunjungan->type_rujuk  = 2;
            }else if($data['rujukLanjut']['khusus'] != null){
              $kunjungan->type_rujuk  = 1;
            }
            // $kunjungan->type_rujuk    =
            $kunjungan->save();

            if($kunjungan){
              $rujuk  = new RujukLanjut;
              $rujuk->kunjungan_id  = $kunjungan->id;
              if($data['rujukLanjut']['tglEstRujuk'] != null && $data['rujukLanjut']['kdppk'] != null){
                $rujuk->tgl_est_rujuk = date('Y-m-d', strtotime($data['rujukLanjut']['tglEstRujuk']));
                $rujuk->kd_provider   = $data['rujukLanjut']['kdppk'];
              }
              if($data['rujukLanjut']['subSpesialis'] != null){
                $rujuk->spesialis     = $spesialis;
                $rujuk->subspesialis  = $data['rujukLanjut']['subSpesialis']['kdSubSpesialis1'];
                $rujuk->kd_sarana     = $data['rujukLanjut']['subSpesialis']['kdSarana'];
              }
              if($data['rujukLanjut']['khusus'] != null){
                $rujuk->kd_khusus     = $data['rujukLanjut']['khusus']['kdkhusus'];
                $rujuk->kd_sub_khusus = $data['rujukLanjut']['khusus']['kdSubSpesialis'];
                $rujuk->catatan       = $data['rujukLanjut']['khusus']['catatan'];
              }
              $rujuk->save();
            }
        }
    }

    private function getDiagnosa($param){
        $keywoard = explode('.', $param);

        $bpjs_api = $this->bpjs_api();

        $ch = curl_init($bpjs_api['base_url'].'/diagnosa/'.$keywoard[0].'/0/15');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $bpjs_api['headers']);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        header("Content-Type: application/json");

        $datas = json_decode($data, true);
        $check_loop = $datas['response']['list'] ;
        foreach ($check_loop as $key => $value) {
            if($value['kdDiag'] == $param){
                $data = $value;
            }

            $result = $data;
        }
        return $result;
    }

    private function getDokterBpjs($dokter){
        $bpjs_api = $this->bpjs_api();

        $ch = curl_init($bpjs_api['base_url'].'/dokter/0/33');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $bpjs_api['headers']);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        header("Content-Type: application/json");

        $datas = json_decode($data, true);
        $check_loop = $datas['response']['list'];
        foreach ($check_loop as $key => $value) {
            if($value['kdDokter'] == $dokter){
                $data = $value;
            }
            $result = $data;
        }
        return $result;
    }

    public function getKesadaran(){
        $bpjs_api = $this->bpjs_api();

        $ch = curl_init($bpjs_api['base_url'].'/kesadaran');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $bpjs_api['headers']);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        header("Content-Type: application/json");

        $datas = json_decode($data, true);
        return $datas['response']['list'];
    }

}
