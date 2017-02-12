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
        $abbr = [];
        $arr_text = self::deleteGarbageFromText($text);
        foreach ($arr_text as $word) {
            if (($word == mb_strtoupper($word)) && (strlen($word) > 2) && (!is_numeric($word))) {
                $abbr[] = $word;
            }
        }
        $abbr = array_unique($abbr);
        $geo = array_unique(self::searchGeoLocation($arr_text));


        $arr_text = array_map('mb_strtoupper', $arr_text);

        $noun = self::getBaseFormForArray($arr_text, $morphy);

        $noun = array_count_values($noun);
        arsort($noun, SORT_NUMERIC);
        $noun = array_slice($noun, 0, 3);

        $pre_answer = array_keys($noun);
        
        $answer = self::selectTagsFromWords($pre_answer);
        $answer = array_map('mb_strtolower', array_unique(array_merge($answer, $abbr, $geo)));
        return $answer;
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

        $answer = array_merge($answer, self::selectTagsFromWords($arr));
        $answer = array_unique(array_map('mb_strtolower', $answer));
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
            $arr[$i] = mb_strtoupper(mb_substr($arr[$i], 0, 1)) . mb_strtolower(mb_substr($arr[$i], 1));
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