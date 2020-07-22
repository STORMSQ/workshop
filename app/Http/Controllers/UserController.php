<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use App\Model\Option;
use Hash;
class UserController extends Controller
{
    public function login(){

        return view('admin.login');
    }

    public function check(Request $request){
        $pwd = Option::where('key','password')->first();
        if (Hash::check($request->password,$pwd['value'])) {

            $request->session()->put('user','admin');
            return redirect('/admin');
        }else{

            $request->session()->flash('alert-warning','密碼錯誤');
            return redirect('/admin/login');
        }

    }

    public function logout(Request $request){

        $request->session()->forget('user');
        return redirect('/admin/login');
    }


}
