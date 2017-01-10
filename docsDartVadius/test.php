<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'curlItem.php';
require_once 'parserRSS.php';
require_once 'phpQuery-onefile.php';
require_once 'rssItem.php';
require_once 'pdoLib.php';
require_once 'parserPost.php';
require_once 'phantomJsItem.php';

function show($arr) {
    echo '<pre>' . print_r($arr, 1) . '</pre>';
}

$sites = [
    'http://news.liga.net/all/rss.xml',
    'http://censor.net.ua/includes/news_ru.xml',
    'https://lenta.ru/rss/news',
    'http://www.pravda.com.ua/rus/rss/',
    'http://fakty.ua/rss_feed/all',
];
/*foreach ($sites as $site) {
    $data = new curlItem($site, $setup);
    $posts = new parserRSS($data, $rules);
    $uniquePosts = $posts->getUniquePosts();
    print_r($uniquePosts);
    foreach ($uniquePosts as $value) {
        $value->save();
    }
}*/


//http://fakty.ua/228477-bojnyu-v-aeroportu-vo-floride-ustroil-26-letnij-veteran-irakskoj-vojny-foto
//http://news.liga.net/news/capital/14521665-voditeley_prosyat_ne_ezdit_po_kievu_na_vremya_snegouborochnykh_rabot.htm
//http://www.pravda.com.ua/rus/news/2017/01/7/7131846/


/*$url = 'http://news.liga.net/news/capital/14521665-voditeley_prosyat_ne_ezdit_po_kievu_na_vremya_snegouborochnykh_rabot.htm';
$data = new curlItem($url, $setup);
print_r($data);
$post = new parserPost($data, $rule2);
show($post->getPost());*/

$url = 'http://news.liga.net/news/capital/14521665-voditeley_prosyat_ne_ezdit_po_kievu_na_vremya_snegouborochnykh_rabot.htm';
$phantom = new phantomJsItem($url, PHANTOMPATH, JSPATH);
$post = new parserPost($phantom, $rule2, 2);
show($post->getPost());
