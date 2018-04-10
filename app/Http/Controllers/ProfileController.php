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
		->leftjoin('room_schedule', 'register.class', 'room_schedule.class')
		->where('register.user', Auth::user()->id)
		->get();

		$slot = DB::table('schedule')
		->get();

		$data = array('user' => $user, 'schedule' => $schedule, 'slot' => $slot);
		return view('profilepage')->with($data);
	}
}
