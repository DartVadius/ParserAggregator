<?php

namespace app\modules\parser\controllers;

use yii\web\Controller;
use app\modules\parser\lib\PageParserCurl;
use app\modules\parser\lib\PageParser;
use app\modules\parser\lib\ContentParser;
use phpQuery;


class PreviewController extends Controller {

    public function actionTest() {
        $rule = [
            'find' => [
                'title' => '.entry-title',
                'textShort' => '',
                'textFull' => 'div.text',
                'category' => '',
                'date' => '',
                'author' => '',
                'img' => 'a.top_img_loader img',
                'links' => '',
                'tags' => '.tags a',
            ],
            'remove' => 'b::contains("Читайте также"), b::contains("Читайте на"), b::contains("Также читайте"), b::contains("Читайте:"), b::contains("Смотрите на"), b::contains("Смотрите также"), .tags span',
            'prefix' => '',
        ];
        $ex = json_encode($rule);
        $url = 'http://censor.net.ua/photo_news/424009/poroshenko_poprosil_glavu_krasnogo_kresta_maurera_o_sodeyistvii_v_osvobojdenii_ukrainskih_zalojnikov';
        $parser = new PageParserCurl($url);
        //$parser = new PageParserPhantom($url);
        $data = new ContentParser($parser, $rule);
        return $this->render('prw', ['info' => $data, 'json' => $ex]);
    }

    public function actionIndex() {
        $url = 'http://fakty.ua/228590-savchenko-obecshayut-sotrudnichat-s-sbu-no-ne-otchityvatsya';
        $post = new PageParser($url);
        return $this->render('prw', ['info' => $post]);
    }


    
//    private function strProcessing($str) {
//        $str = trim($str);
//        return mb_strtolower($str); //Приведение строки к нижнему регистру
//    }

}
