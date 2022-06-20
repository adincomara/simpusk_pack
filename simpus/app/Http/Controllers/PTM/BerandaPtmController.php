<?php

namespace App\Http\Controllers\PTM;

use App\Http\Controllers\Simpusk\Controller;
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
}
