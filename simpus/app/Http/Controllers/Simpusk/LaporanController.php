<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Bidang;
use App\Models\Simpusk\DetailPengeluaranObat;
use App\Models\Simpusk\Jabatan;
use Illuminate\Http\Request;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pegawai;
use App\Muse;
use App\Models\Simpusk\LaporanBPJS;
use App\Models\Simpusk\Pelayananpoli;
use App\Models\Simpusk\Pelayananpoliresep;
use App\Models\Simpusk\Pelayananpolidiagnosa;
use App\Models\Simpusk\Pelayananlaboratorium;
use App\Models\Simpusk\Pelayananpolilaboratorium;
use App\Models\Simpusk\Tindakan;
use App\Models\Simpusk\Obat;
use App\Models\Simpusk\PengeluaranObat;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;

class LaporanController extends Controller
{
  protected $original_column = array(
    1 => "no_rawat",
    2 => "no_rekamedis",
    3 => "nama_pasien",
    4 => "status_pasien",
    5 => "tbl_pegawai.nama_pegawai",
    6 => "tbl_poli.nama_poli",

  );

  public function pasienDiagnosa()
  {
    //$pasien = Pasien::all();

    return view('laporan/laporanpasiendiagnosa');
  }

  public function pasienBPJS()
  {
    //$pasien = Pasien::all();
    return view('integrasi_bpjs/pasien_bpjs');
  }
  public function rujukanBPJS()
  {
    //$pasien = Pasien::all();
    return view('integrasi_bpjs/rujukan_pasien_bpjs');
  }

  public function pasienTindakan()
  {
    //$pasien = Pasien::all();
    return view('laporan/laporanpasientindakan');
  }


