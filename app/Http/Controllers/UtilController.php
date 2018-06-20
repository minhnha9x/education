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