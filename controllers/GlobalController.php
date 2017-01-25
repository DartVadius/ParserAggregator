<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\modules\parser\lib\GeoPlugin;
use Stichoza\GoogleTranslate\TranslateClient;
use app\models\Articles;
use app\models\Tags;
use app\models\ArticlesToTags;

/**
 * GlobalController
 *
 * @author DartVadius
 */
class GlobalController extends Controller {

    protected function geoLock($ip = null) {
        if ($ip == NULL) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $geoplugin = new geoPlugin();
        $geoplugin->locate($ip);
        $result['city'] = $geoplugin->city;
        $result['region'] = $geoplugin->region;
        $result['country'] = $geoplugin->countryName;
        $result['country'] = $this->translate($result['country']);
        $result['country'] = $this->strProcessing($result['country']);
        $result['city'] = $this->translate($result['city']);
        $result['city'] = $this->strProcessing($result['city']);
        $result['region'] = $this->translate($result['region']);
        $result['region'] = $this->strProcessing($result['region']);

        //$radius = 10;        
        //$result['nearby'] = $geoplugin->nearby(10);
        return $result;
    }

    protected function translate($text, $source = 'en', $target = 'ru') {
        $translator = new TranslateClient($source, $target);
        return $translator->translate($text);
    }

    protected function strProcessing($str) {
        $str = trim($str);
        return mb_strtolower($str);
    }

    protected function findArtByGeo($geo) {
        //$city = $geo['city'];
        //$region = $geo['country'];        
        //$region = 'эстония';
//        $qery = new Query();
//        echo ((new Query())
//                        ->select(['tag_id'])
//                        ->from('Tags')
//                        ->where([
//                            'tag' => "$region",
//                        ])->one());
        
        return (new \yii\db\Query())
                        ->select(['Articles.*', 'Tags.tag', 'Tags.tag_id'])
                        ->from('Tags')
                        ->leftJoin('Articles_To_Tags', 'Tags.tag_id = Articles_To_Tags.tag_id')
                        ->leftJoin('Articles', 'Articles_To_Tags.article_id = Articles.article_id')
                        ->where([
                            'like', 'tag', $geo
                        ])
                        ->all();
    }

}
