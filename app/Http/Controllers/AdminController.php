<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Course;
use DateTime;

class AdminController extends Controller
{
    public function getData() {
        $courses = DB::table('course')
        ->select('course.*', 'subject.name as subject', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
        ->leftjoin('subject', 'course.subject', '=', 'subject.id')
        ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
        ->leftjoin('class', 'class.course', '=', 'course.id')
        ->groupBy('course.id')
        ->get();
        $data = array('courses' => $courses);

        $subjects = DB::table('subject')
        ->select('subject.*', DB::raw('count(course.id) as count'))
        ->leftjoin('course', 'course.subject', 'subject.id')
        ->groupBy('subject.id')
        ->get();
        $data = array('courses' => $courses, 'subjects' => $subjects);
        return view('adminpage')->with($data);
    }
    public function getCourse($id) {
    	$course = DB::table('course')
        ->select('course.*', 'subject.name as subject')
        ->where('course.id', $id)
        ->join('subject', 'course.subject', '=', 'subject.id')
        ->get();
    	$data = $course->toJson();
    	return $data;
    }
    public function addCourse(Request $request) {
    	$course = new Course;
    	$course->name = $request->name;
    	$course->subject = $request->subject;
    	$course->price = $request->price;
    	//$course->description = $request->description;
    	//$course->created_at = new DateTime();
    	$course->save();
    	return view('adminpage');
    }
}
