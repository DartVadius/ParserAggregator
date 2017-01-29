<?php
namespace app\modules\parser\lib;
use phpMorphy;

/**
* Class for search tags in article.
*/
class MorthySearch 
{
	public static $punktuation_marks = array('.', ',', '!', '?', ':', ';', '-', '"', '\'', '(', ')');
	public static function getTagsFromText($text) 
	{
		$morphy = new \phpMorphy(\Yii::getAlias(
			'@vendor/umisoft/phpmorphy/dicts'//Путь к словарям
        ), 'ru_RU', ['storage' => PHPMORPHY_STORAGE_FILE, 'graminfo_as_text' => FALSE,]);

        $new_text = str_replace($this->punktuation_marks, "", $text); //удаляем знаки пунктуации
		$new_text = str_replace("  ", " ", $new_text);//заменяем 2-йной пробел

		$arr_text = explode(" ", $new_text); //режем на массив
		$arr_text = array_map('mb_strtoupper', $arr_text); //делаем все большими буквами для поиска в словаре

		$noun = [];
		for ($i=0; $i < count($arr_text); $i++) {
			$word = $morphy->getBaseForm($arr_text[$i]); //ищем базовую форму слова, может быть несколько. возвращает массив
		    if (($word[0] != 'false') && ($morphy->getPartOfSpeech($word[0])[0] == 'C')) { //берем первое слово если оно существительное
				$noun[] = $word[0];
		    }
		}

		$noun = array_count_values($noun); //подсчитываем количество вхождений каждого существительного

		if (count($noun) >= 5) {
			$noun = array_slice($noun, 0, 5); // берем срез только первых трех существительных
		}

		$answer = array_keys($noun);
		$answer = array_map('mb_strtolower', $answer);
		return $answer;
	}

	public static function getTagsFromTitle($text) 
	{
		$answer = [];
		$str = str_replace($this->punktuation_marks, "", $text);
        $str = str_replace("  ", " ", $new_text);//заменяем 2-йной пробел
        $arr = explode(" ", $str);
        foreach ($arr as $word) {
            if ($word == mb_strtoupper($word)) {
                $answer[] = $word;
            }
        }
        return $answer;
	}
}



