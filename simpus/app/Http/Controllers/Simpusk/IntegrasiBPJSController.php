<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Kunjungan;
use App\Models\Simpusk\LaporanBPJS;
use App\Models\Simpusk\Obat;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pelayananlaboratorium;
use App\Models\Simpusk\Pelayananpoli;
use App\Models\Simpusk\Pelayananpolidiagnosa;
use App\Models\Simpusk\Pelayananpolilaboratorium;
use App\Models\Simpusk\Pelayananpoliresep;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\RujukLanjut;
use App\Models\Simpusk\Tindakan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;

class IntegrasiBPJSController extends Controller
{
    protected $original_column = array(
        1 => "no_rawat",
        2 => "no_rekamedis",
    );
    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }
    function safe_decode($string, $mode = null)
    {
        $data = str_replace(array('_'), array('/'), $string);
        return $data;
    }
    public function index(){
        return view('integrasi_bpjs/rujukan_bpjs');
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
    public function getDataRujukan(Request $request){
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
    public function ubah($enc_id){
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        $kunjungan = Kunjungan::where('no_kunjungan', $dec_id)->first();

        // if($kunjungan){
        //     $rujuk_lanjut = RujukLanjut::where('kunjungan_id', $kunjungan->id)->first();
        //     $tgl = date('d/m/Y', strtotime($kunjungan->tgl_pulang));
        //     $kunjungan->tanggal_pulang = $tgl;

        //     $dokter = $this->getDokterBpjs($kunjungan->kd_dokter);
        //     $diagnosa = $this->getDiagnosa($kunjungan->kd_diagnosa);
        //     $kesadaran = $this->getKesadaran();

        //     $poli = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.tanggal_lahir','tbl_pendaftaran.status_pasien','tbl_poli.nama_poli','tbl_poli.id as poliid','tbl_pendaftaran.no_bpjs')
        //                     ->leftJoin('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')
        //                     ->leftJoin('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')
        //                     ->where('tbl_pendaftaran.no_bpjs',$kunjungan->no_kartu)
        //                     ->whereDate('tbl_pendaftaran.tanggal_daftar', date('Y-m-d', strtotime($kunjungan->tgl_daftar)))
        //                     ->first();
        //     $Lab = Pelayananlaboratorium::all();
        // }
        $rujuk_lanjut = array();
        $dokter = array();
        $diagnosa = array();
        $kesadaran = array();
        $poli = array();
        $Lab = array();
        return view('backend/pelayanan_poli/rujukan_bpjs/form', compact('enc_id','kunjungan', 'rujuk_lanjut','dokter','diagnosa', 'kesadaran', 'poli', 'Lab'));
    }

    public function pasienBPJS()
    {
        //$pasien = Pasien::all();
        return view('integrasi_bpjs/pasien_bpjs');
    }
    public function getdatapasienBPJS(Request $request)
    { {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = Pasien::select('*')->where('status_pasien', 'BPJS');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $records->where(function ($query) use ($search) {
            $query->orWhere('no_rekamedis', 'LIKE', "%{$search}%");
            $query->orWhere('no_ktp', 'LIKE', "%{$search}%");
            $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
            $query->orWhere('no_bpjs', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->no_bpjs));
            $action = "";


            $action .= '<a href="' . route('report.detailBPJS', $enc_id) . '"  class="btn btn-success" title="Pasien BPJS">Lihat Detail</a>&nbsp;';





            $record->no             = $key + $page;
            $record->DT_RowId       = $record->id;
            $record->no_rekamedis   = $record->no_rekamedis;
            $record->no_ktp         = $record->no_ktp;
            $record->no_bpjs        = $record->no_bpjs;
            $record->nama_pasien    = $record->nama_pasien;
            $record->jenis_kelamin  = $record->jenis_kelamin;
            $record->tempat_lahir   = $record->tempat_lahir;
            $record->tanggal_lahir  = $record->tanggal_lahir;
            $record->ttl            = $record->tempat_lahir . "," . $record->tanggal_lahir;
            $record->alamat         = $record->alamat;
            $record->status_pasien  = $record->status_pasien;
            $record->action     = $action;
        }

        if ($request->user()->can('pasien.index')) {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );
        } else {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => 0,
            "recordsFiltered" => 0,
            "data"            => []
            );
        }
        return json_encode($json_data);
        }
    }
    public function rujukanBPJS()
    {
        //$pasien = Pasien::all();
        return view('integrasi_bpjs/rujukan_pasien_bpjs');
    }
    public function getdatarujukanBPJS(Request $request)
    { {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];
        $search_tgl = $request->search_tgl;
        // return $search_tgl;

        // $records = LaporanBPJS::select('*');
        $records = Kunjungan::select('*');
        $records->whereHas('pendaftaran.pasien');
        $records->where('status_pulang', 4);
        if($search_tgl){
            $records->whereDate('created_at', date('Y-m-d 00:00:00', strtotime($search_tgl)));
        }


        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $records->where(function ($query) use ($search) {
            $query->orWhere('no_rekamedis', 'LIKE', "%{$search}%");
            $query->orWhere('no_ktp', 'LIKE', "%{$search}%");
            $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
            $query->orWhere('no_bpjs', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        // return $data;
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->no_kunjungan));
            $action = "";

            if($record->no_kunjungan != '-'){
                $action .= '<a href="' . route('report.printRujukan', $record->no_kunjungan) . '" target="_blank"  class="btn btn-success" title="Detail Rujukan"><i class="fa fa-eye"></i></a>&nbsp;';
            }else{
                $action .= '<a href="' . route('report.printRujukanUmum', $record->id_pendaftaran) . '" target="_blank" class="btn btn-success" title="Detail Rujukan"><i class="fa fa-eye"></i></a>&nbsp;';
            }

            $record->no             = $key + $page;
            $record->DT_RowId       = $record->id;
            $record->nokunjungan    = $record->no_kunjungan;
            $record->nokartu        = $record->no_kartu;
            $record->nama_pasien    = $record->pendaftaran->pasien->nama_pasien;

            $record->tglkunjungan   = $record->rujuk_lanjut->tgl_est_rujuk;

            $record->action      = $action;
        }

        if ($request->user()->can('pasien.index')) {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );
        } else {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => 0,
            "recordsFiltered" => 0,
            "data"            => []
            );
        }
        return json_encode($json_data);
        }
    }
    public function daftarKunjungan($request, $kunjungan){
        // return "tes";
        //   return $pendaftaran;
        $poli = Poli::find($request->poli_id);
        // return $poli;
        if($kunjungan->no_kunjungan != null){
            $nokunjungan = $kunjungan->no_kunjungan;
            $kdpoli     = null;
            $kdpoliinternal = $poli->kdpoli;
        }else{
            $nokunjungan = null;
            $kdpoli     = $poli->kdpoli;
            $kdpoliinternal = null;
        }
        // return $kunjungan->pendaftaran;
        $nokartu    = $request->no_bpjs;
        $tgldaftar  = date('d-m-Y', strtotime($kunjungan->pendaftaran->tanggal_daftar));
        $keluhan    = $request->keluhan;
        $kdsadar    = $request->kesadaran;
        $sistole    = $request->sistole;
        $diastole   = $request->diastole;
        $berat      = $request->berat;
        $tinggi     = $request->tinggi;
        $resp       = $request->resp;
        $heart      = $request->heart;
        $terapi     = $request->terapi;
        $stspulang  = $request->status_pulang;
        $tglpulang  = date('d-m-Y',strtotime($request->tglpulang));
        $dokter     = $request->kdDokter;
        $diagnosa1   = $request->diagnosa1;
        $diagnosa2   = $request->diagnosa2;
        $diagnosa3   = $request->diagnosa3;
        $tglrujuk   = $request->tglrujuk;
        $provider   = $request->provider;
        $spesialis  = $request->spesialis;
        $subspesialis = $request->subspesialis;
        $sarana     = $request->sarana;
        $kdkhusus   = $request->kdkhusus;
        $kdksubhusus= $request->subkhusus;
        $catatan    = $request->catatan;
        $kdtacc     = $request->tacc;
        $alasantacc = $request->alasanTacc;

        if($request->status_pulang == '4'){
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
                "kdDiag1"       => $diagnosa1,
                "kdDiag2"       => $diagnosa2,
                "kdDiag3"       => $diagnosa3,
                "kdPoliRujukInternal"=> $kdpoliinternal,
                "rujukLanjut"=>[
                    "tglEstRujuk" => date('d-m-Y',strtotime($tglrujuk)),
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
                "kdDiag1"       => $diagnosa1,
                "kdDiag2"       => $diagnosa2,
                "kdDiag3"       => $diagnosa3,
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
                "kdDiag1"       => $diagnosa1,
                "kdDiag2"       => $diagnosa2,
                "kdDiag3"       => $diagnosa3,
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

        if($kunjungan->pendaftaran->status_pasien == "BPJS"){
            $uri = env('API_URL'); //url web service bpjs
            $consID 	= env('API_CONSID'); //customer ID anda
            $secretKey 	= env('API_SECRETKEY'); //secretKey anda

            $pcareUname = env('API_PCAREUNAME'); //username pcare
            $pcarePWD 	= env('API_PCAREPWD'); //password pcare anda

            $kdAplikasi	= env('API_KDAPLIKASI'); //kode aplikasi


            $stamp    = time();
            $data     = $consID.'&'.$stamp;

            $signature = hash_hmac('sha256', $data, $secretKey, true);
            $encodedSignature = base64_encode($signature);
            $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);

            // $headers = array(
            //             "Accept: application/json",
            //             "X-cons-id:".$consID,
            //             "X-timestamp: ".$stamp,
            //             "X-signature: ".$encodedSignature,
            //             "X-authorization: Basic " .$encodedAuthorization
            //         );

            $headers = array(
                "Accept: application/json",
                "X-cons-id:".$consID,
                "X-timestamp: ".$stamp,
                "X-signature: " .base64_encode($signature),
                "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
                'Content-Type:application/json',

            );

            // return $post;

            $post = json_encode($post);
            //  return $this->simpan_data_bpjs(json_decode($post,true), '015909241221Y000352', $spesialis);
            // return response()->json(['data' => $simpan]);

            $ch = curl_init($uri.'/kunjungan');
            // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
            $data = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            }

            // return curl_error($ch);

            curl_close($ch);

            header("Content-Type: application/json");
            // return $data;
            $no_kun = json_decode($data, true);
            if($no_kun['metaData']['code'] == 201){
                $no_kunjungan = $no_kun['response']['message'];
                // $no_kunjungan = "015909241221Y000352";
                $simpan = $this->simpan_data_bpjs(json_decode($post,true), $no_kunjungan, $spesialis, $kunjungan->pendaftaran, $request);
                if($simpan['success'] == true){
                    return array(
                        "nokunjungan" => $no_kunjungan,
                        "success" => true,
                        "code" => 201,
                        "message" => "Data Berhasil Disimpan",
                    );
                }else{
                    return $simpan;
                }
            }else{
                return array(
                    'print' => false,
                    'success' => false,
                    'datas' => json_decode($data, true),
                    'provider' => $provider
                );
            }
        }else{
            // return $post;
            $post = json_encode($post);
            $no_kunjungan = "-";
            $simpan = $this->simpan_data_bpjs(json_decode($post,true), $no_kunjungan, $spesialis, $kunjungan->pendaftaran, $request);
            // return $simpan;
            if($simpan['success'] == true){
                return array(
                    "nokunjungan" => $no_kunjungan,
                    "success" => true,
                    "code" => 201,
                    "message" => "Data Berhasil Disimpan",
                );
            }else{
                return $simpan;
            }
        }

        // $no_kun['metaData']['code'] = 201;\



        // return response()->json([
        //   'success' => true,
        //   'datas' => json_decode($data, true),
        //   'provider' => $provider
        // ]);
    }
    private function simpan_data_bpjs($data, $noKunjungan, $spesialis, $pendaftaran, $request){
        // return $pendaftaran->id;
        $check_kunjungan = Kunjungan::where('id_pendaftaran', $pendaftaran->id)->first();
        // $check_kunjungan = Kunjungan::where('no_kartu', $data['noKartu'])->orWhere('no_kunjungan', $data['noKunjungan'])->whereDate('tgl_daftar', strtotime($data['tglDaftar']))->first();
        // return $check_kunjungan;
        $poli = Poli::find($request->poli_id);
        if($check_kunjungan){
          $kunjungan                = Kunjungan::find($check_kunjungan->id);
          $kunjungan->no_kartu      = $data['noKartu'];
          $kunjungan->no_kunjungan  = $noKunjungan;
          $kunjungan->tgl_daftar    = date('Y-m-d', strtotime($data['tglDaftar']));
          $kunjungan->code_poli     = $poli->kdpoli;
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
          $kunjungan->kd_diagnosa1   = $data['kdDiag1'];
          $kunjungan->kd_diagnosa2   = $data['kdDiag2'];
          $kunjungan->kd_diagnosa3   = $data['kdDiag3'];
          $kunjungan->kd_faskes_rujuk = $data['rujukLanjut']['kdppk'];
          $kunjungan->kd_tacc       = $data['kdTacc'];
          $kunjungan->catatan       = $request->catatan;
            //   $kunjungan->catatan = $data['catatan'];
          if($data['alasanTacc'] != null ){
            $kunjungan->alasan_tacc   = $data['alasanTacc'];
          }
          if($data['rujukLanjut']['subSpesialis'] != null){
            $kunjungan->type_rujuk  = 2;
          }else if($data['rujukLanjut']['khusus'] != null){
            $kunjungan->type_rujuk  = 1;
          }
          if($kunjungan->save()){
              if($request->status_pulang == '4'){
                    $rujuk  = RujukLanjut::where('kunjungan_id', $kunjungan->id)->first();
                    if(isset($rujuk)){
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
                        if($rujuk->save()){
                            $datalaporan['nokunjungan'] = $noKunjungan;
                            $datalaporan['nokartu'] = $data['noKartu'];
                            $datalaporan['tgldaftar'] = $data['tglDaftar'];
                            $datalaporan['pendaftaran'] = $pendaftaran;
                            return array(
                                "success" => true,
                                "code" => 201,
                                "message" => "Data Laporan Berhasil Disimpan"
                            );
                            // $laporanbpjs = $this->insertlaporanbpjs($datalaporan);
                            // if($laporanbpjs['success'] == true){
                            //     return array(
                            //         "success" => true,
                            //         "code" => 201,
                            //         "message" => "Data Laporan Berhasil Disimpan"
                            //     );
                            // }else{
                            //     return array(
                            //         "print" => false,
                            //         "success" => false,
                            //         "code" => 401,
                            //         "message" => "Data Laporan Gagal Disimpan"
                            //     );
                            // }
                        }else{
                            return array(
                                "print" => false,
                                "success" => false,
                                "code" => 401,
                                "message" => "Data Rujuk Lanjut Gagal Disimpan"
                            );
                        }
                    }else{
                        // return "tes";
                        $rujuk = new RujukLanjut;
                        $rujuk->kunjungan_id = $kunjungan->id;
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
                        // return $rujuk;
                        if($rujuk->save()){
                            $datalaporan['nokunjungan'] = $noKunjungan;
                            $datalaporan['nokartu'] = $data['noKartu'];
                            $datalaporan['tgldaftar'] = $data['tglDaftar'];
                            $datalaporan['pendaftaran'] = $pendaftaran;
                            return array(
                                "success" => true,
                                "code" => 201,
                                "message" => "Data Laporan Berhasil Disimpan"
                            );
                            // $laporanbpjs = $this->insertlaporanbpjs($datalaporan);
                            // if($laporanbpjs['success'] == true){
                            //     return array(
                            //         "success" => true,
                            //         "code" => 201,
                            //         "message" => "Data Laporan Berhasil Disimpan"
                            //     );
                            // }else{
                            //     return array(
                            //         "print" => false,
                            //         "success" => false,
                            //         "code" => 401,
                            //         "message" => "Data Laporan Gagal Disimpan"
                            //     );
                            // }
                        }else{
                            return array(
                                "print" => false,
                                "success" => false,
                                "code" => 401,
                                "message" => "Data Rujuk Lanjut Gagal Disimpan"
                            );
                        }
                    }
                    // $rujuk  = RujukLanjut::where('kunjungan_id', $kunjungan->id);
                    // $rujuk->kunjungan_id = $kunjungan->id;

              }else{
                return array(
                    "success" => true,
                    "code" => 201,
                    "message" => "Data Laporan Berhasil Disimpan"
                );
                    // $datalaporan['nokunjungan'] = $noKunjungan;
                    // $datalaporan['nokartu'] = $data['noKartu'];
                    // $datalaporan['tgldaftar'] = $data['tglDaftar'];
                    // $datalaporan['pendaftaran'] = $pendaftaran;
                    // $laporanbpjs = $this->insertlaporanbpjs($datalaporan);
                    // if($laporanbpjs['success'] == true){

                    // }else{
                    //     return array(
                    //         "print" => false,
                    //         "success" => false,
                    //         "code" => 401,
                    //         "message" => "Data Laporan Gagal Disimpan"
                    //     );
                    // }
              }

          }else{
            return array(
                "print" => false,
                "success" => false,
                "code" => 401,
                "message" => "Data Kunjungan Gagal Disimpan"
            );
          }
        }else{
            // return "tes";
          $kunjungan                = new Kunjungan;
          $kunjungan->id_pendaftaran = $pendaftaran->id;
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
          $kunjungan->kd_diagnosa1   = $data['kdDiag1'];
          $kunjungan->kd_diagnosa2   = $data['kdDiag2'];
          $kunjungan->kd_diagnosa3   = $data['kdDiag3'];
          $kunjungan->kd_faskes_rujuk = $data['rujukLanjut']['kdppk'];
          $kunjungan->kd_tacc       = $data['kdTacc'];
          $kunjungan->catatan       = $request->catatan;
          if($data['alasanTacc'] != null ){
            $kunjungan->alasan_tacc   = $data['alasanTacc'];
          }
          if($data['rujukLanjut']['subSpesialis'] != null){
            $kunjungan->type_rujuk  = 2;
          }else if($data['rujukLanjut']['khusus'] != null){
            $kunjungan->type_rujuk  = 1;
          }
          // $kunjungan->type_rujuk    =


          if($kunjungan->save()){
              if($request->status_pulang == '4'){
                    if($data['rujukLanjut']['kdppk'] != 0){
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
                        if(!$rujuk->save()){
                            return array(
                                "print" => false,
                                "success" => false,
                                "code" => 401,
                                "message" => "Data Rujuk Lanjut Gagal Disimpan"
                            );
                        }
                        $datalaporan['nokunjungan'] = $noKunjungan;
                        $datalaporan['nokartu'] = $data['noKartu'];
                        $datalaporan['tgldaftar'] = $data['tglDaftar'];
                        $datalaporan['pendaftaran'] = $pendaftaran;
                        $laporanbpjs = $this->insertlaporanbpjs($datalaporan);
                        if($laporanbpjs['success'] == true){
                            return array(
                                "success" => true,
                                "code" => 201,
                                "message" => "Data Laporan Berhasil Disimpan"
                            );
                        }else{
                            return array(
                                "print" => false,
                                "success" => false,
                                "code" => 401,
                                "message" => "Data Laporan Gagal Disimpan"
                            );
                        }

                    }
              }else{
                    $datalaporan['nokunjungan'] = $noKunjungan;
                    $datalaporan['nokartu'] = $data['noKartu'];
                    $datalaporan['tgldaftar'] = $data['tglDaftar'];
                    $datalaporan['pendaftaran'] = $pendaftaran;
                    $laporanbpjs = $this->insertlaporanbpjs($datalaporan);
                    if($laporanbpjs['success'] == true){
                        return array(
                            "success" => true,
                            "code" => 201,
                            "message" => "Data Laporan Berhasil Disimpan"
                        );
                    }else{
                        return array(
                            "print" => false,
                            "success" => false,
                            "code" => 401,
                            "message" => "Data Laporan Gagal Disimpan"
                        );
                    }
              }
          }else{
            return array(
                "print" => false,
                "success" => false,
                "code" => 401,
                "message" => "Data Kunjungan Gagal Disimpan"
            );
          }
        }


    }
    public function simpanPelayananPoli($req, $kunjungan){
        $Pelayananpoli = Pelayananpoli::where('pendaftaran_id',$kunjungan->id_pendaftaran)->first();

        $Pelayananpoli->pendaftaran_id         = $req->pendaftaran_id;
        $Pelayananpoli->penunjang              = $req->penunjang;
        $Pelayananpoli->note                   = $req->note;
        $Pelayananpoli->dokter_id              = $req->kdDokter;
        $Pelayananpoli->created_at             = date('Y-m-d H:i:s');
        if(!$Pelayananpoli->save()){
            return array(
                "success" => false,
                "message" => "Gagal menyimpan pelayanan poli",
                "code" => 401
            );
        }
        $ppolidiagnosa = Pelayananpolidiagnosa::where('pelayanan_poli_id', $Pelayananpoli->id);
        if(!$ppolidiagnosa->delete()){
            return array(
                "success" => false,
                "message" => "Gagal mengupdate pelayanan poli diagnosa",
                "code" => 401
            );
        }
        for($i=1; $i<=3 ; $i++){
            if($req->input('diagnosa'.$i) != null){
              $ppolidiagnosa = new Pelayananpolidiagnosa;
              $ppolidiagnosa->pelayanan_poli_id = $Pelayananpoli->id;
              $ppolidiagnosa->diagnosa = $req->input('diagnosa'.$i);
              if($ppolidiagnosa->save()){
                  continue;
              }else{
                  return array(
                      "success" => false,
                      "message" => "Gagal menyimpan diagnosa",
                      "code" => 401
                  );
                  break;
              }
            }
        }
        if($Pelayananpoli->penunjang == "T"){
            $pendaftaran = Pendaftaran::find($req->pendaftaran_id);
            $pendaftaran->flag_periksa = 1;
            $pendaftaran->save();
          if($pendaftaran){
            //   $total_d = $req->total_diagnosa;
            //   for($i=1;$i<=$total_d;$i++){
            //     if($req->input('nama_diagnosi_'.$i) != ""){
            //       $ppolidiagnosa = new Pelayananpolidiagnosa;

            //       $ppolidiagnosa->pelayanan_poli_id      = $Pelayananpoli->id;
            //       $ppolidiagnosa->tindakan_id            = $req->input('tindakan_'.$i);
            //       $ppolidiagnosa->diagnosa               = $req->input('nama_diagnosi_'.$i);
            //       if($ppolidiagnosa->save()){
            //           continue;
            //       }else{
            //           return array(
            //             "success" => false,
            //             "message" => "Gagal menyimpan diagnosa",
            //             "code" => 401
            //           );
            //           break;
            //       }

            //     }
            //   }
                $poliresep = Pelayananpoliresep::where('pelayanan_poli_id', $Pelayananpoli->id);
                  if(!$poliresep->delete()){
                    return array(
                        "success" => false,
                        "message" => "Gagal mengupdate pelayanan poli resep",
                        "code" => 401
                    );
                  }
              if($req->total_obat != 0){
                for ($i=1; $i <= $req->total_obat ; $i++) {
                  if($req->input('obat_'.$i) != "" || $req->input('obat_'.$i) != "0"){
                    //   return $req->input('obat_'.$i);
                    $poliresep    = new Pelayananpoliresep;

                    $poliresep->pelayanan_poli_id = $Pelayananpoli->id;
                    $poliresep->obat_id           = $req->input('obat_'.$i);
                    $poliresep->jumlah            = $req->input('jumlah_obat_'.$i);
                    // $poliresep->cara_pakai        = $req->input('cara_pakai_obat_'.$i);
                    $poliresep->aturan_pakai      = $req->input('aturan_pakai_obat_'.$i);
                    if($poliresep->save()){
                        continue;
                    }else{
                        return array(
                            "success" => false,
                            "message" => "Gagal menyimpan obat",
                            "code" => 401
                        );
                    }
                  }
                }
              }
              return array(
                  "success" => true,
                  "message" => "Data berhasil disimpan",
                  "code" => 201,
              );
          }else{
            return array(
                "success" => false,
                "message" => "Pasien sudah dilayani atau belum mendaftar",
                "code" => 401,
            );
          }
            return array(
                "success" => true,
                "message" => "Data berhasil disimpan",
                "code" => 201,
            );

        }else{
            $datalab = Pelayananpolilaboratorium::where('pelayanan_poli_id', $Pelayananpoli->id);
            if(!$datalab->delete()){
                return array(
                    "success" => false,
                    "message" => "Gagal mengupdate pelayanan poli laboratorium",
                    "code" => 401
                );
            }
            // return $Pelayananpoli;
            if($Pelayananpoli){
                $datalab = Pelayananlaboratorium::all();
                foreach($datalab as $lab){
                $cekLab    = $req->input('lab_pemeriksaan_'.$lab->id);
                if($cekLab == 1){
                    $p_lab = new Pelayananpolilaboratorium;
                    $p_lab->pelayanan_poli_id         = $Pelayananpoli->id;
                    $p_lab->pelayanan_laboratorium_id = $lab->id;
                    $p_lab->nilai = 0;
                    if($p_lab->save()){
                        continue;
                    }else{
                        return array(
                            "success" => false,
                            "code" => 401,
                            "message" => "Data lab gagal disimpan",
                        );
                    }
                }
                }
                if(!empty($p_lab)) {
                $pendaftaran = Pendaftaran::find($req->pendaftaran_id);
                $pendaftaran->flag_periksa = 1;
                if($pendaftaran->save()){
                    return array(
                        "success" => true,
                        "message" => "Data berhasil disimpan",
                        "code" => 201,
                    );
                }else{
                    return array(
                        "success" => false,
                        "code" => 401,
                        "message" => "Data pendaftaran gagal disimpan",
                    );
                }
                }
            }
            return array(
                "success" => true,
                "message" => "Data berhasil disimpan",
                "code" => 201,
            );
      }
    }

    public function kunjungan_simpan(Request $req){
        // return $req->all();
        // return $req->enc_id;
        $dec_id = $this->safe_decode(Crypt::decryptString($req->enc_id));
        $kunjungan = Kunjungan::find($dec_id);
        // return $kunjungan->pendaftaran;
        $daftar_kunjungan =  $this->daftarKunjungan($req, $kunjungan);
        if($daftar_kunjungan['success'] == true){
            $simpanpelayananpoli = $this->simpanPelayananPoli($req, $kunjungan);
            if($simpanpelayananpoli['success'] == true){
                return response()->json([
                    "success" => true,
                    "message" => "Data berhasil disimpan",
                    "code" => 201,
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Data gagal disimpan di pelayanan poli",
                    "code" => 201,
                ]);
            }
        }else{
            return response()->json([
                "success" => false,
                "message" => "Data gagal disimpan di kunjungan pasien",
                "code" => 201,
            ]);
        }

    }
    public function get_rujukan_bpjs($no_rujukan){
        $uri = env('API_URL'); //url web service bpjs
        $consID 	= env('API_CONSID'); //customer ID anda
        $secretKey 	= env('API_SECRETKEY'); //secretKey anda

        $pcareUname = env('API_PCAREUNAME'); //username pcare
        $pcarePWD 	= env('API_PCAREPWD'); //password pcare anda

        $kdAplikasi	= env('API_KDAPLIKASI'); //kode aplikasi


        $stamp		= time();
        $data 		= $consID.'&'.$stamp;

        $signature = hash_hmac('sha256', $data, $secretKey, true);
        $encodedSignature = base64_encode($signature);
        $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);

        $headers = array(
                    "Accept: application/json",
                    "X-cons-id:".$consID,
                    "X-timestamp: ".$stamp,
                    "X-signature: ".base64_encode($signature),
                    "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
                );
        $ch = curl_init($uri.'/kunjungan/rujukan/'.$no_rujukan);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        return $data;
    }
    function print_rujukan($enc_id)
    {

        // return "tes";
        $nokunjungan = $enc_id;
        // return $nokunjungan;
        // $databpjs = $this->get_rujukan_bpjs("015909241221Y000352");
        $databpjs = $this->get_rujukan_bpjs($nokunjungan);
        $data = Kunjungan::where('no_kunjungan', $nokunjungan)->first();
        // return $data->faskes_rujuk;
        // return $databpjs['response'];

        if($databpjs['metaData']['code'] == 200){
            return view('integrasi_bpjs/print_rujuk', ['nokunjungan'=>$nokunjungan, 'databpjs' => $databpjs['response'], 'data' => $data]);
        }else{
            return "gagal mengambil data bpjs";
        }
        //return $databpjs;
        // $data = Kunjungan::where('no_kunjungan', $enc_id)->first();
        // if(!isset($data)){
        //     return "Data Tidak Ditemukan";
        // }
    }
    function print_rujukanumum($enc_id){
        // return $enc_id;
        // $tes = Pelayananpoli::with(['pendaftaran.poli'])->find('4');
        // $poli = $tes->pendaftaran->poli->nama_poli;

        // return $poli;
        $kunjungan = Kunjungan::where('id_pendaftaran', $enc_id)->first();
        // return $kunjungan->pasien;
        $pelayanan_poli = Pelayananpoli::where('pendaftaran_id', $enc_id)->first();
        // return date('d-m-Y', strtotime($kunjungan->created_at));
        // return Carbon::today();

        $total_rujuk = Kunjungan::whereDate('created_at', date('Y-m-d 00:00:00', strtotime($kunjungan->created_at)))->where('status_pulang',4)->whereNotIn('id_pendaftaran',[$kunjungan->id_pendaftaran])->get();
        // return $total_rujuk;
        $no_rujuk = count($total_rujuk)+1;
        // return $no_rujuk;
        // return count($pelayanan_poli->poli_diagnosa);
        // return $kunjungan->rujuk_lanjut;
        return view('integrasi_bpjs/print_rujukumum', ['kunjungan' => $kunjungan, 'pelayanan_poli' => $pelayanan_poli, 'no_rujuk' => $no_rujuk]);
    }
    public function KunjunganPasienBPJS(){
        // return "tes";
        return view('integrasi_bpjs/kunjungan_pasien_bpjs');
    }
    public function getdatakunjunganpasienBPJS(Request $request)
    { {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];
        $search_tgl = $request->search_tgl;

        $records = Kunjungan::select('*')->whereHas('pendaftaran.pasien');
        // $records->pendaftaran->pasien->orwhere('nama_pasien', 'Alone testing');
        // $records->whereHas('pendaftaran.poli');
        $records->whereDate('created_at', date('Y-m-d 00:00:00', strtotime($search_tgl)));
        // $records = Pasien::select('*')->where('status_pasien', 'BPJS');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }
        // return $records->get();
        if ($search) {
            $records->with(['pendaftaran.pasien' => function($query) use ($search) {
                $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
                }, 'pendaftaran.poli']);
                // $records->where(function ($query) use ($search) {
                // // $query->orWhere('no_rekamedis', 'LIKE', "%{$search}%");
                // // $query->orWhere('no_ktp', 'LIKE', "%{$search}%");
                // // $query->orWhere('pendaftaran.pasien.nama_pasien', 'LIKE', "%{$search}%");
                // // $query->orWhere('no_bpjs', 'LIKE', "%{$search}%");
                // });
        }else{
            $records->with(['pendaftaran.pasien', 'pendaftaran.poli']);
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        // return $data;
        // return $data[0]->pendaftaran;
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
            $action = "";


            $action .= '<a href="' . route('kunjungan.detailkunjunganpasienbpjs', $enc_id) . '"  class="btn btn-success" title="Pasien BPJS">Lihat Detail</a>&nbsp;';



            // return $record->pendaftaran->pasien;
            // return $record;
            $record->no             = $key + $page;
            $record->DT_RowId       = $record->id;
            $record->no_rawat       = $record->pendaftaran->no_rawat;
            $record->no_rekamedis   = $record->pendaftaran->no_rekamedis;
            $record->poli           = $record->pendaftaran->poli->nama_poli;
            $record->status_pasien  = $record->pendaftaran->status_pasien;
            $record->no_ktp         = $record->pendaftaran->pasien->no_ktp;
            $record->no_bpjs        = $record->pendaftaran->pasien->no_bpjs;
            $record->nama_pasien    = $record->pendaftaran->pasien->nama_pasien;
            $record->jenis_kelamin  = $record->pendaftaran->pasien->jenis_kelamin;
            $record->tempat_lahir   = $record->pendaftaran->pasien->tempat_lahir;
            $record->tanggal_lahir  = $record->pendaftaran->pasien->tanggal_lahir;
            $record->ttl            = $record->pendaftaran->pasien->tempat_lahir . "," . $record->pendaftaran->pasien->tanggal_lahir;
            $record->alamat         = $record->pendaftaran->pasien->alamat;
            $record->status_pasien  = $record->pendaftaran->status_pasien;
            $record->tgl_daftar     = date('d-m-Y', strtotime($record->tgl_daftar));
            $record->action     = $action;
        }

        if ($request->user()->can('pasien.index')) {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );
        } else {
            $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => 0,
            "recordsFiltered" => 0,
            "data"            => []
            );
        }
        return json_encode($json_data);
        }
    }
    public function DetailKunjunganPasienBPJS($enc_id){
        // return $enc_id;
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        // return $dec_id;
        // return view('integrasi_bpjs/kunjungan_pasien_form');

        $Tindakans = Tindakan::all();
        $Obats = Obat::all();
        $Lab = Pelayananlaboratorium::all();

        if ($dec_id) {
            //$poli= Pelayananpoli::find($dec_id);
            $kunjungan = Kunjungan::find($dec_id);
            // return $kunjungan;
            // $poli = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pendaftaran.id_dokter','tbl_pendaftaran.nama_penanggung_jawab','tbl_pasien.nama_pasien','tbl_pasien.tanggal_lahir','tbl_pendaftaran.status_pasien','tbl_poli.nama_poli','tbl_poli.id as poliid','tbl_pendaftaran.no_bpjs')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')->where('tbl_pendaftaran.id',$dec_id)->first();
            //dd($poli);
            // return response()->json([
            //   'datas' => $poli
            // ]);
            // return $poli;
            //  return $dec_id;
            //  return $poli->rujuk_lanjut;
            // return $kunjungan->kd_diagnosa1;
            return view('integrasi_bpjs/kunjungan_pasien_form',compact('enc_id','kunjungan','Tindakans','Obats','Lab'));
        } else {
            return view('errors/noaccess');
        }
        // return $data;
    }
}
