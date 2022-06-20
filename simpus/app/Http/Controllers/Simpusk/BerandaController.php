<?php

namespace App\Http\Controllers\Simpusk;

// use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
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
use Maatwebsite\Excel\Facades\Excel;

class BerandaController extends Controller
{
	// index:halaman beranda
    public function index(){
    	$tgl = Carbon::now()->format('d F Y');
    	$jmluser   = User::count();
        // return "tes";
        return view('dashboard');
    	// return view('backend/beranda/index',compact('tgl','jmluser'));
    }
    // public function import(Request $request){

    //     // validasi
	// 	$this->validate($request, [
	// 		'file' => 'required|mimes:csv,xls,xlsx'
	// 	]);

	// 	// menangkap file excel
	// 	$file = $request->file('file');
    //     //return $file->getClientOriginalName();
	// 	// membuat nama file unik
	// 	$nama_file = rand().$file->getClientOriginalName();
    //     //return $nama_file;

	// 	// upload ke folder file_siswa di dalam folder public
	// 	$file->move('file_siswa',$nama_file);

	// 	// import data
	// 	Excel::import(new SiswaImport, public_path('/../../file_siswa/'.$nama_file));
    //     return "oke";

	// 	// notifikasi dengan session
	// 	// Session::flash('sukses','Data Siswa Berhasil Diimport!');
    // }
    // public function getjumlahpasien(Request $request){

    // }
}
