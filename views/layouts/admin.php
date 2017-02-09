<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use mdm\admin\components\Helper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $menuItems = [
//        ['label' => 'Главная', 'url' => ['/admin/']],
        ['label' => 'Сайты', 'url' => ['/admin/sites/index']],
        ['label' => 'RSS', 'url' => ['/admin/post/index']],
        ['label' => 'Статьи', 'url' => ['/admin/articles/index']],
        ['label' => 'Категории', 'url' => ['/admin/category/']],
        ['label' => 'Парсер RSS', 'url' => ['../parser/parser/rss']],
        ['label' => 'Парсер Post', 'url' => ['../parser/parser/post']],
        ['label' => 'Превью', 'url' => ['../parser/parser/test']],
        ['label' => 'Пользователи', 'url' => ['/rbac/default/index']],
        Yii::$app->user->isGuest ? (
        ['label' => 'Войти', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ];

    NavBar::begin([
        'brandLabel' => 'Aggregator',
//        'brandUrl' => Yii::$app->homeUrl,
        'brandUrl' => '/admin/sites',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => Helper::filter($menuItems),

    ]);
    NavBar::end();
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
        <p class="pull-left">&copy; Agregator <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
