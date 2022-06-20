<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Pasien;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
// use GuzzleHttp\Psr7\Req;
use DB;
use PDF;

class PasienController extends Controller
{
  protected $original_column = array(
    1 => "no_rekamedis",
    2 => "no_ktp",
    3 => "no_bpjs",
    4 => "nama_pasien",
    5 => "jenis_kelamin",
    6 => "tempat_lahir",
    7 => "tanggal_lahir",
    8 => "alamat",
    9 => "status_pasien",
  );

  public function index()
  {

    return view('master/data_pasien');
  }

  public function getData(Request $request)
  {
    $limit = $request->length;
    $start = $request->start;
    $page  = $start + 1;
    $search = $request->search['value'];

    $records = Pasien::select('*');
    // return response()->json(['data' => $records]);
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
      $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
      $no_bpjs = $record->no_bpjs;
      $action = "";
      $action.='<a href="#" onclick="riwayat_kunjungan(\''.$no_bpjs.'\',\'' .strtoupper($record->nama_pasien).'\')" class="btn btn-primary btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-sticky-note"></i> Riwayat Kunjungan</a>&nbsp;';
      $action.='<a href="#" onclick="detail_data('.$record->id.',\'' .$record->nama_pasien.'\')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
      if($request->user()->can('pasien.ubah')){
        $action.='<a href="'.route('pasien.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
      }
      if($request->user()->can('pasien.hapus')){
        $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
      }


      $record->no             = $key + $page;
      $record->DT_RowId       = $record->id;
      $record->no_rekamedis   = $record->no_rekamedis;
      $record->ktpbpjs         = "KTP : ".$record->no_ktp."<br>BPJS : ".$record->no_bpjs;
      $record->nama_pasien    = $record->nama_pasien;
      $record->jenis_kelamin  = $record->jenis_kelamin;
      $record->tempat_lahir   = $record->tempat_lahir;
      $record->tanggal_lahir  = $record->tanggal_lahir;
      $record->ttl            = $record->tempat_lahir . "," . $record->tanggal_lahir;
      $record->alamat         = $record->alamat;
      $record->status_pasien  = $record->status_pasien;
      $record->action         = $action;
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
  public function detail_data(Request $req){
    $id = $req->id;
    echo $id;
    $data = Pasien::where('id',$id)->first();
    if($data->jenis_kelamin == 'L'){
        $jenis_kelamin = "Laki-Laki";
    }
    else{
        $jenis_kelamin = "Perempuan";
    }
    echo"

        <tr>

          <td class='text-left no-sort'>No Rekamedis</td>
          <td>:</td>
          <td>".$data->no_rekamedis."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>NIK/BPJS</td>
          <td>:</td>
          <td>".$data->no_ktp." / ".$data->no_bpjs."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Nama Pasien</td>
          <td>:</td>
          <td>".$data->nama_pasien."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Tempat & Tanggal Lahir</td>
          <td>:</td>
          <td>".$data->tempat_lahir.", ".$data->tanggal_lahir."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Jenis Kelamin</td>
          <td>:</td>
          <td>".$jenis_kelamin."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Alamat</td>
          <td>:</td>
          <td>".$data->alamat."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Telp</td>
          <td>:</td>
          <td>".$data->telp."</td>
        </tr>
        <tr>
          <td class='text-left no-sort'>Status</td>
          <td>:</td>
          <td>".$data->status_pasien."</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
          <!-- <th class='text-left no-sort'></th> -->


      ";
    //   $no = 0;
    //   foreach($getDatas as $data){
    //     $no++;
    //     echo"
    //     <tr>
    //       <td>".$no."</td>
    //       <td>".$data->no_rekamedis."</td>
    //       <td style='width:20%'>NIK : ".$data->no_ktp."<br>BPJS : ".$data->no_bpjs."</td>
    //       <td>".$data->nama_pasien."</td>
    //       <td>".$data->tempat_lahir.", ".$data->tanggal_lahir."</td>
    //       <td>".$data->jenis_kelamin."</td>
    //       <td>".$data->alamat."</td>

    //       <td>".$data->telp."</td>
    //       <td>".$data->status_pasien."</td>
    //       <!-- <td><a href=".route('kk.ubah',$data->id)." class='btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip' title='Edit'><i class='ion ion-md-create'></i></a><a href='#' onclick='deleteData(this,\"".$data->id."\")' class='btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip' title='Hapus'><i class='ion ion-md-close'></i></a></td> -->
    //     ";
    //     }echo"
    //   </tbody>
    // ";
  }
  function riwayat_kunjungan(Request $req){
    $no_kartu = $req->no_kartu;
    $uri = env('API_URL');
    // return $uri;
    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcareUname = env('API_PCAREUNAME', '0159092404'); //username pcare
    $pcarePWD 	= env('API_PCAREPWD', '0159092404$2Pkm'); //password pcare anda

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
    $ch = curl_init($uri.'/kunjungan/peserta/'.$no_kartu);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo curl_error($ch);
    }
    curl_close($ch);

    $result = json_decode($data, true);

    if($result['metaData']['code'] == 200){
        // return $result['response']['list'];
        $data ="";
        foreach($result['response']['list'] as $riwayat){
            // return $riwayat;
            $data .=
            "<tr>
            <td><span class='badge badge-light'>".$riwayat['poli']['nmPoli']."</span></td>
            <td>".$riwayat['tglKunjungan']."</td>
            <td class='text-justify'> ".$riwayat['diagnosa1']['kdDiag']." | ".$riwayat['diagnosa1']['nmDiag']."</td>
            </tr>";
        }
        //return $data;
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => $data,
        ]);

    }else{
        return response()->json([
            'success' => false,
            'code'    => 400,
            'message' => 'Data BPJS tidak ditemukan',
        ]);
    }

