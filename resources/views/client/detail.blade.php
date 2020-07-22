@extends('client')
@section('css')
    #class td{
    border-style:solid;
    border-width: 1px;
    padding: 0px;

    }
    input {
    padding: 10px;
    border: solid 1px #dcdcdc;
    transition: box-shadow 0.3s, border 0.3s;
    }


@endsection
<script type="text/javascript">
        var choose = function(){
        var classArray = new Array();
        $('input[name="signup[]"]:checked').each(function() {

            classArray.push($(this).val());
        });
        $.ajax({
            url: '/ajax/class_check',
            dataType: 'json',
            type: 'get',
            data: {
                id: classArray


            },
            success: function(data){
                //alert(JSON.stringify(data));


                for(var i=0;i<=data[1].length-1;i++){
                    $(document.getElementById('tr'+data[1][i])).css("background-color",'gray');
                    $(document.getElementById('box'+data[1][i])).css("display",'none');
                    $(document.getElementById('info'+data[1][i])).html('衝堂');


                }

                for(var i=0;i<=data[2].length-1;i++){
                    $(document.getElementById('tr'+data[2][i])).css("background-color",'');
                    $(document.getElementById('box'+data[2][i])).css("display",'block');
                    $(document.getElementById('info'+data[2][i])).html('');
                }

                for(var i=0;i<=data[3].length-1;i++){
                    $(document.getElementById('tr'+data[3][i])).css("background-color",'gray');
                    $(document.getElementById('box'+data[3][i])).css("display",'block');
                    $(document.getElementById('info'+data[3][i])).html('');

                }
                for(var i=0;i<=data[4].length-1;i++){
                    $(document.getElementById('tr'+data[4][i])).css("background-color",'gray');
                    $(document.getElementById('box'+data[4][i])).css("display",'none');
                    $(document.getElementById('info'+data[4][i])).html('檢測到身份不符');

                }
                for(var i=0;i<=data[5].length-1;i++){
                    $(document.getElementById('tr'+data[5][i])).css("background-color",'gray');
                    $(document.getElementById('box'+data[5][i])).css("display",'none');
                    $(document.getElementById('info'+data[5][i])).html('額滿');

                }



                if(data[3].length>0){
                    $('#submit').css('display','block');
                }else{
                    $('#submit').css('display','none');
                }

            },
            error: function(data,status,xhr){
                alert(status + xhr);
            }
        });



    }

</script>
@section('content')
@if($info['action']==1)

    <p>修改報名課程</p>
    <p>可直接勾選想要追加報名的課程</p>
    <form action="/signup/update" method="post">
        <p>報名編號：{{$info['form_id']}}<input type="hidden" name="form_id" value="{{$info['form_id']}}"></p>
    <table>
        <td><td>姓名</td><td><input type="text" name="username" value="{{$info['user'][0][0]}}"></td></tr>
        <td><td>生日</td><td><input type="date" name="birthofdate" value="{{$info['user'][0][1]}}"></td></tr>
        <td><td>身份證號</td><td>{{$info['user'][0][2]}}<input type="hidden" name="id" value="{{$info['user'][0][2]}}"></td></tr>
        <td><td>聯絡住址</td><td><input type="text" name="address" value="{{$info['user'][0][6]}}"></td></tr>
        <td><td>聯絡電話1</td><td><input type="text" name="phone" value="{{$info['user'][0][3]}}"></td></tr>
        <td><td>聯絡電話2</td><td><input type="text" name="phone2" value="{{$info['user'][0][4]}}"></td></tr>
        <td><td>Email</td><td><input type="email" name="mail" value="{{$info['user'][0][5]}}"></td></tr>


    </table>
    <table width="100%" id="class">
        <tr><th>課程名稱</th><th>時間</th><th>教師</th><th>課程日期</th><th>已報名人數/開放人數/候補人數</th><th>選取報名/狀態</th></tr>

        @for($i=0;$i<=count($info['class'])-1;$i++)

            @if(in_array($info['class'][$i]['id'],$info['condition']))
                <tr style="background-color:gray"  align="center"><td id="tr{{$info['class'][$i]['id']}}"><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td><a id="count{{$info['class'][$i]['id']}}">{{$info['class'][$i]['full']}}</a></td><td width="15%">
                                檢測到身份不符</td>
                </tr>
            @elseif(in_array($info['class'][$i]['id'],$info['arr']))

            <tr style="background-color:gray" align="center"><td ><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td><a id="count{{$info['class'][$i]['id']}}">{{$info['class'][$i]['full']}}</a></td><td width="15%">
                  已報名無法取消<br>{{$info['semester']}}-{{str_pad($info['sort'][array_search($info['class'][$i]['id'],$info['arr'])],2,"0",STR_PAD_LEFT)}}-{{($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber']<0)?'補'.abs($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber']):str_pad($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber'],2,"0",STR_PAD_LEFT)}}</td>

            </tr>
            @elseif(in_array($info['class'][$i]['id'],$info['has']))
                <tr style="background-color:gray" align="center"><td ><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td><a id="count{{$info['class'][$i]['id']}}">{{$info['class'][$i]['full']}}</a></td><td width="15%">
                        衝堂</td>

                </tr>
            @else
                <tr style="{{($info['class'][$i]['full']=='額滿')?'background-color:gray':''}}" {{($info['class'][$i]['full']!='額滿')?'id=tr'.$info['class'][$i]['id']:''}} align="center"><td ><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td><a id="count{{$info['class'][$i]['id']}}">{{$info['class'][$i]['full']}}</a></td><td width="15%"><label for="box{{$info['class'][$i]['id']}}">
                    @if($info['class'][$i]['full']!='額滿')
                        <input type="checkbox" id="box{{$info['class'][$i]['id']}}" name="signup[]" value="{{$info['class'][$i]['id']}}" onchange="choose()"></label><a id="info{{$info['class'][$i]['id']}}"></a></td>
                    @endif
                </tr>
            @endif

        @endfor
    </table>
        <br><center><button id="submit" style="display:none">修改報名</button></center>
        {{csrf_field()}}
    </table>
    </form>
@else
    <p>無此頁面</p>

@endif
<center><a href="/"><button>離開</button></a></center>
@endsection