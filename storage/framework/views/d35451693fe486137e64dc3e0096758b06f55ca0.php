
<?php $__env->startSection('content'); ?>

<hr>
<h2>2017-10-11更新 & DEBUG說明</h2>
<br>
<p>1.新增後補名額功能。</p>
<p>2.發現Overview模型會將Primary key預設為id，這將與使用者身分證欄位吻合導致判斷為0，已增加該模型的新Primary Key。</p>
<p>3.修改部分敘述。</p>
<p>4.排除法選客條件限制功能頁面跳轉功能修正。</p>
<br>

<hr>
<h2>2017-10-06更新 & DEBUG說明</h2>
<br>
<p>1.Laravel Framework版本升級：5.1.46--->5.2.45。</p>
<p>2.移除ControllerServiceProvider服務。</p>
<p>3.Excel輸出現在改由使用loadView方法取代row方法。</p>
<p>4.統計下載功能現在直接在HEADER處點選。</p>
<p>5.資料庫中，semester_overview(View)欄位id更改為user_id。</p>
<p>6.修正表單重複提交問題。</p>

<div align="right"><a href="https://github.com/STORMSQ"><h3>Creator & Maintainer : STORMSQ</h3></a></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>