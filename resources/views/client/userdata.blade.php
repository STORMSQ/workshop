@extends('client')
@section('css')
    table td{
    border-style:solid;
    border-width: 1px;
    }
@endsection
@section('content')

    @if($info['repeat']==1)
        您已提交過報名，不可重複提交，如欲修改，請使用<a href="/search">修改報名</a>功能
    @else
        @if($info['success'])
            <p>報名資訊</p>
            <table >

                <tr><td>*姓名：</td><td>{{$info['user']['username']}}</td></tr>
                <tr><td>*生日：</td><td>{{$info['user']['birthofdate']}}</td></tr>
                <tr><td>*身份證號碼：</td><td>{{$info['user']['id']}}</td></tr>
                <tr><td>*住址：</td><td>{{$info['user']['address']}}</td></tr>
                <tr><td>*聯絡電話1：</td><td>{{$info['user']['phone']}}</td></tr>
                <tr><td>聯絡電話2：</td><td>{{$info['user']['phone2']}}</td></tr>
                <tr><td>*Email：</td><td>{{$info['user']['email']}}</td></tr>
            </table>

        <h2><b>以下課程報名成功</b></h2>
        <table width="90%" id="class">
            <th>課程名稱</th><th>課程時間</th><th>教師名稱</th><th>課程日期</th><th><font color="red">您的課程學號</font></th>
            @for($i=0;$i<=count($info['success'])-1;$i++)

                    <tr><td>{{$info['success'][$i]['className']}}</td><td>每週 {{$info['success'][$i]['week']}}<br>{{$info['success'][$i]['start']}}-{{$info['success'][$i]['end']}}</td><td>{{$info['success'][$i]['teacher']}}</td><td>{{$info['success'][$i]['startdate']}}<br>{{$info['success'][$i]['enddate']}}</td><td><center><font size="4" ><b>{{$info['semester'][$i].'-'.str_pad($info['success'][$i]['sort'],2,"0",STR_PAD_LEFT).'-'}}{{($info['callnumber'][$i]<0)?'補'.abs($info['callnumber'][$i]):str_pad($info['callnumber'][$i],2,"0",STR_PAD_LEFT)}}</b></font></center></td></tr>

            @endfor
        </table>
        <h2>本次報名序號：<font color="red"><b>{{$info['form_id']}}</b></font>(建議您記住這個序號，如有問題時，這個序號可以快速定位到您的報名資料)</h2>
        <p><h2>提醒您：請於<font color="red">三天內</font>前繳交保證金，逾期將取消報名課程</h2></p>
        @endif
        @if($info['fail'])
           <font color="red"><b> 以下課程因已額滿報名失敗（也許是其他人在這段時間比您早提交報名）</b></font>
            <table width="90%" id="class">
            @for($i=0;$i<=count($info['fail'])-1;$i++)

                    <tr style="background:#FF0000"><td>{{$info['fail'][$i]['className']}}</td><td>每週 {{$info['fail'][$i]['week']}}<br>{{$info['fail'][$i]['start']}}-{{$info['fail'][$i]['end']}}</td><td>{{$info['fail'][$i]['teacher']}}</td><td>{{$info['fail'][$i]['startdate']}}<br>{{$info['fail'][$i]['enddate']}}</td></tr>
            @endfor
            </table>
        @endif

    @endif
    <center><a href="/"><button>離開</button></a></center>

@endsection