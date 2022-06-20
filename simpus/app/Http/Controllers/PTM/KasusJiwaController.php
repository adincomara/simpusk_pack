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
use App\Models\Kasus_ptm;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\PTM\Rekap_gangguan_jiwa;

use DB;
use Auth;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KasusJiwaController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {

        $date_now = date('M-Y');
        $user = Puskesmas::find(auth()->user()->puskesmas_id);
        return view('ptm/kasus/jiwa/index', compact('user', 'date_now'));
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
        $cek = Rekap_gangguan_jiwa::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    private function get_data_record($rekap_jiwa, $puskesmas, $periode)
    {
        // $puskesmas  = Puskesmas::where();
        // $dataquery = Rekap_gangguan_jiwa::select('*')->where('puskesmas_id', $puskesmas)->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->first();
        $dataquery = collect($rekap_jiwa)->where('puskesmas_id', $puskesmas)->first();
        return $dataquery;
    }


    public function getData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $page  = $start + 1;
        $search = $request->search['value'];


        if ($request->periode != '') {
            $periode = date('Y-m-d', strtotime('01-' . $request->periode));
        } else {
            $periode = date('Y-m-d');
        }
        $all_rekap_gangguan_jiwa = Rekap_gangguan_jiwa::select('*')->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->get();

        $dataquery = Rekap_gangguan_jiwa::select('ptm_rekap_gangguan_jiwa.*', 'ptm_puskesmas.name as puskesmas');
        $dataquery->leftJoin('ptm_puskesmas', 'ptm_puskesmas.id', 'ptm_rekap_gangguan_jiwa.puskesmas_id');
        $dataquery->where('ptm_rekap_gangguan_jiwa.puskesmas_id', auth()->user()->puskesmas_id);

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('ptm_rekap_gangguan_jiwa.id', 'ASC');
        }

        if ($request->periode != null) {
            $dataquery->whereMonth('ptm_rekap_gangguan_jiwa.periode', date('m', strtotime($periode)))->whereYear('ptm_rekap_gangguan_jiwa.periode', date('Y', strtotime($periode)));
        }

        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();

        $dataquery->limit($limit);
        $dataquery->offset($start);
        $data = $dataquery->get();
        foreach ($data as $key => $result) {
            $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
            $action = "";

            // if ($request->user()->can('ptm.index')) {
            //     $record = $this->get_data_record($all_rekap_gangguan_jiwa, $result->id, $periode);
            // }
            $action .= "";

            $action .= "<div class='btn-group'>";
            $action .= '<a href="' . route('kasus_jiwa.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';


            $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';


            $action .= "</div>";

            $result->no                   = $key + $page;
            $result->id                   = $result->id;
            $result->action               = $action;

            $result->puskesmas                         = $result->puskesmas;
            $result->demensia_l                        = $result->demensia_l;
            $result->demensia_p                        = $result->demensia_p;
            $result->g_ansietas_0_14_l                 = $result->g_ansietas_0_14_l;
            $result->g_ansietas_0_14_p                 = $result->g_ansietas_0_14_p;
            $result->g_ansietas_15_59_l                = $result->g_ansietas_15_59_l;
            $result->g_ansietas_15_59_p                = $result->g_ansietas_15_59_p;
            $result->g_ansietas_60_l                   = $result->g_ansietas_60_l;
            $result->g_ansietas_60_p                   = $result->g_ansietas_60_p;
            $result->g_ansietas_depresi_0_14_l         = $result->g_ansietas_depresi_0_14_l;
            $result->g_ansietas_depresi_0_14_p         = $result->g_ansietas_depresi_0_14_p;
            $result->g_ansietas_depresi_15_59_l        = $result->g_ansietas_depresi_15_59_l;
            $result->g_ansietas_depresi_15_59_p        = $result->g_ansietas_depresi_15_59_p;
            $result->g_ansietas_depresi_60_l           = $result->g_ansietas_depresi_60_l;
            $result->g_ansietas_depresi_60_p           = $result->g_ansietas_depresi_60_p;
            $result->g_depresi_0_14_l                  = $result->g_depresi_0_14_l;
            $result->g_depresi_0_14_p                  = $result->g_depresi_0_14_p;
            $result->g_depresi_15_59_l                 = $result->g_depresi_15_59_l;
            $result->g_depresi_15_59_p                 = $result->g_depresi_15_59_p;
            $result->g_depresi_60_l                    = $result->g_depresi_60_l;
            $result->g_depresi_60_p                    = $result->g_depresi_60_p;
            $result->g_penyalahgunaan_napza_0_14_l     = $result->g_penyalahgunaan_napza_0_14_l;
            $result->g_penyalahgunaan_napza_0_14_p     = $result->g_penyalahgunaan_napza_0_14_p;
            $result->g_penyalahgunaan_napza_15_59_l    = $result->g_penyalahgunaan_napza_15_59_l;
            $result->g_penyalahgunaan_napza_15_59_p    = $result->g_penyalahgunaan_napza_15_59_p;
            $result->g_penyalahgunaan_napza_60_l       = $result->g_penyalahgunaan_napza_60_l;
            $result->g_penyalahgunaan_napza_60_p       = $result->g_penyalahgunaan_napza_60_p;
            $result->g_anak_remaja_0_14_l              = $result->g_anak_remaja_0_14_l;
            $result->g_anak_remaja_0_14_p              = $result->g_anak_remaja_0_14_p;
            $result->g_anak_remaja_15_59_l             = $result->g_anak_remaja_15_59_l;
            $result->g_anak_remaja_15_59_p             = $result->g_anak_remaja_15_59_p;
            $result->g_anak_remaja_60_l                = $result->g_anak_remaja_60_l;
            $result->g_anak_remaja_60_p                = $result->g_anak_remaja_60_p;
            $result->g_psikotik_akut_0_14_l            = $result->g_psikotik_akut_0_14_l;
            $result->g_psikotik_akut_0_14_p            = $result->g_psikotik_akut_0_14_p;
            $result->g_psikotik_akut_15_59_l           = $result->g_psikotik_akut_15_59_l;
            $result->g_psikotik_akut_15_59_p           = $result->g_psikotik_akut_15_59_p;
            $result->g_psikotik_akut_60_l              = $result->g_psikotik_akut_60_l;
            $result->g_psikotik_akut_60_p              = $result->g_psikotik_akut_60_p;
            $result->skizofrenia_0_14_l                = $result->skizofrenia_0_14_l;
            $result->skizofrenia_0_14_p                = $result->skizofrenia_0_14_p;
            $result->skizofrenia_15_59_l               = $result->skizofrenia_15_59_l;
            $result->skizofrenia_15_59_p               = $result->skizofrenia_15_59_p;
            $result->skizofrenia_60_l                  = $result->skizofrenia_60_l;
            $result->skizofrenia_60_p                  = $result->skizofrenia_60_p;
            $result->g_somatoform_0_14_l               = $result->g_somatoform_0_14_l;
            $result->g_somatoform_0_14_p               = $result->g_somatoform_0_14_p;
            $result->g_somatoform_15_59_l              = $result->g_somatoform_15_59_l;
            $result->g_somatoform_15_59_p              = $result->g_somatoform_15_59_p;
            $result->g_somatoform_60_l                 = $result->g_somatoform_60_l;
            $result->g_somatoform_60_p                 = $result->g_somatoform_60_p;
            $result->insomnia_0_14_l                   = $result->insomnia_0_14_l;
            $result->insomnia_0_14_p                   = $result->insomnia_0_14_p;
            $result->insomnia_15_59_l                  = $result->insomnia_15_59_l;
            $result->insomnia_15_59_p                  = $result->insomnia_15_59_p;
            $result->insomnia_60_l                     = $result->insomnia_60_l;
            $result->insomnia_60_p                     = $result->insomnia_60_p;
            $result->percobaan_bunuh_diri_0_14_l       = $result->percobaan_bunuh_diri_0_14_l;
            $result->percobaan_bunuh_diri_0_14_p       = $result->percobaan_bunuh_diri_0_14_p;
            $result->percobaan_bunuh_diri_15_59_l      = $result->percobaan_bunuh_diri_15_59_l;
            $result->percobaan_bunuh_diri_15_59_p      = $result->percobaan_bunuh_diri_15_59_p;
            $result->percobaan_bunuh_diri_60_l         = $result->percobaan_bunuh_diri_60_l;
            $result->percobaan_bunuh_diri_60_p         = $result->percobaan_bunuh_diri_60_p;
            $result->redartasi_mental_0_14_l           = $result->redartasi_mental_0_14_l;
            $result->redartasi_mental_0_14_p           = $result->redartasi_mental_0_14_p;
            $result->redartasi_mental_15_59_l          = $result->redartasi_mental_15_59_l;
            $result->redartasi_mental_15_59_p          = $result->redartasi_mental_15_59_p;
            $result->redartasi_mental_60_l             = $result->redartasi_mental_60_l;
            $result->redartasi_mental_60_p             = $result->redartasi_mental_60_p;
            $result->g_kepribadian_perilaku_0_14_l     = $result->g_kepribadian_perilaku_0_14_l;
            $result->g_kepribadian_perilaku_0_14_p     = $result->g_kepribadian_perilaku_0_14_p;
            $result->g_kepribadian_perilaku_15_59_l    = $result->g_kepribadian_perilaku_15_59_l;
            $result->g_kepribadian_perilaku_15_59_p    = $result->g_kepribadian_perilaku_15_59_p;
            $result->g_kepribadian_perilaku_60_l       = $result->g_kepribadian_perilaku_60_l;
            $result->g_kepribadian_perilaku_60_p       = $result->g_kepribadian_perilaku_60_p;
            $result->jumlah_kasus                      = $result->jumlah_kasus;
        }
        $array["puskesmas"] = $data->count();
        $array["demensia_l"] = $data->sum('demensia_l');
        $array["demensia_p"] = $data->sum('demensia_p');
        $array["g_ansietas_0_14_l"] = $data->sum('g_ansietas_0_14_l');
        $array["g_ansietas_0_14_p"] = $data->sum('g_ansietas_0_14_p');
        $array["g_ansietas_15_59_l"] = $data->sum('g_ansietas_15_59_l');
        $array["g_ansietas_15_59_p"] = $data->sum('g_ansietas_15_59_p');
        $array["g_ansietas_60_l"] = $data->sum('g_ansietas_60_l');
        $array["g_ansietas_60_p"] = $data->sum('g_ansietas_60_p');
        $array["g_ansietas_depresi_0_14_l"] = $data->sum('g_ansietas_depresi_0_14_l');
        $array["g_ansietas_depresi_0_14_p"] = $data->sum('g_ansietas_depresi_0_14_p');
        $array["g_ansietas_depresi_15_59_l"] = $data->sum('g_ansietas_depresi_15_59_l');
        $array["g_ansietas_depresi_15_59_p"] = $data->sum('g_ansietas_depresi_15_59_p');
        $array["g_ansietas_depresi_60_l"] = $data->sum('g_ansietas_depresi_60_l');
        $array["g_ansietas_depresi_60_p"] = $data->sum('g_ansietas_depresi_60_p');
        $array["g_depresi_0_14_l"] = $data->sum('g_depresi_0_14_l');
        $array["g_depresi_0_14_p"] = $data->sum('g_depresi_0_14_p');
        $array["g_depresi_15_59_l"] = $data->sum('g_depresi_15_59_l');
        $array["g_depresi_15_59_p"] = $data->sum('g_depresi_15_59_p');
        $array["g_depresi_60_l"] = $data->sum('g_depresi_60_l');
        $array["g_depresi_60_p"] = $data->sum('g_depresi_60_p');
        $array["g_penyalahgunaan_napza_0_14_l"] = $data->sum('g_penyalahgunaan_napza_0_14_l');
        $array["g_penyalahgunaan_napza_0_14_p"] = $data->sum('g_penyalahgunaan_napza_0_14_p');
        $array["g_penyalahgunaan_napza_15_59_l"] = $data->sum('g_penyalahgunaan_napza_15_59_l');
        $array["g_penyalahgunaan_napza_15_59_p"] = $data->sum('g_penyalahgunaan_napza_15_59_p');
        $array["g_penyalahgunaan_napza_60_l"] = $data->sum('g_penyalahgunaan_napza_60_l');
        $array["g_penyalahgunaan_napza_60_p"] = $data->sum('g_penyalahgunaan_napza_60_p');
        $array["g_anak_remaja_0_14_l"] = $data->sum('g_anak_remaja_0_14_l');
        $array["g_anak_remaja_0_14_p"] = $data->sum('g_anak_remaja_0_14_p');
        $array["g_anak_remaja_15_59_l"] = $data->sum('g_anak_remaja_15_59_l');
        $array["g_anak_remaja_15_59_p"] = $data->sum('g_anak_remaja_15_59_p');
        $array["g_anak_remaja_60_l"] = $data->sum('g_anak_remaja_60_l');
        $array["g_anak_remaja_60_p"] = $data->sum('g_anak_remaja_60_p');
        $array["g_psikotik_akut_0_14_l"] = $data->sum('g_psikotik_akut_0_14_l');
        $array["g_psikotik_akut_0_14_p"] = $data->sum('g_psikotik_akut_0_14_p');
        $array["g_psikotik_akut_15_59_l"] = $data->sum('g_psikotik_akut_15_59_l');
        $array["g_psikotik_akut_15_59_p"] = $data->sum('g_psikotik_akut_15_59_p');
        $array["g_psikotik_akut_60_l"] = $data->sum('g_psikotik_akut_60_l');
        $array["g_psikotik_akut_60_p"] = $data->sum('g_psikotik_akut_60_p');
        $array["skizofrenia_0_14_l"] = $data->sum('skizofrenia_0_14_l');
        $array["skizofrenia_0_14_p"] = $data->sum('skizofrenia_0_14_p');
        $array["skizofrenia_15_59_l"] = $data->sum('skizofrenia_15_59_l');
        $array["skizofrenia_15_59_p"] = $data->sum('skizofrenia_15_59_p');
        $array["skizofrenia_60_l"] = $data->sum('skizofrenia_60_l');
        $array["skizofrenia_60_p"] = $data->sum('skizofrenia_60_p');
        $array["g_somatoform_0_14_l"] = $data->sum('g_somatoform_0_14_l');
        $array["g_somatoform_0_14_p"] = $data->sum('g_somatoform_0_14_p');
        $array["g_somatoform_15_59_l"] = $data->sum('g_somatoform_15_59_l');
        $array["g_somatoform_15_59_p"] = $data->sum('g_somatoform_15_59_p');
        $array["g_somatoform_60_l"] = $data->sum('g_somatoform_60_l');
        $array["g_somatoform_60_p"] = $data->sum('g_somatoform_60_p');
        $array["insomnia_0_14_l"] = $data->sum('insomnia_0_14_l');
        $array["insomnia_0_14_p"] = $data->sum('insomnia_0_14_p');
        $array["insomnia_15_59_l"] = $data->sum('insomnia_15_59_l');
        $array["insomnia_15_59_p"] = $data->sum('insomnia_15_59_p');
        $array["insomnia_60_l"] = $data->sum('insomnia_60_l');
        $array["insomnia_60_p"] = $data->sum('insomnia_60_p');
        $array["percobaan_bunuh_diri_0_14_l"] = $data->sum('percobaan_bunuh_diri_0_14_l');
        $array["percobaan_bunuh_diri_0_14_p"] = $data->sum('percobaan_bunuh_diri_0_14_p');
        $array["percobaan_bunuh_diri_15_59_l"] = $data->sum('percobaan_bunuh_diri_15_59_l');
        $array["percobaan_bunuh_diri_15_59_p"] = $data->sum('percobaan_bunuh_diri_15_59_p');
        $array["percobaan_bunuh_diri_60_l"] = $data->sum('percobaan_bunuh_diri_60_l');
        $array["percobaan_bunuh_diri_60_p"] = $data->sum('percobaan_bunuh_diri_60_p');
        $array["redartasi_mental_0_14_l"] = $data->sum('redartasi_mental_0_14_l');
        $array["redartasi_mental_0_14_p"] = $data->sum('redartasi_mental_0_14_p');
        $array["redartasi_mental_15_59_l"] = $data->sum('redartasi_mental_15_59_l');
        $array["redartasi_mental_15_59_p"] = $data->sum('redartasi_mental_15_59_p');
        $array["redartasi_mental_60_l"] = $data->sum('redartasi_mental_60_l');
        $array["redartasi_mental_60_p"] = $data->sum('redartasi_mental_60_p');
        $array["g_kepribadian_perilaku_0_14_l"] = $data->sum('g_kepribadian_perilaku_0_14_l');
        $array["g_kepribadian_perilaku_0_14_p"] = $data->sum('g_kepribadian_perilaku_0_14_p');
        $array["g_kepribadian_perilaku_15_59_l"] = $data->sum('g_kepribadian_perilaku_15_59_l');
        $array["g_kepribadian_perilaku_15_59_p"] = $data->sum('g_kepribadian_perilaku_15_59_p');
        $array["g_kepribadian_perilaku_60_l"] = $data->sum('g_kepribadian_perilaku_60_l');
        $array["g_kepribadian_perilaku_60_p"] = $data->sum('g_kepribadian_perilaku_60_p');
        $array["jumlah_kasus"] = $data->sum('jumlah_kasus');
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
            "sum_data"        => $array
        );
        return json_encode($json_data);
    }

    public function tambah()
    {
        $query = Puskesmas::select('ptm_puskesmas.*');
        $query->where('ptm_puskesmas.id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return $puskesmas;

        // return response()->json($puskesmas);
        return view('ptm/kasus/jiwa/form', compact('puskesmas', 'date_now'));
    }

    public function simpan(Request $req)
    {
        // return $req->all();
        $enc_id     = $req->enc_id;
        // return response()->json(['data' => $req->all()]);

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }


        $cek_nama = $this->cekExist('periode', date("m", strtotime('01-' . $req->periode)), $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                DB::beginTransaction();
                if ($enc_id) {
                    $ptm = Rekap_gangguan_jiwa::find($dec_id);
                    $ptm->demensia_l                           = $req->demensia_l;
                    $ptm->demensia_p                           = $req->demensia_p;
                    $ptm->g_ansietas_0_14_l                    = $req->g_ansietas_0_14_l;
                    $ptm->g_ansietas_0_14_p                    = $req->g_ansietas_0_14_p;
                    $ptm->g_ansietas_15_59_l                   = $req->g_ansietas_15_59_l;
                    $ptm->g_ansietas_15_59_p                   = $req->g_ansietas_15_59_p;
                    $ptm->g_ansietas_60_l                      = $req->g_ansietas_60_l;
                    $ptm->g_ansietas_60_p                      = $req->g_ansietas_60_p;
                    $ptm->g_ansietas_depresi_0_14_l            = $req->g_ansietas_depresi_0_14_l;
                    $ptm->g_ansietas_depresi_0_14_p            = $req->g_ansietas_depresi_0_14_p;
                    $ptm->g_ansietas_depresi_15_59_l           = $req->g_ansietas_depresi_15_59_l;
                    $ptm->g_ansietas_depresi_15_59_p           = $req->g_ansietas_depresi_15_59_p;
                    $ptm->g_ansietas_depresi_60_l              = $req->g_ansietas_depresi_60_l;
                    $ptm->g_ansietas_depresi_60_p              = $req->g_ansietas_depresi_60_p;
                    $ptm->g_depresi_0_14_l                     = $req->g_depresi_0_14_l;
                    $ptm->g_depresi_0_14_p                     = $req->g_depresi_0_14_p;
                    $ptm->g_depresi_15_59_l                    = $req->g_depresi_15_59_l;
                    $ptm->g_depresi_15_59_p                    = $req->g_depresi_15_59_p;
                    $ptm->g_depresi_60_l                       = $req->g_depresi_60_l;
                    $ptm->g_depresi_60_p                       = $req->g_depresi_60_p;
                    $ptm->g_penyalahgunaan_napza_0_14_l        = $req->g_penyalahgunaan_napza_0_14_l;
                    $ptm->g_penyalahgunaan_napza_0_14_p        = $req->g_penyalahgunaan_napza_0_14_p;
                    $ptm->g_penyalahgunaan_napza_15_59_l       = $req->g_penyalahgunaan_napza_15_59_l;
                    $ptm->g_penyalahgunaan_napza_15_59_p       = $req->g_penyalahgunaan_napza_15_59_p;
                    $ptm->g_penyalahgunaan_napza_60_l          = $req->g_penyalahgunaan_napza_60_l;
                    $ptm->g_penyalahgunaan_napza_60_p          = $req->g_penyalahgunaan_napza_60_p;
                    $ptm->g_anak_remaja_0_14_l                 = $req->g_anak_remaja_0_14_l;
                    $ptm->g_anak_remaja_0_14_p                 = $req->g_anak_remaja_0_14_p;
                    $ptm->g_anak_remaja_15_59_l                = $req->g_anak_remaja_15_59_l;
                    $ptm->g_anak_remaja_15_59_p                = $req->g_anak_remaja_15_59_p;
                    $ptm->g_anak_remaja_60_l                   = $req->g_anak_remaja_60_l;
                    $ptm->g_anak_remaja_60_p                   = $req->g_anak_remaja_60_p;
                    $ptm->g_psikotik_akut_0_14_l               = $req->g_psikotik_akut_0_14_l;
                    $ptm->g_psikotik_akut_0_14_p               = $req->g_psikotik_akut_0_14_p;
                    $ptm->g_psikotik_akut_15_59_l              = $req->g_psikotik_akut_15_59_l;
                    $ptm->g_psikotik_akut_15_59_p              = $req->g_psikotik_akut_15_59_p;
                    $ptm->g_psikotik_akut_60_l                 = $req->g_psikotik_akut_60_l;
                    $ptm->g_psikotik_akut_60_p                 = $req->g_psikotik_akut_60_p;
                    $ptm->skizofrenia_0_14_l                   = $req->skizofrenia_0_14_l;
                    $ptm->skizofrenia_0_14_p                   = $req->skizofrenia_0_14_p;
                    $ptm->skizofrenia_15_59_l                  = $req->skizofrenia_15_59_l;
                    $ptm->skizofrenia_15_59_p                  = $req->skizofrenia_15_59_p;
                    $ptm->skizofrenia_60_l                     = $req->skizofrenia_60_l;
                    $ptm->skizofrenia_60_p                     = $req->skizofrenia_60_p;
                    $ptm->g_somatoform_0_14_l                  = $req->g_somatoform_0_14_l;
                    $ptm->g_somatoform_0_14_p                  = $req->g_somatoform_0_14_p;
                    $ptm->g_somatoform_15_59_l                 = $req->g_somatoform_15_59_l;
                    $ptm->g_somatoform_15_59_p                 = $req->g_somatoform_15_59_p;
                    $ptm->g_somatoform_60_l                    = $req->g_somatoform_60_l;
                    $ptm->g_somatoform_60_p                    = $req->g_somatoform_60_p;
                    $ptm->insomnia_0_14_l                      = $req->insomnia_0_14_l;
                    $ptm->insomnia_0_14_p                      = $req->insomnia_0_14_p;
                    $ptm->insomnia_15_59_l                     = $req->insomnia_15_59_l;
                    $ptm->insomnia_15_59_p                     = $req->insomnia_15_59_p;
                    $ptm->insomnia_60_l                        = $req->insomnia_60_l;
                    $ptm->insomnia_60_p                        = $req->insomnia_60_p;
                    $ptm->percobaan_bunuh_diri_0_14_l          = $req->percobaan_bunuh_diri_0_14_l;
                    $ptm->percobaan_bunuh_diri_0_14_p          = $req->percobaan_bunuh_diri_0_14_p;
                    $ptm->percobaan_bunuh_diri_15_59_l         = $req->percobaan_bunuh_diri_15_59_l;
                    $ptm->percobaan_bunuh_diri_15_59_p         = $req->percobaan_bunuh_diri_15_59_p;
                    $ptm->percobaan_bunuh_diri_60_l            = $req->percobaan_bunuh_diri_60_l;
                    $ptm->percobaan_bunuh_diri_60_p            = $req->percobaan_bunuh_diri_60_p;
                    $ptm->redartasi_mental_0_14_l              = $req->redartasi_mental_0_14_l;
                    $ptm->redartasi_mental_0_14_p              = $req->redartasi_mental_0_14_p;
                    $ptm->redartasi_mental_15_59_l             = $req->redartasi_mental_15_59_l;
                    $ptm->redartasi_mental_15_59_p             = $req->redartasi_mental_15_59_p;
                    $ptm->redartasi_mental_60_l                = $req->redartasi_mental_60_l;
                    $ptm->redartasi_mental_60_p                = $req->redartasi_mental_60_p;
                    $ptm->g_kepribadian_perilaku_0_14_l        = $req->g_kepribadian_perilaku_0_14_l;
                    $ptm->g_kepribadian_perilaku_0_14_p        = $req->g_kepribadian_perilaku_0_14_p;
                    $ptm->g_kepribadian_perilaku_15_59_l       = $req->g_kepribadian_perilaku_15_59_l;
                    $ptm->g_kepribadian_perilaku_15_59_p       = $req->g_kepribadian_perilaku_15_59_p;
                    $ptm->g_kepribadian_perilaku_60_l          = $req->g_kepribadian_perilaku_60_l;
                    $ptm->g_kepribadian_perilaku_60_p          = $req->g_kepribadian_perilaku_60_p;
                    $ptm->jumlah_kasus                         = $req->demensia_p + $req->g_ansietas_0_14_l + $req->g_ansietas_0_14_p + $req->g_ansietas_15_59_l + $req->g_ansietas_15_59_p + $req->g_ansietas_60_l + $req->g_ansietas_60_p + $req->g_ansietas_depresi_0_14_l + $req->g_ansietas_depresi_0_14_p + $req->g_ansietas_depresi_15_59_l + $req->g_ansietas_depresi_15_59_p + $req->g_ansietas_depresi_60_l + $req->g_ansietas_depresi_60_p + $req->g_depresi_0_14_l + $req->g_depresi_0_14_p + $req->g_depresi_15_59_l + $req->g_depresi_15_59_p + $req->g_depresi_60_l + $req->g_depresi_60_p + $req->g_penyalahgunaan_napza_0_14_l + $req->g_penyalahgunaan_napza_0_14_p + $req->g_penyalahgunaan_napza_15_59_l + $req->g_penyalahgunaan_napza_15_59_p + $req->g_penyalahgunaan_napza_60_l + $req->g_penyalahgunaan_napza_60_p + $req->g_anak_remaja_0_14_l + $req->g_anak_remaja_0_14_p + $req->g_anak_remaja_15_59_l + $req->g_anak_remaja_15_59_p + $req->g_anak_remaja_60_l + $req->g_anak_remaja_60_p + $req->g_psikotik_akut_0_14_l + $req->g_psikotik_akut_0_14_p + $req->g_psikotik_akut_15_59_l + $req->g_psikotik_akut_15_59_p + $req->g_psikotik_akut_60_l + $req->g_psikotik_akut_60_p + $req->skizofrenia_0_14_l + $req->skizofrenia_0_14_p + $req->skizofrenia_15_59_l + $req->skizofrenia_15_59_p + $req->skizofrenia_60_l + $req->skizofrenia_60_p + $req->g_somatoform_0_14_l + $req->g_somatoform_0_14_p + $req->g_somatoform_15_59_l + $req->g_somatoform_15_59_p + $req->g_somatoform_60_l + $req->g_somatoform_60_p + $req->insomnia_0_14_l + $req->insomnia_0_14_p + $req->insomnia_15_59_l + $req->insomnia_15_59_p + $req->insomnia_60_l + $req->insomnia_60_p + $req->percobaan_bunuh_diri_0_14_l + $req->percobaan_bunuh_diri_0_14_p + $req->percobaan_bunuh_diri_15_59_l + $req->percobaan_bunuh_diri_15_59_p + $req->percobaan_bunuh_diri_60_l + $req->percobaan_bunuh_diri_60_p + $req->redartasi_mental_0_14_l + $req->redartasi_mental_0_14_p + $req->redartasi_mental_15_59_l + $req->redartasi_mental_15_59_p + $req->redartasi_mental_60_l + $req->redartasi_mental_60_p + $req->g_kepribadian_perilaku_0_14_l + $req->g_kepribadian_perilaku_0_14_p + $req->g_kepribadian_perilaku_15_59_l + $req->g_kepribadian_perilaku_15_59_p + $req->g_kepribadian_perilaku_60_l + $req->g_kepribadian_perilaku_60_p;
                    $ptm->periode                              = date("Y-m-d", strtotime('01-' . $req->periode));
                    $ptm->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Rekap_gangguan_jiwa::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $ptm                                       = new Rekap_gangguan_jiwa;
                    $ptm->user_id                              = auth()->user()->id;
                    $ptm->puskesmas_id                         = auth()->user()->puskesmas_id;
                    $ptm->demensia_l                           = $req->demensia_l;
                    $ptm->demensia_p                           = $req->demensia_p;
                    $ptm->g_ansietas_0_14_l                    = $req->g_ansietas_0_14_l;
                    $ptm->g_ansietas_0_14_p                    = $req->g_ansietas_0_14_p;
                    $ptm->g_ansietas_15_59_l                   = $req->g_ansietas_15_59_l;
                    $ptm->g_ansietas_15_59_p                   = $req->g_ansietas_15_59_p;
                    $ptm->g_ansietas_60_l                      = $req->g_ansietas_60_l;
                    $ptm->g_ansietas_60_p                      = $req->g_ansietas_60_p;
                    $ptm->g_ansietas_depresi_0_14_l            = $req->g_ansietas_depresi_0_14_l;
                    $ptm->g_ansietas_depresi_0_14_p            = $req->g_ansietas_depresi_0_14_p;
                    $ptm->g_ansietas_depresi_15_59_l           = $req->g_ansietas_depresi_15_59_l;
                    $ptm->g_ansietas_depresi_15_59_p           = $req->g_ansietas_depresi_15_59_p;
                    $ptm->g_ansietas_depresi_60_l              = $req->g_ansietas_depresi_60_l;
                    $ptm->g_ansietas_depresi_60_p              = $req->g_ansietas_depresi_60_p;
                    $ptm->g_depresi_0_14_l                     = $req->g_depresi_0_14_l;
                    $ptm->g_depresi_0_14_p                     = $req->g_depresi_0_14_p;
                    $ptm->g_depresi_15_59_l                    = $req->g_depresi_15_59_l;
                    $ptm->g_depresi_15_59_p                    = $req->g_depresi_15_59_p;
                    $ptm->g_depresi_60_l                       = $req->g_depresi_60_l;
                    $ptm->g_depresi_60_p                       = $req->g_depresi_60_p;
                    $ptm->g_penyalahgunaan_napza_0_14_l        = $req->g_penyalahgunaan_napza_0_14_l;
                    $ptm->g_penyalahgunaan_napza_0_14_p        = $req->g_penyalahgunaan_napza_0_14_p;
                    $ptm->g_penyalahgunaan_napza_15_59_l       = $req->g_penyalahgunaan_napza_15_59_l;
                    $ptm->g_penyalahgunaan_napza_15_59_p       = $req->g_penyalahgunaan_napza_15_59_p;
                    $ptm->g_penyalahgunaan_napza_60_l          = $req->g_penyalahgunaan_napza_60_l;
                    $ptm->g_penyalahgunaan_napza_60_p          = $req->g_penyalahgunaan_napza_60_p;
                    $ptm->g_anak_remaja_0_14_l                 = $req->g_anak_remaja_0_14_l;
                    $ptm->g_anak_remaja_0_14_p                 = $req->g_anak_remaja_0_14_p;
                    $ptm->g_anak_remaja_15_59_l                = $req->g_anak_remaja_15_59_l;
                    $ptm->g_anak_remaja_15_59_p                = $req->g_anak_remaja_15_59_p;
                    $ptm->g_anak_remaja_60_l                   = $req->g_anak_remaja_60_l;
                    $ptm->g_anak_remaja_60_p                   = $req->g_anak_remaja_60_p;
                    $ptm->g_psikotik_akut_0_14_l               = $req->g_psikotik_akut_0_14_l;
                    $ptm->g_psikotik_akut_0_14_p               = $req->g_psikotik_akut_0_14_p;
                    $ptm->g_psikotik_akut_15_59_l              = $req->g_psikotik_akut_15_59_l;
                    $ptm->g_psikotik_akut_15_59_p              = $req->g_psikotik_akut_15_59_p;
                    $ptm->g_psikotik_akut_60_l                 = $req->g_psikotik_akut_60_l;
                    $ptm->g_psikotik_akut_60_p                 = $req->g_psikotik_akut_60_p;
                    $ptm->skizofrenia_0_14_l                   = $req->skizofrenia_0_14_l;
                    $ptm->skizofrenia_0_14_p                   = $req->skizofrenia_0_14_p;
                    $ptm->skizofrenia_15_59_l                  = $req->skizofrenia_15_59_l;
                    $ptm->skizofrenia_15_59_p                  = $req->skizofrenia_15_59_p;
                    $ptm->skizofrenia_60_l                     = $req->skizofrenia_60_l;
                    $ptm->skizofrenia_60_p                     = $req->skizofrenia_60_p;
                    $ptm->g_somatoform_0_14_l                  = $req->g_somatoform_0_14_l;
                    $ptm->g_somatoform_0_14_p                  = $req->g_somatoform_0_14_p;
                    $ptm->g_somatoform_15_59_l                 = $req->g_somatoform_15_59_l;
                    $ptm->g_somatoform_15_59_p                 = $req->g_somatoform_15_59_p;
                    $ptm->g_somatoform_60_l                    = $req->g_somatoform_60_l;
                    $ptm->g_somatoform_60_p                    = $req->g_somatoform_60_p;
                    $ptm->insomnia_0_14_l                      = $req->insomnia_0_14_l;
                    $ptm->insomnia_0_14_p                      = $req->insomnia_0_14_p;
                    $ptm->insomnia_15_59_l                     = $req->insomnia_15_59_l;
                    $ptm->insomnia_15_59_p                     = $req->insomnia_15_59_p;
                    $ptm->insomnia_60_l                        = $req->insomnia_60_l;
                    $ptm->insomnia_60_p                        = $req->insomnia_60_p;
                    $ptm->percobaan_bunuh_diri_0_14_l          = $req->percobaan_bunuh_diri_0_14_l;
                    $ptm->percobaan_bunuh_diri_0_14_p          = $req->percobaan_bunuh_diri_0_14_p;
                    $ptm->percobaan_bunuh_diri_15_59_l         = $req->percobaan_bunuh_diri_15_59_l;
                    $ptm->percobaan_bunuh_diri_15_59_p         = $req->percobaan_bunuh_diri_15_59_p;
                    $ptm->percobaan_bunuh_diri_60_l            = $req->percobaan_bunuh_diri_60_l;
                    $ptm->percobaan_bunuh_diri_60_p            = $req->percobaan_bunuh_diri_60_p;
                    $ptm->redartasi_mental_0_14_l              = $req->redartasi_mental_0_14_l;
                    $ptm->redartasi_mental_0_14_p              = $req->redartasi_mental_0_14_p;
                    $ptm->redartasi_mental_15_59_l             = $req->redartasi_mental_15_59_l;
                    $ptm->redartasi_mental_15_59_p             = $req->redartasi_mental_15_59_p;
                    $ptm->redartasi_mental_60_l                = $req->redartasi_mental_60_l;
                    $ptm->redartasi_mental_60_p                = $req->redartasi_mental_60_p;
                    $ptm->g_kepribadian_perilaku_0_14_l        = $req->g_kepribadian_perilaku_0_14_l;
                    $ptm->g_kepribadian_perilaku_0_14_p        = $req->g_kepribadian_perilaku_0_14_p;
                    $ptm->g_kepribadian_perilaku_15_59_l       = $req->g_kepribadian_perilaku_15_59_l;
                    $ptm->g_kepribadian_perilaku_15_59_p       = $req->g_kepribadian_perilaku_15_59_p;
                    $ptm->g_kepribadian_perilaku_60_l          = $req->g_kepribadian_perilaku_60_l;
                    $ptm->g_kepribadian_perilaku_60_p          = $req->g_kepribadian_perilaku_60_p;
                    $ptm->jumlah_kasus                         = $req->demensia_p + $req->g_ansietas_0_14_l + $req->g_ansietas_0_14_p + $req->g_ansietas_15_59_l + $req->g_ansietas_15_59_p + $req->g_ansietas_60_l + $req->g_ansietas_60_p + $req->g_ansietas_depresi_0_14_l + $req->g_ansietas_depresi_0_14_p + $req->g_ansietas_depresi_15_59_l + $req->g_ansietas_depresi_15_59_p + $req->g_ansietas_depresi_60_l + $req->g_ansietas_depresi_60_p + $req->g_depresi_0_14_l + $req->g_depresi_0_14_p + $req->g_depresi_15_59_l + $req->g_depresi_15_59_p + $req->g_depresi_60_l + $req->g_depresi_60_p + $req->g_penyalahgunaan_napza_0_14_l + $req->g_penyalahgunaan_napza_0_14_p + $req->g_penyalahgunaan_napza_15_59_l + $req->g_penyalahgunaan_napza_15_59_p + $req->g_penyalahgunaan_napza_60_l + $req->g_penyalahgunaan_napza_60_p + $req->g_anak_remaja_0_14_l + $req->g_anak_remaja_0_14_p + $req->g_anak_remaja_15_59_l + $req->g_anak_remaja_15_59_p + $req->g_anak_remaja_60_l + $req->g_anak_remaja_60_p + $req->g_psikotik_akut_0_14_l + $req->g_psikotik_akut_0_14_p + $req->g_psikotik_akut_15_59_l + $req->g_psikotik_akut_15_59_p + $req->g_psikotik_akut_60_l + $req->g_psikotik_akut_60_p + $req->skizofrenia_0_14_l + $req->skizofrenia_0_14_p + $req->skizofrenia_15_59_l + $req->skizofrenia_15_59_p + $req->skizofrenia_60_l + $req->skizofrenia_60_p + $req->g_somatoform_0_14_l + $req->g_somatoform_0_14_p + $req->g_somatoform_15_59_l + $req->g_somatoform_15_59_p + $req->g_somatoform_60_l + $req->g_somatoform_60_p + $req->insomnia_0_14_l + $req->insomnia_0_14_p + $req->insomnia_15_59_l + $req->insomnia_15_59_p + $req->insomnia_60_l + $req->insomnia_60_p + $req->percobaan_bunuh_diri_0_14_l + $req->percobaan_bunuh_diri_0_14_p + $req->percobaan_bunuh_diri_15_59_l + $req->percobaan_bunuh_diri_15_59_p + $req->percobaan_bunuh_diri_60_l + $req->percobaan_bunuh_diri_60_p + $req->redartasi_mental_0_14_l + $req->redartasi_mental_0_14_p + $req->redartasi_mental_15_59_l + $req->redartasi_mental_15_59_p + $req->redartasi_mental_60_l + $req->redartasi_mental_60_p + $req->g_kepribadian_perilaku_0_14_l + $req->g_kepribadian_perilaku_0_14_p + $req->g_kepribadian_perilaku_15_59_l + $req->g_kepribadian_perilaku_15_59_p + $req->g_kepribadian_perilaku_60_l + $req->g_kepribadian_perilaku_60_p;
                    $ptm->periode                   = date("Y-m-d", strtotime('01-' . $req->periode));
                    $ptm->save();

                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil ditambahkan.'
                    );
                }
            } catch (\Throwable $th) {
                $json_data = array(
                    "success"         => FALSE,
                    "message"         => $th->getMessage()
                );
            }
        }
        return json_encode($json_data);
    }

    public function filter_puskesmas(Request $req)
    {
        // return $req->all();
        // return response()->json(['data' => $req->all()]);
        if ($req->kabupaten != null || $req->kabupaten != '') {
            $kabupaten = Kabupaten::find($req->kabupaten);
            $kabupaten_slice = explode(" ", $kabupaten->name);
            if ($kabupaten_slice[0] != 'KOTA') {
                $kabupaten_name = ucwords(strtolower($kabupaten_slice[1]));
            } else {
                $kabupaten_name = ucwords(strtolower($kabupaten->name));
            }
            if ($req->search == null || $req->search == '') {
                $supplier = Puskesmas::where('kabupaten', $kabupaten_name)->get();
            } else {
                $supplier = Puskesmas::where('kabupaten', $kabupaten_name)
                    ->where('name', 'LIKE', "%{$req->search}%")
                    ->get();
            }
        } else {
            $supplier = Puskesmas::select('*')
                ->where('name', 'LIKE', "%{$req->search}%")
                ->limit(10)
                ->get();
        }

        return json_encode($supplier);
    }

    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $query = Puskesmas::select('ptm_puskesmas.*');
            $query->where('ptm_puskesmas.id', auth()->user()->puskesmas_id);
            $puskesmas = $query->first();

            $ptm = Rekap_gangguan_jiwa::find($dec_id);
            $periode = date('M-Y', strtotime($ptm->periode));
            $ptm->date_periode = $periode;
            // return response()->json(['data' => $ptm]);
            return view('ptm/kasus/jiwa/form', compact('enc_id', 'puskesmas', 'ptm'));
        } else {
            $json_data = array(
                "success"         => FALSE,
                "message"         => $th->getMessage()
            );
            return json_encode($json_data);
        }

        // return response()->json($puskesmas);

    }

    public function hapus(Request $req, $enc_id)
    {
        try {
            $dec_id   = $this->safe_decode(Crypt::decryptString($enc_id));
            $ptm    = Rekap_gangguan_jiwa::find($dec_id);
            $ptm->delete();

            $json_data = array(
                "status"         => 'success',
                "message"         => 'Data berhasil dihapus.'
            );
        } catch (\Throwable $th) {
            $json_data = array(
                "success"         => 'gagal',
                "message"         => $th->getMessage()
            );
        }
        return response()->json($json_data);
    }
    public function cetak_pdf(Request $request)
    {
        // return $request->all();
        // return response()->json($request->all());
        // $search = $request->search['value'];

        if ($request->periode != '') {
            $periode = date('Y-m-d', strtotime('01-' . $request->periode));
        } else {
            $periode = date('Y-m-d');
        }
        $all_rekap_gangguan_jiwa = Rekap_gangguan_jiwa::select('*')->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->get();
        if ($request->user()->can('provinsi.index')) {
            $dataquery = Kabupaten::where('provinsi_id', auth()->user()->provinsi_id);
            $dataquery->orderBy('id', 'ASC');


            if ($request->kabupaten != NULL) {
                // $kabupaten  = $this->split_kabupaten($request->kabupaten);
                $kabupaten  = Kabupaten::find($request->kabupaten);
                $dataquery->where('name', $kabupaten->name);
            }

            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
            $provinsi = Provinsi::find(auth()->user()->provinsi_id);
            $all_puskesmas = Puskesmas::where('provinsi', 'like', "%{$provinsi->name}%")->get();
        } elseif (auth()->user()->can('balkesmas.index')) {
            // return 'tes';
            $dataquery = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id);
            $dataquery->orderBy('id', 'ASC');


            if ($request->kabupaten != NULL) {
                // $kabupaten  = $this->split_kabupaten($request->kabupaten);

                $kabupaten  = Kabupaten::find($request->kabupaten);
                $dataquery->where('name', $kabupaten->name);
            }

            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
            $balkesmas = Balkesmas::find(auth()->user()->balkesmas_id);
            $provinsi = Provinsi::find($balkesmas->provinsi_id);
            $all_puskesmas = Puskesmas::where('provinsi', 'like', "%{$provinsi->name}%")->get();
        } elseif (auth()->user()->can('kabupaten.index')) {
            $kabupaten = Kabupaten::select('id', 'name')->where('id', auth()->user()->kabupaten_id)->first();
            $kabupaten_name = explode(" ", $kabupaten->name);
            $kabupaten = $kabupaten_name[1];
            $dataquery = Puskesmas::select('id', 'name')->where('kabupaten', 'LIKE', "%{$kabupaten}%");

            $dataquery->orderBy('id', 'ASC');


            if ($request->puskesmas != NULL) {
                $dataquery->where('id', $request->puskesmas);
            }
        } elseif (auth()->user()->can('puskesmas.index')) {
            $dataquery = Rekap_gangguan_jiwa::select('rekap_gangguan_jiwa.*', 'puskesmas.name as puskesmas');
            $dataquery->leftJoin('puskesmas', 'puskesmas.id', 'rekap_gangguan_jiwa.puskesmas_id');
            $dataquery->where('puskesmas_id', auth()->user()->puskesmas_id);


            $dataquery->orderBy('rekap_gangguan_jiwa.id', 'ASC');

            if ($request->periode != null) {
                $dataquery->whereMonth('rekap_gangguan_jiwa.periode', date('m', strtotime($periode)))->whereYear('rekap_gangguan_jiwa.periode', date('Y', strtotime($periode)));
            }
        }
        $totalData = $dataquery->get()->count();

        $totalFiltered = $dataquery->get()->count();


        $data = $dataquery->get();
        // return $data;
        if (auth()->user()->can('provinsi.index') || auth()->user()->can('balkesmas.index')) {
            foreach ($data as $key => $resultt) {
                $kabupaten_name = explode(" ", $resultt->name);
                $kab = $kabupaten_name[1];
                $puskes_name = ucwords(strtolower($kab));
                $dataquery = collect($all_puskesmas)->where('kabupaten', $puskes_name)->all();
                foreach ($dataquery as $idx => $result) {
                    $record = $this->get_data_record($all_rekap_gangguan_jiwa, $result->id, $periode);
                    $result->puskesmas                         = $result->name;
                    $result->demensia_l                        = isset($record) ? $record->demensia_l : 0;
                    $result->demensia_p                        = isset($record) ? $record->demensia_p : 0;
                    $result->g_ansietas_0_14_l                 = isset($record) ? $record->g_ansietas_0_14_l : 0;
                    $result->g_ansietas_0_14_p                 = isset($record) ? $record->g_ansietas_0_14_p : 0;
                    $result->g_ansietas_15_59_l                = isset($record) ? $record->g_ansietas_15_59_l : 0;
                    $result->g_ansietas_15_59_p                = isset($record) ? $record->g_ansietas_15_59_p : 0;
                    $result->g_ansietas_60_l                   = isset($record) ? $record->g_ansietas_60_l : 0;
                    $result->g_ansietas_60_p                   = isset($record) ? $record->g_ansietas_60_p : 0;
                    $result->g_ansietas_depresi_0_14_l         = isset($record) ? $record->g_ansietas_depresi_0_14_l : 0;
                    $result->g_ansietas_depresi_0_14_p         = isset($record) ? $record->g_ansietas_depresi_0_14_p : 0;
                    $result->g_ansietas_depresi_15_59_l        = isset($record) ? $record->g_ansietas_depresi_15_59_l : 0;
                    $result->g_ansietas_depresi_15_59_p        = isset($record) ? $record->g_ansietas_depresi_15_59_p : 0;
                    $result->g_ansietas_depresi_60_l           = isset($record) ? $record->g_ansietas_depresi_60_l : 0;
                    $result->g_ansietas_depresi_60_p           = isset($record) ? $record->g_ansietas_depresi_60_p : 0;
                    $result->g_depresi_0_14_l                  = isset($record) ? $record->g_depresi_0_14_l : 0;
                    $result->g_depresi_0_14_p                  = isset($record) ? $record->g_depresi_0_14_p : 0;
                    $result->g_depresi_15_59_l                 = isset($record) ? $record->g_depresi_15_59_l : 0;
                    $result->g_depresi_15_59_p                 = isset($record) ? $record->g_depresi_15_59_p : 0;
                    $result->g_depresi_60_l                    = isset($record) ? $record->g_depresi_60_l : 0;
                    $result->g_depresi_60_p                    = isset($record) ? $record->g_depresi_60_p : 0;
                    $result->g_penyalahgunaan_napza_0_14_l     = isset($record) ? $record->g_penyalahgunaan_napza_0_14_l : 0;
                    $result->g_penyalahgunaan_napza_0_14_p     = isset($record) ? $record->g_penyalahgunaan_napza_0_14_p : 0;
                    $result->g_penyalahgunaan_napza_15_59_l    = isset($record) ? $record->g_penyalahgunaan_napza_15_59_l : 0;
                    $result->g_penyalahgunaan_napza_15_59_p    = isset($record) ? $record->g_penyalahgunaan_napza_15_59_p : 0;
                    $result->g_penyalahgunaan_napza_60_l       = isset($record) ? $record->g_penyalahgunaan_napza_60_l : 0;
                    $result->g_penyalahgunaan_napza_60_p       = isset($record) ? $record->g_penyalahgunaan_napza_60_p : 0;
                    $result->g_anak_remaja_0_14_l              = isset($record) ? $record->g_anak_remaja_0_14_l : 0;
                    $result->g_anak_remaja_0_14_p              = isset($record) ? $record->g_anak_remaja_0_14_p : 0;
                    $result->g_anak_remaja_15_59_l             = isset($record) ? $record->g_anak_remaja_15_59_l : 0;
                    $result->g_anak_remaja_15_59_p             = isset($record) ? $record->g_anak_remaja_15_59_p : 0;
                    $result->g_anak_remaja_60_l                = isset($record) ? $record->g_anak_remaja_60_l : 0;
                    $result->g_anak_remaja_60_p                = isset($record) ? $record->g_anak_remaja_60_p : 0;
                    $result->g_psikotik_akut_0_14_l            = isset($record) ? $record->g_psikotik_akut_0_14_l : 0;
                    $result->g_psikotik_akut_0_14_p            = isset($record) ? $record->g_psikotik_akut_0_14_p : 0;
                    $result->g_psikotik_akut_15_59_l           = isset($record) ? $record->g_psikotik_akut_15_59_l : 0;
                    $result->g_psikotik_akut_15_59_p           = isset($record) ? $record->g_psikotik_akut_15_59_p : 0;
                    $result->g_psikotik_akut_60_l              = isset($record) ? $record->g_psikotik_akut_60_l : 0;
                    $result->g_psikotik_akut_60_p              = isset($record) ? $record->g_psikotik_akut_60_p : 0;
                    $result->skizofrenia_0_14_l                = isset($record) ? $record->skizofrenia_0_14_l : 0;
                    $result->skizofrenia_0_14_p                = isset($record) ? $record->skizofrenia_0_14_p : 0;
                    $result->skizofrenia_15_59_l               = isset($record) ? $record->skizofrenia_15_59_l : 0;
                    $result->skizofrenia_15_59_p               = isset($record) ? $record->skizofrenia_15_59_p : 0;
                    $result->skizofrenia_60_l                  = isset($record) ? $record->skizofrenia_60_l : 0;
                    $result->skizofrenia_60_p                  = isset($record) ? $record->skizofrenia_60_p : 0;
                    $result->g_somatoform_0_14_l               = isset($record) ? $record->g_somatoform_0_14_l : 0;
                    $result->g_somatoform_0_14_p               = isset($record) ? $record->g_somatoform_0_14_p : 0;
                    $result->g_somatoform_15_59_l              = isset($record) ? $record->g_somatoform_15_59_l : 0;
                    $result->g_somatoform_15_59_p              = isset($record) ? $record->g_somatoform_15_59_p : 0;
                    $result->g_somatoform_60_l                 = isset($record) ? $record->g_somatoform_60_l : 0;
                    $result->g_somatoform_60_p                 = isset($record) ? $record->g_somatoform_60_p : 0;
                    $result->insomnia_0_14_l                   = isset($record) ? $record->insomnia_0_14_l : 0;
                    $result->insomnia_0_14_p                   = isset($record) ? $record->insomnia_0_14_p : 0;
                    $result->insomnia_15_59_l                  = isset($record) ? $record->insomnia_15_59_l : 0;
                    $result->insomnia_15_59_p                  = isset($record) ? $record->insomnia_15_59_p : 0;
                    $result->insomnia_60_l                     = isset($record) ? $record->insomnia_60_l : 0;
                    $result->insomnia_60_p                     = isset($record) ? $record->insomnia_60_p : 0;
                    $result->percobaan_bunuh_diri_0_14_l       = isset($record) ? $record->percobaan_bunuh_diri_0_14_l : 0;
                    $result->percobaan_bunuh_diri_0_14_p       = isset($record) ? $record->percobaan_bunuh_diri_0_14_p : 0;
                    $result->percobaan_bunuh_diri_15_59_l      = isset($record) ? $record->percobaan_bunuh_diri_15_59_l : 0;
                    $result->percobaan_bunuh_diri_15_59_p      = isset($record) ? $record->percobaan_bunuh_diri_15_59_p : 0;
                    $result->percobaan_bunuh_diri_60_l         = isset($record) ? $record->percobaan_bunuh_diri_60_l : 0;
                    $result->percobaan_bunuh_diri_60_p         = isset($record) ? $record->percobaan_bunuh_diri_60_p : 0;
                    $result->redartasi_mental_0_14_l           = isset($record) ? $record->redartasi_mental_0_14_l : 0;
                    $result->redartasi_mental_0_14_p           = isset($record) ? $record->redartasi_mental_0_14_p : 0;
                    $result->redartasi_mental_15_59_l          = isset($record) ? $record->redartasi_mental_15_59_l : 0;
                    $result->redartasi_mental_15_59_p          = isset($record) ? $record->redartasi_mental_15_59_p : 0;
                    $result->redartasi_mental_60_l             = isset($record) ? $record->redartasi_mental_60_l : 0;
                    $result->redartasi_mental_60_p             = isset($record) ? $record->redartasi_mental_60_p : 0;
                    $result->g_kepribadian_perilaku_0_14_l     = isset($record) ? $record->g_kepribadian_perilaku_0_14_l : 0;
                    $result->g_kepribadian_perilaku_0_14_p     = isset($record) ? $record->g_kepribadian_perilaku_0_14_p : 0;
                    $result->g_kepribadian_perilaku_15_59_l    = isset($record) ? $record->g_kepribadian_perilaku_15_59_l : 0;
                    $result->g_kepribadian_perilaku_15_59_p    = isset($record) ? $record->g_kepribadian_perilaku_15_59_p : 0;
                    $result->g_kepribadian_perilaku_60_l       = isset($record) ? $record->g_kepribadian_perilaku_60_l : 0;
                    $result->g_kepribadian_perilaku_60_p       = isset($record) ? $record->g_kepribadian_perilaku_60_p : 0;
                    $result->jumlah_kasus                      = isset($record) ? $record->jumlah_kasus : 0;
                }
                // $resultt->no                                = $key + $page;
                if ($kabupaten_name[0] != 'KOTA') {
                    $resultt->kabupaten            = strtoupper($kabupaten_name[1]);
                    $resultt->puskesmas            = strtoupper($kabupaten_name[1]);
                } else {
                    $resultt->kabupaten            = strtoupper($resultt->kabupaten);
                    $resultt->puskesmas            = $resultt->name;
                }
                // $resultt->puskesmas                         = $resultt->name;
                $resultt->demensia_l                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['demensia_l'])->all();
                })->sum('demensia_l');
                $resultt->demensia_p                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['demensia_p'])->all();
                })->sum('demensia_p');
                $resultt->g_ansietas_0_14_l                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_0_14_l'])->all();
                })->sum('g_ansietas_0_14_l');
                $resultt->g_ansietas_0_14_p                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_0_14_p'])->all();
                })->sum('g_ansietas_0_14_p');
                $resultt->g_ansietas_15_59_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_15_59_l'])->all();
                })->sum('g_ansietas_15_59_l');
                $resultt->g_ansietas_15_59_p                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_15_59_p'])->all();
                })->sum('g_ansietas_15_59_p');
                $resultt->g_ansietas_60_l                   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_60_l'])->all();
                })->sum('g_ansietas_60_l');
                $resultt->g_ansietas_60_p                   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_60_p'])->all();
                })->sum('g_ansietas_60_p');
                $resultt->g_ansietas_depresi_0_14_l         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_0_14_l'])->all();
                })->sum('g_ansietas_depresi_0_14_l');
                $resultt->g_ansietas_depresi_0_14_p         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_0_14_p'])->all();
                })->sum('g_ansietas_depresi_0_14_p');
                $resultt->g_ansietas_depresi_15_59_l        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_15_59_l'])->all();
                })->sum('g_ansietas_depresi_15_59_l');
                $resultt->g_ansietas_depresi_15_59_p        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_15_59_p'])->all();
                })->sum('g_ansietas_depresi_15_59_p');
                $resultt->g_ansietas_depresi_60_l           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_60_l'])->all();
                })->sum('g_ansietas_depresi_60_l');
                $resultt->g_ansietas_depresi_60_p           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_ansietas_depresi_60_p'])->all();
                })->sum('g_ansietas_depresi_60_p');
                $resultt->g_depresi_0_14_l                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_0_14_l'])->all();
                })->sum('g_depresi_0_14_l');
                $resultt->g_depresi_0_14_p                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_0_14_p'])->all();
                })->sum('g_depresi_0_14_p');
                $resultt->g_depresi_15_59_l                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_15_59_l'])->all();
                })->sum('g_depresi_15_59_l');
                $resultt->g_depresi_15_59_p                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_15_59_p'])->all();
                })->sum('g_depresi_15_59_p');
                $resultt->g_depresi_60_l                    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_60_l'])->all();
                })->sum('g_depresi_60_l');
                $resultt->g_depresi_60_p                    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_depresi_60_p'])->all();
                })->sum('g_depresi_60_p');
                $resultt->g_penyalahgunaan_napza_0_14_l     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_0_14_l'])->all();
                })->sum('g_penyalahgunaan_napza_0_14_l');
                $resultt->g_penyalahgunaan_napza_0_14_p     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_0_14_p'])->all();
                })->sum('g_penyalahgunaan_napza_0_14_p');
                $resultt->g_penyalahgunaan_napza_15_59_l    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_15_59_l'])->all();
                })->sum('g_penyalahgunaan_napza_15_59_l');
                $resultt->g_penyalahgunaan_napza_15_59_p    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_15_59_p'])->all();
                })->sum('g_penyalahgunaan_napza_15_59_p');
                $resultt->g_penyalahgunaan_napza_60_l       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_60_l'])->all();
                })->sum('g_penyalahgunaan_napza_60_l');
                $resultt->g_penyalahgunaan_napza_60_p       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_penyalahgunaan_napza_60_p'])->all();
                })->sum('g_penyalahgunaan_napza_60_p');
                $resultt->g_anak_remaja_0_14_l              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_0_14_l'])->all();
                })->sum('g_anak_remaja_0_14_l');
                $resultt->g_anak_remaja_0_14_p              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_0_14_p'])->all();
                })->sum('g_anak_remaja_0_14_p');
                $resultt->g_anak_remaja_15_59_l             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_15_59_l'])->all();
                })->sum('g_anak_remaja_15_59_l');
                $resultt->g_anak_remaja_15_59_p             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_15_59_p'])->all();
                })->sum('g_anak_remaja_15_59_p');
                $resultt->g_anak_remaja_60_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_60_l'])->all();
                })->sum('g_anak_remaja_60_l');
                $resultt->g_anak_remaja_60_p                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_anak_remaja_60_p'])->all();
                })->sum('g_anak_remaja_60_p');
                $resultt->g_psikotik_akut_0_14_l            = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_0_14_l'])->all();
                })->sum('g_psikotik_akut_0_14_l');
                $resultt->g_psikotik_akut_0_14_p            = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_0_14_p'])->all();
                })->sum('g_psikotik_akut_0_14_p');
                $resultt->g_psikotik_akut_15_59_l           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_15_59_l'])->all();
                })->sum('g_psikotik_akut_15_59_l');
                $resultt->g_psikotik_akut_15_59_p           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_15_59_p'])->all();
                })->sum('g_psikotik_akut_15_59_p');
                $resultt->g_psikotik_akut_60_l              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_60_l'])->all();
                })->sum('g_psikotik_akut_60_l');
                $resultt->g_psikotik_akut_60_p              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_psikotik_akut_60_p'])->all();
                })->sum('g_psikotik_akut_60_p');
                $resultt->skizofrenia_0_14_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_0_14_l'])->all();
                })->sum('skizofrenia_0_14_l');
                $resultt->skizofrenia_0_14_p                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_0_14_p'])->all();
                })->sum('skizofrenia_0_14_p');
                $resultt->skizofrenia_15_59_l               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_15_59_l'])->all();
                })->sum('skizofrenia_15_59_l');
                $resultt->skizofrenia_15_59_p               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_15_59_p'])->all();
                })->sum('skizofrenia_15_59_p');
                $resultt->skizofrenia_60_l                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_60_l'])->all();
                })->sum('skizofrenia_60_l');
                $resultt->skizofrenia_60_p                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skizofrenia_60_p'])->all();
                })->sum('skizofrenia_60_p');
                $resultt->g_somatoform_0_14_l               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_0_14_l'])->all();
                })->sum('g_somatoform_0_14_l');
                $resultt->g_somatoform_0_14_p               = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_0_14_p'])->all();
                })->sum('g_somatoform_0_14_p');
                $resultt->g_somatoform_15_59_l              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_15_59_l'])->all();
                })->sum('g_somatoform_15_59_l');
                $resultt->g_somatoform_15_59_p              = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_15_59_p'])->all();
                })->sum('g_somatoform_15_59_p');
                $resultt->g_somatoform_60_l                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_60_l'])->all();
                })->sum('g_somatoform_60_l');
                $resultt->g_somatoform_60_p                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_somatoform_60_p'])->all();
                })->sum('g_somatoform_60_p');
                $resultt->insomnia_0_14_l                   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_0_14_l'])->all();
                })->sum('insomnia_0_14_l');
                $resultt->insomnia_0_14_p                   = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_0_14_p'])->all();
                })->sum('insomnia_0_14_p');
                $resultt->insomnia_15_59_l                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_15_59_l'])->all();
                })->sum('insomnia_15_59_l');
                $resultt->insomnia_15_59_p                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_15_59_p'])->all();
                })->sum('insomnia_15_59_p');
                $resultt->insomnia_60_l                     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_60_l'])->all();
                })->sum('insomnia_60_l');
                $resultt->insomnia_60_p                     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['insomnia_60_p'])->all();
                })->sum('insomnia_60_p');
                $resultt->percobaan_bunuh_diri_0_14_l       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_0_14_l'])->all();
                })->sum('percobaan_bunuh_diri_0_14_l');
                $resultt->percobaan_bunuh_diri_0_14_p       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_0_14_p'])->all();
                })->sum('percobaan_bunuh_diri_0_14_p');
                $resultt->percobaan_bunuh_diri_15_59_l      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_15_59_l'])->all();
                })->sum('percobaan_bunuh_diri_15_59_l');
                $resultt->percobaan_bunuh_diri_15_59_p      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_15_59_p'])->all();
                })->sum('percobaan_bunuh_diri_15_59_p');
                $resultt->percobaan_bunuh_diri_60_l         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_60_l'])->all();
                })->sum('percobaan_bunuh_diri_60_l');
                $resultt->percobaan_bunuh_diri_60_p         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['percobaan_bunuh_diri_60_p'])->all();
                })->sum('percobaan_bunuh_diri_60_p');
                $resultt->redartasi_mental_0_14_l           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_0_14_l'])->all();
                })->sum('redartasi_mental_0_14_l');
                $resultt->redartasi_mental_0_14_p           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_0_14_p'])->all();
                })->sum('redartasi_mental_0_14_p');
                $resultt->redartasi_mental_15_59_l          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_15_59_l'])->all();
                })->sum('redartasi_mental_15_59_l');
                $resultt->redartasi_mental_15_59_p          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_15_59_p'])->all();
                })->sum('redartasi_mental_15_59_p');
                $resultt->redartasi_mental_60_l             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_60_l'])->all();
                })->sum('redartasi_mental_60_l');
                $resultt->redartasi_mental_60_p             = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['redartasi_mental_60_p'])->all();
                })->sum('redartasi_mental_60_p');
                $resultt->g_kepribadian_perilaku_0_14_l     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_0_14_l'])->all();
                })->sum('g_kepribadian_perilaku_0_14_l');
                $resultt->g_kepribadian_perilaku_0_14_p     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_0_14_p'])->all();
                })->sum('g_kepribadian_perilaku_0_14_p');
                $resultt->g_kepribadian_perilaku_15_59_l    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_15_59_l'])->all();
                })->sum('g_kepribadian_perilaku_15_59_l');
                $resultt->g_kepribadian_perilaku_15_59_p    = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_15_59_p'])->all();
                })->sum('g_kepribadian_perilaku_15_59_p');
                $resultt->g_kepribadian_perilaku_60_l       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_60_l'])->all();
                })->sum('g_kepribadian_perilaku_60_l');
                $resultt->g_kepribadian_perilaku_60_p       = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['g_kepribadian_perilaku_60_p'])->all();
                })->sum('g_kepribadian_perilaku_60_p');
                $resultt->jumlah_kasus                      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jumlah_kasus'])->all();
                })->sum('jumlah_kasus');
                $resultt->action                            = "";
            }
        } else {
            foreach ($data as $key => $result) {
                $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
                $action = "";

                if ($request->user()->can('ptm.index')) {
                    $record = $this->get_data_record($all_rekap_gangguan_jiwa, $result->id, $periode);
                }

                $action .= "";

                if ($request->user()->can('ptm.ubah')) {
                    $action .= "<div class='btn-group'>";
                    $action .= '<a href="' . route('jiwa.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }
                if ($request->user()->can('ptm.ubah')) {
                    $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
                }

                $action .= "</div>";

                // $result->no                   = $key + $page;
                $result->id                   = $result->id;
                $result->action               = $action;
                if ($request->user()->can('kabupaten.index')) {
                    $result->puskesmas                         = $result->name;
                    $result->demensia_l                        = isset($record) ? $record->demensia_l : 0;
                    $result->demensia_p                        = isset($record) ? $record->demensia_p : 0;
                    $result->g_ansietas_0_14_l                 = isset($record) ? $record->g_ansietas_0_14_l : 0;
                    $result->g_ansietas_0_14_p                 = isset($record) ? $record->g_ansietas_0_14_p : 0;
                    $result->g_ansietas_15_59_l                = isset($record) ? $record->g_ansietas_15_59_l : 0;
                    $result->g_ansietas_15_59_p                = isset($record) ? $record->g_ansietas_15_59_p : 0;
                    $result->g_ansietas_60_l                   = isset($record) ? $record->g_ansietas_60_l : 0;
                    $result->g_ansietas_60_p                   = isset($record) ? $record->g_ansietas_60_p : 0;
                    $result->g_ansietas_depresi_0_14_l         = isset($record) ? $record->g_ansietas_depresi_0_14_l : 0;
                    $result->g_ansietas_depresi_0_14_p         = isset($record) ? $record->g_ansietas_depresi_0_14_p : 0;
                    $result->g_ansietas_depresi_15_59_l        = isset($record) ? $record->g_ansietas_depresi_15_59_l : 0;
                    $result->g_ansietas_depresi_15_59_p        = isset($record) ? $record->g_ansietas_depresi_15_59_p : 0;
                    $result->g_ansietas_depresi_60_l           = isset($record) ? $record->g_ansietas_depresi_60_l : 0;
                    $result->g_ansietas_depresi_60_p           = isset($record) ? $record->g_ansietas_depresi_60_p : 0;
                    $result->g_depresi_0_14_l                  = isset($record) ? $record->g_depresi_0_14_l : 0;
                    $result->g_depresi_0_14_p                  = isset($record) ? $record->g_depresi_0_14_p : 0;
                    $result->g_depresi_15_59_l                 = isset($record) ? $record->g_depresi_15_59_l : 0;
                    $result->g_depresi_15_59_p                 = isset($record) ? $record->g_depresi_15_59_p : 0;
                    $result->g_depresi_60_l                    = isset($record) ? $record->g_depresi_60_l : 0;
                    $result->g_depresi_60_p                    = isset($record) ? $record->g_depresi_60_p : 0;
                    $result->g_penyalahgunaan_napza_0_14_l     = isset($record) ? $record->g_penyalahgunaan_napza_0_14_l : 0;
                    $result->g_penyalahgunaan_napza_0_14_p     = isset($record) ? $record->g_penyalahgunaan_napza_0_14_p : 0;
                    $result->g_penyalahgunaan_napza_15_59_l    = isset($record) ? $record->g_penyalahgunaan_napza_15_59_l : 0;
                    $result->g_penyalahgunaan_napza_15_59_p    = isset($record) ? $record->g_penyalahgunaan_napza_15_59_p : 0;
                    $result->g_penyalahgunaan_napza_60_l       = isset($record) ? $record->g_penyalahgunaan_napza_60_l : 0;
                    $result->g_penyalahgunaan_napza_60_p       = isset($record) ? $record->g_penyalahgunaan_napza_60_p : 0;
                    $result->g_anak_remaja_0_14_l              = isset($record) ? $record->g_anak_remaja_0_14_l : 0;
                    $result->g_anak_remaja_0_14_p              = isset($record) ? $record->g_anak_remaja_0_14_p : 0;
                    $result->g_anak_remaja_15_59_l             = isset($record) ? $record->g_anak_remaja_15_59_l : 0;
                    $result->g_anak_remaja_15_59_p             = isset($record) ? $record->g_anak_remaja_15_59_p : 0;
                    $result->g_anak_remaja_60_l                = isset($record) ? $record->g_anak_remaja_60_l : 0;
                    $result->g_anak_remaja_60_p                = isset($record) ? $record->g_anak_remaja_60_p : 0;
                    $result->g_psikotik_akut_0_14_l            = isset($record) ? $record->g_psikotik_akut_0_14_l : 0;
                    $result->g_psikotik_akut_0_14_p            = isset($record) ? $record->g_psikotik_akut_0_14_p : 0;
                    $result->g_psikotik_akut_15_59_l           = isset($record) ? $record->g_psikotik_akut_15_59_l : 0;
                    $result->g_psikotik_akut_15_59_p           = isset($record) ? $record->g_psikotik_akut_15_59_p : 0;
                    $result->g_psikotik_akut_60_l              = isset($record) ? $record->g_psikotik_akut_60_l : 0;
                    $result->g_psikotik_akut_60_p              = isset($record) ? $record->g_psikotik_akut_60_p : 0;
                    $result->skizofrenia_0_14_l                = isset($record) ? $record->skizofrenia_0_14_l : 0;
                    $result->skizofrenia_0_14_p                = isset($record) ? $record->skizofrenia_0_14_p : 0;
                    $result->skizofrenia_15_59_l               = isset($record) ? $record->skizofrenia_15_59_l : 0;
                    $result->skizofrenia_15_59_p               = isset($record) ? $record->skizofrenia_15_59_p : 0;
                    $result->skizofrenia_60_l                  = isset($record) ? $record->skizofrenia_60_l : 0;
                    $result->skizofrenia_60_p                  = isset($record) ? $record->skizofrenia_60_p : 0;
                    $result->g_somatoform_0_14_l               = isset($record) ? $record->g_somatoform_0_14_l : 0;
                    $result->g_somatoform_0_14_p               = isset($record) ? $record->g_somatoform_0_14_p : 0;
                    $result->g_somatoform_15_59_l              = isset($record) ? $record->g_somatoform_15_59_l : 0;
                    $result->g_somatoform_15_59_p              = isset($record) ? $record->g_somatoform_15_59_p : 0;
                    $result->g_somatoform_60_l                 = isset($record) ? $record->g_somatoform_60_l : 0;
                    $result->g_somatoform_60_p                 = isset($record) ? $record->g_somatoform_60_p : 0;
                    $result->insomnia_0_14_l                   = isset($record) ? $record->insomnia_0_14_l : 0;
                    $result->insomnia_0_14_p                   = isset($record) ? $record->insomnia_0_14_p : 0;
                    $result->insomnia_15_59_l                  = isset($record) ? $record->insomnia_15_59_l : 0;
                    $result->insomnia_15_59_p                  = isset($record) ? $record->insomnia_15_59_p : 0;
                    $result->insomnia_60_l                     = isset($record) ? $record->insomnia_60_l : 0;
                    $result->insomnia_60_p                     = isset($record) ? $record->insomnia_60_p : 0;
                    $result->percobaan_bunuh_diri_0_14_l       = isset($record) ? $record->percobaan_bunuh_diri_0_14_l : 0;
                    $result->percobaan_bunuh_diri_0_14_p       = isset($record) ? $record->percobaan_bunuh_diri_0_14_p : 0;
                    $result->percobaan_bunuh_diri_15_59_l      = isset($record) ? $record->percobaan_bunuh_diri_15_59_l : 0;
                    $result->percobaan_bunuh_diri_15_59_p      = isset($record) ? $record->percobaan_bunuh_diri_15_59_p : 0;
                    $result->percobaan_bunuh_diri_60_l         = isset($record) ? $record->percobaan_bunuh_diri_60_l : 0;
                    $result->percobaan_bunuh_diri_60_p         = isset($record) ? $record->percobaan_bunuh_diri_60_p : 0;
                    $result->redartasi_mental_0_14_l           = isset($record) ? $record->redartasi_mental_0_14_l : 0;
                    $result->redartasi_mental_0_14_p           = isset($record) ? $record->redartasi_mental_0_14_p : 0;
                    $result->redartasi_mental_15_59_l          = isset($record) ? $record->redartasi_mental_15_59_l : 0;
                    $result->redartasi_mental_15_59_p          = isset($record) ? $record->redartasi_mental_15_59_p : 0;
                    $result->redartasi_mental_60_l             = isset($record) ? $record->redartasi_mental_60_l : 0;
                    $result->redartasi_mental_60_p             = isset($record) ? $record->redartasi_mental_60_p : 0;
                    $result->g_kepribadian_perilaku_0_14_l     = isset($record) ? $record->g_kepribadian_perilaku_0_14_l : 0;
                    $result->g_kepribadian_perilaku_0_14_p     = isset($record) ? $record->g_kepribadian_perilaku_0_14_p : 0;
                    $result->g_kepribadian_perilaku_15_59_l    = isset($record) ? $record->g_kepribadian_perilaku_15_59_l : 0;
                    $result->g_kepribadian_perilaku_15_59_p    = isset($record) ? $record->g_kepribadian_perilaku_15_59_p : 0;
                    $result->g_kepribadian_perilaku_60_l       = isset($record) ? $record->g_kepribadian_perilaku_60_l : 0;
                    $result->g_kepribadian_perilaku_60_p       = isset($record) ? $record->g_kepribadian_perilaku_60_p : 0;
                    $result->jumlah_kasus                      = isset($record) ? $record->jumlah_kasus : 0;
                } else if ($request->user()->can('puskesmas.index')) {
                    $result->puskesmas                         = $result->puskesmas;
                    $result->demensia_l                        = $result->demensia_l;
                    $result->demensia_p                        = $result->demensia_p;
                    $result->g_ansietas_0_14_l                 = $result->g_ansietas_0_14_l;
                    $result->g_ansietas_0_14_p                 = $result->g_ansietas_0_14_p;
                    $result->g_ansietas_15_59_l                = $result->g_ansietas_15_59_l;
                    $result->g_ansietas_15_59_p                = $result->g_ansietas_15_59_p;
                    $result->g_ansietas_60_l                   = $result->g_ansietas_60_l;
                    $result->g_ansietas_60_p                   = $result->g_ansietas_60_p;
                    $result->g_ansietas_depresi_0_14_l         = $result->g_ansietas_depresi_0_14_l;
                    $result->g_ansietas_depresi_0_14_p         = $result->g_ansietas_depresi_0_14_p;
                    $result->g_ansietas_depresi_15_59_l        = $result->g_ansietas_depresi_15_59_l;
                    $result->g_ansietas_depresi_15_59_p        = $result->g_ansietas_depresi_15_59_p;
                    $result->g_ansietas_depresi_60_l           = $result->g_ansietas_depresi_60_l;
                    $result->g_ansietas_depresi_60_p           = $result->g_ansietas_depresi_60_p;
                    $result->g_depresi_0_14_l                  = $result->g_depresi_0_14_l;
                    $result->g_depresi_0_14_p                  = $result->g_depresi_0_14_p;
                    $result->g_depresi_15_59_l                 = $result->g_depresi_15_59_l;
                    $result->g_depresi_15_59_p                 = $result->g_depresi_15_59_p;
                    $result->g_depresi_60_l                    = $result->g_depresi_60_l;
                    $result->g_depresi_60_p                    = $result->g_depresi_60_p;
                    $result->g_penyalahgunaan_napza_0_14_l     = $result->g_penyalahgunaan_napza_0_14_l;
                    $result->g_penyalahgunaan_napza_0_14_p     = $result->g_penyalahgunaan_napza_0_14_p;
                    $result->g_penyalahgunaan_napza_15_59_l    = $result->g_penyalahgunaan_napza_15_59_l;
                    $result->g_penyalahgunaan_napza_15_59_p    = $result->g_penyalahgunaan_napza_15_59_p;
                    $result->g_penyalahgunaan_napza_60_l       = $result->g_penyalahgunaan_napza_60_l;
                    $result->g_penyalahgunaan_napza_60_p       = $result->g_penyalahgunaan_napza_60_p;
                    $result->g_anak_remaja_0_14_l              = $result->g_anak_remaja_0_14_l;
                    $result->g_anak_remaja_0_14_p              = $result->g_anak_remaja_0_14_p;
                    $result->g_anak_remaja_15_59_l             = $result->g_anak_remaja_15_59_l;
                    $result->g_anak_remaja_15_59_p             = $result->g_anak_remaja_15_59_p;
                    $result->g_anak_remaja_60_l                = $result->g_anak_remaja_60_l;
                    $result->g_anak_remaja_60_p                = $result->g_anak_remaja_60_p;
                    $result->g_psikotik_akut_0_14_l            = $result->g_psikotik_akut_0_14_l;
                    $result->g_psikotik_akut_0_14_p            = $result->g_psikotik_akut_0_14_p;
                    $result->g_psikotik_akut_15_59_l           = $result->g_psikotik_akut_15_59_l;
                    $result->g_psikotik_akut_15_59_p           = $result->g_psikotik_akut_15_59_p;
                    $result->g_psikotik_akut_60_l              = $result->g_psikotik_akut_60_l;
                    $result->g_psikotik_akut_60_p              = $result->g_psikotik_akut_60_p;
                    $result->skizofrenia_0_14_l                = $result->skizofrenia_0_14_l;
                    $result->skizofrenia_0_14_p                = $result->skizofrenia_0_14_p;
                    $result->skizofrenia_15_59_l               = $result->skizofrenia_15_59_l;
                    $result->skizofrenia_15_59_p               = $result->skizofrenia_15_59_p;
                    $result->skizofrenia_60_l                  = $result->skizofrenia_60_l;
                    $result->skizofrenia_60_p                  = $result->skizofrenia_60_p;
                    $result->g_somatoform_0_14_l               = $result->g_somatoform_0_14_l;
                    $result->g_somatoform_0_14_p               = $result->g_somatoform_0_14_p;
                    $result->g_somatoform_15_59_l              = $result->g_somatoform_15_59_l;
                    $result->g_somatoform_15_59_p              = $result->g_somatoform_15_59_p;
                    $result->g_somatoform_60_l                 = $result->g_somatoform_60_l;
                    $result->g_somatoform_60_p                 = $result->g_somatoform_60_p;
                    $result->insomnia_0_14_l                   = $result->insomnia_0_14_l;
                    $result->insomnia_0_14_p                   = $result->insomnia_0_14_p;
                    $result->insomnia_15_59_l                  = $result->insomnia_15_59_l;
                    $result->insomnia_15_59_p                  = $result->insomnia_15_59_p;
                    $result->insomnia_60_l                     = $result->insomnia_60_l;
                    $result->insomnia_60_p                     = $result->insomnia_60_p;
                    $result->percobaan_bunuh_diri_0_14_l       = $result->percobaan_bunuh_diri_0_14_l;
                    $result->percobaan_bunuh_diri_0_14_p       = $result->percobaan_bunuh_diri_0_14_p;
                    $result->percobaan_bunuh_diri_15_59_l      = $result->percobaan_bunuh_diri_15_59_l;
                    $result->percobaan_bunuh_diri_15_59_p      = $result->percobaan_bunuh_diri_15_59_p;
                    $result->percobaan_bunuh_diri_60_l         = $result->percobaan_bunuh_diri_60_l;
                    $result->percobaan_bunuh_diri_60_p         = $result->percobaan_bunuh_diri_60_p;
                    $result->redartasi_mental_0_14_l           = $result->redartasi_mental_0_14_l;
                    $result->redartasi_mental_0_14_p           = $result->redartasi_mental_0_14_p;
                    $result->redartasi_mental_15_59_l          = $result->redartasi_mental_15_59_l;
                    $result->redartasi_mental_15_59_p          = $result->redartasi_mental_15_59_p;
                    $result->redartasi_mental_60_l             = $result->redartasi_mental_60_l;
                    $result->redartasi_mental_60_p             = $result->redartasi_mental_60_p;
                    $result->g_kepribadian_perilaku_0_14_l     = $result->g_kepribadian_perilaku_0_14_l;
                    $result->g_kepribadian_perilaku_0_14_p     = $result->g_kepribadian_perilaku_0_14_p;
                    $result->g_kepribadian_perilaku_15_59_l    = $result->g_kepribadian_perilaku_15_59_l;
                    $result->g_kepribadian_perilaku_15_59_p    = $result->g_kepribadian_perilaku_15_59_p;
                    $result->g_kepribadian_perilaku_60_l       = $result->g_kepribadian_perilaku_60_l;
                    $result->g_kepribadian_perilaku_60_p       = $result->g_kepribadian_perilaku_60_p;
                    $result->jumlah_kasus                      = $result->jumlah_kasus;
                }
            }
        }
        $array["puskesmas"] = $data->count();
        $array["demensia_l"] = $data->sum('demensia_l');
        $array["demensia_p"] = $data->sum('demensia_p');
        $array["g_ansietas_0_14_l"] = $data->sum('g_ansietas_0_14_l');
        $array["g_ansietas_0_14_p"] = $data->sum('g_ansietas_0_14_p');
        $array["g_ansietas_15_59_l"] = $data->sum('g_ansietas_15_59_l');
        $array["g_ansietas_15_59_p"] = $data->sum('g_ansietas_15_59_p');
        $array["g_ansietas_60_l"] = $data->sum('g_ansietas_60_l');
        $array["g_ansietas_60_p"] = $data->sum('g_ansietas_60_p');
        $array["g_ansietas_depresi_0_14_l"] = $data->sum('g_ansietas_depresi_0_14_l');
        $array["g_ansietas_depresi_0_14_p"] = $data->sum('g_ansietas_depresi_0_14_p');
        $array["g_ansietas_depresi_15_59_l"] = $data->sum('g_ansietas_depresi_15_59_l');
        $array["g_ansietas_depresi_15_59_p"] = $data->sum('g_ansietas_depresi_15_59_p');
        $array["g_ansietas_depresi_60_l"] = $data->sum('g_ansietas_depresi_60_l');
        $array["g_ansietas_depresi_60_p"] = $data->sum('g_ansietas_depresi_60_p');
        $array["g_depresi_0_14_l"] = $data->sum('g_depresi_0_14_l');
        $array["g_depresi_0_14_p"] = $data->sum('g_depresi_0_14_p');
        $array["g_depresi_15_59_l"] = $data->sum('g_depresi_15_59_l');
        $array["g_depresi_15_59_p"] = $data->sum('g_depresi_15_59_p');
        $array["g_depresi_60_l"] = $data->sum('g_depresi_60_l');
        $array["g_depresi_60_p"] = $data->sum('g_depresi_60_p');
        $array["g_penyalahgunaan_napza_0_14_l"] = $data->sum('g_penyalahgunaan_napza_0_14_l');
        $array["g_penyalahgunaan_napza_0_14_p"] = $data->sum('g_penyalahgunaan_napza_0_14_p');
        $array["g_penyalahgunaan_napza_15_59_l"] = $data->sum('g_penyalahgunaan_napza_15_59_l');
        $array["g_penyalahgunaan_napza_15_59_p"] = $data->sum('g_penyalahgunaan_napza_15_59_p');
        $array["g_penyalahgunaan_napza_60_l"] = $data->sum('g_penyalahgunaan_napza_60_l');
        $array["g_penyalahgunaan_napza_60_p"] = $data->sum('g_penyalahgunaan_napza_60_p');
        $array["g_anak_remaja_0_14_l"] = $data->sum('g_anak_remaja_0_14_l');
        $array["g_anak_remaja_0_14_p"] = $data->sum('g_anak_remaja_0_14_p');
        $array["g_anak_remaja_15_59_l"] = $data->sum('g_anak_remaja_15_59_l');
        $array["g_anak_remaja_15_59_p"] = $data->sum('g_anak_remaja_15_59_p');
        $array["g_anak_remaja_60_l"] = $data->sum('g_anak_remaja_60_l');
        $array["g_anak_remaja_60_p"] = $data->sum('g_anak_remaja_60_p');
        $array["g_psikotik_akut_0_14_l"] = $data->sum('g_psikotik_akut_0_14_l');
        $array["g_psikotik_akut_0_14_p"] = $data->sum('g_psikotik_akut_0_14_p');
        $array["g_psikotik_akut_15_59_l"] = $data->sum('g_psikotik_akut_15_59_l');
        $array["g_psikotik_akut_15_59_p"] = $data->sum('g_psikotik_akut_15_59_p');
        $array["g_psikotik_akut_60_l"] = $data->sum('g_psikotik_akut_60_l');
        $array["g_psikotik_akut_60_p"] = $data->sum('g_psikotik_akut_60_p');
        $array["skizofrenia_0_14_l"] = $data->sum('skizofrenia_0_14_l');
        $array["skizofrenia_0_14_p"] = $data->sum('skizofrenia_0_14_p');
        $array["skizofrenia_15_59_l"] = $data->sum('skizofrenia_15_59_l');
        $array["skizofrenia_15_59_p"] = $data->sum('skizofrenia_15_59_p');
        $array["skizofrenia_60_l"] = $data->sum('skizofrenia_60_l');
        $array["skizofrenia_60_p"] = $data->sum('skizofrenia_60_p');
        $array["g_somatoform_0_14_l"] = $data->sum('g_somatoform_0_14_l');
        $array["g_somatoform_0_14_p"] = $data->sum('g_somatoform_0_14_p');
        $array["g_somatoform_15_59_l"] = $data->sum('g_somatoform_15_59_l');
        $array["g_somatoform_15_59_p"] = $data->sum('g_somatoform_15_59_p');
        $array["g_somatoform_60_l"] = $data->sum('g_somatoform_60_l');
        $array["g_somatoform_60_p"] = $data->sum('g_somatoform_60_p');
        $array["insomnia_0_14_l"] = $data->sum('insomnia_0_14_l');
        $array["insomnia_0_14_p"] = $data->sum('insomnia_0_14_p');
        $array["insomnia_15_59_l"] = $data->sum('insomnia_15_59_l');
        $array["insomnia_15_59_p"] = $data->sum('insomnia_15_59_p');
        $array["insomnia_60_l"] = $data->sum('insomnia_60_l');
        $array["insomnia_60_p"] = $data->sum('insomnia_60_p');
        $array["percobaan_bunuh_diri_0_14_l"] = $data->sum('percobaan_bunuh_diri_0_14_l');
        $array["percobaan_bunuh_diri_0_14_p"] = $data->sum('percobaan_bunuh_diri_0_14_p');
        $array["percobaan_bunuh_diri_15_59_l"] = $data->sum('percobaan_bunuh_diri_15_59_l');
        $array["percobaan_bunuh_diri_15_59_p"] = $data->sum('percobaan_bunuh_diri_15_59_p');
        $array["percobaan_bunuh_diri_60_l"] = $data->sum('percobaan_bunuh_diri_60_l');
        $array["percobaan_bunuh_diri_60_p"] = $data->sum('percobaan_bunuh_diri_60_p');
        $array["redartasi_mental_0_14_l"] = $data->sum('redartasi_mental_0_14_l');
        $array["redartasi_mental_0_14_p"] = $data->sum('redartasi_mental_0_14_p');
        $array["redartasi_mental_15_59_l"] = $data->sum('redartasi_mental_15_59_l');
        $array["redartasi_mental_15_59_p"] = $data->sum('redartasi_mental_15_59_p');
        $array["redartasi_mental_60_l"] = $data->sum('redartasi_mental_60_l');
        $array["redartasi_mental_60_p"] = $data->sum('redartasi_mental_60_p');
        $array["g_kepribadian_perilaku_0_14_l"] = $data->sum('g_kepribadian_perilaku_0_14_l');
        $array["g_kepribadian_perilaku_0_14_p"] = $data->sum('g_kepribadian_perilaku_0_14_p');
        $array["g_kepribadian_perilaku_15_59_l"] = $data->sum('g_kepribadian_perilaku_15_59_l');
        $array["g_kepribadian_perilaku_15_59_p"] = $data->sum('g_kepribadian_perilaku_15_59_p');
        $array["g_kepribadian_perilaku_60_l"] = $data->sum('g_kepribadian_perilaku_60_l');
        $array["g_kepribadian_perilaku_60_p"] = $data->sum('g_kepribadian_perilaku_60_p');
        $array["jumlah_kasus"] = $data->sum('jumlah_kasus');
        // return $data;
        $view = 'template/kasus/jiwa/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'KasusJiwa.xlsx');
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
            'title'                 => 'Rekapitulasi Gangguan Jiwa',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/kasus/jiwa/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-Rekapitulasi-Gangguan-Jiwa-pdf.pdf');
    }
}
