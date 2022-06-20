<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Penyakit;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class PenyakitController extends Controller
{
   protected $original_column = array(
    1 => "kode_penyakit",
    2 => "nama_penyakit",
  );

  public function index()
  {

    return view('master/data_penyakit');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = Penyakit::select('*');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('kode_penyakit','LIKE',"%{$search}%");
                $query->orWhere('nama_penyakit','LIKE',"%{$search}%");
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

        if($request->user()->can('penyakit.ubah')){
            $action.='<a href="'.route('penyakit.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('penyakit.hapus')){
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }







        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->kode_penyakit  = $record->kode_penyakit;
        $record->nama_penyakit  = $record->nama_penyakit;
        $record->action         = $action;
      }

      if ($request->user()->can('penyakit.index')) {
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

    public function generateNoNota_()
    {
      $next_no = '';
      $max_order = Penyakit::max('id');
      if ($max_order) {
          $data = Penyakit::find($max_order);
          $ambil = substr($data->no_rekamedis, -6);
      }
      if ($max_order==null) {
        $next_no = '000001';
      }elseif (strlen($ambil)<6) {
        $next_no = '000001';
      }elseif ($ambil == '999999') {
        $next_no = '000001';
      }else {
        $next_no = substr('000000', 0, 6-strlen($ambil+1)).($ambil+1);
      }
      return $next_no;
    }

    public function generateNoNota()
    {
      $max_order = Penyakit::max('kode_penyakit');
      return $max_order + 1;
    }

  public function tambah()
  {
      $no_rekam = $this->generateNoNota();
      return view('master_form/penyakit_form', compact('no_rekam'));
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $penyakit= Penyakit::find($dec_id);

        return view('master_form/penyakit_form',compact('enc_id','penyakit'));
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

        $penyakit = Penyakit::find($dec_id);

        $penyakit->kode_penyakit   = $req->kode_penyakit;
        $penyakit->nama_penyakit   = $req->nama_penyakit;
        $penyakit->save();
        if ($penyakit) {
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

        $penyakit = new penyakit;

        $penyakit->kode_penyakit   = $req->kode_penyakit;
        $penyakit->nama_penyakit   = $req->nama_penyakit;
        $penyakit->save();

        if($penyakit) {
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
      $penyakit = Penyakit::find($dec_id);

      if ($penyakit) {
          $penyakit->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }
}
