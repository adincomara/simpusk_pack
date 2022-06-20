<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Kk;
use App\Models\Simpusk\Kkdetail;
use App\Models\Simpusk\Kabupaten;
use App\Models\Simpusk\Kecamatan;
use App\Models\Simpusk\Kelurahan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class KkController extends Controller
{
   protected $original_column = array(
    1 => "no_kk",
    2 => "nama_kepala_keluarga",
    3 => "alamat",
    4 => "rt",
    5 => "rw",
    6 => "kel_id",
    7 => "kec_id",
    8 => "kabkot_id",
    9 => "prov_id",
  );

  public function index()
  {

    return view('master/data_kartukeluarga');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      //$records = Kk::select('*');
      $records = Kk::select('kk.*','tbl_kelurahan.name as nama_kelurahan','tbl_kecamatan.name as nama_kecamatan','tbl_kabkot.name as nama_kabkot')->join('tbl_kelurahan', 'tbl_kelurahan.id', '=', 'kk.kel_id')->join('tbl_kecamatan', 'tbl_kecamatan.id', '=', 'kk.kec_id')->join('tbl_kabkot', 'tbl_kabkot.id', '=', 'kk.kabkot_id');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('no_kk','LIKE',"%{$search}%");
                $query->orWhere('nama_kepala_keluarga','LIKE',"%{$search}%");
                $query->orWhere('alamat','LIKE',"%{$search}%");
                $query->orWhere('kodepos','LIKE',"%{$search}%");
                $query->orWhere('nama_kelurahan','LIKE',"%{$search}%");
                $query->orWhere('nama_kecamatan','LIKE',"%{$search}%");
                $query->orWhere('nama_kabkot','LIKE',"%{$search}%");
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
        //   $action.='<a href="#" onclick="detail_data('.$record->id.')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="ion-ios-document"></i></a>&nbsp;';
        $action.='<a href="#" onclick="detail_data('.$record->id.')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Detail"><i class="fa fa-sticky-note"></i> Detail</a>&nbsp;';
        if($request->user()->can('kk.ubah')){
            $action.='<a href="'.route('kk.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('kk.hapus')){
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }


        $record->no                     = $key+$page;
        $record->DT_RowId               = $record->id;
        $record->no_kk                  = $record->no_kk;
        $record->nama_kepala_keluarga   = $record->nama_kepala_keluarga;
        $record->alamat                 = $record->alamat;
        $record->kodepos                = $record->kodepos;
        $record->nama_kelurahan         = $record->nama_kelurahan;
        $record->nama_kecamatan         = $record->nama_kecamatan;
        $record->nama_kabkot            = $record->nama_kabkot;
        $record->rt                     = $record->rt;
        $record->rw                     = $record->rw;
        $record->rt_rw                  = "RT ".$record->rt." RW ".$record->rw;
        $record->alamat_lengkap         = $record->alamat." ".$record->rt_rw;
        $record->nama_provinsi          = "JAWA TENGAH";
        $record->action                 = $action;
      }

      if ($request->user()->can('kk.index')) {
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
      $getKabupaten = Kabupaten::all();
      return view('master_form/kartukeluarga_form')->with('getKabupaten',$getKabupaten);
  }

  public function pilihKabkot(Request $req){
  $idKabkot = $req->cmbKabkot;

  $getKecamatan = Kecamatan::where('kabkot_id',$idKabkot)->get();
  return response()->json($getKecamatan,200);
}

public function pilihKec(Request $req){
  $idKec = $req->cmbKec;

  $getKelurahan = Kelurahan::where('kecamatan_id',$idKec)->get();
  return response()->json($getKelurahan,200);
}
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $getKabupaten = Kabupaten::all();
    $getKecamatan = Kecamatan::all();
    $getKelurahan = Kelurahan::all();
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
    $getDataDetail = Kkdetail::where('kk_id',$dec_id)->get();

      if ($dec_id) {
        $kk= Kk::find($dec_id);

        return view('master_form/kartukeluarga_form',compact('enc_id','kk','getKabupaten','getKecamatan','getKelurahan','getDataDetail'));
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

        $kk = Kk::find($dec_id);

        $kk->no_kk                  = $req->input('no_kk');
        $kk->nama_kepala_keluarga   = $req->nama_kepala_keluarga;
        $kk->alamat                 = $req->alamat;
        $kk->kodepos                = $req->kodepos;
        $kk->kel_id                 = $req->cmbKel;
        $kk->kec_id                 = $req->cmbKec;
        $kk->kabkot_id              = $req->cmbKabkot;
        $kk->rt                     = $req->rt;
        $kk->rw                     = $req->rw;
        $kk->kode_pos               = $req->kode_pos;
        $kk->prov_id                = 33;
        $kk->save();

        if ($kk) {
          $total = $req->total;
        // $data = Kkdetail::all();
        // foreach($data as $d){
        //     if(empty($d->nama_lengkap) && empty($d->nik)){
        //         $d->delete();
        //     }
        // }
        //return $req->all();
          for($i=0;$i<=$total;$i++){

              $kkdetail = Kkdetail::where('kk_id',$dec_id)->where('nama_lengkap',$req->input('nama_kk_'.$i))->where('nik',$req->input('nik_'.$i))->first();

            //   if($i==1){
            //       //return $req->input('nik_'.$i);
            //       return $kkdetail;

            //   }
              if(isset($kkdetail)){
                // if($i == 1){
                //     return $req->input('jenis_pekerjaan_'.$i);
                // }
                $kkdetail->kk_id                  = $dec_id;
                $kkdetail->nama_lengkap           = $req->input('nama_kk_'.$i);
                $kkdetail->nik                    = $req->input('nik_'.$i);
                $kkdetail->jenis_kelamin          = $req->input('jk_'.$i);
                $kkdetail->tanggal_lahir          = $req->input('tanggal_lahir_'.$i);
                $kkdetail->agama                  = $req->input('agama_'.$i);
                $kkdetail->pendidikan             = $req->input('pendidikan_'.$i);
                $kkdetail->jenis_pekerjaan        = $req->input('jenis_pekerjaan_'.$i);
                $kkdetail->golongan_darah         = $req->input('golongan_darah_'.$i);
                $kkdetail->status_hubungan        = $req->input('status_hubungan_'.$i);
                $kkdetail->save();
                //dd($req->input('nama_kk_'.$i));

              }
              else{

                $cek1 = $req->input('nama_kk_'.$i);
                //return $cek1;
                $cek2 = $req->input('nik_'.$i);
                if(!empty($cek1) || !empty($cek2)){

                    $kkdetail = new Kkdetail;

                    $kkdetail->kk_id                  = $dec_id;
                    $kkdetail->nama_lengkap           = $req->input('nama_kk_'.$i);
                    $kkdetail->nik                    = $req->input('nik_'.$i);
                    $kkdetail->jenis_kelamin          = $req->input('jk_'.$i);
                    $kkdetail->tanggal_lahir          = $req->input('tanggal_lahir_'.$i);
                    $kkdetail->agama                  = $req->input('agama_'.$i);
                    $kkdetail->pendidikan             = $req->input('pendidikan_'.$i);
                    $kkdetail->jenis_pekerjaan        = $req->input('jenis_pekerjaan_'.$i);
                    $kkdetail->golongan_darah         = $req->input('golongan_darah_'.$i);
                    $kkdetail->status_hubungan        = $req->input('status_hubungan_'.$i);
                    //dd($req->input('nama_kk_'.$i));
                    $kkdetail->save();
                }
              }
              if(!empty($kkdetail->id)){
                $kkid[] = json_encode($kkdetail->id);
              }

            }
            //return $kkid;
            Kkdetail::where('kk_id', $dec_id)->wherenotIn('id',$kkid)->delete();
            // return $filterdata;
            $json_data = array(
                "success"         => TRUE,
                "message"         => 'Data berhasil diperbarui.'
                );

            return $json_data;
            // $data = Kkdetail::all();
            // foreach($data as $d){
            //     if(empty($d->nama_lengkap) && empty($d->nik)){
            //         $d->delete();
            //     }
            // }
          }


        }
      else{
        $kk = new Kk;
        //dd($req->v_status);

        $kk->no_kk                  = $req->input('no_kk');
        $kk->nama_kepala_keluarga   = $req->nama_kepala_keluarga;
        $kk->alamat                 = $req->alamat;
        $kk->kodepos                = $req->kodepos;
        $kk->kel_id                 = $req->cmbKel;
        $kk->kec_id                 = $req->cmbKec;
        $kk->kabkot_id              = $req->cmbKabkot;
        $kk->rt                     = $req->rt;
        $kk->rw                     = $req->rw;
        $kk->kode_pos               = $req->kode_pos;
        $kk->prov_id                = 33;
        //dd($req->input('no_kk'));
        $kk->save();
        if($kk){

        $total = $req->total;
        for($i=1;$i<=$total;$i++){
            if($req->input('nama_kk_'.$i) != "" || $req->input('nik_'.$i) != ""){
            $kkdetail = new Kkdetail;

            $kkdetail->kk_id                  = $kk->id;
            $kkdetail->nama_lengkap           = $req->input('nama_kk_'.$i);
            $kkdetail->nik                    = $req->input('nik_'.$i);
            $kkdetail->jenis_kelamin          = $req->input('jk_'.$i);
            $kkdetail->tanggal_lahir          = $req->input('tanggal_lahir_'.$i);
            $kkdetail->agama                  = $req->input('agama_'.$i);
            $kkdetail->pendidikan             = $req->input('pendidikan_'.$i);
            $kkdetail->jenis_pekerjaan        = $req->input('jenis_pekerjaan_'.$i);
            $kkdetail->golongan_darah         = $req->input('golongan_darah_'.$i);
            $kkdetail->status_hubungan        = $req->input('status_hubungan_'.$i);
            //dd($req->input('nama_kk_'.$i));
            $kkdetail->save();
          }
        }
      }

        if($kkdetail) {
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
      $kk = Kk::find($dec_id);

      if ($kk) {
          $kk->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }

    public function addAnggota(Request $req){
      $totals = $req->totals;

      echo"
      <div class='form-row data_".$totals."'>
              <div class='form-group col-md-2'>
                <label class='form-label'>NIK<span>*</span></label>
                <input type='text' class='form-control' id='nik_".$totals."' minlength='16' onkeypress='return onlyNumberKey(event)'  name='nik_".$totals."' required>
              </div>
              <div class='form-group col-md-2'>
                <label class='form-label'>Nama Lengkap<span>*</span></label>
                <input type='text' class='form-control' id='nama_kk_".$totals."'  name='nama_kk_".$totals."' required>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>JK <span>*</span></label>
                <select class='form-control' id='jk_".$totals."'  name='jk_".$totals."'>
                  <option value='' selected disabled=''>Pilih Jenis Kelamin</option>
                  <option value='L'>Laki-laki</option>
                  <option value='P'>Perempuan</option>
                </select>
              </div>
              <div class='form-group col-md-2'>
                <label class='form-label'>Tanggal Lahir <span>*</span></label>
                <input type='date' class='form-control' id='tanggal_lahir_".$totals."'  name='tanggal_lahir_".$totals."'>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>Agama <span>*</span></label>
                <select class='form-control' id='agama_".$totals."'  name='agama_".$totals."'>
                  <option value='' selected disabled=''>Pilih Agama</option>
                  <option value='Islam'>Islam</option>
                  <option value='Kristen'>Kristen</option>
                  <option value='Katholik'>Katholik</option>
                  <option value='Hindu'>Hindu</option>
                  <option value='Budha'>Budha</option>
                  <option value='Konghucu'>Konghucu</option>
                </select>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>Pndkn <span>*</span></label>
                <select class='form-control' id='pendidikan_".$totals."'  name='pendidikan_".$totals."'>
                  <option value='' selected disabled=''>Pilih Pendidikan</option>
                  <option value='TK'>TK</option>
                  <option value='SD_MI'>SD/MI</option>
                  <option value='SMP_MTS'>SMP/MTS</option>
                  <option value='SMA_SMK'>SMA/SMK</option>
                  <option value='S1'>S1</option>
                  <option value='S2'>S2</option>
                  <option value='S3'>S3</option>
                </select>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>Pkrjn <span>*</span></label>
                <input type='text' class='form-control' id='jenis_pekerjaan_".$totals."'  name='jenis_pekerjaan_".$totals."'>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>GolDarah <span>*</span></label>
                <select class='form-control' id='golongan_darah_".$totals."'  name='golongan_darah_".$totals."'>
                  <option value='' selected disabled=''>Pilih Golongan Darah</option>
                  <option value='-'>-</option>
                  <option value='A'>A</option>
                  <option value='B'>B</option>
                  <option value='AB'>AB</option>
                  <option value='O'>O</option>
                </select>
              </div>
              <div class='form-group col-md-1'>
                <label class='form-label'>Hbngn <span>*</span></label>
                <input type='text' class='form-control' id='status_hubungan_".$totals."'  name='status_hubungan_".$totals."'>
              </div>
              <div class='form-group col-md-1'>

                <button type='button' class='btn btn-danger' onclick='removeAnggota(\"".$totals."\")'><i class='fa fa-close'></i></button>
              </div>
            </div>
      ";
    }

    public function detail_data(Request $req){
      $id_kk = $req->id;
      $getDatas = Kkdetail::where('kk_id',$id_kk)->get();
      echo"
        <thead>
          <tr>
            <th class='text-center no-sort'>No</th>
            <th class='text-left no-sort'>NIK</th>
            <th class='text-left no-sort'>Nama lengkap</th>
            <th class='text-left no-sort'>Tanggal Lahir</th>
            <th class='text-left no-sort'>Jenis Kelamin</th>
            <th class='text-left no-sort'>Agama</th>
            <th class='text-left no-sort'>Pendidikan</th>
            <th class='text-left no-sort'>Jenis Pekerjaan</th>
            <th class='text-left no-sort'>Golongan Darah</th>
            <th class='text-left no-sort'>Status Hubungan</th>
            <!-- <th class='text-left no-sort'></th> -->
          </tr>
        </thead>
        <tbody>
        ";
        $no = 0;
        foreach($getDatas as $data){
          $no++;
          echo"
          <tr>
            <td>".$no."</td>
            <td>".$data->nik."</td>
            <td>".$data->nama_lengkap."</td>
            <td>".$data->tanggal_lahir."</td>
            <td>".$data->jenis_kelamin."</td>
            <td>".$data->agama."</td>
            <td>".$data->pendidikan."</td>
            <td>".$data->jenis_pekerjaan."</td>
            <td>".$data->golongan_darah."</td>
            <td>".$data->status_hubungan."</td>
            <!-- <td><a href=".route('kk.ubah',$data->id)." class='btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip' title='Edit'><i class='ion ion-md-create'></i></a><a href='#' onclick='deleteData(this,\"".$data->id."\")' class='btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip' title='Hapus'><i class='ion ion-md-close'></i></a></td> -->
          ";
          }echo"
        </tbody>
      ";
    }

    public function ubahKkDetail(Request $req){

    }
}
