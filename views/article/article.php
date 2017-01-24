<?php if (!empty($article)) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $article->title ?></h3>
        </div>
        <div class="panel-body">
            <img src="<?php echo $img[0]->link_to_image; ?>">
            <?php echo $article->text ?>
            <div class="img_block">

                <?php
                $i = 0;
                foreach ($img as $image):
                    if ($i !== 0) { ?>
                        <a class="group1" href="<?php echo $image->link_to_image; ?>" title="">
                        <img src="<?php echo $image->link_to_image; ?>">
                    </a>
                  <?php  }
                    $i++;
                    ?>



                <?php endforeach ?>

            </div>
            <br>
            <h3>А тут у нас теги</h3>
            <p><b>
                    <?php foreach ($tags as $tag): ?>
                        <?php echo $tag['tag'] . " | "; ?>
                    <?php endforeach ?>
                </b></p>
        </div>

        <div><a href="<?= \yii\helpers\Url::to(['/']); ?>">Вернуться</a></div>
    </div>
<?php endif; ?>