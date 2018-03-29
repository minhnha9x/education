<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SubjectController extends Controller
{
    public function get($id)
    {
    	$course = DB::table('course')->where('subject', $id)->get();
    	$subject = DB::table('subject')->where('id', $id)->first();
    	$data = array('courses' => $course, 'subject' => $subject);
    	return view('subjectpage')->with($data);
    }
}
