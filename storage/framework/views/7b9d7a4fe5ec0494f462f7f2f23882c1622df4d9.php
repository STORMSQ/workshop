
   
    <?php $__env->startSection('navi'); ?>
            <li>
                <a href="<?php echo e(route('project_home')); ?>">報名管理首頁</a> <span class="divider">/</span>	
            </li>

            <!--<li class="active">欣榮研習班報名系統</li>-->
        
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
    <a class="btn btn-success" href="<?php echo e(route('project_add')); ?>"><i class="icon-plus icon-white"></i> 新增</a>
    
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"></div>
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>年</th>
                            <th>期</th>
                            <th>名稱</th>
                            <th>開放時間</th>
                            <th>繳費時間</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>