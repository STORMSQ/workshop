
<table>
<tr>
<?php foreach($title as $row): ?>
<td><?php echo e($row); ?></td>
<?php endforeach; ?>
</tr>
<?php foreach($cell as $row): ?>
<tr>
    <?php foreach($row as $data): ?>
        <td><?php echo e($data); ?></td>
    <?php endforeach; ?>
</tr>
<?php endforeach; ?>

</table>