<?php

namespace app\modules\preview\lib;


class PageParserCurl extends PageParser {

    /**
     *
     * @param string $url
     */
    public function __construct($url) {
        parent::__construct($url);
        $ch = curl_init(); //Инициализирует сеанс cURL
        curl_setopt($ch, CURLOPT_URL, $url); //Устанавливает параметр для сеанса CURL
        foreach ($this->appConfig['cURLsetup'] as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $this->body = curl_exec($ch);  //Выполняет запрос cURL
        curl_close($ch);
    }

}
