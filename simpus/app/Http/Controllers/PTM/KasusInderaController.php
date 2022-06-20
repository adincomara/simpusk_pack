<?php

namespace App\Http\Controllers\PTM;

use App\Exports\ExportExcel;
use App\Exports\ExportExcel2;
use App\Http\Controllers\Simpusk\Controller;
use App\Models\Balkesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\PTM\Puskesmas;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\PTM\Indera;
use App\Models\PTM\MasterIndera;
use App\Models\PTM\Rekap_gangguan_jiwa;

use PDF;
use DB;
use Auth;
use Carbon;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\PseudoTypes\True_;

class KasusInderaController extends Controller
{
    protected $original_column = array(
        1 => "name",
    );

    public function index()
    {
        $date_now   = date('M-Y');

        $user = Puskesmas::find(auth()->user()->puskesmas_id);

        return view('ptm/kasus/indera/index', compact('date_now', 'user'));
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

    private function getDataInderaPenglihatan($kegiatan, $user, $puskesmas, $bulan)
    {
        $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->where('user_id', $user)->where('puskesmas_id', $puskesmas)
            ->whereMonth('periode', date('m', strtotime($bulan)))->whereYear('periode', date('Y', strtotime($bulan)))->first();

        return $query;
    }
    private function getDataInderaPenglihatanProv($kegiatan, $user, $puskesmas, $start, $end)
    {
        // return $start;
        $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->where('puskesmas_id', $puskesmas)
        ->where('periode', '>=', $start)->where('periode', '<=', $end);
            return $query;
        // if ($kabupaten != null && $puskesmas != null) {
        // } elseif ($kabupaten != null && $puskesmas == null) {
        //     // return $kabupaten;
        //     $kabupaten = Kabupaten::find($kabupaten);

        //     $data = explode(" ", $kabupaten->name);
        //     $all_puskesmas = Puskesmas::where('kabupaten', 'LIKE', "%{$data[1]}%")->get();
        //     $all_puskesmas_id = array();
        //     foreach ($all_puskesmas as $pusk) {
        //         $all_puskesmas_id[] = $pusk->id;
        //     }
        //     // return $all_puskesmas_id;
        //     $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->whereIn('puskesmas_id', $all_puskesmas_id)
        //     ->where('periode', '>=', $start)->where('periode', '<=', $end)->get();
        //     // return $query;
        // } else {
        //     if(auth()->user()->can('balkesmas.index')){
        //         $balkesmas = Kabupaten::where('balkesmas_id', auth()->user()->balkesmas_id)->pluck('name');

        //         $array_balkes = collect();
        //         foreach($balkesmas as $bal){
        //             $kab = explode(" ", $bal);
        //             if($kab[0] != "KOTA"){
        //                 $array_balkes->push(ucwords(strtolower($kab[1])));
        //             }else{
        //                 $array_balkes->push(ucwords(strtolower($bal)));
        //             }
        //         }
        //         $all_puskesmas = Puskesmas::whereIn('kabupaten', $array_balkes)->pluck('id');
        //         $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->whereIn('puskesmas_id', $all_puskesmas)
        //         ->where('periode', '>=', $start)->where('periode', '<=', $end)->get();
        //     }else{
        //         $provinsi = Provinsi::where('id', auth()->user()->provinsi_id)->first();
        //         $all_puskesmas = Puskesmas::where('provinsi', 'LIKE', "%{$provinsi->name}%")->get();
        //         // return $all_puskesmas;
        //         $all_puskesmas_id = array();
        //         foreach ($all_puskesmas as $pusk) {
        //             $all_puskesmas_id[] = $pusk->id;
        //         }
        //         $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->whereIn('puskesmas_id', $all_puskesmas_id)
        //         ->where('periode', '>=', $start)->where('periode', '<=', $end)->get();

        //     }
        // }

        // return $query;
    }

    private function getDataInderaPendengaranProv($kegiatan, $user, $puskesmas, $start, $end)
    {
        $query = Indera::where('kegiatan', 'LIKE', "%{$kegiatan}%")->where('puskesmas_id', $puskesmas)
        ->where('periode', '>=', $start)->where('periode', '<=', $end);


        return $query;
    }

    public function getDataPengelihatan(Request $request)
    {
        // return $request->all();
        // return "tes";
        $penglihatan = MasterIndera::select('id', 'kegiatan')->where('kategori_kegiatan', 0)->get();
        // return $penglihatan;
        // return $request->all();
        if ($request->periode_start != '') {
            $periode_start    = date('Y-m-d', strtotime('01-'.$request->periode_start));
        } else {
            $periode_start    = date('Y-m-d');
        }
        if ($request->periode_end != '') {
            $periode_end    = date('Y-m-d', strtotime('01-'.$request->periode_end));;
        } else {
            $periode_end    = date('Y-m-d');
        }

        $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);

        foreach ($penglihatan as $key => $value) {

            $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, auth()->user()->puskesmas_id, $periode_start, $periode_end);
            // return $check_data;
            // if ($check_data) {
            //     $value->id_kegiatan = $check_data->id;
            // }
            $value->no = $key + 1;
            $value->umur_0_7hr_l        = $check_data->sum('umur_0_7hr_l');
            $value->umur_0_7hr_p        = $check_data->sum('umur_0_7hr_p');
            $value->umur_2_28hr_l       = $check_data->sum('umur_2_28hr_l');
            $value->umur_2_28hr_p       = $check_data->sum('umur_2_28hr_p');
            $value->umur_1_11bln_l      = $check_data->sum('umur_1_11bln_l');
            $value->umur_1_11bln_p      = $check_data->sum('umur_1_11bln_p');
            $value->umur_1_4thn_l       = $check_data->sum('umur_1_4thn_l');
            $value->umur_1_4thn_p       = $check_data->sum('umur_1_4thn_p');
            $value->umur_5_9thn_l       = $check_data->sum('umur_5_9thn_l');
            $value->umur_5_9thn_p       = $check_data->sum('umur_5_9thn_p');
            $value->umur_10_14thn_l     = $check_data->sum('umur_10_14thn_l');
            $value->umur_10_14thn_p     = $check_data->sum('umur_10_14thn_p');
            $value->umur_15_19thn_l     = $check_data->sum('umur_15_19thn_l');
            $value->umur_15_19thn_p     = $check_data->sum('umur_15_19thn_p');
            $value->umur_20_44thn_l     = $check_data->sum('umur_20_44thn_l');
            $value->umur_20_44thn_p     = $check_data->sum('umur_20_44thn_p');
            $value->umur_45_59thn_l     = $check_data->sum('umur_45_59thn_l');
            $value->umur_45_59thn_p     = $check_data->sum('umur_45_59thn_p');
            $value->umur_lebih_59thn_l  = $check_data->sum('umur_lebih_59thn_l');
            $value->umur_lebih_59thn_p  = $check_data->sum('umur_lebih_59thn_p');
            $value->kasus_baru_l        = $check_data->sum('kasus_baru_l');
            $value->kasus_baru_p        = $check_data->sum('kasus_baru_p');
            $value->kasus_baru_total    = $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p');
            $value->kasus_lama_l        = $check_data->sum('kasus_lama_l');
            $value->kasus_lama_p        = $check_data->sum('kasus_lama_p');
            $value->kasus_lama_total    = $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p');
            $value->kunjungan_l         = $check_data->sum('kunjungan_l');
            $value->kunjungan_p         = $check_data->sum('kunjungan_p');
            $value->total_kunjungan     = $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p');
            $value->kasus_dirujuk         = $check_data->sum('kasus_dirujuk');
        }

