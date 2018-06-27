<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Office;
use App\Subject;
use App\Course;
use App\Register;
use App\Student_Level;
use Carbon\Carbon;

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

        $count = DB::table('class')
        ->select('*', 'class.id as id', DB::raw('count(register.id) as count'))
        ->leftjoin('register', 'register.class', 'class.id')
        ->groupBy('class.id')
        ->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('class', 'room_schedule.class', 'class.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->leftjoin('course', 'course.id', 'class.course')
        ->select("*");

        $teacher = DB::table('room_schedule')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('users', 'room_schedule.teacher', 'users.teacher')
        ->leftjoin('main_teacher', 'users.teacher', 'main_teacher.id')
        ->groupBy('users.teacher')
        ->groupBy('class.id')
        ->get();

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

        $data = array('class' => $class, 'schedule' => $schedule, 'teacher' => $teacher, 'count' => $count);
        return $data;
    }

    public function getAllSubject() {
        $data = Subject::select('subject.*', DB::raw('count(course.id) as count'))
        ->leftjoin('course', 'course.subject', 'subject.id')
        ->groupBy('subject.id')
        ->get();
        return $data;
    }

    public function getCourseFromSub(Request $r) {
        $data = Course::select("*")
        ->where('subject', $r->id)
        ->get();
        return $data;
    }

    public function getAllOffice() {
        $data = Office::get();
        return $data;
    }

    public function classRegister(Request $request) {
        if ($request->promotion != '') {
            $today = Carbon::now();

            $promotion = DB::table('promotion')
            ->leftjoin('class', 'promotion.course', 'class.course')
            ->where('promotion.code', $request->promotion)
            ->where('class.course', $request->course)
            ->where('class.id', $request->class)
            ->where('promotion.limited', '>', 'promotion.used')
            ->whereRaw('? between promotion.start_date and promotion.end_date', [$today])
            ->get();

            if ($promotion->isEmpty()) {
                return array('msg' => 'Mã giảm giá không tồn tại.', 'type' => 'danger');
            }
            else {
                $check = $this->validateNewRegister(Auth::user()->id, $request->class);
                switch ($check) {
                    case false:
                        return array('msg' => 'Đăng ký thất bại. Vui lòng kiểm tra lại thời khóa biểu hoặc môn học tiên quyết của khóa học.', 'type' => 'danger');
                        break;
                    default:
                        $register = new Register;
                        $register->class = $request->class;
                        $register->user = Auth::user()->id;
                        $register->save();

                        $promotion->used += 1;
                        $promotion->save();
                        return array('msg' => 'Bạn đã đăng kí khóa học thành công! Hãy vào trang cá nhân để xem các khóa học đã đăng kí.', 'type' => 'success');
                        break;
                }
            }
        }
        else {
            $check = $this->validateNewRegister(Auth::user()->id, $request->class);
            switch ($check) {
                case false:
                    return array('msg' => 'Đăng ký thất bại. Vui lòng kiểm tra lại thời khóa biểu hoặc môn học tiên quyết của khóa học.', 'type' => 'danger');
                    break;
                default:
                    $register = new Register;
                    $register->class = $request->class;
                    $register->user = Auth::user()->id;
                    $register->save();
                    return array('msg' => 'Bạn đã đăng kí khóa học thành công! Hãy vào trang cá nhân để xem các khóa học đã đăng kí.', 'type' => 'success');
                    break;
            }
        }
    }

    public function validateNewRegister(Int $user_id, Int $class_id) {
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
}