  public function getdatapasienDiagnosa(Request $request)
  { {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start + 1;
      $search = $request->search['value'];

      $records = Pasien::select('*');

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
        $enc_id = $this->safe_encode(Crypt::encryptString($record->no_rekamedis));
        $action = "";


        $action .= '<a href="' . route('report.detailDiagnosis', $enc_id) . '"  class="btn btn-success" title="Diagnosis Pasien">Lihat Diagnosis Pasien</a>&nbsp;';

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
  public function getdatarujukanBPJS(Request $request)
  { {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start + 1;
      $search = $request->search['value'];

      $records = LaporanBPJS::select('*');

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
    //   return $data;
    // return "tes";
      foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->nokunjungan));
        $action = "";


        $action .= '<a href="' . route('report.detailRujukan', $record->nokunjungan) . '"  class="btn btn-simpan" title="Detail Rujukan"><i class="fa fa-eye"></i></a>&nbsp;';
        $record->no             = $key + $page;
        $record->DT_RowId       = $record->id;
        $record->nokunjungan    = $record->nokunjungan;
        $record->nokartu        = $record->nokartu;
        $record->nama_pasien    = $record->nama_pasien;
        $record->tglkunjungan   = $record->tglkunjungan;

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

  public function getdatapasienTindakan(Request $request)
  { {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start + 1;
      $search = $request->search['value'];

      $records = Pasien::select('*');

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
        $enc_id = $this->safe_encode(Crypt::encryptString($record->no_rekamedis));
        $action = "";


        $action .= '<a href="' . route('report.detailTindakan', $enc_id) . '"  class="btn btn-success" title="Tindakan Pasien">Lihat Tindakan Pasien</a>&nbsp;';





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

  function laporan_diagnosis($enc_id)
  {

    $no_rekamedis = $this->safe_decode(Crypt::decryptString($enc_id));
    $poli = Pasien::select('*')->where('no_rekamedis', $no_rekamedis)->first();
    $records = Pelayananpolidiagnosa::select(
      'tbl_pelayanan_poli_diagnosa.*',
      'tbl_pendaftaran.id',
      'tbl_pendaftaran.no_rawat',
      'tbl_pendaftaran.no_rekamedis',
      'tbl_pasien.nama_pasien',
      'tbl_pasien.tempat_lahir',
      'tbl_pendaftaran.status_pasien',
      'tbl_poli.nama_poli',
      'users.name as nama_user',
      'tbl_pelayanan_poli.id as id_pelayanan_poli',
      'tbl_pelayanan_poli.flag_lab as flag_lab'
    )
      ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
      ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
      ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
      ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
      ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
      ->where('tbl_pendaftaran.no_rekamedis', $no_rekamedis)->get();

    return view('laporan_dll/laporanpasiendiagnosadetail', compact('poli', 'records', 'no_rekamedis', 'enc_id'));
  }
  function laporan_rujukan($enc_id)
  {
    $nokunjungan = $enc_id;
    $data = LaporanBPJS::where('nokunjungan', $enc_id);
    // return response()->json(['data' => $nokartu]);
    return view('backend/report/pasienRujukanDetail', compact('data', 'nokunjungan', 'enc_id'));
  }

  function laporan_bpjs($enc_id)
  {

    $no_bpjs = $this->safe_decode(Crypt::decryptString($enc_id));
    $poli = Pasien::select('*')->where('no_bpjs', $no_bpjs)->first();
    //     $records = Pelayananpolidiagnosa::select('tbl_pelayanan_poli_diagnosa.*','tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.tempat_lahir','tbl_pendaftaran.status_pasien',
    //       'tbl_poli.nama_poli','users.name as nama_user','tbl_pelayanan_poli.id as id_pelayanan_poli','tbl_pelayanan_poli.flag_lab as flag_lab')
    //       ->join('tbl_pelayanan_poli','tbl_pelayanan_poli_diagnosa.pelayanan_poli_id','tbl_pelayanan_poli.id')
    //       ->join('tbl_pendaftaran','tbl_pelayanan_poli.pendaftaran_id','tbl_pendaftaran.id')
    //       ->join('users','tbl_pelayanan_poli.dokter_id','users.id')
    //       ->join('tbl_pasien','tbl_pasien.no_bpjs','tbl_pasien.no_bpjs')
    //       ->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')
    //       ->where('tbl_pasien.no_bpjs',$no_bpjs)->toSql();;
    // dd($records);
    return view('backend/report/pasienBPJSDetail', compact('poli', 'no_bpjs', 'enc_id'));
  }

  function laporan_tindakan($enc_id)
  {

    $no_rekamedis = $this->safe_decode(Crypt::decryptString($enc_id));
    $poli = Pasien::select('*')->where('no_rekamedis', $no_rekamedis)->first();
    $records = Pelayananpolidiagnosa::select(
      'tbl_pelayanan_poli_diagnosa.*',
      'tbl_pendaftaran.id',
      'tbl_pendaftaran.no_rawat',
      'tbl_pendaftaran.no_rekamedis',
      'tbl_pasien.nama_pasien',
      'tbl_pasien.tempat_lahir',
      'tbl_pendaftaran.status_pasien',
      'tbl_poli.nama_poli',
      'users.name as nama_user',
      'tbl_pelayanan_poli.id as id_pelayanan_poli',
      'tbl_pelayanan_poli.flag_lab as flag_lab',
      'tbl_tindakan.kode_tindakan',
      'tbl_tindakan.nama_tindakan'
    )
      ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
      ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
      ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
      ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
      ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
      ->join('tbl_tindakan', 'tbl_pelayanan_poli_diagnosa.tindakan_id', 'tbl_tindakan.id')
      ->where('tbl_pendaftaran.no_rekamedis', $no_rekamedis)->get();

    return view('laporan_dll/laporanpasientindakandetail', compact('poli', 'records', 'no_rekamedis', 'enc_id'));
  }

  public function gettindakanpasien(Request $request)
  { {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start + 1;
      $search = $request->search['value'];

      $records = Tindakan::select('*');

      if (array_key_exists($request->order[0]['column'], $this->original_column)) {
        $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
      }

      if ($search) {
        $records->where(function ($query) use ($search) {
          $query->orWhere('nama_tindakan', 'LIKE', "%{$search}%");
          $query->orWhere('kode_tindakan', 'LIKE', "%{$search}%");
        });
      }
      $totalData = $records->get()->count();

      $totalFiltered = $records->get()->count();

      $records->limit($limit);
      $records->offset($start);
      $data = $records->get();
      foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->no_rekamedis));
        $action = "";


        $action .= '<a href="' . route('report.tindakanPasien_detail', $record->id) . '"  class="btn btn-success" title="Tindakan Pasien">Lihat Tindakan Pasien</a>&nbsp;';





        $record->no             = $key + $page;
        $record->kode_tindakan       = $record->kode_tindakan;
        $record->nama_tindakan   = $record->nama_tindakan;
        $record->action     = $action;
      }
      $json_data = array(
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
      );
    //   if ($request->user()->can('pasien.index')) {
    //     $json_data = array(
    //       "draw"            => intval($request->input('draw')),
    //       "recordsTotal"    => intval($totalData),
    //       "recordsFiltered" => intval($totalFiltered),
    //       "data"            => $data
    //     );
    //   } else {
    //     $json_data = array(
    //       "draw"            => intval($request->input('draw')),
    //       "recordsTotal"    => 0,
    //       "recordsFiltered" => 0,
    //       "data"            => []
    //     );
    //   }
      return json_encode($json_data);
    }
  }
  function tindakanpasien_index(){
      return view('laporan/laporantindakanpasien');
  }
  function tindakanPasien_detail($id)
  {
      //return $id;
    // $tindakans = Pelayananpolidiagnosa::select('tbl_pelayanan_poli_diagnosa.*','tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.tempat_lahir','tbl_pendaftaran.status_pasien',
    //     'tbl_poli.nama_poli','users.name as nama_user','tbl_pelayanan_poli.id as id_pelayanan_poli','tbl_pelayanan_poli.flag_lab as flag_lab','tbl_tindakan.kode_tindakan','tbl_tindakan.nama_tindakan')
    //     ->join('tbl_pelayanan_poli','tbl_pelayanan_poli_diagnosa.pelayanan_poli_id','tbl_pelayanan_poli.id')
    //     ->join('tbl_pendaftaran','tbl_pelayanan_poli.pendaftaran_id','tbl_pendaftaran.id')
    //     ->join('users','tbl_pelayanan_poli.dokter_id','users.id')
    //     ->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')
    //     ->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')
    //     ->join('tbl_tindakan','tbl_pelayanan_poli_diagnosa.tindakan_id','tbl_tindakan.id')
    //     ->groupBy('tbl_pelayanan_poli_diagnosa.tindakan_id')
    //     ->get();
    $tindakans = Tindakan::where('id', $id)->get();


    $dTindakans = "";
    foreach ($tindakans as $tindakan) {
      $Pasien = Pelayananpolidiagnosa::select(
        'tbl_pelayanan_poli_diagnosa.*',
        'tbl_pendaftaran.id',
        'tbl_pendaftaran.no_rawat',
        'tbl_pendaftaran.no_rekamedis',
        'tbl_pasien.nama_pasien',
        'tbl_pasien.tempat_lahir',
        'tbl_pendaftaran.status_pasien',
        'tbl_poli.nama_poli',
        'users.name as nama_user',
        'tbl_pelayanan_poli.id as id_pelayanan_poli',
        'tbl_pelayanan_poli.flag_lab as flag_lab',
        'tbl_tindakan.kode_tindakan',
        'tbl_tindakan.nama_tindakan',
        'tbl_pelayanan_poli.created_at as created_at'
      )
        ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
        ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
        ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
        ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
        ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
        ->join('tbl_tindakan', 'tbl_pelayanan_poli_diagnosa.tindakan_id', 'tbl_tindakan.id')
        ->where('tbl_pelayanan_poli_diagnosa.tindakan_id', $id)->get();
      $pOut = "";
      $pOutt = "";
      foreach ($Pasien as $p) {
        $ppp = "" . $p->nama_pasien . "<br>";
        $pppp = "" . $p->created_at . "<br>";

        $pOut = $pOut . $ppp;
        $pOutt = $pOutt . $pppp;
        //echo $pOut;
      }

      $dTindakanss = "<tr>
                            <td>" . $tindakan->nama_tindakan . "</td>
                            <td>" . $pOutt . "</td>
                            <td>" . $pOut . "</td>
                          </tr>";
      $dTindakans = $dTindakans . $dTindakanss;
    }

    $data = $dTindakans;

    return view('laporan/laporantindakanpasien_detail',['id' => $id])->with('data', $data);
  }
  public function cetakTindakanPasien_detail($id)
  {
    $tindakans = Tindakan::where('id',$id)->get();


    $dTindakans = "";
    foreach ($tindakans as $tindakan) {
      $Pasien = Pelayananpolidiagnosa::select(
        'tbl_pelayanan_poli_diagnosa.*',
        'tbl_pendaftaran.id',
        'tbl_pendaftaran.no_rawat',
        'tbl_pendaftaran.no_rekamedis',
        'tbl_pasien.nama_pasien',
        'tbl_pasien.tempat_lahir',
        'tbl_pendaftaran.status_pasien',
        'tbl_poli.nama_poli',
        'users.name as nama_user',
        'tbl_pelayanan_poli.id as id_pelayanan_poli',
        'tbl_pelayanan_poli.flag_lab as flag_lab',
        'tbl_tindakan.kode_tindakan',
        'tbl_tindakan.nama_tindakan',
        'tbl_pelayanan_poli.created_at as created_at'
      )
        ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
        ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
        ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
        ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
        ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
        ->join('tbl_tindakan', 'tbl_pelayanan_poli_diagnosa.tindakan_id', 'tbl_tindakan.id')
        ->where('tbl_pelayanan_poli_diagnosa.tindakan_id', $id)->get();
      $pOut = "";
      $pOutt = "";
      foreach ($Pasien as $p) {
        $ppp = "" . $p->nama_pasien . "<br>";
        $pppp = "" . $p->created_at . "<br>";

        $pOut = $pOut . $ppp;
        $pOutt = $pOutt . $pppp;
        //echo $pOut;
      }

      $dTindakanss = "<tr>
                            <td>" . $tindakan->nama_tindakan . "</td>
                            <td>" . $pOutt . "</td>
                            <td>" . $pOut . "</td>
                          </tr>";
      $dTindakans = $dTindakans . $dTindakanss;
    }

    $data = $dTindakans;
    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '9',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'LAPORAN TINDAKAN PASIEN',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetakReportTindakanPasien', ['data' => $data], [], $config);
    ob_get_clean();
    return $pdf->download('LAPORAN TINDAKAN PASIEN_'.$tindakan->nama_tindakan.'' . date('d_m_Y H_i_s') . '.pdf');
    //download : langsung download
    //stream : open preview
  }

  public function cetakTindakanPasien()
  {
    $tindakans = Tindakan::all();


    $dTindakans = "";
    foreach ($tindakans as $tindakan) {
      $Pasien = Pelayananpolidiagnosa::select(
        'tbl_pelayanan_poli_diagnosa.*',
        'tbl_pendaftaran.id',
        'tbl_pendaftaran.no_rawat',
        'tbl_pendaftaran.no_rekamedis',
        'tbl_pasien.nama_pasien',
        'tbl_pasien.tempat_lahir',
        'tbl_pendaftaran.status_pasien',
        'tbl_poli.nama_poli',
        'users.name as nama_user',
        'tbl_pelayanan_poli.id as id_pelayanan_poli',
        'tbl_pelayanan_poli.flag_lab as flag_lab',
        'tbl_tindakan.kode_tindakan',
        'tbl_tindakan.nama_tindakan',
        'tbl_pelayanan_poli.created_at as created_at'
      )
        ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
        ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
        ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
        ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
        ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
        ->join('tbl_tindakan', 'tbl_pelayanan_poli_diagnosa.tindakan_id', 'tbl_tindakan.id')
        ->where('tbl_pelayanan_poli_diagnosa.tindakan_id', $tindakan->id)->get();
      $pOut = "";
      $pOutt = "";
      foreach ($Pasien as $p) {
        $ppp = "" . $p->nama_pasien . "<br>";
        $pppp = "" . $p->created_at . "<br>";

        $pOut = $pOut . $ppp;
        $pOutt = $pOutt . $pppp;
        //echo $pOut;
      }

      $dTindakanss = "<tr>
                            <td>" . $tindakan->nama_tindakan . "</td>
                            <td>" . $pOutt . "</td>
                            <td>" . $pOut . "</td>
                          </tr>";
      $dTindakans = $dTindakans . $dTindakanss;
    }

    $data = $dTindakans;
    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '9',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'LAPORAN TINDAKAN PASIEN',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetakReportTindakanPasien', ['data' => $data], [], $config);
    ob_get_clean();
    return $pdf->download('LAPORAN TINDAKAN PASIEN_' . date('d_m_Y H_i_s') . '.pdf');
    //download : langsung download
    //stream : open preview
  }


  public function cetakDiagnosa($enc_id)
  {
    $no_rekamedis = $this->safe_decode(Crypt::decryptString($enc_id));
    $poli = Pasien::select('*')->where('no_rekamedis', $no_rekamedis)->first();
    $records = Pelayananpolidiagnosa::select(
      'tbl_pelayanan_poli_diagnosa.*',
      'tbl_pendaftaran.id',
      'tbl_pendaftaran.no_rawat',
      'tbl_pendaftaran.no_rekamedis',
      'tbl_pasien.nama_pasien',
      'tbl_pasien.tempat_lahir',
      'tbl_pendaftaran.status_pasien',
      'tbl_poli.nama_poli',
      'users.name as nama_user',
      'tbl_pelayanan_poli.id as id_pelayanan_poli',
      'tbl_pelayanan_poli.flag_lab as flag_lab'
    )
      ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
      ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
      ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
      ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
      ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
      ->where('tbl_pendaftaran.no_rekamedis', $no_rekamedis)->get();
    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '9',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'DATA LAPORAN PASIEN BERDASARKAN DIAGNOSA',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetakReportPasienDiagnosaDetail', ['no_rekamedis' => $no_rekamedis, 'records' => $records], ['poli' => $poli], [], $config);
    ob_get_clean();
    return $pdf->download('DATA LAPORAN PASIEN BERDASARKAN DIAGNOSA_' . date('d_m_Y H_i_s') . '.pdf');
    //download : langsung download
    //stream : open preview
  }

  public function cetakTindakan($enc_id)
  {
    $no_rekamedis = $this->safe_decode(Crypt::decryptString($enc_id));
    $poli = Pasien::select('*')->where('no_rekamedis', $no_rekamedis)->first();
    $records = Pelayananpolidiagnosa::select(
      'tbl_pelayanan_poli_diagnosa.*',
      'tbl_pendaftaran.id',
      'tbl_pendaftaran.no_rawat',
      'tbl_pendaftaran.no_rekamedis',
      'tbl_pasien.nama_pasien',
      'tbl_pasien.tempat_lahir',
      'tbl_pendaftaran.status_pasien',
      'tbl_poli.nama_poli',
      'users.name as nama_user',
      'tbl_pelayanan_poli.id as id_pelayanan_poli',
      'tbl_pelayanan_poli.flag_lab as flag_lab',
      'tbl_tindakan.kode_tindakan',
      'tbl_tindakan.nama_tindakan'
    )
      ->join('tbl_pelayanan_poli', 'tbl_pelayanan_poli_diagnosa.pelayanan_poli_id', 'tbl_pelayanan_poli.id')
      ->join('tbl_pendaftaran', 'tbl_pelayanan_poli.pendaftaran_id', 'tbl_pendaftaran.id')
      ->join('users', 'tbl_pelayanan_poli.dokter_id', 'users.id')
      ->join('tbl_pasien', 'tbl_pasien.no_rekamedis', 'tbl_pendaftaran.no_rekamedis')
      ->join('tbl_poli', 'tbl_poli.id', 'tbl_pendaftaran.id_poli')
      ->join('tbl_tindakan', 'tbl_pelayanan_poli_diagnosa.tindakan_id', 'tbl_tindakan.id')
      ->where('tbl_pendaftaran.no_rekamedis', $no_rekamedis)->get();
    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '9',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'DATA LAPORAN PASIEN BERDASARKAN DIAGNOSA',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetakReportPasienTindakanDetail', ['no_rekamedis' => $no_rekamedis, 'records' => $records], ['poli' => $poli], [], $config);
    ob_get_clean();
    return $pdf->download('DATA LAPORAN PASIEN BERDASARKAN TINDAKAN_"' . date('d_m_Y H_i_s') . '".pdf');
    //download : langsung download
    //stream : open preview
  }
  public function cetakRujukan($nokunjungan)
  {
    // $no_rekamedis = $this->safe_decode(Crypt::decryptString($enc_id));
    $datarujukan = LaporanBPJS::where('nokunjungan', $nokunjungan)->first();
    // return response()->json(['data' => $datarujukan]);

    $config = [
      'mode'                  => '',
      'format'                => 'A4',
      'default_font_size'     => '9',
      'default_font'          => 'sans-serif',
      'margin_left'           => 8,
      'margin_right'          => 8,
      'margin_top'            => 30,
      'margin_bottom'         => 10,
      'margin_header'         => 0,
      'margin_footer'         => 0,
      'orientation'           => 'L',
      'title'                 => 'DATA LAPORAN PASIEN BERDASARKAN RUJUKAN',
      'author'                => '',
      'watermark'             => '',
      'show_watermark'        => true,
      'show_watermark_image'  => true,
      'watermark_font'        => 'sans-serif',
      'display_mode'          => 'fullpage',
      'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('backend.report.cetakReportPasienRujukanDetail', ['nokunjungan' => $nokunjungan, 'datarujukan' => $datarujukan],);
    ob_get_clean();
    return $pdf->stream('DATA LAPORAN PASIEN BERDASARKAN RUJUKAN_"' . date('d_m_Y H_i_s') . '".pdf');
    //download : langsung download
    //stream : open preview
  }

  public function detailrujukanBPJS(Request $request)
  {
    $nokunjungan = $request->enc_id;
    $uri = "https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0"; //url web service bpjs

    $consID   = "17432"; //customer ID anda
    $secretKey   = "8uRC52B72D"; //secretKey anda

    $pcareUname = "Dvlppkmjepang"; //username pcare
    $pcarePWD   = "Dvlppkmjepang@123"; //password pcare anda

    $kdAplikasi  = "095"; //kode aplikasi

    $stamp    = time();
    $data     = $consID . '&' . $stamp;

    $signature = hash_hmac('sha256', $data, $secretKey, true);

    $headers = array(
      "Accept: application/json",
      "X-cons-id:" . $consID,
      "X-timestamp: " . $stamp,
      "X-signature: " . base64_encode($signature),
      "X-authorization: Basic " . base64_encode($pcareUname . ':' . $pcarePWD . ':' . $kdAplikasi)
    );

    $ch = curl_init($uri . '/kunjungan/rujukan/' . $nokunjungan);
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
      'data' => json_decode($data)
    ]);
  }

