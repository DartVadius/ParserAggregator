<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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


<div class="well">
    <form action="" method="post">
        <label for="sorce">url</label>
        <input type="text" name="sorce">
        <label for="rules">rules</label>
        <textarea name="rules"cols="30" rows="10"></textarea>
        <select>
            <option>cURL</option>
            <option>Phantom</option>
        </select>
        <input type="submit">
    </form>
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
