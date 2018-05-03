<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;
use App\Teacher_Dayoff;
use App\Teaching_Offset;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;

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
                ->groupby('course.id')
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

                $schedule = DB::table('register')
                ->leftjoin('class', 'register.class', 'class.id')
                ->leftjoin('course', 'class.course', 'course.id')
                ->leftjoin('room_schedule', 'register.class', 'room_schedule.class')
                ->leftjoin('room', 'room_schedule.room', 'room.id')
                ->leftjoin('office', 'room.office', 'office.id')
                ->select('*', 'course.name as course')
                ->where('register.user', Auth::user()->id)
                ->get();

                $data = array('user' => $user, 
                    'schedule' => $schedule, 
                    'slot' => $slot, 
                    'week' => $weekday, 
                    'test' => $week, 
                    'courses' => $courses, 
                    'userInfo' => Auth::user());
            }
            else {
                $user_info = DB::table('employee')
                ->select('*', 'name as fullname', 'mail as email')
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

                $week = array();
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

                $teacher_schedule = $this->getTeacherSchedule(Auth::user()->id);

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
                    'courses' => $courses,
                    'teacher_dayoff' => $teacher_dayoff,
                    'teaching_offset' => $teaching_offset,
                    'tschedule' => $teacher_schedule,
                    'week' => $weekday,
                    'test' => $week,
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

    public function addTeachingOffset(Request $r) {
        $data = new Teaching_Offset;
        $data->room_schedule = $r->room_schedule;
        $data->teacher_dayoff = $r->id;
        $data->date = $r->date;
        Debugbar::info($r->date);
        $data->save();
        return back()->withInput();
    }

    public function getTeacherSchedule(Int $r) {
        $teacher_id = 1;
        $current_date = '05/15/2018';
        $date_formated = Carbon::parse($current_date)->startOfDay();

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
}
