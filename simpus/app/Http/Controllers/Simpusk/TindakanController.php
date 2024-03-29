<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Pcare;
use Illuminate\Http\Request;
use App\Models\Simpusk\Tindakan;
use App\Models\Simpusk\Poli;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class TindakanController extends Controller
{
   protected $original_column = array(
    1 => "kode_tindakan",
    2 => "nama_tindakan",
  );

  public function index()
  {
    // $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');
    // $consID 	= env('API_CONSID', '9243'); //customer ID anda
    // $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    // $pcare = Pcare::first();
    // $pcareUname = $pcare->username;
    // $pcarePWD = $pcare->password;

    // $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

    // $stamp    = time();
    // $data     = $consID.'&'.$stamp;

    // $signature = hash_hmac('sha256', $data, $secretKey, true);
    // $encodedSignature = base64_encode($signature);
    // $encodedAuthorization = base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi);
    // // return $uri;
    // $headers = array(
    //             "Accept: application/json",
    //             "X-cons-id:".$consID,
    //             "X-timestamp: ".$stamp,
    //             "X-signature: ".$encodedSignature,
    //             "X-authorization: Basic " .$encodedAuthorization,
    //             "Content-Type: application/json"
    //         );

    //     $ch = curl_init($uri.'/tindakan/kdTkp/10/0/100');
    //     // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //     // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    //     $data = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo curl_error($ch);
    //     }
    //     curl_close($ch);

    //     // header("Content-Type: application/json");
    //     $data = json_decode($data, true);
    //     // return response()->json([
    //     //     'datas' => $data,
    //     //     'success' => true,
    //     // ]);
    //     return $data;

    return view('master/data_tindakan');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = Tindakan::select('*');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('kode_tindakan','LIKE',"%{$search}%");
                $query->orWhere('nama_tindakan','LIKE',"%{$search}%");
        });
      }
      $totalData = $records->get()->count();

      $totalFiltered = $records->get()->count();

      $records->limit($limit);
      $records->offset($start);
      $data = $records->get();
      foreach ($data as $key=> $record)
      {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
        $action = "";
        if($request->user()->can('tindakan.ubah')){
            $action.='<a href="'.route('tindakan.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('tindakan.hapus')){
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }





        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->kode_tindakan  = $record->kode_tindakan;
        $record->nama_tindakan  = $record->nama_tindakan;
        $record->tindakan_oleh  = $record->tindakan_oleh;
        $record->action         = $action;
      }

      if ($request->user()->can('tindakan.index')) {
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



  public function tambah()
  {
      $dataPoli = Poli::all();
      return view('master_form/tindakan_form',compact('dataPoli'));
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
     $dataPoli = Poli::all();
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $tindakan= Tindakan::find($dec_id);

        return view('master_form/tindakan_form',compact('enc_id','tindakan','dataPoli'));
      } else {
        return view('errors/noaccess');
      }
    }
    public function simpan(Request $req)
    {
      $enc_id     = $req->enc_id;



      if ($enc_id != null) {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      }else{
        $dec_id = null;
      }

      if($enc_id){

        $tindakan = Tindakan::find($dec_id);

        $tindakan->kode_tindakan   = $req->kode_tindakan;
        $tindakan->nama_tindakan   = $req->nama_tindakan;
        $tindakan->tarif_tindakan   = str_replace('.','',$req->tarif_tindakan);
        $tindakan->id_poliklinik   = $req->poliklinik;
        $tindakan->tindakan_oleh   = $req->tindakan_oleh;
        $tindakan->save();
        if ($tindakan) {
          $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data berhasil diperbarui.'
             );
        }else{
           $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data gagal diperbarui.'
             );
        }
      }else{

        $tindakan = new tindakan;

        $tindakan->kode_tindakan   = $req->kode_tindakan;
        $tindakan->nama_tindakan   = $req->nama_tindakan;
        $tindakan->tarif_tindakan   = str_replace('.','',$req->tarif_tindakan);
        $tindakan->id_poliklinik   = $req->poliklinik;
        $tindakan->tindakan_oleh   = $req->tindakan_oleh;
        $tindakan->save();

        if($tindakan) {
          $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data berhasil ditambahkan.'
          );
        }else{
          $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data gagal ditambahkan.'
          );
        }

      }
      return json_encode($json_data);
    }
    public function hapus(Request $req,$enc_id)
    {
      $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      $tindakan = Tindakan::find($dec_id);

      if ($tindakan) {
          $tindakan->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }
}