  public function detailriwayatBPJS(Request $request)
  {
    $nopeserta = $request->nokartu;
    $uri = "https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0"; //url web service bpjs

    $consID   = "17432"; //customer ID anda
    $secretKey   = "8uRC52B72D"; //secretKey anda

    $pcareUname = "Dvlppkmjepang"; //username pcare
    $pcarePWD   = "Dvlppkmjepang@123"; //password pcare anda

    $kdAplikasi  = "095"; //kode aplikasi

    $stamp    = time();
    $data     = $consID . '&' . $stamp;

    $signature = hash_hmac('sha256', $data, $secretKey, true);

    $headers = array(
      "Accept: application/json",
      "X-cons-id:" . $consID,
      "X-timestamp: " . $stamp,
      "X-signature: " . base64_encode($signature),
      "X-authorization: Basic " . base64_encode($pcareUname . ':' . $pcarePWD . ':' . $kdAplikasi)
    );

    $ch = curl_init($uri . '/kunjungan/peserta/' . $nopeserta);
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
  public function tenagakesehatan_index(){
      return view('laporan/laporantenagapuskesmas');
  }
  public function jabatannakes_index(){
      return view('laporan/laporanjabatan');
  }
  public function jabatan_nakes_getdata(Request $request){
    $limit = $request->length;
    $start = $request->start;
    $page  = $start + 1;
    $search = $request->search['value'];

    $records = Jabatan::select('*');

    //   if(array_key_exists($request->order[0]['column'], $this->original_column)){
    //      $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
    //   }
    //   else{
    //     $records->orderBy('created_at','DESC');
    //   }
    if ($search) {
        $records->where(function ($query) use ($search) {
            $query->orWhere('nama_jabatan', 'LIKE', "%{$search}%");
        });
    }
    $totalData = $records->get()->count();

    $totalFiltered = $records->get()->count();

    $records->limit($limit);
    $records->offset($start);
    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_jabatan));
        $action = "";

