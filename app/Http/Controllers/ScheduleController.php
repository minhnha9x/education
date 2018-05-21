<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Register;

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

        $data = array('courses' => $courses,
            'subjects' => $subjects,
            'offices' => $offices,
            'userInfo' => (object) $user_info[0],
            'classes' => $classes
        );
        return view('schedulepage')->with($data);
    }

    public function getSchedule(Request $r) {

        $class = DB::table('class')
        ->leftjoin('course', 'class.course', 'course.id')
        ->leftjoin('room_schedule', 'class.id', 'room_schedule.class')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->leftjoin('subject', 'course.subject', 'subject.id')
        ->groupBy('class.id')
        ->select('*', 'course.name as course', 'class.id as id', 'course.id as courseid', 'office.name as office');
        if ($r->course != null) {
            $class = $class->where('course', $r->course);
        }
        if ($r->subject != null) {
            $class = $class->where('subject', $r->subject);
        }
        if ($r->office != null) {
            $class = $class->where('office', $r->office);
        }
        $class = $class->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('class', 'room_schedule.class', 'class.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->leftjoin('course', 'course.id', 'class.course')
        ->select("*");
        if ($r->subject != null){
            $schedule = $schedule->where('subject', $r->subject);
        }
        if ($r->course != null) {
            $schedule = $schedule->where('course', $r->course);
        }
        if ($r->office != null) {
            $schedule = $schedule->where('office', $r->office);
        }
        $schedule = $schedule->get();

        $data = array('class' => $class, 'schedule' => $schedule);
        return $data;
    }

    public function classRegister(Request $request) {
        if ($request->promotion != '') {
            $promotion = DB::table('promotion')
            ->leftjoin('class', 'promotion.course', 'class.course')
            ->where('promotion.code', $request->promotion)
            ->where('class.course', $request->course)
            ->where('class.id', $request->class)
            ->get();

            if ($promotion->isEmpty()) {
                return array('msg' => 'Mã giảm giá không tồn tại.', 'type' => 'danger');
            }
            else {
                $register = new Register;
                $register->class = $request->class;
                $register->promotion = $request->promotion;
                $register->user = Auth::user()->id;
                $register->save();
                return array('msg' => 'Bạn đã đăng kí khóa học thành công với mã giảm giá <strong>' . $request->promotion . '</strong>!<br>Hãy vào trang cá nhân để xem các khóa học đã đăng kí.', 'type' => 'success');
            }
        }
        else {
            $register = new Register;
            $register->class = $request->class;
            $register->user = Auth::user()->id;
            $register->save();
            return array('msg' => 'Bạn đã đăng kí khóa học thành công! Hãy vào trang cá nhân để xem các khóa học đã đăng kí.', 'type' => 'success');
        }
    }
}
