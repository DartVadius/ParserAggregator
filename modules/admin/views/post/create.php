<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PostsRss */

$this->title = 'Create Posts Rss';
$this->params['breadcrumbs'][] = ['label' => 'Posts Rsses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-rss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
