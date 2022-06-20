<?php

namespace App\Http\Controllers\Simpusk;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Simpusk\Bidang;
use App\Models\Simpusk\Pegawai;


use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;

class BidangController extends Controller
{
    public function url_bidang()
    {
        $x = env('APP_URL') . '/bidang';
        return $x;
    }
    protected $original_column = array(
        1 => "title",
        2 => "status",
    );
    public function status()
    {
        $value = array('1' => 'Aktif', '0' => 'Tidak Aktif');
        return $value;
    }


    public function index()
    {
        return view('master/data_bidang');
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = Bidang::select('*');

        //   if(array_key_exists($request->order[0]['column'], $this->original_column)){
        //      $records->orderByRaw($this->original_column[$request->order[0]['column']].' '.$request->order[0]['dir']);
        //   }
        //   else{
        //     $records->orderBy('created_at','DESC');
        //   }
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('nama_bidang', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id_bidang));
            $action = "";

            $action .= "";

            if($request->user()->can('bidang.ubah')){
                $action.='<a href="'.route('bidang.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if($request->user()->can('bidang.hapus')){
                $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }

            $record->no             = $key + $page;
            // $record->url            = '<a href="'.$this->url_bidang().'/'.$record->slug_url.'" target="_blank">'.$this->url_bidang().'/'.$record->slug_url.'</a>';
            $record->action         = $action;
        }
        if ($request->user()->can('bidang.index')) {
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

    function safe_encode($string)
    {
        $data = str_replace(array('/'), array('_'), $string);
        return $data;
    }
    function safe_decode($string, $mode = null)
    {
        $data = str_replace(array('_'), array('/'), $string);
        return $data;
    }
    public function tambah()
    {

        $status = $this->status();
        $selectedstatus = "1";
        return view('master_form/bidang_form', compact('status', 'selectedstatus'));
    }


    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $bidang = Bidang::find($dec_id);
            $status = $this->status();
            $selectedstatus = $bidang->status;

            if ($bidang->image == null) {
                $gambar = url('media/bidang/no_img.png');
            } else {
                $gambar = url($bidang->image);
            }

            return view('master_form/bidang_form', compact('enc_id', 'bidang', 'gambar', 'status', 'selectedstatus'));
        } else {
            return view('errors/noaccess');
        }
    }


    private function cekSlug($column, $var, $id)
    {
        $cek = Bidang::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function simpan(Request $req)
    {
        $enc_id     = $req->enc_id;
        $datagambar = $req->image;
        $dir        = 'media/member/';

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

        if ($enc_id) {
            $data = Bidang::find($dec_id);

            $data->nama_bidang       = $req->nama_bidang;
            $data->save();

            if ($data) {
                $json_data = array(
                    "success"         => TRUE,
                    "message"         => 'Data berhasil diperbarui.'
                );
            } else {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => 'Data gagal diperbarui.'
                );
            }
        } else {
            $data = new Bidang;

            $data->nama_bidang            = $req->nama_bidang;
            $data->save();
            if ($data) {
                $json_data = array(
                    "success"         => TRUE,
                    "message"         => 'Data berhasil ditambahkan.'
                );
            } else {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => 'Data gagal ditambahkan.'
                );
            }
        }
        return json_encode($json_data);
    }

    public function hapus(Request $req, $enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $bidang = Bidang::find($dec_id);

        $pegawai = Pegawai::where('id_jabatan',$dec_id)->first();
        if($pegawai){
            return response()->json(['status' => "failed", 'message' => 'Data dipakai di pegawai, tidak dapat dihapus']);
        }else{
            if ($bidang) {
                $bidang->delete();
                return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
            } else {
                return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
            }
        }
    }
}
