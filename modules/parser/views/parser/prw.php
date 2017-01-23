<?php
//
//use yii\helpers\Html;
//use yii\grid\GridView;
//
//
//
//$this->title = 'Sites';
//$this->params['breadcrumbs'][] = $this->title;
//?>
<div class="well">
    <form action="">
        <label for="sorce">url</label>
        <input type="text" name="sorce">
        <label for="rules">rules</label>
        <input type="textarea" name="rules">
        <select>
            <option>cURL</option>
            <option>Phantom</option>
        </select>
        <input type="submit">
    </form>
    <p><?php echo $json; ?></p>
    <pre><?= print_r($info, TRUE) ?></pre>
</div>