<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\controllers\GlobalController;
use app\models\Category;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <!--    --><?php
    //    NavBar::begin([
    //        'brandLabel' => 'Aggregator',
    //        'brandUrl' => Yii::$app->homeUrl,
    //        'options' => [
    //            'class' => 'navbar-inverse navbar-fixed-top',
    //        ],
    //    ]);

    ?>
    <header>
        <div class="top_header">
            <div class="device">
                <div class="device__screen">
                    <div id="menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: hidden">
                        <svg width="1000px" height="1000px">
                            <path id="pathA" d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                            <path id="pathB" d="M 300 500 L 700 500"></path>
                            <path id="pathC" d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
                        </svg>
                        <button id="menu-icon-trigger" class="menu-icon-trigger"></button>
                    </div><!-- menu-icon-wrapper -->
                    <div id="dummy" class="dummy d_none">
                        <div class="dummy__item">
                            <?php echo Nav::widget([
                                'items' => [
                                    ['label' => 'Главная', 'url' => [Yii::$app->homeUrl]],
                                ],

                            ]); ?>
                        </div>
                        <?php if(  Yii::$app->user->isGuest): ?>
                            <div class="dummy__item">
                                <?php echo Nav::widget([
                                    'items' => [
                                        ['label' => 'Регистрация', 'url' => ['/site/signup']]
                                    ],

                                ]); ?>
                            </div>
                        <?php endif; ?>
                        <div class="dummy__item">
                            <?php echo Nav::widget([
                                'items' => [
                                    Yii::$app->user->isGuest ? (
                                    ['label' => 'Логин', 'url' => ['/site/login']]
                                    ) : (
                                        '<li>'
                                        . Html::beginForm(['/site/logout'], 'post')
                                        . Html::submitButton(
                                            'Логаут (' . Yii::$app->user->identity->username . ')',
                                            ['class' => 'btn btn-link logout']
                                        )
                                        . Html::endForm()
                                        . '</li>'
                                    ),
                                ],
                            ]); ?>
                        </div>
                        <?php if( Yii::$app->user->getId() == 1): ?>
                            <div class="dummy__item">
                                <?php echo Nav::widget([
                                    'items' => [
                                        Yii::$app->user->getId() == 1 ? (['label' => 'Admin', 'url' => ['/admin/sites']]) :
                                            (['label' => false, 'url' => false]),
                                    ],

                                ]); ?>
                            </div>
                        <?php endif; ?>
                    </div><!-- /dummy -->
                </div><!-- /device-content -->
            </div><!-- /device -->
            <button class="navbar-toggle collapsed menu_btn" type="button" data-toggle="collapse" data-target="#top_menu" aria-expanded="false" aria-controls="collapseExample">

                <span class="glyphicon glyphicon-paperclip clr"></span>
            </button>
        </div>

        <nav class="top-menu collapse navbar-collapse" id="top_menu">
            <ul class="menu">
                <?php foreach (Category::find()->orderBy('id')->all() as $category): ?>
                    <li><a href="<?= \yii\helpers\Url::to(['category/category', 'link' => $category->id]); ?>"><?php echo $category->category_name ?></a></li>
                <?php endforeach ?>
            </ul>
        </nav>

    </header>
    <?php


    //    echo Nav::widget([
    //        'options' => ['class' => 'navbar-nav navbar-right'],
    //        'items' => [
    ////            ['label' => 'Gii', 'url' => ['/site/index.php?r=gii']],
    ////            ['label' => 'Посты', 'url' => ['/site/index']],
    ////            ['label' => 'Contact', 'url' => ['/site/contact']],
    //            ['label' => 'Регистрация', 'url' => ['/site/signup']],
    //            Yii::$app->user->isGuest ? (
    //                ['label' => 'Login', 'url' => ['/site/login']]
    //            ) : (
    //                '<li>'
    //                . Html::beginForm(['/site/logout'], 'post')
    //                . Html::submitButton(
    //                    'Logout (' . Yii::$app->user->identity->username . ')',
    //                    ['class' => 'btn btn-link logout']
    //                )
    //                . Html::endForm()
    //                . '</li>'
    //            ),
    //
    //            Yii::$app->user->getId() == 1 ? (['label' => 'Admin', 'url' => ['/admin/sites']]) :
    //                (['label' => false, 'url' => false]),
    //        ],
    //    ]);

    //    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Aggregator <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
