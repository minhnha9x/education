<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Student_Level;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Session;
use Mail;

class UtilController extends Controller
{
    public function validateNewRegister(Request $r) {
        $user_id = 1;
        $class_id = 100;
        $result = true;

        $current_schedule = $this->getScheduleAsDict($class_id);
        if (count($current_schedule) < 1) {
            return false;
        }
        $current_schedule = $current_schedule[0];
        $current_day_list = explode(",", $current_schedule->day);
        $current_slot_list = explode(",", $current_schedule->slot);

        $registers = DB::table('register')
        ->leftjoin('class', 'class.id', 'register.class')
        ->where('register.user', '=', '?')
        ->whereRaw('(? BETWEEN class.start_date AND class.end_date or ? BETWEEN class.start_date AND class.end_date)')
        ->select('register.class')
        ->setBindings([$user_id, $current_schedule->start_date, $current_schedule->end_date])
        ->get();
        foreach ($registers as $classID) {
            $schedule = $this->getScheduleAsDict($classID->class);
            if (count($schedule) < 1) {
                continue;
            }
            $schedule = $schedule[0];
            $day_list = explode(",", $schedule->day);
            $slot_list = explode(",", $schedule->slot);
            foreach ($day_list as $key => $value) {
                $day_exist = array_search($value, $current_day_list);
                if ($day_exist >= 0 && $current_slot_list[$day_exist] == $slot_list[$key]) {
                    return false;
                }
            }
        }
        return $this->validateCourseRequired($user_id, $class_id);
    }

    public function validateCourseRequired($user_id, $class_id) {
        $class = DB::table('class')
        ->where('class.id', $class_id)
        ->leftjoin('course', 'course.id', 'class.course')
        ->select('course.certificate_required')
        ->first();
        if ($class->certificate_required == null)
            return true;
        if (!$class)
            return false;
        $sl_obj = Student_Level::where('course', $class->certificate_required)
        ->where('member', $user_id)
        ->first();
        if ($sl_obj)
            return true;
        return false;
    }

    public function getScheduleAsDict($class_id) {
        $schedule = DB::table('room_schedule')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->where('room_schedule.class', $class_id)
        ->select(
            'class.end_date',
            'class.start_date',
            DB::raw("GROUP_CONCAT(room_schedule.current_date SEPARATOR ',') as day"),
            DB::raw("GROUP_CONCAT(room_schedule.schedule SEPARATOR ',') as slot")
        )
        ->groupBy('class.id')
        ->get();
        return $schedule;
    }

    public function sendMail(Request $request)
    {
        $email = $request->email;
        Mail::send('mail_template.mail', array('firstname'=>'nhamh'), function($message) use ($email){
            $message->to($email, 'Visitor')->subject('Visitor Feedback!');
        });
        Session::flash('flash_message', 'Send message successfully!');

        return abort(404);
    }

    public function getEmployeeNotInList($list_id)
    {
        $result = DB::table('employee')
        ->whereNotIn('employee.id', $list_id)
        ->select('*')
        ->get();
        return $result;
    }

    public function getEmployeeExcludeTA(Request $r)
    {
        $ta = DB::table('teaching_assistant')
        ->select('id')
        ->get()
        ->pluck('id');
        $result = $this->getEmployeeNotInList($ta);
        return $result;
    }
    public function getEmployeeExcludeTeacher(Request $r)
    {
        $mt = DB::table('main_teacher')
        ->select('id')
        ->get()
        ->pluck('id');
        $result = $this->getEmployeeNotInList($mt);
        return $result;
    }
    public function getEmployeeExcludeOW(Request $r)
    {
        $ow = DB::table('office_worker')
        ->select('id')
        ->get()
        ->pluck('id');
        $result = $this->getEmployeeNotInList($ow);
        return $result;
    }

}