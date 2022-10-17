<?php

namespace App\Http\Controllers\PTM;

use App\Http\Controllers\Simpusk\Controller;
use App\Models\PTM\Assist;
use App\Models\PTM\Kabupaten;
use App\Models\PTM\Provinsi;
use App\Models\PTM\Puskesmas;
use Illuminate\Http\Request;
use App\Models\Simpusk\Member;
use App\Models\Simpusk\RoleUser;
use App\Models\Simpusk\User;
use App\Models\Simpusk\Slider;
use App\Models\Simpusk\Blog;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

class BerandaPtmController extends Controller
{
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
    public function index()
    {
        //return "yes";
        // if($data == "enc"){
        //     //return "dfsf";
        //     //return redirect()->route('beranda.ngetes');
        //     return "oke";

        //     //return $akun;
        // }
        //$tes = session('auth');
        //return $tes;
        //return Auth::user();
        $tgl = Carbon::now()->format('d F Y');
        $jmluser   = User::count();
        return view('dashboard_ptm');
        //return view('backend/beranda/index',compact('tgl','jmluser'));
    }
    private function count_data($kabupaten, $periode_start, $periode_end)
    {
        $kabupate = Kabupaten::find($kabupaten);
        $kab_name = explode(' ', $kabupate->name);
        if($kab_name[0] != 'KOTA'){
            $kab = ucwords(strtolower($kab_name[1]));
        }else{
            $kab = ucwords(strtolower($kabupate->name));
        }
        $puskesmas = Puskesmas::where('kabupaten', $kab)->pluck('id');
        $query = Assist::select('*')->whereIn('puskesmas_id', $puskesmas);
        $result = $query->sum('jml_peserta_pusk_l') + $query->sum('jml_peserta_pusk_p') + $query->sum('jml_peserta_sklh_l') + $query->sum('jml_peserta_sklh_p');
        return $result;
    }

