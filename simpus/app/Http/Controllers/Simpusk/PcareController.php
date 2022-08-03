<?php

namespace App\Http\Controllers\Simpusk;

use App\Models\Simpusk\Pcare;
use Illuminate\Http\Request;

class PcareController extends Controller
{
    public function index(){
        $pcare = Pcare::first();
        // return $pcare;
        return view('pengaturan_form/pcare_form', ['pcare' => $pcare]);
    }
    public function simpan(Request $req){
        $pcare = Pcare::first();
        $pcare->username = $req->username;
        $pcare->password = $req->password;
        if($pcare->save()){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }
}