    return response()->json([
      'datas' => $result
    ]);
    //   return $req->all();
  }
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

  public function generateNoNota()
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

  public function tambah()
  {
    $no_rekam = $this->generateNoNota();
    return view('master_form/pasien_form', compact('no_rekam'));
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

    if ($dec_id) {
      $pasien = Pasien::find($dec_id);

      return view('master_form/pasien_form', compact('enc_id', 'pasien'));
    } else {
      return view('errors/noaccess');
    }
  }
  public function simpan(Request $req)
  {
    $enc_id     = $req->enc_id;

    if ($enc_id != null) {
      $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
    } else {
      $dec_id = null;
    }

    if ($enc_id) {

      $pasien = Pasien::find($dec_id);

      $pasien->no_rekamedis   = $req->no_rekamedis;
      $pasien->no_ktp         = $req->no_ktp;
      $pasien->no_bpjs        = $req->no_bpjs;
      $pasien->nama_pasien    = str_replace("'","",$req->nama_pasien);
      $pasien->jenis_kelamin  = $req->jenis_kelamin;
      $pasien->tempat_lahir   = $req->tempat_lahir;
      $pasien->tanggal_lahir  = date('d-m-Y', strtotime($req->tanggal_lahir));
      $pasien->alamat         = $req->alamat;
      $pasien->alamat_domisili = $req->alamat_domisili;
      $pasien->telp           = $req->telp;
      $pasien->status_pasien  = $req->status_pasien;
      $pasien->save();
      if ($pasien) {
        $json_data = array(
          "success"         => TRUE,
          "message"         => 'Data berhasil diperbarui.'
        );
      } else {
        $json_data = array(
          "success"         => FALSE,
          "message"         => 'Data gagal diperbarui.'
        );
      }
    } else {

      $pasien = new Pasien;

      $pasien->no_rekamedis   = $req->no_rekamedis;
      $pasien->no_ktp         = $req->no_ktp;
      $pasien->no_bpjs        = $req->no_bpjs;
      $pasien->nama_pasien    = str_replace("'","",$req->nama_pasien);
      $pasien->jenis_kelamin  = $req->jenis_kelamin;
      $pasien->tempat_lahir   = $req->tempat_lahir;
      $pasien->tanggal_lahir  = date('d-m-Y', strtotime($req->tanggal_lahir));
      $pasien->alamat         = $req->alamat;
      $pasien->alamat_domisili = $req->alamat_domisili;
      $pasien->telp           = $req->telp;
      $pasien->status_pasien  = $req->status_pasien;
      if ($pasien->save()) {
        $json_data = array(
          "success"         => TRUE,
          "message"         => 'Data berhasil ditambahkan.'
        );
      } else {
        $json_data = array(
          "success"         => FALSE,
          "message"         => 'Data gagal ditambahkan.'
        );
      }
    }
    return json_encode($json_data);
  }

  public function validatePasien(Request $request){
    $uri = env('API_URL');
    // return $uri;
    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcareUname = env('API_PCAREUNAME', '0159092404'); //username pcare
    $pcarePWD 	= env('API_PCAREPWD', '0159092404$2Pkm'); //password pcare anda

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

    // $base_url = 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0';

    $nik = $request->nik;
    $cek = substr($nik,0,1);


    // $consID 	= '9243'; //customer ID anda
    // $secretKey 	= '3yVE45CCBC'; //secretKey anda

    // $pcareUname = '0159092404'; //username pcare
    // $pcarePWD 	= '0159092404$2Pkm'; //password pcare anda

    // $kdAplikasi	= '095'; //kode aplikasi

    // $stamp		= time();
    // $data 		= $consID.'&'.$stamp;

    // $signature = hash_hmac('sha256', $data, $secretKey, true);

    // $header = array(
    //             'Accept: application/json',
    //             'X-cons-id: '.$consID,
    //             'X-timestamp: '.$stamp,
    //             'X-signature: '.base64_encode($signature),
    //             'X-authorization: Basic ' .base64_encode($pcareUname.':'.$pcarePWD.':'.$kdAplikasi)
    //           );
    if($cek == '0'){
        $ch = curl_init($uri.'/peserta/'.$nik);
    }else{
        $ch = curl_init($uri.'/peserta/nik/'.$nik);
    }


    // $ch = curl_init($base_url.'/peserta/'.$nik);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo curl_error($ch);
    }
    curl_close($ch);

    $result = json_decode($data, true);

    if($result['metaData']['code'] == 200){
        return response()->json([
            'datas' => $result
          ]);
    }else{
        return response()->json([
            'success' => false,
            'code'    => 400,
            'message' => 'Data tidak ditemukan',
        ]);
    }


  }

  public function hapus(Request $req, $enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
    $pasien = Pasien::find($dec_id);

    if ($pasien) {
      $pasien->delete();
      return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
    } else {
      return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
    }
  }
  function autocomplete(Request $request)
  {
    $datapasien = Pasien::select('nama_pasien')->where('nama_pasien', 'LIKE', $request->term . '%')->get();
    $return_arr = array();
    foreach ($datapasien as $pasien) {
      $return_arr[] = $pasien->nama_pasien;
    }
    echo json_encode($return_arr);
  }

  public function cetakPasienKunjungan(Request $request)
  {
    $pasien = Pasien::all();
    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '11',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'DATA KUNJUNGAN PASIEN PUSKESMAS',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetak_kunjungan', ['pasien' => $pasien], [], $config);
    ob_get_clean();
    return $pdf->download('Data Pasien_' . date('d_m_Y H_i_s') . '.pdf');
    //download : langsung download
    //stream : open preview
  }
}
