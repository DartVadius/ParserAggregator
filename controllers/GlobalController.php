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
        $result['country'] = self::translate($result['country']);
        $result['country'] = self::strProcessing($result['country']);
        $result['city'] = self::translate($result['city']);
        $result['city'] = self::strProcessing($result['city']);
        $result['region'] = self::translate($result['region']);
        $result['region'] = self::strProcessing($result['region']);

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

    public static function getGeolocation(){
        
//
        $ip = '94.244.22.168';
        $geo = self::geoLock($ip);
        $geoCity = self::findArtByGeo($geo['city']);

        if (count($geoCity) < 10) {
            $geoRegion = self::findArtByGeo($geo['region']);
            $geoCity = array_merge($geoCity, $geoRegion);
        }
        if (count($geoCity) < 10) {
            $geoCountry = self::findArtByGeo($geo['country']);
            $geoCity = array_merge($geoCity, $geoCountry);
        }

        return $geoCity;
    }
//        $categories = \app\models\Category::find()->orderBy('id')->all();
//        return $categories;


}
