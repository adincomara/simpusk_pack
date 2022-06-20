<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\JenisOperasi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class JenisOperasiController extends Controller
{
   protected $original_column = array(
    1 => "kode_jenis_operasi",
    2 => "nama_jenis_operasi",
  );


  public function index()
  {
    return view('master/data_jenisoperasi');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = JenisOperasi::select('*');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('kode_jenis_operasi','LIKE',"%{$search}%");
                $query->orWhere('nama_jenis_operasi','LIKE',"%{$search}%");
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

        if($request->user()->can('jenisoperasi.ubah')){
           $action.='<a href="'.route('jenisoperasi.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('jenisoperasi.hapus')){
           $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }






        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->id             = $record->id;
        $record->kode           = $record->kode_jenis_operasi;
        $record->nama           = $record->nama_jenis_operasi;

        $record->action         = $action;
      }
      if ($request->user()->can('jenisoperasi.index')) {
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

      return view('master_form/jenisoperasi_form');
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      if ($dec_id) {
        $jenisoperasi= JenisOperasi::find($dec_id);

        return view('master_form/jenisoperasi_form',compact('enc_id','jenisoperasi'));
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

        $jenisoperasi = JenisOperasi::find($dec_id);

        $jenisoperasi->kode_jenis_operasi      = $req->kode_jenis_operasi;
        $jenisoperasi->nama_jenis_operasi       = $req->nama_jenis_operasi;

        $jenisoperasi->save();
        if ($jenisoperasi) {
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

        $jenisoperasi = new JenisOperasi;


        $jenisoperasi->kode_jenis_operasi   = $req->kode_jenis_operasi;
        $jenisoperasi->nama_jenis_operasi   = $req->nama_jenis_operasi;

        $jenisoperasi->save();

        if($jenisoperasi) {
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
      $jenisoperasi = JenisOperasi::find($dec_id);

      if ($jenisoperasi) {
          $jenisoperasi->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }

}
