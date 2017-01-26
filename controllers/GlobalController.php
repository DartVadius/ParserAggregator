<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\modules\parser\lib\geoPlugin;
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
        $date = new \DateTime();
        $date->modify('-7 days');
        $date->format('Y-m-d H:i:s');
        $date = $date->getTimestamp();
        $date = date('Y-m-d H:i:s', $date);        
        return (new Query())
                        ->select(['Articles.*'])
                        ->from('Tags')
                        ->leftJoin('Articles_To_Tags', 'Tags.tag_id = Articles_To_Tags.tag_id')
                        ->leftJoin('Articles', 'Articles_To_Tags.article_id = Articles.article_id')
                        ->where([
                            'like', 'tag', $geo
                        ])
                        ->andWhere(['>', 'article_create_datetime', $date])
                        ->orderBy('article_create_datetime desc')
                        ->all();
    }

}