        $action .= "";

        $action.='<a href="'.route('jabatannakes.detail', $record->id_jabatan).'" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Lihat Tenaga Kesehatan</a>&nbsp;';
        // if($request->user()->can('jabatan.ubah')){
        //     $action.='<a href="'.route('jabatan.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        // }
        // if($request->user()->can('jabatan.hapus')){
        //     $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        // }

        $record->no             = $key + $page;
        // $record->url            = '<a href="'.$this->url_jabatan().'/'.$record->slug_url.'" target="_blank">'.$this->url_jabatan().'/'.$record->slug_url.'</a>';
        $record->action         = $action;
    }
    if ($request->user()->can('jabatan.index')) {
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
  public function jabatan_detail($id){
    $datas = Pegawai::select('tbl_pegawai.*','tbl_jabatan.nama_jabatan as nama_jabatan','tbl_bidang.nama_bidang as nama_bidang');
    $datas->leftJoin('tbl_jabatan','tbl_jabatan.id_jabatan','tbl_pegawai.id_jabatan');
    $datas->leftJoin('tbl_bidang','tbl_bidang.id_bidang','tbl_pegawai.id_bidang');
    $datas->where('tbl_pegawai.id_jabatan', $id);
    $pegawai = $datas->get();
    // $pegawai = Pegawai::all();
    return view('laporan/laporanjabatan_detail',['data'=> $pegawai, 'id'=>$id]);
    return response()->json(['data' => $pegawai]);
  }
  public function cetakjabatan($id){
    $pegawai = Pegawai::where('id_jabatan', $id)->get();
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
    'title'                 => 'DATA JABATAN NAKES PUSKESMAS',
    'author'                => '',
    'watermark'             => '',
    'show_watermark'        => true,
    'show_watermark_image'  => true,
    'watermark_font'        => 'sans-serif',
    'display_mode'          => 'fullpage',
    'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('laporan_dll/cetak_jabatan_nakes', ['pegawai'=>$pegawai],[],$config);
    ob_get_clean();
    return $pdf->download('Data Pegawai_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview
  }
  public function pemberianobat_index(){
      return view('laporan/laporanpemberian_obat');
  }
  public function getdatapemberianobat(Request $request){
      //return response()->json($request->all());
    $limit = $request->length;
    $start = $request->start;
    $page  = $start + 1;
    $search = $request->search['value'];
    $typefilter = $request->type;
    $min = $request->min;
    $max = $request->max;

    $records = PengeluaranObat::select('*');
    if (array_key_exists($request->order[0]['column'], $this->original_column)) {
        $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
    }


    if($typefilter == "date"){
        if(!empty($min)&&!empty($max)){
            $cek1 = strtotime($min);
            $cek2 = strtotime($max);
            if($cek1 > $cek2){
                $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                );
                return $json_data;
            }
        }

        if($min){
            $data = $records->get();
            $tgl1 = strtotime($min);
            foreach($data as $obat){
                $tgl2 = strtotime($obat->tgl_serah_obat);
                if($tgl1 <= $tgl2){
                    $id_obat[] = $obat->id_pengeluaran;
                }

            }
            if(empty($id_obat)){
                $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                );
                return json_encode($json_data);
            }
            $dat = PengeluaranObat::whereIn('id_pengeluaran', $id_obat);
        }
        if($max){
            if($min){
                $records = $dat;
            }
            $data = $records->get();
            $tgl1 = strtotime($max);
            foreach($data as $obat){
                $tgl2 = strtotime($obat->tgl_serah_obat);
                if($tgl1 >= $tgl2){
                    $id_obat[] = $obat->id_pengeluaran;
                }

            }
            if(empty($id_obat)){
                $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                );
                return json_encode($json_data);
            }
            $records = PengeluaranObat::whereIn('id_pengeluaran', $id_obat);
        }
    }
    elseif($typefilter == "search"){
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('no_terima_obat', 'LIKE', "%{$search}%");
                $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
                $query->orWhere('keterangan', 'LIKE', "%{$search}%");
                $query->orWhere('tgl_serah_obat', 'LIKE', "%{$search}%");
            });
        }
    }
    $totalData = $records->get()->count();

    $totalFiltered = $records->get()->count();

    $records->limit($limit)->get();

    $records->offset($start);
    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pengeluaran));
        $action = "";


        // if ($request->user()->can('pengeluaran_obat.ubah')) {
            $action .= '<a href="' . route('pengeluaran_obat.detail', $enc_id) . '" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
        // }
        if ($request->user()->can('pengeluaran_obat.hapus')) {
            $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }

        $record->no             = $key + $page;
        $record->no_terima_obat  = $record->no_terima_obat;
        $record->nama_pasien  = $record->nama_pasien;
        $record->keterangan      = $record->keterangan;
        $record->tgl_serah_obat      = $record->tgl_serah_obat;
        $record->id_pendaftaran      = $record->id_pendaftaran;
        $record->action         = $action;
    }
    if ($request->user()->can('pengeluaran_obat.index')) {
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
  public function cetakberiobat(Request $request){
    //return response()->json($request->all());
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
        'title'                 => 'DATA PEMBERIAN OBAT PUSKESMAS',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];
    $search = $request->search;

    $typefilter = $request->typefilter;
    $min = $request->min;
    $max = $request->max;

    $records = PengeluaranObat::select('*');
    // if (array_key_exists($request->order[0]['column'], $this->original_column)) {
    //     $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
    // }


    if($typefilter == "date"){

        if($min){
            $data = $records->get();
            $tgl1 = strtotime($min);
            foreach($data as $obat){
                $tgl2 = strtotime($obat->tgl_serah_obat);
                if($tgl1 <= $tgl2){
                    $id_obat[] = $obat->id_pengeluaran;
                }

            }
            if(empty($id_obat)){
                $pdf = PDF::loadView('laporan_dll/cetak_pemberian_obat', ['pengeluaran_obat'=>[]],[],$config);
                ob_get_clean();

                return $pdf->stream('Data Pemberian Obat_'.date('d_m_Y H_i_s').'.pdf');

            }
            $dat = PengeluaranObat::whereIn('id_pengeluaran', $id_obat);
        }
        if($max){
            if($min){
                $records = $dat;
            }
            $data = $records->get();
            $tgl1 = strtotime($max);
            foreach($data as $obat){
                $tgl2 = strtotime($obat->tgl_serah_obat);
                if($tgl1 >= $tgl2){
                    $id_obat[] = $obat->id_pengeluaran;
                }

            }
            if(empty($id_obat)){
                $pdf = PDF::loadView('laporan_dll/cetak_pemberian_obat', ['pengeluaran_obat'=>[]],[],$config);
                ob_get_clean();

                return $pdf->stream('Data Pemberian Obat_'.date('d_m_Y H_i_s').'.pdf');
            }
            $records = PengeluaranObat::whereIn('id_pengeluaran', $id_obat);
        }

    }

    if($typefilter == "search"){
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('no_terima_obat', 'LIKE', "%{$search}%");
                $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
                $query->orWhere('keterangan', 'LIKE', "%{$search}%");
                $query->orWhere('tgl_serah_obat', 'LIKE', "%{$search}%");
            });
        }

    }
    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pengeluaran));


        // $record->no             = $key + $page;
        $record->no_terima_obat  = $record->no_terima_obat;
        $record->nama_pasien  = $record->nama_pasien;
        $record->keterangan      = $record->keterangan;
        $record->tgl_serah_obat      = $record->tgl_serah_obat;
        $record->id_pendaftaran      = $record->id_pendaftaran;
    }
        $pengeluaran_obat = $data;
        //return $pengeluaran_obat;
        foreach($pengeluaran_obat as $obat){

            $array_obat[] = array_merge($obat->toArray(), array(
                'detail' => DetailPengeluaranObat::where('id_pengeluaran_obat', $obat['id_pengeluaran'])->get(),
            ));


        }
        // return $array_obat;

    //return $array_obat;

    $pdf = PDF::loadView('laporan_dll/cetak_pemberian_obat', ['pengeluaran_obat'=>$array_obat],[],$config);
    ob_get_clean();

    return $pdf->stream('Data Pemberian Obat_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview

  }
  public function cetaktenagakesehatan(Request $request){
    //return $request->all();
    $search = $request->search;

    $records = Pegawai::select('*');

    if ($search) {
        $records->where(function ($query) use ($search) {
            $query->orWhere('nama_pegawai', 'LIKE', "%{$search}%")
            ->orWhere('nip', 'LIKE', "%{$search}%")
            ->orWhere('nik', 'LIKE', "%{$search}%")
            ->orWhere('npwp', 'LIKE', "%{$search}%")
            ->orWhere('tempat_lahir', 'LIKE', "%{$search}%");
        });
    }
    $totalData = $records->get()->count();

    $totalFiltered = $records->get()->count();

    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_pegawai));




        $record->nama_jabatan = Jabatan::select('nama_jabatan')->where('id_jabatan',$record->id_jabatan)->first()->nama_jabatan;
        $record->nama_bidang = Bidang::select('nama_bidang')->where('id_bidang',$record->id_bidang)->first()->nama_bidang;

        $record->nipnik = "NIP : ".$record->nip."<br>NIK : ".$record->nik;
        if($record->jenis_kelamin == "Laki-Laki"){
            $record->jenis_kelamin = "L";
        }
        else{
            $record->jenis_kelamin = "P";
        }
    }
    // return $data;

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
        'title'                 => 'DATA PEGAWAI',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];

     //return $data;
    $pdf = PDF::loadView('laporan_dll/cetak_tenaga_puskesmas', ['pegawai'=>$data],[],$config);
    ob_get_clean();
    //return $data;
    //return $pdf->download();
    return $pdf->download('Data Pegawai_'.date('d_m_Y H_i_s').'.pdf');
  }
  public function getdatakunjunganpasien(Request $request){
    $limit = $request->length;
    $start = $request->start;
    $page  = $start + 1;
    $search = $request->search['value'];

    $records = Pasien::select('*');
    if ($search) {
        $records->where(function ($query) use ($search) {
            $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
            $query->orWhere('no_ktp', 'LIKE', "%{$search}%");
            $query->orWhere('no_bpjs', 'LIKE', "%{$search}%");
        });
    }
    $totalData = $records->get()->count();

    $totalFiltered = $records->get()->count();

    $records->limit($limit);
    $records->offset($start);
    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_jabatan));
        $action = "";

        $action .= "";
        $record->no             = $key + $page;
        $record->ktpbpjs        ="KTP : ".$record->no_ktp."<br>BPJS : ".$record->no_bpjs;
    }
    if ($request->user()->can('jabatan.index')) {
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
  public function cetakdatakunjunganpasien(Request $request){
    //return $request->all();
    $search = $request->search;

    $records = Pasien::select('*');
    if ($search) {
        $records->where(function ($query) use ($search) {
            $query->orWhere('nama_pasien', 'LIKE', "%{$search}%");
            $query->orWhere('no_ktp', 'LIKE', "%{$search}%");
            $query->orWhere('no_bpjs', 'LIKE', "%{$search}%");
        });
    }
    $totalData = $records->get()->count();

    $totalFiltered = $records->get()->count();

    $data = $records->get();
    foreach ($data as $key => $record) {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id_jabatan));
        $action = "";

        $action .= "";
        // $record->no             = $key + $page;
        $record->ktpbpjs        ="KTP : ".$record->no_ktp."<br>BPJS : ".$record->no_bpjs;
    }
    $pasien = $data;
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
  }
  public function indexdatakunjunganpasien(){
      return view('laporan/laporankunjunganpasien');
  }

}
