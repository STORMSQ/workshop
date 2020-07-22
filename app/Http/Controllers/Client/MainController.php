<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Semester;
use App\Model\Users;
use App\Model\Overview;
use App\Model\Condition;
use App\Model\Semester_User;
use App\Model\Classes_Limit;
use App\Model\Semester_Overview;
use Redirect;
use DB;
use Session;
use Symfony\Component\Translation\Interval;
use App\Model\Option;

class MainController extends Controller
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

        $semester = Semester::where('status','available')->first();
        if($semester){
            $this->setData('class',$this->limit());
            $this->setData('semester',$semester);
        }else{
            $this->setData('class','none');
            $this->setData('semester','none');
        }



        return view('client.index',['info'=>$this->getData()]);
    }


    public function getday($day){
        $week='';
        foreach ($day as $d) {
            switch ($d) {
                case 1:
                    $week .= '(一)';
                    break;
                case 2:
                    $week .= '(二)';
                    break;
                case 3:
                    $week .= '(三)';
                    break;
                case 4:
                    $week .= '(四)';
                    break;
                case 5:
                    $week .= '(五)';
                    break;
                case 6:
                    $week .= '(六)';
                    break;
                case 7:
                    $week .= '(日)';
                    break;
            }
        }

        return $week;
    }

    public function limit(){
        $class = array();
        $available = Semester::where('status', '=', 'available')->first();
        if ($available) {



            foreach ($available->classes as $row) {

                $day = explode(',', $row['week']);
                $week=$this->getday($day);

                $limit = Classes_Limit::where('classes_id', '=', $row['classes_id'])->first();

                if ($limit) {
                    if ($limit['current'] >= $limit['count']+$limit['alternate']) {
                        $full = '本課程連同候補位皆已額滿';
                    }else{
                        $full='已報'.$limit['current'].'名，名額'.$limit['count'].'名，候補'.$row['alternate'].'名';
                    }
                }else{
                    $full='已報0名，名額'.$row['count'].'名，候補'.$row['alternate'].'名';
                }
                array_push($class, array('id' => $row['classes_id'], 'className' => $row['className'], 'start' => $row['start'], 'end' => $row['end'], 'week' => $week, 'teacher' => $row['teacher'], 'startdate' => $row['startdate'], 'enddate' => $row['enddate'], 'limit' => $row['limit'], 'full' => $full,'range'=>$row['range'],'sort'=>$row['sort']));
            }
            return $class;
        }else{
            array_push($class,'false');
        }

    }
