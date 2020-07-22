@extends('admin')
    @section('navi')
        <li>
            <a href="">首頁</a> <span class="divider">/</span>	
        </li>
        <li>
            <a href="{{route('project_home')}}">報名管理首頁</a> <span class="divider">/</span>	
        </li>
         <li class="active">新增一個新專案</li>
    @endsection
   
@section('content')
<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"></div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">
            <form class="form-horizontal" action="{{route('project_action',['type'=>'add'])}}" method="post">
            {{csrf_field()}}
              <fieldset>
                <legend>基本資料新增</legend>
                <div class="control-group">
                  <label class="control-label" for="class_name">學年名稱 </label>
                  <div class="controls">
                    <input type="text" class="span6" id="class_name" name="year_name" value="{{old('class_name')}}" required>                    
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="class_name">學期名稱 </label>
                  <div class="controls">
                    <input type="text" class="span6" id="class_name" name="semester_name" value="{{old('class_name')}}" required>                    
                  </div>
                </div>
                <div class="control-group {{($errors->has('start') )?'error':''}}">
                  <label class="control-label" for="date_range">報名開始</label>
                   <div class="controls date_group">
                        <div class="form-group">
                            <div class="input-append date form_datetime" data-date="" data-date-format="yyyy-mm-dd hh:ii:00">
                                <input size="16" name="start" type="text" value="" >
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>
                          @foreach($errors->get('start') as $row)
                            <span class="help-inline">{{$row}}</span>
                          @endforeach
                    </div>
                    
                  
                
                 
               
                </div>
                 <div class="control-group">
                  <label class="control-label" for="date_range">報名結束</label>
                     <div class="controls date_group">
                        <div class="form-group">
                            <div class="input-append date form_datetime" data-date-format="yyyy-mm-dd hh:ii:00">
                                <input size="16" name="end" type="text" value="" >
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>
                    </div>
                 </div>
                <div class="control-group">
                  <label class="control-label" for="date_range">繳費結束時間</label>
                     <div class="controls date_group">
                        <div class="form-group">
                            <div class="input-append date form_datetime" data-date-format="yyyy-mm-dd hh:ii:00">
                                <input size="16" name="pay_due" type="text" value="" >
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>
                    </div>
                 </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">新增</button>
                  <button type="reset" class="btn">取消</button>
                </div>
                <input type="hidden" name="type" value="addYearSemester">
                {{csrf_field()}}
              </fieldset>

            </form>

        </div>
    </div>
</div>
    @endsection

    @section('jquery')
    <link href="{{asset('templates/vendors/clockpicker/bootstrap-clockpicker.css')}}" rel="stylesheet"></style>
    <script src="{{asset('templates/vendors/clockpicker/bootstrap-clockpicker.js')}}"></script>
   
    <script>
    function openclock(o){
        $("input[name=class_time_start]").click();
    }
    $(function(){
         $('.form_datetime').datetimepicker({
                language:  'zh-TW',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 0
            });
           
       
        $(".uniform_on").uniform();
        $(".chzn-select").chosen();
        //$('.textarea').ckeditor();

        var clockInput = $('.clockpicker').clockpicker({
			placement: 'bottom',
		    autoclose: true
		});

		/*$('#showClock').click(function(e){
			e.stopPropagation();
			$('.clockpicker').clockpicker('show');
        });*/
        
        $(".date_group").each(function(index, element) {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            
            var checkin = $(this).find(".datepicker").eq(0).datepicker({
                    onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
            }
            checkin.hide();
            
            }).data('datepicker');
            
            var checkout = $(this).find(".datepicker").eq(1).datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
            }).on('changeDate', function(ev) {
            checkout.hide();
            }).data('datepicker');

        });
       
    });
    function openclock(o){
            event.stopPropagation();
            $("input[name="+o+"]").click();
        
    }

    
    
    </script>
@endsection
   