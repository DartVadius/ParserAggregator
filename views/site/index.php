<?php if (count($model)): ?>
    <nav class="top-menu">
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href=""><?php echo $category->category_name ?></a></li>
            <?php endforeach ?>
        </ul>
    </nav>

    <?php foreach ($model as $item): ?>

        <div class="well">
            <div class="row">
                <div class="col-md-4 col-sm-4 ">
                    <?php $img = \app\models\Images::find()->select('link_to_image')->where(['article_id' => $item->article_id])->column(); ?>
                    <img src="<?php 
                    if (!empty($img)) {
                        echo $img[0];
                    }
                    ?>"> </br>

                </div>
                <div class="col-md-8 col-sm-8">
                    <h3><?= $item->title ?></h3>
                    <span class="small"><?php echo $item->article_create_datetime ?></span> </br>
                    <p class="small">Источник: <?php echo $item->sourse; ?></p>
                    <div><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->article_id]); ?>">Перейти</a></div>
                </div>
            </div>
        </div>

    <?php endforeach ?>
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>

<?php endif; ?>

