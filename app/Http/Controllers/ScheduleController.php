<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ScheduleController extends Controller
{
	public function get() {
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

		$offices = DB::table('office')
		->get();

		$classes = DB::table('class')
		->select('class.*', 'course.name as course')
		->leftjoin('course', 'course.id', 'class.course')
		->orderby('course.name')
		->get();
		$data = array('courses' => $courses, 'subjects' => $subjects, 'offices' => $offices,  'classes' => $classes);
		return view('schedulepage')->with($data);
	}
	public function getschedule(Request $r) {

		$class = DB::table('class')
        ->select("*")
        ->where('course', $r->course)
        ->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->leftjoin('class', 'room_schedule.class', 'class.id')
        ->leftjoin('course', 'class.course', 'course.id')
        ->where('course.subject', $r->subject)
        ->where('course.id', $r->course)
        ->where('office.id', $r->office)
        ->get();

        $data = array('class' => $class, 'schedule' => $schedule,);
        return $data;
	}
}
