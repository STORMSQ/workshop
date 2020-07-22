@extends('client')
@section('css')
    #class td{
    border-style:solid;
    border-width: 1px;
    }
@endsection
@section('content')
    @if($info['repeat']==1)
        您已提交過，不可重複提交
    @else
   報名編號：{{$info['form_id']}}修改如下
   <p><b>以下追加報名成功：</b></p>
   <table width="90%" id="class">
        
        <tr><th>課程名稱</th><th>課程時間</th><th>教師名稱</th><th>課程起訖</th><th><font size="red">課程學號</font></th></tr>
       @for($i=0;$i<=count($info['success'])-1;$i++)

           <tr><td>{{$info['success'][$i]['className']}}</td><td>每週 {{$info['success'][$i]['week']}}<br>{{$info['success'][$i]['start']}}-{{$info['success'][$i]['end']}}</td><td>{{$info['success'][$i]['teacher']}}</td><td>{{$info['success'][$i]['startdate']}}<br>{{$info['success'][$i]['enddate']}}</td><td><font size="4" color="red"><b>{{$info['semester'][$i].'-'.str_pad($info['success'][$i]['sort'],2,"0",STR_PAD_LEFT).'-'}}{{($info['callnumber'][$i]<0)?'補'.abs($info['callnumber'][$i]):str_pad($info['callnumber'][$i],2,"0",STR_PAD_LEFT)}}</b></font></td></tr>

       @endfor
   </table>
   @if($info['fail'])
       以下課程因已額滿報名失敗（也許是其他人在這段時間比您早提交報名）
       <table width="90%" id="class">
           @for($i=0;$i<=count($info['fail'])-1;$i++)

               <tr><td>{{$info['fail'][$i]['className']}}</td><td>每週 {{$info['fail'][$i]['week']}}<br>{{$info['fail'][$i]['start']}}-{{$info['fail'][$i]['end']}}</td><td>{{$info['fail'][$i]['teacher']}}</td><td>{{$info['fail'][$i]['startdate']}}<br>{{$info['fail'][$i]['enddate']}}</td></tr>
           @endfor
       </table>
   @endif
    @endif
    <center><button><a href="/search/detail?id={{$info['form_id']}}">返回查詢報名</a></button></center>
    <center><button><a href="/">回到首頁</a></button></center>
@endsection