<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Teacher_Backup;

class ProfileController extends Controller
{
	public function get() {
		if(Auth::check()) {
			$slot = DB::table('schedule')
			->get();

			$week = array(1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thrursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday");

			$courses = DB::table('course')
	        ->leftjoin('course_teacher', 'course_teacher.course', 'course.id')
	        ->where('course_teacher.teacher', Auth::user()->id)
	        ->get();
			
			if (Auth::user()->role == 'member')
			{
				$user = DB::table('register')
				->leftjoin('users', 'register.user', 'users.id')
				->leftjoin('class', 'register.class', 'class.id')
				->leftjoin('course', 'class.course', 'course.id')
				->where('users.id', Auth::user()->id)
				->groupby('course.id')
				->get();

				$schedule = DB::table('register')
				->leftjoin('class', 'register.class', 'class.id')
				->leftjoin('course', 'class.course', 'course.id')
				->leftjoin('room_schedule', 'register.class', 'room_schedule.class')
				->leftjoin('room', 'room_schedule.room', 'room.id')
				->leftjoin('office', 'room.office', 'office.id')
				->select('*', 'course.name as course')
				->where('register.user', Auth::user()->id)
				->get();

				$data = array('user' => $user, 'schedule' => $schedule, 'slot' => $slot, 'week' => $week, 'courses' => $courses);
			}
			else {
		        $schedule = DB::table('room_schedule')
		        ->leftjoin('class', 'room_schedule.class', 'class.id')
		        ->leftjoin('course', 'class.course', 'course.id')
		        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
		        ->leftjoin('room', 'room_schedule.room', 'room.id')
		        ->leftjoin('office', 'room.office', 'office.id')
		        ->select('*', 'course.name as course2', 'room_schedule.id as room_schedule')
		        ->get();

				$data = array('slot' => $slot, 
					'courses' => $courses,
					'schedule' => $schedule,
					'week' => $week);
			}
			return view('profilepage')->with($data);
		}
		else {
			abort(404);
		}
	}
	public function addTeacherBackup(Request $r) {
		$data = new Teacher_Backup;
        $data->backup_teacher = $r->teacher;
        $data->date = $r->date;
        $data->room_schedule = $r->room_schedule;
        $data->save();
        return back()->withInput();
	}
}
