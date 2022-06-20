<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\DiagnosaPenyakit;
use App\Models\Simpusk\Pegawai;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;

class DiagnosaPenyakitController extends Controller
{
    public function url_diagnosa_penyakit()
    {
        $x = env('APP_URL') . '/diagnosa_penyakit';
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
        return view('master/data_diagnosa_penyakit');
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = DiagnosaPenyakit::select('*');
        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('kode_diagnosa', 'LIKE', "%{$search}%");
                $query->orWhere('nama_penyakit', 'LIKE', "%{$search}%");
            });
        }

        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->kode_diagnosa));
            $action = "";

            $action .= "";
            if($request->user()->can('diagnosa_penyakit.ubah')){
                $action.='<a href="'.route('diagnosa_penyakit.ubah',$enc_id).'" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if($request->user()->can('diagnosa_penyakit.hapus')){
             $action.='<a href="#" onclick="deleteData(this,\''.$enc_id.'\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> hapus</a>&nbsp;';
            }




            $record->no             = $key + $page;
            $record->action         = $action;
            $record->kode_diagnosa         = $record->kode_diagnosa;
        }
        if ($request->user()->can('diagnosa_penyakit.index')) {
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
        return view('master_form/diagnosa_penyakit_form', compact('status', 'selectedstatus'));
    }


    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $diagnosa_penyakit = DiagnosaPenyakit::find($dec_id);
            return view('master_form/diagnosa_penyakit_form', compact('enc_id', 'diagnosa_penyakit'));
        } else {
            return view('errors/noaccess');
        }
    }

    public function simpan(Request $req)
    {
        $enc_id     = $req->enc_id;

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }

        if ($enc_id) {
            $data = DiagnosaPenyakit::find($dec_id);

            // $data->kode_diagnosa       = $req->kode_diagnosa;
            $data->nama_penyakit       = $req->nama_penyakit;
            $data->ciri_ciri_penyakit       = $req->ciri_ciri_penyakit;
            $data->keterangan       = $req->keterangan;
            $data->ciri_ciri_umum       = $req->ciri_ciri_umum;
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
            $checkdata = DiagnosaPenyakit::find($req->kode_diagnosa);
            if ($checkdata) {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => 'Kode Diangnosa sudah terdaftar.'
                );
            } else {
                $data = new DiagnosaPenyakit;

                $data->kode_diagnosa       = $req->kode_diagnosa;
                $data->nama_penyakit       = $req->nama_penyakit;
                $data->ciri_ciri_penyakit       = $req->ciri_ciri_penyakit;
                $data->keterangan       = $req->keterangan;
                $data->ciri_ciri_umum       = $req->ciri_ciri_umum;
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
        }
        return json_encode($json_data);
    }

    public function hapus(Request $req, $enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        $diagnosa_penyakit = DiagnosaPenyakit::find($dec_id);

        $pegawai = Pegawai::where('id_jabatan', $dec_id)->first();
        if ($pegawai) {
            return response()->json(['status' => "failed", 'message' => 'Data dipakai di pegawai, tidak dapat dihapus']);
        } else {
            if ($diagnosa_penyakit) {
                $diagnosa_penyakit->delete();
                return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
            } else {
                return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
            }
        }
    }
}
