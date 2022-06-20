<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Supplier;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;
use Excel;
use App\Exports\SupplierExport;
class SupplierController extends Controller
{
   protected $original_column = array(
    1 => "kode_supplier",
    2 => "nama_supplier",
    3 => "alamat",
    4 => "no_telpon",
  );


  public function index()
  {
    return view('apotik/data_supplier');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = Supplier::select('*');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }

       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('kode_supplier','LIKE',"%{$search}%");
                $query->orWhere('nama_supplier','LIKE',"%{$search}%");
                $query->orWhere('alamat','LIKE',"%{$search}%");
                $query->orWhere('no_telpon','LIKE',"%{$search}%");
        });
      }
      $totalData = $records->get()->count();

      $totalFiltered = $records->get()->count();

      $records->limit($limit);
      $records->offset($start);
      $data = $records->get();
      foreach ($data as $key=> $record)
      {
        $enc_id = $this->safe_encode(Crypt::encryptString($record->kode_supplier));
        $action = "";

        if($request->user()->can('supplier.ubah')){
          $action.='<a href="'.route('supplier.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('supplier.hapus')){
          $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }




        $record->no             = $key+$page;
        $record->kode_supplier  = $record->kode_supplier;
        $record->nama_supplier  = $record->nama_supplier;
        $record->alamat         = $record->alamat;
        $record->no_telpon      = $record->no_telpon;

        $record->action         = $action;
      }
      if ($request->user()->can('supplier.index')) {
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

      return view('apotik_form/supplier_form');
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      if ($dec_id) {
        $supplier= Supplier::find($dec_id);
        return view('apotik_form/supplier_form',compact('enc_id','supplier'));
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

        $supplier = Supplier::find($dec_id);
        $supplier->kode_supplier  = $req->kode_supplier;
        $supplier->nama_supplier  = $req->nama_supplier;
        $supplier->alamat         = $req->alamat;
        $supplier->no_telpon      = $req->no_telpon;
        $supplier->save();

        if ($supplier) {
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

        $supplier = new Supplier;

        $supplier->kode_supplier  = $req->kode_supplier;
        $supplier->nama_supplier  = $req->nama_supplier;
        $supplier->alamat         = $req->alamat;
        $supplier->no_telpon      = $req->no_telpon;
        $supplier->save();

        if($supplier) {
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

    public function cetak(Request $request)
    {
       $supplier = Supplier::all();
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
        'title'                 => 'DATA SUPPLIER',
        'author'                => '',
        'watermark'             => '',
        'show_watermark'        => true,
        'show_watermark_image'  => true,
        'watermark_font'        => 'sans-serif',
        'display_mode'          => 'fullpage',
        'watermark_text_alpha'  => 0.2,
    ];

    $pdf = PDF::loadView('apotik_dll/supplier_cetak', ['supplier'=>$supplier],[],$config);
    ob_get_clean();
    return $pdf->download('Data Supplier_'.date('d_m_Y H_i_s').'.pdf');
    //download : langsung download
    //stream : open preview
    }
    public function laporanExcel(Request $request)
    {

      return Excel::download(new SupplierExport(),'Data Supplier"'.date('d_m_Y H_i_s').'".xlsx');
    }
    public function hapus(Request $req,$enc_id)
    {
      $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      $supplier = Supplier::find($dec_id);

      if ($supplier) {
          $supplier->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }

    function autocomplete(Request $request) {
        $datasupplier = Supplier::select('nama_supplier')->where('nama_supplier','LIKE',$request->term.'%')->get();
        $return_arr = array();
        foreach ($datasupplier as $supplier) {
            $return_arr[] = $supplier->nama_supplier;
        }

        echo json_encode($return_arr);
    }
}
