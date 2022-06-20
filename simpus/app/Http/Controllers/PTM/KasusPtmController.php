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
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\PTM\Kasus_ptm;


use DB;
use Auth;
use Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Auth\Events\Failed;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use phpDocumentor\Reflection\PseudoTypes\False_;

class KasusPtmController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        $date_now   = date('M-Y');
        $user = Puskesmas::find(auth()->user()->puskesmas_id);
        return view('ptm/kasus/ptm/index', compact('user', 'date_now'));
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
        $cek = Kasus_ptm::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    private function get_data_record($kasus_ptm, $puskesmas, $periode)
    {
        // $puskesmas  = Puskesmas::where();
        $dataquery = collect($kasus_ptm)->where('puskesmas_id', $puskesmas)->first();
        // $dataquery = Kasus_ptm::select('*')->where('puskesmas_id', $puskesmas)->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->first();

        return $dataquery;
    }

    // private function split_kabupaten($kabupaten)
    // {
    //     $kabupaten_data = Kabupaten::find($kabupaten);
    //     $explode    = explode(" ", $kabupaten_data->name);
    //     $result = $explode[1];

    //     return $result;
    // }
    private function usia_group()
    {
        $result = '[{"id":1,"hitung":"1", "field":"0-14"},{"id":2,"hitung":"2","field":"15-59"},{"id":3,"hitung": "3","field":">=60"}]';
        // '[{"first_name":"Bikash","gender":"male"},{"first_name":"Dev","gender":"male"},{"first_name":"John Doe","gender":"female"}]';
        return json_decode($result, true);
    }
    private function getusia($usia){
        if($usia == 1){
            return "14";
        }else if($usia == 2){
            return "15";
        }else if($usia == 3){
            return "60";
        }
    }
    private function arrayptm(){
        return array("ima",
        "decompcordis",
        "hipertensi",
        "stroke",
        "dmtgtinsulin",
        "dmtdktgtinsulin",
        "camammae",
        "caserviks",
        "leukimia",
        "retiniblastoma",
        "cakolorectal",
        "talasemia",
        "ppok",
        "asmabronkhiale",
        "gagalginjalkronik",
        "osteoporosis",
        "obesitas");
    }
    private function count_data($data, $puskesmas, $periode_start, $periode_end)
    {
        // return $data;
        // $result = Kasus_ptm::whereIn('puskesmas_id', $puskesmas)->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->where('usia', $data)->get();
        $result = Kasus_ptm::whereIn('puskesmas_id', $puskesmas)->where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->where('usia', $data)->get();

        return $result;
    }
    private function count_data_kabupaten($puskesmas, $periode_start, $periode_end)
    {
        // return $data;
        $result = Kasus_ptm::whereIn('puskesmas_id', $puskesmas)->where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->orderBy('usia', 'ASC')->orderBy('jeniskelamin', 'ASC')->get();

        return $result;
    }
    private function count_data_prov($puskesmas, $periode_start, $periode_end)
    {
        // return $data;
        $result = Kasus_ptm::whereIn('puskesmas_id', $puskesmas)->where('periode', '>=', $periode_start)->where('periode', '<=', $periode_end)->orderBy('usia', 'ASC')->orderBy('jeniskelamin', 'ASC')->get();

        return $result;
    }
    public function getData_(Request $request)
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

        $all_kasus_ptm = Kasus_ptm::select('*')->whereMonth('periode', date('m', strtotime($periode)))->whereYear('periode', date('Y', strtotime($periode)))->get();
        // return $all_kasus_ptm;
        // return "tes";

        $dataquery = Kasus_ptm::select('kasus_ptm.*', 'puskesmas.name as name');
        $dataquery->leftJoin('puskesmas', 'puskesmas.id', 'kasus_ptm.puskesmas_id');
        $dataquery->where('kasus_ptm.puskesmas_id', auth()->user()->puskesmas_id);

        if (array_key_exists($request->order[0]['column'], $this->original_column)) {
            $dataquery->orderByRaw($this->original_column[$request->order[0]['column']] . ' ' . $request->order[0]['dir']);
        } else {
            $dataquery->orderBy('kasus_ptm.id', 'ASC');
        }

        if ($request->periode != null) {
            $dataquery->whereMonth('kasus_ptm.periode', date('m', strtotime($periode)))->whereYear('kasus_ptm.periode', date('Y', strtotime($periode)));
        }

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

            if ($request->user()->can('ptm.ubah')) {
                $action .= '<a href="' . route('ptm.ubah', $enc_id) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
            }

            if ($request->user()->can('ptm.hapus')) {
                $action .= '<a href="#" onclick="deleteData(this,\'' . $enc_id . '\')" class="btn btn-danger btn-xs icon-btn md-btn-flat product-tooltip" title="Hapus"><i class="fa fa-times"></i> Hapus</a>&nbsp;';
            }
            $action .= "</div>";
            $result->no                   = $key + $page;
            $result->id                   = $result->id;
            $result->action               = $action;
            if (auth()->user()->can('kabupaten.index')) {
                $record = $this->get_data_record($all_kasus_ptm, $result->id, $periode);
                $result->kode_puskesmas = $result->code;
            } elseif (auth()->user()->can('puskesmas.index')) {
                $record = $result;
            }
            $result->puskesmas            = $result->name;
            $result->ima                  = isset($record) ? $record->ima : 0;
            $result->decomp_cordis        = isset($record) ? $record->decomp_cordis : 0;
            $result->hipertensi           = isset($record) ? $record->hipertensi : 0;
            $result->stroke               = isset($record) ? $record->stroke : 0;
            $result->dm_tgt_insulin       = isset($record) ? $record->dm_tgt_insulin : 0;
            $result->dm_tak_tgt_insulin   = isset($record) ? $record->dm_tak_tgt_insulin : 0;
            $result->ca_mammae            = isset($record) ? $record->ca_mammae : 0;
            $result->ca_serviks           = isset($record) ? $record->ca_serviks : 0;
            $result->leukimia             = isset($record) ? $record->leukimia : 0;
            $result->retiniblastoma       = isset($record) ? $record->retiniblastoma : 0;
            $result->ca_kolorectal        = isset($record) ? $record->ca_kolorectal : 0;
            $result->talasemia            = isset($record) ? $record->talasemia : 0;
            $result->ppok                 = isset($record) ? $record->ppok : 0;
            $result->asma_bronkhiale      = isset($record) ? $record->asma_bronkhiale : 0;
            $result->ginjal_kronik        = isset($record) ? $record->ginjal_kronik : 0;
            $result->osteoporosis         = isset($record) ? $record->osteoporosis : 0;
            $result->obesitas             = isset($record) ? $record->obesitas : 0;
        }
        $array['ima'] = $data->sum('ima');
        $array['decomp_cordis'] = $data->sum('decomp_cordis');
        $array['hipertensi'] = $data->sum('hipertensi');
        $array['stroke'] = $data->sum('stroke');
        $array['dm_tgt_insulin'] = $data->sum('dm_tgt_insulin');
        $array['dm_tak_tgt_insulin'] = $data->sum('dm_tak_tgt_insulin');
        $array['ca_mammae'] = $data->sum('ca_mammae');
        $array['ca_serviks'] = $data->sum('ca_serviks');
        $array['leukimia'] = $data->sum('leukimia');
        $array['retiniblastoma'] = $data->sum('retiniblastoma');
        $array['ca_kolorectal'] = $data->sum('ca_kolorectal');
        $array['talasemia'] = $data->sum('talasemia');
        $array['ppok'] = $data->sum('ppok');
        $array['asma_bronkhiale'] = $data->sum('asma_bronkhiale');
        $array['ginjal_kronik'] = $data->sum('ginjal_kronik');
        $array['osteoporosis'] = $data->sum('osteoporosis');
        $array['obesitas'] = $data->sum('obesitas');
        $array['puskesmas'] = $data->count();
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
            "sum_data"        => $array
        );
        return json_encode($json_data);
    }
    public function getData(Request $request){
        if ($request->periode_start != '') {
            $periode_start = date('Y-m-d', strtotime('01-' . $request->periode_start));
        } else {
            $periode_start = date('Y-m-d');
        }
        if ($request->periode_end != '') {
            $periode_end = date('Y-m-d', strtotime('01-' . $request->periode_end));
        } else {
            $periode_end = date('Y-m-d');
        }
        $json = [];
        $data = $this->usia_group();
        $puskesmas_id = [auth()->user()->puskesmas_id];



        $json = $this->getDataPuskesmas($data, $puskesmas_id, $periode_start, $periode_end);
        // return $json;
        $jenkel = array('l', 'p');


        foreach($this->arrayptm() as $ptm){
            foreach($jenkel as $kel){
                $sum_data[$ptm.'_'.$kel] = collect($json)->map(function ($user) use ($ptm, $kel) {
                        return collect($user)->only([$ptm.'_'.$kel])->all();
                    })->sum($ptm.'_'.$kel);
            }
        }


        foreach($this->arrayptm() as $ptm){
            $sum_data[$ptm.'_total'] = $sum_data[$ptm.'_l'] + $sum_data[$ptm.'_p'];
        }

        $json_data = array(

            "data"            => $json,
            "sum_data"        => $sum_data
        );
        return json_encode($json_data);
    }
    private function getDataPuskesmas($data, $puskesmas_id, $periode_start, $periode_end){
        $json = [];
        foreach($data as $key => $result){
            $hasil = $this->count_data($result['hitung'], $puskesmas_id, $periode_start, $periode_end);
            $json[$key]['id'] = $result['id'];
            $json[$key]['golumur'] = $result['field'];
            if(count($hasil) > 0){
                // return $hasil;
                $kel = array('l', 'p');
                foreach($kel as $idx => $kelamin){
                    $json[$key]['ima_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('ima');
                    $json[$key]['decompcordis_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('decompcordis');
                    $json[$key]['hipertensi_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('hipertensi');
                    $json[$key]['stroke_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('stroke');
                    $json[$key]['dmtgtinsulin_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('dmtgtinsulin');
                    $json[$key]['dmtdktgtinsulin_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('dmtdktgtinsulin');
                    $json[$key]['camammae_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('camammae');
                    $json[$key]['caserviks_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('caserviks');
                    $json[$key]['leukimia_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('leukimia');
                    $json[$key]['retiniblastoma_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('retiniblastoma');
                    $json[$key]['cakolorectal_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('cakolorectal');
                    $json[$key]['talasemia_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('talasemia');
                    $json[$key]['ppok_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('ppok');
                    $json[$key]['asmabronkhiale_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('asmabronkhiale');
                    $json[$key]['gagalginjalkronik_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('gagalginjalkronik');
                    $json[$key]['osteoporosis_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('osteoporosis');
                    $json[$key]['obesitas_'.$kelamin] = collect($hasil)->where('jeniskelamin', $kelamin)->sum('obesitas');
                }
                if(!isset($json[$key]['ima_l'])){
                    $json[$key]['ima_l'] = 0;
                    $json[$key]['decompcordis_l'] = 0;
                    $json[$key]['hipertensi_l'] = 0;
                    $json[$key]['stroke_l'] = 0;
                    $json[$key]['dmtgtinsulin_l'] = 0;
                    $json[$key]['dmtdktgtinsulin_l'] = 0;
                    $json[$key]['camammae_l'] = 0;
                    $json[$key]['caserviks_l'] = 0;
                    $json[$key]['leukimia_l'] = 0;
                    $json[$key]['retiniblastoma_l'] = 0;
                    $json[$key]['cakolorectal_l'] = 0;
                    $json[$key]['talasemia_l'] = 0;
                    $json[$key]['ppok_l'] = 0;
                    $json[$key]['asmabronkhiale_l'] = 0;
                    $json[$key]['gagalginjalkronik_l'] = 0;
                    $json[$key]['osteoporosis_l'] = 0;
                    $json[$key]['obesitas_l'] = 0;
                }else if(!isset($json[$key]['ima_p'])){
                    $json[$key]['ima_p'] = 0;
                    $json[$key]['decompcordis_p'] = 0;
                    $json[$key]['hipertensi_p'] = 0;
                    $json[$key]['stroke_p'] = 0;
                    $json[$key]['dmtgtinsulin_p'] = 0;
                    $json[$key]['dmtdktgtinsulin_p'] = 0;
                    $json[$key]['camammae_p'] = 0;
                    $json[$key]['caserviks_p'] = 0;
                    $json[$key]['leukimia_p'] = 0;
                    $json[$key]['retiniblastoma_p'] = 0;
                    $json[$key]['cakolorectal_p'] = 0;
                    $json[$key]['talasemia_p'] = 0;
                    $json[$key]['ppok_p'] = 0;
                    $json[$key]['asmabronkhiale_p'] = 0;
                    $json[$key]['gagalginjalkronik_p'] = 0;
                    $json[$key]['osteoporosis_p'] = 0;
                    $json[$key]['obesitas_p'] = 0;
                }
                $json[$key]['ima_total'] = $json[$key]['ima_l'] + $json[$key]['ima_p'];
                $json[$key]['decompcordis_total'] = $json[$key]['decompcordis_l'] + $json[$key]['decompcordis_p'];
                $json[$key]['hipertensi_total'] = $json[$key]['hipertensi_l'] + $json[$key]['hipertensi_p'];
                $json[$key]['stroke_total'] = $json[$key]['stroke_l'] + $json[$key]['stroke_p'];
                $json[$key]['dmtgtinsulin_total'] = $json[$key]['dmtgtinsulin_l'] + $json[$key]['dmtgtinsulin_p'];
                $json[$key]['dmtdktgtinsulin_total'] = $json[$key]['dmtdktgtinsulin_l'] + $json[$key]['dmtdktgtinsulin_p'];
                $json[$key]['camammae_total'] = $json[$key]['camammae_l'] + $json[$key]['camammae_p'];
                $json[$key]['caserviks_total'] = $json[$key]['caserviks_l'] + $json[$key]['caserviks_p'];
                $json[$key]['leukimia_total'] = $json[$key]['leukimia_l'] + $json[$key]['leukimia_p'];
                $json[$key]['retiniblastoma_total'] = $json[$key]['retiniblastoma_l'] + $json[$key]['retiniblastoma_p'];
                $json[$key]['cakolorectal_total'] = $json[$key]['cakolorectal_l'] + $json[$key]['cakolorectal_p'];
                $json[$key]['talasemia_total'] = $json[$key]['talasemia_l'] + $json[$key]['talasemia_p'];
                $json[$key]['ppok_total'] = $json[$key]['ppok_l'] + $json[$key]['ppok_p'];
                $json[$key]['asmabronkhiale_total'] = $json[$key]['asmabronkhiale_l'] + $json[$key]['asmabronkhiale_p'];
                $json[$key]['gagalginjalkronik_total'] = $json[$key]['gagalginjalkronik_l'] + $json[$key]['gagalginjalkronik_p'];
                $json[$key]['osteoporosis_total'] = $json[$key]['osteoporosis_l'] + $json[$key]['osteoporosis_p'];
                $json[$key]['obesitas_total'] = $json[$key]['obesitas_l'] + $json[$key]['obesitas_p'];

            }else{
                $json[$key]['ima_l'] = 0;
                $json[$key]['decompcordis_l'] = 0;
                $json[$key]['hipertensi_l'] = 0;
                $json[$key]['stroke_l'] = 0;
                $json[$key]['dmtgtinsulin_l'] = 0;
                $json[$key]['dmtdktgtinsulin_l'] = 0;
                $json[$key]['camammae_l'] = 0;
                $json[$key]['caserviks_l'] = 0;
                $json[$key]['leukimia_l'] = 0;
                $json[$key]['retiniblastoma_l'] = 0;
                $json[$key]['cakolorectal_l'] = 0;
                $json[$key]['talasemia_l'] = 0;
                $json[$key]['ppok_l'] = 0;
                $json[$key]['asmabronkhiale_l'] = 0;
                $json[$key]['gagalginjalkronik_l'] = 0;
                $json[$key]['osteoporosis_l'] = 0;
                $json[$key]['obesitas_l'] = 0;
                $json[$key]['ima_p'] = 0;
                $json[$key]['decompcordis_p'] = 0;
                $json[$key]['hipertensi_p'] = 0;
                $json[$key]['stroke_p'] = 0;
                $json[$key]['dmtgtinsulin_p'] = 0;
                $json[$key]['dmtdktgtinsulin_p'] = 0;
                $json[$key]['camammae_p'] = 0;
                $json[$key]['caserviks_p'] = 0;
                $json[$key]['leukimia_p'] = 0;
                $json[$key]['retiniblastoma_p'] = 0;
                $json[$key]['cakolorectal_p'] = 0;
                $json[$key]['talasemia_p'] = 0;
                $json[$key]['ppok_p'] = 0;
                $json[$key]['asmabronkhiale_p'] = 0;
                $json[$key]['gagalginjalkronik_p'] = 0;
                $json[$key]['osteoporosis_p'] = 0;
                $json[$key]['obesitas_p'] = 0;
                $json[$key]['ima_total'] = $json[$key]['ima_l'] + $json[$key]['ima_p'];
                $json[$key]['decompcordis_total'] = $json[$key]['decompcordis_l'] + $json[$key]['decompcordis_p'];
                $json[$key]['hipertensi_total'] = $json[$key]['hipertensi_l'] + $json[$key]['hipertensi_p'];
                $json[$key]['stroke_total'] = $json[$key]['stroke_l'] + $json[$key]['stroke_p'];
                $json[$key]['dmtgtinsulin_total'] = $json[$key]['dmtgtinsulin_l'] + $json[$key]['dmtgtinsulin_p'];
                $json[$key]['dmtdktgtinsulin_total'] = $json[$key]['dmtdktgtinsulin_l'] + $json[$key]['dmtdktgtinsulin_p'];
                $json[$key]['camammae_total'] = $json[$key]['camammae_l'] + $json[$key]['camammae_p'];
                $json[$key]['caserviks_total'] = $json[$key]['caserviks_l'] + $json[$key]['caserviks_p'];
                $json[$key]['leukimia_total'] = $json[$key]['leukimia_l'] + $json[$key]['leukimia_p'];
                $json[$key]['retiniblastoma_total'] = $json[$key]['retiniblastoma_l'] + $json[$key]['retiniblastoma_p'];
                $json[$key]['cakolorectal_total'] = $json[$key]['cakolorectal_l'] + $json[$key]['cakolorectal_p'];
                $json[$key]['talasemia_total'] = $json[$key]['talasemia_l'] + $json[$key]['talasemia_p'];
                $json[$key]['ppok_total'] = $json[$key]['ppok_l'] + $json[$key]['ppok_p'];
                $json[$key]['asmabronkhiale_total'] = $json[$key]['asmabronkhiale_l'] + $json[$key]['asmabronkhiale_p'];
                $json[$key]['gagalginjalkronik_total'] = $json[$key]['gagalginjalkronik_l'] + $json[$key]['gagalginjalkronik_p'];
                $json[$key]['osteoporosis_total'] = $json[$key]['osteoporosis_l'] + $json[$key]['osteoporosis_p'];
                $json[$key]['obesitas_total'] = $json[$key]['obesitas_l'] + $json[$key]['obesitas_p'];
            }
        }
        return $json;
    }
    public function tambah()
    {
        $query = Puskesmas::select('puskesmas.*');
        $query->where('puskesmas.id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return response()->json($puskesmas);
        return view('template/kasus/ptm/form', compact('puskesmas', 'date_now'));
    }
    private function getDataKabupaten($data, $puskesmas, $periode_start, $periode_end){
        // return $periode_end;
        $json = [];
        foreach($puskesmas as $key => $pusk){
            $hasil = $this->count_data_kabupaten([$pusk->id], $periode_start, $periode_end);
            $tes = collect($hasil)->where('usia', '3')->all();

            $json[$key]['no'] = $key+1;
            $json[$key]['nama_puskesmas'] = $pusk->name;
            // return $data;
            foreach($data as $idx => $result){
                $record = collect($hasil)->where('usia', $result['hitung'])->all();
                if(count($record) != 0){
                    if(count($record) > 1){
                        $jenkel = array('l', 'p');
                        foreach($jenkel as $kel){
                            foreach($this->arrayptm() as $ptm){
                                $json[$key][$ptm.'_'.$kel.'_'.$this->getusia($result['hitung'])] = collect($record)->where('jeniskelamin', $kel)->sum($ptm);
                            }
                        }
                    }else{
                        $record = array_values($record)[0];
                        if($record['jeniskelamin'] == 'l'){
                            foreach($this->arrayptm() as $ptm){
                                $json[$key][$ptm.'_'.$record['jeniskelamin'].'_'.$this->getusia($result['hitung'])] = $record[$ptm];
                                $json[$key][$ptm.'_p_'.$this->getusia($result['hitung'])] = 0;
                            }
                        }else{
                            foreach($this->arrayptm() as $ptm){
                                $json[$key][$ptm.'_'.$record['jeniskelamin'].'_'.$this->getusia($result['hitung'])] = $record[$ptm];
                                $json[$key][$ptm.'_l_'.$this->getusia($result['hitung'])] = 0;
                            }
                        }
                    }
                }else{
                    $jenkel = array('l', 'p');
                    foreach($jenkel as $kel){
                        foreach($this->arrayptm() as $ptm){
                            $json[$key][$ptm.'_'.$kel.'_'.$this->getusia($result['hitung'])] = 0;
                        }
                    }
                }
                // unset($record);
            }
            // return $record;
            $jenkel = array('l', 'p');
            foreach($jenkel as $kel){
                foreach($this->arrayptm() as $ptm){
                    $json[$key][$ptm.'_'.$kel.'_total'] = collect($hasil)->where('jeniskelamin', $kel)->sum($ptm);
                }
            }
            foreach($this->arrayptm() as $ptm){
                $json[$key][$ptm.'_total'] = $json[$key][$ptm.'_l_total'] + $json[$key][$ptm.'_p_total'];
            }

        }
        return $json;
    }
    public function simpan_(Request $req)
    {
        $enc_id     = $req->enc_id;
        // return response()->json(['data' => $req->all()]);

        if ($enc_id != null) {
            $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        } else {
            $dec_id = null;
        }


        $cek_nama = $this->cekExist('periode', date("Y", strtotime('01-' . $req->periode)), $dec_id);
        if (!$cek_nama) {
            $json_data = array(
                "success"         => FALSE,
                "message"         => 'Mohon maaf. Nama Jabatan sudah terdaftar pada sistem.'
            );
        } else {
            try {
                DB::beginTransaction();
                if ($enc_id) {
                    $ptm = Kasus_ptm::find($dec_id);
                    $ptm->ima                   = $req->ima;
                    $ptm->decomp_cordis         = $req->decomp_cordis;
                    $ptm->hipertensi            = $req->hipertensi;
                    $ptm->stroke                = $req->stroke;
                    $ptm->dm_tgt_insulin        = $req->dm_tgt_insulin;
                    $ptm->dm_tak_tgt_insulin    = $req->dm_tak_tgt_insulin;
                    $ptm->ca_mammae             = $req->ca_mammae;
                    $ptm->ca_serviks            = $req->ca_serviks;
                    $ptm->leukimia              = $req->leukimia;
                    $ptm->retiniblastoma        = $req->retiniblastoma;
                    $ptm->ca_kolorectal         = $req->ca_kolorectal;
                    $ptm->talasemia             = $req->talasemia;
                    $ptm->ppok                  = $req->ppok;
                    $ptm->asma_bronkhiale       = $req->asma_bronkhiale;
                    $ptm->ginjal_kronik         = $req->ginjal_kronik;
                    $ptm->osteoporosis          = $req->osteoporosis;
                    $ptm->obesitas              = $req->obesitas;
                    $ptm->periode                 = date("Y-m-d", strtotime('01-' . $req->periode));
                    $ptm->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek = Kasus_ptm::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $ptm                        = new Kasus_ptm;
                    $ptm->user_id               = auth()->user()->id;
                    $ptm->puskesmas_id          = auth()->user()->puskesmas_id;
                    $ptm->ima                   = $req->ima;
                    $ptm->decomp_cordis         = $req->decomp_cordis;
                    $ptm->hipertensi            = $req->hipertensi;
                    $ptm->stroke                = $req->stroke;
                    $ptm->dm_tgt_insulin        = $req->dm_tgt_insulin;
                    $ptm->dm_tak_tgt_insulin    = $req->dm_tak_tgt_insulin;
                    $ptm->ca_mammae             = $req->ca_mammae;
                    $ptm->ca_serviks            = $req->ca_serviks;
                    $ptm->leukimia              = $req->leukimia;
                    $ptm->retiniblastoma        = $req->retiniblastoma;
                    $ptm->ca_kolorectal         = $req->ca_kolorectal;
                    $ptm->talasemia             = $req->talasemia;
                    $ptm->ppok                  = $req->ppok;
                    $ptm->asma_bronkhiale       = $req->asma_bronkhiale;
                    $ptm->ginjal_kronik         = $req->ginjal_kronik;
                    $ptm->osteoporosis          = $req->osteoporosis;
                    $ptm->obesitas              = $req->obesitas;
                    // $ptm->periode               = date("Y-m-d", strtotime(str_replace('/', '-', $req->periode)));
                    $ptm->periode                 = date("Y-m-d", strtotime('01-' . $req->periode));

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
    public function simpan(Request $req){
        // return $req->all();
        $periode_start = date('Y-m-d', strtotime('01-'.$req->periode_start));
        $periode_end = date('Y-m-d', strtotime('01-'.$req->periode_end));
        // return $periode_end;
        if(strtotime($periode_start) != strtotime($periode_end)){
            return array(
                'success' => FALSE,
                'message' => 'Periode tidak sama'
            );
        }
        $explode = explode('_', $req->id);
        $usia = $explode[0];
        $ptm = $explode[1];
        $jeniskelamin = $explode[2];
        $data = Kasus_ptm::where('user_id', auth()->user()->id)->where('puskesmas_id', auth()->user()->puskesmas_id)->where('jeniskelamin',$jeniskelamin)->where('usia', $usia)->where('periode', $periode_start)->first();
        if(!isset($data)){
            $new = new Kasus_ptm;
            $new->user_id = auth()->user()->id;
            $new->puskesmas_id = auth()->user()->puskesmas_id;
            $new->$ptm = $req->nilai;
            $new->usia = $usia;
            $new->jeniskelamin = $jeniskelamin;
            $new->periode = $periode_start;
            if($new->save()){
                array(
                    'success' => TRUE,
                    'message' => 'Data berhasil disimpan'
                );
            }else{
                return array(
                    'success' => FALSE,
                    'message' => 'Data gagal disimpan'
                );
            }
        }else{
            $data->$ptm = $req->nilai;
            $data->save();
            if($data->save()){
                return "Data berhasil disimpan";
            }else{
                return array(
                    'success' => FALSE,
                    'message' => 'Data gagal disimpan'
                );
            }
        }
    }
    public function ubah($enc_id)
    {
        $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        if ($dec_id) {
            $query = Puskesmas::select('puskesmas.*');
            $query->where('puskesmas.id', auth()->user()->puskesmas_id);
            $puskesmas = $query->first();

            $ptm = Kasus_ptm::find($dec_id);
            $periode = date('M-Y', strtotime($ptm->periode));
            $ptm->date_periode = $periode;
            // return response()->json(['data' => $ptm]);
            return view('template/kasus/ptm/form', compact('enc_id', 'puskesmas', 'ptm'));
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
            $ptm    = Kasus_ptm::find($dec_id);
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

    public function cetak_pdf(Request $request){
        // return $request->all();
        if($request->start != ''){
            $periode_start = date('Y-m-d', strtotime('01-'.$request->start));
        }else{
            $periode_start = date('Y-m-d');
        }
        if($request->end != ''){
            $periode_end = date('Y-m-d', strtotime('01-'.$request->end));
        }else{
            $periode_end = date('Y-m-d');
        }
        $json = [];
        $data = $this->usia_group();


        $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
        $puskesmas = [$puskesmas];



        $awal  = date_create($periode_start);
        $akhir  = date_create($periode_end);
        // $akhir = date_create(); // waktu sekarang
        $diff  = date_diff( $awal, $akhir );
        $json = [];
        // return $diff->m;
        for($i=0;$i<=$diff->m;$i++){
            $start = date('Y-m-d', strtotime($periode_start.' first day of +'.$i.' month'));
            $json[$i] = $this->getDataKabupaten($data, $puskesmas, $start, $start)[0];
            $json[$i]['no'] = $i+1;
            $json[$i]['bulan'] = date('M-Y', strtotime($periode_start.' first day of +'.$i.' month'));
        }
        // return $json;
        $sum_data['nama_puskesmas'] = count($json);
        $jenkel = array('l', 'p');
        foreach($this->arrayptm() as $ptm){
            foreach($jenkel as $kel){
                foreach($this->usia_group() as $usia){
                    $sum_data[$ptm.'_'.$kel.'_'.$this->getusia($usia['hitung'])] = collect($json)->map(function ($user) use ($ptm, $kel, $usia) {
                        return collect($user)->only([$ptm.'_'.$kel.'_'.$this->getusia($usia['hitung'])])->all();
                    })->sum($ptm.'_'.$kel.'_'.$this->getusia($usia['hitung']));
                }
            }
        }
        foreach($this->arrayptm() as $ptm){
            foreach($jenkel as $kel){
                $sum_data[$ptm.'_'.$kel.'_total'] = $sum_data[$ptm.'_'.$kel.'_14'] + $sum_data[$ptm.'_'.$kel.'_15'] + $sum_data[$ptm.'_'.$kel.'_60'];
            }
        }
        foreach($this->arrayptm() as $ptm){
            $sum_data[$ptm.'_total'] = $sum_data[$ptm.'_p_total'] + $sum_data[$ptm.'_l_total'];
        }

        $view = 'ptm/kasus/ptm/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($json, $sum_data, $view), 'KasusPTM.xlsx');
        }
        $config = [
            'mode'                  => '',
            'format'                => 'A3',
            'default_font_size'     => '11',
            'default_font'          => 'sans-serif',
            'margin_left'           => 8,
            'margin_right'          => 8,
            'margin_top'            => 8,
            'margin_bottom'         => 8,
            'margin_header'         => 0,
            'margin_footer'         => 0,
            'orientation'           => 'L',
            'title'                 => 'Kasus PTM',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        // return $json;
        $pdf = Pdf::loadview('ptm/kasus/ptm/cetak', ['data' => $json, 'sum_data' => $sum_data], [], $config);
        return $pdf->download('laporan-Kasus-PTM-pdf.pdf');
        // return $json_data;
    }
}
