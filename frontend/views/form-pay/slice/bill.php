<?php

?>
<div style="display: flex; justify-content: space-between; flex-wrap:wrap;">
<?php foreach ($fields as $field=>$value) :?>
    <?php if (!empty($value) && $field != 'id' && $field != 'user_id') :?>
        <div style="width: 49%;" class="js-remove-bill">
            <?= $model->getAttributeLabel($field)?>: <?=$value?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
</div>