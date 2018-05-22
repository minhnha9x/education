<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Barryvdh\Debugbar\Facade as Debugbar;

class HomeController extends Controller
{
    public function get() {
        if(Auth::check()) {
            if (Auth::user()->teacher != null) {
                $user_info = DB::table('employee')
                ->select('*', 'mail as email')
                ->where('employee.id', Auth::user()->teacher)
                ->get();
            }
            else {
                $user_info = Auth::user();
            }
        }
        else {
            $user_info = null;
        }

        $subjects = DB::table('subject')
        ->select('subject.*', DB::raw('count(course.id) as count'))
        ->leftjoin('course', 'course.subject', 'subject.id')
        ->groupBy('subject.id')
        ->orderBy('count', 'desc')
        ->get();

        $courses = DB::table('course')
        ->select('course.*', 'subject.name as subject', 'subject.id as subjectid', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
        ->leftjoin('subject', 'course.subject', '=', 'subject.id')
        ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
        ->leftjoin('class', 'class.course', '=', 'course.id')
        ->groupBy('course.id')
        ->get();

        $data = array('userInfo' => (object) $user_info[0],
            'subject' => $subjects,
            'course' => $courses,
        );
        Debugbar::info($data);
        return view('homepage')->with($data);
    }
}