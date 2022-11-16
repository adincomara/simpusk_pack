<?php

namespace App\Http\Controllers\Simpusk;

use Illuminate\Http\Request;

class SinkronasiBPJSController extends Controller
{
    public function index(){
        return view('sinkronasi/bpjs');
    }
}
