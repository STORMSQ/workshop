
<?php $__env->startSection('content'); ?>
    <p>使用一般查詢</p>
    <table>
    <form action="/admin/confirm" method="get">
        <input type="hidden" name="type" value="1">
        <tr><td>姓名</td><td><input type="text" name="username" value=""></td></tr>
        <tr><td>身分證號碼</td><td><input type="text" name="id" value=""></td></tr>
        <tr><td colspan="2"><button>查詢</button></td></tr>
    </form>
    </table>
    <p>使用報名序號查詢</p>
    <table>
    <form action="/admin/confirm" method="get">
       <input type="hidden" name="type" value="2">
        <tr><td>報名序號</td><td><input type="text" name="form_id" value=""></td></tr>
        <tr><td colspan="2"><button>查詢</button></td></tr>
    </form>
    </table>
    <hr>
    <?php if($info['submit']==1): ?>
        <?php if(count($info['form_id'])>0): ?>
        <table>
            <?php foreach($info['form_id'] as $row): ?>
                <tr><td><a href="/admin/detail?form=<?php echo e($row); ?>"><?php echo e($row); ?></a></td></tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            查無資料
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>