<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\DiagnosaPenyakit;
use App\Models\Simpusk\Kunjungan;
use Illuminate\Http\Request;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pegawai;
use App\Models\Simpusk\Pelayananpoli;
use App\Models\Simpusk\Pelayananlaboratorium;
use App\Models\Simpusk\Pelayananpoliresep;
use App\Models\Simpusk\Pelayananpolidiagnosa;
use App\Models\Simpusk\Pelayananpolilaboratorium;
use App\Models\Simpusk\Tindakan;
use App\Models\Simpusk\Obat;
use App\Models\Simpusk\LaporanBPJS;
use App\Models\Simpusk\Pcare;
use App\Models\Simpusk\RujukLanjut;
use App\Models\Simpusk\StokObat;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use Auth;
use Illuminate\Support\Carbon;

use function GuzzleHttp\Psr7\str;

class PelayananpoliController extends Controller
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
    return view('pelayanan/pelayanan_poli');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];
      $search_tgl = $request->search_tgl;
        if(Auth::user()->poli != '-'){
            $poli = Auth::user()->poli;
            $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien', 'tbl_pendaftaran.flag_periksa', 'tbl_pendaftaran.nama_penanggung_jawab', 'tbl_pasien.alamat',
                'tbl_poli.nama_poli')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.kdpoli','tbl_pendaftaran.id_poli')->where(function ($query) use ($search_tgl) {
                    $query->orwhere('tbl_pendaftaran.flag_periksa', 0);
                    $query->orwhere('tbl_pendaftaran.flag_periksa', 3);
                })->where('tbl_pendaftaran.id_poli', Auth::user()->poli);

        }
        else{
            $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien', 'tbl_pendaftaran.flag_periksa', 'tbl_pendaftaran.nama_penanggung_jawab', 'tbl_pasien.alamat',
            'tbl_poli.nama_poli')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.kdpoli','tbl_pendaftaran.id_poli')->where(function ($query) use ($search_tgl) {
                $query->orwhere('tbl_pendaftaran.flag_periksa', 0);
                $query->orwhere('tbl_pendaftaran.flag_periksa', 3);
            });
            // return $records->get();
        }
        $records->whereDate('tbl_pendaftaran.tanggal_daftar', '=', date('Y-m-d', strtotime($search_tgl)));

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('tbl_pendaftaran.no_rawat','LIKE',"%{$search}%");
                $query->orWhere('tbl_pendaftaran.no_rekamedis','LIKE',"%{$search}%");
                $query->orWhere('tbl_pasien.nama_pasien','LIKE',"%{$search}%");
                $query->orWhere('tbl_pendaftaran.status_pasien','LIKE',"%{$search}%");
                // $query->orWhere('tbl_pegawai.nama_pegawai','LIKE',"%{$search}%");
                $query->orWhere('tbl_poli.nama_poli','LIKE',"%{$search}%");
        });
      }
      $totalData = $records->get()->count();

      $totalFiltered = $records->get()->count();

      $records->limit($limit);
      $records->offset($start);
      $data = $records->get();
      foreach ($data as $key=> $record)
      {
        // return $record;
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
        $action = "";

        // if($request->user()->can('pelayanan_poli.hapus')){
        //   $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="ion ion-md-close"></i></a>&nbsp;';
        // }

        if($request->user()->can('pelayanan_poli.tindakan_dokter')){
            if($record->flag_periksa == 0){
                $action.='<a href="'.route('pelayanan_poli.tindakan_dokter',$enc_id).'"  class="btn btn-success" title="Periksa Dokter">Tindakan Dokter</a>&nbsp;';

            }else if($record->flag_periksa == 3){
                $action.='<a href="'.route('pelayanan_poli.tindakan_dokter',$enc_id).'"  class="btn btn-warning" title="Periksa Dokter">Diagnosa & Resep Obat</a>&nbsp;';
                // $pelayananpoli = Pelayananpoli::where('pendaftaran_id', $record->id)->first();
                // return $pelayananpoli;
            }
        }

        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->no_rawat       = $record->no_rawat;
        $record->no_rekamedis   = $record->no_rekamedis;
        $record->nama_pasien    = $record->nama_pasien;
        $record->alamat         = $record->alamat;
        $record->status_pasien  = $record->status_pasien;
        $record->nama_penanggung_jawab   = $record->nama_penanggung_jawab;
        $record->nama_poli      = $record->nama_poli;
        $record->action         = $action;
      }

      if ($request->user()->can('pelayanan_poli.index')) {
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
        $data = Pasien::select("*")->where("no_rekamedis","LIKE","%{$query}%")->get();
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
        $query= $request['query'];
        $data = Pegawai::select("*")->where('id_bidang',3)->where("nama_pegawai","LIKE","%{$query}%")->get();
        $output = '';
        if (count($data)>0) {
            $output = '<ul class="list-unstyled" style="cursor: pointer;display: block; position: absolute;z-index: 99999 !important";border: 2px solid #000000;
    padding: 5px 0;border-radius: 2px;>';
            foreach ($data as $row){

                $output .= '<li class="list-group-item pilihdokter" data-row=\''.$row.'\'style="background: antiquewhite;">'.$row->nik.' | '.$row->nama_pegawai.'</li>';
            }
            $output .= '</ul>';
        }
        else {
            $output .= '<li class="list-group-item">'.'No results'.'</li>';
        }
        return $output;

   }
  public function tambah()
  {
      $pjj = $this->pjj();
      $selectedpjj = '';
      $status = $this->status_pasien();
      $selectedstatus = '';
      $poli = Poli::all();
      $selectedpoli = "";

      return view('backend/pendaftaran/form',compact('pjj','selectedpjj','status','selectedstatus','poli','selectedpoli'));
  }
  // ubah : Form ubah data
  public function tindakan_dokter($enc_id)
  {
    $Tindakans = Tindakan::all();
    // return $Tindakans;
    $Obats = Obat::all();
    $Lab = Pelayananlaboratorium::where('status',1)->get();
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        //$poli= Pelayananpoli::find($dec_id);
        $poli = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pendaftaran.id_dokter','tbl_pendaftaran.nama_penanggung_jawab', 'tbl_pendaftaran.flag_periksa', 'tbl_pasien.nama_pasien','tbl_pasien.tanggal_lahir','tbl_pendaftaran.status_pasien','tbl_poli.nama_poli','tbl_poli.kdpoli as poliid','tbl_pendaftaran.no_bpjs')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.kdpoli','tbl_pendaftaran.id_poli')->where('tbl_pendaftaran.id',$dec_id)->first();
        // return $poli;
        if($poli->flag_periksa == 0){
            return view('pelayanan_form/pelayanan_poli_form',compact('enc_id','poli','Tindakans','Obats','Lab'));
        }else if($poli->flag_periksa == 3){
            $kunjungan = Kunjungan::where('id_pendaftaran', $poli->id)->with('rujuk_lanjut', 'faskes_rujuk')->first();
            // return $kunjungan;
            $pelayananpoli = Pelayananpoli::where('pendaftaran_id', $kunjungan->pendaftaran->id)->with('poli_laboratorium','poli_laboratorium.pelayananlaboratorium')->first();
            $PelayananLab = $pelayananpoli->poli_laboratorium;
            // return $PelayananLab;
            // $diagnosa1 = $kunjungan->diagnosa1;
            // $diagnosa2 = $kunjungan->diagnosa2;
            // $diagnosa3 = $kunjungan->diagnosa3;
            // $pendaftaran = $pelayananpoli->pendaftaran;
            // $pasien = $pelayananpoli->pendaftaran->pasien;
            return view('pelayanan_form/pelayanan_poli_form',compact('enc_id','poli','Tindakans','Obats','Lab', 'kunjungan', 'PelayananLab'));

            // return $diagnosa1;
        }

        //dd($poli);
        // return response()->json([
        //   'datas' => $poli
        // ]);
         //return $poli;
        //  return $dec_id;
        //   return $poli;
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
        // return $req->all();
        // return "tes";
        // return $req->all();
      $enc_id     = $req->enc_id;
      if ($enc_id != null) {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      }else{
        $dec_id = null;
      }
      $pendaftaran = Pendaftaran::where('id',$dec_id)->first();
      if(isset($pendaftaran)){
        if($req->status_pasien == "Umum"){
        //    $pelayananpoli = $this->simpanPelayananPoli($req);
        //     //    return $pelayananpoli;
        //    if($pelayananpoli['success'] == true){
        //         return response()->json([
        //             'success' => true,
        //             'code' => 201,
        //             'message' => 'Data Berhasil Disimpan'
        //         ]);
        //     }else{
        //         return $pelayananpoli;
        //     }


            $daftar_kunjungan = $this->daftarKunjungan($req, $pendaftaran);
            // $pelayananpoli = $this->simpanPelayananPoli($req);
            // return $daftar_kunjungan;
            if($daftar_kunjungan['success'] == true){
                $pelayananpoli = $this->simpanPelayananPoli($req);
                // return $pelayananpoli;
                if($pelayananpoli['success'] == true){
                    if($req->status_pulang == '4'){
                        return response()->json([
                            'print' => true,
                            'status_pasien' => 'Umum',
                            'id_pendaftaran' => $pendaftaran->id,
                            'nokunjungan' => $daftar_kunjungan['nokunjungan'],
                            'success' => true,
                            'code' => 201,
                            'message' => 'Data Berhasil Disimpan'
                        ]);
                    }
                    return response()->json([
                        'print'  => false,
                        'success' => true,
                        'code' => 201,
                        'message' => 'Data Berhasil Disimpan'
                    ]);
                }else{
                    return $pelayananpoli;
                }
            }else{
                return $daftar_kunjungan;
            }
        }else{
           $daftar_kunjungan = $this->daftarKunjungan($req, $pendaftaran);
           if($daftar_kunjungan['success'] == true){
               $pelayananpoli = $this->simpanPelayananPoli($req);
               if($pelayananpoli['success'] == true){
                   if($req->status_pulang == '4'){
                      return response()->json([
                        'print' => true,
                        'status_pulang' => 'BPJS',
                        'id_pendaftaran' => $pendaftaran->id,
                        'nokunjungan' => $daftar_kunjungan['nokunjungan'],
                        'success' => true,
                        'code' => 201,
                        'message' => 'Data Berhasil Disimpan'
                      ]);
                   }
                   return response()->json([
                       'print'  => false,
                       'success' => true,
                       'code' => 201,
                       'message' => 'Data Berhasil Disimpan'
                   ]);
               }else{
                   return $pelayananpoli;
               }
           }else{
               return $daftar_kunjungan;
           }
        }
      }else{
          return response()->json([
            "success" => false,
            "code" => 401,
            "message" => "Pasien sudah dilayani atau belum terdaftar"
          ]);
      }
    }
    public function simpanPelayananPoli($req){
        $Pelayananpoli = Pelayananpoli::where('pendaftaran_id', $req->pendaftaran_id)->first();
        // return $Pelayananpoli;
        if(!isset($Pelayananpoli)){
            $Pelayananpoli = new Pelayananpoli;
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
        }

        $ppolidiagnosa = Pelayananpolidiagnosa::where('pelayanan_poli_id',$Pelayananpoli->id)->delete();
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
            // return $Pelayananpoli;
            if($Pelayananpoli){
                // return $Pelayananpoli;
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
                    $pendaftaran->flag_periksa = 2;

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
                            "message" => "Data pelayanan poli gagal disimpan",
                        );
                    }
                }else{
                    $pendaftaran = Pendaftaran::find($req->pendaftaran_id);
                    if(isset($pendaftaran)){
                        if($pendaftaran->flag_periksa == 3){
                            $pendaftaran->flag_periksa = 1;
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
                            if(!$pendaftaran->save()){
                                return array(
                                    "success" => false,
                                    "code" => 401,
                                    "message" => "Data pelayanan poli gagal disimpan, update flag periksa gagal",
                                );
                            }
                        }else{
                            return array(
                                "success" => false,
                                "code" => 401,
                                "message" => "Data pelayanan poli gagal disimpan, data pendaftaran pasien tidak ditemukan",
                            );
                        }
                    }else{
                        return array(
                            "success" => false,
                            "code" => 401,
                            "message" => "Data pelayanan poli gagal disimpan, silahkan pilih laboratorium untuk pemeriksaan",
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
    public function daftarKunjungan($request, $pendaftaran){
        // return "tes";
        //   return $pendaftaran;
        $poli = Poli::where('kdpoli',$request->poli_id)->first();
        // return $poli;
        if($request->no_kunjungan != null){
            $nokunjungan = $request->no_kunjungan;
            $kdpoli     = null;
            $kdpoliinternal = $poli->kdpoli;
        }else{
            $nokunjungan = null;
            $kdpoli     = $poli->kdpoli;
            $kdpoliinternal = null;
        }

        $nokartu    = $request->no_bpjs;
        $tgldaftar  = date('d-m-Y', strtotime($pendaftaran->tanggal_daftar));
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

        if($pendaftaran->status_pasien == "BPJS"){
            return $post;
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
                $simpan = $this->simpan_data_bpjs(json_decode($post,true), $no_kunjungan, $spesialis, $pendaftaran, $request);
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
            $simpan = $this->simpan_data_bpjs(json_decode($post,true), $no_kunjungan, $spesialis, $pendaftaran, $request);
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
                    $rujuk  = new RujukLanjut;
                    // $rujuk  = RujukLanjut::where('kunjungan_id', $kunjungan->id);
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
                    if($rujuk->save()){
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
                    }else{
                        return array(
                            "print" => false,
                            "success" => false,
                            "code" => 401,
                            "message" => "Data Rujuk Lanjut Gagal Disimpan"
                        );
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
    public function hapus(Request $req,$enc_id)
    {
      $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      $pendaftaran = Pendaftaran::find($dec_id);

      if ($pendaftaran) {
          $pendaftaran->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }
    public function searchDiagnosa(Request $request){
        // $data = DiagnosaPenyakit::where('nama_penyakit', 'LIKE', '%'.$request->input('term', '').'%')
        //     ->get(['kode_diagnosa as id', 'nama_penyakit as text']);
        // return ['results' => $data];

        $query = DiagnosaPenyakit::select('*')
        ->orWhere('kode_diagnosa', 'LIKE', "%{$request->search}%");
        $query->orWhere('nama_penyakit', 'LIKE', "%{$request->search}%")
                ->limit(15);
        $diagnosa = $query->get();

        return json_encode($diagnosa);
        // $data = '{
        //     "results": [
        //       {
        //         "id": 1,
        //         "text": "New Vanfort"
        //       },
        //       {
        //         "id": 8,
        //         "text": "New Iva"
        //       },
        //       {
        //         "id": 14,
        //         "text": "New Traceychester"
        //       }
        //     ]
        //   }';
        // return $data;
    }

    public function searchTindakan(Request $request){
        $query = Tindakan::orWhere('kode_tindakan', 'LIKE', "%{$request->search}%");
        $query->orWhere('nama_tindakan', 'LIKE', "%{$request->search}%")
                ->limit(15);
        $diagnosa = $query->get();

        return json_encode($diagnosa);
        // return response()->json(['data' => $obat]);
    }
    public function addDiagnosis(Request $req){
      $total = $req->total;
      $Tindakans = Tindakan::all();
      $diagnosa = DiagnosaPenyakit::all();

      echo"
      <tr id='dataAjaxDiagnosis_".$total."'>
            <td> <select class='form-control select2_diagnosa_".$total."' name='nama_diagnosi_".$total."' id='nama_diagnosi_".$total."'>

                ";
                // foreach($diagnosa as $diag){
                //     echo"<option value='".$diag->kode_diagnosa."'>".$diag->kode_diagnosa." | ".$diag->nama_penyakit." </option>";
                // }
                echo"
            </select></td>
            <td width='40%'><select id='tindakan_".$total."' name='tindakan_".$total."' class='select2_tindakan_".$total." form-control'>
            <option value='0' selected disabled>Pilih Tindakan</option>
          ";
          foreach($Tindakans as $tindakan){
            echo"
                <option value=".$tindakan->id.">".$tindakan->kode_tindakan." - ".$tindakan->nama_tindakan."</option>";
                }echo"
        </select> </td>
        <td width='5%'><a href='#!' onclick='javascript:deleteDiagnosi(".$total.")' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus'><i class='fa fa-close'></i></a></td>
      </tr>

      <script>
        $(function () {
            $('.select2_diagnosa_".$total."').select2({

            placeholder: 'Pilih Diagnosa',
            ajax: {
                url: '".route('pelayanan_poli.searchDiagnosa')."',
                dataType: 'JSON',
                data: function(params) {
                return {
                    search: params.term
                }
                },
                processResults: function (data) {
                var results = [];
                $.each(data, function(index, item){
                    results.push({
                        id: item.kode_diagnosa,
                        text : item.kode_diagnosa+' | '+item.nama_penyakit,
                    });
                });
                return{
                    results: results
                };
                }
            }
            })
            $('.select2_tindakan_".$total."').select2({

            placeholder: 'Pilih Tindakan',
            ajax: {
                url: '".route('pelayanan_poli.searchTindakan')."',
                dataType: 'JSON',
                data: function(params) {
                return {
                    search: params.term
                }
                },
                processResults: function (data) {
                var results = [];
                $.each(data, function(index, item){
                    results.push({
                        id: item.id,
                        text : item.kode_tindakan+' | '+item.nama_tindakan,
                    });
                });
                return{
                    results: results
                };
                }
            }
            })
        })
        </script>


        <script>
          function deleteDiagnosi(id){

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data akan terhapus!',

                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Ya',
                cancelButtonText:'Batal',
                confirmButtonColor: '#ec6c62',
                closeOnConfirm: false
              }).then(function(result){
                if(result.value){
                    $('#dataAjaxDiagnosis_'+id).remove();

                }


            });

          }
          </script>


      ";

    }

    public function searchObat(Request $request){
        $stok = StokObat::select('id_obat')->where('stok_obat', '>', '0')->distinct()->get();
        if($stok->count()>0){
            foreach($stok as $st){
                $id_obt[] = $st->id_obat;
            }
        }
        else{
            $id_obt = array();
        }
        $key = $request->search;
        $query = Obat::WhereIn('id',$id_obt);
        $query->where(function($q) use($key){
            $q->orwhere('nama_obat', 'LIKE', "%{$key}%");
            $q->orwhere('kode_obat', 'LIKE', "%{$key}%");
        });
        // $query->orWhere('nama_obat', 'LIKE', "%{$request->search}%")
        //         ->limit(15);
        // $query->orWhere('kode_obat', 'LIKE', "%{$request->search}%");
        $obat = $query->get();

        return json_encode($obat);
    }

      public function addObat(Request $req){
      $total = $req->total;
      $stok = StokObat::select('id_obat')->where('stok_obat', '>', '0')->distinct()->get();
      foreach($stok as $st){
          $id_obt[] = $st->id_obat;
      }

      $Obats = Obat::whereIn('id', $id_obt)->get();
     // return $Obats;

      echo"
      <tr id='dataAjaxObat_".$total."'>
        <td width='30%'><select id='obat_".$total."' name='obat_".$total."' class='select2_obat_".$total." form-control mb-1'>
        <option value='0' selected disabled>Pilih Obat</option> ";
    //   foreach($Obats as $obat){
    //     echo"
    //         <option value=".$obat->id.">".$obat->kode_obat." - ".$obat->nama_obat."</option>";
    //         }
    echo"
    </select></td>
        <td><input type='number' min='1' class='form-control form-control-sm mb-1' name='jumlah_obat_".$total."' id='jumlah_obat_".$total."'></td>
        <td><input type='text' class='form-control form-control-sm mb-1' name='aturan_pakai_obat_".$total."' id='aturan_pakai_obat_".$total."' value='3x1, Setelah Makan'></td>
        <td><a href='#!' onclick='javascript:deleteObat(".$total.")' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus'><i class='fa fa-close'></i></a></td>

      </tr>

        <script>
            $(function () {
                $('.select2_obat_".$total."').select2({

                    placeholder: 'Pilih Obat',
                    ajax: {
                        url: '".route('pelayanan_poli.searchObat')."',
                        dataType: 'JSON',
                        data: function(params) {
                        return {
                            search: params.term
                        }
                        },
                        processResults: function (data) {
                        var results = [];
                        $.each(data, function(index, item){
                            results.push({
                                id: item.id,
                                text : item.kode_obat+' - '+item.nama_obat,
                            });
                        });
                        return{
                            results: results
                        };
                        }
                    }
                })
            })
        </script>

        <script>
          function deleteObat(id){

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data akan terhapus!',

                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Ya',
                cancelButtonText:'Batal',
                confirmButtonColor: '#ec6c62',
                closeOnConfirm: false
              }).then(function(result){
                if(result.value){
                    $('#dataAjaxObat_'+id).remove();

                }


            });



          }
          </script>


      ";

    }



    public function simpanPelayananPoli_(Request $req){
      $Pelayananpoli = new Pelayananpoli;

      $Pelayananpoli->pendaftaran_id         = $req->pendaftaran_id;
      $Pelayananpoli->penunjang              = $req->penunjang;
      $Pelayananpoli->note                   = $req->note;
      $Pelayananpoli->dokter_id              = auth()->user()->id;
      $Pelayananpoli->created_at             = date('Y-m-d H:i:s');
      $Pelayananpoli->save();

      if($Pelayananpoli->penunjang == "T"){
        $pendaftaran = Pendaftaran::find($req->pendaftaran_id);
                $pendaftaran->flag_periksa = 1;
                $pendaftaran->save();
        if($pendaftaran){
            $total_d = $req->total_diagnosis;

            for($i=1;$i<=$total_d;$i++){
              if($req->input('nama_diagnosi_'.$i) != ""){
                $ppolidiagnosa = new Pelayananpolidiagnosa;

                $ppolidiagnosa->pelayanan_poli_id      = $Pelayananpoli->id;
                $ppolidiagnosa->tindakan_id            = $req->input('tindakan_'.$i);
                $ppolidiagnosa->diagnosa               = $req->input('nama_diagnosi_'.$i);
                $ppolidiagnosa->save();
              }

              if($req->input('obat_'.$i) != "" || $req->input('obat_'.$i) != "0"){
                $poliresep    = new Pelayananpoliresep;

                $poliresep->pelayanan_poli_id = $Pelayananpoli->id;
                $poliresep->obat_id           = $req->input('obat_'.$i);
                $poliresep->jumlah            = $req->input('jumlah_obat_'.$i);
                $poliresep->cara_pakai        = $req->input('cara_pakai_obat_'.$i);
                $poliresep->aturan_pakai      = $req->input('aturan_pakai_obat_'.$i);
                $poliresep->save();
              }
            }

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
        return json_encode($json_data);

      }else{
      if($Pelayananpoli){
          $datalab = Pelayananlaboratorium::all();
          foreach($datalab as $lab){
            $cekLab    = $req->input('lab_pemeriksaan_'.$lab->id);
            if($cekLab == 1){
            $p_lab = new Pelayananpolilaboratorium;
            $p_lab->pelayanan_poli_id         = $Pelayananpoli->id;
            $p_lab->pelayanan_laboratorium_id = $lab->id;
            $p_lab->nilai = 0;
            $p_lab->save();
            }

          }
          if($p_lab) {
            $pendaftaran = Pendaftaran::find($req->pendaftaran_id);
            $pendaftaran->flag_periksa = 1;
            $pendaftaran->save();
              if($pendaftaran){
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
    }
      return json_encode($json_data);
    }
  }



  public function getDiagnosa(Request $request){
    $keywoard = $request->keywoard;
    // return $request->all();
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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

            $ch = curl_init($uri.'/diagnosa/'.$keywoard.'/0/15');
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

            header("Content-Type: application/json");
            $tamp = json_decode($data, true);
            foreach($tamp['response']['list'] as $diag){
                $cek = DiagnosaPenyakit::where('kode_diagnosa', $diag['kdDiag'])->first();
                if(!isset($cek)){
                    $datadiag = new DiagnosaPenyakit;
                    $datadiag->kode_diagnosa = $diag['kdDiag'];
                    $datadiag->nama_penyakit = $diag['nmDiag'];
                    if($datadiag->save()){
                        continue;
                    }else{
                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal menyimpan diagnosa ke database',
                            ]);
                        break;

                    }
                }

            }
            return response()->json([
              'success' => true,
              'datas' => json_decode($data),
            ]);
  }
  public function getDokterBpjs(){
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');
    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

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
        return response()->json([
            'datas' => $data,
            'success' => true,
        ]);
  }

  public function getKesadaran(){
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


    $ch = curl_init($uri.'/kesadaran');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getSpesialis(){
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');;

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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


    $ch = curl_init($uri.'/spesialis');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getSubSpesialis(Request $request){
    $kdspesialis = $request->spesialis;
    // return $request->all();
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');;

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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

    $ch = curl_init($uri.'/spesialis/'.$kdspesialis.'/subspesialis');
    // $ch = curl_init($uri.'/spesialis'.$kdspesialis.'/subspesialis');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getKhusus(){
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');;

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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


    $ch = curl_init($uri.'/spesialis/khusus');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getSarana(){
    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');;

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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


    $ch = curl_init($uri.'/spesialis/sarana');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getFaskesRujukSpesialis(Request $request){
    //   return $request->all();
    $kdsubspesialis = $request->kdsubspesialis;
    $kdsarana = $request->kdsarana;
    $tglrujuk = $request->tglrujuk;

    $uri = env('API_URL', 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0');;

    $consID 	= env('API_CONSID', '9243'); //customer ID anda
    $secretKey 	= env('API_SECRETKEY', '3yVE45CCBC'); //secretKey anda

    $pcare = Pcare::first();
    $pcareUname = $pcare->username;
    $pcarePWD = $pcare->password;

    $kdAplikasi	= env('API_KDAPLIKASI', '095'); //kode aplikasi

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

    $ch = curl_init($uri.'/spesialis/rujuk/subspesialis/'.$kdsubspesialis.'/sarana/'.$kdsarana.'/tglEstRujuk/'.$tglrujuk);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

  public function getFaskesRujukKhusus(Request $request){
    $kdkhusus = $request->kdkhusus;
    $nokartu = $request->nokartu;
    $tglrujuk = $request->tglrujuk;

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

    $ch = curl_init($uri.'/spesialis/rujuk/khusus/'.$kdkhusus.'/noKartu/'.$nokartu.'/tglEstRujuk/'.$tglrujuk);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo curl_error($ch);
    }
    curl_close($ch);

    header("Content-Type: application/json");

    $faskes = json_decode($data, true);
    if($faskes['metaData']['code'] == 200){
    $save_faskes = $faskes['response']['list'];
        foreach ($save_faskes as $key => $value) {
        $this->faskes_rujuk($value);
        }
    }

    return response()->json([
        'datas' => $faskes
    ]);
  }

  public function getFaskesRujukSubKhusus(Request $request){
    $kdkhusus = $request->kdkhusus;
    $subkhusus = $request->subkhusus;
    $nokartu = $request->nokartu;
    $tglrujuk = $request->tglrujuk;

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

    $ch = curl_init($uri.'/spesialis/rujuk/khusus/'.$kdkhusus.'/subspesialis/'.$subkhusus.'/noKartu/'.$nokartu.'/tglEstRujuk/'.$tglrujuk);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo curl_error($ch);
    }
    curl_close($ch);

    header("Content-Type: application/json");

    $faskes = json_decode($data, true);
    if($faskes['metaData']['code'] == 200){
        $save_faskes = $faskes['response']['list'];
        foreach ($save_faskes as $key => $value) {
        $this->faskes_rujuk($value);
        }
    }

    return response()->json([
        'datas' => $faskes
    ]);
  }

  public function insertlaporanbpjs($datalaporan){
    // return $datalaporan;
    if($datalaporan['nokartu'] != "-"){
        $datapendaftaran_nama = Pasien::where('no_bpjs', $datalaporan['nokartu'])->first()->nama_pasien;
    }else{
        $datapendaftaran_nama = Pasien::where('no_rekamedis', $datalaporan['pendaftaran']['no_rekamedis'])->first()->nama_pasien;
    }
    $laporanbpjs = new LaporanBPJS;
    $laporanbpjs->nokunjungan = $datalaporan['nokunjungan'];
    $laporanbpjs->nokartu     = $datalaporan['nokartu'];
    $laporanbpjs->nama        = $datapendaftaran_nama;
    $laporanbpjs->tglkunjungan= $datalaporan['tgldaftar'];

    if($laporanbpjs->save()){
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
  public function notifikasi(){
    $pendaftaran = Pendaftaran::where('tanggal_daftar', date('Y-m-d'));
    $pendaftaran->where(function($q){
        $q->orwhere('flag_periksa', 0);
        $q->orwhere('flag_periksa', 3);
    });
    if(auth()->user()->poli != '-'){
        $pendaftaran->where('id_poli', auth()->user()->poli);
    }
    $pendaftaran = $pendaftaran->get();
    return count($pendaftaran);
  }
  public function toast(){
    $pendaftaran = Pendaftaran::where('tanggal_daftar', date('Y-m-d'));
    $pendaftaran->where(function($q){
        $q->orwhere('flag_periksa', 0);
        $q->orwhere('flag_periksa', 3);
    });
    if(auth()->user()->poli != '-'){
        $pendaftaran->where('id_poli', auth()->user()->poli);
    }
    // $timestamp = strtotime(date('H:i')) - 60;
    // return date('Y-m-d H:i:s', strtotime('now - 1 minutes'));
    // return date('H:i:s', strtotime('now - 1 minutes'));
    $datetime = new Carbon(date('H:i:s', strtotime('now - 2 seconds')));
    // return $datetime;
    $pendaftaran->where('created_at', '>=', $datetime);
    $pendaftaran = $pendaftaran->get();
    return count($pendaftaran);


  }
}
