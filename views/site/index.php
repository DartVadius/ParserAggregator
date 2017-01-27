<nav class="top-menu">
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="<?= \yii\helpers\Url::to(['category/category', 'link' => $category->id]); ?>"><?php echo $category->category_name ?></a></li>
        <?php endforeach ?>
    </ul>
</nav>
<div class="device">
    <div class="device__screen">
        <div id="menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: hidden">
            <svg width="1000px" height="1000px">
                <path id="pathA" d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                <path id="pathB" d="M 300 500 L 700 500"></path>
                <path id="pathC" d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
            </svg>
            <button id="menu-icon-trigger" class="menu-icon-trigger"></button>
        </div><!-- menu-icon-wrapper -->
        <div id="dummy" class="dummy">
            <div class="dummy__item"><a href="http://aggregator/site/signup">Регистрация</a></div>
            <div class="dummy__item"><a href="http://aggregator/site/login">Логин</a></div>

        </div><!-- /dummy -->
    </div><!-- /device-content -->
</div><!-- /device -->
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