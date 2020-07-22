
<?php $__env->startSection('css'); ?>
    #class td{
    border-style:solid;
    border-width: 1px;
    }
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if($info['repeat']==1): ?>
        您已提交過，不可重複提交
    <?php else: ?>
   報名編號：<?php echo e($info['form_id']); ?>修改如下
   <p><b>以下追加報名成功：</b></p>
   <table width="90%" id="class">
        
        <tr><th>課程名稱</th><th>課程時間</th><th>教師名稱</th><th>課程起訖</th><th><font size="red">課程學號</font></th></tr>
       <?php for($i=0;$i<=count($info['success'])-1;$i++): ?>

           <tr><td><?php echo e($info['success'][$i]['className']); ?></td><td>每週 <?php echo e($info['success'][$i]['week']); ?><br><?php echo e($info['success'][$i]['start']); ?>-<?php echo e($info['success'][$i]['end']); ?></td><td><?php echo e($info['success'][$i]['teacher']); ?></td><td><?php echo e($info['success'][$i]['startdate']); ?><br><?php echo e($info['success'][$i]['enddate']); ?></td><td><font size="4" color="red"><b><?php echo e($info['semester'][$i].'-'.str_pad($info['success'][$i]['sort'],2,"0",STR_PAD_LEFT).'-'); ?><?php echo e(($info['callnumber'][$i]<0)?'補'.abs($info['callnumber'][$i]):str_pad($info['callnumber'][$i],2,"0",STR_PAD_LEFT)); ?></b></font></td></tr>

       <?php endfor; ?>
   </table>
   <?php if($info['fail']): ?>
       以下課程因已額滿報名失敗（也許是其他人在這段時間比您早提交報名）
       <table width="90%" id="class">
           <?php for($i=0;$i<=count($info['fail'])-1;$i++): ?>

               <tr><td><?php echo e($info['fail'][$i]['className']); ?></td><td>每週 <?php echo e($info['fail'][$i]['week']); ?><br><?php echo e($info['fail'][$i]['start']); ?>-<?php echo e($info['fail'][$i]['end']); ?></td><td><?php echo e($info['fail'][$i]['teacher']); ?></td><td><?php echo e($info['fail'][$i]['startdate']); ?><br><?php echo e($info['fail'][$i]['enddate']); ?></td></tr>
           <?php endfor; ?>
       </table>
   <?php endif; ?>
    <?php endif; ?>
    <center><button><a href="/search/detail?id=<?php echo e($info['form_id']); ?>">返回查詢報名</a></button></center>
    <center><button><a href="/">回到首頁</a></button></center>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>