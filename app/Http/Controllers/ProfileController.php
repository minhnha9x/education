<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use DateTime;
use App\Teacher_Dayoff;
use App\TA_Dayoff;
use App\Teaching_Offset;
use App\Employee;
use App\Exam;
use App\User;
use App\Student_Level;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;
use File;

class ProfileController extends Controller
{
    public function get() {
        if(Auth::check()) {
            $slot = DB::table('schedule')
            ->get();

            $weekday = array(1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday");

            $courses = DB::table('course')
            ->leftjoin('course_teacher', 'course_teacher.course', 'course.id')
            ->where('course_teacher.teacher', Auth::user()->id)
            ->get();
            
            if (Auth::user()->role != 'teacher')
            {
                $user = DB::table('register')
                ->leftjoin('users', 'register.user', 'users.id')
                ->leftjoin('class', 'register.class', 'class.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->where('users.id', Auth::user()->id)
                ->get();

                $week = array();
                foreach ($user as $c) {
                    $firstweekdays = ($this->getWeekday($c->start_date) == 0 ? 1 : 7 - $this->getWeekday($c->start_date) + 1);

                    $today = new DateTime('now');
                    $formattedDate = new DateTime($c->start_date);
                    $formattedDate2 = new DateTime($c->end_date);
                    $diff = date_diff($today, $formattedDate);
                    $currentweek = floor($diff->format('%a')/7) + 1;

                    $diff2 = date_diff($formattedDate, $formattedDate2);
                    $diff2 = $diff2->format('%a');

                    $lastweekdays = ($diff2 - $firstweekdays) % 7 ;

                    $totalweek = 1 + floor(($diff2 - $firstweekdays) / 7 ) + ($lastweekdays == 0 ? 0 : 1);

                    $data = array('currentweek' => $currentweek, 
                        'firstweekdays' => $firstweekdays,
                        'lastweekdays' => $lastweekdays,
                        'totalweek' => $totalweek,
                    );

                    $week += array($c->class => $data);
                }

                $date_formated = Carbon::now()->startOfDay();
                $schedule = DB::table('register')
                ->leftjoin('class', 'register.class', 'class.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('room_schedule', 'register.class', 'room_schedule.class')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->select('*', 'course.name as course')
                ->where('register.user', Auth::user()->id)
                ->whereRaw('(class.start_date <= ? and class.end_date >= ?)', [$date_formated, $date_formated])
                ->get();

                $teacher_dayoff = DB::table('teacher_dayoff')
                ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('register', 'room_schedule.class', 'register.class')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->where('register.user', Auth::user()->id)
                ->where('teacher_dayoff.backup_teacher', null)
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'teacher_dayoff.id as id')
                ->orderby('teacher_dayoff.date')
                ->get();

                $teaching_offset = DB::table('teaching_offset')
                ->leftjoin('teacher_dayoff', 'teaching_offset.teacher_dayoff', 'teacher_dayoff.id')
                ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('register', 'room_schedule.class', 'register.class')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->where('register.user', Auth::user()->id)
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'teacher_dayoff.date as dayoff', 'teaching_offset.date as date', 'room_schedule.room as room')
                ->orderby('teaching_offset.date')
                ->get();

                $result = DB::table('exam')
                ->select('exam.*', 'register.class')
                ->leftjoin('register', 'register.id', 'exam.register')
                ->where('register.user', Auth::user()->id)
                ->get()
                ->keyBy('class');

                $data = array('user' => $user, 
                    'schedule' => $schedule,
                    'teacher_dayoff' => $teacher_dayoff,
                    'teaching_offset' => $teaching_offset,
                    'slot' => $slot,
                    'result' => $result,
                    'weekday' => $weekday,
                    'week' => $week,
                    'courses' => $courses,
                    'userInfo' => Auth::user());
            }
            else {
                $user_info = DB::table('employee')
                ->select('*', 'mail as email')
                ->where('employee.id', Auth::user()->teacher)
                ->get();

                $class = DB::table('class')
                ->leftjoin('course', 'course.id', 'class.course')
                ->leftjoin('room_schedule', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->where('room_schedule.teacher', Auth::user()->teacher)
                ->select('*', 'course.name as course', 'course.id as courseid')
                ->groupby('class.id')
                ->get();

                $class2 = DB::table('class')
                ->leftjoin('course', 'course.id', 'class.course')
                ->leftjoin('room_schedule', 'room_schedule.class', 'class.id')
                ->leftjoin('room_ta', 'room_ta.room_schedule', 'room_schedule.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->where('room_ta.TA', Auth::user()->teacher)
                ->select('*', 'course.name as course', 'course.id as courseid')
                ->groupby('class.id')
                ->get();

                $week = array();
                $week2 = array();
                $day_off = array();
                $day_offset = array();
                foreach ($class as $c) {
                    $firstweekdays = ($this->getWeekday($c->start_date) == 0 ? 1 : 7 - $this->getWeekday($c->start_date) + 1);

                    $today = new DateTime('now');
                    $formattedDate = new DateTime($c->start_date);
                    $formattedDate2 = new DateTime($c->end_date);
                    $diff = date_diff($today, $formattedDate);
                    $currentweek = floor($diff->format('%a')/7) + 1;

                    $diff2 = date_diff($formattedDate, $formattedDate2);
                    $diff2 = $diff2->format('%a');

                    $lastweekdays = ($diff2 - $firstweekdays) % 7 ;

                    $totalweek = 1 + floor(($diff2 - $firstweekdays) / 7 ) + ($lastweekdays == 0 ? 0 : 1);

                    $data = array('currentweek' => $currentweek, 
                        'firstweekdays' => $firstweekdays,
                        'lastweekdays' => $lastweekdays,
                        'totalweek' => $totalweek,
                    );

                    $week += array($c->class => $data);

                    $temp = DB::table('teacher_dayoff')
                    ->leftjoin('room_schedule', 'room_schedule.id', 'teacher_dayoff.room_schedule')
                    ->where('room_schedule.teacher', Auth::user()->teacher)
                    ->where('teacher_dayoff.backup_teacher', null)
                    ->where('room_schedule.class', $c->id)
                    ->count();
                    $day_off += array($c->class => $temp);

                    $temp2 = DB::table('teaching_offset')
                    ->leftjoin('teacher_dayoff', 'teaching_offset.teacher_dayoff', 'teacher_dayoff.id')
                    ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                    ->leftjoin('room', 'room_schedule.room', 'room.id')
                    ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                    ->where('room_schedule.teacher', Auth::user()->teacher)
                    ->where('room_schedule.class', $c->id)
                    ->count();
                    $day_offset += array($c->class => $temp2);
                }

                foreach ($class2 as $c) {
                    $firstweekdays = ($this->getWeekday($c->start_date) == 0 ? 1 : 7 - $this->getWeekday($c->start_date) + 1);

                    $today = new DateTime('now');
                    $formattedDate = new DateTime($c->start_date);
                    $formattedDate2 = new DateTime($c->end_date);
                    $diff = date_diff($today, $formattedDate);
                    $currentweek = floor($diff->format('%a')/7) + 1;

                    $diff2 = date_diff($formattedDate, $formattedDate2);
                    $diff2 = $diff2->format('%a');

                    $lastweekdays = ($diff2 - $firstweekdays) % 7 ;

                    $totalweek = 1 + floor(($diff2 - $firstweekdays) / 7 ) + ($lastweekdays == 0 ? 0 : 1);

                    $data = array('currentweek' => $currentweek, 
                        'firstweekdays' => $firstweekdays,
                        'lastweekdays' => $lastweekdays,
                        'totalweek' => $totalweek,
                    );

                    $week2 += array($c->class => $data);
                }

                $teacher_schedule = $this->getTeacherScheduleById(Auth::user()->teacher);

                $ta_schedule = $this->getTASchedulebyId(Auth::user()->teacher);

                $teacher_dayoff = DB::table('teacher_dayoff')
                ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->leftjoin('employee', 'teacher_dayoff.backup_teacher', 'employee.id')
                ->where('room_schedule.teacher', Auth::user()->teacher)
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'teacher_dayoff.id as id')
                ->orderby('teacher_dayoff.date')
                ->get();

                $ta_dayoff = DB::table('ta_dayoff')
                ->leftjoin('room_schedule', 'ta_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->leftjoin('employee', 'ta_dayoff.ta_id', 'employee.id')
                ->where('ta_dayoff.ta_id', Auth::user()->teacher)
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'ta_dayoff.id as id')
                ->orderby('ta_dayoff.date')
                ->get();

                $teacher_backup = DB::table('teacher_dayoff')
                ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->leftjoin('employee', 'room_schedule.teacher', 'employee.id')
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'teacher_dayoff.id as id', 'employee.name as teacher_off')
                ->where('teacher_dayoff.backup_teacher', $user_info[0]->id)
                ->orderby('teacher_dayoff.date')
                ->get();

                $teaching_offset = DB::table('teaching_offset')
                ->leftjoin('teacher_dayoff', 'teaching_offset.teacher_dayoff', 'teacher_dayoff.id')
                ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
                ->leftjoin('class', 'room_schedule.class', 'class.id')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
                ->where('room_schedule.teacher', Auth::user()->teacher)
                ->select('*', 'course.name as course', 'course.id as courseid', 'office.name as office', 'teacher_dayoff.date as dayoff', 'teaching_offset.date as date', 'room_schedule.room as room')
                ->orderby('teaching_offset.date')
                ->get();

                $data = array('slot' => $slot, 
                    'class' => $class,
                    'class2' => $class2,
                    'courses' => $courses,
                    'teacher_dayoff' => $teacher_dayoff,
                    'ta_dayoff' => $ta_dayoff,
                    'teacher_backup' => $teacher_backup,
                    'teaching_offset' => $teaching_offset,
                    'tschedule' => $teacher_schedule,
                    'taschedule' => $ta_schedule,
                    'weekday' => $weekday,
                    'week' => $week,
                    'week2' => $week2,
                    'teacher_dayoff_count' => $day_off,
                    'teaching_offset_count' => $day_offset,
                    'userInfo' => (object) $user_info[0]
                );
            }
            return view('profilepage')->with($data);
        }
        else {
            abort(404);
        }
    }

    public function getAvailableTeacher(Request $r) {
        // Replace this with param in get request
        $office = $r->office;
        $course = $r->course;
        $slot_in_day = $r->slot;
        $date = $r->date;
        //#

        $date_formated = Carbon::parse($date)->startOfDay();

        $validate = strtotime($date);
        $day_in_week = date('l', $validate);
        $data = DB::table('main_teacher')
        ->select('employee.name',
            'employee.id',
            'employee.mail',
            'main_teacher.degree',
            'course_teacher.course',
            'office_main_teacher.office',
            'room_schedule.schedule',
            'room_schedule.current_date',
            'class.start_date',
            'class.end_date',
            DB::raw('COUNT( CASE WHEN (class.start_date <= ? and class.end_date >= ? and room_schedule.current_date = ? and room_schedule.schedule = ?) THEN employee.id ELSE NULL END) as count')
        )
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->leftjoin('course_teacher','course_teacher.teacher', 'main_teacher.id')
        ->leftjoin('office_main_teacher', 'office_main_teacher.teacher', 'main_teacher.id')
        ->leftjoin('room_schedule', 'room_schedule.teacher', 'main_teacher.id')
        ->leftjoin('class', 'room_schedule.class', 'class.id')
        ->where('course_teacher.course', '=', '?')
        ->where('office_main_teacher.office','=', '?')
        ->having('count', '=', 0)
        ->groupBy('main_teacher.id')
        ->setBindings([$date_formated, $date_formated, $day_in_week, $slot_in_day, $course, $office])
        ->get();
        return $data;
    }

    public function getSlot() {
        return  DB::table('schedule')->get();
    }

    public function getWeekday($date) {
        return date('w', strtotime($date));
    }


    public function addTeacherDayoff(Request $r) {
        $data = new Teacher_Dayoff;
        if ($r->teacher != "") {
            $data->backup_teacher = $r->teacher;
        }
        $data->date = date("Y-m-d", strtotime($r->week));
        $data->room_schedule = $r->room_schedule;
        $data->save();
        return back()->withInput();
    }

    public function addTADayoff(Request $r) {
        $data = new TA_Dayoff;
        if ($r->teacher != "") {
            $data->backup_ta = $r->teacher;
        }
        $data->date = date("Y-m-d", strtotime($r->week));
        $data->room_schedule = $r->room_schedule;
        $data->ta_id = $r->id;
        $data->save();
        return back()->withInput();
    }

    public function addTeachingOffset(Request $r) {
        $data = new Teaching_Offset;
        $data->room_schedule = $r->room_schedule;
        $data->teacher_dayoff = $r->id;
        $data->date = $r->date;
        $data->save();
        return back()->withInput();
    }

    public function getTeacherScheduleById(Int $id) {
        $teacher_id = $id;
        $date_formated = Carbon::now()->startOfDay();

        $data = DB::table('room_schedule')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('course', 'class.course', 'course.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'office.id', 'room.office')
        ->select('*', 'course.name as course', 'course.id as courseid', 'room_schedule.id as room_schedule')
        ->where('room_schedule.teacher', $teacher_id)
        ->whereRaw('(class.start_date <= ? and class.end_date >= ?)', [$date_formated, $date_formated])
        ->get();

        return $data;
    }

     public function getTeacherSchedule(Request $r) {
        $teacher_id = $r->id;
        return $this->getTeacherScheduleById($teacher_id);
    }

    public function getTASchedule(Request $r) {
        $ta_id = $r->id;
        return $this->getTASchedulebyId($ta_id);
    }

    public function getTASchedulebyId(Int $id) {
        $ta_id = $id;
        $date_formated = Carbon::now()->startOfDay();

        $data = DB::table('room_ta')
        ->leftjoin('room_schedule', 'room_ta.room_schedule', 'room_schedule.id')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('course', 'class.course', 'course.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'office.id', 'room.office')
        ->select('*', 'course.name as course', 'course.id as courseid', 'room_schedule.id as room_schedule')
        ->where('room_ta.TA', $ta_id)
        ->whereRaw('(class.start_date <= ? and class.end_date >= ?)', [$date_formated, $date_formated])
        ->get();

        return $data;
    }

    public function updateProfile(Request $r) {
        $data = Employee::findOrFail($r->id);
        $data->name = $r->fullname;
        $data->phone = $r->phone;
        $data->address = $r->address;
        $data->birthday = $r->birthday;
        $data->save();
        return back()->withInput();
    }

    public function updateAvatar(Request $request)
    {
        $data = User::findOrFail(Auth::user()->id);
        File::delete($data->avatar);
        $file = $request->file;
        $file->move('./img/user/',  Auth::user()->id . '.' . $file->getClientOriginalExtension());
        $data->avatar = './img/user/' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
        $data->save();
    }

    public function updatePassword(Request $r) {
        $data = User::findOrFail($r->id);
        if (Hash::check($r->old, $data->password) == false)
            return array('msg' => 'Mật khẩu cũ không chính xác!', 'type' => 'error');
        else {
            if ($r->new != $r->confirm)
                return array('msg' => 'Xác nhận mật khẩu mới không chính xác!', 'type' => 'error');
            else {
                $data->password = Hash::make($r->new);
                $data->save();
                return array('msg' => 'Đổi mật khẩu thành công!', 'type' => 'success');
            }
        }
    }

    public function getScoreList(Request $r) {
        $data = DB::table('register')
        ->select('users.id', 'users.name', 'exam.score', 'exam.teacher_feedback', 'register.id as register', 'exam.id as exam', 'exam.supervisor_feedback')
        ->leftjoin('exam', 'exam.register', 'register.id')
        ->leftjoin('users', 'users.id', 'register.user')
        ->where('register.class', $r->class_id)
        ->get();
        return $data;
    }
    public function updateScoreList(Request $r) {
        foreach ($r->data as $score) {
            $score = (object) $score;
            if ($score->exam != null){
                $data = Exam::find($score->exam);
                if ($data == null) {
                    return back();
                }
            }
            else {
                $data = new Exam;
            }
            $data->register = $score->register;
            $data->score = $score->score;
            $data->teacher_feedback = $score->teacher_feedback;
            $data->supervisor_feedback = $score->supervisor_feedback;
            $course = DB::table('register')
            ->leftjoin('class', 'class.id', 'register.class')
            ->leftjoin('course', 'course.id', 'class.course')
            ->where('register.id', $score->register)
            ->select('course.id', 'register.user')
            ->first();
            $sl_obj = Student_Level::where('course', $course->id)
                ->where('member', $course->user)
                ->first();
            if ($score->score >= 5) {
                $data->result = 'Pass';
                if (!$sl_obj) {
                    $sl_obj = new Student_Level;
                    $sl_obj->member = $course->user;
                    $sl_obj->course = $course->id;
                    $sl_obj->save();
                }
            }
            else {
                $data->result = 'Fail';
                if ($sl_obj)
                    $sl_obj->delete();
            }
            $data->save();
        }
        return back()->withInput();
    }
}
