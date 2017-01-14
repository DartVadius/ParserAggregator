<?php

namespace app\modules\parser;

/**
 * parser module definition class
 */
class ParserModule extends \yii\base\Module {
    public static $configPageParser;
    public static $configContentParser;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\parser\controllers';    
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        self::$configPageParser = require(__DIR__ . '/config/configPageParser.php');
        self::$configContentParser = require(__DIR__ . '/config/configContentParser.php');
    }
    
}
