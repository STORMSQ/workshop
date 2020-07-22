
<?php echo $__env->make('alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>

<form action="/admin/check" method="post">
   輸入密碼： <input type="password" name="password">
    <button>登入</button>
    <?php echo e(csrf_field()); ?>

</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>