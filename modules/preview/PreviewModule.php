<?php

namespace app\modules\preview;

/**
 * preview module definition class
 */
class PreviewModule extends \yii\base\Module {
    public static $config;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\preview\controllers';
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        self::$config = require(__DIR__ . '/config/config.php');        
    }
    
}
