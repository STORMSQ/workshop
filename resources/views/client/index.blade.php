@extends('client')
<script src="{{asset('/ckeditor/ckeditor.js')}}"></script>
@include('alert')
@section('css')
    #class td{
    border-style:solid;
    border-width: 1px;
    padding: 0px;

    }
@endsection
@section('dialogcontent')
autoOpen:false,
show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "blind",
        duration: 1000
      },
height: 600,
width: 1000,
modal: true,
      buttons: {
        "OK": function() {
          $("#abscontent").html(null);
          $( this ).dialog( "close" );
        }
      }
@endsection
<script language="javascript">
var abstracts = function(id){
    $.ajax({
    url: '/ajax/abstracts',
    dataType: 'json',
    type: 'get',
    data: {
        id: id
    },
    success: function(data){
       // CKEDITOR.instances.abscontent.setData(data[0]);
       $("#abscontent").html(data[0]);
    },

    error: function (data){
        alert(status + xhr);
    }
    });
    $("#dialog").dialog("open");

}
</script>
@section('content')
        <center>現在系統時間：{{date('Y-m-d H:i:s')}}</center>
        @if($info['semester']!='none')
            <center><p><font color="red"><b>開放報名時間：{{$info['semester']['start']}}至{{$info['semester']['end']}}</b></font></p></center>
            <center><a href="/signup"><button style="width:300px;height:150px;font-size:26px;">網路報名</button></a> <a href="/search"><button style="width:300px;height:150px;font-size:26px;">報名查詢/修改</button></a></center>
            <hr>
            <center><h3>本期課程一覽</h3></center>
            <table width="100%" id="class" cellspacing="0">
                <tr><th>編號</th><th>課程名稱</th><th>時間</th><th>教師</th><th>課程日期</th><th>招生對象</th><th>課程大綱</th></tr>
                @for($i=0;$i<=count($info['class'])-1;$i++)

                    <tr align="center"><td>{{$info['semester']['year'].$info['semester']['identity'].'-'.str_pad($info['class'][$i]['sort'],2,"0",STR_PAD_LEFT)}}</td><td ><a>{{$info['class'][$i]['className']}}</a></td><td>每週 {{$info['class'][$i]['week']}}<br>{{$info['class'][$i]['start']}}-{{$info['class'][$i]['end']}}</td><td>{{$info['class'][$i]['teacher']}}</td><td>{{$info['class'][$i]['startdate']}}<br>{{$info['class'][$i]['enddate']}}</td><td>{{$info['class'][$i]['range']}}</td><td><a onclick=abstracts("{{$info['class'][$i]['id']}}")>查看</a></td>

                    </tr>

                @endfor

            </table>
        @else
            <center><h3>目前無任何研習班開放報名</h3></center>
        @endif
    

@endsection
@section('dialog')

<span id="abscontent" >
</span>

@endsection