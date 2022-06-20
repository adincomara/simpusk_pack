<?php

namespace App\Http\Controllers\PTM;

use App\Exports\ExportExcel;
use App\Http\Controllers\Simpusk\Controller;
use App\Models\Balkesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\PTM\Puskesmas;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\PTM\Pandu;

use DB;
use Auth;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PanduController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {

        $kabupaten = [];


        $user = Puskesmas::find(auth()->user()->puskesmas_id);

        $start_date = date('M-Y');
        $end_date = date('M-Y');
        $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

        return view('ptm/deteksi_dini/pandu/index', compact('kabupaten', 'user', 'data', 'start_date', 'end_date'));
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
        $cek = Pandu::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function tambah()
    {
        $query = Puskesmas::select('*');
        $query->where('id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return response()->json($puskesmas);
        return view('ptm/deteksi_dini/pandu/form', compact('puskesmas', 'date_now'));
    }

    private function sum_data($array, $field, $puskesmas, $periode_start, $periode_end)
    {
        // $dataquery = Pandu::where('puskesmas_id', $puskesmas)
        //     ->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
        //     ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))
        //     ->sum($field);
        $dataquery = collect($array)->where('puskesmas_id', $puskesmas)->map(function ($user) use ($field) {
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
        $all_data = Pandu::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
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
                $action .= '<a href="' . route('dd_pandu.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
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

            $result->jml_pasien_skrining        = $this->sum_data($all_data, 'jml_pasien_skrining', $result->id, $periode_start, $periode_end);
            $result->jml_kasus_ptm              = $this->sum_data($all_data, 'jml_kasus_ptm', $result->id, $periode_start, $periode_end);
            $result->jml_kasus_non_ptm          = $this->sum_data($all_data, 'jml_kasus_non_ptm', $result->id, $periode_start, $periode_end);
            $result->charta_5                   = $this->sum_data($all_data, 'charta_5', $result->id, $periode_start, $periode_end);
            $result->charta_5_10                = $this->sum_data($all_data, 'charta_5_10', $result->id, $periode_start, $periode_end);
            $result->charta_10_20               = $this->sum_data($all_data, 'charta_10_20', $result->id, $periode_start, $periode_end);
            $result->charta_20_30               = $this->sum_data($all_data, 'charta_20_30', $result->id, $periode_start, $periode_end);
            $result->charta_30                  = $this->sum_data($all_data, 'charta_30', $result->id, $periode_start, $periode_end);
            $result->jml_dirujuk_rs             = $this->sum_data($all_data, 'jml_dirujuk_rs', $result->id, $periode_start, $periode_end);

        }
        // return $data;
        if(count($all_data) <= 0){
            $data = [];
        }

        $array['puskesmas']                    = (count($all_data) > 0)? $data->count() : 0;
        $array['jml_pasien_skrining']          = (count($all_data) > 0)? $data->sum('jml_pasien_skrining') : 0;
        $array['jml_kasus_ptm']                = (count($all_data) > 0)? $data->sum('jml_kasus_ptm') : 0;
        $array['jml_kasus_non_ptm']            = (count($all_data) > 0)? $data->sum('jml_kasus_non_ptm') : 0;
        $array['charta_5']                     = (count($all_data) > 0)? $data->sum('charta_5') : 0;
        $array['charta_5_10']                  = (count($all_data) > 0)? $data->sum('charta_5_10') : 0;
        $array['charta_10_20']                 = (count($all_data) > 0)? $data->sum('charta_10_20') : 0;
        $array['charta_20_30']                 = (count($all_data) > 0)? $data->sum('charta_20_30') : 0;
        $array['charta_30']                    = (count($all_data) > 0)? $data->sum('charta_30') : 0;
        $array['jml_dirujuk_rs']               = (count($all_data) > 0)? $data->sum('jml_dirujuk_rs') : 0;

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
                    $pandu = Pandu::where('puskesmas_id', $puskesmas->id)->where('periode', date('Y-m-d', strtotime('01-' . $req->periode)))->first();
                    // $pandu = Pandu::find($dec_id);
                    // return $pandu;
                    $pandu->user_id                = auth()->user()->id;
                    $pandu->puskesmas_id           = auth()->user()->puskesmas_id;

                    $pandu->jml_pasien_skrining    = $req->jml_pasien_skrining;
                    $pandu->jml_kasus_ptm          = $req->jml_kasus_ptm;
                    $pandu->jml_kasus_non_ptm      = $req->jml_kasus_non_ptm;
                    $pandu->charta_5               = $req->charta_5;
                    $pandu->charta_5_10            = $req->charta_5_10;
                    $pandu->charta_10_20           = $req->charta_10_20;
                    $pandu->charta_20_30           = $req->charta_20_30;
                    $pandu->charta_30              = $req->charta_30;
                    $pandu->jml_dirujuk_rs         = $req->jml_dirujuk_rs;
                    $pandu->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $pandu->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Pandu::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $pandu                         = new pandu;
                    $pandu->user_id                = auth()->user()->id;
                    $pandu->puskesmas_id           = auth()->user()->puskesmas_id;

                    $pandu->jml_pasien_skrining    = $req->jml_pasien_skrining;
                    $pandu->jml_kasus_ptm          = $req->jml_kasus_ptm;
                    $pandu->jml_kasus_non_ptm      = $req->jml_kasus_non_ptm;
                    $pandu->charta_5               = $req->charta_5;
                    $pandu->charta_5_10            = $req->charta_5_10;
                    $pandu->charta_10_20           = $req->charta_10_20;
                    $pandu->charta_20_30           = $req->charta_20_30;
                    $pandu->charta_30              = $req->charta_30;
                    $pandu->jml_dirujuk_rs         = $req->jml_dirujuk_rs;
                    $pandu->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $pandu->save();

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

                $pandu = Pandu::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $pandu;
                $periode = date('M-Y', strtotime($pandu->periode));
                $pandu->date_periode = $periode;

                // return response()->json(['data' => $ptm]);
                return view('ptm/deteksi_dini/pandu/form', compact('enc_id', 'puskesmas', 'pandu'));
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

                return view('template/deteksi/pandu/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
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

            return view('template/deteksi/pandu/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
        }
        // $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        // // return $dec_id;
        // if ($dec_id) {
        //     $query = Puskesmas::select('puskesmas.*');
        //     $query->where('puskesmas.id', auth()->user()->puskesmas_id);
        //     $puskesmas = $query->first();
        //     // return $puskesmas;

        //     $pandu = Pandu::find($dec_id);
        //     $periode = date('m-Y', strtotime($pandu->periode));
        //     $pandu->date_periode = $periode;

        //     // return response()->json(['data' => $ptm]);
        //     return view('ptm/deteksi_dini/pandu/form', compact('enc_id', 'puskesmas', 'pandu'));
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

                $pandu = Pandu::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $pandu;
                // return $pandu;
                if ($pandu->delete()) {
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


        if ($request->periode_start != '' && $request->periode_end != '') {
            $periode_start = date('Y-m-d', strtotime('01-' . $request->periode_start));
            $periode_end = date('Y-m-d', strtotime('01-' . $request->periode_end));
        } else {
            $periode_start = date('Y-m-d');
            $periode_end = date('Y-m-d');
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
            $all_data = Pandu::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data = Pandu::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data = Pandu::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        } else if ($request->user()->can('puskesmas.index')) {
            $dataquery = Puskesmas::select('id', 'name');
            $dataquery->where('id', auth()->user()->puskesmas_id);
            $dataquery->orderBy('name', 'ASC');

            $id_pusk = $dataquery->pluck('id');
            $all_data = Pandu::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
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

                    $result->jml_pasien_skrining        = $this->sum_data($all_data, 'jml_pasien_skrining', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_ptm              = $this->sum_data($all_data, 'jml_kasus_ptm', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_non_ptm          = $this->sum_data($all_data, 'jml_kasus_non_ptm', $result->id, $periode_start, $periode_end);
                    $result->charta_5                   = $this->sum_data($all_data, 'charta_5', $result->id, $periode_start, $periode_end);
                    $result->charta_5_10                = $this->sum_data($all_data, 'charta_5_10', $result->id, $periode_start, $periode_end);
                    $result->charta_10_20               = $this->sum_data($all_data, 'charta_10_20', $result->id, $periode_start, $periode_end);
                    $result->charta_20_30               = $this->sum_data($all_data, 'charta_20_30', $result->id, $periode_start, $periode_end);
                    $result->charta_30                  = $this->sum_data($all_data, 'charta_30', $result->id, $periode_start, $periode_end);
                    $result->jml_dirujuk_rs             = $this->sum_data($all_data, 'jml_dirujuk_rs', $result->id, $periode_start, $periode_end);
                }
                $enc_id = $this->safe_encode(Crypt::encryptString($resultt->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('dd_pandu.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('dd_pandu.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('dd_pandu.hapus')) {
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

                $resultt->jml_pasien_skrining              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_pasien_skrining'])->all();
                })->sum('jml_pasien_skrining');
                $resultt->jml_kasus_ptm               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_kasus_ptm'])->all();
                })->sum('jml_kasus_ptm');
                $resultt->jml_kasus_non_ptm          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_kasus_non_ptm'])->all();
                })->sum('jml_kasus_non_ptm');
                $resultt->charta_5          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['charta_5'])->all();
                })->sum('charta_5');
                $resultt->charta_5_10             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['charta_5_10'])->all();
                })->sum('charta_5_10');
                $resultt->charta_10_20             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['charta_10_20'])->all();
                })->sum('charta_10_20');
                $resultt->charta_20_30                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['charta_20_30'])->all();
                })->sum('charta_20_30');
                $resultt->charta_30                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['charta_30'])->all();
                })->sum('charta_30');
                $resultt->jml_dirujuk_rs                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_dirujuk_rs'])->all();
                })->sum('jml_dirujuk_rs');
            }
        } else {
            foreach ($data as $key => $result) {
                $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('dd_pandu.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('dd_pandu.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('dd_pandu.hapus')) {
                    $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
                }

                $action .= "</div>";

                // $result->no                     = $key + $page;
                $result->id                     = $result->id;
                $result->action                 = $action;

                if ($request->user()->can('kabupaten.index')) {
                    // $record = $this->get_data_record($result->id, $periode_start, $periode_end);
                    // return response()->json(['data' => $record]);
                    // $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
                    $result->puskesmas              = $result->name;

                    $result->jml_pasien_skrining        = $this->sum_data($all_data, 'jml_pasien_skrining', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_ptm              = $this->sum_data($all_data, 'jml_kasus_ptm', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_non_ptm          = $this->sum_data($all_data, 'jml_kasus_non_ptm', $result->id, $periode_start, $periode_end);
                    $result->charta_5                   = $this->sum_data($all_data, 'charta_5', $result->id, $periode_start, $periode_end);
                    $result->charta_5_10                = $this->sum_data($all_data, 'charta_5_10', $result->id, $periode_start, $periode_end);
                    $result->charta_10_20               = $this->sum_data($all_data, 'charta_10_20', $result->id, $periode_start, $periode_end);
                    $result->charta_20_30               = $this->sum_data($all_data, 'charta_20_30', $result->id, $periode_start, $periode_end);
                    $result->charta_30                  = $this->sum_data($all_data, 'charta_30', $result->id, $periode_start, $periode_end);
                    $result->jml_dirujuk_rs             = $this->sum_data($all_data, 'jml_dirujuk_rs', $result->id, $periode_start, $periode_end);
                } else if ($request->user()->can('puskesmas.index')) {
                    $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
                    $result->puskesmas              = $result->name;

                    $result->jml_pasien_skrining        = $this->sum_data($all_data, 'jml_pasien_skrining', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_ptm              = $this->sum_data($all_data, 'jml_kasus_ptm', $result->id, $periode_start, $periode_end);
                    $result->jml_kasus_non_ptm          = $this->sum_data($all_data, 'jml_kasus_non_ptm', $result->id, $periode_start, $periode_end);
                    $result->charta_5                   = $this->sum_data($all_data, 'charta_5', $result->id, $periode_start, $periode_end);
                    $result->charta_5_10                = $this->sum_data($all_data, 'charta_5_10', $result->id, $periode_start, $periode_end);
                    $result->charta_10_20               = $this->sum_data($all_data, 'charta_10_20', $result->id, $periode_start, $periode_end);
                    $result->charta_20_30               = $this->sum_data($all_data, 'charta_20_30', $result->id, $periode_start, $periode_end);
                    $result->charta_30                  = $this->sum_data($all_data, 'charta_30', $result->id, $periode_start, $periode_end);
                    $result->jml_dirujuk_rs             = $this->sum_data($all_data, 'jml_dirujuk_rs', $result->id, $periode_start, $periode_end);
                }
            }
        }

        $array['puskesmas']                    = $data->count();
        $array['jml_pasien_skrining']          = $data->sum('jml_pasien_skrining');
        $array['jml_kasus_ptm']                = $data->sum('jml_kasus_ptm');
        $array['jml_kasus_non_ptm']            = $data->sum('jml_kasus_non_ptm');
        $array['charta_5']                     = $data->sum('charta_5');
        $array['charta_5_10']                  = $data->sum('charta_5_10');
        $array['charta_10_20']                 = $data->sum('charta_10_20');
        $array['charta_20_30']                 = $data->sum('charta_20_30');
        $array['charta_30']                    = $data->sum('charta_30');
        $array['jml_dirujuk_rs']               = $data->sum('jml_dirujuk_rs');
        $array['action']                 = '';
        // return $data;
        $view = 'template/deteksi/pandu/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'dd_pandu.xlsx');
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
            'title'                 => 'pandu',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/deteksi/pandu/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-deteksi-dd_pandu.pdf');
    }
}
