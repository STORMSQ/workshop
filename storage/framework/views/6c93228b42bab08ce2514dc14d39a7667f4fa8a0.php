
<script src="<?php echo e(asset('/ckeditor/ckeditor.js')); ?>"></script>
<?php $__env->startSection('jquery'); ?>
    <?php if(Session::has('jumptopage')): ?>

        $(document.getElementById("<?php echo e(Session::get('jumptopage')); ?>")).click();



    <?php endif; ?>
<?php $__env->stopSection(); ?>
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
<?php echo $__env->make('alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
    <button id="fun1" onclick=change_f('fun1')>研習班規章</button>  <button id="fun2" onclick=change_f('fun2')>報名說明</button>   <button id="fun3" onclick=change_f('fun3')>管理員密碼</button>
<div id="rulepage">
    <h2>研習班規章</h2>
    <form action="/admin/option/rule" method="post">
        <textarea class="ckeditor" name="rule">
            <?php echo e($info['rule']['value']); ?>

        </textarea>
        <?php echo e(csrf_field()); ?>

            <button>修改</button>
        </form>
</div>
<div id="notepage" style="display:none">
    <h2>報名說明</h2>
    <form action="/admin/option/note" method="post">
        <textarea class="ckeditor" name="note">
            <?php echo e($info['note']['value']); ?>

        </textarea>
        <button>修改</button>
        <?php echo e(csrf_field()); ?>

    </form>

</div>
    <div id="adminpage" style="display:none">
        <h2>管理員修改密碼</h2>
        <form action="/admin/option/admin" method="post">
        請輸入密碼：　　<input type="password" name="password1" value=""><br>
        請再次輸入密碼：<input type="password" name="password2" value="">
            <button>修改</button>
            <?php echo e(csrf_field()); ?>

        </form>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>