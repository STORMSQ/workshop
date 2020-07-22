
<script src="<?php echo e(asset('/ckeditor/ckeditor.js')); ?>"></script>
<?php $__env->startSection('jquery'); ?>
    $( "#sortable" ).sortable();
    $( "#tabs" ).tabs();
   
                
    <?php if(Session::has('jumptopage')): ?>

           $(document.getElementById("<?php echo e(Session::get('jumptopage')); ?>")).click();
    <?php endif; ?>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('dialogcontent'); ?>
autoOpen:false,
height: 600,
width: 1000,
modal: true,
      buttons: {
        "OK": function() {
          var value = CKEDITOR.instances['abs'].getData();
          $(document.getElementById(document.getElementById('object').value)).val(value);  
          
          
          CKEDITOR.instances.abs.setData( '' );
          $( "#object").val();
          $( this ).dialog( "close" );
        }
      }
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    .tb td{
    border-style:solid;
    border-width: 1px;
    padding: 0px;
    white-space: nowrap;
    font-size: 12px;

    }
    input[type=text]  {
    width:110;
    }
    input[type=number]
    {
    width:40;
    }
    input[type=date]
    {
    width:auto;
    }
    input[type=time]
    {
    width:140;
    }

    #tabs div{
        background: parent;
    }
<?php $__env->stopSection(); ?>
<script language="javascript">

    var i =0;
    var j=0 ;
    var add_row = function(number){
        if(i<=number){
            i=number+1;
        }


        str ='<tr id="tr['+i+']"><td><input type="hidden" name=data['+i+'][classes_id] value="none"><input type="text" name=data['+i+'][className] value="" required><td>週一<input type="checkbox" name=data['+i+'][date][] value="1" >週二<input type="checkbox" name=data['+i+'][date][] value="2" >週三<input type="checkbox" name=data['+i+'][date][] value="3" ><br>週四<input type="checkbox" name=data['+i+'][date][] value="4" >週五<input type="checkbox" name=data['+i+'][date][] value="5" >週六<input type="checkbox" name=data['+i+'][date][] value="6" ><br>週日<input type="checkbox" name=data['+i+'][date][] value="7" ></td><td>開始日期<br><input type="date" name="data['+i+'][startdate]" required><br>結束日期<br><input type="date" name="data['+i+'][enddate]" required></td><td>開始時間<br><input type="time" name=data['+i+'][start] required><br>結束時間<br><input type="time" name=data['+i+'][end] required></td><td><input type="text" name=data['+i+'][teacher] required></td><td><input type="text" name="data['+i+'][range]" required></td><td><input type="number" name=data['+i+'][count] required> / <input type="number" name=data['+i+'][alternate] value="" required></td><td><input type="hidden" id=data['+i+'][abstract] name=data['+i+'][abstract] value=""><a onclick=getAbs("data['+i+'][abstract]")>編輯</a></td><td><center><a  onclick=del_row("tr['+i+']")>X</a></center></td></td></tr>';

        $( '#sortable' ).append(str);

        i++;
    }
    var add_condition= function(number){
        if(j<=number){
             j=number+1;
        }
        str='';
        $.ajax({
            url: '/ajax/show_class',
            dataType: 'json',
            type: 'get',
            success: function(data) {

                str+='<tr id=c_tr['+j+']><td>如果選擇<input type=hidden name=condition['+j+'][cid] value="none"><select name=condition['+j+'][classes_id]>';
                for(var a=0;a<=data.length-1;a++){
                    str+='<option value='+data[a][0]+'>'+data[a][1]+'</option>';
                }
                str+='</select>，則禁止選擇<select name=condition['+j+'][key2]>';
                for(var b=0;b<=data.length-1;b++){
                    str+='<option value='+data[b][0]+'>'+data[b][1]+'</option>';
                }
                str+='</select></td><td><a onclick=del_row("c_tr['+j+']")>刪除</a></td></tr>';
                $('#cond').append(str);
                j++;

            },
            error: function(data,status,xhr){
                alert(status + xhr);
            }
            });


    }
    var del_row = function(object){

        $(document.getElementById(object)).remove();
    }

    var change_f = function(name){



        if(name=='fun1'){
            $('#class1').attr('style','display: block');
            $('#class2').attr('style','display:none');
            $('#class3').attr('style','display:none');
        }


        if(name=='fun2'){
            $('#class1').attr('style','display: none');
            $('#class2').attr('style','display: block');
            $('#class3').attr('style','display:none');
        }
        if(name=='fun3') {
            $('#class1').attr('style', 'display: none');
            $('#class2').attr('style', 'display: none');
            $('#class3').attr('style', 'display: block');

        }
    }
    var checkdata = function(){

        st=true;
        for(x=0;x<=i-1;x++){

            if($('input[name="data['+x+'][date][]"]').exists() && $('input[name="data['+x+'][date][]"]:checked').length==0){
                /////alert(x);
                st=false;
            }
        }
        return st;



    }
    var getAbs = function(object){
        CKEDITOR.instances.abs.setData(document.getElementById(object).value);
        
        $( "#object").val(object);

        $( "#dialog" ).dialog( "open" );
    }
