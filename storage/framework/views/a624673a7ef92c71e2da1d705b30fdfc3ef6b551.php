
<?php $__env->startSection('css'); ?>
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


<?php $__env->stopSection(); ?>
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
<?php $__env->startSection('content'); ?>
<?php if($info['action']==1): ?>

    <p>修改報名課程</p>
    <p>可直接勾選想要追加報名的課程</p>
    <form action="/signup/update" method="post">
        <p>報名編號：<?php echo e($info['form_id']); ?><input type="hidden" name="form_id" value="<?php echo e($info['form_id']); ?>"></p>
    <table>
        <td><td>姓名</td><td><input type="text" name="username" value="<?php echo e($info['user'][0][0]); ?>"></td></tr>
        <td><td>生日</td><td><input type="date" name="birthofdate" value="<?php echo e($info['user'][0][1]); ?>"></td></tr>
        <td><td>身份證號</td><td><?php echo e($info['user'][0][2]); ?><input type="hidden" name="id" value="<?php echo e($info['user'][0][2]); ?>"></td></tr>
        <td><td>聯絡住址</td><td><input type="text" name="address" value="<?php echo e($info['user'][0][6]); ?>"></td></tr>
        <td><td>聯絡電話1</td><td><input type="text" name="phone" value="<?php echo e($info['user'][0][3]); ?>"></td></tr>
        <td><td>聯絡電話2</td><td><input type="text" name="phone2" value="<?php echo e($info['user'][0][4]); ?>"></td></tr>
        <td><td>Email</td><td><input type="email" name="mail" value="<?php echo e($info['user'][0][5]); ?>"></td></tr>


    </table>
    <table width="100%" id="class">
        <tr><th>課程名稱</th><th>時間</th><th>教師</th><th>課程日期</th><th>已報名人數/開放人數/候補人數</th><th>選取報名/狀態</th></tr>

        <?php for($i=0;$i<=count($info['class'])-1;$i++): ?>

            <?php if(in_array($info['class'][$i]['id'],$info['condition'])): ?>
                <tr style="background-color:gray"  align="center"><td id="tr<?php echo e($info['class'][$i]['id']); ?>"><a><?php echo e($info['class'][$i]['className']); ?></a></td><td>每週 <?php echo e($info['class'][$i]['week']); ?><br><?php echo e($info['class'][$i]['start']); ?>-<?php echo e($info['class'][$i]['end']); ?></td><td><?php echo e($info['class'][$i]['teacher']); ?></td><td><?php echo e($info['class'][$i]['startdate']); ?><br><?php echo e($info['class'][$i]['enddate']); ?></td><td><a id="count<?php echo e($info['class'][$i]['id']); ?>"><?php echo e($info['class'][$i]['full']); ?></a></td><td width="15%">
                                檢測到身份不符</td>
                </tr>
            <?php elseif(in_array($info['class'][$i]['id'],$info['arr'])): ?>

            <tr style="background-color:gray" align="center"><td ><a><?php echo e($info['class'][$i]['className']); ?></a></td><td>每週 <?php echo e($info['class'][$i]['week']); ?><br><?php echo e($info['class'][$i]['start']); ?>-<?php echo e($info['class'][$i]['end']); ?></td><td><?php echo e($info['class'][$i]['teacher']); ?></td><td><?php echo e($info['class'][$i]['startdate']); ?><br><?php echo e($info['class'][$i]['enddate']); ?></td><td><a id="count<?php echo e($info['class'][$i]['id']); ?>"><?php echo e($info['class'][$i]['full']); ?></a></td><td width="15%">
                  已報名無法取消<br><?php echo e($info['semester']); ?>-<?php echo e(str_pad($info['sort'][array_search($info['class'][$i]['id'],$info['arr'])],2,"0",STR_PAD_LEFT)); ?>-<?php echo e(($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber']<0)?'補'.abs($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber']):str_pad($info['data'][array_search($info['class'][$i]['id'],$info['arr'])]['callnumber'],2,"0",STR_PAD_LEFT)); ?></td>

            </tr>
            <?php elseif(in_array($info['class'][$i]['id'],$info['has'])): ?>
                <tr style="background-color:gray" align="center"><td ><a><?php echo e($info['class'][$i]['className']); ?></a></td><td>每週 <?php echo e($info['class'][$i]['week']); ?><br><?php echo e($info['class'][$i]['start']); ?>-<?php echo e($info['class'][$i]['end']); ?></td><td><?php echo e($info['class'][$i]['teacher']); ?></td><td><?php echo e($info['class'][$i]['startdate']); ?><br><?php echo e($info['class'][$i]['enddate']); ?></td><td><a id="count<?php echo e($info['class'][$i]['id']); ?>"><?php echo e($info['class'][$i]['full']); ?></a></td><td width="15%">
                        衝堂</td>

                </tr>
            <?php else: ?>
                <tr style="<?php echo e(($info['class'][$i]['full']=='額滿')?'background-color:gray':''); ?>" <?php echo e(($info['class'][$i]['full']!='額滿')?'id=tr'.$info['class'][$i]['id']:''); ?> align="center"><td ><a><?php echo e($info['class'][$i]['className']); ?></a></td><td>每週 <?php echo e($info['class'][$i]['week']); ?><br><?php echo e($info['class'][$i]['start']); ?>-<?php echo e($info['class'][$i]['end']); ?></td><td><?php echo e($info['class'][$i]['teacher']); ?></td><td><?php echo e($info['class'][$i]['startdate']); ?><br><?php echo e($info['class'][$i]['enddate']); ?></td><td><a id="count<?php echo e($info['class'][$i]['id']); ?>"><?php echo e($info['class'][$i]['full']); ?></a></td><td width="15%"><label for="box<?php echo e($info['class'][$i]['id']); ?>">
                    <?php if($info['class'][$i]['full']!='額滿'): ?>
                        <input type="checkbox" id="box<?php echo e($info['class'][$i]['id']); ?>" name="signup[]" value="<?php echo e($info['class'][$i]['id']); ?>" onchange="choose()"></label><a id="info<?php echo e($info['class'][$i]['id']); ?>"></a></td>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>

        <?php endfor; ?>
    </table>
        <br><center><button id="submit" style="display:none">修改報名</button></center>
        <?php echo e(csrf_field()); ?>

    </table>
    </form>
<?php else: ?>
    <p>無此頁面</p>

<?php endif; ?>
<center><a href="/"><button>離開</button></a></center>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>