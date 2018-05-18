<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class OfficeController extends Controller
{
    public function get() {
    	$offices = DB::table('office')
        ->get();

    	$data = array('offices' => $offices,
        );
        return view('officepage')->with($data);
	}
}