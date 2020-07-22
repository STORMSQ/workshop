
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
<?php $__env->startSection('jquery'); ?>
        $('#all_check').click(function(){
            if($('#all_check').prop('checked')){
                $('input[name="confirm[]"]').each(function(){
                    $(this).prop('checked',true);
                });
            }else{
                $('input[name="confirm[]"]').each(function(){
                    $(this).prop('checked',false);
                 });
            }
        });
        $( "#accordion" ).accordion({
            heightStyle: "content"
        });

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if($info['action']==1 ): ?>
        <p>報名編號：<?php echo e($info['form_id']); ?><input type="hidden" name="form_id" value="<?php echo e($info['form_id']); ?>"></p>
        <table>
            <tr><td>姓名</td><td><?php echo e($info['user'][0][0]); ?></td></tr>
            <tr><td>生日</td><td><?php echo e($info['user'][0][1]); ?></td></tr>
            <tr><td>身份證號</td><td><?php echo e($info['user'][0][2]); ?></td></tr>
            <tr><td>聯絡住址</td><td><?php echo e($info['user'][0][6]); ?></td></tr>
            <tr><td>聯絡電話1</td><td><?php echo e($info['user'][0][3]); ?></td></tr>
            <tr><td>聯絡電話2</td><td><?php echo e($info['user'][0][4]); ?></td></tr>
            <tr><td>Email</td><td><?php echo e($info['user'][0][5]); ?></td></tr>
        </table>
        <div id="accordion">

        <h3>報名確認</h3>
        <div>
        <form action="/admin/confirm/update" method="get">
        <input type="hidden" name="form_id" value="<?php echo e($info['form_id']); ?>">
            <input type="hidden" name="username" value="<?php echo e($info['user'][0][0]); ?>">
            <input type="hidden" name="birthofdate" value="<?php echo e($info['user'][0][1]); ?>">
            <input type="hidden" name="id" value="<?php echo e($info['user'][0][2]); ?>">
            <input type="hidden" name="address" value="<?php echo e($info['user'][0][6]); ?>">
            <input type="hidden" name="phone" value="<?php echo e($info['user'][0][3]); ?>">
            <input type="hidden" name="phone2" value="<?php echo e($info['user'][0][4]); ?>">
            <input type="hidden" name="mail" value="<?php echo e($info['user'][0][5]); ?>">

        <table width="50%" id="class">
            <tr><th>刪除報名</th><th>課程</th><th>序號</th></tr>
            <?php if(count($info['confirmed'])>0): ?>
                <?php for($i=0;$i<=count($info['confirmed'])-1;$i++): ?>
                    <tr  align="center"><td><a href="/admin/delete?form_id=<?php echo e($info['form_id']); ?>&classes_id=<?php echo e($info['confirmed'][$i]['classes_id']); ?>">X</a></td><td ><a><?php echo e($info['confirmed'][$i]['className']); ?></a></td><td><?php echo e($info['confirmed'][$i]['callnumber']); ?></td></tr>
                <?php endfor; ?>
            <?php endif; ?>
            <?php if(count($info['standby'])>0): ?>
                <?php for($i=0;$i<=count($info['standby'])-1;$i++): ?>
                    <tr  align="center"><td><a href="/admin/delete?form_id=<?php echo e($info['form_id']); ?>&classes_id=<?php echo e($info['standby'][$i]['classes_id']); ?>">X</a></td><td ><a><?php echo e($info['standby'][$i]['className']); ?></a></td></tr>
                <?php endfor; ?>
            <?php endif; ?>
        </table>
        <center><button>確認</button></center>

        </form>
    
    </div>
            <h3>強制報名</h3>
            <div>
                <form action="/admin/confirm/force" method="get">
                    <input type="hidden" name="url" value="<?php echo e($info['url']); ?>">
                    <input type="hidden" name="form_id" value="<?php echo e($info['form_id']); ?>">
                    <input type="hidden" name="username" value="<?php echo e($info['user'][0][0]); ?>">
                    <input type="hidden" name="birthofdate" value="<?php echo e($info['user'][0][1]); ?>">
                    <input type="hidden" name="id" value="<?php echo e($info['user'][0][2]); ?>">
                    <input type="hidden" name="address" value="<?php echo e($info['user'][0][6]); ?>">
                    <input type="hidden" name="phone" value="<?php echo e($info['user'][0][3]); ?>">
                    <input type="hidden" name="phone2" value="<?php echo e($info['user'][0][4]); ?>">
                    <input type="hidden" name="mail" value="<?php echo e($info['user'][0][5]); ?>">
                    <h2>強制報名</h2>
                    <p>給這位報名者無視任何規則加報科目</p>
                    <table>
                        <?php foreach($info['force'] as $row): ?>
                            <tr><td><?php echo e($row['className']); ?></td><td><input type="checkbox" name="f_add[]" value="<?php echo e($row['classes_id']); ?>"></td></tr>
                        <?php endforeach; ?>
                    </table>
                    <button>確認</button>
                </form>
            </div>
    <?php else: ?>
      <p>查無資料</p>
    <?php endif; ?>        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>