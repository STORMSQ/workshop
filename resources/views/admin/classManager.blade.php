@extends('admin')
@section('css')
    #class td{
    border-style:solid;
    border-width: 1px;
    padding: 0px;

    }
    .switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
    }

    /* Hide default HTML checkbox */
    .switch input {display:none;}

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 12px;
    left: 1px;
    bottom: 1px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .2s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(17px);
    -ms-transform: translateX(17px);
    transform: translateX(17px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
@endsection
@section('jquery')
@endsection
<script type="text/javascript">
    var allswitch = function(object){
    $("input[name='switch[]']").each(function(){
        if($(object).val()==$(this).val()){
            if($(object).is(':checked')){
                $(this).attr('checked', true);
                $.get('/ajax/switchs?s=open&id=' + $(object).val());


            } else {
                $(object).attr('checked',false);
                $.get('/ajax/switchs?s=close&id='+$(object).val());
            }
        }else{

            $(this).attr('checked',false);
            $.get('/ajax/switchs?s=close&id='+$(this).val());

        }


    });
    }

    var datechange = function(object,id,type){
        //alert(object.value);
       
            $.get('/ajax/datechange?t='+type+'&type='+object.id+'&id=' + id+'&v='+object.value);
        

    }
</script>


@section('content')
    <form action="/admin/classManagerAdd" method="get">
        <div style="border-width: 1px; border-style: solid;width:40%" >
            <h3>建立新專案</h3>

        學年：<input type="number" name="year" style="width: 60" required>期<input type="text" name="identity" style="width: 60" required><br>

         簡易描述：<input type="text" name="desc" >
        {{csrf_field()}}
        <button style="width: 80; height:30; font-size: 10">建立新一期</button>
        </div>
    </form>
    <hr>
    <table  id="class" cellspacing="0" width="70%">

        <tr><th>年度</th><th>期數</th><th>描述</th><th>修改</th><th>開/關</th><th>開放時間</th><th>繳費期限</th></tr>
    @foreach($info['semester'] as $row)

        <tr><td>{{$row['year']}}</td><td>{{$row['identity']}}</td><td>{{$row['desc']}}</td><td><table border="0"><tr><td><a href="/admin/classManagerDetail?id={{$row['semester_id']}}"><span class="ui-icon ui-icon-wrench"></span></a></td><td><a href="/admin/classManagerDel?id={{$row['semester_id']}}" onclick="return confirm('此操作將會刪除所有有關這個期數的所有資料\n包含課程、報名資料以及限制條件\n你確定嗎？')"><span class="ui-icon  ui-icon-close"></span></a></td></tr></table></td><td><label class="switch"><input type="checkbox" name="switch[]" value="{{$row['semester_id']}}" {{($info['available']['semester_id']==$row['semester_id'])? 'checked': ''}} onclick="allswitch(this)"><span class="slider"></span></label></td><td>起始時間<input type="datetime" id="start" name="start[]" value="{{$row['start']}}" onblur=datechange(this,'{{$row['semester_id']}}','date')><br>結束時間<input type="datetime" id="end" name="end[]" value="{{$row['end']}}" onblur=datechange(this,'{{$row['semester_id']}}','date')></td><td><input type="datetime" id="chargedue" name="chargedue[]" value="{{$row['chargedue']}}" onblur=datechange(this,'{{$row['semester_id']}}','due')></td></tr>

    @endforeach
    </table>
    <hr>


@endsection