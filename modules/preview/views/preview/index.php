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
<?php
if(isset($_POST)){
    echo $json . "</br>";

    echo "<pre>";
        print_r($info, TRUE);
    echo "</pre>";
}
//
//
//?>