</script>
<?php $__env->startSection('content'); ?>
    <div>

    </div>

    <button onclick="change_f('fun1')">課程管理</button> <button id="fun2" onclick="change_f('fun2')">排除法選課條件設置</button><button id="fun3" onclick="change_f('fun3')">修改學期</button>
    <div id="class3" style="display:none">
        <form action="/admin/classManagerUpdate" method="get">
            <input type="hidden" name="id" value="<?php echo e($info['semester_id']); ?>">
            <br>
            <table>
                <tr><td>年度<input type="number" name="year" value="<?php echo e($info['semester']['year']); ?>"></td><td>期數<input type="text" name="identity" value="<?php echo e($info['semester']['identity']); ?>"></td><td>描述<input type="text" name="desc" value="<?php echo e($info['semester']['desc']); ?>"></td></tr>

            </table>
            <button>修改</button>
        </form>

    </div>

   <div id="class1" style="">
            <p>課程管理</p>
            <p align="right"><button onclick="add_row(<?php echo e($info['class']->count()-1); ?>)">新增課程</button></p>
            <form action="/admin/classManagerAction" method="post" onsubmit="return checkdata()">
                <input type="hidden" name="id" value="<?php echo e($info['semester_id']); ?>">
                <table class="tb"  width="100%" align="center">
                    <tr><th>課程名稱</th><th>課程星期</th><th>課程日期</th><th>課程時間</th><th>授課教師</th><th>招生限制</th><th>名額/候補</th><th>課程大綱</th><th>刪除</th></tr>
                     <tbody id="sortable">
                        <?php if($info['class']->count()>0): ?>
                            <?php for($i=0;$i<=count($info['class'])-1;$i++): ?>

                                <tr id="tr[<?php echo e($i); ?>]"><td><input type="hidden" name=data[<?php echo e($i); ?>][classes_id] value="<?php echo e($info['class'][$i]['classes_id']); ?>" ><input type="text" name=data[<?php echo e($i); ?>][className] value="<?php echo e($info['class'][$i]['className']); ?>" required></td><td>週一<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="1" <?php echo e((substr_count($info['class'][$i]['week'],1)>0)?'checked':''); ?>>週二<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="2" <?php echo e((substr_count($info['class'][$i]['week'],'2')>0)?'checked':''); ?>>週三<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="3" <?php echo e((substr_count($info['class'][$i]['week'],'3')>0)?'checked':null); ?>><br>週四<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="4" <?php echo e((substr_count($info['class'][$i]['week'],'4')>0)?'checked':''); ?>>週五<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="5" <?php echo e((substr_count($info['class'][$i]['week'],'5')>0)?'checked':''); ?>>週六<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="6" <?php echo e((substr_count($info['class'][$i]['week'],'6')>0)? 'checked':''); ?>><br>週日<input type="checkbox" name=data[<?php echo e($i); ?>][date][] value="7" <?php echo e((substr_count($info['class'][$i]['week'],'7')>0)?'checked':''); ?>></td><td>開始日期<br><input type="date" name=data[<?php echo e($i); ?>][startdate] value="<?php echo e($info['class'][$i]['startdate']); ?>" required><br>結束日期<br><input type="date" name=data[<?php echo e($i); ?>][enddate] value="<?php echo e($info['class'][$i]['enddate']); ?>" required></td><td>開始時間<br><input type="time" name=data[<?php echo e($i); ?>][start] value="<?php echo e($info['class'][$i]['start']); ?>" required><br>結束時間<br><input type="time" name=data[<?php echo e($i); ?>][end] value="<?php echo e($info['class'][$i]['end']); ?>" required></td><td><input type="text" name=data[<?php echo e($i); ?>][teacher] value="<?php echo e($info['class'][$i]['teacher']); ?>" required></td><td><input type="text" name=data[<?php echo e($i); ?>][range] value="<?php echo e($info['class'][$i]['range']); ?>" required></td><td><input type="number" name=data[<?php echo e($i); ?>][count] value="<?php echo e($info['class'][$i]['count']); ?>" required> / <input type="number" name=data[<?php echo e($i); ?>][alternate] value="<?php echo e($info['class'][$i]['alternate']); ?>" required></td><td><input type="hidden" id=data[<?php echo e($i); ?>][abstract] name=data[<?php echo e($i); ?>][abstract] value="<?php echo e($info['class'][$i]['abstract']); ?>"><a onclick=getAbs('data[<?php echo e($i); ?>][abstract]')>編輯</a></td><td align="center"><a href="/admin/classManagerDelete?id=<?php echo e($info['class'][$i]['classes_id']); ?>&url=<?php echo e($info['c_id']); ?>" onclick="return confirm('確認要刪除嗎?')">X</a></td></tr>
                            
                            <?php endfor; ?>
                        <?php endif; ?>

                    </tbody>
                </table>
                <?php echo e(csrf_field()); ?>

                <button>提交</button>
            </form>
    </div>
    <div id="class2" style="display:none">
            <p>選課條件設置</p>
        <button onclick="add_condition(<?php echo e(count($info['condition'])-1); ?>)">+</button>
        <form action="/admin/classManagerConditionAction" method="post">
           <table class="tb" >
            <tbody id="cond">

                <input type="hidden" name="id" value="<?php echo e($info['semester_id']); ?>">
                <?php for($a=0;$a<=count($info['condition'])-1;$a++): ?>
                    <tr id="c_tr[<?php echo e($a); ?>]"><td>如果選擇
                        <input type="hidden" name=condition[<?php echo e($a); ?>][cid] value="<?php echo e($info['condition'][$a]['cid']); ?>">
                        <select name=condition[<?php echo e($a); ?>][classes_id]>
                            <?php for($i=0;$i<=count($info['class'])-1;$i++): ?>
                                <?php if($info['condition'][$a]->classes['classes_id']==$info['class'][$i]['classes_id']): ?>
                                    <option value="<?php echo e($info['condition'][$a]['classes_id']); ?>" selected><?php echo e($info['class'][$i]['className']); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($info['class'][$i]['classes_id']); ?>"><?php echo e($info['class'][$i]['className']); ?></option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>
                        ，則禁止選擇
                        <select name="condition[<?php echo e($a); ?>][key2]">
                            <?php for($i=0;$i<=count($info['class'])-1;$i++): ?>

                                    <option value="<?php echo e($info['class'][$i]['classes_id']); ?>" <?php echo e(($info['condition'][$a]['key2']==$info['class'][$i]['classes_id'])?'selected':''); ?>><?php echo e($info['class'][$i]['className']); ?></option>

                            <?php endfor; ?>
                        </select>
                    </td><td><a href="/admin/classManagerConditionDelete?cid=<?php echo e($info['condition'][$a]['cid']); ?>&url=<?php echo e($info['c_id']); ?>" onclick="return confirm('確認要刪除嗎?')">刪除</a></td></tr>
                <?php endfor; ?>



            </tbody>

           </table>
        <button>提交</button>
        <?php echo e(csrf_field()); ?>

        </form>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('dialog'); ?>
    <input type="hidden" id="object" value="">
    <textarea id="abs" class="ckeditor"></textarea>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>