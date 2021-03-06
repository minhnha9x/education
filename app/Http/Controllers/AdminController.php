<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;
use File;
use Auth;
use App\Http\Requests;
use App\Course;
use App\Exam;
use App\Subject;
use App\Office;
use App\Room;
use App\Course_Room;
use App\Promotion;
use App\Employee;
use App\Teacher;
use App\TA;
use App\Worker;
use App\Office_Worker;
use App\Office_Teacher;
use App\Office_TA;
use App\Course_Teacher;
use App\Course_TA;
use App\Class_Room;
use App\Student_level;
use App\Room_Schedule;
use App\Room_TA;
use App\User;
use App\Register;
use DateTime;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission');
    }

    public function getData() {
        if(Auth::check() && Auth::user()->role == 'admin') {
            $subjects = DB::table('subject')
            ->select('subject.*', DB::raw('count(course.id) as count'))
            ->leftjoin('course', 'course.subject', 'subject.id')
            ->groupBy('subject.id')
            ->get();

            $class = DB::table('class')
            ->select('*', 'class.id as id', 'course.name as course', DB::raw('count(register.id) as count'))
            ->leftjoin('register', 'register.class', 'class.id')
            ->leftjoin('course', 'course.id', 'class.course')
            ->leftjoin('room_schedule', 'class.id', 'room_schedule.class')
            ->leftjoin('room', 'room_schedule.room', 'room.id')
            ->orderby('course.name')
            ->groupBy('class.id')
            ->get();

            $schedule = DB::table('room_schedule')
            ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
            ->leftjoin('room', 'room_schedule.room', 'room.id')
            ->leftjoin('office', 'room.office', 'office.id')
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

            $data = array('all_class' => $class,
                'subjects' => $subjects,
                'schedule' => $schedule,
                'teachers' => $teacher);

            return view('adminpage')->with($data);
        }
        else {
            abort(404);
        }
    }

    public function getAllCertification() {
        $data = User::select('users.id', 'users.name', 'users.email', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->leftjoin('student_level', 'student_level.member', 'users.id')
        ->leftjoin('course', 'student_level.course', 'course.id')
        ->where('users.role', 'member')
        ->groupBy('users.id')
        ->get();
        return $data;
    }

    public function updateCertification(Request $r) {
        $data = Student_level::where('member', $r->id)
        ->where('course', $r->course)
        ->first();
        if ($data == null)
        {
            $t = new Student_level;
            $t->course = $r->course;
            $t->member = $r->id;
            $t->save();
        }
    }

    public function getAllClass() {
        $class = DB::table('class')
        ->select('*', 'class.id as id', 'course.name as course', 'office.name as office')
        ->leftjoin('course', 'course.id', 'class.course')
        ->leftjoin('room_schedule', 'class.id', 'room_schedule.class')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->groupBy('class.id')
        ->get();

        $count = DB::table('class')
        ->select('*', 'class.id as id', DB::raw('count(register.id) as count'))
        ->leftjoin('register', 'register.class', 'class.id')
        ->groupBy('class.id')
        ->get();

        $schedule = DB::table('room_schedule')
        ->leftjoin('schedule', 'room_schedule.schedule', 'schedule.id')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->leftjoin('office', 'room.office', 'office.id')
        ->get();

        return array('class' => $class,
            'schedule' => $schedule,
            'count' => $count);
    }

    function addClass(Request $r) {
        $class_obj = new Class_Room;
        $class_obj->course = $r->course;
        $class_obj->supervisor = $r->supervisor;
        $class_obj->start_date = date('Y-m-d', strtotime($r->start_date));
        $class_obj->end_date = date('Y-m-d', strtotime($r->end_date));
        $class_obj->save();
        foreach ($r->schedule as $schedule => $detail) {
            $slot_and_day = explode('_', $schedule, 2);
            $slot = $slot_and_day[0];
            $day = $slot_and_day[1];

            $room_schedule_obj = new Room_Schedule;
            $room_schedule_obj->class = $class_obj->id;
            $room_schedule_obj->schedule = $slot;
            $room_schedule_obj->current_date = $day;
            $room_schedule_obj->teacher = $detail[1];
            $room_schedule_obj->room = $detail[0];
            $room_schedule_obj->save();
            foreach ($detail[2] as $ta) {
                $room_ta = new Room_TA;
                $room_ta->TA = $ta['TASelected'];
                $room_ta->room_schedule = $room_schedule_obj->id;
                $room_ta->save();
            }
        }
        return $result = array('msg' => 'Đã cập nhật danh sách lớp học.', 'type' => 'success');
    }

    public function deleteClass(Request $r) {
        $class = DB::table('class')
        ->where('id', $r->id)
        ->delete();
        return array('msg' => 'Xóa lớp học thành công.', 'type' => 'success');
    }

    public function getAllRegister() {
        $data = Register::leftjoin('users', 'register.user', 'users.id')
        ->leftjoin('class', 'register.class', 'class.id')
        ->leftjoin('course', 'class.course', 'course.id')
        ->leftjoin('subject', 'course.subject', 'subject.id')
        ->select('users.name as name', 'course.name as course', 'register.created_date', 'register.promotion as promotion', 'register.fee_status', 'users.email as mail', 'class.id as class', 'register.id as id')
        ->get();
        return $data;
    }

    public function deleteRegister(Request $r) {
        try {
            $subject = Register::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa đăng ký thành công.', 'type' => 'success');
    }

    public function updateFee(Request $r) {
        $data = Register::where('id', $r->id)
        ->first();
        if ($data->fee_status == 1)
            $data->fee_status = 0;
        else
            $data->fee_status = 1;
        $data->save();
        return array('msg' => 'Đã cập nhật tình trạng học phí của học viên.', 'type' => 'success');
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
        if ($r->id != null) {
            $data = Subject::findOrFail($r->id);
            $result = array('msg' => 'Đã cập nhật danh sách môn học.', 'type' => 'success');
        }
        else {
            $data = new Subject;
            $result = array('msg' => 'Đã cập nhật danh sách môn học.', 'type' => 'success', 'id' => $data->id);
        }
        $data->name = $r->name;
        $data->description = $r->desc;
        $data->save();
        return $result;
    }

    public function updateSubjectImg(Request $r) {
        $data = Subject::findOrFail($r->id);
        $file = $r->file;
        $file->move('./img/subject/',  $r->id . '.' . $file->getClientOriginalExtension());
        $data->img = './img/subject/' . $r->id . '.' . $file->getClientOriginalExtension();
        $data->save();
    }

    public function deleteSubject(Request $r) {
        try {
            $subject = Subject::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa môn học thành công.', 'type' => 'success');
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
        if ($r->id != null) {
            $data = Course::findOrFail($r->id);
            $result = array('msg' => 'Đã cập nhật danh sách khóa học.', 'type' => 'success');

        }
        else { 
            $data = new Course;
            $result = array('msg' => 'Đã cập nhật danh sách khóa học.', 'type' => 'success', 'id' => $data->id);
        }
        $data->name = $r->name;
        $data->subject = $r->subject;
        $data->price = $r->price;
        $data->total_of_period = $r->total_of_period;
        $data->description = $r->description;
        $data->certificate_required = $r->certificate_required;
        $data->teaching_assistant = $r->teaching_assistant;
        $data->save();
        return $result;
    }

    public function updateCourseImg(Request $r) {
        $data = Course::findOrFail($r->id);
        $file = $r->file;
        $file->move('./img/course/',  $r->id . '.' . $file->getClientOriginalExtension());
        $data->img_url = './img/course/' . $r->id . '.' . $file->getClientOriginalExtension();
        $data->save();
    }

    public function deleteCourse(Request $r) {
        $course = Course::findOrFail($r->id)
        ->delete();
        return array('msg' => 'Xóa khóa học thành công.', 'type' => 'success');
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

    public function updateOfficeImg(Request $r) {
        $data = Office::findOrFail($r->id);
        $file = $r->file;
        $file->move('./img/office/',  $r->id . '.' . $file->getClientOriginalExtension());
        $data->location = './img/office/' . $r->id . '.' . $file->getClientOriginalExtension();
        $data->save();
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
        $data->save();
        return array('msg' => 'Đã cập nhật danh sách trung tâm.', 'type' => 'success');
    }

    public function deleteOffice(Request $r) {
        try {
            $office = Office::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa trung tâm thành công.', 'type' => 'success');
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
        return array('msg' => 'Đã cập nhật danh sách phòng học.', 'type' => 'success');
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
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
    }

    public function deleteRoomCourse($room_id, $course_id) {
        try {
            $course_room = Course_Room::where('room', $room_id)
            ->where('course', $course_id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
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
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa phòng học thành công.', 'type' => 'success');
    }

    public function getAllEmployee() {
        $data = DB::table('employee')
        ->get();
        return $data;
    }

    public function getEmployee(Request $r) {
        $data = DB::table('employee')
        ->leftjoin('office_worker', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'position.id', 'office_worker.position')
        ->where('employee.id', $r->id)
        ->select('employee.*', 'position.name as position', 'position.id as positionid', 'employee.name as name', 'employee.id as id', 'employee.address as address', 'office.name as office', 'office.id as officeid')
        ->get();
        return $data;
    }

    public function addEmployee(Request $r) {
        Debugbar::info('aa', $r);
        if ($r->id != null) {
            $data = Employee::findOrFail($r->id);
            $result = array('msg' => 'Đã cập nhật thông tin nhân viên.', 'type' => 'success');
        }
        else {
            $data = new Employee;
            $result = array('msg' => 'Thêm nhân viên thành công.', 'type' => 'success');
        }
        $data->name = $r->name;
        $data->birthday = $r->birthday;
        $data->address = $r->address;
        $data->phone = $r->phone;
        $data->mail = $r->mail;
        $data->save();
        return $result;
    }

    public function getAllWorker() {
        $data = DB::table('office_worker')
        ->leftjoin('employee', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'office_worker.position', 'position.id')
        ->select('*', 'position.name as position', 'office.name as office', 'employee.name as name', 'employee.id as id')
        ->get();
        return $data;
    }

    public function getWorker(Request $r) {
        $data = DB::table('office_worker')
        ->leftjoin('employee', 'office_worker.id', 'employee.id')
        ->leftjoin('office', 'office_worker.office', 'office.id')
        ->leftjoin('position', 'office_worker.position', 'position.id')
        ->where('employee.id', $r->id)
        ->select('*', 'position.name as position', 'position.id as positionid', 'office.name as office', 'office.id as officeid', 'employee.name as name', 'employee.id as id')
        ->get();
        return $data;
    }

    public function addWorker(Request $r) {
        if ($r->employeeid != null) {
            $data = Worker::findOrFail($r->employeeid);
            $result = array('msg' => 'Đã cập nhật thông tin nhân viên văn phòng.', 'type' => 'success');
        }
        else {
            $data = new Worker;
            $data->id = $r->id;
            $result = array('msg' => 'Thêm nhân viên văn phòng thành công.', 'type' => 'success');
        }
        $data->position = $r->position;
        $data->office = $r->office;
        $data->experience = $r->experience;
        $data->save();
        return $result;
    }

    public function deleteWorker(Request $r) {
        try {
            $data = Worker::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa nhân viên văn phòng thành công.', 'type' => 'success');
    }

    public function deleteEmployee(Request $r) {
        try {
            $data = Office_Teacher::where('teacher', $r->id)
            ->delete();
            $data = Course_Teacher::where('teacher', $r->id)
            ->delete();
            $data = Teacher::where('id', $r->id)
            ->delete();
            $data = Office_Worker::where('id', $r->id)
            ->delete();
            $data = Employee::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa nhân viên thành công.', 'type' => 'success');
    }

    public function getAllTeacher() {
        $main_teacher = DB::table('main_teacher')
        ->select('main_teacher.degree',
            'main_teacher.id',
            'employee.name as name',
            'employee.address as address',
            'employee.phone as phone',
            'employee.birthday as birthday',
            'employee.mail as mail',
            DB::raw("GROUP_CONCAT(office.name SEPARATOR ', ') as office"))
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->leftjoin('office_main_teacher', 'office_main_teacher.teacher', 'main_teacher.id')
        ->leftjoin('office', 'office.id', 'office_main_teacher.office')
        ->groupBy('main_teacher.id');
        $data = DB::table(DB::raw("({$main_teacher->toSql()}) as main_teacher"))
        ->select('main_teacher.*', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->leftjoin('course_teacher', 'course_teacher.teacher', 'main_teacher.id')
        ->leftjoin('course', 'course_teacher.course', 'course.id')
        ->groupBy('main_teacher.id')
        ->get();
        return $data;
    }

    public function getAllTA() {
        $teaching_assistant = DB::table('teaching_assistant')
        ->select('teaching_assistant.degree',
            'teaching_assistant.id',
            'employee.name as name',
            'employee.address as address',
            'employee.phone as phone',
            'employee.birthday as birthday',
            'employee.mail as mail',
            DB::raw("GROUP_CONCAT(office.name SEPARATOR ', ') as office"))
        ->leftjoin('employee', 'employee.id', 'teaching_assistant.id')
        ->leftjoin('office_ta', 'office_ta.teaching_assistant', 'teaching_assistant.id')
        ->leftjoin('office', 'office.id', 'office_ta.office')
        ->groupBy('teaching_assistant.id');
        $data = DB::table(DB::raw("({$teaching_assistant->toSql()}) as teaching_assistant"))
        ->select('teaching_assistant.*', DB::raw("GROUP_CONCAT(course.name SEPARATOR ', ') as course"))
        ->leftjoin('course_ta', 'course_ta.TA', 'teaching_assistant.id')
        ->leftjoin('course', 'course_ta.course', 'course.id')
        ->groupBy('teaching_assistant.id')
        ->get();
        return $data;
    }

    public function getTeacher(Request $r) {
        $main_teacher = DB::table('main_teacher')
        ->select('main_teacher.degree',
            'main_teacher.id',
            'employee.name as name',
            'employee.address as address',
            'employee.phone as phone',
            'employee.birthday as birthday',
            'employee.mail as mail',
            DB::raw("GROUP_CONCAT(office.id SEPARATOR ', ') as office"))
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->leftjoin('office_main_teacher', 'office_main_teacher.teacher', 'main_teacher.id')
        ->leftjoin('office', 'office.id', 'office_main_teacher.office')
        ->groupBy('main_teacher.id');
        $data = DB::table(DB::raw("({$main_teacher->toSql()}) as main_teacher"))
        ->select('main_teacher.*', DB::raw("GROUP_CONCAT(course.id SEPARATOR ', ') as course"))
        ->leftjoin('course_teacher', 'course_teacher.teacher', 'main_teacher.id')
        ->leftjoin('course', 'course_teacher.course', 'course.id')
        ->groupBy('main_teacher.id')
        ->where('main_teacher.id', $r->id)
        ->get();
        return $data;
    }

    public function getTA(Request $r) {
        $teaching_assistant = DB::table('teaching_assistant')
        ->select('teaching_assistant.degree',
            'teaching_assistant.id',
            'employee.name as name',
            'employee.address as address',
            'employee.phone as phone',
            'employee.birthday as birthday',
            'employee.mail as mail',
            DB::raw("GROUP_CONCAT(office.id SEPARATOR ', ') as office"))
        ->leftjoin('employee', 'employee.id', 'teaching_assistant.id')
        ->leftjoin('office_ta', 'office_ta.teaching_assistant', 'teaching_assistant.id')
        ->leftjoin('office', 'office.id', 'office_ta.office')
        ->groupBy('teaching_assistant.id');
        $data = DB::table(DB::raw("({$teaching_assistant->toSql()}) as teaching_assistant"))
        ->select('teaching_assistant.*', DB::raw("GROUP_CONCAT(course.id SEPARATOR ', ') as course"))
        ->leftjoin('course_ta', 'course_ta.TA', 'teaching_assistant.id')
        ->leftjoin('course', 'course_ta.course', 'course.id')
        ->groupBy('teaching_assistant.id')
        ->where('teaching_assistant.id', $r->id)
        ->get();
        return $data;
    }

    public function addTeacher(Request $r) {
        Debugbar::info("aaa", $r);
        if ($r->employeeid != null) {
            $teacher = Teacher::findOrFail($r->employeeid);
            $result = array('msg' => 'Đã cập nhật thông tin giáo viên.', 'type' => 'success');
        }
        else {
            Debugbar::info("aaa", $r);
            $teacher = new Teacher;
            $teacher->id = $r->id;
            $employee = Employee::findOrFail($r->id);
            $temp = User::where('email', $employee->mail)->first();
            if ($temp == null) {
                $data = new User;
                $data->name = $employee->name;
                $data->email = $employee->mail;
                $data->password = Hash::make('12345678');
                $data->role = 'teacher';
                $data->teacher = $employee->id;
                $data->save();
            }
            $result = array('msg' => 'Thêm giáo viên thành công.', 'type' => 'success');
        }

        $teacher->degree = $r->degree;
        $teacher->save();

        foreach ($r->office as $o) {
            $this->addOfficeTeacher($teacher->id, $o);
        }
        foreach ($r->officedel as $o) {
            $this->deleteOfficeTeacher($teacher->id, $o);
        }

        foreach ($r->course as $c) {
            $this->addCourseTeacher($teacher->id, $c);
        }
        foreach ($r->coursedel as $c) {
            $this->deleteCourseTeacher($teacher->id, $c);
        }
        return $result;
    }

    public function addTA(Request $r) {
        if ($r->employeeid != null) {
            $ta = TA::findOrFail($r->employeeid);
            $result = array('msg' => 'Đã cập nhật thông tin trợ giảng.', 'type' => 'success');
        }
        else {
            $ta = new TA;
            $ta->id = $r->id;
            $employee = Employee::findOrFail($r->id);
            $temp = User::where('email', $employee->mail)->first();
            if ($temp == null) {
                $data = new User;
                $data->name = $employee->name;
                $data->email = $employee->mail;
                $data->password = Hash::make('12345678');
                $data->role = 'teacher';
                $data->teacher = $employee->id;
                $data->save();
            }
            $result = array('msg' => 'Thêm trợ giảng thành công.', 'type' => 'success');
        }

        $ta->degree = $r->degree;
        $ta->save();
        foreach ($r->office as $o) {
            $this->addOfficeTA($ta->id, $o);
        }
        foreach ($r->officedel as $o) {
            $this->deleteOfficeTA($ta->id, $o);
        }

        foreach ($r->course as $c) {
            $this->addCourseTA($ta->id, $c);
        }
        foreach ($r->coursedel as $c) {
            $this->deleteCourseTA($ta->id, $c);
        }
        return $result;
    }

    public function addOfficeTeacher($teacher_id, $office_id) {
        try {
            $data = Office_Teacher::where('teacher', $teacher_id)
            ->where('office', $office_id)
            ->first();

            if ($data == null) {
                $data = new Office_Teacher;
                $data->office = $office_id;
                $data->teacher = $teacher_id;
                $data->save();
            }
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
    }

    public function addOfficeTA($teacher_id, $office_id) {
        try {
            $data = Office_TA::where('teaching_assistant', $teacher_id)
            ->where('office', $office_id)
            ->first();
            if ($data == null) {
                $data = new Office_TA;
                $data->office = $office_id;
                $data->teaching_assistant = $teacher_id;
                $data->save();
            }
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
    }

    public function addCourseTeacher($teacher_id, $course_id) {
        try {
            $data = Course_Teacher::where('teacher', $teacher_id)
            ->where('course', $course_id)
            ->first();

            if ($data == null) {
                $data = new Course_Teacher;
                $data->course = $course_id;
                $data->teacher = $teacher_id;
                $data->save();
            }
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
    }

    public function addCourseTA($teacher_id, $course_id) {
        try {
            $data = Course_TA::where('TA', $teacher_id)
            ->where('course', $course_id)
            ->first();

            if ($data == null) {
                $data = new Course_TA;
                $data->course = $course_id;
                $data->TA = $teacher_id;
                $data->save();
            }
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
    }

    public function deleteOfficeTeacher($teacher_id, $office_id) {
        try {
            $data = Office_Teacher::where('teacher', $teacher_id)
            ->where('office', $office_id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return back()->withInput();
    }

    public function deleteOfficeTA($teacher_id, $office_id) {
        try {
            $data = Office_TA::where('teaching_assistant', $teacher_id)
            ->where('office', $office_id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return back()->withInput();
    }

    public function deleteCourseTeacher($teacher_id, $course_id) {
        try {
            $data = Course_Teacher::where('teacher', $teacher_id)
            ->where('course', $course_id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return back()->withInput();
    }

    public function deleteCourseTA($teacher_id, $course_id) {
        try {
            $data = Course_TA::where('TA', $teacher_id)
            ->where('course', $course_id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return back()->withInput();
    }

    public function deleteTeacher(Request $r) {
        try {
            $data = Office_Teacher::where('teacher', $r->id)
            ->delete();
            $data = Course_Teacher::where('teacher', $r->id)
            ->delete();
            $data = Teacher::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa giáo viên thành công.', 'type' => 'success');
    }

    public function deleteTA(Request $r) {
        try {
            $data = Office_TA::where('teaching_assistant', $r->id)
            ->delete();
            $data = Course_TA::where('TA', $r->id)
            ->delete();
            $data = DB::table('room_ta')->where('TA', $r->id)
            ->delete();
            $data = TA::where('id', $r->id)
            ->delete();
        }
        catch (\Exception $e) {
            return array('msg' => $e->getMessage(), 'type' => 'danger');
        }
        return array('msg' => 'Xóa trợ giảng thành công.', 'type' => 'success');
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
        $data->limited = $r->limited;
        $data->start_date = $r->start_date;
        $data->end_date = $r->end_date;
        $data->save();
        return array('msg' => 'Đã cập nhật danh sách mã giảm giá.', 'type' => 'success');
    }

    public function editPromotion(Request $r) {
        $data = Promotion::find($r->code);
        if ($data != null) {
            $data->benefit = $r->benefit;
            $data->course = $r->course;
            $data->limited = $r->limited;
            $data->start_date = $r->start_date;
            $data->end_date = $r->end_date;
            $data->save();
        }
        return array('msg' => 'Đã cập nhật danh sách mã giảm giá.', 'type' => 'success');
    }

    public function deletePromotion(Request $r) {
        $data = Promotion::find($r->code);
        $data->delete();
        return array('msg' => 'Xóa mã giảm giá thành công.', 'type' => 'success');
    }

    public function getAllPosition() {
        $data = DB::table('position')
        ->get();
        return $data;
    }

    public function getPosition(Request $r) {
        $data = DB::table('position')
        ->where('id', $r->id)
        ->get();
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
                    $result[$schedule->id]['schedule'][$schedule->current_date][$schedule->schedule] = $schedule->office;
                }
            }
        }
        return $result;
    }

    public function getTAScheduleList($ta_ids, $start_range, $end_range) {
        $start_range = date('Y-m-d', strtotime($start_range));
        $end_range = date('Y-m-d', strtotime($end_range));

        $ta_schedule = $this->getTAScheduleData($ta_ids);
        $result = array();
        foreach ($ta_schedule as $schedule) {
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
                    $result[$schedule->id]['schedule'][$schedule->current_date][$schedule->schedule] = $schedule->office;
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
            'employee.name',
            'room.office')
        ->leftjoin('employee', 'employee.id', 'main_teacher.id')
        ->leftjoin('room_schedule', 'room_schedule.teacher', 'main_teacher.id')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->whereIn('main_teacher.id', json_decode($teacher_ids, TRUE))
        ->get();

        return $teacher_schedule;
    }

    public function getTAScheduleData($ta_ids) {
        $ta_schedule = DB::table('teaching_assistant')
        ->select('teaching_assistant.id',
            'room_schedule.current_date',
            'room_schedule.schedule',
            'class.start_date',
            'class.end_date',
            'employee.name',
            'room.office')
        ->leftjoin('employee', 'employee.id', 'teaching_assistant.id')
        ->leftjoin('room_ta', 'room_ta.TA', 'teaching_assistant.id')
        ->leftjoin('room_schedule', 'room_schedule.id', 'room_ta.room_schedule')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('room', 'room_schedule.room', 'room.id')
        ->whereIn('teaching_assistant.id', json_decode($ta_ids, TRUE))
        ->get();

        return $ta_schedule;
    }

    public function postRoomList(Request $r) {
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

    public function getTAScheduleInRange(Request $r) {
        $ta_list = DB::table('office_ta')
        ->select('office_ta.teaching_assistant as ta_id')
        ->leftjoin('course_ta', 'course_ta.TA', 'office_ta.teaching_assistant')
        ->where('course_ta.course', $r->course)
        ->where('office_ta.office', $r->office)
        ->distinct()
        ->get();

        if (count($ta_list) < 1) {
            return array();
        }
        $data = $this->getTAScheduleList($ta_list, $r->start_date, $r->end_date);
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

    public function getCourseOffice(Request $r) {
        $data = DB::table('course_room')
        ->select('office.id', 'office.name', 'course_room.course')
        ->leftjoin('room', 'room.id', 'course_room.room')
        ->leftjoin('office', 'office.id', 'room.office')
        ->groupBy('office.id')
        ->groupBy('course_room.course');

        $format_data = DB::table(DB::raw("({$data->toSql()}) as course_office"))
        ->select('course_office.id as office', DB::raw("GROUP_CONCAT(course_office.course SEPARATOR ', ') as course"))
        ->groupBy('course_office.id')
        ->get();
        return $format_data;
    }

    public function countRegisterBySubjectInMonth($year, $month) {
        $end_day = date('Y-m-t', strtotime($year.'-'.$month.'-01'));
        $start_day = date('Y-m-d', strtotime($year.'-'.$month.'-01'));

        $end_day = Carbon::parse($end_day)->startOfDay();
        $start_day = Carbon::parse($start_day)->startOfDay();
        $data = DB::table('register')
        ->select('subject.name', DB::raw('count(class.id) as count'))
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('course','course.id', 'class.course')
        ->rightjoin('subject','subject.id', 'course.subject')
        ->whereBetween('register.created_date', [$start_day->startOfDay(), $end_day->endOfDay()])
        ->groupBy('subject.id')
        ->get();
        return $data;
    }

    public function countRegisterBySubjectInRange($start_day, $end_day) {
        $end_day = Carbon::parse($end_day)->startOfDay();
        $start_day = Carbon::parse($start_day)->startOfDay();
        $data = DB::table('register')
        ->select('subject.name', DB::raw('count(class.id) as count'))
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('course','course.id', 'class.course')
        ->rightjoin('subject','subject.id', 'course.subject')
        ->whereBetween('register.created_date', [$start_day->startOfDay(), $end_day->endOfDay()])
        ->groupBy('subject.id')
        ->get();
        return $data;
    }

    public function countRegisterBySubjectInYear(Request $r) {
        $year = $r->year;
        $end_day = date('Y-m-t', strtotime($year.'-12-01'));
        $start_day = date('Y-m-d', strtotime($year.'-01-01'));
        $result = $this->countRegisterBySubjectInRange($start_day, $end_day);
        return $result;
    }

    public function countRegisterByOfficeInYear(Request $r) {
        $year = $r->year;
        $end_day = date('Y-m-t', strtotime($year.'-12-01'));
        $start_day = date('Y-m-d', strtotime($year.'-01-01'));
        $result = $this->countRegisterByOfficeInRange($start_day, $end_day);
        return $result;
    }

    public function countRegisterByOfficeInMonth($year, $month) {
        $end_day = date('Y-m-t', strtotime($year.'-'.$month.'-01'));
        $start_day = date('Y-m-d', strtotime($year.'-'.$month.'-01'));

        $end_day = Carbon::parse($end_day)->startOfDay();
        $start_day = Carbon::parse($start_day)->startOfDay();
        $data = DB::table('register')
        ->select('register.id as register', 'office.name as office')
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('room_schedule','room_schedule.class', 'class.id')
        ->leftjoin('room','room.id', 'room_schedule.room')
        ->rightjoin('office', 'office.id', 'room.office')
        ->whereRaw('register.created_date between ? and ?')
        ->groupBy('office.id', 'register.id');

        $new_data = DB::table(DB::raw("({$data->toSql()}) as register_office"))
        ->select('register_office.office', DB::raw('count(register_office.register) as count'))
        ->groupBy('register_office.office')
        ->setBindings([$start_day->startOfDay(), $end_day->endOfDay()])
        ->get();
        return $new_data;
    }

    public function countRegisterByOfficeInRange($start_day, $end_day) {
        $end_day = Carbon::parse($end_day)->startOfDay();
        $start_day = Carbon::parse($start_day)->startOfDay();
        $data = DB::table('register')
        ->select('register.id as register', 'office.name as office')
        ->leftjoin('class','class.id', 'register.class')
        ->leftjoin('room_schedule','room_schedule.class', 'class.id')
        ->leftjoin('room','room.id', 'room_schedule.room')
        ->rightjoin('office', 'office.id', 'room.office')
        ->whereRaw('register.created_date between ? and ?')
        ->groupBy('office.id', 'register.id');

        $new_data = DB::table(DB::raw("({$data->toSql()}) as register_office"))
        ->select('register_office.office', DB::raw('count(register_office.register) as count'))
        ->groupBy('register_office.office')
        ->setBindings([$start_day->startOfDay(), $end_day->endOfDay()])
        ->get();
        return $new_data;
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

    public function getAvailableTA(Request $r) {
        // Replace this with param in get request
        $office = $r->office;
        $course = $r->course;
        $slot_in_day = $r->slot;
        $date = $r->date;;
        //#

        $date_formated = Carbon::parse($date)->startOfDay();

        $validate = strtotime($date);
        $day_in_week = date('l', $validate);
        $data = DB::table('teaching_assistant')
        ->select('employee.name',
            'employee.id',
            'teaching_assistant.degree',
            'course_ta.course',
            'office_ta.office',
            'room_schedule.schedule',
            'room_schedule.current_date',
            'class.start_date',
            'class.end_date',
            DB::raw('COUNT( CASE WHEN (class.start_date <= ? and class.end_date >= ? and room_schedule.current_date = ? and room_schedule.schedule = ?) THEN employee.id ELSE NULL END) as count')
        )
        ->leftjoin('employee', 'employee.id', 'teaching_assistant.id')
        ->leftjoin('course_ta','course_ta.TA', 'teaching_assistant.id')
        ->leftjoin('office_ta', 'office_ta.teaching_assistant', 'teaching_assistant.id')
        ->leftjoin('room_ta', 'room_ta.TA', 'teaching_assistant.id')
        ->leftjoin('room_schedule', 'room_schedule.id', 'room_ta.room_schedule')
        ->leftjoin('class', 'room_schedule.class', 'class.id')
        ->where('course_ta.course', '=', '?')
        ->where('office_ta.office','=', '?')
        ->having('count', '=', 0)
        ->groupBy('teaching_assistant.id')
        ->setBindings([$date_formated, $date_formated, $day_in_week, $slot_in_day, $course, $office])
        ->get();
        return $data;
    }

    public function getScore(Request $r) {
        $data = DB::table('register')
        ->leftjoin('exam','exam.register', 'register.id')
        ->leftjoin('class','register.class', 'class.id')
        ->leftjoin('users','register.user', 'users.id')
        ->select('*', 'users.id as user', 'exam.score as score', 'register.id as register', 'exam.id as id')
        ->where('register.class', $r->id)
        ->get();
        return $data;
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
        ->select('employee.id','employee.name', 'employee.mail', 'position.name as position', 'position.rate_salary')
        ->get();
        foreach ($main_teacher_salary as $teacher) {
            $teaching_day = $this->getNumberOfTeachingDay($start_day, $end_day, $teacher->id);
            $day_off = $this->getNumberOfDayOff($start_day, $end_day, $teacher->id);
            $teaching_backup = $this->getNumberOfTeachingBackup($start_day, $end_day, $teacher->id);
            $teaching_offset = $this->getNumberOfTeachingOffSet($start_day, $end_day, $teacher->id);
            $mt_salary_rate = 200000;
            $ta_salary_rate = 100000;
            $officer_basic_salary = 5000000;

            $teacher->salary = $mt_salary_rate*($teaching_day - $day_off + $teaching_backup + $teaching_offset);
            $teacher->salary += $teacher->rate_salary*$officer_basic_salary;

            $ta_teaching_day = $this->getNumberOfTATeachingDay($start_day, $end_day, $teacher->id);
            $ta_day_off = $this->getNumberOfTADayOff($start_day, $end_day, $teacher->id);
            $teacher->salary += $ta_salary_rate*($ta_teaching_day - $ta_day_off);

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

    public function getNumberOfTADayOff($start_date, $end_date, $ta_id) {
        $ta_dayoff = DB::table('ta_dayoff')
        ->select(DB::raw('count(*) as count'))
        ->where('ta_dayoff.ta_id', $ta_id)
        ->whereRaw('ta_dayoff.date between ? and ?', [$start_date, $end_date])
        ->get();
        return $ta_dayoff[0]->count;
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

    public function getNumberOfTATeachingDay($start_date, $end_date, $ta_id) {
        $teacher_schedule = DB::table('room_schedule')
        ->select('room_schedule.current_date', 'class.start_date', 'class.end_date')
        ->leftjoin('class', 'class.id', 'room_schedule.class')
        ->leftjoin('room_ta', 'room_ta.room_schedule', 'room_schedule.id')
        ->where('room_ta.TA', $ta_id)
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
        if ($wF < $wT)     $isExtraDay = $day >= $wF && $day <= $wT;
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
    function getSupervisors(Request $r) {
        $supervisorList = DB::table('office_worker')
        ->select('employee.id as id', 'employee.name as name')
        ->leftjoin('employee', 'employee.id', 'office_worker.id')
        ->where('office_worker.position', 1)
        ->where('office_worker.office', $r->office_id)
        ->get();

        return $supervisorList;
    }
}
