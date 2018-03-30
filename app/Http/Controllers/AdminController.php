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
        ->select('course.*', 'subject.name as subject', 'subject.id as subjectid', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
        ->leftjoin('subject', 'course.subject', '=', 'subject.id')
        ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
        ->leftjoin('class', 'class.course', '=', 'course.id')
        ->groupBy('course.id')
        ->get();

        $subjects = DB::table('subject')
        ->select('subject.*', DB::raw('count(course.id) as count'))
        ->leftjoin('course', 'course.subject', 'subject.id')
        ->groupBy('subject.id')
        ->get();

        $class = DB::table('class')
        ->select('class.*', 'course.name as course')
        ->leftjoin('course', 'course.id', 'class.course')
        ->orderby('course.name')
        ->get();

        $employees = DB::table('employee')
        ->get();

        $offices = DB::table('office')
        ->get();

        $data = array('courses' => $courses, 'subjects' => $subjects, 'all_class' => $class, 'employees' => $employees, 'offices' => $offices);

        return view('adminpage')->with($data);
    }
    public function getCourse($id) {
        $course = DB::table('course')
        ->select('course.*', 'subject.name as subject', 'subject.id as subjectid')
        ->where('course.id', $id)
        ->join('subject', 'course.subject', '=', 'subject.id')
        ->get();
        $data = $course->toJson();
        return $data;
    }
    public function getCourseFromSub($id) {
        $course = DB::table('course')
        ->select("*")
        ->where('subject', $id)
        ->get();
        $data = $course->toJson();
        return $data;
    }
    public function deleteCourse($id) {
        $course = DB::table('course')
        ->where('id', $id)
        ->delete();
        return back()->withInput();
    }
    public function addCourse(Request $request) {
        $course = new Course;
        $course->name = $request->name;
        $course->subject = $request->subject;
        $course->price = $request->price;
        $course->total_of_period = $request->total_of_period;
        $course->description = $request->description;
        $course->certificate_required = $request->required;
        $course->save();
        return back()->withInput();
    }
}
