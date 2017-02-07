<?php

namespace app\modules\parser\lib;

use phpMorphy;
use Yii;
use app\models\Tags;
use app\models\Country;

/**
 * Class for search tags in article.
 * @author SilinMykola.
 */
class MorthySearch
{

    public static function getTagsFromText($text)
    {
        $morphy = new \phpMorphy(\Yii::getAlias(
            '@vendor/umisoft/phpmorphy/dicts'
        ), 'ru_RU', ['storage' => PHPMORPHY_STORAGE_FILE, 'graminfo_as_text' => FALSE,]);


        $answer = [];
        $arr_text = self::deleteGarbageFromText($text);
        foreach ($arr_text as $word) {
            if ($word == mb_strtoupper($word)) {
                $answer[] = $word;
            }
        }

        $arr_text = array_map('mb_strtoupper', $arr_text);

        $noun = self::getBaseFormForArray($arr_text, $morphy);

        $noun = array_count_values($noun);

        if (count($noun) >= 3) {
            $noun = array_slice($noun, 0, 3);
        }

        $pre_answer = array_keys($noun);
        $pre_answer = array_map('mb_strtolower', $pre_answer);

        return self::selectTagsFromWords($pre_answer);
    }

    public static function getTagsFromTitle($text)
    {
        $answer = [];
        $geo = [];
        $morphy = new \phpMorphy(\Yii::getAlias(
            '@vendor/umisoft/phpmorphy/dicts'
        ), 'ru_RU', ['storage' => PHPMORPHY_STORAGE_FILE, 'graminfo_as_text' => FALSE,]);

        $arr = self::deleteGarbageFromText($text);

        foreach ($arr as $word) {
            if (($word == mb_strtoupper($word)) && (strlen($word) > 2) && (!is_numeric($word))) {
                $answer[] = $word;
            }
        }

        $arr = array_map('mb_strtoupper', $arr);


        $arr = self::getBaseFormForArray($arr, $morphy);

        $arr = array_map('mb_strtolower', $arr);
        $geo = self::searchGeoLocation($arr);
        if (!empty($geo)) {
            array_merge($answer, $geo);
        }

        $answer = array_merge($answer,array_unique(self::selectTagsFromWords($arr)));
        return $answer;
    }

    public static function getBaseFormForArray($arr, $morphy)
    {
        $answer = [];
        for ($i=0; $i < count($arr); $i++) {
            $word = $morphy->getBaseForm($arr[$i]);
            if (($word[0] != 'false') && ($morphy->getPartOfSpeech($word[0])[0] == 'C')) {
                $answer[] = $word[0];
            }
        }
        return $answer;
    }

    public static function deleteGarbageFromText($text)
    {
        $new_text = preg_replace("/[^\p{L}0-9 ]/iu", " ", $text);
        $new_text = str_replace("  ", " ", $new_text);
        $arr_text = explode(" ", $new_text);

        $answer = [];
        for ($i=0; $i< count($arr_text); $i++) {
            $arr_text[$i] = trim($arr_text[$i]);
            if ($arr_text[$i] !== "") {
                $answer[] = $arr_text[$i];
            }
        }
        return $answer;
    }

    public static function selectTagsFromWords($arr)
    {
        $answer = [];
        foreach ($arr as $word) {
            $tagId = (new \yii\db\Query())
                ->select(['tag_id'])
                ->from('Tags')
                ->where([
                    'tag' => $word,
                ])->one();
            if ((!empty($tagId)) && (!in_array($word, $answer))) {
                array_push($answer, $word);
            }
        }
        return $answer;
    }

    public static function searchGeoLocation($arr)
    {
        $answer = [];
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i] = mb_strtoupper(mb_substr($arr[$i], 0, 1)) . mb_substr($arr[$i], 1);
        }
        foreach ($arr as $word) {
            $country = (new \yii\db\Query())
                ->select('country_id')
                ->from('country')
                ->where(['name' => $word])
                ->one();
            if (!empty($country)) {
                array_push($answer, $word);
            }

            $city = (new \yii\db\Query())
                ->select('city_id')
                ->from('city')
                ->where(['name' => $word])
                ->one();
            if (!empty($city)) {
                array_push($answer, $word);
            }

            $region = (new \yii\db\Query())
                ->select('region_id')
                ->from('region')
                ->where(['name' => $word])
                ->one();
            if (!empty($city)) {
                array_push($answer, $word);
            }
        }

        return $answer;
    }
}