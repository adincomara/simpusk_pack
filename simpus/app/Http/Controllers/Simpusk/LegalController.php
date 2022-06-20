<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Legal;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class LegalController extends Controller
{
   protected $original_column = array(
    1 => "title",
    2 => "legalkat_id",
    3 => "status"
  );
  public function status()
  {

    $value = array('1'=>'Aktif' ,'0'=>'Tidak Aktif' );
    return $value;
  }
  public function kategori()
  {
	  $value = array('1'=>'Kebijakan Privasi' ,'2'=>'Syarat dan Ketentuan','3'=>'Bantuan');
	  return $value;
  }
  public function index()
  {
    return view('backend/legal/index');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = Legal::select('*');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }
      else{
        $records->orderBy('id','ASC');
      }
       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('title','LIKE',"%{$search}%");
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
       	if($request->user()->can('legal.detail')){
           $action.='<a href="#" onclick="detailData(this,'.$key.')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" title="Detail"><i class="ion ion-md-eye"></i></a>&nbsp;';
        }
        if($request->user()->can('legal.ubah')){
          $action.='<a href="'.route('legal.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="ion ion-md-create"></i></a>&nbsp;';
        }

        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->id             = $record->id;
        $record->title          = $record->title;
        $record->content        = $record->content;
       	$record->kategori       = $this->kategori(0)[$record->legalkat_id];
       	$record->status         = $record->status=='1' ? '<span class="badge badge-outline-success">Aktif</span>' : '<span class="badge badge-outline-danger">Tidak Aktif</span>' ;
       	$record->tgl            = date('d-m-Y',strtotime($record->created_at));
        $record->action         = $action;
      }
      if ($request->user()->can('legal.index')) {
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
      $kategori = $this->kategori();
      $selectedkategori = "1";
      $status = $this->status();
      $selectedstatus = "1";
      return view('backend/legal/form',compact('kategori','selectedkategori','status','selectedstatus'));
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      if ($dec_id) {
        $legal= Legal::find($dec_id);
        $kategori = $this->kategori();
        $selectedkategori = $legal->legalkat_id;
        $status = $this->status();
        $selectedstatus = $legal->status;
        return view('backend/legal/form',compact('enc_id','legal','kategori','selectedkategori','status','selectedstatus'));
      } else {
        return view('errors/noaccess');
      }
    }

    private function cekExist($column,$var,$id)
    {
       $cek = Legal::where('id','!=',$id)->where($column,'=',$var)->first();
       return (!empty($cek) ? false : true);
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
         $cek_kat = $this->cekExist('legalkat_id',$req->kategori,$dec_id);
         if(!$cek_kat)
         {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data gagal diubah dikarenakan kategori sudah ada di database.'
            );
         }else{
         	$legal = Legal::find($dec_id);
	        $legal->title      = $req->title;
	        $legal->content    = $req->content;
	        $legal->legalkat_id= $req->kategori;
	        $legal->status     = $req->status;
	        $legal->updated_by = Auth()->user()->name;
	        $legal->save();
	        if ($legal) {
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
         }
      }else{

      	//cek kategori sudah ada?
      	$cek = Legal::where('legalkat_id',$req->kategori)->first();
      	if ($cek) {
      	    $json_data = array(
                "success"         => FALSE,
                "message"         => 'Data gagal ditambahkan dikarenakan kategori sudah ada di database.'
            );
      	}else{
      		$legal = new Legal;
	        $legal->title      = $req->title;
	        $legal->content    = $req->content;
	        $legal->legalkat_id= $req->kategori;
	        $legal->status     = $req->status;
	        $legal->created_by = Auth()->user()->name;
	        $legal->save();

	        if($legal) {
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
