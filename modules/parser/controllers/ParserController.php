<?php

namespace app\modules\parser\controllers;

use yii\web\Controller;
use app\modules\parser\models;

/**
 * Default controller for the `parser` module
 */
class ParserController extends Controller {
    
    public function actionIndex() {
         
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionTest() {
        $url = 'http://dnd.kr.ua/';
        $parser = new models\PageParserCurl($url);
        //$parser = new models\PageParserPhantom($url);
        //$parser = new models\ContentParser;
        return $this->render('test', ['info' => $parser]);
    }
    
    public function actionParse($method) {
        
    }

}
