<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Barryvdh\Debugbar\Facade as Debugbar;

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
        return true;
        
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