<?php

namespace App\Http\Controllers\Simpusk;

// use App\Http\Controllers\Controller;
use App\Models\Simpusk\AntrianBPJS;
use App\Models\Simpusk\Pasien;
use App\Models\Simpusk\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function ambil_antrian($request, $pendaftaran, $no_antrian_bpjs){
        $poli = Poli::find($request->id_poli);
        $data = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_antrian', 'LIKE', $poli->kode_poli.'%')->orderBy('id', 'DESC')->first();
        if(!isset($data)){
            $no_antrian = $poli->kode_poli."1";
        }else{
            $no_antrian = $poli->kode_poli."".(substr($data->no_antrian,1)+1);
        }
        $antrian = new AntrianBPJS;
        $antrian->id_pendaftaran = $pendaftaran->id;
        $antrian->no_kartu  = $pendaftaran->no_bpjs;
        $antrian->no_ktp    = Pasien::where('no_rekamedis', $pendaftaran->no_rekamedis)->first()->no_ktp;
        $antrian->code_poli = Poli::find($pendaftaran->id_poli)->kdpoli;
        $antrian->no_antrian = $no_antrian;
        $antrian->no_antrian_bpjs = $no_antrian_bpjs;
        $antrian->tgl_daftar = date('Y-m-d', strtotime($pendaftaran->tanggal_daftar));
        if($antrian->save()){

            $cetak_antrian = collect([
                'poli' => $poli->nama_poli,
                'no_antrian' => $antrian->no_antrian,
            ]);
            return response()->json([
                "success"         => TRUE,
                'antrian'      => $cetak_antrian,
                "code"            => 201,
                "message"         => "Pasien berhasil didaftarkan"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Pendaftaran antrian gagal disimpan di database SIMPUSK',
            ]);

        }
    }
    public function postantrian(Request $req){
        $poli = Poli::where('kdpoli', $req->kdpoli)->first();
        $data = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('no_antrian', 'LIKE', $poli->kode_poli.'%')->orderBy('id', 'DESC')->first();
        if(!isset($data)){
            $no_antrian = $poli->kode_poli."1";
        }else{
            $no_antrian = $poli->kode_poli."".(substr($data->no_antrian,1)+1);
        }
        $antrian = new AntrianBPJS;
        $antrian->tgl_daftar = date('Y-m-d' );
        $antrian->no_antrian = $no_antrian;
        $antrian->code_poli = $req->kdpoli;
        $antrian->save();
        $antrian->poli = $antrian->poli;
        return $antrian;
        // return $no_antrian;
    }
    public function updateantrian($kdpoli, $pendaftaran, $no_antrian_bpjs){
        $poli = $kdpoli;
        $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime($pendaftaran->tanggal_daftar)))
        ->where('no_antrian', 'LIKE', $poli->kode_poli.'%')
        ->where('status', 0)
        ->where('status_daftar', 0)
        ->orderBy('id', 'ASC')
        ->where('id_pendaftaran', '=', NULL)
        ->first();
        if(isset($antrian)){
            if($pendaftaran->save()){
                $antrian->id_pendaftaran = $pendaftaran->id;
                $antrian->no_kartu  = $pendaftaran->no_bpjs;
                $antrian->no_ktp    = $pendaftaran->pasien->no_ktp;
                $antrian->code_poli = $poli->kdpoli;
                $antrian->no_antrian_bpjs = $no_antrian_bpjs;
                $antrian->status_daftar = 1;
                $antrian->status = 1;
                if($antrian->save()){
                    $cetak_antrian = collect([
                        'poli' => $poli->nama_poli,
                        'no_antrian' => $antrian->no_antrian,
                    ]);
                    return response()->json([
                        "success"         => TRUE,
                        'antrian'      => $cetak_antrian,
                        "code"            => 201,
                        "message"         => "Pasien berhasil didaftarkan"
                    ]);
            }
            }else{
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'Pendaftaran antrian gagal disimpan di database SIMPUSK',
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'Belum mengambil Antrian',
            ]);
        }
    }
    public function index(){
        return view('antrian.antrian');
    }
    public function getData(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $page  = $start +1;
        $search = $request->search['value'];
        $search_tgl = $request->search_tgl;
        $records = AntrianBPJS::where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())));
        $datacol = $records->get();
        $datacollect = collect([]);
        foreach($datacol as $d){
            $datacollect->push($d);
        }
        $datagroup = $datacollect->groupBy('code_poli');
        if($search) {
            $records->where(function ($query) use ($search) {
                    $query->orWhere('no_rawat','LIKE',"%{$search}%");
                    $query->orWhere('tbl_pendaftaran.no_rekamedis','LIKE',"%{$search}%");
                    $query->orWhere('nama_pasien','LIKE',"%{$search}%");
                    $query->orWhere('tbl_pendaftaran.status_pasien','LIKE',"%{$search}%");
                    $query->orWhere('tbl_poli.nama_poli','LIKE',"%{$search}%");
            });
        }
        $totalData = $datagroup->count();

        $totalFiltered = $datagroup->count();
        $data = $datagroup;
        $no = 0;
        $datates = collect([]);
        foreach ($data as $key => $record)
        {
            $enc_id = $key;
            $antrian_saat_ini = 1;
            foreach($record as $r){
                if($r->status == 1){
                    $antrian_saat_ini++;
                }else{
                    continue;
                }
            }
            $pol = Poli::where('kdpoli', $key)->first();
            $recordcollect['no'] = $no + $page;
            $recordcollect['nama_poli'] = $pol->nama_poli;
            $recordcollect['total_antrian'] = count($record);
            $recordcollect['antrian_saat_ini'] = $pol->kode_poli."".$antrian_saat_ini;
            $recordcollect['sisa_antrian'] = (count($record) - $antrian_saat_ini);

            $action = "";
            $action.='<a href="#" onclick="panggil(this,\''.$recordcollect['antrian_saat_ini'].'\')" class="panggil btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px;" id="panggil'.$key.'" title="Hapus"><i class="fa fa-bullhorn"></i> Panggil</a>&nbsp;';
            if($recordcollect['sisa_antrian'] > 0){
                $action.='<a href="#" onclick="selesai(\''.$recordcollect['antrian_saat_ini'].'\')" class="btn btn-primary btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-forward"></i> Lanjut</a>&nbsp;';

            }elseif($recordcollect['sisa_antrian'] == 0 ){
                // $action.='<a href="#" onclick="panggil(this,\''.$recordcollect['antrian_saat_ini'].'\')" class="btn btn-success btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-bullhorn"></i> Panggil</a>&nbsp;';
                $action.='<a href="#" onclick="selesai(\''.$recordcollect['antrian_saat_ini'].'\')" class="btn btn-primary btn-xs icon-btn md-btn-flat product-tooltip" style="min-width:60px" title="Hapus"><i class="fa fa-forward"></i> Selesai</a>&nbsp;';
            }

            if($recordcollect['sisa_antrian'] == -1){
                $recordcollect['sisa_antrian'] = "Tidak Ada antrian";
                $recordcollect['antrian_saat_ini'] = "Tidak Ada antrian";
            }
            $recordcollect['action'] = $action;
            $datates->push($recordcollect);
            $no++;

        }
        if ($request->user()->can('pendaftaran.index')) {
            $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $datates
                    );
        }else{
            $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => []
                    );
        }
        return json_encode($json_data);
    }
    public function antriannow(){
        $antrian = AntrianBPJS::where('status', 0)->where('status_daftar', 0)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->orderBy('id', 'ASC')->first();
        $kosong = array(
            'no_antrian' => 0
        );
        return (isset($antrian))? $antrian : $kosong;
    }
    public function antrianselesai(Request $request){
        $data = AntrianBPJS::where('no_antrian', $request->nomor)->where('tgl_daftar', date('Y-m-d', strtotime(Carbon::now())))->where('status', 0)->first();
        if(isset($data)){
            $data->status = 1;
            if($data->save()){
                return response()->json([
                    'success' => true,
                    'message' => 'Nomor Antrian Berhasil Diupdate',
                    'code' => 201
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'code' => 401,
            ]);
        }
    }
    public function antriancetak($antrian){
        return view('antrian.cetak', ['antrian' => json_decode($antrian,true)]);
    }
    public function audio_panggil(Request $request){
        // return $request->all();
        $pecah = str_split($request->antrian);
        $all_audio = collect([
            collect([
                'file' => asset('/inspinia/musik/in.wav')
            ]),
            collect([
                'file' =>  asset('/inspinia/musik/antrian.wav')
            ])
        ]);
        $jumlahkata = count($pecah);
        foreach($pecah as $i => $audio){
            if($i > 0){
                if($jumlahkata == 2){
                    $tampung = collect([
                        'file' => asset('/inspinia/musik/'.$audio.'.wav')
                    ]);
                }elseif($jumlahkata == 3){
                    if($audio == 1){
                        $tampung = collect([
                            'file' => asset('/inspinia/musik/'.$audio.''.$pecah[$i+1].'.wav')
                        ]);
                        $all_audio->push($tampung);
                        break;
                    }else{
                        if($i == 1){
                            $tampung = collect([
                                'file' => asset('/inspinia/musik/'.$audio.'0.wav')
                            ]);
                        }else{
                            $tampung = collect([
                                'file' => asset('/inspinia/musik/'.$audio.'.wav')
                            ]);
                        }
                    }

                }elseif($jumlahkata == 4){
                    if($i == 1){
                        $tampung = collect([
                            'file' => asset('/inspinia/musik/'.$audio.'00.wav')
                        ]);
                    }elseif($i == 2){
                        $tampung = collect([
                            'file' => asset('/inspinia/musik/'.$audio.'0.wav')
                        ]);
                    }else{
                        $tampung = collect([
                            'file' => asset('/inspinia/musik/'.$audio.'.wav')
                        ]);
                    }
                }
            }else{
                $tampung = collect([
                    'file' => asset('/inspinia/musik/'.strtolower($audio).'.wav')
                ]);
            }

            $all_audio->push($tampung);
        }
        return $all_audio;

        // return count($pecah);
    }
    public function getDataAntrian(){
        $poli = Poli::where('status', 1)->whereNotIn('kdpoli', ['021'])->get();
        $alldata = collect([]);
        foreach($poli as $detailpoli){
            $antrian = AntrianBPJS::where('code_poli', $detailpoli->kdpoli)->where('tgl_daftar', date('Y-m-d'))->orderBy('id', 'DESC')->first();
            // return $antrian;
            if(isset($antrian)){
                $data = collect([
                    'kdpoli' => $detailpoli->kdpoli,
                    'no_antrian' => $antrian->no_antrian,
                ]);
            }else{
                $data = collect([
                    'kdpoli' => $detailpoli->kdpoli,
                    'no_antrian' => '0',
                ]);
            }
            $alldata->push($data);

        }
        return $alldata;
    }
    public function getDataOperator(){
        $antrian = AntrianBPJS::where('tgl_daftar', date('Y-m-d'))->where('status',1)->get();
        $poli = Poli::where('status', 1)->whereNotIn('kdpoli', ['021'])->get();
        $alldata = collect([]);

        foreach($poli as $detailpoli){
            // $jumlahantrian = 0;
            // return $detailpoli;
            $antrian = AntrianBPJS::where('code_poli', $detailpoli->kdpoli)->where('tgl_daftar', date('Y-m-d'))->where('status', 1)->orderBy('id_pendaftaran', 'DESC')->first();
            if(isset($antrian)){
                $antriselanjutnya = substr($antrian->no_antrian,0,1).''.(substr($antrian->no_antrian,1)+1);
                $cekantriselanjutnya = AntrianBPJS::where('no_antrian', $antriselanjutnya)->where('tgl_daftar', date('Y-m-d'))->first();
                if(isset($cekantriselanjutnya)){
                    $data = collect([
                        'poli' => $detailpoli,
                        'antrian' => substr($antrian->no_antrian,0,1).''.(substr($antrian->no_antrian,1)+1),
                    ]);
                }else{
                    $data = collect([
                        'poli' => $detailpoli,
                        'antrian' => substr($antrian->no_antrian,0,1).''.substr($antrian->no_antrian,1),
                        // 'antrian' => 0,
                    ]);
                }

            }else{
                $cek_antrian = AntrianBPJS::where('code_poli', $detailpoli->kdpoli)->where('tgl_daftar', date('Y-m-d'))->first();

                if(isset($cek_antrian)){
                    // return $cek_antrian;
                    $data = collect([
                        'poli' => $detailpoli,
                        'antrian' => substr($cek_antrian->no_antrian,0,1).'1',
                        // 'antrian' => 0,
                    ]);
                }else{
                    $data = collect([
                        'poli' => $detailpoli,
                        // 'antrian' => substr($antrian->no_antrian,0,1).'1',
                        'antrian' => 0,
                    ]);
                }
            }

            $alldata->push($data);
                // return $detailpoli;


        }
        return $alldata;
    }
    public function getallpoli(){
        $poli = Poli::where('status', 1)->whereNotIn('kdpoli', ['021'])->get();
        return $poli;
    }
}
