<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function getData() {
        $courses = DB::table('course')
        ->select('course.*', 'subject.name as subject')
        ->join('subject', 'course.subject', '=', 'subject.id')
        ->get();
        $data = array('courses' => $courses);
        return view('adminpage')->with($data);
    }
}
