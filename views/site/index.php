<?php if (count($model)): ?>
    <?php foreach ($model as $item): ?>

        <div class="well">
            <h3><?= $item->title ?></h3>
            <span class="small"><?php echo $item->article_create_datetime ?></span>
        <?php $img = \app\models\Images::find()->select('link_to_image')->where(['article_id' => $item->article_id])->column(); ?>
            <img src="<?php echo $img[0]; ?>">
            <div><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->article_id]); ?>">Перейти</a></div>
        </div>

    <?php endforeach ?>

<?php endif; ?>
