<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProfileController extends Controller
{
	public function get() {
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

		$slot = DB::table('schedule')
		->get();

		$week = array(1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thrursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday");

		$data = array('user' => $user, 'schedule' => $schedule, 'slot' => $slot, 'week' => $week);
		return view('profilepage')->with($data);
	}
}