        $array['umur_0_7hr_l']  = $penglihatan->sum('umur_0_7hr_l');
        $array['umur_0_7hr_p']  = $penglihatan->sum('umur_0_7hr_p');
        $array['umur_2_28hr_l'] = $penglihatan->sum('umur_2_28hr_l');
        $array['umur_2_28hr_p'] = $penglihatan->sum('umur_2_28hr_p');
        $array['umur_1_11bln_l']    = $penglihatan->sum('umur_1_11bln_l');
        $array['umur_1_11bln_p']    = $penglihatan->sum('umur_1_11bln_p');
        $array['umur_1_4thn_l'] = $penglihatan->sum('umur_1_4thn_l');
        $array['umur_1_4thn_p'] = $penglihatan->sum('umur_1_4thn_p');
        $array['umur_5_9thn_l'] = $penglihatan->sum('umur_5_9thn_l');
        $array['umur_5_9thn_p'] = $penglihatan->sum('umur_5_9thn_p');
        $array['umur_10_14thn_l']   = $penglihatan->sum('umur_10_14thn_l');
        $array['umur_10_14thn_p']   = $penglihatan->sum('umur_10_14thn_p');
        $array['umur_15_19thn_l']   = $penglihatan->sum('umur_15_19thn_l');
        $array['umur_15_19thn_p']   = $penglihatan->sum('umur_15_19thn_p');
        $array['umur_20_44thn_l']   = $penglihatan->sum('umur_20_44thn_l');
        $array['umur_20_44thn_p']   = $penglihatan->sum('umur_20_44thn_p');
        $array['umur_45_59thn_l']   = $penglihatan->sum('umur_45_59thn_l');
        $array['umur_45_59thn_p']   = $penglihatan->sum('umur_45_59thn_p');
        $array['umur_lebih_59thn_l']    = $penglihatan->sum('umur_lebih_59thn_l');
        $array['umur_lebih_59thn_p']    = $penglihatan->sum('umur_lebih_59thn_p');
        $array['kasus_baru_l']  = $penglihatan->sum('kasus_baru_l');
        $array['kasus_baru_p']  = $penglihatan->sum('kasus_baru_p');
        $array['kasus_baru_total']  = $penglihatan->sum('kasus_baru_total');
        $array['kasus_lama_l']  = $penglihatan->sum('kasus_lama_l');
        $array['kasus_lama_p']  = $penglihatan->sum('kasus_lama_p');
        $array['kasus_lama_total']  = $penglihatan->sum('kasus_lama_total');
        $array['kunjungan_l']   = $penglihatan->sum('kunjungan_l');
        $array['kunjungan_p']   = $penglihatan->sum('kunjungan_p');
        $array['total_kunjungan']   = $penglihatan->sum('total_kunjungan');
        $array['kasus_dirujuk']   = $penglihatan->sum('kasus_dirujuk');

        $json_data = array(
            "draw"            => intval(13),
            "recordsTotal"    => intval(13),
            "recordsFiltered" => intval(13),
            "data"            => $penglihatan,
            "sum_data"        => $array
        );

