<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\AntrianBPJS;
use App\Models\Kk;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\P;

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
    public function get_sisaantrian($kdpoli, $nokartu){
        $user = $_SERVER['HTTP_X_USERNAME'];
        $data = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->get();
        $data_pasien = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_kartu', $nokartu)->first();
        $poli = Poli::where('kdpoli', $kdpoli)->first();
        if(isset($data_pasien)){
            $datacollect = collect([]);
            foreach($data as $d){
                $datacollect->push($d);
            }
            $groupdata = $datacollect->groupBy('status');
            if($data_pasien->status == 0){
                return array(
                    'nomorantrean' => "".$data_pasien->no_antrian,
                    'namapoli' => $poli->nama_poli,
                    'sisaantrean' => "".(substr($data_pasien->no_antrian,1) - ( (empty($groupdata[1]))? 1 : count($groupdata[1]) ) ),
                    'antreanpanggil' => $poli->kode_poli."".((empty($groupdata[1]))? 1 : count($groupdata[1])+1),
                    'keterangan' => '',
                    'user' => $user
                );
            }else{
                return array(
                    'nomorantrean' => "".$data_pasien->no_antrian,
                    'namapoli' => $poli->nama_poli,
                    'sisaantrean' => "".( (substr($data_pasien->no_antrian,1) - ( (empty($groupdata[1]))? 1 : count($groupdata[1]) ) ) < 0)? 'Antrian sudah terlewati' : (substr($data_pasien->no_antrian,1) - ( (empty($groupdata[1]))? 1 : count($groupdata[1]) ) ),
                    'antreanpanggil' => $poli->kode_poli."".((empty($groupdata[1]))? 1 : count($groupdata[1])),
                    'keterangan' => '',
                );
            }
        }else{
            return "Pasien Belum terdaftar";
        }
    }
    public function get_antrian($kdpoli){
        $data = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->get();
        $poli = Poli::where('kdpoli', $kdpoli)->first();
        if(isset($data)){
            $datacollect = collect([]);
            foreach($data as $d){
                $datacollect->push($d);
            }
            $groupdata = $datacollect->groupBy('status');
            return array(
                'namapoli' => $poli->nama_poli,
                'totalantrean' => "".count($datacollect),
                'sisaantrean' => "".(count($datacollect) - ( (empty($groupdata[1]))? 0 : count($groupdata[1]) ) ),
                'antreanpanggil' => $poli->kode_poli."".((empty($groupdata[1]))? 1 : count($groupdata[1])),
                'keterangan' => '',
            );
        }else{
            return array(
                'namapoli' => $poli->nama_poli,
                'totalantrean' => "".count($data),
                'sisaantrean' => "".count($data),
                'antreanpanggil' => "Tidak ada Antrian",
                'keterangan' => '',
            );
        }
    }
    public function status_antrean($kdpoli, $tgl_periksa){
        // return $tgl_periksa;
        $poli = Poli::where('kdpoli', $kdpoli)->first();
        if(!isset($poli)){
            return response()->json([
                'response' => array(
                    'message' => 'Kode Poli Salah'
                ),
                'metadata' => array(
                    'message' => 'error',
                    'code' => 201,
                ),
            ]);
        }
        $data = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime($tgl_periksa)))->get();
        // return $data;
        if(isset($data)){
            $datacollect = collect([]);
            foreach($data as $d){
                $datacollect->push($d);
            }
            $groupdata = $datacollect->groupBy('status');
            // return $groupdata[1][count($groupdata[1])-1];
            // return (empty($groupdata[1]))? 0 : count($groupdata[1]);
            return response()->json([
                'response' => array(
                    'namapoli' => $poli->nama_poli,
                    'totalantrean' => "".count($datacollect),
                    'sisaantrean' => "".((empty($groupdata[0]))? 0 : count($groupdata[0])),
                    // 'antreanpanggil' => $poli->kode_poli."".((empty($groupdata[1]))? 1 : count($groupdata[1])),
                    'antreanpanggil' => ((empty($groupdata[0]))? 'Tidak ada antrean' : $groupdata[0][0]['no_antrian']),
                    'keterangan' => '',
                ),
                'metadata' => array(
                    'message' => 'Ok',
                    'code' => 200
                ),

            ]);
        }else{
            return response()->json([
                'response' => array(
                    'namapoli' => $poli->nama_poli,
                    'totalantrean' => "".count($data),
                    'sisaantrean' => "".count($data),
                    'antreanpanggil' => "Tidak ada Antrian",
                    'keterangan' => '',
                ),
                'metadata' => array(
                    'message' => 'Ok',
                    'code' => 200
                ),

            ]);
        }
    }
    public function get_pendaftaranbpjs($noUrut, $tgl_daftar){
        $uri = env('API_URL');;

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

        $headers = array(
                    "Accept: application/json",
                    "X-cons-id:".$consID,
                    "X-timestamp: ".$stamp,
                    "X-signature: ".$encodedSignature,
                    "X-authorization: Basic " .$encodedAuthorization
                );
        $ch = curl_init($uri.'/pendaftaran/noUrut/'.$noUrut.'/tglDaftar/'.date('d-m-Y',strtotime($tgl_daftar)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        // return $data;
        // return "tes";
        // return $uri.'/pendaftaran/noUrut/'.$noUrut.'/tglDaftar'.$tgl_daftar;
        return json_decode($data, true);
    }
    public function cek_pendaftaran($request){
        $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))
        ->where('no_kartu', $request['nomorkartu'])
        ->where('no_ktp', $request['nik'])
        ->where('code_poli',$request['kodepoli'])
        ->orderBy('created_at', 'DESC')
        ->first();
        // return $antrian;
        if(isset($antrian)){
            if($antrian->status == 0){
                return array(
                    'success' => false,
                    'message' => 'Pasien sudah terdaftar dan nomor antrian belum terlewati'
                );
            }else{
                $get_pendaftaranbpjs = $this->get_pendaftaranbpjs($antrian->no_antrian_bpjs, $antrian->tgl_daftar);
                if($get_pendaftaranbpjs['response']['status'] == 'Baru' && $antrian->pendaftaran->flag_periksa == 0){
                    return array(
                        'success' => true,
                        'terdaftar' => 1,
                        'pasien' => $antrian,
                    );
                }else{
                    return array(
                        'success' => false,
                        'message' => 'Pasien sudah pernah didaftarkan dan diperiksa'
                    );
                }
            }
        }else{
            return array(
                'success' => true,
                'terdaftar' => 0,
            );
        }
    }
    public function create_antrean(Request $request){

        $cek_pendaftaran = $this->cek_pendaftaran($request);
        // return $cek_pendaftaran;
        $cek_pasien = Pasien::where('no_bpjs', $request->nomorkartu)->where('no_ktp', $request->nik)->first();
        // return $cek_pasien;
        $cek_poli = Poli::where('kdpoli', $request->kodepoli)->first();
        $datenow = date('Y-m-d', strtotime(Carbon::now()));
        $dateinput = date('Y-m-d', strtotime($request->tanggalperiksa));

        // VALIDATOR

        if($cek_pendaftaran['success'] == false){
            return response()->json([
                'response' => array(
                    'message' => $cek_pendaftaran['message'],
                ),
                'metadata' => array(
                    'message' => $cek_pendaftaran['message'],
                    'code' => 201,
                ),
            ]);
        }
        if(!isset($cek_pasien)){
            return response()->json([
                'response' => array(
                    'message' => 'Pasien belum terdaftar',
                ),
                'metadata' => array(
                    'message' => 'Pasien belum terdaftar',
                    'code' => 201,
                ),
            ]);
        }
        if(!isset($cek_poli)){
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
        if($datenow != $dateinput){
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
        // END VALIDATOR

        $getBPJS = app('App\Http\Controllers\PendaftaranController')->getBPJS($cek_pasien->no_bpjs);
        // return $getBPJS;
        if($getBPJS["metaData"]["code"] == 200){
            $kdProviderPeserta = $getBPJS["response"]["kdProviderPst"]["kdProvider"];
            // return $kdProviderPeserta;
            $svPCARE = app('App\Http\Controllers\PendaftaranController')->simpanBPJS($cek_pasien->no_bpjs, $kdProviderPeserta, date('Y-m-d'), $cek_poli->kdpoli);
            // return $svPCARE;
            if($svPCARE['metaData']['code'] != 201){
               $get_pendaftaranbpjs = $this->get_pendaftaranbpjs($cek_pendaftaran['pasien']['no_antrian_bpjs'], $cek_pendaftaran['pasien']['tgl_daftar']);
            //    return $get_pendaftaranbpjs;
               if(isset($get_pendaftaranbpjs['response']['noUrut'])){
                    $svPCARE['metaData']['code'] = 201;
                    $svPCARE['response'] = array(
                        'message' => $get_pendaftaranbpjs['response']['noUrut'],
                    );
               }else{
                    return response()->json([
                        'response' => array(
                            'message' => 'Gagal mengambil NoUrut dari PCare',
                        ),
                        'metadata' => array(
                            'message' => 'Gagal mengambil NoUrut dari PCare',
                            'code' => 201,
                        )
                    ]);
               }

            }

            if($svPCARE["metaData"]["code"] == 201){
                $pendaftaran  = $this->create_pendaftaran($cek_pasien, $cek_poli, $request);
                if($pendaftaran['success'] == true){
                    $datapendaftaran = $pendaftaran['data'];
                   // $data = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_antrian', 'LIKE', $cek_poli->kode_poli.'%')->get();
                    $no_ant = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_antrian', 'LIKE', $cek_poli->kode_poli.'%')->orderBy('id', 'DESC')->first();
                    if(!isset($no_ant)){
                        $no_antrian = $cek_poli->kode_poli."1";
                    }else{
                        $no_antrian = $cek_poli->kode_poli."".(substr($no_ant->no_antrian,1)+1);
                    }

                    $antrian = new AntrianBPJS;
                    $antrian->id_pendaftaran = $datapendaftaran->id;
                    $antrian->no_kartu  = $datapendaftaran->no_bpjs;
                    $antrian->no_ktp    = $cek_pasien->no_ktp;
                    $antrian->code_poli = $cek_poli->kdpoli;
                    $antrian->no_antrian = $no_antrian;
                    $antrian->no_antrian_bpjs = $svPCARE['response']['message'];
                    $antrian->tgl_daftar = date('Y-m-d', strtotime($datapendaftaran->tanggal_daftar));
                    if($antrian->save()){
                        $get_antrian = $this->get_antrian($cek_poli->kdpoli);
                        return response()->json([
                            'response' => array(
                                'nomorantrean' => $antrian->no_antrian,
                                'angkaantrean' => substr($antrian->no_antrian, 1),
                                'namapoli' => $cek_poli->nama_poli,
                                'sisaantrean' => $get_antrian['sisaantrean'],
                                'antreanpanggil' => $get_antrian['antreanpanggil'],
                                'keterangan' => 'Apabila antrean terlewat harap mengambil antrean kembali'
                            ),
                            'metadata' => array(
                                'message' => 'Ok',
                                'code' => 200,
                            )
                        ]);
                    }else{
                        return response()->json([
                            'response' => array(
                                'message' => 'Gagal menyimpan antrian',
                            ),
                            'metadata' => array(
                                'message' => 'Gagal menyimpan antrian',
                                'code' => 201,
                            )
                        ]);
                    }
                }else{
                    return response()->json([
                        'response' => array(
                            'message' => 'Gagal menyimpan data pendaftaran di database local',
                        ),
                        'metadata' => array(
                            'message' => 'Gagal menyimpan data pendaftaran di database local',
                            'code' => 201,
                        )
                    ]);
                }
            }else{
                return response()->json([
                    'response' => array(
                        'message' => 'Gagal menyimpan data pendaftaran di database PCare',
                    ),
                    'metadata' => array(
                        'message' => 'Gagal menyimpan data pendaftaran di database PCare',
                        'code' => 201,
                    )
                ]);
            }

        }else{
            return response()->json([
                'response' => array(
                    'message' => 'Gagal mengambil data BPJS',
                ),
                'metadata' => array(
                    'message' => 'Gagal mengambil data BPJS',
                    'code' => 201,
                )
            ]);
        }
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

    public function create_pendaftaran($pasien, $poli, $request){
        // return collect([
        //     'success' => true,
        //     'data' => $pasien,
        // ]);
        $cek_pasien = Pendaftaran::where('id_poli', $poli->id)
        ->where('no_rekamedis', $pasien->no_rekamedis)
        ->where('tanggal_daftar', date('Y-m-d'))
        ->where('no_bpjs', $pasien->no_bpjs)
        ->where('flag_periksa', 0)
        ->first();
        if(isset($cek_pasien)){
            return collect([
                'success' => true,
                'data' => $cek_pasien,
            ]);
        }
        $pendaftaran = new Pendaftaran;
        $pendaftaran->no_rawat                          = $this->generateNoRawat();
        $pendaftaran->no_rekamedis                      = $pasien->no_rekamedis;
        $pendaftaran->tanggal_daftar                    = date('Y-m-d');
        $pendaftaran->id_poli                           = $poli->id;
        $pendaftaran->id_dokter                         = "-";
        $pendaftaran->nama_penanggung_jawab             = "-";
        $pendaftaran->id_poli_sub                       = null;
        $pendaftaran->hubungan_dengan_penanggung_jawab  = "-";
        $pendaftaran->alamat_penanggung_jawab           = "-";
        $pendaftaran->status_pasien                     = "BPJS";
        $pendaftaran->no_bpjs                           = $pasien->no_bpjs;
        $pendaftaran->keluhan                           = $request->keluhan;
        if($pendaftaran->save()){
            return collect([
                'success' => true,
                'data' => $pendaftaran,
            ]);
        }else{
            return collect([
                'success' => false,
            ]);
        }

    }
    public function sisa_antrean($nokartu, $kdpoli, $tgl_periksa){
        $cek_poli = Poli::where('kdpoli', $kdpoli)->first();
        $datenow = date('Y-m-d', strtotime(Carbon::now()));
        $dateinput = date('Y-m-d', strtotime($tgl_periksa));
        $cek_pasien = AntrianBPJS::where('code_poli', $kdpoli)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_kartu', $nokartu)->first();
        $data = collect([
            'nomorkartu' => $nokartu,
            'kodepoli' => $kdpoli
        ]);
        // return $data['nomorkartu'];
        $get_sisaantrian = $this->get_sisaantrian($kdpoli, $nokartu);
        // return $get_sisaantrian;
        // VALIDATOR
        if(!isset($cek_pasien)){
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
        if(!isset($cek_poli)){
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
        if($datenow != $dateinput){
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
        //END VALIDATOR
        return response()->json([
            'response' => array(
                'message' => $get_sisaantrian,
            ),
            'metadata' => array(
                'message' => 'Ok',
                'code' => 201,
            ),
        ]);
    }
    public function deleteBPJS($antrian){
        // return $antrian;
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

        $headers = array(
            "Accept: application/json",
            "X-cons-id:".$consID,
            "X-timestamp: ".$stamp,
            "X-signature: " .base64_encode($signature),
            "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
            'Content-Type:application/json',

        );
        $fullurl = $uri.'/pendaftaran/peserta/'.$antrian->no_kartu.'/tglDaftar/'.date('d-m-Y',strtotime($antrian->tgl_daftar)).'/noUrut/'.$antrian->no_antrian_bpjs.'/kdPoli/'.$antrian->code_poli;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_URL, $fullurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        // return $data;
        return json_decode($data, true);
    }
    public function batal_antrean(Request $request){
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
}
