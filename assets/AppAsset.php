<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/demo.css',
        'css/component.css',
        'css/site.css',
        'css/colorbox.css',
    ];
    public $images = [
        'images/controls.png',
        'images/loading.gif',
    ];
    public $js = [
        'js/main.js',
        'js/bootstrap.min.js',
        'js/jquery-3.1.1.min.js',
        'js/jquery.colorbox.js',
        'js/segment.min.js',
        'js/ease.min.js',
        //'js/test.js',
    ];
    public $jsOptions = [
      'position' => \yii\web\View::POS_END,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
