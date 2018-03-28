<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function getData() {
    	$courses = DB::table('course')->get();
    	$data = array('courses' => $courses);
    	return view('adminpage')->with($data);
    }
}
