<?php if (!empty($article)) : ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><?php echo $article->title ?></h2>
        </div>
        <div class="panel-body">
            <?php  if($img != null) : ?>
                <img src="<?php echo $img[0]->link_to_image; ?>">
            <?php endif; ?>

            <?php echo $article->text ?>
            <div class="img_block">
                <?php
                $i = 0;
                foreach ($img as $image):
                    if ($i !== 0) {
                        ?>
                        <a class="group1" href="<?php echo $image->link_to_image; ?>" title="">
                            <img src="<?php echo $image->link_to_image; ?>">
                        </a>
                        <?php
                    }
                    $i++;
                    ?>
                <?php endforeach ?>
            </div>
            <br>
            <div class="article_tags">               
                    <?php foreach ($tags as $tag): ?>
                <b><a href="<?= \yii\helpers\Url::to(['site/tag', 'link' => $tag['tag_id']]); ?>"><?php echo $tag['tag']; ?></a></b>
                    <?php endforeach ?>

            </div>

        </div>
        
        <div><a href="<?= \yii\helpers\Url::previous(); ?>">Вернуться</a></div>
    </div>
<?php endif; ?>