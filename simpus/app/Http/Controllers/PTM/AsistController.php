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
use App\Models\PTM\Assist;

use DB;
use Auth;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AsistController extends Controller
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

        return view('ptm/deteksi_dini/assist/index', compact('kabupaten', 'user', 'data', 'start_date', 'end_date'));
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
        $cek =Assist::where('id', '!=', $id)->where($column, '=', $var)->first();
        return (!empty($cek) ? false : true);
    }

    public function tambah()
    {
        $query = Puskesmas::select('*');
        $query->where('id', auth()->user()->puskesmas_id);
        $puskesmas = $query->first();
        $date_now   = date('M-Y');
        // return response()->json($puskesmas);
        return view('ptm/deteksi_dini/assist/form', compact('puskesmas', 'date_now'));
    }

    private function sum_data($array, $field, $puskesmas, $periode_start, $periode_end)
    {
        // $dataquery =Assist::where('puskesmas_id', $puskesmas)
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
        $all_data =Assist::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
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
                $action .= '<a href="' . route('dd_assist.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
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

            $result->jml_sklh_skrining_assist          = $this->sum_data($all_data, 'jml_sklh_skrining_assist', $result->id, $periode_start, $periode_end);
            $result->jml_peserta_pusk_l                = $this->sum_data($all_data, 'jml_peserta_pusk_l', $result->id, $periode_start, $periode_end);
            $result->jml_peserta_pusk_p                = $this->sum_data($all_data, 'jml_peserta_pusk_p', $result->id, $periode_start, $periode_end);
            $result->jml_peserta_sklh_l                = $this->sum_data($all_data, 'jml_peserta_sklh_l', $result->id, $periode_start, $periode_end);
            $result->jml_peserta_sklh_p                = $this->sum_data($all_data, 'jml_peserta_sklh_p', $result->id, $periode_start, $periode_end);
            $result->tembakau_l                        = $this->sum_data($all_data, 'tembakau_l', $result->id, $periode_start, $periode_end);
            $result->tembakau_p                        = $this->sum_data($all_data, 'tembakau_p', $result->id, $periode_start, $periode_end);
            $result->alkohol_l                         = $this->sum_data($all_data, 'alkohol_l', $result->id, $periode_start, $periode_end);
            $result->alkohol_p                         = $this->sum_data($all_data, 'alkohol_p', $result->id, $periode_start, $periode_end);
            $result->kanabis_l                         = $this->sum_data($all_data, 'kanabis_l', $result->id, $periode_start, $periode_end);
            $result->kanabis_p                         = $this->sum_data($all_data, 'kanabis_p', $result->id, $periode_start, $periode_end);
            $result->kokain_l                          = $this->sum_data($all_data, 'kokain_l', $result->id, $periode_start, $periode_end);
            $result->kokain_p                          = $this->sum_data($all_data, 'kokain_p', $result->id, $periode_start, $periode_end);
            $result->stimulan_l                        = $this->sum_data($all_data, 'stimulan_l', $result->id, $periode_start, $periode_end);
            $result->stimulan_p                        = $this->sum_data($all_data, 'stimulan_p', $result->id, $periode_start, $periode_end);
            $result->inhalansia_l                      = $this->sum_data($all_data, 'inhalansia_l', $result->id, $periode_start, $periode_end);
            $result->inhalansia_p                      = $this->sum_data($all_data, 'inhalansia_p', $result->id, $periode_start, $periode_end);
            $result->sedatif_l                         = $this->sum_data($all_data, 'sedatif_l', $result->id, $periode_start, $periode_end);
            $result->sedatif_p                         = $this->sum_data($all_data, 'sedatif_p', $result->id, $periode_start, $periode_end);
            $result->halusinogen_l                     = $this->sum_data($all_data, 'halusinogen_l', $result->id, $periode_start, $periode_end);
            $result->halusinogen_p                     = $this->sum_data($all_data, 'halusinogen_p', $result->id, $periode_start, $periode_end);
            $result->opioida_l                         = $this->sum_data($all_data, 'opioida_l', $result->id, $periode_start, $periode_end);
            $result->opioida_p                         = $this->sum_data($all_data, 'opioida_p', $result->id, $periode_start, $periode_end);
            $result->lain_l                            = $this->sum_data($all_data, 'lain_l', $result->id, $periode_start, $periode_end);
            $result->lain_p                            = $this->sum_data($all_data, 'lain_p', $result->id, $periode_start, $periode_end);
            $result->skrining_ringan_l                 = $this->sum_data($all_data, 'skrining_ringan_l', $result->id, $periode_start, $periode_end);
            $result->skrining_ringan_p                 = $this->sum_data($all_data, 'skrining_ringan_p', $result->id, $periode_start, $periode_end);
            $result->skrining_sedang_l                 = $this->sum_data($all_data, 'skrining_sedang_l', $result->id, $periode_start, $periode_end);
            $result->skrining_sedang_p                 = $this->sum_data($all_data, 'skrining_sedang_p', $result->id, $periode_start, $periode_end);
            $result->skrining_berat_l                  = $this->sum_data($all_data, 'skrining_berat_l', $result->id, $periode_start, $periode_end);
            $result->skrining_berat_p                  = $this->sum_data($all_data, 'skrining_berat_p', $result->id, $periode_start, $periode_end);
            $result->tindak_skrining_rujuk_l           = $this->sum_data($all_data, 'tindak_skrining_rujuk_l', $result->id, $periode_start, $periode_end);
            $result->tindak_skrining_rujuk_p           = $this->sum_data($all_data, 'tindak_skrining_rujuk_p', $result->id, $periode_start, $periode_end);
            $result->tindak_skrining_langsung_l        = $this->sum_data($all_data, 'tindak_skrining_langsung_l', $result->id, $periode_start, $periode_end);
            $result->tindak_skrining_langsung_p        = $this->sum_data($all_data, 'tindak_skrining_langsung_p', $result->id, $periode_start, $periode_end);

        }
        // return $data;
        if(count($all_data) <= 0){
            $data = [];
        }
        $array['puskesmas']            = (count($all_data) > 0)? $data->count() : 0;
        $array['jml_sklh_skrining_assist'] = (count($all_data) > 0)? $data->sum('jml_sklh_skrining_assist') : 0;
        $array['jml_peserta_pusk_l'] = (count($all_data) > 0)? $data->sum('jml_peserta_pusk_l') : 0;
        $array['jml_peserta_pusk_p'] = (count($all_data) > 0)? $data->sum('jml_peserta_pusk_p') : 0;
        $array['jml_peserta_sklh_l'] = (count($all_data) > 0)? $data->sum('jml_peserta_sklh_l') : 0;
        $array['jml_peserta_sklh_p'] = (count($all_data) > 0)? $data->sum('jml_peserta_sklh_p') : 0;
        $array['tembakau_l'] = (count($all_data) > 0)? $data->sum('tembakau_l') : 0;
        $array['tembakau_p'] = (count($all_data) > 0)? $data->sum('tembakau_p') : 0;
        $array['alkohol_l'] = (count($all_data) > 0)? $data->sum('alkohol_l') : 0;
        $array['alkohol_p'] = (count($all_data) > 0)? $data->sum('alkohol_p') : 0;
        $array['kanabis_l'] = (count($all_data) > 0)? $data->sum('kanabis_l') : 0;
        $array['kanabis_p'] = (count($all_data) > 0)? $data->sum('kanabis_p') : 0;
        $array['kokain_l'] = (count($all_data) > 0)? $data->sum('kokain_l') : 0;
        $array['kokain_p'] = (count($all_data) > 0)? $data->sum('kokain_p') : 0;
        $array['stimulan_l'] = (count($all_data) > 0)? $data->sum('stimulan_l') : 0;
        $array['stimulan_p'] = (count($all_data) > 0)? $data->sum('stimulan_p') : 0;
        $array['inhalansia_l'] = (count($all_data) > 0)? $data->sum('inhalansia_l') : 0;
        $array['inhalansia_p'] = (count($all_data) > 0)? $data->sum('inhalansia_p') : 0;
        $array['sedatif_l'] = (count($all_data) > 0)? $data->sum('sedatif_l') : 0;
        $array['sedatif_p'] = (count($all_data) > 0)? $data->sum('sedatif_p') : 0;
        $array['halusinogen_l'] = (count($all_data) > 0)? $data->sum('halusinogen_l') : 0;
        $array['halusinogen_p'] = (count($all_data) > 0)? $data->sum('halusinogen_p') : 0;
        $array['opioida_l'] = (count($all_data) > 0)? $data->sum('opioida_l') : 0;
        $array['opioida_p'] = (count($all_data) > 0)? $data->sum('opioida_p') : 0;
        $array['lain_l'] = (count($all_data) > 0)? $data->sum('lain_l') : 0;
        $array['lain_p'] = (count($all_data) > 0)? $data->sum('lain_p') : 0;
        $array['skrining_ringan_l'] = (count($all_data) > 0)? $data->sum('skrining_ringan_l') : 0;
        $array['skrining_ringan_p'] = (count($all_data) > 0)? $data->sum('skrining_ringan_p') : 0;
        $array['skrining_sedang_l'] = (count($all_data) > 0)? $data->sum('skrining_sedang_l') : 0;
        $array['skrining_sedang_p'] = (count($all_data) > 0)? $data->sum('skrining_sedang_p') : 0;
        $array['skrining_berat_l'] = (count($all_data) > 0)? $data->sum('skrining_berat_l') : 0;
        $array['skrining_berat_p'] = (count($all_data) > 0)? $data->sum('skrining_berat_p') : 0;
        $array['tindak_skrining_rujuk_l'] = (count($all_data) > 0)? $data->sum('tindak_skrining_rujuk_l') : 0;
        $array['tindak_skrining_rujuk_p'] = (count($all_data) > 0)? $data->sum('tindak_skrining_rujuk_p') : 0;
        $array['tindak_skrining_langsung_l'] = (count($all_data) > 0)? $data->sum('tindak_skrining_langsung_l') : 0;
        $array['tindak_skrining_langsung_p'] = (count($all_data) > 0)? $data->sum('tindak_skrining_langsung_p') : 0;

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
                    $asist =Assist::where('puskesmas_id', $puskesmas->id)->where('periode', date('Y-m-d', strtotime('01-' . $req->periode)))->first();
                    // $asist =Assist::find($dec_id);
                    // return $asist;
                    $asist->user_id                = auth()->user()->id;
                    $asist->puskesmas_id           = auth()->user()->puskesmas_id;

                    $asist->jml_sklh_skrining_assist    = $req->jml_sklh_skrining_assist;
                    $asist->jml_peserta_pusk_l          = $req->jml_peserta_pusk_l;
                    $asist->jml_peserta_pusk_p          = $req->jml_peserta_pusk_p;
                    $asist->jml_peserta_sklh_l          = $req->jml_peserta_sklh_l;
                    $asist->jml_peserta_sklh_p          = $req->jml_peserta_sklh_p;
                    $asist->tembakau_l                  = $req->tembakau_l;
                    $asist->tembakau_p                  = $req->tembakau_p;
                    $asist->alkohol_l                   = $req->alkohol_l;
                    $asist->alkohol_p                   = $req->alkohol_p;
                    $asist->kanabis_l                   = $req->kanabis_l;
                    $asist->kanabis_p                   = $req->kanabis_p;
                    $asist->kokain_l                    = $req->kokain_l;
                    $asist->kokain_p                    = $req->kokain_p;
                    $asist->stimulan_l                  = $req->stimulan_l;
                    $asist->stimulan_p                  = $req->stimulan_p;
                    $asist->inhalansia_l                = $req->inhalansia_l;
                    $asist->inhalansia_p                = $req->inhalansia_p;
                    $asist->sedatif_l                   = $req->sedatif_l;
                    $asist->sedatif_p                   = $req->sedatif_p;
                    $asist->halusinogen_l               = $req->halusinogen_l;
                    $asist->halusinogen_p               = $req->halusinogen_p;
                    $asist->opioida_l                   = $req->opioida_l;
                    $asist->opioida_p                   = $req->opioida_p;
                    $asist->lain_l                      = $req->lain_l;
                    $asist->lain_p                      = $req->lain_p;
                    $asist->skrining_ringan_l           = $req->skrining_ringan_l;
                    $asist->skrining_ringan_p           = $req->skrining_ringan_p;
                    $asist->skrining_sedang_l           = $req->skrining_sedang_l;
                    $asist->skrining_sedang_p           = $req->skrining_sedang_p;
                    $asist->skrining_berat_l            = $req->skrining_berat_l;
                    $asist->skrining_berat_p            = $req->skrining_berat_p;
                    $asist->tindak_skrining_rujuk_l     = $req->tindak_skrining_rujuk_l;
                    $asist->tindak_skrining_rujuk_p     = $req->tindak_skrining_rujuk_p;
                    $asist->tindak_skrining_langsung_l  = $req->tindak_skrining_langsung_l;
                    $asist->tindak_skrining_langsung_p  = $req->tindak_skrining_langsung_p;
                    $asist->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $asist->save();
                    DB::commit();
                    $json_data = array(
                        "success"         => TRUE,
                        "message"         => 'Data berhasil diperbarui.'
                    );
                } else {
                    $cek =Assist::where('puskesmas_id', auth()->user()->puskesmas_id)->where('periode', date("Y-m-d", strtotime('01-' . $req->periode)))->first();
                    if (isset($cek)) {
                        return response()->json([
                            "success"         => FALSE,
                            "message"         => 'Data gagal diperbarui, data sudah pernah diinput di periode ini'
                        ]);
                    }
                    $asist                         = new Assist;
                    $asist->user_id                = auth()->user()->id;
                    $asist->puskesmas_id           = auth()->user()->puskesmas_id;


                    $asist->jml_sklh_skrining_assist    = $req->jml_sklh_skrining_assist;
                    $asist->jml_peserta_pusk_l          = $req->jml_peserta_pusk_l;
                    $asist->jml_peserta_pusk_p          = $req->jml_peserta_pusk_p;
                    $asist->jml_peserta_sklh_l          = $req->jml_peserta_sklh_l;
                    $asist->jml_peserta_sklh_p          = $req->jml_peserta_sklh_p;
                    $asist->tembakau_l                  = $req->tembakau_l;
                    $asist->tembakau_p                  = $req->tembakau_p;
                    $asist->alkohol_l                   = $req->alkohol_l;
                    $asist->alkohol_p                   = $req->alkohol_p;
                    $asist->kanabis_l                   = $req->kanabis_l;
                    $asist->kanabis_p                   = $req->kanabis_p;
                    $asist->kokain_l                    = $req->kokain_l;
                    $asist->kokain_p                    = $req->kokain_p;
                    $asist->stimulan_l                  = $req->stimulan_l;
                    $asist->stimulan_p                  = $req->stimulan_p;
                    $asist->inhalansia_l                = $req->inhalansia_l;
                    $asist->inhalansia_p                = $req->inhalansia_p;
                    $asist->sedatif_l                   = $req->sedatif_l;
                    $asist->sedatif_p                   = $req->sedatif_p;
                    $asist->halusinogen_l               = $req->halusinogen_l;
                    $asist->halusinogen_p               = $req->halusinogen_p;
                    $asist->opioida_l                   = $req->opioida_l;
                    $asist->opioida_p                   = $req->opioida_p;
                    $asist->lain_l                      = $req->lain_l;
                    $asist->lain_p                      = $req->lain_p;
                    $asist->skrining_ringan_l           = $req->skrining_ringan_l;
                    $asist->skrining_ringan_p           = $req->skrining_ringan_p;
                    $asist->skrining_sedang_l           = $req->skrining_sedang_l;
                    $asist->skrining_sedang_p           = $req->skrining_sedang_p;
                    $asist->skrining_berat_l            = $req->skrining_berat_l;
                    $asist->skrining_berat_p            = $req->skrining_berat_p;
                    $asist->tindak_skrining_rujuk_l     = $req->tindak_skrining_rujuk_l;
                    $asist->tindak_skrining_rujuk_p     = $req->tindak_skrining_rujuk_p;
                    $asist->tindak_skrining_langsung_l  = $req->tindak_skrining_langsung_l;
                    $asist->tindak_skrining_langsung_p  = $req->tindak_skrining_langsung_p;
                    $asist->periode                = date("Y-m-d", strtotime('01-' . $req->periode));
                    $asist->save();

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

                $assist =Assist::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $assist;
                $periode = date('M-Y', strtotime($assist->periode));
                $assist->date_periode = $periode;

                // return response()->json(['data' => $ptm]);
                return view('ptm/deteksi_dini/assist/form', compact('enc_id', 'puskesmas', 'assist'));
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

                return view('ptm/deteksi_dini/assist/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
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

            return view('ptm/deteksi_dini/assist/index', compact('kabupaten', 'user_level', 'user', 'data', 'start_date', 'end_date'))->with('alert', 'danger');
        }
        // $dec_id = $this->safe_decode(Crypt::decryptString($enc_id));
        // // return $dec_id;
        // if ($dec_id) {
        //     $query = Puskesmas::select('puskesmas.*');
        //     $query->where('puskesmas.id', auth()->user()->puskesmas_id);
        //     $puskesmas = $query->first();
        //     // return $puskesmas;

        //     $assist =Assist::find($dec_id);
        //     $periode = date('m-Y', strtotime($assist->periode));
        //     $assist->date_periode = $periode;

        //     // return response()->json(['data' => $ptm]);
        //     return view('ptm/deteksi_dini/assist/form', compact('enc_id', 'puskesmas', 'assist'));
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

                $assist =Assist::where('puskesmas_id', $puskesmas->id)->where('periode', $get_array['start'])->first();
                // return $assist;
                // return $assist;
                if ($assist->delete()) {
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
            $all_data =Assist::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data =Assist::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
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
            $all_data =Assist::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))
                ->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
        } else if ($request->user()->can('puskesmas.index')) {
            $dataquery = Puskesmas::select('id', 'name');
            $dataquery->where('id', auth()->user()->puskesmas_id);
            $dataquery->orderBy('name', 'ASC');

            $id_pusk = $dataquery->pluck('id');
            $all_data =Assist::whereIn('puskesmas_id', $id_pusk)->whereDate('periode', '>=', date('Y-m-d', strtotime($periode_start)))->whereDate('periode', '<=', date('Y-m-d', strtotime($periode_end)))->get();
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


                    $result->jml_sklh_skrining_assist          = $this->sum_data($all_data, 'jml_sklh_skrining_assist', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_l                = $this->sum_data($all_data, 'jml_peserta_pusk_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_p                = $this->sum_data($all_data, 'jml_peserta_pusk_p', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_l                = $this->sum_data($all_data, 'jml_peserta_sklh_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_p                = $this->sum_data($all_data, 'jml_peserta_sklh_p', $result->id, $periode_start, $periode_end);
                    $result->tembakau_l                        = $this->sum_data($all_data, 'tembakau_l', $result->id, $periode_start, $periode_end);
                    $result->tembakau_p                        = $this->sum_data($all_data, 'tembakau_p', $result->id, $periode_start, $periode_end);
                    $result->alkohol_l                         = $this->sum_data($all_data, 'alkohol_l', $result->id, $periode_start, $periode_end);
                    $result->alkohol_p                         = $this->sum_data($all_data, 'alkohol_p', $result->id, $periode_start, $periode_end);
                    $result->kanabis_l                         = $this->sum_data($all_data, 'kanabis_l', $result->id, $periode_start, $periode_end);
                    $result->kanabis_p                         = $this->sum_data($all_data, 'kanabis_p', $result->id, $periode_start, $periode_end);
                    $result->kokain_l                          = $this->sum_data($all_data, 'kokain_l', $result->id, $periode_start, $periode_end);
                    $result->kokain_p                          = $this->sum_data($all_data, 'kokain_p', $result->id, $periode_start, $periode_end);
                    $result->stimulan_l                        = $this->sum_data($all_data, 'stimulan_l', $result->id, $periode_start, $periode_end);
                    $result->stimulan_p                        = $this->sum_data($all_data, 'stimulan_p', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_l                      = $this->sum_data($all_data, 'inhalansia_l', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_p                      = $this->sum_data($all_data, 'inhalansia_p', $result->id, $periode_start, $periode_end);
                    $result->sedatif_l                         = $this->sum_data($all_data, 'sedatif_l', $result->id, $periode_start, $periode_end);
                    $result->sedatif_p                         = $this->sum_data($all_data, 'sedatif_p', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_l                     = $this->sum_data($all_data, 'halusinogen_l', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_p                     = $this->sum_data($all_data, 'halusinogen_p', $result->id, $periode_start, $periode_end);
                    $result->opioida_l                         = $this->sum_data($all_data, 'opioida_l', $result->id, $periode_start, $periode_end);
                    $result->opioida_p                         = $this->sum_data($all_data, 'opioida_p', $result->id, $periode_start, $periode_end);
                    $result->lain_l                            = $this->sum_data($all_data, 'lain_l', $result->id, $periode_start, $periode_end);
                    $result->lain_p                            = $this->sum_data($all_data, 'lain_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_l                 = $this->sum_data($all_data, 'skrining_ringan_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_p                 = $this->sum_data($all_data, 'skrining_ringan_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_l                 = $this->sum_data($all_data, 'skrining_sedang_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_p                 = $this->sum_data($all_data, 'skrining_sedang_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_l                  = $this->sum_data($all_data, 'skrining_berat_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_p                  = $this->sum_data($all_data, 'skrining_berat_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_l           = $this->sum_data($all_data, 'tindak_skrining_rujuk_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_p           = $this->sum_data($all_data, 'tindak_skrining_rujuk_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_l        = $this->sum_data($all_data, 'tindak_skrining_langsung_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_p        = $this->sum_data($all_data, 'tindak_skrining_langsung_p', $result->id, $periode_start, $periode_end);
                }
                $enc_id = $this->safe_encode(Crypt::encryptString($resultt->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('dd_assist.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('dd_assist.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('dd_assist.hapus')) {
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

                $resultt->jml_sklh_skrining_assist          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_sklh_skrining_assist'])->all();
                })->sum('jml_sklh_skrining_assist');
                $resultt->jml_peserta_pusk_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_peserta_pusk_l'])->all();
                })->sum('jml_peserta_pusk_l');
                $resultt->jml_peserta_pusk_p                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_peserta_pusk_p'])->all();
                })->sum('jml_peserta_pusk_p');
                $resultt->jml_peserta_sklh_l                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_peserta_sklh_l'])->all();
                })->sum('jml_peserta_sklh_l');
                $resultt->jml_peserta_sklh_p                = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['jml_peserta_sklh_p'])->all();
                })->sum('jml_peserta_sklh_p');
                $resultt->tembakau_l                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tembakau_l'])->all();
                })->sum('tembakau_l');
                $resultt->tembakau_p                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tembakau_p'])->all();
                })->sum('tembakau_p');
                $resultt->alkohol_l                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['alkohol_l'])->all();
                })->sum('alkohol_l');
                $resultt->alkohol_p                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['alkohol_p'])->all();
                })->sum('alkohol_p');
                $resultt->kanabis_l                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kanabis_l'])->all();
                })->sum('kanabis_l');
                $resultt->kanabis_p                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kanabis_p'])->all();
                })->sum('kanabis_p');
                $resultt->kokain_l                          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kokain_l'])->all();
                })->sum('kokain_l');
                $resultt->kokain_p                          = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['kokain_p'])->all();
                })->sum('kokain_p');
                $resultt->stimulan_l                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['stimulan_l'])->all();
                })->sum('stimulan_l');
                $resultt->stimulan_p                        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['stimulan_p'])->all();
                })->sum('stimulan_p');
                $resultt->inhalansia_l                      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['inhalansia_l'])->all();
                })->sum('inhalansia_l');
                $resultt->inhalansia_p                      = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['inhalansia_p'])->all();
                })->sum('inhalansia_p');
                $resultt->sedatif_l                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['sedatif_l'])->all();
                })->sum('sedatif_l');
                $resultt->sedatif_p                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['sedatif_p'])->all();
                })->sum('sedatif_p');
                $resultt->halusinogen_l                     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['halusinogen_l'])->all();
                })->sum('halusinogen_l');
                $resultt->halusinogen_p                     = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['halusinogen_p'])->all();
                })->sum('halusinogen_p');
                $resultt->opioida_l                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['opioida_l'])->all();
                })->sum('opioida_l');
                $resultt->opioida_p                         = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['opioida_p'])->all();
                })->sum('opioida_p');
                $resultt->lain_l                            = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['lain_l'])->all();
                })->sum('lain_l');
                $resultt->lain_p                            = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['lain_p'])->all();
                })->sum('lain_p');
                $resultt->skrining_ringan_l                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_ringan_l'])->all();
                })->sum('skrining_ringan_l');
                $resultt->skrining_ringan_p                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_ringan_p'])->all();
                })->sum('skrining_ringan_p');
                $resultt->skrining_sedang_l                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_sedang_l'])->all();
                })->sum('skrining_sedang_l');
                $resultt->skrining_sedang_p                 = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_sedang_p'])->all();
                })->sum('skrining_sedang_p');
                $resultt->skrining_berat_l                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_berat_l'])->all();
                })->sum('skrining_berat_l');
                $resultt->skrining_berat_p                  = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['skrining_berat_p'])->all();
                })->sum('skrining_berat_p');
                $resultt->tindak_skrining_rujuk_l           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tindak_skrining_rujuk_l'])->all();
                })->sum('tindak_skrining_rujuk_l');
                $resultt->tindak_skrining_rujuk_p           = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tindak_skrining_rujuk_p'])->all();
                })->sum('tindak_skrining_rujuk_p');
                $resultt->tindak_skrining_langsung_l        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tindak_skrining_langsung_l'])->all();
                })->sum('tindak_skrining_langsung_l');
                $resultt->tindak_skrining_langsung_p        = collect($dataquery)->map(function ($user) {
                    return collect($user->toArray())->only(['tindak_skrining_langsung_p'])->all();
                })->sum('tindak_skrining_langsung_p');
            }
        } else {
            foreach ($data as $key => $result) {
                $enc_id = $this->safe_encode(Crypt::encryptString($result->id));
                $action = "";

                $action .= "";
                $action .= "<div class='btn-group'>";
                if ($request->user()->can('dd_assist.ubah')) {
                    $array = array(
                        'enc' => $enc_id,
                        'start' => $periode_start,
                        'end' => $periode_end
                    );
                    // $encode = json_encode($array);
                    $action .= '<a href="' . route('dd_assist.ubah', 'enc=' . $array['enc'] . '&start=' . $array['start'] . '&end=' . $array['end']) . '" class="btn btn-warning btn-xs icon-btn md-btn-flat product-tooltip" title="Edit"><i class="fa fa-pencil"></i> Edit</a>&nbsp;';
                }

                if ($request->user()->can('dd_assist.hapus')) {
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



                    $result->jml_sklh_skrining_assist          = $this->sum_data($all_data, 'jml_sklh_skrining_assist', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_l                = $this->sum_data($all_data, 'jml_peserta_pusk_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_p                = $this->sum_data($all_data, 'jml_peserta_pusk_p', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_l                = $this->sum_data($all_data, 'jml_peserta_sklh_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_p                = $this->sum_data($all_data, 'jml_peserta_sklh_p', $result->id, $periode_start, $periode_end);
                    $result->tembakau_l                        = $this->sum_data($all_data, 'tembakau_l', $result->id, $periode_start, $periode_end);
                    $result->tembakau_p                        = $this->sum_data($all_data, 'tembakau_p', $result->id, $periode_start, $periode_end);
                    $result->alkohol_l                         = $this->sum_data($all_data, 'alkohol_l', $result->id, $periode_start, $periode_end);
                    $result->alkohol_p                         = $this->sum_data($all_data, 'alkohol_p', $result->id, $periode_start, $periode_end);
                    $result->kanabis_l                         = $this->sum_data($all_data, 'kanabis_l', $result->id, $periode_start, $periode_end);
                    $result->kanabis_p                         = $this->sum_data($all_data, 'kanabis_p', $result->id, $periode_start, $periode_end);
                    $result->kokain_l                          = $this->sum_data($all_data, 'kokain_l', $result->id, $periode_start, $periode_end);
                    $result->kokain_p                          = $this->sum_data($all_data, 'kokain_p', $result->id, $periode_start, $periode_end);
                    $result->stimulan_l                        = $this->sum_data($all_data, 'stimulan_l', $result->id, $periode_start, $periode_end);
                    $result->stimulan_p                        = $this->sum_data($all_data, 'stimulan_p', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_l                      = $this->sum_data($all_data, 'inhalansia_l', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_p                      = $this->sum_data($all_data, 'inhalansia_p', $result->id, $periode_start, $periode_end);
                    $result->sedatif_l                         = $this->sum_data($all_data, 'sedatif_l', $result->id, $periode_start, $periode_end);
                    $result->sedatif_p                         = $this->sum_data($all_data, 'sedatif_p', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_l                     = $this->sum_data($all_data, 'halusinogen_l', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_p                     = $this->sum_data($all_data, 'halusinogen_p', $result->id, $periode_start, $periode_end);
                    $result->opioida_l                         = $this->sum_data($all_data, 'opioida_l', $result->id, $periode_start, $periode_end);
                    $result->opioida_p                         = $this->sum_data($all_data, 'opioida_p', $result->id, $periode_start, $periode_end);
                    $result->lain_l                            = $this->sum_data($all_data, 'lain_l', $result->id, $periode_start, $periode_end);
                    $result->lain_p                            = $this->sum_data($all_data, 'lain_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_l                 = $this->sum_data($all_data, 'skrining_ringan_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_p                 = $this->sum_data($all_data, 'skrining_ringan_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_l                 = $this->sum_data($all_data, 'skrining_sedang_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_p                 = $this->sum_data($all_data, 'skrining_sedang_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_l                  = $this->sum_data($all_data, 'skrining_berat_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_p                  = $this->sum_data($all_data, 'skrining_berat_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_l           = $this->sum_data($all_data, 'tindak_skrining_rujuk_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_p           = $this->sum_data($all_data, 'tindak_skrining_rujuk_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_l        = $this->sum_data($all_data, 'tindak_skrining_langsung_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_p        = $this->sum_data($all_data, 'tindak_skrining_langsung_p', $result->id, $periode_start, $periode_end);
                } else if ($request->user()->can('puskesmas.index')) {
                    $result->kabupaten              = date('d-m-Y', strtotime($periode_start)) . ' - ' . date('d-m-Y', strtotime($periode_end));
                    $result->puskesmas              = $result->name;


                    $result->jml_sklh_skrining_assist          = $this->sum_data($all_data, 'jml_sklh_skrining_assist', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_l                = $this->sum_data($all_data, 'jml_peserta_pusk_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_pusk_p                = $this->sum_data($all_data, 'jml_peserta_pusk_p', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_l                = $this->sum_data($all_data, 'jml_peserta_sklh_l', $result->id, $periode_start, $periode_end);
                    $result->jml_peserta_sklh_p                = $this->sum_data($all_data, 'jml_peserta_sklh_p', $result->id, $periode_start, $periode_end);
                    $result->tembakau_l                        = $this->sum_data($all_data, 'tembakau_l', $result->id, $periode_start, $periode_end);
                    $result->tembakau_p                        = $this->sum_data($all_data, 'tembakau_p', $result->id, $periode_start, $periode_end);
                    $result->alkohol_l                         = $this->sum_data($all_data, 'alkohol_l', $result->id, $periode_start, $periode_end);
                    $result->alkohol_p                         = $this->sum_data($all_data, 'alkohol_p', $result->id, $periode_start, $periode_end);
                    $result->kanabis_l                         = $this->sum_data($all_data, 'kanabis_l', $result->id, $periode_start, $periode_end);
                    $result->kanabis_p                         = $this->sum_data($all_data, 'kanabis_p', $result->id, $periode_start, $periode_end);
                    $result->kokain_l                          = $this->sum_data($all_data, 'kokain_l', $result->id, $periode_start, $periode_end);
                    $result->kokain_p                          = $this->sum_data($all_data, 'kokain_p', $result->id, $periode_start, $periode_end);
                    $result->stimulan_l                        = $this->sum_data($all_data, 'stimulan_l', $result->id, $periode_start, $periode_end);
                    $result->stimulan_p                        = $this->sum_data($all_data, 'stimulan_p', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_l                      = $this->sum_data($all_data, 'inhalansia_l', $result->id, $periode_start, $periode_end);
                    $result->inhalansia_p                      = $this->sum_data($all_data, 'inhalansia_p', $result->id, $periode_start, $periode_end);
                    $result->sedatif_l                         = $this->sum_data($all_data, 'sedatif_l', $result->id, $periode_start, $periode_end);
                    $result->sedatif_p                         = $this->sum_data($all_data, 'sedatif_p', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_l                     = $this->sum_data($all_data, 'halusinogen_l', $result->id, $periode_start, $periode_end);
                    $result->halusinogen_p                     = $this->sum_data($all_data, 'halusinogen_p', $result->id, $periode_start, $periode_end);
                    $result->opioida_l                         = $this->sum_data($all_data, 'opioida_l', $result->id, $periode_start, $periode_end);
                    $result->opioida_p                         = $this->sum_data($all_data, 'opioida_p', $result->id, $periode_start, $periode_end);
                    $result->lain_l                            = $this->sum_data($all_data, 'lain_l', $result->id, $periode_start, $periode_end);
                    $result->lain_p                            = $this->sum_data($all_data, 'lain_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_l                 = $this->sum_data($all_data, 'skrining_ringan_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_ringan_p                 = $this->sum_data($all_data, 'skrining_ringan_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_l                 = $this->sum_data($all_data, 'skrining_sedang_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_sedang_p                 = $this->sum_data($all_data, 'skrining_sedang_p', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_l                  = $this->sum_data($all_data, 'skrining_berat_l', $result->id, $periode_start, $periode_end);
                    $result->skrining_berat_p                  = $this->sum_data($all_data, 'skrining_berat_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_l           = $this->sum_data($all_data, 'tindak_skrining_rujuk_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_rujuk_p           = $this->sum_data($all_data, 'tindak_skrining_rujuk_p', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_l        = $this->sum_data($all_data, 'tindak_skrining_langsung_l', $result->id, $periode_start, $periode_end);
                    $result->tindak_skrining_langsung_p        = $this->sum_data($all_data, 'tindak_skrining_langsung_p', $result->id, $periode_start, $periode_end);
                }
            }
        }

        $array['puskesmas']            = $data->count();
        $array['jml_sklh_skrining_assist'] = $data->sum('jml_sklh_skrining_assist');
        $array['jml_peserta_pusk_l'] = $data->sum('jml_peserta_pusk_l');
        $array['jml_peserta_pusk_p'] = $data->sum('jml_peserta_pusk_p');
        $array['jml_peserta_sklh_l'] = $data->sum('jml_peserta_sklh_l');
        $array['jml_peserta_sklh_p'] = $data->sum('jml_peserta_sklh_p');
        $array['tembakau_l'] = $data->sum('tembakau_l');
        $array['tembakau_p'] = $data->sum('tembakau_p');
        $array['alkohol_l'] = $data->sum('alkohol_l');
        $array['alkohol_p'] = $data->sum('alkohol_p');
        $array['kanabis_l'] = $data->sum('kanabis_l');
        $array['kanabis_p'] = $data->sum('kanabis_p');
        $array['kokain_l'] = $data->sum('kokain_l');
        $array['kokain_p'] = $data->sum('kokain_p');
        $array['stimulan_l'] = $data->sum('stimulan_l');
        $array['stimulan_p'] = $data->sum('stimulan_p');
        $array['inhalansia_l'] = $data->sum('inhalansia_l');
        $array['inhalansia_p'] = $data->sum('inhalansia_p');
        $array['sedatif_l'] = $data->sum('sedatif_l');
        $array['sedatif_p'] = $data->sum('sedatif_p');
        $array['halusinogen_l'] = $data->sum('halusinogen_l');
        $array['halusinogen_p'] = $data->sum('halusinogen_p');
        $array['opioida_l'] = $data->sum('opioida_l');
        $array['opioida_p'] = $data->sum('opioida_p');
        $array['lain_l'] = $data->sum('lain_l');
        $array['lain_p'] = $data->sum('lain_p');
        $array['skrining_ringan_l'] = $data->sum('skrining_ringan_l');
        $array['skrining_ringan_p'] = $data->sum('skrining_ringan_p');
        $array['skrining_sedang_l'] = $data->sum('skrining_sedang_l');
        $array['skrining_sedang_p'] = $data->sum('skrining_sedang_p');
        $array['skrining_berat_l'] = $data->sum('skrining_berat_l');
        $array['skrining_berat_p'] = $data->sum('skrining_berat_p');
        $array['tindak_skrining_rujuk_l'] = $data->sum('tindak_skrining_rujuk_l');
        $array['tindak_skrining_rujuk_p'] = $data->sum('tindak_skrining_rujuk_p');
        $array['tindak_skrining_langsung_l'] = $data->sum('tindak_skrining_langsung_l');
        $array['tindak_skrining_langsung_p'] = $data->sum('tindak_skrining_langsung_p');
        $array['action']                 = '';
        // return $data;
        $view = 'template/deteksi/assist/cetak';
        if ($request->cetakan == 'excel') {
            return Excel::download(new ExportExcel($data, $array, $view), 'Assist.xlsx');
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
            'title'                 => 'ASSIST',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/deteksi/assist/cetak', ['data' => $data, 'sum_data' => $array], [], $config);
        return $pdf->download('laporan-deteksi-assist.pdf');
    }
}
