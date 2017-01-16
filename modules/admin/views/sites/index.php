<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SitesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sites-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sites', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'site_id',
            'name',
            'source',
            'method_of_parsing',
            'parsing_settings:ntext',
             'make_parsing',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
