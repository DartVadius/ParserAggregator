
<div class="row">
    <div class="col-md-9" role="main">
        <?php if (count($model)): ?>
            <?php foreach ($model as $item): ?>
                <div class="well">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 ">
                            <div class="all_img">
                                <?php $img = \app\models\Images::find()->select('link_to_image')->where(['article_id' => $item->article_id])->column(); ?>
                                <?php if ($img != null) : ?>
                                    <img src="<?php echo $img[0]; ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3><?= $item->title ?></h3>
                            <span class="small"><?php echo $item->article_create_datetime ?></span> </br>
                            <p class="small"><?php echo $item->sourse; ?></p>
                            <div><a href="<?= \yii\helpers\Url::to(['article/view', 'link' => $item->article_id]); ?>">Перейти</a></div>
                        </div>
                    </div>
                </div>                
            <?php endforeach ?>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
        <?php endif; ?>
    </div>
    <div class="col-md-3" role="complementary">
        <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix-top">
            <ul class="nav bs-docs-sidenav">
                <li class="">
                    <a href="#glyphicons">Glyphicons</a>
                    <ul class="nav">
                        <li class="">
                            <a href="#glyphicons-glyphs">Available glyphs</a>
                        </li>
                        <li>
                            <a href="#glyphicons-how-to-use">How to use</a>
                        </li>
                        <li>
                            <a href="#glyphicons-examples">Examples</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#dropdowns">Dropdowns</a>
                    <ul class="nav">
                        <li>
                            <a href="#dropdowns-example">Example</a>
                        </li>
                        <li>
                            <a href="#dropdowns-alignment">Alignment</a>
                        </li>
                        <li>
                            <a href="#dropdowns-headers">Headers</a>
                        </li>
                        <li>
                            <a href="#dropdowns-divider">Divider</a>
                        </li>
                        <li>
                            <a href="#dropdowns-disabled">Disabled menu items</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#btn-groups">Button groups</a>
                    <ul class="nav">
                        <li>
                            <a href="#btn-groups-single">Basic example</a>
                        </li>
                        <li>
                            <a href="#btn-groups-toolbar">Button toolbar</a>
                        </li>
                        <li>
                            <a href="#btn-groups-sizing">Sizing</a>
                        </li>
                        <li>
                            <a href="#btn-groups-nested">Nesting</a>
                        </li>
                        <li>
                            <a href="#btn-groups-vertical">Vertical variation</a>
                        </li>
                        <li>
                            <a href="#btn-groups-justified">Justified button groups</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>