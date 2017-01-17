<?php

namespace app\modules\parser;

/**
 * parser module definition class
 */
class Module extends \yii\base\Module {
    public static $config;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\parser\controllers';
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        self::$config = require(__DIR__ . '/config/config.php');        
    }
    
}
