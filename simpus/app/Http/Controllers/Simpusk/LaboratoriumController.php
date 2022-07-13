<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Jabatan;
use App\Models\Simpusk\Kunjungan;
use Illuminate\Http\Request;
use App\Models\Simpusk\Pendaftaran;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Pegawai;
use App\Models\Simpusk\Pelayananpoli;
use App\Models\Simpusk\Pelayananpoliresep;
use App\Models\Simpusk\Pelayananpolidiagnosa;
use App\Models\Simpusk\Pelayananlaboratorium;
use App\Models\Simpusk\Pelayananpolilaboratorium;
use App\Models\Simpusk\Tindakan;
use App\Models\Simpusk\Obat;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class LaboratoriumController extends Controller
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
    return view('pelayanan/laboratorium');
  }
  public function master(){
    return view('master.data_laboratorium');
  }

  public function ubah($enc_id)
  {

    // return $enc_id;
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

    if ($dec_id) {
        $laboratorium  = Pelayananlaboratorium::find($dec_id);
        return view('master_form/laboratorium_form',compact('enc_id','laboratorium'));
    } else {
    return view('errors/noaccess');
    }
  }

  public function status_ubah(Request $req){
    //   return $req->value;
      $data = Pelayananlaboratorium::find($req->id);
      if($data->status == 1){
          $data->status = 0;
      }else{
          $data->status = 1;
      }
      if($data->save()){
         // return $data;
           return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'status pemeriksaan laboratorium berhasil dirubah',
        ]);
      }else{
         // return $data;
        return response()->json([
            'success' => false,
            'code' => 201,
            'message' => 'status pemeriksaan laboratorium gagal dirubah',
        ]);
      }
    }

  public function getDataMaster(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = Pelayananlaboratorium::select('*');
        $records->orderBy('status', 'DESC');

        //   if(array_key_exists($request->order[0]['column'], $this->original_column)){
        //      $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        //   }
        //   else{
        //     $records->orderBy('created_at','DESC');
        //   }
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
            $action = "";

            $action .= "";

            if($request->user()->can('laboratorium.ubah')){
                $action.='<a href="'.route('laboratorium.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if($request->user()->can('laboratorium.hapus')){
                $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }

            $record->no             = $key + $page;
            if($record->status == '1'){
                $record->status = "<label class='switch'>
                <input type='checkbox' value='".$record->id."' id='data_".$record->id."' checked>
                <span class='slider round'></span>
              </label>
              <script>
              $('#data_".$record->id."').click(function(){
                var id = this.value;
                var cek = $('#data_".$record->id."').prop('checked');
                console.log(cek);
                if(cek == true){
                    var val = 1;
                }
                else{
                    var val = 0;
                }
                console.log(val);

                  Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Status pemeriksaan laboratorium akan diubah!',

                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Ya',
                    cancelButtonText:'Batal',
                    confirmButtonColor: '#ec6c62',
                    closeOnConfirm: false
                  }).then(function(result){
                      if(result.value){
                        $.ajax({
                            type: 'POST',
                            url: '".route('laboratorium.status_ubah')."',
                            headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
                            data: {id : id, value: cek},
                            success: function(data){
                                if(data.success == true){
                                    Swal.fire('Yes',data.message,'success');
                                    table.ajax.reload(null, true);

                                }
                                else{
                                    Swal.fire('Peringatan',data.message,'info');
                                }
                            }
                        });
                      }else{
                        var check = $('#data_".$record->id."');
                        if(check.prop('checked') == false){
                            check.prop('checked', true);
                        }
                        else{
                            check.prop('checked', false);
                        }

                      }
                  });
              });
              </script>";
            }
            else{
                $record->status = "<label class='switch'>
                <input type='checkbox' value='".$record->id."' id='data_".$record->id."'>
                <span class='slider round'></span>
              </label>
              <script>
              $('#data_".$record->id."').click(function(){
                var id = this.value;
                var cek = $('#data_".$record->id."').prop('checked');
                console.log(cek);
                if(cek == true){
                    var val = 0;
                }
                else{
                    var val = 1;
                }
                console.log(val);
                  Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Status pemeriksaan laboratorium akan diubah!',

                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Ya',
                    cancelButtonText:'Batal',
                    confirmButtonColor: '#ec6c62',
                    closeOnConfirm: false
                  }).then(function(result){
                      if(result.value){
                        $.ajax({
                            type: 'POST',
                            url: '".route('laboratorium.status_ubah')."',
                            headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
                            data: {id : id, value: cek},
                            success: function(data){
                                if(data.success == true){
                                    Swal.fire('Yes',data.message,'success');
                                    table.ajax.reload(null, true);

                                }
                                else{
                                    Swal.fire('Peringatan',data.message,'info');
                                }
                            }
                        });
                      }else{
                        var check = $('#data_".$record->id."');
                        if(check.prop('checked') == false){
                            check.prop('checked', true);
                        }
                        else{
                            check.prop('checked', false);
                        }

                      }
                  });
              });
              </script>";
            }
            // $record->url            = '<a href="'.$this->url_laboratorium().'/'.$record->slug_url.'" target="_blank">'.$this->url_laboratorium().'/'.$record->slug_url.'</a>';
            $record->action         = $action;
        }
        if ($request->user()->can('laboratorium.index')) {
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

  public function getData(Request $request)
  {
    // return "tes";
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];
      $search_tgl = $request->search_tgl;

      $records = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pendaftaran.status_pasien', 'tbl_pendaftaran.tanggal_daftar',
        'tbl_poli.nama_poli','tbl_pelayanan_poli.id as id_pelayanan_poli','tbl_pelayanan_poli.flag_lab as flag_lab')->join('tbl_pelayanan_poli','tbl_pelayanan_poli.pendaftaran_id','tbl_pendaftaran.id')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.kdpoli','tbl_pendaftaran.id_poli')->where('tbl_pelayanan_poli.penunjang','Y')->whereDate('tbl_pendaftaran.tanggal_daftar', '=', date('Y-m-d', strtotime($search_tgl)));
    // return $records->get();
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
    //   return $data;
      foreach ($data as $key=> $record)
      {
        // return $record;
        $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
        $enc_id2 = $this->safe_encode(Crypt::encryptString($record->id_pelayanan_poli));
        $nilai = Pelayananpolilaboratorium::where('pelayanan_poli_id', $record->id_pelayanan_poli)->pluck('nilai');
        $nil = '';
        foreach($nilai as $idx => $n){
            $nil .= $n.',';
            if(count($nilai) == ($idx+1)){
                $nil .= $n;
            }
        }

        // $nil = json_encode($nilai, true);
        $params = 'pelayanan_poli_id='.$record->id_pelayanan_poli.'&nilai='.$nil;
        // return $params;
        $action = "";

        // if($request->user()->can('pelayanan_poli.hapus')){
        //   $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="ion ion-md-close"></i></a>&nbsp;';
        // }

        if($request->user()->can('laboratorium.periksa')){
            if($record->flag_lab == 0){
                $action.='<a href="'.route('laboratorium.periksa',$enc_id).'"  class="btn btn-primary" style="min-width:210px" title="Periksa Laboratorium">Periksa Laboratorium</a>&nbsp;';
            }else{
                $action.='<a href="'.route('laboratorium.cetak_lab',$params).'"  class="btn btn-success" style="min-width:210px" title="Lihat Hasil Laboratorium"><i class="fa fa-print"></i> Cetak Hasil Pemeriksaan</a>&nbsp;';
            }
        }

        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->no_rawat       = $record->no_rawat;
        $record->no_rekamedis   = $record->no_rekamedis;
        $record->nama_pasien    = $record->nama_pasien;
        $record->status_pasien  = $record->status_pasien;
        $record->nama_user      = $record->nama_user;
        $record->nama_poli      = $record->nama_poli;
        $record->action         = $action;
      }

      if ($request->user()->can('laboratorium.index')) {
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
      return view('master_form/laboratorium_form');
  }
  // ubah : Form ubah data
  public function periksa_laboratorium($enc_id)
  {
   // $PelayananLab = Pelayananlaboratorium::all();
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        //$poli= Pelayananpoli::find($dec_id);
        $poli = Pendaftaran::where('tbl_pendaftaran.id',$dec_id)->first();
        // return $poli->poli;
        // return $poli->pasien;

        // $poli = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.tanggal_lahir','tbl_pendaftaran.status_pasien','tbl_pegawai.nama_pegawai as nama_dokter','tbl_poli.nama_poli','tbl_pendaftaran.no_bpjs','users.name as nama_user','tbl_pelayanan_poli.penunjang as penunjang','tbl_pelayanan_poli.note as catatan_dokter','tbl_pelayanan_poli.id as id_pelayanan_poli')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_pelayanan_poli','tbl_pelayanan_poli.pendaftaran_id','tbl_pendaftaran.id')->join('tbl_pegawai','tbl_pegawai.id_pegawai','tbl_pelayanan_poli.dokter_id')->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')->join('users','tbl_pelayanan_poli.dokter_id','users.id')->where('tbl_pendaftaran.id',$dec_id)->first();
        // $PelayananLab = Pelayananpolilaboratorium::select('tbl_pelayanan_poli_laboratorium.nilai','tbl_pelayanan_laboratorium.name as nama_pemeriksaan','tbl_pelayanan_laboratorium.min as min','tbl_pelayanan_laboratorium.max as max','tbl_pelayanan_laboratorium.satuan as satuan','tbl_pelayanan_laboratorium.id as id_poli_lab')->join('tbl_pelayanan_laboratorium','tbl_pelayanan_laboratorium.id','tbl_pelayanan_poli_laboratorium.pelayanan_laboratorium_id')->where('tbl_pelayanan_poli_laboratorium.pelayanan_poli_id',$poli->id_pelayanan_poli)->get();
        $PelayananLab = Pelayananpolilaboratorium::where('pelayanan_poli_id', $poli->pelayanan_poli->id)->with(['pelayananlaboratorium'])->get();
        // return $poli->kunjungan;
        return view('pelayanan_form/laboratorium_form',compact('enc_id','poli','PelayananLab'));
      } else {
        return view('errors/noaccess');
      }
    }

  public function lihat_periksa_laboratorium($enc_id)
  {
    $Tindakans = Tindakan::all();
    $Obats = Obat::all();
    $PelayananLab = Pelayananlaboratorium::all();
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        //$poli= Pelayananpoli::find($dec_id);
        $poliLab = Pelayananpolilaboratorium::where('tbl_pelayanan_poli_laboratorium.pelayanan_poli_id',$dec_id)->with(['pelayananlaboratorium'])->get();
        // $poliLab = Pelayananpolilaboratorium::select('tbl_pelayanan_poli_laboratorium.nilai','tbl_pelayanan_laboratorium.name as nama_pemeriksaan','tbl_pelayanan_laboratorium.min as min','tbl_pelayanan_laboratorium.max as max','tbl_pelayanan_laboratorium.satuan as satuan')->join('tbl_pelayanan_laboratorium','tbl_pelayanan_laboratorium.id','tbl_pelayanan_poli_laboratorium.pelayanan_laboratorium_id')->where('tbl_pelayanan_poli_laboratorium.pelayanan_poli_id',$dec_id)->get();
        // return $poliLab;
        $pasien = Pendaftaran::whereHas('pelayanan_poli', function ($query) use ($dec_id) {
            return $query->where('id', '=', $dec_id);
        })->first();
        // return $pasien;
        $kunjungan = Kunjungan::where('id_pendaftaran',$pasien->id)->with(['diagnosa1', 'diagnosa2', 'diagnosa3'])->first();
        // return $kunjungan;
        // return $pasien->pelayanan_poli;
        // $pasien = Pendaftaran::select('tbl_pendaftaran.id','tbl_pendaftaran.no_rawat','tbl_pendaftaran.no_rekamedis','tbl_pasien.nama_pasien','tbl_pasien.jenis_kelamin','tbl_pasien.alamat','tbl_pasien.no_bpjs','tbl_pendaftaran.status_pasien',
        // 'tbl_poli.nama_poli','users.name as nama_user','tbl_pelayanan_poli.id as id_pelayanan_poli')->join('tbl_pelayanan_poli','tbl_pelayanan_poli.pendaftaran_id','tbl_pendaftaran.id')->join('users','tbl_pelayanan_poli.dokter_id','users.id')->join('tbl_pasien','tbl_pasien.no_rekamedis','tbl_pendaftaran.no_rekamedis')->join('tbl_poli','tbl_poli.id','tbl_pendaftaran.id_poli')->where('tbl_pelayanan_poli.id',$dec_id)->first();
        return view('pelayanan_form/laboratorium_lihatperiksa',compact('enc_id','poliLab','PelayananLab','pasien','Tindakans','Obats', 'kunjungan'));
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
    public function simpanMaster(Request $req){
        $enc_id = $req->enc;
        if(isset($enc_id)){
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
            $laboratorium = Pelayananlaboratorium::find($dec_id);
            $laboratorium->name     = $req->nama_pemeriksaan;
            $laboratorium->min      = $req->min;
            $laboratorium->max      = $req->max;
            $laboratorium->satuan   = $req->satuan;
            $laboratorium->status   = $req->status;
        }else{
            $laboratorium = new Pelayananlaboratorium();
            $laboratorium->name     = $req->nama_pemeriksaan;
            $laboratorium->min      = $req->min;
            $laboratorium->max      = $req->max;
            $laboratorium->satuan   = $req->satuan;
            $laboratorium->status   = $req->status;
        }

        if($laboratorium->save()){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'code'    => 201,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan',
                'code'    => 204,
            ]);
        }
    }
    public function simpan(Request $req)
    {
        // return $req->all();
        $PelayananLab = Pelayananpolilaboratorium::select('tbl_pelayanan_poli_laboratorium.nilai','tbl_pelayanan_poli_laboratorium.id as id_pelayanan_poli_lab','tbl_pelayanan_laboratorium.name as nama_pemeriksaan','tbl_pelayanan_laboratorium.min as min','tbl_pelayanan_laboratorium.max as max','tbl_pelayanan_laboratorium.satuan as satuan','tbl_pelayanan_laboratorium.id as id_poli_lab')->join('tbl_pelayanan_laboratorium','tbl_pelayanan_laboratorium.id','tbl_pelayanan_poli_laboratorium.pelayanan_laboratorium_id')->where('tbl_pelayanan_poli_laboratorium.pelayanan_poli_id',$req->pelayanan_poli_id)->get();
        $pelayanan_poli_id = $req->pelayanan_poli_id;

        foreach($PelayananLab as $lab){
            $Pelayananpolilaboratorium = Pelayananpolilaboratorium::find($lab->id_pelayanan_poli_lab);
            $Pelayananpolilaboratorium->pelayanan_poli_id         = $pelayanan_poli_id;
            $Pelayananpolilaboratorium->nilai                     = $req->input('nilai_'.$lab->id_poli_lab);
            $Pelayananpolilaboratorium->pelayanan_laboratorium_id = $lab->id_poli_lab;
                $Pelayananpolilaboratorium->save();
        }

        if(!empty($Pelayananpolilaboratorium)) {
          $pelayananpoli = Pelayananpoli::find($req->pelayanan_poli_id);
          $pelayananpoli->flag_lab                      = 2;
          $pendaftaran = Pendaftaran::where('id', $pelayananpoli->pendaftaran_id)->first();
          $pendaftaran->flag_periksa = 3;
          $pendaftaran->save();
          $pelayananpoli->save();
          if($pelayananpoli){
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

    }
    }
    public function hapus(Request $req,$enc_id)
    {
      $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      $laboratorium = Pelayananlaboratorium::find($dec_id);

      if ($laboratorium) {
          $laboratorium->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }

    public function addDiagnosis(Request $req){
      $total = $req->total;
      $Tindakans = Tindakan::all();

      echo"
          <div class='form-row' id='dataAjaxDiagnosis_".$total."'>
            <div class='form-group col-md-6'>
              <label class='form-label'>Diagnosis</label>
              <input type='text' class='form-control mb-1' name='nama_diagnosi_".$total."' id='nama_diagnosi_".$total."'>
            </div>
            <div class='form-group col-md-5'>
              <label class='form-label'>Tindakan</label>
              <select id='tindakan_".$total."' name='tindakan_".$total."' class='select2 form-control mb-1'>
                  <option value='0' selected disabled>Pilih Tindakan</option>
                ";
                foreach($Tindakans as $tindakan){
                  echo"
                      <option value=".$tindakan->id.">".$tindakan->kode_tindakan." - ".$tindakan->nama_tindakan."</option>";
                      }echo"
              </select>
            </div>
            <div class='form-group col-md-1'>
              <a href='#!' onclick='javascript:deleteDiagnosi(".$total.")' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus' style='margin-top: 30%;'><i class='fa fa-close'></i></a>
            </div>
          </div>

        <script>
            $(function () {
                $('.select2').select2()
            })
        </script>

        <script>
          function deleteDiagnosi(id){
            $('#dataAjaxDiagnosis_'+id).remove();
          }
          </script>


      ";

    }

      public function addObat(Request $req){
      $total = $req->total;
      $Obats = Obat::all();

      echo"
          <div class='form-row' id='dataAjaxObat_".$total."'>
            <div class='form-group col-md-3'>
              <label class='form-label'>Obat / Resep</label>
              <select id='obat_".$total."' name='obat_".$total."' class='select2 form-control mb-1'>
                  <option value='0' selected disabled>Pilih Obat</option> ";
                foreach($Obats as $obat){
                  echo"
                      <option value=".$obat->id.">".$obat->kode_obat." - ".$obat->nama_obat."</option>";
                      }echo"
              </select>
            </div>
            <div class='form-group col-md-2'>
              <label class='form-label'>Jumlah</label>
              <input type='number' min='1' class='form-control mb-1' name='jumlah_obat_".$total."' id='jumlah_obat_".$total."'>
            </div>
            <div class='form-group col-md-3'>
              <label class='form-label'>Cara Pakai</label>
              <input type='text' class='form-control mb-1' name='cara_pakai_obat_".$total."' id='cara_pakai_obat_".$total."'>
            </div>
            <div class='form-group col-md-3'>
              <label class='form-label'>Aturan Pakai</label>
              <input type='text' class='form-control mb-1' name='aturan_pakai_obat_".$total."' id='aturan_pakai_obat_".$total."' value='3x1, Setelah Makan'>
            </div>
            <div class='form-group col-md-1'>
            <a href='#!' onclick='javascript:deleteObat(".$total.")' class='btn btn-danger btn-lg icon-btn lg-btn-flat product-tooltip' title='Hapus' style='margin-top: 30%;'><i class='fa fa-close'></i></a>
            </div>
          </div>

        <script>
            $(function () {
                $('.select2').select2()
            })
        </script>

        <script>
          function deleteObat(id){
            $('#dataAjaxObat_'+id).remove();
          }
          </script>


      ";

    }

    public function simpanPelayananPoli(Request $req){
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
        if($Pelayananpoli){
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
        $total_d = $req->total_diagnosis;

        for($i=1;$i<=$total_d;$i++){
            if($req->input('nama_diagnosi_'.$i) != ""){
            $ppolidiagnosa = new Pelayananpolidiagnosa;

            $ppolidiagnosa->pelayanan_poli_id      = $Pelayananpoli->id;
            $ppolidiagnosa->tindakan_id            = $req->input('tindakan_'.$i);
            $ppolidiagnosa->diagnosa               = $req->input('nama_diagnosi_'.$i);
            $ppolidiagnosa->save();
          }
        }
        if($ppolidiagnosa){
            $total_o = $req->total_obat;

            for($ii=1;$ii<=$total_o;$ii++){
                if($req->input('obat_'.$ii) != "" || $req->input('obat_'.$ii) != "0"){
                $ppoliobat = new Pelayananpoliresep;

                $ppoliobat->pelayanan_poli_id      = $Pelayananpoli->id;
                $ppoliobat->obat_id                = $req->input('obat_'.$ii);
                $ppoliobat->jumlah                 = $req->input('jumlah_obat_'.$ii);
                $ppoliobat->cara_pakai             = $req->input('cara_pakai_obat_'.$ii);
                $ppoliobat->aturan_pakai           = $req->input('aturan_pakai_obat_'.$ii);
                $ppoliobat->save();
              }
            }
              if($ppoliobat) {
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
    }
      return json_encode($json_data);
    }
  }

  public function simpanResepLab(Request $req){
    //   return $req->all();
      $pelayanan_poli_id        = $req->pelayanan_poli_id;

    //     $total_d = $req->total_diagnosis;

    //     for($i=1;$i<=$total_d;$i++){
    //         if($req->input('nama_diagnosi_'.$i) != ""){
    //         $ppolidiagnosa = new Pelayananpolidiagnosa;

    //         $ppolidiagnosa->pelayanan_poli_id      = $pelayanan_poli_id;
    //         $ppolidiagnosa->tindakan_id            = $req->input('tindakan_'.$i);
    //         $ppolidiagnosa->diagnosa               = $req->input('nama_diagnosi_'.$i);
    //         $ppolidiagnosa->save();
    //       }
    //     }
    //     if($ppolidiagnosa){

    //   }

    $total_o = $req->total_obat;
    if($total_o > 1){
        for($ii=1;$ii<=$total_o;$ii++){
            $inputobt = $req->input('obat_'.$ii);
            if(isset($inputobt)){
                if($req->input('obat_'.$ii) != "" || $req->input('obat_'.$ii) != "0"){
                    $ppoliobat = new Pelayananpoliresep;

                    $ppoliobat->pelayanan_poli_id      = $pelayanan_poli_id;
                    $ppoliobat->obat_id                = $req->input('obat_'.$ii);
                    $ppoliobat->jumlah                 = $req->input('jumlah_obat_'.$ii);
                    $ppoliobat->cara_pakai             = $req->input('cara_pakai_obat_'.$ii);
                    $ppoliobat->aturan_pakai           = $req->input('aturan_pakai_obat_'.$ii);
                    if($ppoliobat->save()){
                        continue;
                    }else{
                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal menyimpan resep Obat'
                        ]);
                    }

            }

          }
        }
          if($ppoliobat) {
                $pelayananpoli = Pelayananpoli::find($pelayanan_poli_id);
                $pelayananpoli->flag_lab = 2;
                if($pelayananpoli->save()){
                    return response()->json([
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    ]);

                }else{
                    return response()->json([
                        "success"         => FALSE,
                        "message"         => 'Data gagal ditambahkan.'
                    ]);
                }
            }
    }else{
        $pelayananpoli = Pelayananpoli::find($pelayanan_poli_id);
        $pelayananpoli->flag_lab = 2;
        $pelayananpoli->save();
        if($pelayananpoli){
            $pendaftaran = Pendaftaran::find($pelayananpoli->pendaftaran_id);
            $pendaftaran->flag_periksa = 1;
            if($pendaftaran->save()){
                return response()->json([
                    "success"         => TRUE,
                    "message"         => 'Data berhasil ditambahkan.'
                ]);
            }else{
                return response()->json([
                    "success"         => FALSE,
                    "message"         => 'Data gagal merubah flag pendaftaran.'
                ]);
            }

        }else{
            return response()->json([
                "success"         => FALSE,
                "message"         => 'Data gagal ditambahkan.'
            ]);
        }
    }



  }
  public function cetak_lab($req){
    // return $req;
    parse_str($req, $array);
    $nilai = explode(',', $array['nilai']);
    // return $nilai[0];
      $record = Pelayananpoli::where('id', $array['pelayanan_poli_id'])->with('pendaftaran', 'pendaftaran.pasien')->first();
      $data['pelayanan_poli'] = $record;
      $data['pendaftaran'] = $record->pendaftaran;
      $data['pasien'] = $record->pendaftaran->pasien;
      $data['pelayanan_poli_lab'] = Pelayananpolilaboratorium::where('pelayanan_poli_id', $record->id)->with('pelayananlaboratorium')->get();
      foreach($data['pelayanan_poli_lab'] as $key => $lab){
        if($lab['pelayananlaboratorium']['min'] > $nilai[$key] || $lab['pelayananlaboratorium']['max'] < $nilai[$key]){
            $nilai[$key] = '<p style="color:red"> '.$nilai[$key].' </p>';
        }
      }
    return view('pelayanan/cetak_laboratorium', ['data' => $data, 'nilai' => $nilai]);
  }
}
