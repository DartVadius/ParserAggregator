<?php if (count($model)): ?>
    <?php foreach ($model as $item): ?>

        <div class="well">
            <div class="row">
                <div class="col-md-4 col-sm-4 ">
                    <div class="all_img">
                        <?php $img = \app\models\Images::find()->select('link_to_image')->where(['article_id' => $item->article_id])->column(); ?>
                        <?php if ($img != null) : ?>
                            <img src="<?php echo $img[0]; ?>">
                        <?php endif; ?>
                    </div>

                </div>
                <div class="col-md-8 col-sm-8">
                    <h3><?= $item->title ?></h3>
                    <span class="small"><?php echo $item->article_create_datetime ?></span> </br>

                    <div><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->article_id]); ?>">Перейти</a></div>
                </div>
            </div>
        </div>

    <?php endforeach ?>
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>

<?php endif; ?>

