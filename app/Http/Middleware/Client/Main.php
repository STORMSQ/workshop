<?php

namespace App\Http\Middleware\Client;

use Closure;
use Session;
use App\Model\Semester;
use DB;


class Main
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$available = Semester::where('status','available')->first();
        $available = DB::table('semester')->where('status','available')->first();
        $now = strtotime(date('Y-m-d H:i:s'));

        $open= strtotime(date($available->start));
        $close = strtotime(date($available->end));
        //dd($now,$open,$close);

        if(session('user')!='admin') {
            if($available) {
                if ($available->start != null) {
                    if ($now < $open) {
                        $request->session()->flash('alert-warning', '尚未到達報名時間\n');
                        return redirect('/');
                    }
                }
                if ($available->end != null) {
                    if ($now > $close) {
                        $request->session()->flash('alert-warning', '已超過報名時間\n');
                        return redirect('/');
                    }
                }
            }else{
                $request->session()->flash('alert-warning', '研習班目前尚無開放\n');
                return redirect('/');
            }

        }

            return $next($request);
        
    }
}
