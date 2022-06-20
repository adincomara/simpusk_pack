<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pegawai;
use App\Models\Simpusk\AntrianBPJS;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class PendaftaranController extends Controller
{
   protected $original_column = array(
    1 => "no_rawat",
    2 => "no_rekamedis",
    3 => "nama_pasien",
    4 => "status_pasien",
    5 => "tbl_pegawai.nama_pegawai",
    6 => "tbl_poli.nama_poli",

  );

  public function pjj()
  {
      $value = array('Saudara Kandung','Orang Tua','Lain-lain');
      return $value;
  }
  public function status_pasien()
  {
      $value = array('BPJS','Umum');
      return $value;
  }
  public function index()
  {

    return view('pelayanan/pendaftaran');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];
      $search_tgl = $request->search_tgl;

      $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien', 'tbl_pendaftaran.flag_periksa',
      'tbl_poli.nama_poli')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli');
    //   $records->where('tbl_pendaftaran.flag_periksa', 0);
      $records->whereDate('tbl_pendaftaran.tanggal_daftar', '=', date('Y-m-d', strtotime($search_tgl)));
    //   return $records->get();


      if(array_key_exists($request->order[0]['column'], $this->original_column)){
        $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }else{
        $records->orderBy('id','DESC');
      }

      if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('no_rawat','LIKE',"%{$search}%");
                $query->orWhere('tbl_pendaftaran.no_rekamedis','LIKE',"%{$search}%");
                $query->orWhere('nama_pasien','LIKE',"%{$search}%");
                $query->orWhere('tbl_pendaftaran.status_pasien','LIKE',"%{$search}%");
                $query->orWhere('tbl_poli.nama_poli','LIKE',"%{$search}%");
        });
      }
      $totalData = $records->get()->count();

      $totalFiltered = $records->get()->count();

      $records->limit($limit);
      $records->offset($start);
      $data = $records->get();
    //   return $data;
      foreach ($data as $key=> $record)
      {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
        $action = "";

        if ($request->user()->can('pendaftaran.hapus')) {
            // return $record->id;
            // $status_antrian = AntrianBPJS::where('id_pendaftaran', $record->id)->first();

            // return $status_antrian;
            // if(isset($status_antrian)){
            //     $antrian = collect([
            //         'poli' => $record->nama_poli,
            //         'no_antrian' => $status_antrian->no_antrian,
            //     ]);
            //     if($status_antrian->status == 0){
            //         // $action.="<a href='#'onclick='cetakantrian(".json_encode($antrian).")' class='btn btn-primary btn-xs icon-btn md-btn-flat product-tooltip' style='min-width:60px' title='cetak'><i class='fa fa-print'></i> Antrian</a>&nbsp;";
            //     }


            // }
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';

        }

        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->no_rawat       = $record->no_rawat;
        $record->no_rekamedis   = $record->no_rekamedis;
        $record->nama_pasien    = $record->nama_pasien;
        $record->status_pasien  = $record->status_pasien;
        $record->nama_pegawai   = $record->nama_pegawai;
        $record->nama_poli      = $record->nama_poli;
        if($record->flag_periksa == 1){
            $record->action = "Sudah Dilayani";
        }else{
            $record->action         = $action;
        }


      }

      if ($request->user()->can('pendaftaran.index')) {
        $json_data = array(
                  "draw"            => intval($request->input('draw')),
                  "recordsTotal"    => intval($totalData),
                  "recordsFiltered" => intval($totalFiltered),
                  "data"            => $data
                  );
      }else{
         $json_data = array(
                  "draw"            => intval($request->input('draw')),
                  "recordsTotal"    => 0,
                  "recordsFiltered" => 0,
                  "data"            => []
                  );
      }
      return json_encode($json_data);
  }
  function safe_encode($string) {
    $data = str_replace(array('/'),array('_'),$string);
    return $data;
  }
  function safe_decode($string,$mode=null) {
    $data = str_replace(array('_'),array('/'),$string);
    return $data;
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
    public function getNoRekam(Request $request){
        $query= $request['query'];
        $data = Pasien::select("*")->where("no_rekamedis","LIKE","%{$query}%")->orWhere("nama_pasien","LIKE","%{$query}%")->limit(10)->get();
        $output = '';
        if (count($data)>0) {
            $output = '<ul class="list-unstyled" style="cursor: pointer;display: block; position: absolute;z-index: 99999 !important";border: 2px solid #000000;
    padding: 5px 0;border-radius: 2px;>';
            foreach ($data as $row){

                $output .= '<li class="list-group-item pilihnorekam" data-row=\''.$row.'\'style="background: antiquewhite;">'.$row->no_rekamedis.' | '.$row->nama_pasien.'</li>';
            }
            $output .= '</ul>';
        }
        else {
            $output .= '<li class="list-group-item">'.'No results'.'</li>';
        }
        return $output;
   }
    public function getDokter(Request $request){

        $data = Pegawai::select("*")->where('id_bidang',3)->get();
        $output = '';
        if (count($data)>0) {
    //         $output = '<ul class="list-unstyled" style="cursor: pointer;display: block; position: absolute;z-index: 99999 !important";border: 2px solid #000000;
    // padding: 5px 0;border-radius: 2px;>';
            foreach ($data as $row){

                $output .= '<option value="'.$row->id_pegawai.'">'.$row->nip.' | '.$row->nama_pegawai.'</option>';
            }
            // $output .= '</ul>';
        }
        else {
            $output .= '<option></option>';
        }
        return $output;

   }
   public function getDokterBpjs(){
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');
    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcareUname = env('API_PCAREUNAME', '0159092404'); //username pcare
    $pcarePWD 	= env('API_PCAREPWD', '0159092404!2Pkm'); //password pcare anda

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

    $stamp    = time();
    $data     = $consID.'&'.$stamp;

    $signature = hash_hmac('sha256', $data, $secretKey, true);
    $encodedSignature = base64_encode($signature);
    $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);
    // return $uri;
    $headers = array(
                "Accept: application/json",
                "X-cons-id:".$consID,
                "X-timestamp: ".$stamp,
                "X-signature: ".$encodedSignature,
                "X-authorization: Basic " .$encodedAuthorization,
                "Content-Type: application/json"
            );

        $ch = curl_init($uri.'/dokter/0/100');
        // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        // header("Content-Type: application/json");
        $data = json_decode($data, true);
        // return response()->json([
        //     'datas' => $data,
        //     'success' => true,
        // ]);
        return $data;
  }
  public function tambah()
  {
      $pjj = $this->pjj();
      $selectedpjj = '';
      $status = $this->status_pasien();
      $selectedstatus = '';
      $poli = Poli::where('parent',null)->where('status',1)->get();
      $norekam = Pasien::all();
      $selectedpoli = "";
      $dokterbpjs = $this->getDokterBpjs();
    //   return $dokterbpjs;
      $cek_dokter = 0;
      if($dokterbpjs['metaData']['code'] == 200){
          $dokter = $dokterbpjs['response']['list'];
          $cek_dokter = 1;
      }else{
          $cek_dokter = 0;
          $dokter = [];
      }

    //   $tes = json_encode($dokterbpjs, true);
    //   return $dokter;
      return view('pelayanan_form/pendaftaran_form',compact('pjj','selectedpjj','status','selectedstatus','poli','selectedpoli', 'dokter', 'norekam', 'cek_dokter'));
  }
  public function getSubPoli(Request $req,$id){
      $data= Poli::where('parent',$id)->get();
      if(count($data) > 0){
          $json_data = array(
            "success"  => TRUE,
            "jumlah"   => count($data),
            "data"     => $data
          );
      }else{
          $json_data = array(
            "success"  => FALSE,
            "jumlah"   => 0,
            "data"     => []
          );
      }
      return json_encode($json_data);
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $pendaftaran= Pendaftaran::find($dec_id);
        return view('backend/pendaftaran/form',compact('enc_id','pendaftaran'));
      } else {
        return view('errors/noaccess');
      }
    }

   public function cetak($enc_id)
   {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $pendaftaran= Pendaftaran::find($dec_id);
        dd('cetak');
      } else {
        return view('errors/noaccess');
      }
    }
    public function simpan(Request $req)
    {

        $dokter_penanggung_jawab = explode(',',$req->dokter_penanggung_jawab);

        $cekpendaftaranpasien = Pendaftaran::where('no_rekamedis', $req->no_rekamedis)->where('no_bpjs',$req->no_bpjs)->whereDate('tanggal_daftar', Carbon::today())->first();
        if(isset($cekpendaftaranpasien)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pasien sudah pernah didaftarkan'
            ]);
        }
        $cek_kode_poli = Poli::find($req->id_poli)->kode_poli;
        if(!isset($cek_kode_poli)){
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Harap isi kode poli terlebih dahulu'
            ]);
        }
        if($req->status_pasien == "BPJS"){
            $cekaktifbpjs = $this->cekaktifbpjs($req->no_bpjs);
            // return $cekaktifbpjs;
            if($cekaktifbpjs['response']['aktif'] == 1){
                $getBPJS = $this->getBPJS($req->no_bpjs);
                // return $getBPJS;
                if($getBPJS["metaData"]["code"] == 200){

                    if($req->konseling == 1){
                        $kdpoli = '021';
                        $id_poli = '50';
                    }else{
                        $kdpoli = Poli::find($req->id_poli)->kdpoli;
                        $id_poli = $req->id_poli;
                    }
                    // return $kdpoli;
                    $kdProviderPeserta = $getBPJS["response"]["kdProviderPst"]["kdProvider"];
                    $svPCARE = $this->simpanBPJS($req->no_bpjs, $kdProviderPeserta, date('Y-m-d'), $kdpoli);
                    // return $svPCARE;
                    // $svPCARE["metaData"]["code"] = 201;
                    // $svPCARE['response']['message'] = "A49";
                    if($svPCARE["metaData"]["code"] == 201){
                        $pendaftaran = new Pendaftaran;
                        $pendaftaran->no_rawat                          = $this->generateNoRawat();
                        $pendaftaran->no_rekamedis                      = $req->no_rekamedis;
                        $pendaftaran->tanggal_daftar                    = date('Y-m-d');
                        $pendaftaran->id_poli                           = $id_poli;
                        $pendaftaran->id_dokter                         = $dokter_penanggung_jawab[0];
                        $pendaftaran->nama_penanggung_jawab             = $dokter_penanggung_jawab[1];
                        $pendaftaran->id_poli_sub                       = $req->id_poli_sub;
                        $pendaftaran->hubungan_dengan_penanggung_jawab  = $req->hubungan_dengan_penanggung_jawab;
                        $pendaftaran->alamat_penanggung_jawab           = $req->alamat_penanggung_jawab;
                        $pendaftaran->status_pasien                     = $req->status_pasien;
                        $pendaftaran->no_bpjs                           = $req->no_bpjs;

                        if($pendaftaran->save()){
                            // parameter = request, pendaftaran, no antrian jika belum integrasi bpjs
                            // return app('App\Http\Controllers\AntrianController')->ambil_antrian($req, $pendaftaran, $svPCARE['response']['message']);
                            return app('App\Http\Controllers\AntrianController')->updateantrian($kdpoli, $pendaftaran, $svPCARE['response']['message']);
                            // return app('App\Http\Controllers\AntrianController')->ambil_antrian($req, $pendaftaran, null);
                        }else{
                            return response()->json([
                                'success' => false,
                                'code' => 401,
                                'message' => 'Pendaftaran gagal disimpan di database SIMPUSK',
                            ]);
                        }
                    }else{
                        return response()->json([
                            "success"         => FALSE,
                            "code"            => 401,
                            "message"         => $svPCARE['response'],
                        ]);
                    }
                }else{
                    return response()->json([
                        "success"         => FALSE,
                        "code"            => 401,
                        "message"         => $getBPJS,
                    ]);
                }

            }else{
                return response()->json([
                    'success' => false,
                    'code'    => 401,
                    'message' => 'Status BPJS tidak aktif',
                ]);
            }

        }elseif($req->status_pasien == "Umum"){
            if($req->konseling == 1){
                $kdpoli = '021';
                $id_poli = '50';
            }else{
                $kdpoli = Poli::find($req->id_poli);
                $id_poli = $req->id_poli;
            }
            // return $kdpoli;
            $pendaftaran = new Pendaftaran;
            $pendaftaran->no_rawat                          = $this->generateNoRawat();
            $pendaftaran->no_rekamedis                      = $req->no_rekamedis;
            $pendaftaran->tanggal_daftar                    = date('Y-m-d');
            $pendaftaran->id_poli                           = $id_poli;
            $pendaftaran->id_poli_sub                       = isset($req->id_poli_sub)? $req->id_poli_sub : 'null';
            $pendaftaran->id_dokter                         = $dokter_penanggung_jawab[0];
            $pendaftaran->nama_penanggung_jawab             = $dokter_penanggung_jawab[1];
            $pendaftaran->hubungan_dengan_penanggung_jawab  = $req->hubungan_dengan_penanggung_jawab;
            $pendaftaran->alamat_penanggung_jawab           = $req->alamat_penanggung_jawab;
            $pendaftaran->status_pasien                     = $req->status_pasien;
            $pendaftaran->no_bpjs                           = $req->no_bpjs;
            return app('App\Http\Controllers\AntrianController')->updateantrian($kdpoli, $pendaftaran, null);
            if($pendaftaran->save()){
                // return app('App\Http\Controllers\AntrianController')->ambil_antrian($req, $pendaftaran, null);

                // return response()->json([
                //     "success"         => TRUE,
                //     "code"            => 201,
                //     "message"         => "Pasien berhasil didaftarkan"
                // ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Status pasien belum dipilih',
            ]);
        }
    }
    public function hapus(Request $req,$enc_id)
    {
        // return $enc_id;
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $pendaftaran = Pendaftaran::find($dec_id);
        // return $dec_id;
        if (!isset($pendaftaran)){
            return response()->json([
              'success' => false,
              'code' => 204,
              'message'=>'Data tidak ditemukan'
            ]);
        }
        if($pendaftaran->status_pasien == 'Umum'){
            $antrian = AntrianBPJS::where('id_pendaftaran', $pendaftaran->id)->first();
            if($pendaftaran->delete()){
                $antrian->id_pendaftaran    = null;
                $antrian->no_kartu          = null;
                $antrian->no_ktp            = null;
                $antrian->no_antrian_bpjs   = null;
                $antrian->status_daftar     = 0;
                if($antrian->save()){
                    return response()->json([
                        'success' => true,
                        'code' => 202,
                        'message'=>'Data berhasil dihapus'
                      ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'code' => 204,
                        'message'=>'Data gagal dihapus, data antrian gagal diupdate'
                      ]);
                }

            }else{
                return response()->json([
                    'success' => false,
                    'code' => 204,
                    'message'=>'Data gagal dihapus'
                  ]);
            }
        }elseif($pendaftaran->status_pasien == 'BPJS'){
            // return $pendaftaran;
          $antrian = AntrianBPJS::where('id_pendaftaran', $pendaftaran->id)->first();
        //   return $antrian;
          $deletebpjs = $this->deleteBPJS($antrian);
        //   return $deletebpjs;
        $deletebpjs['metaData']['code'] = 304;
          if($deletebpjs['metaData']['code'] == 304){
              if($pendaftaran->delete()){
                $antrian->id_pendaftaran    = null;
                $antrian->no_kartu          = null;
                $antrian->no_ktp            = null;
                $antrian->code_poli         = null;
                $antrian->no_antrian_bpjs   = null;
                if($antrian->save()){
                    return response()->json([
                        'success' => true,
                        'code' => 202,
                        'message'=>'Data berhasil dihapus'
                        ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'code' => 204,
                        'message'=>'Data gagal dihapus, data antrian gagal diupdate'
                        ]);
                }
              }else{
                  return response()->json([
                      "success" => false,
                      "code"  => 204,
                      "message" => 'Data gagal dihapus dari database SIMPUSK',
                  ]);
              }
          }else{
              return response()->json([
                  "success" => false,
                  "code"  => 204,
                  "message" => 'Data gagal dihapus dari sistem BPJS '.$deletebpjs,
              ]);
          }
        }else{
          return response()->json([
              "success" => false,
              "code"  => 204,
              "message" => 'Gagal dihapus tidak ada status pasien',
          ]);
        }
    }

    public function pasienbpjs(Request $request){
    $uri = env('API_URL');
    $nik = $request->noKartu;

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

        $ch = curl_init($uri.'/peserta/'.$nik);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($data, true);
        // return $result;
        if($result['metaData']['code'] != 200){
            return response()->json([
                'datas' => $result,
                'success' => false,
                'code'  => 400,
                'message' => 'Tidak terdaftar BPJS',
            ]);
        }else{
            return response()->json([
                'datas' => $result,
                'success' => true,
                'code'    => 200,
                'message' => 'Tidak terdaftar BPJS',
            ]);
        }

    }
    public function searchRekam(Request $request){
        $key = $request->search;
        $query = Pasien::orwhere('no_rekamedis', 'LIKE', "%{$key}%");
        $query->orwhere('nama_pasien', 'LIKE', "%{$key}%");
        $pasien = $query->get();
        return json_encode($pasien);
    }

    public function pendaftaranBpjs(Request $request){

      $uri = "https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0"; //url web service bpjs
      $consID 	= "17432"; //customer ID anda
      $secretKey 	= "8uRC52B72D"; //secretKey anda

      $pcareUname = "Dvlppkmjepang"; //username pcare
      $pcarePWD 	= "Dvlppkmjepang@123"; //password pcare anda

      $kdAplikasi	= "095"; //kode aplikasi

      $stamp		= time();
      $data 		= $consID.'&'.$stamp;

      $signature = hash_hmac('sha256', $data, $secretKey, true);

      $post = [
        "kdProviderPeserta"=> $request->kdprovider,
        "tglDaftar"=> date('d-m-Y'),
        "noKartu"=> $request->nokartu,
        "kdPoli"=> $request->idpoli,
        "keluhan"=> null,
        "kunjSakit"=> true,
        "sistole"=> 0,
        "diastole"=> 0,
        "beratBadan"=> 0,
        "tinggiBadan"=> 0,
        "respRate"=> 0,
        "heartRate"=> 0,
        "rujukBalik"=> "0",
        "kdTkp"=> "10"
      ];
      $post = json_encode($post);
      $headers = array(
                  "Accept: application/json",
                  "X-cons-id:".$consID,
                  "X-timestamp: ".$stamp,
                  "X-signature: " .base64_encode($signature),
                  "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
                  'Content-Type:application/json',
                  'Content-Length: ' .strlen($post)
              );

      $ch = curl_init($uri.'/pendaftaran');
      curl_setopt($ch, CURLOPT_TIMEOUT, 5);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
      $data = curl_exec($ch);
      if (curl_errno($ch)) {
          echo curl_error($ch);
      }
      curl_close($ch);
      header("Content-Type: application/json");

      return response()->json([
        'datas' => json_decode($data)
      ]);
    }

    public function simpanNoAntrian(Request $request){
      $noantrian = $request->noantrian;
      $idpoli = $request->idpoli;
      $tgldaftar = date('d-m-Y');

      $antrianbpjs = new AntrianBPJS;
      $antrianbpjs->no_antrian = $noantrian;
      $antrianbpjs->id_poli = $idpoli;
      $antrianbpjs->tgl_daftar = $tgldaftar;
      $antrianbpjs->save();

      return response()->json([
        'code'    => 200,
        'response' => [
          'field' => 'No Antrian',
          'message' => $noantrian
        ]
      ]);
    }

    public function simpanBPJS($no_bpjs, $no_provider, $tanggal_daftar, $kdpoli){
            //   $uri = env('API_URL'); //url web service bpjs
        //   //return $uri.'/pendaftaran';
        //   $consID 	= env('API_CONSID'); //customer ID anda
        //     $secretKey 	= env('API_SECRETKEY'); //secretKey anda

        //     $pcareUname = env('API_PCAREUNAME'); //username pcare
        //     $pcarePWD 	= env('API_PCAREPWD'); //password pcare anda

        //     $kdAplikasi	= env('API_KDAPLIKASI'); //kode aplikasi
        $poli = Poli::where('kdpoli', $kdpoli)->first();
        // return $poli;
        if($poli->kunjungan_sakit == 0){
            $kjsakit = false;
        }else{
            $kjsakit = true;
        }
        // return $kjsakit;
        $uri ='https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0'; //url web service bpjs
        $consID 	= '9243'; //customer ID anda
        $secretKey 	= '3yVE45CCBC'; //secretKey anda

        $pcareUname = '0159092404'; //username pcare
        $pcarePWD 	= '0159092404!2Pkm'; //password pcare anda

        $kdAplikasi	= '095'; //kode aplikasi

        $stamp    = time();
        $data     = $consID.'&'.$stamp;
        //   return $data;

        $signature = hash_hmac('sha256', $data, $secretKey, true);
        //   $encodedSignature = base64_encode($signature);
        //   $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);

            $post = [
                "kdProviderPeserta"=> $no_provider,
                "tglDaftar"=> date('d-m-Y'),
                "noKartu"=> $no_bpjs,
                "kdPoli"=> $kdpoli,
                "keluhan"=> null,
                "kunjSakit"=> $kjsakit,
                "sistole"=> 0,
                "diastole"=> 0,
                "beratBadan"=> 0,
                "tinggiBadan"=> 0,
                "respRate"=> 0,
                "heartRate"=> 0,
                "rujukBalik"=> "0",
                "kdTkp"=> "10"
            ];
        $post = json_encode($post);
        $headers = array(
            "Accept: application/json",
            "X-cons-id:".$consID,
            "X-timestamp: ".$stamp,
            "X-signature: " .base64_encode($signature),
            "X-authorization: Basic " .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi),
            'Content-Type:application/json',
            'Content-Length: ' .strlen($post)
        );
            // return $pcarePWD;
        //   echo "X-cons-id:".$consID;
        //   echo "X-timestamp: ".$stamp;
        //   echo "X-signature: ".$encodedSignature;
        //   echo "X-authorization: Basic " .$encodedAuthorization;

        $ch = curl_init($uri."/pendaftaran");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        return json_decode($data,true);
        /*header("Content-Type: application/json");
        json_encode(var_dump(json_decode($data, true)["response"]),true);*/
    }
    public function cekaktifbpjs($no_bpjs){
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

        $ch = curl_init($uri.'/peserta/'.$no_bpjs);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        return $data;
    }

    public function getBPJS($no_bpjs){
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
        $ch = curl_init($uri.'/peserta/'.$no_bpjs);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        //return $data;
        return json_decode($data, true);
        /*header("Content-Type: application/json");
        json_encode(var_dump(json_decode($data, true)["response"]),true);*/

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
}

