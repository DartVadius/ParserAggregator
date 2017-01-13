<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="admin-default-index">

    <?php $form = ActiveForm::begin(); ?>

    <div class="buttons">
        <a onclick="$('#form').submit();" class="button">Сохранить</a>
    </div>
    <form action="" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
            <thead>
            <tr>
                <td class="left">Название</td>
                <td class="left">Источник</td>
                <td class="left">Метод</td>
                <td class="left">Правила</td>
                <td class="left">Вкл/Выкл</td>
                <td class="left">Тест</td>
                <td></td>
            </tr>
            </thead>
            <?php $module_row = 0; ?>

            <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
                <td class="left">
                    <input type="text" name="featured_module[<?php echo $module_row; ?>]" size="20" value="" size="1" />
                    
                </td>
                <td class="left">
                    <input type="text" name="featured_module[<?php echo $module_row; ?>]" size="20" value="" size="1" />
                </td>
                <td class="left">
                    <select name="featured_module[<?php echo $module_row; ?>]">
                        <option value="" selected="selected">option1</option>
                        <option value="" selected="selected">option2</option>
                    </select>
                </td>
                <td class="left">
                    <textarea name="Config[<?php echo $module_row; ?>]" id="" cols="20" rows="2"></textarea>
                </td>
                <td class="left" style="text-align: center">
                    <input type="checkbox" name="options" value=""><Br>
                </td>
                <td class="left">
                    <a onclick="$('#module-row').remove();" class="button">Удалить</a>
                </td>
                <td class="left">
                    <input type="text" name="featured_module[<?php echo $module_row; ?>]" size="20" value="" size="1" />
                    <a href="">Тестим</a>
                </td>
            </tr>
            </tbody>
                <?php $module_row++; ?>
            <tfoot>
            <tr>
                <td colspan="6"></td>
                <td class="left"><a onclick="addModule();" class="button">Добавить модуль</a></td>
            </tr>
            </tfoot>
        </table>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </form>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript"><!--
    var module_row = <?php echo $module_row; ?>;

    function addModule() {
        var html;

        html  = '<tbody id="module-row' + module_row + '">';
        html += '  <tr>';
        html += '       <td class="left"><input type="text" name="featured_module[<?php echo $module_row; ?>]" size="20" value="" size="1" /></td>';
        html += '       <td class="left"><textarea name="Config[<?php echo $module_row; ?>]" id="" cols="20" rows="2"></textarea></td> ';
        html += '       <td class="left"><select name="featured_module[<?php echo $module_row; ?>]"><option value="" selected="selected">option1</option><option value="" selected="selected">option2</option></select></td>';
        html += ' <td class="left"><select name="featured_module[<?php echo $module_row; ?>]"><option value="1" selected="selected">тип парсинга</option><option value="0">тип парсинга</option></select></td>';
        html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button">Удалить</a></td>';
        html += '  </tr>';
        html += '</tbody>';

        $('#module tfoot').before(html);

        module_row++;
    }
    //--></script>
