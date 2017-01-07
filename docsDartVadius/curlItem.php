<?php

/**
 * @todo move to the configuration file
 */
$setup = [
    CURLOPT_HEADER => FALSE,
    CURLOPT_REFERER => 'https://www.google.com',
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_HTTPHEADER => [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
        'Connection: keep-alive'
    ],
    CURLOPT_SSL_VERIFYPEER => FALSE,
    CURLOPT_SSL_VERIFYHOST => FALSE
];

/**
 * @author DartVadius
 */
class curlItem {

    private $data = null;

    public function __construct($url, $setup) {
        $this->data['url'] = $url;
        $urlArr = parse_url($url);
        $this->data['source'] = $urlArr['host'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //настраиваем curl из сетапа
        foreach ($setup as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $this->data['body'] = curl_exec($ch);
        curl_close($ch);
    }

    public function getCurlBody() {
        return $this->data['body'];
    }

    public function getCurlSource() {
        return $this->data['source'];
    }    
    
    public function getCurlUrl() {
        return $this->data['url'];
    }
}
