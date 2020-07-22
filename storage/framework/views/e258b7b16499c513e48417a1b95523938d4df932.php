
<?php $__env->startSection('css'); ?>
    table td{
    border-style:solid;
    border-width: 1px;
    }
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php if($info['repeat']==1): ?>
        您已提交過報名，不可重複提交，如欲修改，請使用<a href="/search">修改報名</a>功能
    <?php else: ?>
        <?php if($info['success']): ?>
            <p>報名資訊</p>
            <table >

                <tr><td>*姓名：</td><td><?php echo e($info['user']['username']); ?></td></tr>
                <tr><td>*生日：</td><td><?php echo e($info['user']['birthofdate']); ?></td></tr>
                <tr><td>*身份證號碼：</td><td><?php echo e($info['user']['id']); ?></td></tr>
                <tr><td>*住址：</td><td><?php echo e($info['user']['address']); ?></td></tr>
                <tr><td>*聯絡電話1：</td><td><?php echo e($info['user']['phone']); ?></td></tr>
                <tr><td>聯絡電話2：</td><td><?php echo e($info['user']['phone2']); ?></td></tr>
                <tr><td>*Email：</td><td><?php echo e($info['user']['email']); ?></td></tr>
            </table>

        <h2><b>以下課程報名成功</b></h2>
        <table width="90%" id="class">
            <th>課程名稱</th><th>課程時間</th><th>教師名稱</th><th>課程日期</th><th><font color="red">您的課程學號</font></th>
            <?php for($i=0;$i<=count($info['success'])-1;$i++): ?>

                    <tr><td><?php echo e($info['success'][$i]['className']); ?></td><td>每週 <?php echo e($info['success'][$i]['week']); ?><br><?php echo e($info['success'][$i]['start']); ?>-<?php echo e($info['success'][$i]['end']); ?></td><td><?php echo e($info['success'][$i]['teacher']); ?></td><td><?php echo e($info['success'][$i]['startdate']); ?><br><?php echo e($info['success'][$i]['enddate']); ?></td><td><center><font size="4" ><b><?php echo e($info['semester'][$i].'-'.str_pad($info['success'][$i]['sort'],2,"0",STR_PAD_LEFT).'-'); ?><?php echo e(($info['callnumber'][$i]<0)?'補'.abs($info['callnumber'][$i]):str_pad($info['callnumber'][$i],2,"0",STR_PAD_LEFT)); ?></b></font></center></td></tr>

            <?php endfor; ?>
        </table>
        <h2>本次報名序號：<font color="red"><b><?php echo e($info['form_id']); ?></b></font>(建議您記住這個序號，如有問題時，這個序號可以快速定位到您的報名資料)</h2>
        <p><h2>提醒您：請於<font color="red">三天內</font>前繳交保證金，逾期將取消報名課程</h2></p>
        <?php endif; ?>
        <?php if($info['fail']): ?>
           <font color="red"><b> 以下課程因已額滿報名失敗（也許是其他人在這段時間比您早提交報名）</b></font>
            <table width="90%" id="class">
            <?php for($i=0;$i<=count($info['fail'])-1;$i++): ?>

                    <tr style="background:#FF0000"><td><?php echo e($info['fail'][$i]['className']); ?></td><td>每週 <?php echo e($info['fail'][$i]['week']); ?><br><?php echo e($info['fail'][$i]['start']); ?>-<?php echo e($info['fail'][$i]['end']); ?></td><td><?php echo e($info['fail'][$i]['teacher']); ?></td><td><?php echo e($info['fail'][$i]['startdate']); ?><br><?php echo e($info['fail'][$i]['enddate']); ?></td></tr>
            <?php endfor; ?>
            </table>
        <?php endif; ?>

    <?php endif; ?>
    <center><a href="/"><button>離開</button></a></center>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>