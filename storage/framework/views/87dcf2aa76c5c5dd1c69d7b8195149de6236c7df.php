<div class="flash-message">
    <?php foreach(['danger', 'warning', 'success', 'info'] as $msg): ?>
        <?php if(Session::has('alert-' . $msg)): ?>
            <script type="text/javascript">
                alert('<?php echo e(Session::get('alert-' . $msg)); ?>');
            </script>
        <?php endif; ?>
    <?php endforeach; ?>
</div>