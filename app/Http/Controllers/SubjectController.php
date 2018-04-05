<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Register;

class SubjectController extends Controller
{
    public function get($id)
    {
    	$courses = DB::table('course')
	    ->select('course.*', 'subject.name as subject', 'subject.id as subjectid', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
	    ->leftjoin('subject', 'course.subject', '=', 'subject.id')
	    ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
	    ->leftjoin('class', 'class.course', '=', 'course.id')
	    ->groupBy('course.id')
	    ->where('course.subject', $id)
	    ->get();

	    $subject = DB::table('subject')->where('id', $id)->first();

	    $subjects = DB::table('subject')
	    ->select('subject.*', DB::raw('count(course.id) as count'))
	    ->leftjoin('course', 'course.subject', 'subject.id')
	    ->groupBy('subject.id')
	    ->get();

	    $offices = DB::table('office')
	    ->get();

	    $classes = DB::table('class')
	    ->select('class.*', 'course.name as course')
	    ->leftjoin('course', 'course.id', 'class.course')
	    ->orderby('course.name')
	    ->get();
        $data = array('courses' => $courses, 'subjects' => $subjects, 'subject' => $subject, 'offices' => $offices,  'classes' => $classes);
        return view('subjectpage')->with($data);
    }
    public function getClassFromCourse($id) {
        $course = DB::table('class')
        ->select("*")
        ->where('course', $id)
        ->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->get();

        $data = array('courses' => $course, 'schedule' => $schedule);
        return $data;
    }
    public function classRegister(Request $request) {
    	if ($request->has('promotion')) {
    		$promotion = DB::table('promotion')
	    	->leftjoin('class', 'promotion.course', 'class.course')
	    	->where('promotion.code', $request->promotion)
	    	->where('class.course', $request->course)
	    	->where('class.id', $request->class)
		    ->get();

		    if ($promotion->isEmpty()) {
		    	session()->flash('error', 'Mã giảm giá không tồn tại.');
		    	return redirect()->back();
		    }
		    else {
		    	$register = new Register;
		        $register->class = $request->class;
		        $register->promotion = $request->promotion;
		        $register->user = Auth::user()->id;
		        $register->save();
		        session()->flash('msg', 'Bạn đã đăng kí khóa học thành công! Hãy vào trang cá nhân để xem các khóa học đã đăng kí.');
		    	return redirect()->back();
		    }
    	}
    	else {
    		$register = new Register;
	        $register->class = $request->class;
	        $register->user = Auth::user()->id;
	        $register->save();
	        session()->flash('msg', 'Bạn đã đăng kí khóa học thành công! Hãy vào trang cá nhân để xem các khóa học đã đăng kí');
	    	return redirect()->back();
    	}
    }
}
