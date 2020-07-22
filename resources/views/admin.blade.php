<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : TailPiece
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20130902

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欣榮圖書館研習班報名系統</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="{{asset('/blade/default.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/blade/fonts.css')}}" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="{{asset('/jquery/external/jquery/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('/jquery/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('/jquery/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/jquery/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('/jquery/jquery-ui.css')}}">
    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    <script type="text/javascript">
        $(function() {

            $( "input[type=submit], button" ).button();
           
            $( "#dialog" ).dialog({
              
                @section('dialogcontent')
                    autoOpen:false
                @show

            });
                
            
            @section('jquery')

            @show


        });

    </script>
    <style>
        input[type=checkbox]{
            zoom: 150%;
        }
        @section('css')
        @show
    </style>
</head>
<body>

<div id="header" class="container">
    <div id="logo">
        <h1><a href="/admin">線上報名後台</a>/<a href="/">前端</a></h1>
    </div>
    <div id="menu">
        <ul>
            <li class=""><a href="/admin/confirm" accesskey="1" title="">報名查詢</a></li>
            <li><a href="/admin/overview/alllist" accesskey="2" title="">統計下載</a></li>
            <li><a href="/admin/classManager" accesskey="3" title="">課程管理</a></li>
            <li><a href="/admin/option" accesskey="4" title="">其他設定</a></li>
            <li><a href="/admin/log" accesskey="4" title="">維護說明</a></li>
            <li><a href="/admin/logout" accesskey="5" title="">登出</a></li>

        </ul>
    </div>
</div>
<div id="page">
    <div class="container">
        @section('content')
        <div class="title">
            @section('title')
            <h2>Nulla luctus eleifend purus</h2>
            <p>This is <strong>TailPiece</strong>, a free, fully standards-compliant CSS template designed by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. The photos in this template are from <a href="http://fotogrph.com/"> Fotogrph</a>. This free template is released under the <a href="http://templated.co/license">Creative Commons Attribution</a> license, so you're pretty much free to do whatever you want with it (even use it commercially) provided you give us credit for it. Have fun :) </p>
            @show
        </div>


        <div class="boxA">
            @section('left')
            <div class="box margin-btm">
                <img src="images/pic01.jpg" width="320" height="180" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
            <div class="box">
                <img src="images/pic02.jpg" width="320" height="220" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
            @show
        </div>


        <div class="boxB">
            @section('middle')
            <div class="box">
                <img src="images/pic03.jpg" width="320" height="280" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
            <div class="box">
                <img src="images/pic05.jpg" width="320" height="140" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
            @show
        </div>


        <div class="boxC">
          @section('right')
            <div class="box">
                <img src="images/pic04.jpg" width="320" height="200" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
            <div class="box">
                <img src="images/pic06.jpg" width="320" height="200" alt="" />
                <div class="details">
                    <p>Consectetuer adipiscing elit. Nam pede erat, porta eu, lobortis eget, tempus et, tellus. Etiam neque. Vivamus consequat lorem at nisl.</p>
                </div>
                <a href="#" class="button">More Details</a>
            </div>
          @show
        </div>
      @show
    </div>
</div>
<div id="copyright" class="container">
    <p>&copy; 欣榮圖書館. | 南投縣竹山鎮大勇路26號 | (049)2637666 </p>
</div>
<div id="dialog" title="課程大綱">
  @section('dialog')
  @show
</div>

</body>
</html>
