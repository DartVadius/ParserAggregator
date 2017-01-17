<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Sites;
use app\modules\parser\lib\PageParser;
use app\modules\parser\lib\PageParserPhantom;
use app\modules\parser\lib\PageParserCurl;
use phpQuery;

/**
 * ParserController
 *
 * @author DartVadius
 */
class ContentController extends Controller {

    public function actionRss() {

        $rules = Sites::find()->where([
                    'make_parsing' => '1'
                ])->all();
        foreach ($rules as $rule) {

            if ($rule->method_of_parsing == 'Phantom') {
                $document = new PageParserPhantom($rule->source);
            }
            if ($rule->method_of_parsing == 'cURL') {                
                $document = new PageParserCurl($rule->source);
            }
            $document = phpQuery::newDocument($document->getBody());
            $posts = $document->find('item');
            
            foreach ($posts as $post) {
                
            }            
        }
        return $this->render('index', ['info' => $posts]);
    }

}
