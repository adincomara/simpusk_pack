<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index(){
        return view('master/data_dokter');
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
        $page  = $start +1;
        $search = $request->search['value'];

        $records = Dokter::select('*');
        $totalData = $records->get()->count();
  
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
            $record->no = $key +1;
            $action.='<a href="'.route('dokter.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
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
            $dokter  = Dokter::find($dec_id);
            $selectedstatus = $dokter->status;
            // $induk = Dokter::where('parent',null)->get();
            // $selectedinduk = $poli->parent;

            return view('master_form/dokter_form',compact('enc_id','dokter', 'selectedstatus'));
        } else {
            return view('errors/noaccess');
        }
    }
    public function tambah(){
        $selectedstatus = '';
        return view('master_form/dokter_form', compact('selectedstatus'));
    }
    public function simpan(Request $req){
        try{
            DB::beginTransaction();
            if($req->enc_id != null || $req->enc_id = ''){
                $dec_id = $this->safe_decode(Crypt::decryptString($req->enc_id));
                $dokter = Dokter::find($dec_id);
            }else{
                $dokter = new Dokter();
            }
            $dokter->kdDokter = $req->kdDokter;
            $dokter->nmDokter = $req->nmDokter;
            $dokter->status = $req->status;
            $dokter->save();
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
            $dokter = Dokter::find($dec_id);
            $dokter->delete();
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
    public function search_dokter(Request $req){
        $dokter = Dokter::where('status', 1);
        if($req->search != '' || $req->search != null){
            $dokter->where(function($q) use ($req){
                $q->orwhere('nmDokter', 'LIKE', $req->search.'%');
                $q->orwhere('kdDokter', 'LIKE', $req->search.'%');
            });
        }
        return response()->json($dokter->get());
    }
}
