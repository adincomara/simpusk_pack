<?php

namespace App\Http\Controllers\PTM;

use App\Exports\ExportExcel;
use App\Http\Controllers\Simpusk\Controller;
use App\Models\Balkesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\PTM\Puskesmas;
use App\Models\PTM\Kabupaten;
use App\Models\Kecamatan;
use App\Models\PTM\Provinsi;
use App\Models\PTM\Sdq;

use DB;
use Auth;
use Carbon;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SdqController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {

        $user = Puskesmas::find(auth()->user()->puskesmas_id);

        $start_date = date('M-Y');
        $end_date = date('M-Y');
        $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

        return view('ptm/deteksi_dini/sdq/index', compact('user', 'data', 'start_date', 'end_date'));
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

    private function cekExist($column, $var, $id)
    {
        $cek = Sdq::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function tambah()
    {
        $query = Puskesmas::select('*');
        $query->where('id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return response()->json($puskesmas);
        return view('ptm/deteksi_dini/sdq/form', compact('puskesmas', 'date_now'));
    }

    private function sum_data($array, $field, $puskesmas, $periode_start, $periode_end)
    {

            $dataquery = collect($array)->where('puskesmas_id', $puskesmas)->where('periode','>=',$periode_start)->where('periode','<=',$periode_end)->map(function ($user) use ($field) {
                return collect($user->toArray())->only([$field])->all();
            })->sum($field);


        return $dataquery;
    }

    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];

        if ($request->periode_start != '' && $request->periode_end != '') {
            $periode_start = date('Y-m-d', strtotime('01-' . $request->periode_start));
            $periode_end = date('Y-m-d', strtotime('01-' . $request->periode_end));
        } else {
            $periode_start = date('Y-m-d');
            $periode_end = date('Y-m-d');
        }

            $dataquery = Puskesmas::select('id', 'name');
            $dataquery->where('id', auth()->user()->puskesmas_id);

            if (array_key_exists($request->order[0]['column'], $this->original_column)) {
                $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
            } else {
                $dataquery->orderBy('code', 'ASC');
            }
            $id_pusk = $dataquery->pluck('id');
            $all_data = Sdq::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
            // return $all_data;


        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        // return $data;


        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            if (strtotime($periode_start) == strtotime($periode_end)) {
                $array = array(
                    'enc' => $enc_id,
                    'start' => $periode_start,
                    'end' => $periode_end
                );
                // $encode = json_encode($array);
                $action .= '<a href="' . route('dd_sdq.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            }

            if (strtotime($periode_start) == strtotime($periode_end)) {
                $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }

            $action .= "</div>";




            $result->no                     = $key + $page;
            $result->id                     = $result->id;
            $result->action                 = $action;
            $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
            $result->puskesmas              = $result->name;

            $result->dd_sdq_4_10_l          = $this->sum_data($all_data, 'dd_sdq_4_10_l', $result->id, $periode_start, $periode_end);
            $result->dd_sdq_4_10_p          = $this->sum_data($all_data, 'dd_sdq_4_10_p', $result->id, $periode_start, $periode_end);
            $result->dd_sdq_11_18_l         = $this->sum_data($all_data, 'dd_sdq_11_18_l', $result->id, $periode_start, $periode_end);
            $result->dd_sdq_11_18_p         = $this->sum_data($all_data, 'dd_sdq_11_18_p', $result->id, $periode_start, $periode_end);
            $result->abnormal_4_10_l        = $this->sum_data($all_data, 'abnormal_4_10_l', $result->id, $periode_start, $periode_end);
            $result->abnormal_4_10_p        = $this->sum_data($all_data, 'abnormal_4_10_p', $result->id, $periode_start, $periode_end);
            $result->abnormal_11_18_l       = $this->sum_data($all_data, 'abnormal_11_18_l', $result->id, $periode_start, $periode_end);
            $result->abnormal_11_18_P       = $this->sum_data($all_data, 'abnormal_11_18_P', $result->id, $periode_start, $periode_end);

        }
        // return $data;
        if(count($all_data) <= 0){
            $data = [];
        }
        $array['puskesmas']            = (count($data) > 0)? $data->count() : 0;
        $array['dd_sdq_4_10_l']        = (count($data) > 0)? $data->sum('dd_sdq_4_10_l') : 0;
        $array['dd_sdq_4_10_p']        = (count($data) > 0)? $data->sum('dd_sdq_4_10_p') : 0;
        $array['dd_sdq_11_18_l']       = (count($data) > 0)? $data->sum('dd_sdq_11_18_l') : 0;
        $array['dd_sdq_11_18_p']       = (count($data) > 0)? $data->sum('dd_sdq_11_18_p') : 0;
        $array['abnormal_4_10_l']      = (count($data) > 0)? $data->sum('abnormal_4_10_l') : 0;
        $array['abnormal_4_10_p']      = (count($data) > 0)? $data->sum('abnormal_4_10_p') : 0;
        $array['abnormal_11_18_l']     = (count($data) > 0)? $data->sum('abnormal_11_18_l') : 0;
        $array['abnormal_11_18_P']     = (count($data) > 0)? $data->sum('abnormal_11_18_P') : 0;
        // return $data;
        // if(count($all_data) < 1){
        //     $data = [];
        // }
        // return "tes";

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data,
                'sum_data'        => $array,
            );

        return json_encode($json_data);
    }

    public function simpan(Request $req)
    {
        // return $req->all();
        if (strtotime('01-' . $req->periode) == 0) {
            return response()->json([
                "success"         => FALSE,
                "message"         => 'Data gagal diperbaharui. Periode harus diisi'
            ]);
        }
        $enc_id     = $req->enc_id;
        // return response()->json(['data' => $req->all()]);

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }


        $cek_nama = $this->cekExist('periode', date("Y", strtotime($req->periode)), $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                DB::beginTransaction();
                if ($enc_id) {
                    // return $dec_id;
                    $query = Puskesmas::select('ptm_puskesmas.*');
                    $query->where('ptm_puskesmas.id', auth()->user()->puskesmas_id);
                    $puskesmas = $query->first();
                    // return $puskesmas;
                    // return $req->periode;
                    $sdq = Sdq::where('puskesmas_id', $puskesmas->id)->where('periode', date('Y-m-d', strtotime('01-' . $req->periode)))->first();
                    // $sdq = Sdq::find($dec_id);
                    // return $sdq;
                    $sdq->user_id                = auth()->user()->id;
                    $sdq->puskesmas_id           = auth()->user()->puskesmas_id;

                    $sdq->dd_sdq_4_10_l        = $req->dd_sdq_4_10_l;
                    $sdq->dd_sdq_4_10_p        = $req->dd_sdq_4_10_p;
                    $sdq->dd_sdq_11_18_l       = $req->dd_sdq_11_18_l;
                    $sdq->dd_sdq_11_18_p       = $req->dd_sdq_11_18_p;
                    $sdq->abnormal_4_10_l      = $req->abnormal_4_10_l;
                    $sdq->abnormal_4_10_p      = $req->abnormal_4_10_p;
                    $sdq->abnormal_11_18_l     = $req->abnormal_11_18_l;
                    $sdq->abnormal_11_18_P     = $req->abnormal_11_18_p;
                    $sdq->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $sdq->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Sdq::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $sdq                         = new Sdq;
                    $sdq->user_id                = auth()->user()->id;
                    $sdq->puskesmas_id           = auth()->user()->puskesmas_id;

                    $sdq->dd_sdq_4_10_l        = $req->dd_sdq_4_10_l;
                    $sdq->dd_sdq_4_10_p        = $req->dd_sdq_4_10_p;
                    $sdq->dd_sdq_11_18_l       = $req->dd_sdq_11_18_l;
                    $sdq->dd_sdq_11_18_p       = $req->dd_sdq_11_18_p;
                    $sdq->abnormal_4_10_l      = $req->abnormal_4_10_l;
                    $sdq->abnormal_4_10_p      = $req->abnormal_4_10_p;
                    $sdq->abnormal_11_18_l     = $req->abnormal_11_18_l;
                    $sdq->abnormal_11_18_P     = $req->abnormal_11_18_p;
                    $sdq->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $sdq->save();

                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    );
                }
            } catch (\Throwable $th) {
                DB::rollback();
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => $th->getMessage()
                );
            }
        }
        return json_encode($json_data);
    }

    public function ubah($array)
    {
        parse_str($array, $get_array);
        if (strtotime($get_array['start']) == strtotime($get_array['end'])) {
            // return "sama";
            $dec_id = $this->safe_decode(Crypt::decryptString($get_array['enc']));
            $enc_id = $get_array['enc'];
            // return $dec_id;
            if ($dec_id) {
                $query = Puskesmas::select('ptm_puskesmas.*');
                $query->where('ptm_puskesmas.id', auth()->user()->puskesmas_id);
                $puskesmas = $query->first();
                // return $puskesmas;

                $sdq = Sdq::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $sdq;
                $periode = date('M-Y', strtotime($sdq->periode));
                $sdq->date_periode = $periode;

                // return response()->json(['data' => $ptm]);
                return view('ptm/deteksi_dini/sdq/form', compact('enc_id', 'puskesmas', 'sdq'));
            } else {
                $kabupaten = Kabupaten::all();
                $user_level = auth()->user()->flag_user;
                $user = Puskesmas::find(auth()->user()->puskesmas_id);
                $start_date = date('M-Y', strtotime('-1 Months'));
                $end_date = date('M-Y');
                $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

                return view('template/deteksi/sdq/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
            }
        } else {
            $kabupaten = Kabupaten::all();
            $user_level = auth()->user()->flag_user;
            if (auth()->user()->can('provinsi.index')) {
                $user = provinsi::find(auth()->user()->provinsi_id);
            } else if (auth()->user()->can('kabupaten.index')) {
                $user = Kabupaten::find(auth()->user()->kabupaten_id);
            } else if (auth()->user()->can('puskesmas.index')) {
                $user = Puskesmas::find(auth()->user()->puskesmas_id);
            }
            $start_date = date('M-Y', strtotime('-1 Months'));
            $end_date = date('M-Y');
            $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

            return view('template/deteksi/sdq/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
        }
        // $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        // // return $dec_id;
        // if ($dec_id) {
        //     $query = Puskesmas::select('puskesmas.*');
        //     $query->where('puskesmas.id', auth()->user()->puskesmas_id);
        //     $puskesmas = $query->first();
        //     // return $puskesmas;

        //     $sdq = Sdq::find($dec_id);
        //     $periode = date('m-Y', strtotime($sdq->periode));
        //     $sdq->date_periode = $periode;

        //     // return response()->json(['data' => $ptm]);
        //     return view('template/deteksi/sdq/form', compact('enc_id', 'puskesmas', 'sdq'));
        // } else {
        //     $json_data = array(
        //         "success"         => FALSE,
        //         "message"         => $th->getMessage()
        //     );
        //     return json_encode($json_data);
        // }
        // return response()->json($puskesmas);
    }

    public function hapus(Request $req, $array)
    {
        parse_str($array, $get_array);
        // return $get_array;
        $dec_id   = $this->safe_decode(Crypt::decryptString($get_array['enc']));
        // return $dec_id;
        if (strtotime($get_array['start']) == strtotime($get_array['end'])) {
            if ($dec_id) {
                $query = Puskesmas::select('puskesmas.*');
                $query->where('puskesmas.id', auth()->user()->puskesmas_id);
                $puskesmas = $query->first();
                // return $puskesmas;

                $sdq = Sdq::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $sdq;
                // return $sdq;
                if ($sdq->delete()) {
                    return response()->json([
                        'success' => TRUE,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'success' => FALSE,
                        'message' => 'Data gagal dihapus'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => FALSE,
                    'message' => 'Data gagal dihapus'
                ]);
            }
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => 'Data gagal dihapus, range periode harus sama'
            ]);
        }
    }
    public function cetak_pdf(Request $request)
    {


        if($request->start != ''){
            $periode_start = date('Y-m-d', strtotime('01-'.$request->start));
        }else{
            $periode_start = date('Y-m=d');
        }
        if($request->end != ''){
            $periode_end = date('Y-m-d', strtotime('01-'.$request->end));
        }else{
            $periode_end = date('Y-m=d');
        }
        if ($request->user()->can('provinsi.index')) {
            $dataquery = Kabupaten::where('provinsi_id', auth()->user()->provinsi_id);

            if ($request->kabupaten != NULL) {
                $kabupaten = Kabupaten::find($request->kabupaten);
                $dataquery->where('name', 'LIKE', "%{$kabupaten->name}%");
            }


            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
            $kabupaten = $dataquery->pluck('name');
            $array_kab = collect();
            foreach ($kabupaten as $k) {
                $kab = explode(" ", $k);
                if ($kab[0] != "KOTA") {
                    $kabupaten_name = ucwords(strtolower($kab[1]));
                } else {
                    $kabupaten_name = ucwords(strtolower($k));
                }
                $array_kab->push($kabupaten_name);
            }
            $pusk = Puskesmas::whereIn('kabupaten', $array_kab);
            $all_puskesmas = $pusk->get();
            $id_pusk = $pusk->pluck('id');
            $all_data = Sdq::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        } else if (auth()->user()->can('balkesmas.index')) {
            $dataquery = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id);
            // return $dataquery->get();
            if ($request->kabupaten != NULL) {
                $kabupaten = Kabupaten::find($request->kabupaten);
                // return $kabupaten;
                $dataquery->where('name', 'LIKE', "%{$kabupaten->name}%");
            }


            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
            $kabupaten = $dataquery->pluck('name');
            $array_kab = collect();
            foreach ($kabupaten as $k) {
                $kab = explode(" ", $k);
                if ($kab[0] != "KOTA") {
                    $kabupaten_name = ucwords(strtolower($kab[1]));
                } else {
                    $kabupaten_name = ucwords(strtolower($k));
                }
                $array_kab->push($kabupaten_name);
            }
            $pusk = Puskesmas::whereIn('kabupaten', $array_kab);
            $all_puskesmas = $pusk->get();
            $id_pusk = $pusk->pluck('id');
            $all_data = Sdq::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
            // return $all_data;
        } else if ($request->user()->can('kabupaten.index')) {
            $kabupaten = Kabupaten::select('id', 'name')->where('id', $request->user()->kabupaten_id)->first();
            $kabupaten_name = explode(" ", $kabupaten->name);
            $kabupaten = $kabupaten_name[1];
            $dataquery = Puskesmas::select('id', 'name')->where('kabupaten', 'LIKE', "%{$kabupaten}%");


            $dataquery->orderBy('name', 'ASC');




            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
            $id_pusk = $dataquery->pluck('id');
            $all_data = Sdq::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        } else if ($request->user()->can('puskesmas.index')) {
            $dataquery = Puskesmas::select('id', 'name');
            $dataquery->where('id', auth()->user()->puskesmas_id);
            $dataquery->orderBy('name', 'ASC');

            $id_pusk = $dataquery->pluck('id');
            $all_data = Sdq::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        }


        $data = $dataquery->get();

        if (auth()->user()->can('provinsi.index') || auth()->user()->can('balkesmas.index')) {
            foreach ($data as $key => $resultt) {
                $kabupaten_name = explode(" ", $resultt->name);
                if ($kabupaten_name[0] != "KOTA") {
                    $kab = ucwords(strtolower($kabupaten_name[1]));
                } else {
                    $kab = ucwords(strtolower($resultt->name));
                }
                // $dataquery = Puskesmas::select('id', 'name')->where('kabupaten', 'LIKE', "%{$kab}%")->get();
                $dataquery = collect($all_puskesmas)->where('kabupaten', $kab)->all();
                // return $dataquery;
                foreach ($dataquery as $idx => $result) {
                    $result->kabupaten              = strtoupper($result->kabupaten);
                    $result->puskesmas              = $result->name;

                    $result->dd_sdq_4_10_l          = $this->sum_data($all_data, 'dd_sdq_4_10_l', $result->id, $periode_start, $periode_end);
                    $result->dd_sdq_4_10_p          = $this->sum_data($all_data, 'dd_sdq_4_10_p', $result->id, $periode_start, $periode_end);
                    $result->dd_sdq_11_18_l         = $this->sum_data($all_data, 'dd_sdq_11_18_l', $result->id, $periode_start, $periode_end);
                    $result->dd_sdq_11_18_p         = $this->sum_data($all_data, 'dd_sdq_11_18_p', $result->id, $periode_start, $periode_end);
                    $result->abnormal_4_10_l        = $this->sum_data($all_data, 'abnormal_4_10_l', $result->id, $periode_start, $periode_end);
                    $result->abnormal_4_10_p        = $this->sum_data($all_data, 'abnormal_4_10_p', $result->id, $periode_start, $periode_end);
                    $result->abnormal_11_18_l       = $this->sum_data($all_data, 'abnormal_11_18_l', $result->id, $periode_start, $periode_end);
                    $result->abnormal_11_18_P       = $this->sum_data($all_data, 'abnormal_11_18_P', $result->id, $periode_start, $periode_end);
                }
                $enc_id = $this->safe_encode(Crypt::encryptString($resultt->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('sdq.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('sdq.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('sdq.hapus')) {
                    $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
                }

                $action .= "</div>";

                // $resultt->no                     = $key + $page;
                $resultt->id                     = $resultt->id;
                $resultt->action                 = $action;
                $kabupaten_name = explode(" ", $resultt->name);
                if ($kabupaten_name[0] != 'KOTA') {
                    $resultt->kabupaten            = strtoupper($kabupaten_name[1]);
                    $resultt->puskesmas            = strtoupper($kabupaten_name[1]);
                } else {
                    $resultt->kabupaten            = strtoupper($resultt->kabupaten);
                    $resultt->puskesmas            = $resultt->name;
                }
                $resultt->dd_sdq_4_10_l              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['dd_sdq_4_10_l'])->all();
                })->sum('dd_sdq_4_10_l');
                $resultt->dd_sdq_4_10_p               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['dd_sdq_4_10_p'])->all();
                })->sum('dd_sdq_4_10_p');
                $resultt->dd_sdq_11_18_l          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['dd_sdq_11_18_l'])->all();
                })->sum('dd_sdq_11_18_l');
                $resultt->dd_sdq_11_18_p          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['dd_sdq_11_18_p'])->all();
                })->sum('dd_sdq_11_18_p');
                $resultt->abnormal_4_10_l             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['abnormal_4_10_l'])->all();
                })->sum('abnormal_4_10_l');
                $resultt->abnormal_4_10_p             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['abnormal_4_10_p'])->all();
                })->sum('abnormal_4_10_p');
                $resultt->abnormal_11_18_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['abnormal_11_18_l'])->all();
                })->sum('abnormal_11_18_l');
            }
        } else {
            if(Gate::check('puskesmas.index')){
                $awal  = date_create($periode_start);
                $akhir  = date_create($periode_end);
                // $akhir = date_create(); // waktu sekarang
                $diff  = date_diff( $awal, $akhir );
                $json = [];
                for($i=0;$i<=$diff->m;$i++){
                    $start = date('Y-m-d', strtotime($periode_start.' first day of +'.$i.' month'));
                    $json[$i]['periode']                = date('M-Y', strtotime($periode_start)) . ' - ' . date('M-Y', strtotime($periode_end));
                    $json[$i]['puskesmas']              = $dataquery->first()['name'];
                    $json[$i]['bulan']                  = date('M-Y', strtotime($periode_start.' first day of +'.$i.' month'));
                    $json[$i]['dd_sdq_4_10_l']          = $this->sum_data($all_data, 'dd_sdq_4_10_l', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['dd_sdq_4_10_p']          = $this->sum_data($all_data, 'dd_sdq_4_10_p', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['dd_sdq_11_18_l']         = $this->sum_data($all_data, 'dd_sdq_11_18_l', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['dd_sdq_11_18_p']         = $this->sum_data($all_data, 'dd_sdq_11_18_p', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['abnormal_4_10_l']        = $this->sum_data($all_data, 'abnormal_4_10_l', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['abnormal_4_10_p']        = $this->sum_data($all_data, 'abnormal_4_10_p', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['abnormal_11_18_l']       = $this->sum_data($all_data, 'abnormal_11_18_l', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['abnormal_11_18_P']       = $this->sum_data($all_data, 'abnormal_11_18_P', auth()->user()->puskesmas_id, $start, $start);
                }
            $data = $json;
            }else{
                foreach ($data as $key => $result) {
                    $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
                    $action = "";

                    $action .= "";
                    $action .= "<div class='btn-group'>";
                    if ($request->user()->can('sdq.ubah')) {
                        $array = array(
                            'enc' => $enc_id,
                            'start' => $periode_start,
                            'end' => $periode_end
                        );
                        $action .= '<a href="' . route('sdq.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                    }

                    if ($request->user()->can('sdq.hapus')) {
                        $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
                    }

                    $action .= "</div>";
                    $result->id                     = $result->id;
                    $result->action                 = $action;

                    if ($request->user()->can('kabupaten.index')) {
                        // $record = $this->get_data_record($result->id, $periode_start, $periode_end);
                        // return response()->json(['data' => $record]);
                        // $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
                        $result->puskesmas              = $result->name;


                        $result->dd_sdq_4_10_l          = $this->sum_data($all_data, 'dd_sdq_4_10_l', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_4_10_p          = $this->sum_data($all_data, 'dd_sdq_4_10_p', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_11_18_l         = $this->sum_data($all_data, 'dd_sdq_11_18_l', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_11_18_p         = $this->sum_data($all_data, 'dd_sdq_11_18_p', $result->id, $periode_start, $periode_end);
                        $result->abnormal_4_10_l        = $this->sum_data($all_data, 'abnormal_4_10_l', $result->id, $periode_start, $periode_end);
                        $result->abnormal_4_10_p        = $this->sum_data($all_data, 'abnormal_4_10_p', $result->id, $periode_start, $periode_end);
                        $result->abnormal_11_18_l       = $this->sum_data($all_data, 'abnormal_11_18_l', $result->id, $periode_start, $periode_end);
                        $result->abnormal_11_18_P       = $this->sum_data($all_data, 'abnormal_11_18_P', $result->id, $periode_start, $periode_end);
                    } else if ($request->user()->can('puskesmas.index')) {
                        $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
                        $result->puskesmas              = $result->name;

                        $result->dd_sdq_4_10_l          = $this->sum_data($all_data, 'dd_sdq_4_10_l', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_4_10_p          = $this->sum_data($all_data, 'dd_sdq_4_10_p', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_11_18_l         = $this->sum_data($all_data, 'dd_sdq_11_18_l', $result->id, $periode_start, $periode_end);
                        $result->dd_sdq_11_18_p         = $this->sum_data($all_data, 'dd_sdq_11_18_p', $result->id, $periode_start, $periode_end);
                        $result->abnormal_4_10_l        = $this->sum_data($all_data, 'abnormal_4_10_l', $result->id, $periode_start, $periode_end);
                        $result->abnormal_4_10_p        = $this->sum_data($all_data, 'abnormal_4_10_p', $result->id, $periode_start, $periode_end);
                        $result->abnormal_11_18_l       = $this->sum_data($all_data, 'abnormal_11_18_l', $result->id, $periode_start, $periode_end);
                        $result->abnormal_11_18_P       = $this->sum_data($all_data, 'abnormal_11_18_P', $result->id, $periode_start, $periode_end);
                    }
                }
            }
        }
        // return $data;
        $array['puskesmas']            = count($data);
        $array['dd_sdq_4_10_l']        = collect($data)->sum('dd_sdq_4_10_l');
        $array['dd_sdq_4_10_p']        = collect($data)->sum('dd_sdq_4_10_p');
        $array['dd_sdq_11_18_l']       = collect($data)->sum('dd_sdq_11_18_l');
        $array['dd_sdq_11_18_p']       = collect($data)->sum('dd_sdq_11_18_p');
        $array['abnormal_4_10_l']      = collect($data)->sum('abnormal_4_10_l');
        $array['abnormal_4_10_p']      = collect($data)->sum('abnormal_4_10_p');
        $array['abnormal_11_18_l']     = collect($data)->sum('abnormal_11_18_l');
        $array['abnormal_11_18_P']     = collect($data)->sum('abnormal_11_18_P');
        $array['action']                 = '';
        // return $data;
        $view = 'template/deteksi/sdq/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'Sdq.xlsx');
        }
        $config = [
            'mode'                  => '',
            'format'                => 'A4',
            'default_font_size'     => '11',
            'default_font'          => 'sans-serif',
            'margin_left'           => 8,
            'margin_right'          => 8,
            'margin_top'            => 8,
            'margin_bottom'         => 8,
            'margin_header'         => 0,
            'margin_footer'         => 0,
            'orientation'           => 'L',
            'title'                 => 'SDQ',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/deteksi/sdq/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-deteksi-sdq.pdf');
    }
}
