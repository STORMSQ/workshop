<?php
/*
 * 供Ajax調用控制器
 *
 * 皆以jsonp格式回傳值
 *
 */
namespace App\Http\Controllers\Client;

use App\Model\Semester_Overview;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Classes;
use App\Model\Classes_Limit;
use App\Model\Semester;
use App\Model\Condition;


class AjaxController extends Controller
{
    //
    public function class_check(Request $request){
        $classCondition=array();
        $signuped = array();
        $available = Semester::where('status', '=', 'available')->first();
        if ($available->count() != 0) {


            $all_class = array();
            $classNumber = array();

            foreach ($available->classes as $row) {
                array_push($classNumber, $row['classes_id']);
                $day = explode(',', $row['week']);
                $week = '';
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
                $limit = Classes_Limit::where('classes_id', '=', $row['classes_id'])->get();
                $full=array();
                if ($limit->count() > 0) {
                    if ($limit[0]['current'] >= $limit[0]['count'] + $limit[0]['alternate']) {
                       array_push($full,$limit[0]['classes_id']);
                    }
                }
                //array_push($all_class, array('id' => $row['classes_id'], 'className' => $row['className'], 'start' => $row['start'], 'end' => $row['end'], 'week' => $week, 'teacher' => $row['teacher'], 'startdate' => $row['startdate'], 'enddate' => $row['enddate']));
                array_push($all_class,$row['classes_id']);
            }

        }

        if(count($request->id)>0) {

            foreach ($request->id as $row) {
                $single = Classes::where('classes_id', $row)->first();
                $condition = Condition::where('classes_id', $row)->get();
                $singleday = explode(',', $single['week']);

                $has = array();
                $tmp = '';
                $tmp1 = '';
                $tmp = strtotime($single['start']);
                $start = date('H:i:s', strtotime('+ 1sec', $tmp));
                $tmp1 = strtotime($single['end']);
                $end = date('H:i:s', strtotime('- 1 sec', $tmp1));

                foreach ($singleday as $row) {
                    $array[] = Classes::whereRaw('FIND_IN_SET(' . $row . ',week)')->where(function ($query) use ($start, $end, $single) {
                        $query->whereBetween('start', array($single['start'], $end))
                            ->orwhereBetween('end', array($start, $single['end']));

                    })->get();

                }

                //dd($array);
                for ($j = 0; $j <= count($array) - 1; $j++) {
                    foreach ($array[$j] as $row) {

                        array_push($has, $row['classes_id']);
                    }
                }



                if($condition->count()>0) {
                    foreach ($condition as $data) {

                        array_push($classCondition, $data['key2']);
                    }
                }


            }



            //dd(array_unique($has));
            $choose=$request->id;
        }else{
            $has=array();
            $choose = array();
        }
        $result = array_udiff($all_class, array_unique($has), function ($a, $b) {
            if ($a === $b) {
                return 0;
            } else {
                return ($a > $b) ? 1 : -1;
            }

        });
        $data = array($all_class,array_values(array_unique($has)),array_values(array_unique($result)),array_values($choose),array_values(array_unique($classCondition)),array_values(array_unique($full)));

        echo json_encode($data);



    }


    public function remain_class(){
        $available = Semester::where('status', '=', 'available')->first();
        $array=array();

        foreach ($available->classes as $row) {

            $class= Classes_Limit::where('classes_id','=',$row['classes_id'])->first();
            $class2 = Classes::where('classes_id','=',$row['classes_id'])->first();
            if($class){
                if($class['current']+$class['alternate'] >=$class['count']){
                    $full = '本課程連同候補位皆已額滿';
                }else{
                    $full='已報'.$class['current'].'名，名額'.$class['count'].'名，候補'.$class['alternate'].'名';
                }
                array_push($array,array($class['classes_id']=>$full));
            }else{
                array_push($array,array($row['classes_id']=>'已報0名，名額'.$class2['count'].'名，候補'.$class2['alternate'].'名'));
            }
            //dd($class);


        }
        echo json_encode($array);
    }

    public function check(Request $request){
        $array= array();
        $available = Semester::where('status', '=', 'available')->first();
        $check = Semester_Overview::/*where(function($query) use($request){
            $query->where('username','LIKE','%'.trim($request->username).'%')
                  ->where('id','LIKE','%'.trim($request->id).'%');
        })->or*/Where('user_id','LIKE','%'.trim($request->id).'%')->where('semester_id',$available['semester_id'])->get();
        if($check->count()>0){
            $array=1;
        }else{
            $id = strtoupper($request->id);
            //建立字母分數陣列
            $headPoint = array(
                'A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                'Y'=>12,'Z'=>30
            );
            //建立加權基數陣列
            $multiply = array(8,7,6,5,4,3,2,1);
            //檢查身份字格式是否正確
            if (preg_match("/^[a-zA-Z][1-2][0-9]+$/",$id) AND strlen($id) == 10){
                //切開字串
                $stringArray = str_split($id);
                //取得字母分數(取頭)
                $total = $headPoint[array_shift($stringArray)];
                //取得比對碼(取尾)
                $point = array_pop($stringArray);
                //取得數字部分分數
                $len = count($stringArray);
                for($j=0; $j<$len; $j++){
                    $total += $stringArray[$j]*$multiply[$j];
                }
                //計算餘數碼並比對
                $last = (($total%10) == 0 )? 0: (10 - ( $total % 10 ));
                if ($last != $point) {
                    $array =2;
                } else {
                    $array =0;
                }
            }  else {
                $array =2;
            }
        }
        echo json_encode($array);
    }

    public function show_class(){
        $available = Semester::where('status', '=', 'available')->first();
        $array=array();
        //dd($available->classes);

        foreach($available->classes as $row){
            //dd($row);
            array_push($array,array($row['classes_id'],$row['className']));

        }


        echo json_encode($array);
    }


    public function switchs(Request $request){
        if($request->s=='open'){
            DB::table('semester')->where('semester_id',$request->id)->update(['status'=>'available']);
        }
        if($request->s=='close'){
            DB::table('semester')->where('semester_id',$request->id)->update(['status'=>'unavailable']);
        }



    }

    public function datechange(Request $request){

        if($request->t=='date'){
            if($request->type=='start'){

                if($request->v==''){
                    DB::table('semester')->where('semester_id','=',$request->id)->update(['start'=>null]);
                }else {

                    DB::table('semester')->where('semester_id','=', $request->id)->update(['start' => $request->v]);
                }
            }elseif($request->type=='end'){
                if($request->v==''){
                    DB::table('semester')->where('semester_id',$request->id)->update(['end'=>null]);
                }else{
                    DB::table('semester')->where('semester_id',$request->id)->update(['end'=>$request->v]);
                }
            }
        }elseif($request->t=='due'){
            DB::table('semester')->where('semester_id',$request->id)->update(['chargedue'=>$request->v]);
        }
    }

    public function abstracts(Request $request){
        $class = Classes::where('classes_id',$request->id)->first();
           $array=array() ;
           
           array_push($array,$class['abstract']);
        
        echo json_encode($array);
    }



}
