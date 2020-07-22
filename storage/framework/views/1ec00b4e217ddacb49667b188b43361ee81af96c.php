
<style>
    input {
        padding: 10px;
        border: solid 1px #dcdcdc;
        transition: box-shadow 0.3s, border 0.3s;
    }
</style>
<script type="text/javascript" >
    function adjust_textarea(h) {
        h.style.height = "20px";
        h.style.height = (h.scrollHeight)+"px";
    }
</script>
<?php $__env->startSection('content'); ?>
    <p>您的位置：報名查詢</p>


       <h2>查詢已報名過的課程，您可以使用以下兩種方式查詢</h2>
        <br>
       <form action="/search/detail" method="get">
    <table style="border-style:solid; border-width:1px;">
        <tr><th colspan="2"><p>1.輸入報名序號</p></th></tr>
        <tr><td>　輸入報名序號</td><td><input type="number" name="id" required></td></tr>
        <tr><td colspan="2"><button>查詢</button></td></tr>
    </table>
       </form>

    <form action="/search" method="get">
        <table style="border-style:solid; border-width:1px;">
            <tr><th colspan="2"><P>2.輸入姓名與身份證號碼</P></th></tr>
            <tr><td>輸入姓名</td><td><input type="text" name="username" required></td></tr>
            <tr><td>輸入身份證號碼</td><td><input type="text" name="id" required></td></tr>
            <tr><td colspan="2"><button>查詢</button></td></tr>
        </table>

    </form>

    <?php if($info['result']==1): ?>
        <?php if(count($info['id'])>0): ?>
            結果(直接點擊數字進入修改)
        <table style="border-style:solid; border-width:1px;">

            <?php foreach($info['id'] as $row): ?>
                <tr><td><a href="/search/detail?id=<?php echo e($row); ?>"><?php echo e($row); ?></a></td></tr>
            <?php endforeach; ?>

        </table>
        <?php else: ?>
            <p>查無結果</p>
        <?php endif; ?>
    <?php endif; ?>
       <center><a href="/"><button>離開</button></a></center>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>