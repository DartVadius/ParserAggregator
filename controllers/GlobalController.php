<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\lib\MyFunctions;
use app\modules\parser\lib\GeoPlugin;
use Stichoza\GoogleTranslate\TranslateClient;
use app\models\Articles;
use app\models\Tags;
use app\models\ArticlesToTags;
use app\models\Category;

class GlobalController extends Controller {

    protected function geoLock($ip = NULL) {
        if ($ip == NULL) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }
        $geoplugin = new geoPlugin();
        $geoplugin->locate($ip);
        $result['city'] = $geoplugin->city;
        $result['region'] = $geoplugin->region;
        $result['country'] = $geoplugin->countryName;
        $result['country'] = $this->translate($result['country']);
        $result['country'] = MyFunctions::strProcessing($result['country']);
        $result['city'] = $this->translate($result['city']);
        $result['city'] = MyFunctions::strProcessing($result['city']);
        $result['region'] = $this->translate($result['region']);
        $result['region'] = MyFunctions::strProcessing($result['region']);
        //$radius = 10;
        //$result['nearby'] = $geoplugin->nearby(10);
        return $result;
    }

    protected function translate($text, $source = 'en', $target = 'ru') {
        $translator = new TranslateClient($source, $target);
        return $translator->translate($text);
    }

    protected function getGeoData($geo) {
        $geoCity = $this->findArtByGeo($geo['city']);
        if (count($geoCity) < 10) {
            $geoRegion = $this->findArtByGeo($geo['region']);
            $geoCity = array_merge($geoCity, $geoRegion);
        }
        if (count($geoCity) < 10) {
            $geoCountry = $this->findArtByGeo($geo['country']);
            $geoCity = array_merge($geoCity, $geoCountry);
        }
        $geoCity = array_map("unserialize",array_unique(array_map("serialize",$geoCity)));
        $geoCity = array_slice($geoCity, 0, 10);        
        return $geoCity;
    }

    protected function findArtByGeo($geo) {
        $date = MyFunctions::setTimeStamp('-7 days');
        return (new Query())
                ->select(['Articles.article_id', 'Articles.title', 'Articles.article_create_datetime'])
                ->from('Articles')
                ->innerJoin('Articles_To_Tags', 'Articles_To_Tags.article_id = Articles.article_id')
                ->innerJoin('Tags', 'Articles_To_Tags.tag_id = Tags.tag_id')
                ->where(['and',['like', 'tag', $geo],['>', 'article_create_datetime', $date]])
                ->distinct()
                ->orderBy('article_create_datetime desc')
                ->all();
    }

}
