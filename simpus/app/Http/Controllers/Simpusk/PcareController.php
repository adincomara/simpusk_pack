<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;

class PcareController extends Controller
{
    public function index(){
        return view('pengaturan_form/pcare_form');
    }
}
