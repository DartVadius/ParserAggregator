<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sites */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sites-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'method_of_parsing')->dropDownList([ 'Phantom' => 'Phantom', 'cURL' => 'CURL', ], ['prompt' => '']) ?>
<div class="settings">    
    <?= $form->field($model, 'parsing_settings'.'[title]')->textInput(['maxlength' => true])->label('title') ?>
    <?= $form->field($model, 'parsing_settings'.'[textShort]')->textInput(['maxlength' => true])->label('textShort') ?>
    <?= $form->field($model, 'parsing_settings'.'[textFull]')->textInput(['maxlength' => true])->label('textFull') ?>
    <?= $form->field($model, 'parsing_settings'.'[category]')->textInput(['maxlength' => true])->label('category') ?>
    <?= $form->field($model, 'parsing_settings'.'[date]')->textInput(['maxlength' => true])->label('date') ?>
    <?= $form->field($model, 'parsing_settings'.'[author]')->textInput(['maxlength' => true])->label('author') ?>
    <?= $form->field($model, 'parsing_settings'.'[img]')->textInput(['maxlength' => true])->label('img') ?>
    <?= $form->field($model, 'parsing_settings'.'[links]')->textInput(['maxlength' => true])->label('links') ?>
    <?= $form->field($model, 'parsing_settings'.'[tags]')->textInput(['maxlength' => true])->label('tags') ?>
    <?= $form->field($model, 'parsing_settings'.'[remove]')->textInput(['maxlength' => true])->label('remove') ?>
    <?= $form->field($model, 'parsing_settings'.'[prefix]')->textInput(['maxlength' => true])->label('prefix') ?>    
</div>

    <?= $form->field($model, 'make_parsing')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
