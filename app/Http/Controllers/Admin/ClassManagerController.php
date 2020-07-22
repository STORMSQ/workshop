<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Classes;
use App\Model\Semester;
use App\Model\Overview;
use App\Model\Semester_Overview;
use App\Model\Condition;
use Redirect;
use Session;

class ClassManagerController extends Controller
{
    public function getData(){

        return $this->data;
    }

    public function setData($key,$value){
        $this->data[$key]=$value;

    }
    //課程管理主選單
    public function classManager(){

        $available = Semester::where('status','available')->first();
        $this->setData('semester',Semester::all());
        $this->setData('available',$available);


        //$this->setData('semester',Semester::all());



        return view('admin.classManager',['info'=>$this->getData()]);
    }

    public function classManagerAdd(Request $request){
        DB::table('semester')->insert([
            'year'=>$request->year,
            'identity'=>$request->identity,
            'desc'=>$request->desc,
            'status'=>'unavailable'

        ]);
        return redirect('/admin/classManager');
    }

    public function classManagerUpdate(Request $request){
        DB::table('semester')->where('semester_id',$request->id)->update([
            'year'=>$request->year,
            'identity'=>$request->identity,
            'desc'=>$request->desc
        ]);
        $request->session()->flash('jumptopage','fun3');

        return redirect('/admin/classManagerDetail?id='.$request->id);
    }

    public function classManagerDel(Request $request){

        $class = Classes::where('semester_id',$request->id)->get();
            if($class->count()>0){
                foreach($class as $row){
                    DB::table('overview')->where('classes_id',$row['classes_id'])->delete();
                }
                DB::table('classes')->where('semester_id',$request->id)->delete();
            }
            DB::table('condition')->where('semester_id',$request->id)->delete();
            DB::table('semester')->where('semester_id',$request->id)->delete();

        return redirect('/admin/classManager');

    }
    public function classManagerDetail(Request $request){

    //課程管理細部
        $class = Classes::where('semester_id','=',$request->id)->get();
        $condition = Condition::where('semester_id','=',$request->id)->get();

        $semester = Semester::where('semester_id',$request->id)->first();

        $this->setData('class',$class);
        $this->setData('semester',$semester);

        $this->setData('class',$class);

        $this->setData('semester_id',$request->id);
        $this->setData('condition',$condition);
        $this->setData('c_id',$request->id);
        return view('admin.classManagerDetail',['info'=>$this->getData()]);
    }

    //修改動作
    public function classManagerAction(Request $request){
        //dd($request->data);
        $week='';
        $a=1;
        foreach($request->data as $row){

           $week=join(',',$row['date']);

            if($row['classes_id']=='none'){


                DB::table('classes')->insert([
                    'semester_id'=>$request->id,
                    'className'=>$row['className'],
                    'teacher'=>$row['teacher'],
                    'count'=>$row['count'],
                    'startdate'=>$row['startdate'],
                    'enddate'=>$row['enddate'],
                    'week'=>$week,
                    'start'=>$row['start'],
                    'end'=>$row['end'],
                    'range'=>$row['range'],
                    'sort'=>$a,
                    'abstract'=>$row['abstract'],
                    'alternate'=>$row['alternate']
                ]);
            }else{

                DB::table('classes')->where('classes_id','=',$row['classes_id'])->update([
                    'semester_id'=>$request->id,
                    'className'=>$row['className'],
                    'teacher'=>$row['teacher'],
                    'count'=>$row['count'],
                    'startdate'=>$row['startdate'],
                    'enddate'=>$row['enddate'],
                    'week'=>$week,
                    'start'=>$row['start'],
                    'end'=>$row['end'],
                    'range'=>$row['range'],
                    'sort'=>$a,
                    'abstract'=>$row['abstract'],
                    'alternate'=>$row['alternate']
                ]);
            }
        $a++;
        }
        return redirect('/admin/classManagerDetail?id='.$request->id);
    }

    //刪除課程
    public function classManagerDelete(Request $request){

        DB::table('overview')->where('classes_id','=',$request->id)->delete();
        DB::table('classes')->where('classes_id','=',$request->id)->delete();

        return redirect('/admin/classManagerDetail?id='.$request->url);
    }

    //排除法執行動作
    public function classManagerConditionAction(Request $request){

        $repeat=0;
        //dd($request);
        foreach($request->condition as $row){

            //假如非新增，則使用update
            if($row['cid']!='none') {
                if ($row['classes_id'] == $row['key2']) {
                    $repeat++;
                }else{
                    DB::table('condition')->where('cid', '=', $row['cid'])->update([
                        'classes_id' => $row['classes_id'],
                        'key2' => $row['key2']
                    ]);
                }
            }else{
                if ($row['classes_id'] == $row['key2']) {
                    $repeat++;
                }else{
                    DB::table('condition')->insert([
                        'semester_id'=>$request->id,
                        'classes_id' => $row['classes_id'],
                        'key2' => $row['key2']
                    ]);
                }
            }

        }

        $request->session()->flash('jumptopage','fun2');


        if($repeat>0) {
            $request->session()->flash('alert-warning', '有' . $repeat . '筆條件相同而被忽略');
        }
        return redirect('/admin/classManagerDetail?id='.$request->id);
    }

    //刪除條件
    public function classManagerConditionDelete(Request $request){

        DB::table('condition')->where('cid','=',$request->cid)->delete();
        $request->session()->flash('jumptopage','fun2');
        return redirect('/admin/classManagerDetail?id='.$request->url);
    }
}
