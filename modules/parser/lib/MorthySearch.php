<?php

namespace app\modules\parser\lib;

use phpMorphy;
use Yii;
use app\models\Tags;

/**
* Class for search tags in article.
*/
class MorthySearch 
{
	
	public static function getTagsFromText($text) 
	{
		$morphy = new \phpMorphy(\Yii::getAlias(
			'@vendor/umisoft/phpmorphy/dicts'//Путь к словарям
        ), 'ru_RU', ['storage' => PHPMORPHY_STORAGE_FILE, 'graminfo_as_text' => FALSE,]);

        
		$answer = [];
		$arr_text = self::deleteGarbageFromText($text);
		foreach ($arr_text as $word) {
            if ($word == mb_strtoupper($word)) {
                $answer[] = $word;
            }
        }

		$arr_text = array_map('mb_strtoupper', $arr_text); //делаем все большими буквами для поиска в словаре

		$noun = self::getBaseFormForArray($arr_text, $morphy);

		$noun = array_count_values($noun); //подсчитываем количество вхождений каждого существительного

		if (count($noun) >= 5) {
			$noun = array_slice($noun, 0, 5); // берем срез только первых пяти существительных
		}

		$answer = array_keys($noun);
		$answer = array_map('mb_strtolower', $answer);
		return $answer;
	}

	public static function getTagsFromTitle($text) 
	{
		$answer = [];
		$morphy = new \phpMorphy(\Yii::getAlias(
			'@vendor/umisoft/phpmorphy/dicts'//Путь к словарям
        ), 'ru_RU', ['storage' => PHPMORPHY_STORAGE_FILE, 'graminfo_as_text' => FALSE,]);

        $arr = self::deleteGarbageFromText($text);

        foreach ($arr as $word) {
            if ($word == mb_strtoupper($word) && (strlen($word) > 2)) {
                $answer[] = $word;
            }
        }
        $arr = array_map('mb_strtoupper', $arr);
		

        $arr = self::getBaseFormForArray($arr, $morphy);

        $arr = array_map('mb_strtolower', $arr);

        foreach ($arr as $word) {
            $tagId = (new \yii\db\Query())
                            ->select(['tag_id'])
                            ->from('Tags')
                            ->where([
                                'tag' => $word,
                            ])->one();
            if (!empty($tagId)) {
                array_push($answer, $word);
            }
        }
        $answer = array_unique($answer);
        return $answer;
	}

	public static function getBaseFormForArray($arr, $morphy)
	{
		$answer = [];
		for ($i=0; $i < count($arr); $i++) {
			$word = $morphy->getBaseForm($arr[$i]); //ищем базовую форму слова, может быть несколько. возвращает массив
	    	if (($word[0] != 'false') && ($morphy->getPartOfSpeech($word[0])[0] == 'C')) { //берем первое слово если оно существительное
				$answer[] = $word[0];
	    	}
		}
		return $answer;
	}

	public static function deleteGarbageFromText($text) //удалить лишние символы и пустые элементы
	{
		$new_text = preg_replace("/[^\p{L}0-9 ]/iu", " ", $text);//удаляем лишние знаки
		$new_text = str_replace("  ", " ", $new_text);//заменяем 2-йной пробел
		$arr_text = explode(" ", $new_text); //режем на массив

		$answer = [];
		for ($i=0; $i< count($arr_text); $i++) { 
			$arr_text[$i] = trim($arr_text[$i]);
			if ($arr_text[$i] !== "") {
				$answer[] = $arr_text[$i];
			}
		}
		return $answer;
	}
}
