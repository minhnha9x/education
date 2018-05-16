<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Course;
use App\Exam;
use App\Subject;
use App\Office;
use App\Room;
use App\Course_Room;
use App\Promotion;
use DateTime;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;

class AdminController extends Controller
{
    public function getData() {
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

        $class = DB::table('class')
        ->select('class.*', 'course.name as course')
        ->leftjoin('course', 'course.id', 'class.course')
        ->orderby('course.name')
        ->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->get();


        $employees = DB::table('employee')
        ->leftjoin('office_worker', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'position.id', 'office_worker.position')
        ->select('*', 'position.name as position', 'employee.name as name', 'employee.id as id', 'employee.address as address', 'office.name as office', 'office.id as officeid')
        ->get();

        $offices = DB::table('office')
        ->get();

        $promotions = DB::table('promotion')
        ->leftjoin('course', 'promotion.course', 'course.id')
        ->get();

        $rooms = DB::table('room')
        ->select('room.*', 'office.name as office', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->leftjoin('office', 'office.id', 'room.office')
        ->join('course_room', 'room.id', 'course_room.room')
        ->leftjoin('course', 'course.id', 'course_room.course')
        ->groupBy('room.id')
        ->get();

        $main_teacher = DB::table('main_teacher')
        ->select('main_teacher.degree',
            'main_teacher.id',
            'employee.name as name',
            DB::raw("GROUP_CONCAT(office.name SEPARATOR ', ') as office"))
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->join('office_main_teacher', 'office_main_teacher.teacher', 'main_teacher.id')
        ->leftjoin('office', 'office.id', 'office_main_teacher.office')
        ->groupBy('main_teacher.id');

        $teacher = DB::table(DB::raw("({$main_teacher->toSql()}) as main_teacher"))
        ->select('main_teacher.*', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->join('course_teacher', 'course_teacher.teacher', 'main_teacher.id')
        ->leftjoin('course', 'course_teacher.course', 'course.id')
        ->groupBy('main_teacher.id')
        ->get();

        $cRbyS = $this->countRegisterBySubject();
        $cRbyO = $this->countRegisterByOffice();
        $data = array('courses' => $courses,
            'all_class' => $class,
            'subjects' => $subjects,
            'employees' => $employees,
            'offices' => $offices,
            'rooms' => $rooms,
            'schedule' => $schedule,
            'promotion' => $promotions,
            'cRbyS' => $cRbyS,
            'cRbyO' => $cRbyO,
            'teachers' => $teacher);

        return view('adminpage')->with($data);
    }

    public function getAllSubject() {
        $data = Subject::select('subject.*', DB::raw('count(course.id) as count'))
        ->leftjoin('course', 'course.subject', 'subject.id')
        ->groupBy('subject.id')
        ->get();
        return $data;
    }

    public function getSubject(Request $r) {
        return Subject::findOrFail($r->id);
    }

    public function addSubject(Request $r) {
        if ($r->id != null)
            $data = Subject::findOrFail($r->id);
        else 
            $data = new Subject;
        $data->name = $r->name;
        $data->description = $r->desc;
        $data->save();
        return back()->withInput();
    }

    public function deleteSubject(Request $r) {
        try {
            $subject = Subject::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }

    public function getAllCourse() {
        $data = Course::select('course.*', 'subject.name as subject', 'subject.id as subjectid', 'course2.name as certificate_required', DB::raw('count(class.id) as count'))
        ->leftjoin('subject', 'course.subject', '=', 'subject.id')
        ->leftjoin('course as course2', 'course.certificate_required', '=', 'course2.id')
        ->leftjoin('class', 'class.course', '=', 'course.id')
        ->groupBy('course.id')
        ->get();
        return $data;
    }

    public function getCourse(Request $r) {
        $data = Course::join('subject', 'course.subject', '=', 'subject.id')
        ->select('course.*', 'subject.name as subject', 'subject.id as subjectid')
        ->where('course.id', $r->id)
        ->get();
        return $data;
    }

    public function getCourseFromSub(Request $r) {
        $data = Course::select("*")
        ->where('subject', $r->id)
        ->get();
        return $data;
    }

    public function addCourse(Request $r) {
        if ($r->id != null)
            $data = Course::findOrFail($r->id);
        else 
            $data = new Course;
        $data->name = $r->name;
        $data->subject = $r->subject;
        $data->price = $r->price;
        $data->total_of_period = $r->total_of_period;
        $data->description = $r->description;
        $data->certificate_required = $r->required;
        $data->save();
        return back()->withInput();
    }

    public function deleteCourse(Request $r) {
        try {
            $course = Course::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }

    public function getAllOffice() {
        $data = Office::get();
        return $data;
    }

    public function getOffice(Request $r) {
        $data = Office::where('id', $r->id)
        ->get();
        return $data;
    }

    public function addOffice(Request $r) {
        if ($r->id != null)
            $data = Office::findOrFail($r->id);
        else 
            $data = new Office;
        $data->name = $r->name;
        $data->address = $r->address;
        $data->phone = $r->phone;
        $data->mail = $r->mail;
        $data->location = $r->location;
        $data->save();
        return back()->withInput();
    }

    public function deleteOffice(Request $r) {
        try {
            $office = Office::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }

    public function getAllRoom() {
        $data = Room::select('room.*', 'office.name as office', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->leftjoin('office', 'office.id', 'room.office')
        ->join('course_room', 'room.id', 'course_room.room')
        ->leftjoin('course', 'course.id', 'course_room.course')
        ->groupBy('room.id')
        ->get();
        return $data;
    }

    public function getRoom(Request $r) {
        $data = Room::select('room.*', DB::raw("GROUP_CONCAT(course.id SEPARATOR ', ') as course"))
        ->leftjoin('office', 'office.id', 'room.office')
        ->join('course_room', 'room.id', 'course_room.room')
        ->leftjoin('course', 'course.id', 'course_room.course')
        ->where('room.id', $r->id)
        ->get();
        return $data;
    }

    public function addRoom(Request $r) {
        if ($r->id != null)
            $data = Room::findOrFail($r->id);
        else 
            $data = new Room;
        $data->office = $r->office;
        $data->max_student = $r->max_student;
        $data->save();
        foreach ($r->course as $courses) {
            $this->addRoomCourse($data->id, $courses);
        }
        foreach ($r->coursedel as $courses) {
            $this->deleteRoomCourse($data->id, $courses);
        }
        return $r->course;
    }

    public function addRoomCourse($room_id, $course_id) {
        try {
            $course_room = Course_Room::where('room', $room_id)
            ->where('course', $course_id)
            ->first();

            if ($course_room == null) {
                $course_room = new Course_Room;
            }
            $course_room->room = $room_id;
            $course_room->course = $course_id;
            $course_room->save();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteRoomCourse($room_id, $course_id) {
        try {
            $course_room = Course_Room::where('room', $room_id)
            ->where('course', $course_id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }

    public function deleteRoom(Request $r) {
        try {
            $room = Course_Room::where('room', $r->id)
            ->delete();
            $room = Room::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }

    public function getAllEmployee() {
        $data = DB::table('employee')
        ->leftjoin('office_worker', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'position.id', 'office_worker.position')
        ->select('position.name as position', 'employee.name as name', 'employee.id as id', 'employee.address as address', 'office.name as office', 'office_worker.office as officeid', 'employee.phone as phone', 'employee.mail as mail', 'employee.birthday')
        ->get();
        return $data;
    }

    public function getEmployee(Request $r) {
        $data = DB::table('employee')
        ->leftjoin('office_worker', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'position.id', 'office_worker.position')
        ->where('employee.id', $r->id)
        ->select('*', 'position.name as position', 'employee.name as name', 'employee.id as id', 'employee.address as address', 'office.name as office', 'office.id as officeid')
        ->get();
        return $data;
    }

    public function getAllPromotion() {
        $data = Promotion::leftjoin('course', 'course.id', 'promotion.course')
        ->get();
        return $data;
    }

    public function getPromotion(Request $r) {
        $data = Promotion::where('code', $r->code)
        ->get();
        return $data;
    }

    public function addPromotion(Request $r) {
        $data = new Promotion;
        $data->code = $r->code;
        $data->benefit = $r->benefit;
        $data->course = $r->course;
        $data->save();
        return back()->withInput();
    }

    public function editPromotion(Request $r) {
        $data = Promotion::find($r->code);
        if ($data != null) {
            $data->benefit = $r->benefit;
            $data->course = $r->course;
            $data->save();
        }
        return back()->withInput();
    }

    public function deletePromotion(Request $r) {
        $data = Promotion::find($r->code);
        $data->delete();
        return $data;
    }

    public function getRoomScheduleList($range_date, $room_ids) {
        $input = $range_date;
        $range_date_list = array();
        $range_date_split = (explode("/",$range_date));
        foreach ($range_date_split as $value) {
            $value = date('Y-m-d', strtotime($value));
            array_push($range_date_list, $value);
        }

        $room_schedule = $this->getRoomScheduleData($room_ids);
        $result = array();
        foreach ($room_schedule as $room_record) {
            if (!array_key_exists($room_record->id, $result)){
                $result[$room_record->id] = array();
            }
            if (strtotime($room_record->end_date) and strtotime($room_record->start_date)){
                $start_date = date('Y-m-d', strtotime($room_record->start_date));
                $end_date = date('Y-m-d', strtotime($room_record->end_date));
                if (!($range_date_list[0] > $end_date || $range_date_list[1] < $start_date)) {
                    if (!array_key_exists($room_record->current_date, $result[$room_record->id])){
                        $result[$room_record->id][$room_record->current_date] = array();
                    }
                    array_push($result[$room_record->id][$room_record->current_date], $room_record->schedule);
                }
            }
        }
        return $result;
    }

    public function getTeacherScheduleList($teacher_ids, $start_range, $end_range) {
        $start_range = date('Y-m-d', strtotime($start_range));
        $end_range = date('Y-m-d', strtotime($end_range));

        $teacher_schedule = $this->getTeacherScheduleData($teacher_ids);
        $result = array();
        foreach ($teacher_schedule as $schedule) {
            if (!array_key_exists($schedule->id, $result)){
                $result[$schedule->id] = array();
                $result[$schedule->id]['schedule'] = array();
                $result[$schedule->id]['name'] = $schedule->name;
            }
            if (strtotime($schedule->end_date) and strtotime($schedule->start_date)){
                $start_date = date('Y-m-d', strtotime($schedule->start_date));
                $end_date = date('Y-m-d', strtotime($schedule->end_date));
                if (!($start_range > $end_date || $end_range < $start_date)) {
                    if (!array_key_exists($schedule->current_date, $result[$schedule->id]['schedule'])){
                        $result[$schedule->id]['schedule'][$schedule->current_date] = array();
                    }
                    array_push($result[$schedule->id]['schedule'][$schedule->current_date], $schedule->schedule);
                }
            }
        }
        return $result;
    }

    public function getRoomScheduleData($room_ids) {
        $room_schedule = DB::table('room')
        ->select('room.id',
            'room_schedule.current_date',
            'room_schedule.schedule',
            'class.start_date',
            'class.end_date')
        ->leftjoin('room_schedule', 'room_schedule.room', '=', 'room.id')
        ->leftjoin('class', 'class.id', '=', 'room_schedule.class');

        if (json_decode($room_ids, TRUE)){
            $room_schedule = $room_schedule
            ->whereIn('room.id', json_decode($room_ids, TRUE));
        }
        $room_schedule = $room_schedule
        ->get();
        return $room_schedule;
    }

    public function getTeacherScheduleData($teacher_ids) {
        $teacher_schedule = DB::table('main_teacher')
        ->select('main_teacher.id',
            'room_schedule.current_date',
            'room_schedule.schedule',
            'class.start_date',
            'class.end_date',
            'employee.name')
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->leftjoin('room_schedule', 'room_schedule.teacher', 'main_teacher.id')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->whereIn('main_teacher.id', json_decode($teacher_ids, TRUE))
        ->get();

        return $teacher_schedule;
    }

    public function postroomlist(Request $r) {
        $class = DB::table('room')
        ->select('room.id')
        ->leftjoin('course_room', 'room.id', 'course_room.room')
        ->where('course_room.course', $r->course)
        ->where('room.office', $r->office)
        ->get();
        if (count($class) < 1) {
            return array();
        }
        $string = $r->start_date . '/' . $r->end_date;
        $data = $this->getRoomScheduleList($string, $class);
        return $data;
    }

    public function getTeacherScheduleInRange(Request $r) {
        $teacher_list = DB::table('office_main_teacher')
        ->select('office_main_teacher.teacher as teacher_id')
        ->leftjoin('course_teacher', 'course_teacher.teacher', 'office_main_teacher.teacher')
        ->where('course_teacher.course', $r->course)
        ->where('office_main_teacher.office', $r->office)
        ->distinct()
        ->get();

        if (count($teacher_list) < 1) {
            return array();
        }
        $data = $this->getTeacherScheduleList($teacher_list, $r->start_date, $r->end_date);
        return $data;
    }

    public function getAvailableOffice(Request $r) {
        $data = DB::table('course_room')
        ->select('office.id', 'office.name')
        ->leftjoin('room', 'room.id', 'course_room.room')
        ->leftjoin('office', 'office.id', 'room.office')
        ->where('course_room.course', $r->course_id)
        ->groupBy('office.id')
        ->get();
        return $data;
    }

    public function countRegisterBySubject() {
        $data = DB::table('register')
        ->select('subject.name', DB::raw('count(class.id) as count'))
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('course','course.id', 'class.course')
        ->rightjoin('subject','subject.id', 'course.subject')
        ->groupBy('subject.id')
        ->get();
        return $data;
    }

    public function countRegisterByOffice() {
        $data = DB::table('register')
        ->select('register.id as register', 'office.name as office')
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('room_schedule','room_schedule.class', 'class.id')
        ->leftjoin('room','room.id', 'room_schedule.room')
        ->rightjoin('office', 'office.id', 'room.office')
        ->groupBy('office.id', 'register.id');

        $new_data = DB::table(DB::raw("({$data->toSql()}) as register_office"))
        ->select('register_office.office', DB::raw('count(register_office.register) as count'))
        ->groupBy('register_office.office')
        ->get();
        return $new_data;
    }

    public function getAvailableTeacher(Request $r) {
        // Replace this with param in get request
        $office = $r->office;
        $course = $r->course;
        $slot_in_day = $r->slot;
        $date = $r->date;;
        //#

        $date_formated = Carbon::parse($date)->startOfDay();

        $validate = strtotime($date);
        $day_in_week = date('l', $validate);
        $data = DB::table('main_teacher')
        ->select('employee.name',
            'employee.id',
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

    public function getScore(Request $r) {
        $id = $r->id;
        $data = DB::table('register')
        ->leftjoin('exam','exam.register', 'register.id')
        ->leftjoin('class','register.class', 'class.id')
        ->leftjoin('users','register.user', 'users.id')
        ->select('*', 'users.id as user', 'exam.score as score', 'register.id as register', 'exam.id as id')
        ->where('register.class', $id)
        ->get();
        return $data;
    }

    public function updateScore(Request $r) {
       if ($r->id != null)
            $data = Exam::findOrFail($r->id);
        else 
            $data = new Exam;
        $data->register = $r->register;
        $data->score = $r->score;
        $data->save();
        return back()->withInput();
    }

    public function getSalaryInMonth(Request $r) {
        //Replace month year with request input
        $year = $r->year;
        $month = $r->month;
        //
        $end_day= date('Y-m-t', strtotime($year.'-'.$month.'-01'));
        $start_day= date('Y-m-d', strtotime($year.'-'.$month.'-01'));

        $main_teacher_salary = DB::table('employee')
        ->leftjoin('office_worker', 'employee.id', 'office_worker.id')
        ->leftjoin('position', 'position.id', 'office_worker.position')
        ->select('employee.id','employee.name', 'position.name as position', 'position.rate_salary')
        ->get();
        foreach ($main_teacher_salary as $teacher) {
            $teaching_day = $this->getNumberOfTeachingDay($start_day, $end_day, $teacher->id);
            $day_off = $this->getNumberOfDayOff($start_day, $end_day, $teacher->id);
            $teaching_backup = $this->getNumberOfTeachingBackup($start_day, $end_day, $teacher->id);
            $teaching_offset = $this->getNumberOfTeachingOffSet($start_day, $end_day, $teacher->id);
            $salary_rate = 200000;

            $teacher->salary = $salary_rate*($teaching_day - $day_off + $teaching_backup + $teaching_offset);
        }
        return $main_teacher_salary;
    }

    public function getNumberOfTeachingOffSet($start_date, $end_date, $teacher_id) {
        $teaching_offset = DB::table('teaching_offset')
        ->select(DB::raw('count(*) as count'))
        ->leftjoin('room_schedule', 'teaching_offset.room_schedule', 'room_schedule.id')
        ->where('room_schedule.teacher', $teacher_id)
        ->whereRaw('teaching_offset.date between ? and ?', [$start_date, $end_date])
        ->get();
        return $teaching_offset[0]->count;
    }

    public function getNumberOfTeachingBackup($start_date, $end_date, $teacher_id) {
        $teaching_backup = DB::table('teacher_dayoff')
        ->select(DB::raw('count(*) as count'))
        ->where('teacher_dayoff.backup_teacher', $teacher_id)
        ->whereRaw('teacher_dayoff.date between ? and ?', [$start_date, $end_date])
        ->get();
        return $teaching_backup[0]->count;
    }

    public function getNumberOfDayOff($start_date, $end_date, $teacher_id) {
        $teacher_dayoff = DB::table('teacher_dayoff')
        ->select(DB::raw('count(*) as count'))
        ->leftjoin('room_schedule', 'teacher_dayoff.room_schedule', 'room_schedule.id')
        ->where('room_schedule.teacher', $teacher_id)
        ->whereRaw('teacher_dayoff.date between ? and ?', [$start_date, $end_date])
        ->get();
        return $teacher_dayoff[0]->count;
    }

    public function getNumberOfTeachingDay($start_date, $end_date, $teacher_id) {
        $teacher_schedule = DB::table('room_schedule')
        ->select('room_schedule.current_date', 'class.start_date', 'class.end_date')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->where('room_schedule.teacher', $teacher_id)
        ->whereRaw('not (class.start_date >= ? or class.end_date <= ?)', [$end_date, $start_date])
        ->get();

        $day_count = 0;
        $day_in_week = array(        
            "Monday"=>1,
            "Tuesday"=>2,
            "Wednesday"=>3,
            "Thursday"=>4,
            "Friday"=>5,
            "Saturday"=>6,
            "Sunday"=>7,
        );
        foreach ($teacher_schedule as $schedule) {
            $from = $start_date;
            $to = $end_date;

            if ($schedule->start_date > $start_date) {
                $from = $schedule->start_date;
            }

            if ($schedule->end_date < $end_date) {
                $to = $schedule->end_date;
            }
            $day_count += $this->dayCount($from, $to, $day_in_week[$schedule->current_date]);
        };
        return $day_count;
    }

    function dayCount($from, $to, $day = 5) {
        $from = new DateTime($from);
        $to   = new DateTime($to);

        $wF = $from->format('w');
        $wT = $to->format('w');
        if ($wF < $wT)       $isExtraDay = $day >= $wF && $day <= $wT;
        else if ($wF == $wT) $isExtraDay = $wF == $day;
        else                 $isExtraDay = $day >= $wF || $day <= $wT;

        return floor($from->diff($to)->days / 7) + $isExtraDay;
    }

    function getRegisterInMonth(Request $r) {
        $year = $r->year;
        $result = array();

        for ($i = 1; $i <= 12; $i++) {
            $month = $i;
            $end_day = date('Y-m-t', strtotime($year.'-'.$month.'-01'));
            $start_day = date('Y-m-d', strtotime($year.'-'.$month.'-01'));

            $end_day = Carbon::parse($end_day)->startOfDay();
            $start_day = Carbon::parse($start_day)->startOfDay();
            $register = DB::table('register')
            ->select(DB::raw('count(register.id) as count'))
            ->whereBetween('register.created_date', [$start_day->startOfDay(), $end_day->endOfDay()])
            ->get();

            $result += array($i => $register[0]->count);
        }

        return $result;
    }
}
