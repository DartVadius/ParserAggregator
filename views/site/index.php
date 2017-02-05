<div class="row">
    <div class="col-md-9 col-sm-9" role="main">
        <?php if (count($model)): ?>
            <?php foreach ($model as $item): ?>
                <div class="well">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="all_img">
                                <?php $img = \app\models\Images::find()->select('link_to_image')->where(['article_id' => $item->article_id])->column(); ?>
                                <?php if ($img != null) : ?>
                                    <img class="img-responsive" src="<?php echo $img[0]; ?>">
                                <?php else: ?>
                                    <img class="img-responsive" src="../web/images/Darth_vadar.jpg">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->article_id]); ?>"><?= $item->title ?></a></h3>
                            <span class="small">Дата: <?php echo $item->article_create_datetime ?></span>
                            <p class="small">Источник: <?php echo $item->sourse; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
        <?php endif; ?>
    </div>
    <div class="col-md-3 col-sm-3" role="complementary">
        <nav class="bs-docs-sidebar hidden-print hidden-xs affix-top">
            <ul class="nav bs-docs-sidenav">
                <?php if (!empty($_SESSION['__id'])): ?>
                    <h4>История тегов</h4>
                <?php else: ?>
                    <h4>Гео Новости</h4>
                <?php endif; ?>
                <?php foreach ($sides_news as $news): ?>
                    <li><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $news['article_id']]); ?>"><?= $news['title'] ?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>
    </div>
</div>
<?php \yii\helpers\Url::remember(); ?>
