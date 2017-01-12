<div class="admin-default-index">
    <div class="buttons">
        <a onclick="$('#form').submit();" class="button">Сохранить</a>
    </div>
    <form action="" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
            <thead>
            <tr>
                <td class="left">Site</td>
                <td class="left">Config</td>
                <td class="left">Rules</td>
                <td class="left">qwerty</td>
                <td class="left">qwerty1</td>
                <td></td>
            </tr>
            </thead>
            <?php $module_row = 0; ?>

            <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
                <td class="left">
                    <input type="text" name="featured_module[<?php echo $module_row; ?>]" size="20" value="https://lifehacker.ru/" size="1" />
                </td>
                <td class="left">
                    <textarea name="Config[<?php echo $module_row; ?>]" id="" cols="20" rows="2">Config</textarea>
                </td>
                <td class="left">
                    <select name="featured_module[<?php echo $module_row; ?>]">
                        <option value="" selected="selected">option1</option>
                        <option value="" selected="selected">option2</option>
                    </select>
                </td>
                <td class="left">
                    <select name="featured_module[<?php echo $module_row; ?>]">
                        <option value="1" selected="selected">тип парсинга</option>
                        <option value="0">тип парсинга</option>
                    </select>
                </td>
                <td class="left">
                    <a onclick="$('#module-row').remove();" class="button">Удалить</a>
                </td>
            </tr>
            </tbody>
                <?php $module_row++; ?>
            <tfoot>
            <tr>
                <td colspan="5"></td>
                <td class="left"><a onclick="addModule();" class="button">Добавить модуль</a></td>
            </tr>
            </tfoot>
        </table>
    </form>
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
