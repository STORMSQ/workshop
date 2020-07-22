
<script src="<?php echo e(asset('/ckeditor/ckeditor.js')); ?>"></script>
<?php echo $__env->make('alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('css'); ?>
    #class td{
    border-style:solid;
    border-width: 1px;
    padding: 0px;

    }
<?php $__env->stopSection(); ?>
<?php $__env->startSection('dialogcontent'); ?>
autoOpen:false,
show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "blind",
        duration: 1000
      },
height: 600,
width: 1000,
modal: true,
      buttons: {
        "OK": function() {
          $("#abscontent").html(null);
          $( this ).dialog( "close" );
        }
      }
<?php $__env->stopSection(); ?>
<script language="javascript">
var abstracts = function(id){
    $.ajax({
    url: '/ajax/abstracts',
    dataType: 'json',
    type: 'get',
    data: {
        id: id
    },
    success: function(data){
       // CKEDITOR.instances.abscontent.setData(data[0]);
       $("#abscontent").html(data[0]);
    },

    error: function (data){
        alert(status + xhr);
    }
    });
    $("#dialog").dialog("open");

}
</script>
<?php $__env->startSection('content'); ?>
        <center>現在系統時間：<?php echo e(date('Y-m-d H:i:s')); ?></center>
        <?php if($info['semester']!='none'): ?>
            <center><p><font color="red"><b>開放報名時間：<?php echo e($info['semester']['start']); ?>至<?php echo e($info['semester']['end']); ?></b></font></p></center>
            <center><a href="/signup"><button style="width:300px;height:150px;font-size:26px;">網路報名</button></a> <a href="/search"><button style="width:300px;height:150px;font-size:26px;">報名查詢/修改</button></a></center>
            <hr>
            <center><h3>本期課程一覽</h3></center>
            <table width="100%" id="class" cellspacing="0">
                <tr><th>編號</th><th>課程名稱</th><th>時間</th><th>教師</th><th>課程日期</th><th>招生對象</th><th>課程大綱</th></tr>
                <?php for($i=0;$i<=count($info['class'])-1;$i++): ?>

                    <tr align="center"><td><?php echo e($info['semester']['year'].$info['semester']['identity'].'-'.str_pad($info['class'][$i]['sort'],2,"0",STR_PAD_LEFT)); ?></td><td ><a><?php echo e($info['class'][$i]['className']); ?></a></td><td>每週 <?php echo e($info['class'][$i]['week']); ?><br><?php echo e($info['class'][$i]['start']); ?>-<?php echo e($info['class'][$i]['end']); ?></td><td><?php echo e($info['class'][$i]['teacher']); ?></td><td><?php echo e($info['class'][$i]['startdate']); ?><br><?php echo e($info['class'][$i]['enddate']); ?></td><td><?php echo e($info['class'][$i]['range']); ?></td><td><a onclick=abstracts("<?php echo e($info['class'][$i]['id']); ?>")>查看</a></td>

                    </tr>

                <?php endfor; ?>

            </table>
        <?php else: ?>
            <center><h3>目前無任何研習班開放報名</h3></center>
        <?php endif; ?>
    

<?php $__env->stopSection(); ?>
<?php $__env->startSection('dialog'); ?>

<span id="abscontent" >
</span>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>