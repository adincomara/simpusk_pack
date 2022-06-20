<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Poli;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
class PoliController extends Controller
{
   protected $original_column = array(
    1 => "nama_poli",
    2 => "ruang_poli",
  );

  public function index()
  {
    return view('master/data_poli');
  }

  public function getData(Request $request)
  {
      $limit = $request->length;
      $start = $request->start;
      $page  = $start +1;
      $search = $request->search['value'];

      $records = Poli::select('*');
      $records->orderBy('status', 'DESC');

      if(array_key_exists($request->order[0]['column'], $this->original_column)){
         $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
      }
       if($search) {
        $records->where(function ($query) use ($search) {
                $query->orWhere('nama_poli','LIKE',"%{$search}%");
                $query->orWhere('ruang_poli','LIKE',"%{$search}%");
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

        if($request->user()->can('poli.ubah')){
            $action.='<a href="'.route('poli.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
        }
        if($request->user()->can('poli.hapus')){
            $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
        }



        if($record->parent !=null){
          $cek = Poli::find($record->parent);
          $indukpoli = $cek->nama_poli;
        }
        $record->no             = $key+$page;
        $record->DT_RowId       = $record->id;
        $record->id             = $record->id;
        $record->name           = $record->parent==null?$record->nama_poli:'--'.$record->nama_poli.' ('.$indukpoli.')';
        $record->ruang          = $record->ruang_poli;
        $record->action         = $action;
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
                text: 'Status poli akan diubah!',

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
                        url: '".route('poli.status_ubah')."',
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
                text: 'Status poli akan diubah!',

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
                        url: '".route('poli.status_ubah')."',
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
      }
      if ($request->user()->can('poli.index')) {
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
      $induk = Poli::where('parent',null)->get();
      $selectedinduk = "";
      return view('master_form/poli_form',compact('induk','selectedinduk'));
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $poli  = Poli::find($dec_id);
        $induk = Poli::where('parent',null)->get();
        $selectedinduk = $poli->parent;

        return view('master_form/poli_form',compact('enc_id','poli','induk','selectedinduk'));
      } else {
        return view('errors/noaccess');
      }
    }
    public function status_ubah(Request $req){
        //   return $req->value;
          $data = Poli::find($req->id);
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
                'message' => 'status poli berhasil dirubah',
            ]);
          }else{
             // return $data;
            return response()->json([
                'success' => false,
                'code' => 201,
                'message' => 'status poli gagal dirubah',
            ]);
          }
      }
    public function simpan(Request $req)
    {
        // return $req->all();
      $enc_id     = $req->enc_id;



      if ($enc_id != null) {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
      }else{
        $dec_id = null;
      }

      if($enc_id){

        $poli = Poli::find($dec_id);

        $poli->nama_poli      = $req->nama_poli;
        $poli->ruang_poli     = $req->ruang_poli;
        $poli->parent         = $req->parent;
        $poli->kdpoli         = $req->kdpoli;
        $poli->save();
        if ($poli) {
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

        $poli = new Poli;

        $poli->nama_poli      = $req->nama_poli;
        $poli->ruang_poli     = $req->ruang_poli;
        $poli->parent         = $req->parent;
        $poli->kdpoli         = $req->kdpoli;
        $poli->save();

        if($poli) {
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
      $poli = poli::find($dec_id);

      if ($poli) {
          $poli->delete();
          return response()->json(['status'=>"success",'message'=>'Data berhasil dihapus.']);
      }else{
           return response()->json(['status'=>"failed",'message'=>'Gagal menghapus data']);
      }
    }
}
