<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;
use App\Models\Simpusk\Obat;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use PDF;

class ObatController extends Controller
{
    protected $original_column = array(
        1 => "id",
        2 => "kode_obat",
        3 => "nama_obat",
        4 => "jenis_obat",
        5 => "satuan",
    );


    public function index()
    {
        return view('apotik/data_obat');
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        $records = Obat::select('*');

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $records->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        }

        if ($search) {
            $records->where(function ($query) use ($search) {
                $query->orWhere('kode_obat', 'LIKE', "%{$search}%");
                $query->orWhere('nama_obat', 'LIKE', "%{$search}%");
                $query->orWhere('jenis_obat', 'LIKE', "%{$search}%");
                $query->orWhere('satuan', 'LIKE', "%{$search}%");
                $query->orWhere('barcode_obat', 'LIKE', "%{$search}%");
            });
        }
        $totalData = $records->get()->count();

        $totalFiltered = $records->get()->count();

        $records->limit($limit);
        $records->offset($start);
        $data = $records->get();
        foreach ($data as $key => $record) {
            $enc_id = $this->safe_encode(Crypt::encryptString($record->id));
            $action = "";

            if ($request->user()->can('obat.ubah')) {
                $action .= '<a href="' . route('obat.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip mb-1" style="min-width:60px" title="Edit"><i class="fa fa-pencil"></i> Ubah</a>&nbsp;';
            }
            if ($request->user()->can('obat.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>&nbsp;';
            }




            $record->no             = $key + $page;
            $record->DT_RowId       = $record->id;
            $record->kode_obat  = $record->kode_obat;
            $record->nama_obat  = $record->nama_obat;
            $record->jenis_obat         = $record->jenis_obat;
            $record->satuan      = $record->satuan;

            $record->action         = $action;
        }
        if ($request->user()->can('obat.index')) {
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

        return view('apotik_form/obat_form');
    }
    // ubah : Form ubah data
    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $obat = Obat::find($dec_id);


            return view('apotik_form/obat_form', compact('enc_id', 'obat'));
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

            $obat = Obat::find($dec_id);
            $obat->kode_obat  = $req->kode_obat;
            $obat->nama_obat  = $req->nama_obat;
            $obat->jenis_obat         = $req->jenis_obat;
            $obat->barcode_obat = $req->barcode_obat;
            $obat->satuan      = $req->satuan;
            $obat->save();

            if ($obat) {
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
            $checkdata = Obat::find($req->id);
            if ($checkdata) {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => 'Kode Obat sudah terdaftar.'
                );
            } else {
                $obat = new Obat;

                $obat->kode_obat  = $req->kode_obat;
                $obat->nama_obat  = $req->nama_obat;
                $obat->jenis_obat         = $req->jenis_obat;
                $obat->barcode_obat = $req->barcode_obat;
                $obat->satuan      = $req->satuan;
                $obat->save();

                if ($obat) {
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
        $obat = Obat::find($dec_id);

        if ($obat) {
            $obat->delete();
            return response()->json(['status' => "success", 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => "failed", 'message' => 'Gagal menghapus data']);
        }
    }
    public function autocomplete(Request $request)
    {
        $dataobat = Obat::select('nama_obat')->where('nama_obat','LIKE',$request->term.'%')->get();
        $return_arr = array();
        foreach ($dataobat as $obat) {
            $return_arr[] = $obat->nama_obat;
        }

        echo json_encode($return_arr);
    }
    public function autofill(Request $request)
    {
        $dataobat = Obat::select('*')->where('nama_obat','LIKE',$request->nama_obat.'%')->first();
        echo json_encode($dataobat);
    }


}
