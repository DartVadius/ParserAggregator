<?php

namespace app\modules\parser\lib;

/**
 * ParserCurl: obtain the content of the page using cURL library
 *
 * @author DartVadius
 */
class PageParserCurl extends PageParser {

    /**
     * getting page content by cURL
     * 
     * @param string $url
     */
    public function __construct($url) {
        parent::__construct($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        foreach ($this->appConfig['cURLsetup'] as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $this->body = curl_exec($ch);
        curl_close($ch);
    }

}
