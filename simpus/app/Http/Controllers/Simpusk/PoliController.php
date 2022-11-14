<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Dokter;
use Illuminate\Http\Request;
use App\Models\Simpusk\Poli;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $record->kdpoli         = $record->kdpoli;
        $record->kode_poli      = $record->kode_poli;
        $list_dokter                 = '';
        foreach(json_decode($record->dokter) as $dokter){
          $cari_dokter = Dokter::where('kdDokter', $dokter)->first();
          $list_dokter .= '<p>'.$cari_dokter['nmDokter'].'</p><br>';
        }
        $record->dokter = $list_dokter;         
        $record->action         = $action;
        // $status = "<label class='switch'>";
        // if($record->status == 1){
        //     $status .="<input type='checkbox' value='".$record->id."' id='data_".$record->id."' checked>";
        // }else{
        //     $status .="<input type='checkbox' value='".$record->id."' id='data_".$record->id."'>";
        // }
        // $status .="<span class='slider round'></span>
        // </label>";
        // $status .= " <script>
        // $('#data_".$record->id."').click(function(){
        //   var id = this.value;
        //   var cek = $('#data_".$record->id."').prop('checked');
        //   console.log(cek);
        //   if(cek == true){
        //       var val = 0;
        //   }
        //   else{
        //       var val = 1;
        //   }
        //   console.log(val);
        //     Swal.fire({
        //       title: 'Apakah Anda yakin?',
        //       text: 'Status poli akan diubah!',

        //       icon: 'warning',
        //       showCancelButton: true,
        //       confirmButtonClass: 'btn-danger',
        //       confirmButtonText: 'Ya',
        //       cancelButtonText:'Batal',
        //       confirmButtonColor: '#ec6c62',
        //       closeOnConfirm: false
        //     }).then(function(result){
        //         if(result.value){
        //           $.ajax({
        //               type: 'POST',
        //               url: '".route('poli.status_ubah')."',
        //               headers: {'X-CSRF-TOKEN': $('[name=\"_token\"]').val()},
        //               data: {id : id, value: cek},
        //               success: function(data){
        //                   if(data.success == true){
        //                       Swal.fire('Yes',data.message,'success');
        //                       table.ajax.reload(null, true);

        //                   }
        //                   else{
        //                       Swal.fire('Peringatan',data.message,'info');
        //                       var check = $('#data_".$record->id."');
        //                       if(check.prop('checked') == false){
        //                           check.prop('checked', true);
        //                       }
        //                       else{
        //                           check.prop('checked', false);
        //                       }

        //                   }
        //               }
        //           });
        //         }else{
        //           var check = $('#data_".$record->id."');
        //           if(check.prop('checked') == false){
        //               check.prop('checked', true);
        //           }
        //           else{
        //               check.prop('checked', false);
        //           }

        //         }
        //     });
        // });
        // </script>";
        if($record->status == 1){
          $status = '<span class="badge badge-primary">Aktif</span>';
        }else{
          $status = '<span class="badge badge-danger">Tidak Aktif</span>';
        }
        $record->status = $status;
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
      $selectedkunjungan = "";
      $selectedstatus = "";
      return view('master_form/poli_form',compact('induk','selectedinduk', 'selectedkunjungan', 'selectedstatus'));
  }
  public function tambah_(){
    $url = '/poli/fktp/1/100';
    return APIBpjsController::get($url);
  }
  // ubah : Form ubah data
  public function ubah($enc_id)
  {
    $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));

      if ($dec_id) {
        $poli  = Poli::find($dec_id);
        $induk = Poli::where('parent',null)->get();
        $selectedinduk = $poli->parent;
        $selectedkunjungan = $poli->kunjungan_sakit;
        $selectedstatus = $poli->status;
        $dokter = collect([]);
        if(count(json_decode($poli->dokter)) > 0){
          foreach(json_decode($poli->dokter) as $key => $dkr){
            $cek_dokter = Dokter::where('kdDokter', $dkr)->first();
            $tamp['kdDokter'] = $cek_dokter->kdDokter;
            $tamp['nmDokter'] = $cek_dokter->nmDokter;
            $dokter->push($tamp);
          }
        }

        return view('master_form/poli_form',compact('enc_id','poli','induk','selectedinduk', 'selectedkunjungan', 'selectedstatus', 'dokter'));
      } else {
        return view('errors/noaccess');
      }
    }
    public function status_ubah(Request $req){
        //   return $req->value;
          $data = Poli::find($req->id);
          if($data->kode_poli == "" || $data->kode_poli == null){
            return response()->json([
                'success' => false,
                'code' => 201,
                'message' => 'status poli gagal dirubah, silahkan isi terlebih dahulu kode poli',
            ]);
          }
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
    public function simpan(Request $req){
      //VALIDASI
      if($req->enc_id == '' || $req->enc_id == null){
        $cek_poli = Poli::where(function($q) use($req){
          $q->orwhere('nama_poli', 'LIKE','%'. $req->nama_poli .'%');
          $q->orwhere('ruang_poli', 'LIKE','%'. $req->nama_poli .'%');
          $q->orwhere('kdpoli', $req->kdpoli);
          $q->orwhere('kode_poli', $req->kode_poli);
        })->first();
        if(isset($cek_poli)){
          return response()->json([
            'success' => false,
            'message' => 'Data gagal disimpan, terdapat kesamaan data dengan database'
          ]);
        }
      }
      //END VALIDASI
      try{
        DB::beginTransaction();
        $enc_id = $req->enc_id;
        $dokter_penanggung = $req->dokter;
        $dec_id = '';
        if($enc_id != '' || $enc_id != null || isset($enc_id)){
          $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        }
        if(!isset($dec_id) || $dec_id == '' || $dec_id == null){
          $poli = new Poli();
        }else{
          $poli = Poli::find($dec_id);
        }
        $poli->nama_poli        = $req->nama_poli;
        $poli->ruang_poli       = $req->nama_poli;
        $poli->kdpoli           = $req->kdpoli;
        $poli->kode_poli        = $req->kode_poli;
        $poli->status           = $req->status;
        $poli->kunjungan_sakit  = $req->kunjungan_sakit;
        $array_dokter = collect();
        foreach($dokter_penanggung as $key => $dokter){
          $array_dokter->push($dokter);
        }
        $poli->dokter = json_encode($array_dokter);
        $poli->save();
        DB::commit();
        return response()->json([
          'success' => true,
          'message' => 'Data berhasil disimpan'
        ]);
        
      }catch(\Throwable $th){
        DB::rollBack();
        return response()->json([
          'success' => false,
          'message' => 'Data gagal disimpan, '.$th->getMessage()
        ]);
      }
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
