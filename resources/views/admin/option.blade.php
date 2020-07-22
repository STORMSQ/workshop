@extends('admin')
<script src="{{asset('/ckeditor/ckeditor.js')}}"></script>
@section('jquery')
    @if(Session::has('jumptopage'))

        $(document.getElementById("{{Session::get('jumptopage')}}")).click();



    @endif
@endsection
<script language="JavaScript">
    var change_f = function(name){


        if(name=='fun1'){
            $('#rulepage').attr('style','display: block');
            $('#notepage').attr('style','display:none');
            $('#adminpage').attr('style','display: none');

        }


        if(name=='fun2'){
            $('#rulepage').attr('style','display: none');
            $('#notepage').attr('style','display: block');
            $('#adminpage').attr('style','display: none');

        }

        if(name=='fun3'){
            $('#rulepage').attr('style','display: none');
            $('#notepage').attr('style','display: none');
            $('#adminpage').attr('style','display: block');

        }

    }
</script>
@include('alert')
@section('content')
    <button id="fun1" onclick=change_f('fun1')>研習班規章</button>  <button id="fun2" onclick=change_f('fun2')>報名說明</button>   <button id="fun3" onclick=change_f('fun3')>管理員密碼</button>
<div id="rulepage">
    <h2>研習班規章</h2>
    <form action="/admin/option/rule" method="post">
        <textarea class="ckeditor" name="rule">
            {{$info['rule']['value']}}
        </textarea>
        {{csrf_field()}}
            <button>修改</button>
        </form>
</div>
<div id="notepage" style="display:none">
    <h2>報名說明</h2>
    <form action="/admin/option/note" method="post">
        <textarea class="ckeditor" name="note">
            {{$info['note']['value']}}
        </textarea>
        <button>修改</button>
        {{csrf_field()}}
    </form>

</div>
    <div id="adminpage" style="display:none">
        <h2>管理員修改密碼</h2>
        <form action="/admin/option/admin" method="post">
        請輸入密碼：　　<input type="password" name="password1" value=""><br>
        請再次輸入密碼：<input type="password" name="password2" value="">
            <button>修改</button>
            {{csrf_field()}}
        </form>

    </div>
@endsection