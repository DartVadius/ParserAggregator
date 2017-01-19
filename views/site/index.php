<?php if(count($model)): ?>
    <?php foreach ($model as $item): ?>
        
        <div class="well">
            <h3><?=$item->title ?></h3>
            <span class="small"><?php echo $item->date ?></span>            
            <div><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->link]); ?>">Перейти</a></div>
        </div>

    <?php endforeach ?>

<?php endif; ?>
