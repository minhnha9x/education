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

        $data = array('userInfo' => (object) $user_info[0]
        );

        return view('homepage')->with($data);
    }
}