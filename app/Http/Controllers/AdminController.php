<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Course;
use DateTime;
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
        ->get();

        $offices = DB::table('office')
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

        $data = array('courses' => $courses,
            'subjects' => $subjects,
            'all_class' => $class,
            'employees' => $employees,
            'offices' => $offices,
            'rooms' => $rooms,
            'schedule' => $schedule,
            'teachers' => $teacher);

        return view('adminpage')->with($data);
    }
    public function getCourse($id) {
        $course = DB::table('course')
        ->select('course.*', 'subject.name as subject', 'subject.id as subjectid')
        ->where('course.id', $id)
        ->join('subject', 'course.subject', '=', 'subject.id')
        ->get();
        $data = $course->toJson();
        return $data;
    }
    public function getCourseFromSub($id) {
        $course = DB::table('course')
        ->select("*")
        ->where('subject', $id)
        ->get();
        $data = $course->toJson();
        return $data;
    }
    public function deleteCourse($id) {
        try {
            $course = DB::table('course')
            ->where('id', $id)
            ->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return back()->withInput();
    }
    public function addCourse(Request $request) {
        $course = new Course;
        $course->name = $request->name;
        $course->subject = $request->subject;
        $course->price = $request->price;
        $course->total_of_period = $request->total_of_period;
        $course->description = $request->description;
        $course->certificate_required = $request->required;
        $course->save();
        return back()->withInput();
    }

    public function updateCourse(Request $request) {
        $course = Course::find($request->id);
        $course->name = $request->name;
        $course->subject = $request->subject;
        $course->price = $request->price;
        $course->total_of_period = $request->total_of_period;
        $course->description = $request->description;
        $course->certificate_required = $request->required;
        $course->update();
        return back()->withInput();
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
        Debugbar::info($result);
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

    public function postroomlist(Request $r) {
        $class = DB::table('room')
        ->select('room.id')
        ->leftjoin('course_room', 'room.id', 'course_room.room')
        ->where('course_room.course', $r->course)
        ->where('room.office', $r->office)
        ->get();
        Debugbar::info($class);
        if (count($class) < 1) {
            return array();
        }
        $string = $r->start_date . '/' . $r->end_date;
        $data = $this->getRoomScheduleList($string, $class);
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
}
