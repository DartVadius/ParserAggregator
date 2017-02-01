<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $testForm = ActiveForm::begin([
    'options' => [        
        'id' => 'testForm',        
        ],    
    ]); ?>
<?= $testForm->field($preview, 'url')->label('URL для тестирования') ?>
<?= $testForm->field($preview, 'method')->label('Метод получения контента')->dropDownList(['cURL', 'Phantom']) ?>
<?= $testForm->field($preview, 'rules')->label('Правила для настройки парсера')->textarea(['rows' => 10, 'value' => '{"find":{"title":"","textShort":"","textFull":"","category":"","date":"","author":"","img":"","links":"","tags":""},"remove":"","prefix":""}']) ?>
<?= Html::button('Test', ['class' => 'btn btn-success', 'id' => 'test'])?>
<?php ActiveForm::end(); ?>
<div id="preview" class="well">
    <p><b>Правила</b></p>
    <div id="rule"></div>
    <div id="content">
        <p><b>Заголовок статьи</b></p>
        <p id="title"></p>
        <p><b>Текст статьи</b></p>
        <p id="text"></p>
        <div id="data"></div>
    </div>
</div>
<?php $this->registerJsFile('@web/js/test.js', ['depends' => 'yii\web\YiiAsset']) ?>