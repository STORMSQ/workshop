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
use Excel;
use Session;



class AdminController extends Controller
{
    private $data;
    public function getData(){

        return $this->data;
    }

    public function setData($key,$value){
        $this->data[$key]=$value;

    }

    public function index(){

        return view('admin.index');

    }

    //課程確認
    public function confirm(Request $request){

       $available = Semester::where('status','=','available')->first();
        $form_id=array();
        $this->setData('submit',0);

        //選擇使用姓名和身份證字號
        if($request->type==1){

          $so=  Semester_Overview::where(function($query) use ($request){
                                    if($request->username!='' and $request->id!=''){
                                        $query->where('username','Like','%'.$request->username.'%')
                                              ->Where('id','=',$request->id);
                                    }elseif($request->username!='' and $request->id==''){
                                        $query->where('username','Like','%'.$request->username.'%');
                                    }elseif($request->username=='' and $request->id!=''){
                                        $query->Where('id','=',$request->id);
                                    }else{
                                        $query->whereNotNull('username');
                                    }

                                    })->where('semester_id','=',$available['semester_id'])->get();
            $this->setData('submit',1);
        //選擇使用報名編號
        }elseif($request->type==2) {
            $so=  Semester_Overview::where('form_id','LIKE','%'.$request->form_id.'%')->where('semester_id','=',$available['semester_id'])->get();
            $this->setData('submit',1);
        }
        if($request->type and $so->count()>0){

            foreach($so as $row){

                array_push($form_id,$row['form_id']);
            }
            $this->setData('form_id',$form_id);

        }else{
            $this->setData('form_id',array());
        }
        return view('admin.confirm',['info'=>$this->getData()]);
    }

    //報名者詳細資料
    public function detail(Request $request){
        $this->setData('action',0);
        $class = array();
        $choose_class=array();
        $user = array();
        $confirmed= array();
        $standbys= array();
        $ov = Overview::where('form_id',$request->form)->get();
        if($ov->count() > 0 and $request->form!=''){

            $confirm= Overview::where('form_id','=',$request->form)->where('status','=',1)->get();
            $standby= Overview::where('form_id','=',$request->form)->where('status','=',0)->get();
           $available = Semester::where('status','=','available')->first();


            if($confirm->count()>0 or $standby->count()>0) {
                foreach ($confirm as $row) {
                    $classes = Classes::where('classes_id', '=', $row['classes_id'])->first();
                    array_push($choose_class,$row['classes_id']);
                    array_push($user, array($row['username'], $row['birthofdate'], $row['id'], $row['phone'], $row['phone2'], $row['email'], $row['address']));
                    array_push($confirmed, array('classes_id' => $classes['classes_id'], 'className' => $classes['className'], 'teacher' => $classes['teacher'], 'start' => $classes['start'], 'end' => $classes['end'], 'startdate' => $classes['startdate'], 'enddate' => $classes['enddate'], 'range' => $classes['range'],'callnumber' => $row['callnumber']));

                }
                foreach ($standby as $row) {
                    $classes = Classes::where('classes_id', '=', $row['classes_id'])->first();
                    array_push($choose_class,$row['classes_id']);
                    array_push($user, array($row['username'], $row['birthofdate'], $row['id'], $row['phone'], $row['phone2'], $row['email'], $row['address']));
                    array_push($standbys, array('classes_id' => $classes['classes_id'], 'className' => $classes['className'], 'teacher' => $classes['teacher'], 'start' => $classes['start'], 'end' => $classes['end'], 'startdate' => $classes['startdate'], 'enddate' => $classes['enddate'], 'range' => $classes['range']));
                }

                $force = Classes::where('semester_id','=',$available['semester_id'])
                    ->where(function($query) use ($choose_class){
                        foreach($choose_class as $row){
                            $query->where('classes_id','!=',$row);

                        }
                    })->get();
                $this->setData('force',$force);
                $this->setData('url',$request->form);

                $this->setData('form_id',$request->form);
                $this->setData('action',1);
                $this->setData('confirmed',$confirmed);
                $this->setData('standby',$standbys);
                $this->setData('user',$user);
            }else{
                $this->setData('action',0);
            }


        }
        return view('admin.detail',['info'=>$this->getData()]);
    }

