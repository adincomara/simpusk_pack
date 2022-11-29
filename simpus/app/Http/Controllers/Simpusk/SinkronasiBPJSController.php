<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Dokter;
use App\Models\Simpusk\Kesadaran;
use App\Models\Simpusk\KhususBPJS;
use App\Models\Simpusk\Poli;
use App\Models\Simpusk\SaranaBPJS;
use App\Models\Simpusk\SpesialisBPJS;
use App\Models\Simpusk\SubSpesialisBPJS;
use App\Models\Simpusk\StatusPulang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SinkronasiBPJSController extends Controller
{
    private function data_array(){
        return array(
            'dokter' => 'Dokter',
            'poli' => 'Poli',
            'spesialis' => 'SpesialisBPJS',
            'subspesialis' => 'SubSpesialisBPJS',
            'sarana' => 'SaranaBPJS',
            'khusus' => 'KhususBPJS',
            'status_pulang' => 'StatusPulang',
            'kesadaran' => 'Kesadaran',
        );
    }
    public function index(){
        date_default_timezone_set('Asia/Jakarta');
        $collect = array();
        foreach($this->data_array() as $key => $value){
            $model = 'App\Models\Simpusk'.'\\'.$value;
            ${$key} = $model::orderBy('updated_at', 'DESC')->first();
            ${'time_'.$key} = 'Belum melakukan Sinkronasi';
            if(isset(${$key})){
                ${'time_'.$key} = 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime(${$key}->updated_at)).' WIB';
            }
            $tamp = 'time_'.$key;
            array_push($collect, $tamp);
        }
        return view('sinkronasi/bpjs', compact($collect));
    }
    public function master_dokter(){
        $url = '/dokter/0/100';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_dokter = Dokter::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_dokter = Dokter::where('kdDokter', $response['kdDokter'])->first();
                if(isset($cek_dokter)){
                    continue;
                }   
                $dokter = new Dokter();
                $dokter->kdDokter = $response['kdDokter'];
                $dokter->nmDokter = $response['nmDokter'];
                $dokter->save();
            }
            DB::commit();
            if(!isset($dokter)){
                $dokter = $cek_dokter;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($dokter->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);

            
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        
    }
    public function master_poli(){
        $url = '/poli/fktp/0/100';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_poli = Poli::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_poli = Poli::where('kdpoli', $response['kdPoli'])->first();
                if(isset($cek_poli)){
                    continue;
                }
                $poli = new Poli();
                $poli->kdpoli = $response['kdPoli'];
                $poli->nama_poli = $response['nmPoli'];
                $poli->ruang_poli = $response['nmPoli'];
                $poli->save();
            }
            DB::commit();
            if(!isset($poli)){
                $poli = $cek_poli;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($poli->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        return $result;
    }
    public function pelayanan_spesialis(){
        $url = '/spesialis';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_spesialis = SpesialisBPJS::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_spesialis = SpesialisBPJS::where('kdSpesialis', $response['kdSpesialis'])->first();
                if(isset($cek_spesialis)){
                    continue;
                }
                $spesialis = new SpesialisBPJS();
                $spesialis->kdSpesialis = $response['kdSpesialis'];
                $spesialis->nmSpesialis = $response['nmSpesialis'];
                $spesialis->save();
            }
            DB::commit();
            if(!isset($spesialis)){
                $spesialis = $cek_spesialis;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($spesialis->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        return $result;
    }
    public function pelayanan_subspesialis(){
        $all_spesialis = SpesialisBPJS::all();
        if(empty($all_spesialis) || count($all_spesialis) == 0){
            return response()->json([
                'success' => false,
                'message' => 'Belum melakukan sinkronasi sarana, atau Tabel Sarana BPJS kosong'
            ]);
        }
        try{
            $cek_subspesialis = SubSpesialisBPJS::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($all_spesialis as $key => $sps){
                $url = '/spesialis/'.$sps['kdSpesialis'].'/subspesialis';
                $result = APIBpjsController::get($url);
                if($result['metaData']['code'] != 200){
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak bisa terhubung dengan BPJS'
                    ]);
                }
                foreach($result['response']['list'] as $idx => $response){
                    $cek_subspesialis = SubSpesialisBPJS::where('kdSubSpesialis', $response['kdSubSpesialis'])->first();
                    if(isset($cek_subspesialis)){
                        continue;
                    }
                    $subspesialis = new SubSpesialisBPJS();
                    $subspesialis->kdSpesialis = $sps['kdSpesialis'];
                    $subspesialis->kdSubSpesialis = $response['kdSubSpesialis'];
                    $subspesialis->nmSubSpesialis = $response['nmSubSpesialis'];
                    $subspesialis->kdPoliRujuk = $response['kdPoliRujuk'];
                    $subspesialis->save();
                }
            }
            DB::commit();
            if(!isset($subspesialis)){
                $subspesialis = $cek_subspesialis;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($subspesialis->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
    }
    public function pelayanan_sarana(){
        $url = '/spesialis/sarana';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_sarana = SaranaBPJS::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_sarana = SaranaBPJS::where('kdSarana', $response['kdSarana'])->first();
                if(isset($cek_sarana)){
                    continue;
                }
                $sarana = new SaranaBPJS();
                $sarana->kdSarana = $response['kdSarana'];
                $sarana->nmSarana = $response['nmSarana'];
                $sarana->save();
            }
            DB::commit();
            if(!isset($sarana)){
                $sarana = $cek_sarana;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($sarana->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        return $result;
    }
    public function pelayanan_khusus(){
        $url = '/spesialis/khusus';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_khusus = KhususBPJS::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_khusus = KhususBPJS::where('kdKhusus', $response['kdKhusus'])->first();
                if(isset($cek_khusus)){
                    continue;
                }
                $khusus = new KhususBPJS();
                $khusus->kdKhusus = $response['kdKhusus'];
                $khusus->nmKhusus = $response['nmKhusus'];
                $khusus->save();
            }
            DB::commit();
            if(!isset($khusus)){
                $khusus = $cek_khusus;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($khusus->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        return $result;
    }
    public function pelayanan_kesadaran(){
        $url = '/kesadaran';
        $result = APIBpjsController::get($url);
        if($result['metaData']['code'] != 200){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa terhubung dengan BPJS'
            ]);
        }
        try{
            $cek_kesadaran = Kesadaran::orderBy('updated_at', 'DESC')->first();
            DB::beginTransaction();
            foreach($result['response']['list'] as $key => $response){
                $cek_kesadaran = Kesadaran::where('kdSadar', $response['kdSadar'])->first();
                if(isset($cek_kesadaran)){
                    continue;
                }
                $kesadaran = new Kesadaran();
                $kesadaran->kdSadar = $response['kdSadar'];
                $kesadaran->nmSadar = $response['nmSadar'];
                $kesadaran->save();
            }
            DB::commit();
            if(!isset($kesadaran)){
                $kesadaran = $cek_kesadaran;
            }
            return response()->json([
                'success' => true,
                'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($kesadaran->updated_at)).' WIB',
                'message' => 'Data berhasil disimpan'
            ]);
        }catch(\Throwable $th){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan, '.$th->getMessage()
            ]);
        }
        return $result;
    }
    public function pelayanan_status_pulang(){
        $arr = array(
            'true', 'false'
        );
        foreach($arr as $idx => $value){
            $url = '/statuspulang/rawatInap/'.$value;
            $result = APIBpjsController::get($url);
            if($result['metaData']['code'] != 200){
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa terhubung dengan BPJS'
                ]);
            }
            try{
                $cek_status_pulang = StatusPulang::orderBy('updated_at', 'DESC')->first();
                DB::beginTransaction();
                foreach($result['response']['list'] as $key => $response){
                    $cek_status_pulang = StatusPulang::where('kdStatusPulang', $response['kdStatusPulang'])->where('rawat_inap', ($value == 'true')? 1 : 0)->first();
                    if(isset($cek_status_pulang)){
                        continue;
                    }
                    $status_pulang = new StatusPulang();
                    $status_pulang->kdStatusPulang = $response['kdStatusPulang'];
                    $status_pulang->nmStatusPulang = $response['nmStatusPulang'];
                    $status_pulang->rawat_inap = ($value == 'true')? 1 : 0;
                    $status_pulang->save();
                }
                
                DB::commit();
                if(!isset($status_pulang)){
                    $status_pulang = $cek_status_pulang;
                }
                
            }catch(\Throwable $th){
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal disimpan, '.$th->getMessage()
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'time'    => 'Terakhir di Update '.date('d - F - Y H:i:s', strtotime($status_pulang->updated_at)).' WIB',
            'message' => 'Data berhasil disimpan'
        ]);
        return $result;
    }
}
