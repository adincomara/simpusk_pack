<?php

namespace App\Http\Controllers\PTM;

use App\Exports\ExportExcel;
use App\Http\Controllers\Simpusk\Controller;
use App\Models\PTM\Balkesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\PTM\Puskesmas;
use App\Models\PTM\Kabupaten;
use App\Models\Kecamatan;
use App\Models\PTM\Provinsi;
use App\Models\PTM\Dd_fr_ptm_keswa;

use DB;
use Auth;
use Carbon;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class FrPtmKeswaController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        if (auth()->user()->can('provinsi.index')) {
            $kabupaten = Kabupaten::all();
        } elseif (auth()->user()->can('balkesmas.index')) {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->get();
        } else {
            $kabupaten = [];
        }

            $user = Puskesmas::find(auth()->user()->puskesmas_id);

        $start_date = date('M-Y');
        $end_date = date('M-Y');
        $data    = Puskesmas::select('id', 'name', 'kecamatan', 'kabupaten', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

        return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/index', compact('kabupaten', 'user', 'data', 'start_date', 'end_date'));
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
        $cek = Dd_fr_ptm_keswa::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function tambah()
    {
        $query = Puskesmas::select('*');
        $query->where('id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return response()->json($puskesmas);
        return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/form', compact('puskesmas', 'date_now'));
    }

    private function sum_data($array, $field, $puskesmas, $periode_start, $periode_end)
    {
        // $dataquery = Dd_fr_ptm_keswa::where('puskesmas_id', $puskesmas)
        //     ->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
        //     ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))
        //     ->sum($field);
        if(Gate::check('puskesmas.index')){
            $dataquery = collect($array)->where('puskesmas_id', $puskesmas)->where('periode',$periode_start)->map(function ($user) use ($field) {
                return collect($user->toArray())->only([$field])->all();
            })->sum($field);
        }else{
            $dataquery = collect($array)->where('puskesmas_id', $puskesmas)->map(function ($user) use ($field) {
                return collect($user->toArray())->only([$field])->all();
            })->sum($field);
        }


        return $dataquery;
    }

    private function get_data_record($puskesmas, $periode_start, $periode_end)
    {
        // $puskesmas  = Puskesmas::where();
        $dataquery = Dd_fr_ptm_keswa::where('puskesmas_id', $puskesmas)
            ->whereDate('dd_fr_ptm_keswa.periode', '>=', date('Y-m-d', strtotime($periode_start)))
            ->whereDate('dd_fr_ptm_keswa.periode', '<=', date('Y-m-d', strtotime($periode_end)))
            ->get();

        // $data = [];
        // foreach ($dataquery as $key => $value) {
        //     $data['jml_hadir']   =
        //     $data['jml_laki']    =
        //     $data['jml_perempuan']   =
        //     $data['usia_15_59']  =
        //     $data['usia_59'] =
        //     $data['cakupan_15_59']   =
        //     $data['cakupan_59']  =
        //     $data['sasaran_15_59']   =
        //     $data['sasaran_59']  =
        //     $data['diri_sendiri']    =
        //     $data['keluarga']    =
        //     $data['merokok'] =
        //     $data['aktifitas_fisik'] =
        //     $data['diet_tdk_seimbang']   =
        //     $data['konsumsi_alkohol']    =
        //     $data['td_tinggi']   =
        //     $data['obesitas']    =
        //     $data['lp_lebih']    =
        //     $data['gds_tinggi']  =
        //     $data['kolesterol_tinggi']   =
        //     $data['asam_urat_tinggi']    =
        //     $data['gangguan_penglihatan']    =
        //     $data['gangguan_pendengaran']    =
        //     $data['srw'] =
        //     $data['kie'] =
        //     $data['rujuk_fktp']  =
        // }


        return $data;
    }

    private function split_kabupaten($kabupaten)
    {
        $kabupaten_data = Kabupaten::find($kabupaten);
        $explode    = explode(" ", $kabupaten_data->name);
        $result = $explode[1];

        return $result;
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
            $all_data = Dd_fr_ptm_keswa::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
            // return $all_data;

        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();

        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            $action .= "";
            $action .= "<div class='btn-group'>";
            $array = array(
                'enc' => $enc_id,
                'start' => $periode_start,
                'end' => $periode_end
            );
            // $encode = json_encode($array);
            if(strtotime($periode_start) == strtotime($periode_end)){
                $action .= '<a href="' . route('dd_fr_ptm_keswa.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }


            $action .= "</div>";
            $result->no                     = $key + $page;
            $result->id                     = $result->id;
            $result->action                 = $action;
            $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
            $result->puskesmas              = $result->name;

            $result->jml_hadir              = $this->sum_data($all_data, 'jml_hadir', $result->id, $periode_start, $periode_end);
            $result->jml_laki               = $this->sum_data($all_data, 'jml_laki', $result->id, $periode_start, $periode_end);
            $result->jml_perempuan          = $this->sum_data($all_data, 'jml_perempuan', $result->id, $periode_start, $periode_end);
            $result->sasaran_15_59          = $this->sum_data($all_data, 'sasaran_15_59', $result->id, $periode_start, $periode_end);
            $result->sasaran_59             = $this->sum_data($all_data, 'sasaran_59', $result->id, $periode_start, $periode_end);
            $result->usia_15_59             = $this->sum_data($all_data, 'usia_15_59', $result->id, $periode_start, $periode_end);
            $result->usia_59                = $this->sum_data($all_data, 'usia_59', $result->id, $periode_start, $periode_end);
            $result->cakupan_15_59          = $this->sum_data($all_data, 'cakupan_15_59', $result->id, $periode_start, $periode_end);
            $result->cakupan_59             = $this->sum_data($all_data, 'cakupan_59', $result->id, $periode_start, $periode_end);
            $result->diri_sendiri           = $this->sum_data($all_data, 'diri_sendiri', $result->id, $periode_start, $periode_end);
            $result->keluarga               = $this->sum_data($all_data, 'keluarga', $result->id, $periode_start, $periode_end);
            $result->merokok                = $this->sum_data($all_data, 'merokok', $result->id, $periode_start, $periode_end);
            $result->aktifitas_fisik        = $this->sum_data($all_data, 'aktifitas_fisik', $result->id, $periode_start, $periode_end);
            $result->diet_tdk_seimbang      = $this->sum_data($all_data, 'diet_tdk_seimbang', $result->id, $periode_start, $periode_end);
            $result->konsumsi_alkohol       = $this->sum_data($all_data, 'konsumsi_alkohol', $result->id, $periode_start, $periode_end);
            $result->td_tinggi              = $this->sum_data($all_data, 'td_tinggi', $result->id, $periode_start, $periode_end);
            $result->obesitas               = $this->sum_data($all_data, 'obesitas', $result->id, $periode_start, $periode_end);
            $result->lp_lebih               = $this->sum_data($all_data, 'lp_lebih', $result->id, $periode_start, $periode_end);
            $result->gds_tinggi             = $this->sum_data($all_data, 'gds_tinggi', $result->id, $periode_start, $periode_end);
            $result->kolesterol_tinggi      = $this->sum_data($all_data, 'kolesterol_tinggi', $result->id, $periode_start, $periode_end);
            $result->asam_urat_tinggi       = $this->sum_data($all_data, 'asam_urat_tinggi', $result->id, $periode_start, $periode_end);
            $result->gangguan_penglihatan   = $this->sum_data($all_data, 'gangguan_penglihatan', $result->id, $periode_start, $periode_end);
            $result->gangguan_pendengaran   = $this->sum_data($all_data, 'gangguan_pendengaran', $result->id, $periode_start, $periode_end);
            $result->srw                    = $this->sum_data($all_data, 'srw', $result->id, $periode_start, $periode_end);
            $result->kie                    = $this->sum_data($all_data, 'kie', $result->id, $periode_start, $periode_end);
            $result->rujuk_fktp             = $this->sum_data($all_data, 'rujuk_fktp', $result->id, $periode_start, $periode_end);


            // return $data;
        }

        if(count($all_data) <= 0){
            $data = [];
        }
            $array['puskesmas']              = (count($data) > 0 )? $data->count() : 0;
            $array['jml_hadir']              = (count($data) > 0 )? $data->sum('jml_hadir') : 0;
            $array['jml_laki']               = (count($data) > 0 )? $data->sum('jml_laki') : 0;
            $array['jml_perempuan']          = (count($data) > 0 )? $data->sum('jml_perempuan') : 0;
            $array['sasaran_15_59']          = (count($data) > 0 )? $data->sum('sasaran_15_59') : 0;
            $array['sasaran_59']             = (count($data) > 0 )? $data->sum('sasaran_59') : 0;
            $array['usia_15_59']             = (count($data) > 0 )? $data->sum('usia_15_59') : 0;
            $array['usia_59']                = (count($data) > 0 )? $data->sum('usia_59') : 0;
            $array['cakupan_15_59']          = (count($data) > 0 )? $data->sum('cakupan_15_59') : 0;
            $array['cakupan_59']             = (count($data) > 0 )? $data->sum('cakupan_59') : 0;
            $array['diri_sendiri']           = (count($data) > 0 )? $data->sum('diri_sendiri') : 0;
            $array['keluarga']               = (count($data) > 0 )? $data->sum('keluarga') : 0;
            $array['merokok']                = (count($data) > 0 )? $data->sum('merokok') : 0;
            $array['aktifitas_fisik']        = (count($data) > 0 )? $data->sum('aktifitas_fisik') : 0;
            $array['diet_tdk_seimbang']      = (count($data) > 0 )? $data->sum('diet_tdk_seimbang') : 0;
            $array['konsumsi_alkohol']       = (count($data) > 0 )? $data->sum('konsumsi_alkohol') : 0;
            $array['td_tinggi']              = (count($data) > 0 )? $data->sum('td_tinggi') : 0;
            $array['obesitas']               = (count($data) > 0 )? $data->sum('obesitas') : 0;
            $array['lp_lebih']               = (count($data) > 0 )? $data->sum('lp_lebih') : 0;
            $array['gds_tinggi']             = (count($data) > 0 )? $data->sum('gds_tinggi') : 0;
            $array['kolesterol_tinggi']      = (count($data) > 0 )? $data->sum('kolesterol_tinggi') : 0;
            $array['asam_urat_tinggi']       = (count($data) > 0 )? $data->sum('asam_urat_tinggi') : 0;
            $array['gangguan_penglihatan']   = (count($data) > 0 )? $data->sum('gangguan_penglihatan') : 0;
            $array['gangguan_pendengaran']   = (count($data) > 0 )? $data->sum('gangguan_pendengaran') : 0;
            $array['srw']                    = (count($data) > 0 )? $data->sum('srw') : 0;
            $array['kie']                    = (count($data) > 0 )? $data->sum('kie') : 0;
            $array['rujuk_fktp']             = (count($data) > 0 )? $data->sum('rujuk_fktp') : 0;


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
                    $ptm_keswa = Dd_fr_ptm_keswa::where('puskesmas_id', $puskesmas->id)->where('periode', date('Y-m-d', strtotime('01-' . $req->periode)))->first();
                    // $ptm_keswa = Dd_fr_ptm_keswa::find($dec_id);
                    // return $ptm_keswa;
                    $ptm_keswa->user_id                = auth()->user()->id;
                    $ptm_keswa->puskesmas_id           = auth()->user()->puskesmas_id;
                    $ptm_keswa->jml_hadir              = $req->jml_hadir;
                    $ptm_keswa->jml_laki               = $req->jml_laki;
                    $ptm_keswa->jml_perempuan          = $req->jml_perempuan;
                    $ptm_keswa->sasaran_15_59          = $req->sasaran_15_59;
                    $ptm_keswa->sasaran_59             = $req->sasaran_59;
                    $ptm_keswa->usia_15_59             = $req->usia_15_59;
                    $ptm_keswa->usia_59                = $req->usia_59;
                    $ptm_keswa->cakupan_15_59          = $req->cakupan_15_59;
                    $ptm_keswa->cakupan_59             = $req->cakupan_59;
                    $ptm_keswa->diri_sendiri           = $req->diri_sendiri;
                    $ptm_keswa->keluarga               = $req->keluarga;
                    $ptm_keswa->merokok                = $req->merokok;
                    $ptm_keswa->aktifitas_fisik        = $req->aktifitas_fisik;
                    $ptm_keswa->diet_tdk_seimbang      = $req->diet_tdk_seimbang;
                    $ptm_keswa->konsumsi_alkohol       = $req->konsumsi_alkohol;
                    $ptm_keswa->td_tinggi              = $req->td_tinggi;
                    $ptm_keswa->obesitas               = $req->obesitas;
                    $ptm_keswa->lp_lebih               = $req->lp_lebih;
                    $ptm_keswa->gds_tinggi             = $req->gds_tinggi;
                    $ptm_keswa->kolesterol_tinggi      = $req->kolesterol_tinggi;
                    $ptm_keswa->asam_urat_tinggi       = $req->asam_urat_tinggi;
                    $ptm_keswa->gangguan_penglihatan   = $req->gangguan_penglihatan;
                    $ptm_keswa->gangguan_pendengaran   = $req->gangguan_pendengaran;
                    $ptm_keswa->srw                    = $req->srw;
                    $ptm_keswa->kie                    = $req->kie;
                    $ptm_keswa->rujuk_fktp             = $req->rujuk_fktp;
                    $ptm_keswa->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $ptm_keswa->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Dd_fr_ptm_keswa::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $ptm_keswa                         = new Dd_fr_ptm_keswa;
                    $ptm_keswa->user_id                = auth()->user()->id;
                    $ptm_keswa->puskesmas_id           = auth()->user()->puskesmas_id;
                    $ptm_keswa->jml_hadir              = $req->jml_hadir;
                    $ptm_keswa->jml_laki               = $req->jml_laki;
                    $ptm_keswa->jml_perempuan          = $req->jml_perempuan;
                    $ptm_keswa->sasaran_15_59          = $req->sasaran_15_59;
                    $ptm_keswa->sasaran_59             = $req->sasaran_59;
                    $ptm_keswa->usia_15_59             = $req->usia_15_59;
                    $ptm_keswa->usia_59                = $req->usia_59;
                    $ptm_keswa->cakupan_15_59          = $req->cakupan_15_59;
                    $ptm_keswa->cakupan_59             = $req->cakupan_59;
                    $ptm_keswa->diri_sendiri           = $req->diri_sendiri;
                    $ptm_keswa->keluarga               = $req->keluarga;
                    $ptm_keswa->merokok                = $req->merokok;
                    $ptm_keswa->aktifitas_fisik        = $req->aktifitas_fisik;
                    $ptm_keswa->diet_tdk_seimbang      = $req->diet_tdk_seimbang;
                    $ptm_keswa->konsumsi_alkohol       = $req->konsumsi_alkohol;
                    $ptm_keswa->td_tinggi              = $req->td_tinggi;
                    $ptm_keswa->obesitas               = $req->obesitas;
                    $ptm_keswa->lp_lebih               = $req->lp_lebih;
                    $ptm_keswa->gds_tinggi             = $req->gds_tinggi;
                    $ptm_keswa->kolesterol_tinggi      = $req->kolesterol_tinggi;
                    $ptm_keswa->asam_urat_tinggi       = $req->asam_urat_tinggi;
                    $ptm_keswa->gangguan_penglihatan   = $req->gangguan_penglihatan;
                    $ptm_keswa->gangguan_pendengaran   = $req->gangguan_pendengaran;
                    $ptm_keswa->srw                    = $req->srw;
                    $ptm_keswa->kie                    = $req->kie;
                    $ptm_keswa->rujuk_fktp             = $req->rujuk_fktp;
                    $ptm_keswa->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $ptm_keswa->save();

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

                $ptm_keswa = Dd_fr_ptm_keswa::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $ptm_keswa;
                $periode = date('M-Y', strtotime($ptm_keswa->periode));
                $ptm_keswa->date_periode = $periode;

                // return response()->json(['data' => $ptm]);
                return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/form', compact('enc_id', 'puskesmas', 'ptm_keswa'));
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

                return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/form', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
            }
        } else {

                $user = Puskesmas::find(auth()->user()->puskesmas_id);

            $start_date = date('M-Y', strtotime('-1 Months'));
            $end_date = date('M-Y');
            $data    = Puskesmas::select('id', 'name', 'kecamatan', 'provinsi')->where('id', auth()->user()->puskesmas_id)->first();

            return view('ptm/deteksi_dini/faktor_risiko_ptm_keswa/form', compact('user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
        }
        // $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        // // return $dec_id;
        // if ($dec_id) {
        //     $query = Puskesmas::select('puskesmas.*');
        //     $query->where('puskesmas.id', auth()->user()->puskesmas_id);
        //     $puskesmas = $query->first();
        //     // return $puskesmas;

        //     $ptm_keswa = Dd_fr_ptm_keswa::find($dec_id);
        //     $periode = date('m-Y', strtotime($ptm_keswa->periode));
        //     $ptm_keswa->date_periode = $periode;

        //     // return response()->json(['data' => $ptm]);
        //     return view('template/deteksi/keswa/form', compact('enc_id', 'puskesmas', 'ptm_keswa'));
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

                $ptm_keswa = Dd_fr_ptm_keswa::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $ptm_keswa;
                // return $ptm_keswa;
                if ($ptm_keswa->delete()) {
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

        // return $request->all();
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
            $all_data = Dd_fr_ptm_keswa::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data = Dd_fr_ptm_keswa::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data = Dd_fr_ptm_keswa::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        } else if ($request->user()->can('puskesmas.index')) {
            $dataquery = Puskesmas::select('id', 'name');
            $dataquery->where('id', auth()->user()->puskesmas_id);
            $dataquery->orderBy('name', 'ASC');

            $id_pusk = $dataquery->pluck('id');
            $all_data = Dd_fr_ptm_keswa::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
            // return $all_data;
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
                    $result->jml_hadir              = $this->sum_data($all_data, 'jml_hadir', $result->id, $periode_start, $periode_end);
                    $result->jml_laki               = $this->sum_data($all_data, 'jml_laki', $result->id, $periode_start, $periode_end);
                    $result->jml_perempuan          = $this->sum_data($all_data, 'jml_perempuan', $result->id, $periode_start, $periode_end);
                    $result->sasaran_15_59          = $this->sum_data($all_data, 'usia_15_59', $result->id, $periode_start, $periode_end);
                    $result->sasaran_59             = $this->sum_data($all_data, 'usia_59', $result->id, $periode_start, $periode_end);
                    $result->usia_15_59             = $this->sum_data($all_data, 'cakupan_15_59', $result->id, $periode_start, $periode_end);
                    $result->usia_59                = $this->sum_data($all_data, 'cakupan_59', $result->id, $periode_start, $periode_end);
                    $result->cakupan_15_59          = $this->sum_data($all_data, 'sasaran_15_59', $result->id, $periode_start, $periode_end);
                    $result->cakupan_59             = $this->sum_data($all_data, 'sasaran_59', $result->id, $periode_start, $periode_end);
                    $result->diri_sendiri           = $this->sum_data($all_data, 'diri_sendiri', $result->id, $periode_start, $periode_end);
                    $result->keluarga               = $this->sum_data($all_data, 'keluarga', $result->id, $periode_start, $periode_end);
                    $result->merokok                = $this->sum_data($all_data, 'merokok', $result->id, $periode_start, $periode_end);
                    $result->aktifitas_fisik        = $this->sum_data($all_data, 'aktifitas_fisik', $result->id, $periode_start, $periode_end);
                    $result->diet_tdk_seimbang      = $this->sum_data($all_data, 'diet_tdk_seimbang', $result->id, $periode_start, $periode_end);
                    $result->konsumsi_alkohol       = $this->sum_data($all_data, 'konsumsi_alkohol', $result->id, $periode_start, $periode_end);
                    $result->td_tinggi              = $this->sum_data($all_data, 'td_tinggi', $result->id, $periode_start, $periode_end);
                    $result->obesitas               = $this->sum_data($all_data, 'obesitas', $result->id, $periode_start, $periode_end);
                    $result->lp_lebih               = $this->sum_data($all_data, 'lp_lebih', $result->id, $periode_start, $periode_end);
                    $result->gds_tinggi             = $this->sum_data($all_data, 'gds_tinggi', $result->id, $periode_start, $periode_end);
                    $result->kolesterol_tinggi      = $this->sum_data($all_data, 'kolesterol_tinggi', $result->id, $periode_start, $periode_end);
                    $result->asam_urat_tinggi       = $this->sum_data($all_data, 'asam_urat_tinggi', $result->id, $periode_start, $periode_end);
                    $result->gangguan_penglihatan   = $this->sum_data($all_data, 'gangguan_penglihatan', $result->id, $periode_start, $periode_end);
                    $result->gangguan_pendengaran   = $this->sum_data($all_data, 'gangguan_pendengaran', $result->id, $periode_start, $periode_end);
                    $result->srw                    = $this->sum_data($all_data, 'srw', $result->id, $periode_start, $periode_end);
                    $result->kie                    = $this->sum_data($all_data, 'kie', $result->id, $periode_start, $periode_end);
                    $result->rujuk_fktp             = $this->sum_data($all_data, 'rujuk_fktp', $result->id, $periode_start, $periode_end);
                }
                $enc_id = $this->safe_encode(Crypt::encryptString($resultt->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('keswa.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('keswa.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('keswa.hapus')) {
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
                $resultt->jml_hadir              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_hadir'])->all();
                })->sum('jml_hadir');
                $resultt->jml_laki               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_laki'])->all();
                })->sum('jml_laki');
                $resultt->jml_perempuan          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_perempuan'])->all();
                })->sum('jml_perempuan');
                $resultt->sasaran_15_59          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['usia_15_59'])->all();
                })->sum('usia_15_59');
                $resultt->sasaran_59             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['usia_59'])->all();
                })->sum('usia_59');
                $resultt->usia_15_59             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['cakupan_15_59'])->all();
                })->sum('cakupan_15_59');
                $resultt->usia_59                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['cakupan_59'])->all();
                })->sum('cakupan_59');
                $resultt->cakupan_15_59          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['sasaran_15_59'])->all();
                })->sum('sasaran_15_59');
                $resultt->cakupan_59             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['sasaran_59'])->all();
                })->sum('sasaran_59');
                $resultt->diri_sendiri           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['diri_sendiri'])->all();
                })->sum('diri_sendiri');
                $resultt->keluarga               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['keluarga'])->all();
                })->sum('keluarga');
                $resultt->merokok                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['merokok'])->all();
                })->sum('merokok');
                $resultt->aktifitas_fisik        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['aktifitas_fisik'])->all();
                })->sum('aktifitas_fisik');
                $resultt->diet_tdk_seimbang      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['diet_tdk_seimbang'])->all();
                })->sum('diet_tdk_seimbang');
                $resultt->konsumsi_alkohol       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['konsumsi_alkohol'])->all();
                })->sum('konsumsi_alkohol');
                $resultt->td_tinggi              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['td_tinggi'])->all();
                })->sum('td_tinggi');
                $resultt->obesitas               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['obesitas'])->all();
                })->sum('obesitas');
                $resultt->lp_lebih               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['lp_lebih'])->all();
                })->sum('lp_lebih');
                $resultt->gds_tinggi             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['gds_tinggi'])->all();
                })->sum('gds_tinggi');
                $resultt->kolesterol_tinggi      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kolesterol_tinggi'])->all();
                })->sum('kolesterol_tinggi');
                $resultt->asam_urat_tinggi       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['asam_urat_tinggi'])->all();
                })->sum('asam_urat_tinggi');
                $resultt->gangguan_penglihatan   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['gangguan_penglihatan'])->all();
                })->sum('gangguan_penglihatan');
                $resultt->gangguan_pendengaran   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['gangguan_pendengaran'])->all();
                })->sum('gangguan_pendengaran');
                $resultt->srw                    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['srw'])->all();
                })->sum('srw');
                $resultt->kie                    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kie'])->all();
                })->sum('kie');
                $resultt->rujuk_fktp             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['rujuk_fktp'])->all();
                })->sum('rujuk_fktp');
            }
        } else {
            if(auth()->user()->can('puskesmas.index')){
                $awal  = date_create($periode_start);
                $akhir  = date_create($periode_end);
                // $akhir = date_create(); // waktu sekarang
                $diff  = date_diff( $awal, $akhir );
                $json = [];
                for($i=0;$i<=$diff->m;$i++){
                    $start = date('Y-m-d', strtotime($periode_start.' first day of +'.$i.' month'));
                    // return $start;
                    $json[$i]['periode']              = date('M-Y', strtotime($periode_start)) . ' - ' . date('M-Y', strtotime($periode_end));
                    $json[$i]['puskesmas']              = $dataquery->first()['name'];
                    $json[$i]['bulan']                  = date('M-Y', strtotime($periode_start.' first day of +'.$i.' month'));
                    $json[$i]['jml_hadir']              = $this->sum_data($all_data, 'jml_hadir', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['jml_laki']               = $this->sum_data($all_data, 'jml_laki', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['jml_perempuan']          = $this->sum_data($all_data, 'jml_perempuan', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['sasaran_15_59']          = $this->sum_data($all_data, 'usia_15_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['sasaran_59']             = $this->sum_data($all_data, 'usia_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['usia_15_59']             = $this->sum_data($all_data, 'cakupan_15_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['usia_59']                = $this->sum_data($all_data, 'cakupan_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['cakupan_15_59']          = $this->sum_data($all_data, 'sasaran_15_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['cakupan_59']             = $this->sum_data($all_data, 'sasaran_59', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['diri_sendiri']           = $this->sum_data($all_data, 'diri_sendiri', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['keluarga']               = $this->sum_data($all_data, 'keluarga', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['merokok']                = $this->sum_data($all_data, 'merokok', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['aktifitas_fisik']        = $this->sum_data($all_data, 'aktifitas_fisik', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['diet_tdk_seimbang']      = $this->sum_data($all_data, 'diet_tdk_seimbang', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['konsumsi_alkohol']       = $this->sum_data($all_data, 'konsumsi_alkohol', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['td_tinggi']              = $this->sum_data($all_data, 'td_tinggi', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['obesitas']               = $this->sum_data($all_data, 'obesitas', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['lp_lebih']               = $this->sum_data($all_data, 'lp_lebih', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['gds_tinggi']             = $this->sum_data($all_data, 'gds_tinggi', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['kolesterol_tinggi']      = $this->sum_data($all_data, 'kolesterol_tinggi', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['asam_urat_tinggi']       = $this->sum_data($all_data, 'asam_urat_tinggi', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['gangguan_penglihatan']   = $this->sum_data($all_data, 'gangguan_penglihatan', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['gangguan_pendengaran']   = $this->sum_data($all_data, 'gangguan_pendengaran', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['srw']                    = $this->sum_data($all_data, 'srw', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['kie']                    = $this->sum_data($all_data, 'kie', auth()->user()->puskesmas_id, $start, $start);
                    $json[$i]['rujuk_fktp']             = $this->sum_data($all_data, 'rujuk_fktp', auth()->user()->puskesmas_id, $start, $start);
                }
                // return $json;
                $data = $json;
            }else{
                foreach ($data as $key => $result) {
                    $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
                    $action = "";
                    $action .= "";
                    $action .= "<div class='btn-group'>";
                    if ($request->user()->can('keswa.ubah')) {
                        $array = array(
                            'enc' => $enc_id,
                            'start' => $periode_start,
                            'end' => $periode_end
                        );
                        $action .= '<a href="' . route('keswa.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                    }

                    if ($request->user()->can('keswa.hapus')) {
                        $action .= '<a href="#" onclick="deleteData(this,\'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end'] . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
                    }

                    $action .= "</div>";
                    $result->id                     = $result->id;
                    $result->action                 = $action;

                    if ($request->user()->can('kabupaten.index')) {
                        $result->puskesmas              = $result->name;
                        $result->jml_hadir              = $this->sum_data($all_data, 'jml_hadir', $result->id, $periode_start, $periode_end);
                        $result->jml_laki               = $this->sum_data($all_data, 'jml_laki', $result->id, $periode_start, $periode_end);
                        $result->jml_perempuan          = $this->sum_data($all_data, 'jml_perempuan', $result->id, $periode_start, $periode_end);
                        $result->sasaran_15_59          = $this->sum_data($all_data, 'usia_15_59', $result->id, $periode_start, $periode_end);
                        $result->sasaran_59             = $this->sum_data($all_data, 'usia_59', $result->id, $periode_start, $periode_end);
                        $result->usia_15_59             = $this->sum_data($all_data, 'cakupan_15_59', $result->id, $periode_start, $periode_end);
                        $result->usia_59                = $this->sum_data($all_data, 'cakupan_59', $result->id, $periode_start, $periode_end);
                        $result->cakupan_15_59          = $this->sum_data($all_data, 'sasaran_15_59', $result->id, $periode_start, $periode_end);
                        $result->cakupan_59             = $this->sum_data($all_data, 'sasaran_59', $result->id, $periode_start, $periode_end);
                        $result->diri_sendiri           = $this->sum_data($all_data, 'diri_sendiri', $result->id, $periode_start, $periode_end);
                        $result->keluarga               = $this->sum_data($all_data, 'keluarga', $result->id, $periode_start, $periode_end);
                        $result->merokok                = $this->sum_data($all_data, 'merokok', $result->id, $periode_start, $periode_end);
                        $result->aktifitas_fisik        = $this->sum_data($all_data, 'aktifitas_fisik', $result->id, $periode_start, $periode_end);
                        $result->diet_tdk_seimbang      = $this->sum_data($all_data, 'diet_tdk_seimbang', $result->id, $periode_start, $periode_end);
                        $result->konsumsi_alkohol       = $this->sum_data($all_data, 'konsumsi_alkohol', $result->id, $periode_start, $periode_end);
                        $result->td_tinggi              = $this->sum_data($all_data, 'td_tinggi', $result->id, $periode_start, $periode_end);
                        $result->obesitas               = $this->sum_data($all_data, 'obesitas', $result->id, $periode_start, $periode_end);
                        $result->lp_lebih               = $this->sum_data($all_data, 'lp_lebih', $result->id, $periode_start, $periode_end);
                        $result->gds_tinggi             = $this->sum_data($all_data, 'gds_tinggi', $result->id, $periode_start, $periode_end);
                        $result->kolesterol_tinggi      = $this->sum_data($all_data, 'kolesterol_tinggi', $result->id, $periode_start, $periode_end);
                        $result->asam_urat_tinggi       = $this->sum_data($all_data, 'asam_urat_tinggi', $result->id, $periode_start, $periode_end);
                        $result->gangguan_penglihatan   = $this->sum_data($all_data, 'gangguan_penglihatan', $result->id, $periode_start, $periode_end);
                        $result->gangguan_pendengaran   = $this->sum_data($all_data, 'gangguan_pendengaran', $result->id, $periode_start, $periode_end);
                        $result->srw                    = $this->sum_data($all_data, 'srw', $result->id, $periode_start, $periode_end);
                        $result->kie                    = $this->sum_data($all_data, 'kie', $result->id, $periode_start, $periode_end);
                        $result->rujuk_fktp             = $this->sum_data($all_data, 'rujuk_fktp', $result->id, $periode_start, $periode_end);
                    }
                }
            }
        }

        $array['puskesmas']              = count($data);
        $array['jml_hadir']              = collect($data)->sum('jml_hadir');
        $array['jml_laki']               = collect($data)->sum('jml_laki');
        $array['jml_perempuan']          = collect($data)->sum('jml_perempuan');
        $array['sasaran_15_59']          = collect($data)->sum('usia_15_59');
        $array['sasaran_59']             = collect($data)->sum('usia_59');
        $array['usia_15_59']             = collect($data)->sum('cakupan_15_59');
        $array['usia_59']                = collect($data)->sum('cakupan_59');
        $array['cakupan_15_59']          = collect($data)->sum('sasaran_15_59');
        $array['cakupan_59']             = collect($data)->sum('sasaran_59');
        $array['diri_sendiri']           = collect($data)->sum('diri_sendiri');
        $array['keluarga']               = collect($data)->sum('keluarga');
        $array['merokok']                = collect($data)->sum('merokok');
        $array['aktifitas_fisik']        = collect($data)->sum('aktifitas_fisik');
        $array['diet_tdk_seimbang']      = collect($data)->sum('diet_tdk_seimbang');
        $array['konsumsi_alkohol']       = collect($data)->sum('konsumsi_alkohol');
        $array['td_tinggi']              = collect($data)->sum('td_tinggi');
        $array['obesitas']               = collect($data)->sum('obesitas');
        $array['lp_lebih']               = collect($data)->sum('lp_lebih');
        $array['gds_tinggi']             = collect($data)->sum('gds_tinggi');
        $array['kolesterol_tinggi']      = collect($data)->sum('kolesterol_tinggi');
        $array['asam_urat_tinggi']       = collect($data)->sum('asam_urat_tinggi');
        $array['gangguan_penglihatan']   = collect($data)->sum('gangguan_penglihatan');
        $array['gangguan_pendengaran']   = collect($data)->sum('gangguan_pendengaran');
        $array['srw']                    = collect($data)->sum('srw');
        $array['kie']                    = collect($data)->sum('kie');
        $array['rujuk_fktp']             = collect($data)->sum('rujuk_fktp');
        $array['action']                 = '';
        // return $data;
        $view = 'template/deteksi/keswa/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'DeteksiDiniKeswa.xlsx');
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
            'title'                 => 'Data Deteksi Dini Faktor Risiko PTM dan Keswa',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/deteksi/keswa/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-deteksi-dini-faktor-risiko-ptm-dan-keswa.pdf');
    }
}
