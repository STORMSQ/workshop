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
@section('jquery')
    $('#username, #id').blur(function(){
        username = $(document.getElementById('username')).val();
        id = $(document.getElementById('id')).val();
        if(id!=''){
            $.get('/ajax/check',{username:username,id:id},function(data){
                if(data==1){

                    $("#information").html('<font color="red">發現已有相同報名者<br>無法再以此身份報名</font>');
                    $("#submit").attr('disabled','true');
                }else if(data==2){
                    $("#information").html('<font color="red">不是有效的身份證號碼</font>');
                    $("#submit").attr('disabled','true');
                }else{

                    $("#information").html('');
                    $("#submit").removeAttr('disabled','');
                }
            });
        }

    });
    $( document ).tooltip();

    $('#id').blur(function(){
        $(this).val($(this).val().toUpperCase());
    });
@endsection
<script type="text/javascript">
    var check = function(){

        if($('#agree').is(':checked')){
            return confirm('提醒您\n報名後無法取消\n請確認您的報名，如不確定 請按取消返回');
        }else  {

            $('#agreefont').attr('color','red');
            alert('你必須同意研習班規章才可報名');

            return false;

         }
    }

    var idcheck = function(){

        id = $('#id').val();
        $.ajax({
            url: '/ajax/idcheck',
            dataType: 'json',
            type: 'get',
            data: {
                id: id


            },
            success: function(data){
                if(data==1){

                    $("#information").html('<font color="red">不是有效的身份證</font>');
                    $("#submit").attr('disabled','true');
                }else{

                    $("#information").html('');
                    $("#submit").removeAttr('disabled','');
                }

            },

            error: function (data){
                alert(status + xhr);
            }
        });


    }

    function adjust_textarea(h) {
        h.style.height = "20px";
        h.style.height = (h.scrollHeight)+"px";
    }

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
    @if($info['class'])
    <p>*此頁面將建立一份新報名，如已報名過，請使用<b><a href="/search">查詢功能</a></b>進行追加報名</p>
    <p>*簡易流程：勾選報名-->填入報名者資料-->提交報名，任何一項步驟未完成則不算報名成功</p>
    <div>
        {!! $info['note']['value'] !!}
    </div>
    <!--<p>本次暑期研習班，學生報名以暑假後的年級為主，例如欲報名國小籃球營，當前年級為小二，因暑假過後將升為三年級，因此可報名</p>
    <p><b>如有任何問題，請聯繫(049)-2637666分機215陳專員</b></p>-->
    <br>


    <center><h2>勾選課程</h2></center>
    <form action="/signup/userdata" method="post" id="main" onsubmit="return check()">
    <table width="100%" id="class" cellspacing="0">
        <tr><th>編號</th><th>課程名稱</th><th>時間</th><th>教師</th><th>課程日期</th><th>招生對象</th><th>已報名數/名額上限/候補人數</th><th><font color="red">請選取課程<br>（可多選）</font></th></tr>
    @for($i=0;$i<=count($info['class'])-1;$i++)

            <tr style="{{($info['class'][$i]['full']=='本課程連同候補位皆已額滿')?'background-color:gray':''}}" {{($info['class'][$i]['full']!='額滿')?'id=tr'.$info['class'][$i]['id']:''}} align="center"><td>{{$info['semester']['year'].$info['semester']['identity'].'-'.str_pad($info['class'][$i]['sort'],2,"0",STR_PAD_LEFT)}}</td><td ><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td>{{$info['class'][$i]['range']}}</td><td><a id="count{{$info['class'][$i]['id']}}">{{$info['class'][$i]['full']}}</a></td><td width="15%"><label for="box{{$info['class'][$i]['id']}}">
                        @if($info['class'][$i]['full']!='本課程連同候補位皆已額滿')
                            <input type="checkbox" id="box{{$info['class'][$i]['id']}}" name="signup[]" value="{{$info['class'][$i]['id']}}" onchange="choose()"></label><a id="info{{$info['class'][$i]['id']}}"></a></td>
                        @endif
                </tr>

    @endfor

    </table>
        <hr>
        <center><h2>輸入報名資訊</h2></center>
        <center><section>
            <table id="userdata" style="border-style:solid;border-width:1px;">
                <tr><td colspan="2"><center>*代表必填</center></td></tr>
                <tr><td colspan="2"><center><p id="information"></p></center></td></tr>
                <tr><td>*真實姓名：</td><td><input type="text" id="username" name="username" value=""  required></td></tr>
                <tr><td>*生日：</td><td>民國<input type="number" id="year" name="year" max="999" min="1" required>年<input type="number" id="month" name="month" max="12" min="1" required>月<input type="number" id="day" name="day" max="31" min="1" required>日</td></tr>
                <tr><td>*身份證號碼：</td><td><input type="text" id="id" name="id"  required></td></tr>
                <tr><td>*住址：</td><td><input type="text" name="address" size="30" required></td></tr>
                <tr><td>*聯絡電話1：</td><td><input type="text" name="phone" required></td></tr>
                <tr><td>聯絡電話2：</td><td><input type="text" name="phone2"></td></tr>
                <tr><td>Email：</td><td><input type="email" name="mail"></td></tr>

            </table>
        </section></center><br>
        <hr>
        <center><h2>請詳細閱讀研習班規章</h2></center>

                    <fieldset>

                            {!! $info['rule']['value'] !!}

                    </fieldset>
                   

        <center><font id="agreefont">我已詳細閱讀並同意以上研習班規章</font><input type="checkbox" id="agree" ></center>


                    <center><button id="submit" style="display:none">提交報名</button></center>
        {{csrf_field()}}
    </form>
    @else
    <p>暫無可用的課程</p>
    @endif
@endsection