    public function getData(Request $request)
    {
        if ($request->periode2 != NULL) {
            $periode_start = date("Y-m-d", strtotime('01-' . $request->periode2));
            $periode_end = date("Y-m-d", strtotime('01-' . $request->periode2));
        } else {
            $periode_start = '01-01-' . date("Y");
            $periode_end = date("d-m-Y");
        }
        // return $periode_en;
        $result_js = [];


        if (auth()->user()->can('provinsi.index')) {
            $kabupaten = Kabupaten::where('provinsi_id', auth()->user()->provinsi_id)->get();
        }else if (auth()->user()->can('balkesmas.index')) {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->get();
        } elseif (auth()->user()->can('kabupaten.index')) {
            $kab = Kabupaten::find(auth()->user()->kabupaten_id);
            $kabupaten = Kabupaten::where('provinsi_id', $kab->provinsi_id)->get();
        } elseif (auth()->user()->can('puskesmas.index')) {
            $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
            $provinsi = Provinsi::where('name', 'LIKE', "%{$puskesmas->provinsi}%")->first();
            $kabupaten = Kabupaten::where('provinsi_id', $provinsi->id)->get();
        }

        foreach ($kabupaten as $key => $value) {
            $result_js['kabupaten'][] = $value->name;
            $result_js['data'][] = $this->count_data($value->id, $periode_start, $periode_end);
        }
        $data_array = collect([]);
        foreach ($result_js['kabupaten'] as $key => $value) {
            $collect = collect([
                'field' => $value,
                'nilai' => $result_js['data'][$key],
            ]);
            $data_array->push($collect);
        }
        $sorted = $data_array->sortBy('nilai');
        $new_result = [];
        foreach ($sorted->values()->all() as $key => $value) {
            if ($key == 0) {
                if ($value['nilai'] < 1) {
                    $new_result['success'] = false;
                    break;
                }
            }
            $new_result['kabupaten'][] = $value['field'];
            $new_result['data'][] = $value['nilai'];
            if ($key == 4) {
                break;
            }
        }
        if (!isset($new_result['success'])) {
            $new_result['success'] = true;
        }
        return response()->json(['data' => $new_result]);
    }
    private function count_data_($kabupaten, $periode_start, $periode_end)
    {
        $query = Odgj::select('*');
        $query->where('kabupaten_id', $kabupaten);
        $query->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)));
        $result = $query->sum('jml_pel_kesehatan',);
        return $result;
    }

    public function getData_(Request $request)
    {
        if ($request->periode3 != NULL) {
            $periode_start = date("Y-m-d", strtotime('01-' . $request->periode3));
            $periode_end = date("Y-m-d", strtotime('01-' . $request->periode3));
        } else {
            $periode_start = date('Y-m-d');
            $periode_end = date('Y-m-d');
        }
        $result_js = [];

        if (auth()->user()->can('provinsi.index')) {
            $kabupaten = Kabupaten::where('provinsi_id', auth()->user()->provinsi_id)->get();
        }else if (auth()->user()->can('balkesmas.index')) {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->get();
        } elseif (auth()->user()->can('kabupaten.index')) {
            $kab = Kabupaten::find(auth()->user()->kabupaten_id);
            $kabupaten = Kabupaten::where('provinsi_id', $kab->provinsi_id)->get();
        } elseif (auth()->user()->can('puskesmas.index')) {
            $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
            $provinsi = Provinsi::where('name', 'LIKE', "%{$puskesmas->provinsi}%")->first();
            $kabupaten = Kabupaten::where('provinsi_id', $provinsi->id)->get();
        }

        foreach ($kabupaten as $key => $value) {
            $result_js['kabupaten'][] = $value->name;
            $result_js['data'][] = $this->count_data_($value->id, $periode_start, $periode_end);
        }
        $data_array = collect([]);
        foreach ($result_js['kabupaten'] as $key => $value) {
            $collect = collect([
                'field' => $value,
                'nilai' => $result_js['data'][$key],
            ]);
            $data_array->push($collect);
        }
        $sorted = $data_array->sortByDesc('nilai');
        $new_result = [];
        foreach ($sorted->values()->all() as $key => $value) {
            if ($key == 0) {
                if ($value['nilai'] < 1) {
                    $new_result['success'] = false;
                    break;
                }
            }
            $new_result['kabupaten'][] = $value['field'];
            $new_result['data'][] = $value['nilai'];

            if ($key == 4) {
                break;
            }
        }
        if (!isset($new_result['success'])) {
            $new_result['success'] = true;
        }
        return response()->json(['data' => $new_result]);
    }
    public function getDataAssist(Request $request)
    {
        $periode = $request->periode;
        if (auth()->user()->can('provinsi.index')) {
            $provinsi = Provinsi::find(auth()->user()->provinsi_id);
            $puskesmas = Puskesmas::where('provinsi', $provinsi->name)->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        }else if (auth()->user()->can('balkesmas.index')) {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->pluck('name');
            $all_kab = array();
            foreach($kabupaten as $kab){
                $kab_name = explode(" ", $kab);
                if($kab_name[0] != 'KOTA'){
                    $all_kab[] = ucwords(strtolower($kab_name[1]));
                }else{
                    $all_kab[] = ucwords(strtolower($kab));
                }
            }
            $puskesmas = Puskesmas::whereIn('kabupaten', $all_kab)->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        } elseif (auth()->user()->can('kabupaten.index')) {
            $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
            // return $kabupaten;
            $kab = explode(" ", $kabupaten->name);
            // return $kab;
            $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$kab[1]}%")->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        } elseif (auth()->user()->can('puskesmas.index')) {
            $all_puskesmas_id = array(auth()->user()->puskesmas_id);
        }
        // return $request->all();
        $data = Assist::whereDate('periode', date('Y-m-d', strtotime('01-' . $periode)))->whereIn('puskesmas_id', $all_puskesmas_id)->get();
        $data_assist = collect([
            'ringan' => $data->sum('skrining_ringan_l') + $data->sum('skrining_ringan_p'),
            'sedang' => $data->sum('skrining_sedang_l') + $data->sum('skrining_sedang_p'),
            'berat' => $data->sum('skrining_berat_l') + $data->sum('skrining_sedang_p'),

        ]);
        return $data_assist;
    }
    public function getDataDeteksidini(Request $request)
    {
        $periode_start = date('Y-m-d', strtotime('01-' . $request->periode_start));
        $periode_end = date('Y-m-d', strtotime('01-' . $request->periode_end));
        $select_kab = '';
        if($request->kabupaten != ''){
            $select_kab = Kabupaten::find($request->kabupaten);
        }
        $select_pusk = '';
        if($request->puskesmas != ''){
            $select_pusk = Puskesmas::find($request->puskesmas);
        }
        if (auth()->user()->can('provinsi.index') && $select_kab == '' && $select_pusk == '') {
            $provinsi = Provinsi::find(auth()->user()->provinsi_id);
            $puskesmas = Puskesmas::where('provinsi', $provinsi->name)->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        }else if (auth()->user()->can('balkesmas.index') && $select_kab == '' && $select_pusk == '') {
            $kabupaten = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->pluck('name');
            $all_kab = array();
            foreach($kabupaten as $kab){
                $kab_name = explode(" ", $kab);
                if($kab_name[0] != 'KOTA'){
                    $all_kab[] = ucwords(strtolower($kab_name[1]));
                }else{
                    $all_kab[] = ucwords(strtolower($kab));
                }
            }
            $puskesmas = Puskesmas::whereIn('kabupaten', $all_kab)->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        } elseif ((auth()->user()->can('kabupaten.index') || $select_kab != '') && $select_pusk == '') {
            return $select_pusk;
            if($select_kab == ''){
                $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
            }else{
                $kabupaten = $select_kab;
            }
            // return $kabupaten;
            $kab = explode(" ", $kabupaten->name);
            // return $kab;
            $puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$kab[1]}%")->get();
            $all_puskesmas_id = array();
            foreach ($puskesmas as $value) {
                $all_puskesmas_id[] = $value->id;
            }
        } elseif (auth()->user()->can('puskesmas.index') || $select_pusk != '') {
            // return $select_pusk;
            if($select_pusk == ''){
                $all_puskesmas_id = array(auth()->user()->puskesmas_id);
            }else{
                $all_puskesmas_id = array($select_pusk->id);
                // return $all_puskesmas_id;
            }
        }
        // return $all_puskesmas_id;
        $data = Dd_fr_ptm_keswa::whereDate('periode', '>=', $periode_start)->whereDate('periode', '<=', $periode_end)->whereIn('puskesmas_id', $all_puskesmas_id)->get();
        $data_dd = collect([
            'merokok' => $data->sum('merokok'),
            'kurang_aktifitas' => $data->sum('aktifitas_fisik'),
            'diet' => $data->sum('diet_tdk_seimbang'),
            'alkohol' => $data->sum('konsumsi_alkohol'),
            'jml_hadir' => $data->sum('jml_hadir'),
            // 'odmk' => $data->sum('obesitas'),
        ]);
        return $data_dd;
    }
}