#####################################################################################

    public function signup(){
        session(['token'=>null]);

        $this->setData('class',$this->limit());
        $this->setData('semester',Semester::where('status','available')->first());
        $this->setData('rule',Option::where('key','rule')->first());
        $this->setData('note',Option::where('key','note')->first());

        return view('client.signup',['info'=>$this->getData()]);

    }

    public function userdata(Request $request){
        $this->validate($request,[
            'month'=> 'required|max:12|min:1',
            'day'=>'required|max:31|min:1'
        ]);
        $this->setData('repeat',0);
        $result = DB::select("select * from semester left join classes on classes.semester_id = semester.semester_id  left join overview on classes.classes_id = overview.classes_id where overview.id = ? and semester.`status` = 'available'",[$request->id]);
        
        //dd(count($result));
        
        if($request->_token!=session('token') and count($result)==0){
            $success = array();
            $fail = array();
            $time = strtotime(date("YmdHis"));
            $i = 0;
            foreach ($request->signup as $row) {
                $limit = Classes_Limit::where('classes_id', $row)->first();
                $class = Classes::where('classes_id','=',$row)->first();
                if ($limit and $limit['current'] >= $limit['count']+$limit['alternate']) {

                    array_push($fail, $class);

                } else {

                    $class['week']=$this->getday(explode(',', $class['week']));
                    array_push($success, $class);
                    $i++;

                }
            }
          
            $num='';
            $avcl=array();
            $semester = Semester::where('status','available')->first();
            $se = $semester;
            
            $so = Semester_Overview::where('semester_id',$semester['semester_id'])->max('form_id');
            $cnum=str_pad($so,4,'0', STR_PAD_LEFT);
            $date = date('md');

            if($cnum==null or substr($cnum,0,4)!=date('md')){
                
                $num=($date.str_pad('1',3,'0', STR_PAD_LEFT));
            }elseif(substr($cnum,0,4)==date('md')){
                $add = substr($cnum,4,3);
                $add++;
                $num=substr($cnum,0,4).str_pad($add,3,'0', STR_PAD_LEFT);
            }

           
            if ($i > 0) {

              
                $callnumber=array();
                $semester=array();
                //dd($success);
                foreach ($success as $row) {

                    $class = Classes::where('classes_id',$row['classes_id'])->select(['count','alternate'])->first();
                    for($i=1;$i<=$class['count']+$class['alternate'];$i++){

                        if($i - $class['count']<=0 and overview::where('classes_id','=',$row['classes_id'])->where('callnumber','=',$i)->get()->count()==0){
                            
                                $last = $i;
                                break;
                          
                        }
                        if($i - $class['count']>0 and overview::where('classes_id','=',$row['classes_id'])->where('callnumber','=',($i-$class['count'])*-1)->get()->count()==0){
                            
                                 $last =  ($i - $class['count'])*-1;
                                 break;             
                         
                         }

                        
                        
                    }
                   
                     
                   //dd($last);
                   
                    array_push($semester,Classes::where('classes_id',$row['classes_id'])->first()->semester['year'].Classes::where('classes_id',$row['classes_id'])->first()->semester['identity']);
                    array_push($callnumber,$last);

                  
                    $d=mktime(0,0,0,$request->month,$request->day,$request->year+1911);
                    $dateofbirth =date('Y-m-d',$d);
                    DB::table('overview')->insert([
                        'classes_id' => $row['classes_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'form_id'=>$num,
                        'username' => $request->username,
                        'birthofdate' => $dateofbirth,
                        'id' => $request->id,
                        'phone' => $request->phone,
                        'phone2' => $request->phone2,
                        'email' => $request->mail,
                        'address'=>$request->address,
                        'status'=>1,
                        'callnumber'=>$last

                    ]);
                }
            }
            $this->setData('user', array('username' => $request->username,
                'id' => $request->id,
                'birthofdate' => $request->birthofdate,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'email' => $request->mail,
                'address' => $request->address));

            session(['token'=>$request->_token]);
            $this->setData('success', $success);
            $this->setData('form_id',$num);
            $this->setData('fail', $fail);
            $this->setData('user', array('username' => $request->username, 'birthofdate' => $request->birthofdate, 'id' => $request->id, 'phone' => $request->phone, 'phone2' => $request->phone2, 'email' => $request->mail,'address'=>$request->address));
            $this->setData('callnumber',$callnumber);
            $this->setData('semester',$semester);
            $this->setData('se',$se);

        }else{
            $this->setData('repeat',1);
        }

        return view('client.userdata',['info'=>$this->getData()]);
    }

    public function search(Request $request){
        $this->setData('id','');
        $this->setData('result',0);
            if($request->username and $request->id) {
                $availabled = array();
                $available = Semester::where('status', '=', 'available')->first();
                if ($available) {
                    foreach ($available->classes as $row) {
                        array_push($availabled, $row['classes_id']);
                    }

                    $class = Overview::where('username', '=', $request->username)->where('id', '=', $request->id)->get();
                    $id = array();
                    foreach ($class as $row) {
                        if (in_array($row['classes_id'], $availabled)) {
                            array_push($id, $row['form_id']);
                        }
                    }
                   
                    $this->setData('id', array_unique($id));
                    $this->setData('result', 1);
                }
            }

            return view('client.search',['info'=>$this->getData()]);

    }

    public function detail(Request $request){
        session(['token'=>'']);
       
        $arr=array();
        $user=array();
        $availabled=array();
        $callnumber=array();
        $sort=array();
        $has = array();
        $available = Semester::where('status', '=', 'available')->first();
        $overview = Overview::where('form_id',$request->id)->get();
        $classCondition=array();
        $this->setData('action',0);
        if($available) {
            foreach($available->classes as $data){
                array_push($availabled,$data['classes_id']);
            }
            if ($overview->count() > 0) {
                $this->setData('action', 1);
                foreach ($overview as $key=>$row) {
                    
                    if(in_array($row['classes_id'],$availabled) and count($availabled) >0) {
                        $c = Classes::where('classes_id', $row['classes_id'])->first();
                        array_push($sort, $c['sort']);
                        $condition = Condition::where('classes_id', $row['classes_id'])->get();

                        $singleday = explode(',', $c['week']);


                        $tmp = '';
                        $tmp1 = '';
                        $tmp = strtotime($c['start']);
                        $start = date('H:i:s', strtotime('+ 1sec', $tmp));
                        $tmp1 = strtotime($c['end']);
                        $end = date('H:i:s', strtotime('- 1 sec', $tmp1));

                        foreach ($singleday as $d) {
                            $array[] = Classes::whereRaw('FIND_IN_SET(' . $d . ',week)')->where(function ($query) use ($start, $end, $c) {
                                $query->whereBetween('start', array($c['start'], $end))
                                    ->orwhereBetween('end', array($start, $c['end']));

                            })->get();

                        }
                        for ($j = 0; $j <= count($array) - 1; $j++) {
                            foreach ($array[$j] as $d1) {

                                array_push($has, $d1['classes_id']);


                            }

                        }
                        if ($condition->count() > 0) {
                            foreach ($condition as $data) {

                                array_push($classCondition, $data['key2']);
                            }
                        }

                        $day = explode(',', $c['week']);
                        $week = $this->getday($day);
                        
                        array_push($arr, $row['classes_id']);
                        array_push($user, array($row['username'], $row['birthofdate'], $row['id'], $row['phone'], $row['phone2'], $row['email'], $row['address']));
                    }else{
                        $this->setData('action',0);
                    }
                }
                $limit = $this->limit();

                
                $this->setData('semester',$available['year'].$available['identity']);
                $this->setData('class', $limit);
                $this->setData('classes', $sort);
                $this->setData('user', $user);
                $this->setData('arr', $arr);
                $this->setData('data', $overview);
                $this->setData('condition', $classCondition);
                $this->setData('form_id', $request->id);
                $this->setData('has', $has);
                $this->setData('sort', $sort);
                $this->setData('callnumber', $callnumber);

            }

        }
        return view('client.detail',['info'=>$this->getData()]);
    }

    public function update(Request $request){

        
        $this->setData('repeat',0);
        $success = array();
        $fail = array();
        $semester=array();
        $callnumber=array();
        if($request->_token!=session('token')) {
            $classes = array();

            $i=0;
            foreach ($request->signup as $row) {
                //$class = Classes::where('classes_id',$row)->select('count')->first();
                /*for($i=1;$i<=$class['count'];$i++){

                    if(overview::where('classes_id','=',$row)->where('callnumber','=',$i)->get()->count()==0){
                        $last = $i;
                        break;
                    }
                }*/

                $class = Classes::where('classes_id',$row)->select(['count','alternate'])->first();
                for($i=1;$i<=$class['count']+$class['alternate'];$i++){

                    if($i - $class['count']<=0 and overview::where('classes_id','=',$row)->where('callnumber','=',$i)->get()->count()==0){
                        
                            $last = $i;
                            break;
                      
                    }
                    if($i - $class['count']>0 and overview::where('classes_id','=',$row)->where('callnumber','=',($i-$class['count'])*-1)->get()->count()==0){
                        
                             $last =  ($i - $class['count'])*-1;
                             break;             
                     
                     }

                    
                    
                }
              
                array_push($semester,Classes::where('classes_id',$row)->first()->semester['year'].Classes::where('classes_id',$row)->first()->semester['identity']);
                array_push($callnumber,$last);

                $limit = Classes_Limit::where('classes_id', $row)->first();
                $class = Classes::where('classes_id','=',$row)->first();
                if ($limit and $limit['current'] >= $limit['count']+$limit['alternate']) {

                    array_push($fail, $class);

                } else {

                    $class['week']=$this->getday(explode(',', $class['week']));
                    array_push($success, $class);
                    $i++;

                }
            }

           if($i>0){
               foreach ($success as $row) {
                   DB::table('overview')->insert([
                       'classes_id' => $row['classes_id'],
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
                       'callnumber'=>$last,
                       'status'=>1

                   ]);
               }

           }



            $this->setData('user', array('classes_id' => $row, 'username' => $request->username,
                'id' => $request->id,
                'birthofdate' => $request->birthofdate,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'email' => $request->mail,
                'address' => $request->address));

            session(['token'=>$request->_token]);
            $this->setData('success', $success);

            $this->setData('fail', $fail);
            $this->setData('callnumber',$callnumber);
            $this->setData('semester',$semester);
        }else{
            $this->setData('repeat',1);
        }
        $this->setData('form_id',$request->form_id);
        return view('client.update',['info'=>$this->getData()]);

    }




}