    //確認課程動作
    public function update(Request $request){
        $count=0;
        if(count($request->confirm)) {
            foreach ($request->confirm as $row) {

                $class = Classes::where('classes_id',$row)->select('count')->first();
                for($i=1;$i<=$class['count'];$i++){

                    if(overview::where('classes_id','=',$row)->where('callnumber','=',$i)->get()->count()==0){
                        $last = $i;
                        break;
                    }
                }


                DB::table('overview')->where('classes_id', '=', $row)->where('form_id','=',$request->form_id)->update([
                    'callnumber' =>$last,
                    'status' => 1
                ]);
                $count++;
            }

            $request->session()->flash('alert-info',$count. '門課程確認完成');
        }else{

           $request->session()->flash('alert-warning','你沒有選擇任何課程');

        }
        return redirect('/admin/detail?form='.$request->form_id);
    }

    //強制報名
    public function force(Request $request){
        if(count($request->f_add)) {
            foreach ($request->f_add as $row) {
                $class = Classes::where('classes_id',$row)->select('count')->first();
                for($i=1;$i<=$class['count'];$i++){

                    if(overview::where('classes_id','=',$row)->where('callnumber','=',$i)->get()->count()==0){
                        $last = $i;
                        break;
                    }
                }
                DB::table('overview')->insert([
                    'classes_id' => $row,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'form_id'=>$request->form_id,
                    'username' => $request->username,
                    'birthofdate' => $request->birthofdate,
                    'id' => $request->id,
                    'phone' => $request->phone,
                    'phone2' => $request->phone2,
                    'email' => $request->mail,
                    'address'=>$request->address,
                    'status'=>1,
                    'callnumber'=>$last
                ]);
                //$count++;
            }
            $request->session()->flash('alert-info','新增報名成功');
        }else{

            $request->session()->flash('alert-warning','你沒有選擇任何課程');

        }
        return redirect('/admin/detail?form='.$request->form_id);

    }

    public function overview(Request $request){

        return view('/admin/overview');
    }

   //下載excel
    public function alllist(Request $request){
        
        
        $semester = Semester::where('status','=','available')->first();
        if($semester) {
        $title = array('報名序號','姓名','身分證字號','生日','電話號碼','電話2','地址','初始報名時間','修改報名時間');

        $data = Semester_Overview::where('semester_id', '=', $semester['semester_id'])->get();
        $i=0;
        $cell=[];
        foreach($data as $row){
            
            $cell[$i]=[
                $row['form_id'],
                $row['username'],
                $row->user_id,
                $row['birthofdate'],
                $row['phone'],
                $row['phone2'],
                $row['address'],
                $row['created_at'],
                $row['updated_at']
            ];

            $class = explode(',', $row['classes']);
            sort($class);
           
            foreach ($class as $c) {
                $o = Overview::where('classes_id', '=', $c)->where('form_id', '=', $row['form_id'])->first();
                $sort = Classes::where('classes_id',$o['classes_id'])->first();
                array_push($cell[$i], $semester['year'] . $semester['identity'] . '-' . str_pad($sort['sort'],2,'0', STR_PAD_LEFT) . '-' .(($o['callnumber']<0)? '補'.abs($o['callnumber']):str_pad($o['callnumber'],2,'0', STR_PAD_LEFT)));
              
            }   
            $i++;
        }


            Excel::create('報名一覽', function ($excel) use ($title,$cell) {
                $excel->sheet('score', function ($sheet) use ($title,$cell) {
                    //$sheet->rows($cellData);
                    $sheet->setAutoSize(true);
                    $sheet->loadView('admin.excel',array('title'=>$title, 'cell'=>$cell));
                });
            })->export('xls');
        }else{
            $request->session()->flash('alert-warning','尚未有任何開放的研習班\n如想下載一覽表，必須先開啟該其研習班');
        }
        //return redirect('/admin/overview');
    }

    public function delete(Request $request){
        DB::table('overview')->where('form_id','=',$request->form_id)->where('classes_id','=',$request->classes_id)->delete();
        return redirect('/admin/detail?form='.$request->form_id);
    }

    public function option(Request $request){

        return view('admin.option',['info'=>$this->getData()]);
    }




}
