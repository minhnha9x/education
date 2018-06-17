<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Barryvdh\Debugbar\Facade as Debugbar;

class ClassManageController extends Controller
{
	public function deleteClass(Request $r) {
		$class = DB::table('class')
		->where('id', $r->id)
		->delete();
		return back()->withInput();
	}
}