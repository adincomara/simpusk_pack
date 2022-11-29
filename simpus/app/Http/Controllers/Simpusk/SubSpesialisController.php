<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\SubSpesialisBPJS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SubSpesialisController extends Controller
{
    public function index(){
        return view('master/data_subspesialis');
    }
    function safe_encode($string) {
        $data = str_replace(array('/'),array('_'),$string);
        return $data;
    }
    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }
    public function getData(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = SubSpesialisBPJS::select('*');
        $totalData = $records->get()->count();
        if($search != null || $search != ''){
            $records->where(function($q) use ($search){
                $q->orwhere('kdSpesialis', 'LIKE', $search.'%');
                $q->orwhere('kdSubSpesialis', 'LIKE', $search.'%');
                $q->orwhere('nmSubSpesialis', 'LIKE', $search.'%');
                $q->orwhere('kdPoliRujuk', 'LIKE', $search.'%');
            });
        }
  
  
        $totalFiltered = $records->get()->count();
  
        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach($data as $key => $record){
            $action = '';
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
            if($record->status == 1){
                $record->status = '<span class="badge badge-primary">Aktif</span>';
            }else{
                $record->status = '<span class="badge badge-danger">Tidak Aktif</span>';
            }
            $record->no = $key + $page;
            $action.='<a href="'.route('subspesialis.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            $record->action = $action;
            

        }
        if ($request->user()->can('dokter.index')) {
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
    public function ubah($enc_id){
        // return $id;
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

        if ($dec_id) {
            $subspesialis  = SubSpesialisBPJS::find($dec_id);
            // $induk = Dokter::where('parent',null)->get();
            // $selectedinduk = $poli->parent;

            return view('master_form/subspesialis_form',compact('enc_id','subspesialis'));
        } else {
            return view('errors/noaccess');
        }
    }
    public function tambah(){
        return view('master_form/subspesialis_form');
    }
    public function simpan(Request $req){
        try{
            DB::beginTransaction();
            if($req->enc_id != null || $req->enc_id = ''){
                $dec_id = $this->safe_decode(Crypt::decryptString($req->enc_id));
                $subspesialis = SubSpesialisBPJS::find($dec_id);
            }else{
                $subspesialis = new SubSpesialisBPJS();
            }
            $subspesialis->kdSpesialis = $req->kdSpesialis;
            $subspesialis->kdSubSpesialis = $req->kdSubSpesialis;
            $subspesialis->nmSubSpesialis = $req->nmSubSpesialis;
            $subspesialis->kdPoliRujuk = $req->kdPoliRujuk;
            $subspesialis->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
        return $req->all();
    }
    public function hapus($enc_id){
        try{
            DB::beginTransaction();
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
            $spesialis = SubSpesialisBPJS::find($dec_id);
            $spesialis->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus'
            ]);

        }
        return $enc_id;
    }
}
