<?php

require_once 'curlItem.php';
require_once 'parserRSS.php';
require_once 'phpQuery-onefile.php';
require_once 'rssItem.php';
require_once 'pdoLib.php';

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

$rules = [
    'title' => 'title',
    'link' => 'link',
    'category' => 'category',
    'date' => 'pubDate'
];

$sites = [
    'http://news.liga.net/all/rss.xml',
    'http://censor.net.ua/includes/news_ru.xml',
    'https://lenta.ru/rss/news',
    'http://www.pravda.com.ua/rus/rss/',
    'http://fakty.ua/rss_feed/all',
];
foreach ($sites as $site) {
    $data = new curlItem($site, $setup);
    $posts = new parserRSS($data, $rules);
    $uniquePosts = $posts->getUniquePosts();
    print_r($uniquePosts);
    foreach ($uniquePosts as $value) {
        $value->save();
    }
}

