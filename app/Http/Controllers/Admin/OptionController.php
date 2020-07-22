<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Semester;
use App\Model\Option;
use Redirect;
use Session;
use Hash;

class OptionController extends Controller
{
    //
    private $data;
    public function getData(){

        return $this->data;
    }

    public function setData($key,$value){
        $this->data[$key]=$value;

    }


    public function index(){
        $rule = Option::where('key','rule')->first();
        $note = Option::where('key','note')->first();

        $this->setData('rule',$rule);
        $this->setData('note',$note);

        return view('admin.option',['info'=>$this->getData()]);
    }

    public function rule(Request $request){
        DB::table('option')->where('id',1)->update([
           'value'=>$request->rule
        ]);
        return redirect('/admin/option');
    }
    public function note(Request $request){
        DB::table('option')->where('id',2)->update([
            'value'=>$request->note
        ]);
        $request->session()->flash('jumptopage','fun2');
        return redirect('/admin/option');
    }
    public function admin(Request $request){
        if($request->password1!=$request->password2){
            $request->session()->flash('alert-warning','兩次輸入密碼不一致');
            $request->session()->flash('jumptopage','fun3');
            return redirect('/admin/option');
        }else{
            DB::table('option')->where('key','password')->update([
               'value'=>Hash::make($request->password1)

            ]);
            $request->session()->flash('alert-warning','修改成功');
            $request->session()->flash('jumptopage','fun3');
            return redirect('/admin/option');
        }
    }
}
