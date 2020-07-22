<?php
namespace App\Services;
use Carbon\Carbon;
class GlobalData{

    public function validateDateTimeDiff($start_date,$end_date,$start_time='00:00',$end_time='00:00')
    {
        $start = Carbon::parse($start_date.' '.$start_time.':00');
        $end = Carbon::parse($end_date.' '.$end_time.':00');
        if($start->gt($end)){
            return false;
        }else{
            return true;
        }
    }
}