        return json_encode($json_data);
    }

    public function getDataPendengaran(Request $request)
    {
        // return 'tes';
        $penglihatan = MasterIndera::select('id', 'kegiatan')->where('kategori_kegiatan', 1)->get();
        // return $penglihatan;
        if ($request->periode_start != '') {
            $periode_start    = date('Y-m-d', strtotime('01-'.$request->periode_start));
        } else {
            $periode_start    = date('Y-m-d');
        }
        if ($request->periode_end != '') {
            $periode_end    = date('Y-m-d', strtotime('01-'.$request->periode_end));
        } else {
            $periode_end    = date('Y-m-d');
        }


        // return $request->all();
        $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
        // return $puskesmas;
        foreach ($penglihatan as $key => $value) {
            $check_data                 = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $puskesmas->id, $periode_start, $periode_end);
            $value->no                  = $key + 1;
            $value->umur_0_7hr_l        = $check_data->sum('umur_0_7hr_l');
            $value->umur_0_7hr_p        = $check_data->sum('umur_0_7hr_p');
            $value->umur_2_28hr_l       = $check_data->sum('umur_2_28hr_l');
            $value->umur_2_28hr_p       = $check_data->sum('umur_2_28hr_p');
            $value->umur_1_11bln_l      = $check_data->sum('umur_1_11bln_l');
            $value->umur_1_11bln_p      = $check_data->sum('umur_1_11bln_p');
            $value->umur_1_4thn_l       = $check_data->sum('umur_1_4thn_l');
            $value->umur_1_4thn_p       = $check_data->sum('umur_1_4thn_p');
            $value->umur_5_9thn_l       = $check_data->sum('umur_5_9thn_l');
            $value->umur_5_9thn_p       = $check_data->sum('umur_5_9thn_p');
            $value->umur_10_14thn_l     = $check_data->sum('umur_10_14thn_l');
            $value->umur_10_14thn_p     = $check_data->sum('umur_10_14thn_p');
            $value->umur_15_19thn_l     = $check_data->sum('umur_15_19thn_l');
            $value->umur_15_19thn_p     = $check_data->sum('umur_15_19thn_p');
            $value->umur_20_44thn_l     = $check_data->sum('umur_20_44thn_l');
            $value->umur_20_44thn_p     = $check_data->sum('umur_20_44thn_p');
            $value->umur_45_59thn_l     = $check_data->sum('umur_45_59thn_l');
            $value->umur_45_59thn_p     = $check_data->sum('umur_45_59thn_p');
            $value->umur_lebih_59thn_l  = $check_data->sum('umur_lebih_59thn_l');
            $value->umur_lebih_59thn_p  = $check_data->sum('umur_lebih_59thn_p');
            $value->kasus_baru_l        = $check_data->sum('kasus_baru_l');
            $value->kasus_baru_p        = $check_data->sum('kasus_baru_p');
            $value->kasus_baru_total    = $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p');
            $value->kasus_lama_l        = $check_data->sum('kasus_lama_l');
            $value->kasus_lama_p        = $check_data->sum('kasus_lama_p');
            $value->kasus_lama_total    = $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p');
            $value->kunjungan_l         = $check_data->sum('kunjungan_l');
            $value->kunjungan_p         = $check_data->sum('kunjungan_p');
            $value->total_kunjungan     = $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p');
            $value->kasus_dirujuk         = $check_data->sum('kasus_dirujuk');
        }



        // return $penglihatan;

        $array['umur_0_7hr_l'] = $penglihatan->sum('umur_0_7hr_l');
        $array['umur_0_7hr_p'] = $penglihatan->sum('umur_0_7hr_p');
        $array['umur_2_28hr_l'] = $penglihatan->sum('umur_2_28hr_l');
        $array['umur_2_28hr_p'] = $penglihatan->sum('umur_2_28hr_p');
        $array['umur_1_11bln_l'] = $penglihatan->sum('umur_1_11bln_l');
        $array['umur_1_11bln_p'] = $penglihatan->sum('umur_1_11bln_p');
        $array['umur_1_4thn_l'] = $penglihatan->sum('umur_1_4thn_l');
        $array['umur_1_4thn_p'] = $penglihatan->sum('umur_1_4thn_p');
        $array['umur_5_9thn_l'] = $penglihatan->sum('umur_5_9thn_l');
        $array['umur_5_9thn_p'] = $penglihatan->sum('umur_5_9thn_p');
        $array['umur_10_14thn_l'] = $penglihatan->sum('umur_10_14thn_l');
        $array['umur_10_14thn_p'] = $penglihatan->sum('umur_10_14thn_p');
        $array['umur_15_19thn_l'] = $penglihatan->sum('umur_15_19thn_l');
        $array['umur_15_19thn_p'] = $penglihatan->sum('umur_15_19thn_p');
        $array['umur_20_44thn_l'] = $penglihatan->sum('umur_20_44thn_l');
        $array['umur_20_44thn_p'] = $penglihatan->sum('umur_20_44thn_p');
        $array['umur_45_59thn_l'] = $penglihatan->sum('umur_45_59thn_l');
        $array['umur_45_59thn_p'] = $penglihatan->sum('umur_45_59thn_p');
        $array['umur_lebih_59thn_l'] = $penglihatan->sum('umur_lebih_59thn_l');
        $array['umur_lebih_59thn_p'] = $penglihatan->sum('umur_lebih_59thn_p');
        $array['kasus_baru_l'] = $penglihatan->sum('kasus_baru_l');
        $array['kasus_baru_p'] = $penglihatan->sum('kasus_baru_p');
        $array['kasus_baru_total'] = $penglihatan->sum('kasus_baru_total');
        $array['kasus_lama_l'] = $penglihatan->sum('kasus_lama_l');
        $array['kasus_lama_p'] = $penglihatan->sum('kasus_lama_p');
        $array['kasus_lama_total'] = $penglihatan->sum('kasus_lama_total');
        $array['kunjungan_l'] = $penglihatan->sum('kunjungan_l');
        $array['kunjungan_p'] = $penglihatan->sum('kunjungan_p');
        $array['total_kunjungan'] = $penglihatan->sum('total_kunjungan');
        $array['kasus_dirujuk'] = $penglihatan->sum('kasus_dirujuk');
        $json_data = array(
            "draw"            => intval(13),
            "recordsTotal"    => intval(13),
            "recordsFiltered" => intval(13),
            "data"            => $penglihatan,
            "sum_data"        => $array
        );
        return json_encode($json_data);
    }

    private function getKegiatan($id)
    {
        $data = MasterIndera::find($id);
        return $data;
    }

    public function simpan(Request $request)
    {
        $data = explode('-', $request->id);
        $field  = $data[1];
        $master_indera = $this->getKegiatan($data[0]);
        $check_data = Indera::where('user_id', auth()->user()->id)->where('puskesmas_id', auth()->user()->puskesmas_id)->where('kegiatan', $master_indera->kegiatan)->whereMonth('periode', date('m', strtotime('01-'.$request->tahun)))->whereYear('periode', date('Y', strtotime('01-'.$request->tahun)))->first();

            if ($check_data){
                $result = Indera::find($check_data->id);
                $result->$field     = $request->nilai;
                $result->periode    = date('Y-m-d', strtotime('01-'.$request->tahun));
                if ($result->save()) {
                    $json_data = array(
                        'success'   => TRUE,
                        'code'      => 201,
                        'message'   => 'data berhasil diupdate'
                    );
                } else {
                    $json_data = array(
                        'success'   => TRUE,
                        'code'      => 401,
                        'message'   => 'data gagal diupdate'
                    );
                }
            } else {
                $result = new Indera;
                $result->user_id    = auth()->user()->id;
                $result->puskesmas_id   = auth()->user()->puskesmas_id;
                $result->kegiatan   = $master_indera->kegiatan;
                $result->$field     = $request->nilai;
                $result->periode    = date('Y-m-d', strtotime('01-'.$request->tahun));
                if ($result->save()) {
                    $json_data = array(
                        'success'   => TRUE,
                        'code'      => 201,
                        'message'   => 'data berhasil diupdate'
                    );
                } else {
                    $json_data = array(
                        'success'   => True,
                        'code'      => 401,
                        'message'   => 'data gagal diupdate'
                    );
                }
            }
        // } else {
        //     $json_data  = array(
        //         'success'   => false,
        //         'code'      => 301,
        //         'message'   => 'Maaf anda tidak memiliki akses untuk mengubah data'
        //     );
        // }

        return response()->json($json_data);
    }
    private function penglihatan_print($request){
        // return $request->all();
        $penglihatan = MasterIndera::select('id', 'kegiatan')->where('kategori_kegiatan', 0)->get();
        if ($request->start != '') {
            $periode_start    = date('Y-m-d', strtotime('01-'.$request->start));
        } else {
            $periode_start    = date('Y-m-d');
        }
        if ($request->end != '') {
            $periode_end    = date('Y-m-d', strtotime('01-'.$request->end));;
        } else {
            $periode_end    = date('Y-m-d');
        }
        if ($request->user()->can('provinsi.index')) {

            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                    // return $check_data;
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                    // return $check_data;
                } else {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);

                }
                if ($kabupaten_id == null && $puskesmas_id == null) {
                    // return $check_data;
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;
                }elseif($kabupaten_id != null && $puskesmas_id == null) {
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;
                }else{
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->umur_0_7hr_l : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->umur_0_7hr_p : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->umur_2_28hr_l : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->umur_2_28hr_p : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->umur_1_11bln_l : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->umur_1_11bln_p : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->umur_1_4thn_l : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->umur_1_4thn_p : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->umur_5_9thn_l : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->umur_5_9thn_p : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->umur_10_14thn_l : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->umur_10_14thn_p : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->umur_15_19thn_l : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->umur_15_19thn_p : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->umur_20_44thn_l : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->umur_20_44thn_p : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->umur_45_59thn_l : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->umur_45_59thn_p : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->umur_lebih_59thn_l : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->umur_lebih_59thn_p : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->kasus_baru_l : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->kasus_baru_p : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->kasus_baru_l + $check_data->kasus_baru_p : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->kasus_lama_l : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->kasus_lama_p : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->kasus_lama_l + $check_data->kasus_lama_p : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->kunjungan_l : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->kunjungan_p : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->kunjungan_l + $check_data->kunjungan_p : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->kasus_dirujuk : 0;
                }
            }
        }else if(auth()->user()->can('balkesmas.index')){
            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            // return null;
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                    // return $check_data;
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                    // return $check_data;
                } else {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);
                    // return $check_data;
                }
                if ($kabupaten_id == null && $puskesmas_id == null) {
                    // return $check_data;
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;
                }elseif($kabupaten_id != null && $puskesmas_id == null) {
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;
                }else{
                    $value->no = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->umur_0_7hr_l : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->umur_0_7hr_p : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->umur_2_28hr_l : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->umur_2_28hr_p : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->umur_1_11bln_l : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->umur_1_11bln_p : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->umur_1_4thn_l : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->umur_1_4thn_p : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->umur_5_9thn_l : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->umur_5_9thn_p : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->umur_10_14thn_l : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->umur_10_14thn_p : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->umur_15_19thn_l : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->umur_15_19thn_p : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->umur_20_44thn_l : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->umur_20_44thn_p : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->umur_45_59thn_l : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->umur_45_59thn_p : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->umur_lebih_59thn_l : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->umur_lebih_59thn_p : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->kasus_baru_l : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->kasus_baru_p : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->kasus_baru_l + $check_data->kasus_baru_p : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->kasus_lama_l : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->kasus_lama_p : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->kasus_lama_l + $check_data->kasus_lama_p : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->kunjungan_l : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->kunjungan_p : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->kunjungan_l + $check_data->kunjungan_p : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->kasus_dirujuk : 0;
                }
            }
        }else if ($request->user()->can('kabupaten.index')) {
            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            // return null;
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                } else {
                    $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);
                }
                $value->no = $key + 1;
                $value->umur_0_7hr_l        = $check_data->sum('umur_0_7hr_l');
                $value->umur_0_7hr_p        = $check_data->sum('umur_0_7hr_p');
                $value->umur_2_28hr_l       = $check_data->sum('umur_2_28hr_l');
                $value->umur_2_28hr_p       = $check_data->sum('umur_2_28hr_p');
                $value->umur_1_11bln_l      = $check_data->sum('umur_1_11bln_l');
                $value->umur_1_11bln_p      = $check_data->sum('umur_1_11bln_p');
                $value->umur_1_4thn_l       = $check_data->sum('umur_1_4thn_l');
                $value->umur_1_4thn_p       = $check_data->sum('umur_1_4thn_p');
                $value->umur_5_9thn_l       = $check_data->sum('umur_5_9thn_l');
                $value->umur_5_9thn_p       = $check_data->sum('umur_5_9thn_p');
                $value->umur_10_14thn_l     = $check_data->sum('umur_10_14thn_l');
                $value->umur_10_14thn_p     = $check_data->sum('umur_10_14thn_p');
                $value->umur_15_19thn_l     = $check_data->sum('umur_15_19thn_l');
                $value->umur_15_19thn_p     = $check_data->sum('umur_15_19thn_p');
                $value->umur_20_44thn_l     = $check_data->sum('umur_20_44thn_l');
                $value->umur_20_44thn_p     = $check_data->sum('umur_20_44thn_p');
                $value->umur_45_59thn_l     = $check_data->sum('umur_45_59thn_l');
                $value->umur_45_59thn_p     = $check_data->sum('umur_45_59thn_p');
                $value->umur_lebih_59thn_l  = $check_data->sum('umur_lebih_59thn_l');
                $value->umur_lebih_59thn_p  = $check_data->sum('umur_lebih_59thn_p');
                $value->kasus_baru_l        = $check_data->sum('kasus_baru_l');
                $value->kasus_baru_p        = $check_data->sum('kasus_baru_p');
                $value->kasus_baru_total    = $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p');
                $value->kasus_lama_l        = $check_data->sum('kasus_lama_l');
                $value->kasus_lama_p        = $check_data->sum('kasus_lama_p');
                $value->kasus_lama_total    = $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p');
                $value->kunjungan_l         = $check_data->sum('kunjungan_l');
                $value->kunjungan_p         = $check_data->sum('kunjungan_p');
                $value->total_kunjungan     = $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p');
                $value->kasus_dirujuk         = $check_data->sum('kasus_dirujuk');
            }
        } else if ($request->user()->can('puskesmas.index')) {
            $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
            $kabupaten = Kabupaten::where('name', 'LIKE', "%{$puskesmas->kabupaten}%")->first();
            foreach ($penglihatan as $key => $value) {

                $check_data = $this->getDataInderaPenglihatanProv($value->kegiatan, auth()->user()->id, $kabupaten->id, auth()->user()->puskesmas_id, $periode_start, $periode_end);
                // return $check_data;
                // if ($check_data) {
                //     $value->id_kegiatan = $check_data->id;
                // }
                $value->no = $key + 1;
                $value->umur_0_7hr_l        = $check_data->sum('umur_0_7hr_l');
                $value->umur_0_7hr_p        = $check_data->sum('umur_0_7hr_p');
                $value->umur_2_28hr_l       = $check_data->sum('umur_2_28hr_l');
                $value->umur_2_28hr_p       = $check_data->sum('umur_2_28hr_p');
                $value->umur_1_11bln_l      = $check_data->sum('umur_1_11bln_l');
                $value->umur_1_11bln_p      = $check_data->sum('umur_1_11bln_p');
                $value->umur_1_4thn_l       = $check_data->sum('umur_1_4thn_l');
                $value->umur_1_4thn_p       = $check_data->sum('umur_1_4thn_p');
                $value->umur_5_9thn_l       = $check_data->sum('umur_5_9thn_l');
                $value->umur_5_9thn_p       = $check_data->sum('umur_5_9thn_p');
                $value->umur_10_14thn_l     = $check_data->sum('umur_10_14thn_l');
                $value->umur_10_14thn_p     = $check_data->sum('umur_10_14thn_p');
                $value->umur_15_19thn_l     = $check_data->sum('umur_15_19thn_l');
                $value->umur_15_19thn_p     = $check_data->sum('umur_15_19thn_p');
                $value->umur_20_44thn_l     = $check_data->sum('umur_20_44thn_l');
                $value->umur_20_44thn_p     = $check_data->sum('umur_20_44thn_p');
                $value->umur_45_59thn_l     = $check_data->sum('umur_45_59thn_l');
                $value->umur_45_59thn_p     = $check_data->sum('umur_45_59thn_p');
                $value->umur_lebih_59thn_l  = $check_data->sum('umur_lebih_59thn_l');
                $value->umur_lebih_59thn_p  = $check_data->sum('umur_lebih_59thn_p');
                $value->kasus_baru_l        = $check_data->sum('kasus_baru_l');
                $value->kasus_baru_p        = $check_data->sum('kasus_baru_p');
                $value->kasus_baru_total    = $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p');
                $value->kasus_lama_l        = $check_data->sum('kasus_lama_l');
                $value->kasus_lama_p        = $check_data->sum('kasus_lama_p');
                $value->kasus_lama_total    = $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p');
                $value->kunjungan_l         = $check_data->sum('kunjungan_l');
                $value->kunjungan_p         = $check_data->sum('kunjungan_p');
                $value->total_kunjungan     = $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p');
                $value->kasus_dirujuk         = $check_data->sum('kasus_dirujuk');
            }
        }
        $array['umur_0_7hr_l']  = $penglihatan->sum('umur_0_7hr_l');
        $array['umur_0_7hr_p']  = $penglihatan->sum('umur_0_7hr_p');
        $array['umur_2_28hr_l'] = $penglihatan->sum('umur_2_28hr_l');
        $array['umur_2_28hr_p'] = $penglihatan->sum('umur_2_28hr_p');
        $array['umur_1_11bln_l']    = $penglihatan->sum('umur_1_11bln_l');
        $array['umur_1_11bln_p']    = $penglihatan->sum('umur_1_11bln_p');
        $array['umur_1_4thn_l'] = $penglihatan->sum('umur_1_4thn_l');
        $array['umur_1_4thn_p'] = $penglihatan->sum('umur_1_4thn_p');
        $array['umur_5_9thn_l'] = $penglihatan->sum('umur_5_9thn_l');
        $array['umur_5_9thn_p'] = $penglihatan->sum('umur_5_9thn_p');
        $array['umur_10_14thn_l']   = $penglihatan->sum('umur_10_14thn_l');
        $array['umur_10_14thn_p']   = $penglihatan->sum('umur_10_14thn_p');
        $array['umur_15_19thn_l']   = $penglihatan->sum('umur_15_19thn_l');
        $array['umur_15_19thn_p']   = $penglihatan->sum('umur_15_19thn_p');
        $array['umur_20_44thn_l']   = $penglihatan->sum('umur_20_44thn_l');
        $array['umur_20_44thn_p']   = $penglihatan->sum('umur_20_44thn_p');
        $array['umur_45_59thn_l']   = $penglihatan->sum('umur_45_59thn_l');
        $array['umur_45_59thn_p']   = $penglihatan->sum('umur_45_59thn_p');
        $array['umur_lebih_59thn_l']    = $penglihatan->sum('umur_lebih_59thn_l');
        $array['umur_lebih_59thn_p']    = $penglihatan->sum('umur_lebih_59thn_p');
        $array['kasus_baru_l']  = $penglihatan->sum('kasus_baru_l');
        $array['kasus_baru_p']  = $penglihatan->sum('kasus_baru_p');
        $array['kasus_baru_total']  = $penglihatan->sum('kasus_baru_total');
        $array['kasus_lama_l']  = $penglihatan->sum('kasus_lama_l');
        $array['kasus_lama_p']  = $penglihatan->sum('kasus_lama_p');
        $array['kasus_lama_total']  = $penglihatan->sum('kasus_lama_total');
        $array['kunjungan_l']   = $penglihatan->sum('kunjungan_l');
        $array['kunjungan_p']   = $penglihatan->sum('kunjungan_p');
        $array['total_kunjungan']   = $penglihatan->sum('total_kunjungan');
        $array['kasus_dirujuk']   = $penglihatan->sum('kasus_dirujuk');
        // if ($request->user()->can('indera.index')) {
        //     $json_data = array(
        //         "draw"            => intval(13),
        //         "recordsTotal"    => intval(13),
        //         "recordsFiltered" => intval(13),
        //         "data"            => $penglihatan,
        //         "sum_data"        => $array
        //     );
        // } else {
        //     $json_data = array(
        //         "draw"            => intval($request->input('draw')),
        //         "recordsTotal"    => 0,
        //         "recordsFiltered" => 0,
        //         "data"            => [],
        //         "sum_data"        => []
        //     );
        // }
        return $result = array('penglihatan' => $penglihatan, 'sum_data' => $array);
        // return json_encode($json_data);

    }
    private function pendengaran_print($request){
        $penglihatan = MasterIndera::select('id', 'kegiatan')->where('kategori_kegiatan', 1)->where('parent_id', '!=', NULL)->get();
        if ($request->start != '') {
            $periode_start    = '01-' . $request->start;
        } else {
            $periode_start    = date('Y-m-d');
        }
        if ($request->end != '') {
            $periode_end    = '01-' . $request->end;
        } else {
            $periode_end    = date('Y-m-d');
        }

        if ($request->user()->can('provinsi.index')) {
            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                } else {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);
                }
                if ($kabupaten_id == null && $puskesmas_id == null) {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;

                }elseif($kabupaten_id != null && $puskesmas_id == null) {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;

                }else{
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->umur_0_7hr_l : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->umur_0_7hr_p : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->umur_2_28hr_l : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->umur_2_28hr_p : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->umur_1_11bln_l : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->umur_1_11bln_p : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->umur_1_4thn_l : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->umur_1_4thn_p : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->umur_5_9thn_l : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->umur_5_9thn_p : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->umur_10_14thn_l : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->umur_10_14thn_p : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->umur_15_19thn_l : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->umur_15_19thn_p : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->umur_20_44thn_l : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->umur_20_44thn_p : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->umur_45_59thn_l : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->umur_45_59thn_p : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->umur_lebih_59thn_l : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->umur_lebih_59thn_p : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->kasus_baru_l : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->kasus_baru_p : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->kasus_baru_l + $check_data->kasus_baru_p : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->kasus_lama_l : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->kasus_lama_p : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->kasus_lama_l + $check_data->kasus_lama_p : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->kunjungan_l : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->kunjungan_p : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->kunjungan_l + $check_data->kunjungan_p : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->kasus_dirujuk : 0;
                }
            }
        }elseif(auth()->user()->can('balkesmas.index')){
            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                } else {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);
                }
                if ($kabupaten_id == null && $puskesmas_id == null) {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk         = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;

                }elseif($kabupaten_id != null && $puskesmas_id == null) {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;

                }else{
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->umur_0_7hr_l : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->umur_0_7hr_p : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->umur_2_28hr_l : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->umur_2_28hr_p : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->umur_1_11bln_l : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->umur_1_11bln_p : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->umur_1_4thn_l : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->umur_1_4thn_p : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->umur_5_9thn_l : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->umur_5_9thn_p : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->umur_10_14thn_l : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->umur_10_14thn_p : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->umur_15_19thn_l : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->umur_15_19thn_p : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->umur_20_44thn_l : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->umur_20_44thn_p : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->umur_45_59thn_l : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->umur_45_59thn_p : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->umur_lebih_59thn_l : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->umur_lebih_59thn_p : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->kasus_baru_l : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->kasus_baru_p : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->kasus_baru_l + $check_data->kasus_baru_p : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->kasus_lama_l : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->kasus_lama_p : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->kasus_lama_l + $check_data->kasus_lama_p : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->kunjungan_l : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->kunjungan_p : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->kunjungan_l + $check_data->kunjungan_p : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->kasus_dirujuk : 0;

                }
            }
        }elseif ($request->user()->can('kabupaten.index')) {
            if ($request->kabupaten != "") {
                $kabupaten_id = $request->kabupaten;
            } else {
                $kabupaten_id = null;
            }
            if ($request->puskesmas != "") {
                $puskesmas_id = $request->puskesmas;
            } else {
                $puskesmas_id = null;
            }
            foreach ($penglihatan as $key => $value) {
                if ($kabupaten_id != null && $puskesmas_id != null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, $puskesmas_id, $periode_start, $periode_end);
                } elseif ($kabupaten_id != null && $puskesmas_id == null) {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten_id, null, $periode_start, $periode_end);
                } else {
                    $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, null, null, $periode_start, $periode_end);
                }
                if ($kabupaten_id != null && $puskesmas_id == null) {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->sum('umur_0_7hr_l') : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->sum('umur_0_7hr_p') : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->sum('umur_2_28hr_l') : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->sum('umur_2_28hr_p') : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->sum('umur_1_11bln_l') : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->sum('umur_1_11bln_p') : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->sum('umur_1_4thn_l') : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->sum('umur_1_4thn_p') : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->sum('umur_5_9thn_l') : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->sum('umur_5_9thn_p') : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->sum('umur_10_14thn_l') : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->sum('umur_10_14thn_p') : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->sum('umur_15_19thn_l') : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->sum('umur_15_19thn_p') : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->sum('umur_20_44thn_l') : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->sum('umur_20_44thn_p') : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->sum('umur_45_59thn_l') : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->sum('umur_45_59thn_p') : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_l') : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->sum('umur_lebih_59thn_p') : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->sum('kasus_baru_l') : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->sum('kasus_lama_l') : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->sum('kasus_lama_p') : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->sum('kunjungan_l') : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->sum('kunjungan_p') : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->sum('kasus_dirujuk') : 0;

                } else {
                    $value->no                  = $key + 1;
                    $value->umur_0_7hr_l        = isset($check_data) ? $check_data->umur_0_7hr_l : 0;
                    $value->umur_0_7hr_p        = isset($check_data) ? $check_data->umur_0_7hr_p : 0;
                    $value->umur_2_28hr_l       = isset($check_data) ? $check_data->umur_2_28hr_l : 0;
                    $value->umur_2_28hr_p       = isset($check_data) ? $check_data->umur_2_28hr_p : 0;
                    $value->umur_1_11bln_l      = isset($check_data) ? $check_data->umur_1_11bln_l : 0;
                    $value->umur_1_11bln_p      = isset($check_data) ? $check_data->umur_1_11bln_p : 0;
                    $value->umur_1_4thn_l       = isset($check_data) ? $check_data->umur_1_4thn_l : 0;
                    $value->umur_1_4thn_p       = isset($check_data) ? $check_data->umur_1_4thn_p : 0;
                    $value->umur_5_9thn_l       = isset($check_data) ? $check_data->umur_5_9thn_l : 0;
                    $value->umur_5_9thn_p       = isset($check_data) ? $check_data->umur_5_9thn_p : 0;
                    $value->umur_10_14thn_l     = isset($check_data) ? $check_data->umur_10_14thn_l : 0;
                    $value->umur_10_14thn_p     = isset($check_data) ? $check_data->umur_10_14thn_p : 0;
                    $value->umur_15_19thn_l     = isset($check_data) ? $check_data->umur_15_19thn_l : 0;
                    $value->umur_15_19thn_p     = isset($check_data) ? $check_data->umur_15_19thn_p : 0;
                    $value->umur_20_44thn_l     = isset($check_data) ? $check_data->umur_20_44thn_l : 0;
                    $value->umur_20_44thn_p     = isset($check_data) ? $check_data->umur_20_44thn_p : 0;
                    $value->umur_45_59thn_l     = isset($check_data) ? $check_data->umur_45_59thn_l : 0;
                    $value->umur_45_59thn_p     = isset($check_data) ? $check_data->umur_45_59thn_p : 0;
                    $value->umur_lebih_59thn_l  = isset($check_data) ? $check_data->umur_lebih_59thn_l : 0;
                    $value->umur_lebih_59thn_p  = isset($check_data) ? $check_data->umur_lebih_59thn_p : 0;
                    $value->kasus_baru_l        = isset($check_data) ? $check_data->kasus_baru_l : 0;
                    $value->kasus_baru_p        = isset($check_data) ? $check_data->kasus_baru_p : 0;
                    $value->kasus_baru_total    = isset($check_data) ? $check_data->kasus_baru_l + $check_data->kasus_baru_p : 0;
                    $value->kasus_lama_l        = isset($check_data) ? $check_data->kasus_lama_l : 0;
                    $value->kasus_lama_p        = isset($check_data) ? $check_data->kasus_lama_p : 0;
                    $value->kasus_lama_total    = isset($check_data) ? $check_data->kasus_lama_l + $check_data->kasus_lama_p : 0;
                    $value->kunjungan_l         = isset($check_data) ? $check_data->kunjungan_l : 0;
                    $value->kunjungan_p         = isset($check_data) ? $check_data->kunjungan_p : 0;
                    $value->total_kunjungan     = isset($check_data) ? $check_data->kunjungan_l + $check_data->kunjungan_p : 0;
                    $value->kasus_dirujuk       = isset($check_data) ? $check_data->kasus_dirujuk : 0;
                }
            }
        } else if ($request->user()->can('puskesmas.index')) {
            // return $request->all();
            $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
            $kabupaten = Kabupaten::where('name', 'LIKE', "%{$puskesmas->kabupaten}%")->first();
            foreach ($penglihatan as $key => $value) {
                $check_data = $this->getDataInderaPendengaranProv($value->kegiatan, auth()->user()->id, $kabupaten->id, $puskesmas->id, $periode_start, $periode_end);
                $value->no                  = $key + 1;
                $value->umur_0_7hr_l        = $check_data->sum('umur_0_7hr_l') ;
                $value->umur_0_7hr_p        = $check_data->sum('umur_0_7hr_p') ;
                $value->umur_2_28hr_l       = $check_data->sum('umur_2_28hr_l') ;
                $value->umur_2_28hr_p       = $check_data->sum('umur_2_28hr_p') ;
                $value->umur_1_11bln_l      = $check_data->sum('umur_1_11bln_l') ;
                $value->umur_1_11bln_p      = $check_data->sum('umur_1_11bln_p') ;
                $value->umur_1_4thn_l       = $check_data->sum('umur_1_4thn_l') ;
                $value->umur_1_4thn_p       = $check_data->sum('umur_1_4thn_p') ;
                $value->umur_5_9thn_l       = $check_data->sum('umur_5_9thn_l') ;
                $value->umur_5_9thn_p       = $check_data->sum('umur_5_9thn_p') ;
                $value->umur_10_14thn_l     = $check_data->sum('umur_10_14thn_l') ;
                $value->umur_10_14thn_p     = $check_data->sum('umur_10_14thn_p') ;
                $value->umur_15_19thn_l     = $check_data->sum('umur_15_19thn_l') ;
                $value->umur_15_19thn_p     = $check_data->sum('umur_15_19thn_p') ;
                $value->umur_20_44thn_l     = $check_data->sum('umur_20_44thn_l') ;
                $value->umur_20_44thn_p     = $check_data->sum('umur_20_44thn_p') ;
                $value->umur_45_59thn_l     = $check_data->sum('umur_45_59thn_l') ;
                $value->umur_45_59thn_p     = $check_data->sum('umur_45_59thn_p') ;
                $value->umur_lebih_59thn_l  = $check_data->sum('umur_lebih_59thn_l') ;
                $value->umur_lebih_59thn_p  = $check_data->sum('umur_lebih_59thn_p') ;
                $value->kasus_baru_l        = $check_data->sum('kasus_baru_l') ;
                $value->kasus_baru_p        = $check_data->sum('kasus_baru_p') ;
                $value->kasus_baru_total    = $check_data->sum('kasus_baru_l') + $check_data->sum('kasus_baru_p') ;
                $value->kasus_lama_l        = $check_data->sum('kasus_lama_l') ;
                $value->kasus_lama_p        = $check_data->sum('kasus_lama_p') ;
                $value->kasus_lama_total    = $check_data->sum('kasus_lama_l') + $check_data->sum('kasus_lama_p') ;
                $value->kunjungan_l         = $check_data->sum('kunjungan_l') ;
                $value->kunjungan_p         = $check_data->sum('kunjungan_p') ;
                $value->total_kunjungan     = $check_data->sum('kunjungan_l') + $check_data->sum('kunjungan_p') ;
                $value->kasus_dirujuk       = $check_data->sum('kasus_dirujuk') ;
            }
        }


        // return $penglihatan;

            $array['umur_0_7hr_l'] = $penglihatan->sum('umur_0_7hr_l');
            $array['umur_0_7hr_p'] = $penglihatan->sum('umur_0_7hr_p');
            $array['umur_2_28hr_l'] = $penglihatan->sum('umur_2_28hr_l');
            $array['umur_2_28hr_p'] = $penglihatan->sum('umur_2_28hr_p');
            $array['umur_1_11bln_l'] = $penglihatan->sum('umur_1_11bln_l');
            $array['umur_1_11bln_p'] = $penglihatan->sum('umur_1_11bln_p');
            $array['umur_1_4thn_l'] = $penglihatan->sum('umur_1_4thn_l');
            $array['umur_1_4thn_p'] = $penglihatan->sum('umur_1_4thn_p');
            $array['umur_5_9thn_l'] = $penglihatan->sum('umur_5_9thn_l');
            $array['umur_5_9thn_p'] = $penglihatan->sum('umur_5_9thn_p');
            $array['umur_10_14thn_l'] = $penglihatan->sum('umur_10_14thn_l');
            $array['umur_10_14thn_p'] = $penglihatan->sum('umur_10_14thn_p');
            $array['umur_15_19thn_l'] = $penglihatan->sum('umur_15_19thn_l');
            $array['umur_15_19thn_p'] = $penglihatan->sum('umur_15_19thn_p');
            $array['umur_20_44thn_l'] = $penglihatan->sum('umur_20_44thn_l');
            $array['umur_20_44thn_p'] = $penglihatan->sum('umur_20_44thn_p');
            $array['umur_45_59thn_l'] = $penglihatan->sum('umur_45_59thn_l');
            $array['umur_45_59thn_p'] = $penglihatan->sum('umur_45_59thn_p');
            $array['umur_lebih_59thn_l'] = $penglihatan->sum('umur_lebih_59thn_l');
            $array['umur_lebih_59thn_p'] = $penglihatan->sum('umur_lebih_59thn_p');
            $array['kasus_baru_l'] = $penglihatan->sum('kasus_baru_l');
            $array['kasus_baru_p'] = $penglihatan->sum('kasus_baru_p');
            $array['kasus_baru_total'] = $penglihatan->sum('kasus_baru_total');
            $array['kasus_lama_l'] = $penglihatan->sum('kasus_lama_l');
            $array['kasus_lama_p'] = $penglihatan->sum('kasus_lama_p');
            $array['kasus_lama_total'] = $penglihatan->sum('kasus_lama_total');
            $array['kunjungan_l'] = $penglihatan->sum('kunjungan_l');
            $array['kunjungan_p'] = $penglihatan->sum('kunjungan_p');
            $array['total_kunjungan'] = $penglihatan->sum('total_kunjungan');
            $array['kasus_dirujuk'] = $penglihatan->sum('kasus_dirujuk');
        $alldata['pendengaran'] = $penglihatan;
        $alldata['sum_data'] = $array;
        return $alldata;

    }
    public function cetak_pdf(Request $request){
        // return $request->all();
        $penglihatan = $this->penglihatan_print($request);
        // return $penglihatan;
        // return $penglihatan['penglihatan'];
        $pendengaran = $this->pendengaran_print($request);
        // return $pendengaran;
        if(auth()->user()->can('puskesmas.index')){
            $puskesmas = Puskesmas::find(auth()->user()->puskesmas_id);
            $pendengaran['data'] = array('start' => $request->start, 'end' => $request->end, 'name' => $puskesmas->name);
            // return $pendengaran;
        }elseif(auth()->user()->can('kabupaten.index')){
            $kabupaten = Kabupaten::find(auth()->user()->kabupaten_id);
            $pendengaran['data'] = array('start' => $request->start, 'end' => $request->end, 'name' => $kabupaten->name);
        }elseif(auth()->user()->can('balkesmas.index')){
            $balkesmas = Balkesmas::find(auth()->user()->balkesmas_id);
            $pendengaran['data'] = array('start' => $request->start, 'end' => $request->end, 'name' => $balkesmas->name);
        }elseif(auth()->user()->can('provinsi.index')){
            $provinsi = Provinsi::find(auth()->user()->provinsi);
            $pendengaran['data'] = array('start' => $request->start, 'end' => $request->end, 'name' => $provinsi->name);
        }
        $view = 'template/kasus/indera/cetak';
        if($request->cetakan == 'excel'){
            return Excel::download(new ExportExcel2($penglihatan, $pendengaran, $view), 'KasusIndera.xlsx');
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
            'title'                 => 'Data Rekapitulasi Gangguan Indera Penglihatan dan Pendengaran',
            'author'                => '',
            'watermark'             => '',
            'show_watermark'        => true,
            'show_watermark_image'  => true,
            'watermark_font'        => 'sans-serif',
            'display_mode'          => 'fullpage',
            'watermark_text_alpha'  => 0.2,
        ];
        $pdf = PDF::loadview('template/kasus/indera/cetak',['data' => $penglihatan, 'data2' => $pendengaran],[],$config);
        return $pdf->download('laporan-kasus-indera.pdf');

    }
}
