<?php

namespace app\modules\preview\controllers;

use Yii;
use yii\web\Controller;
use app\modules\preview\lib\PageParserCurl;
use app\modules\preview\lib\PageParser;
use app\modules\preview\lib\ContentParser;
use app\models\Sites;
use phpQuery;


class PreviewController extends Controller {

    public function actionTest() {
//        $model = new Sites();
//        $rule = [
//            'find' => [
//                'title' => '.entry-title',
//                'textShort' => '',
//                'textFull' => 'div.text',
//                'category' => '',
//                'date' => '',
//                'author' => '',
//                'img' => 'a.top_img_loader img',
//                'links' => '',
//                'tags' => '.tags a',
//            ],
//            'remove' => 'b::contains("Читайте также"), b::contains("Читайте на"), b::contains("Также читайте"), b::contains("Читайте:"), b::contains("Смотрите на"), b::contains("Смотрите также"), .tags span',
//            'prefix' => '',
//        ];
//        $ex = json_encode($rule);
//        $url = 'http://censor.net.ua/photo_news/424009/poroshenko_poprosil_glavu_krasnogo_kresta_maurera_o_sodeyistvii_v_osvobojdenii_ukrainskih_zalojnikov';
//        $parser = new PageParserCurl($url);
//        //$parser = new PageParserPhantom($url);
//        $data = new ContentParser($parser, $rule);
//        return $this->render('prw', ['info' => $data, 'json' => $ex]);
    }

    public function actionIndex() {
//        $model = new Sites();
//        $arr = $model['parsing_settings'];
//        $ex = json_encode($arr);
//        $url = 'http://fakty.ua/228590-savchenko-obecshayut-sotrudnichat-s-sbu-no-ne-otchityvatsya';
//        $post = new PageParser($url);
//        return $this->render('prw', ['info' => $post]);


        return $this->render('index', []);
    }

    public function actionPrw()
    {
//        return $this->render('prw', []);
        $url = '';
        $post = new PageParser($url);

        if (isset($_POST['sorce']) && isset($_POST['rules'])) {
            return $this->redirect(['prw', 'info' => $post]);
        } else {
           echo "Bad information";
        }
    }
    
//    private function strProcessing($str) {
//        $str = trim($str);
//        return mb_strtolower($str); //Приведение строки к нижнему регистру
//    }

}
