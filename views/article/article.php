<?php if (!empty($article)) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $article->title ?></h3>            
        </div>
        <div class="panel-body">
            <?php foreach ($img as $image): ?>            
            <img src="<?php echo $image->link_to_image; ?>">

            <?php endforeach ?>
            <?php echo $article->text ?>
        </div>
        <div><a href="<?= \yii\helpers\Url::to(['site/index']); ?>">Вернуться</a></div>
    </div>
<?php endif; ?>