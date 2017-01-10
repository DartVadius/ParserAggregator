<?php

/**
 * rule for fakty.ua
 */
$rule = [
    'find' => [
        'title' => '.tit_main_news',
        'text' => '#article_content',
        'img' => '.fotoramka_l, .center_pic',
    ],
    'prefix' => 'http://fakty.ua',
    'property' => [
        'img' => 'imgClass',
        'title' => 'titleClass',
        'text' => 'textClass',
    ],
];
/**
 * rule for pravda.com.ua
 */
$rule1 = [
    'find' => [
        'title' => '.post_news__title',
        'text' => '.post_news__text',
        'img' => '.post_news__photo__img',
    ],
    'prefix' => '',
    'property' => [
        'img' => 'imgClass',
        'title' => 'titleClass',
        'text' => 'textClass',
    ],
];

/**
 * rule for news.liga.net
 */
$rule2 = [
    'find' => [
        'title' => '.news_content h1',
        'text' => '._ga1_on_',
        'img' => '#material-image',
    ],
    'remove' => 'b, a',    
    'prefix' => 'http://news.liga.net',
    'property' => [
        'img' => 'imgClass',
        'title' => 'titleClass',
        'text' => 'textClass',
    ],
];

/**
 * parserPost v0.1
 *
 * @author DartVadius
 */
class parserPost {

    private $post = [];

    public function __construct($data, $rules, $method = 1) {
        if ($method === 1) {
            $this->post['url'] = $data->getCurlUrl();
            $this->post['source'] = $data->getCurlSource();
            $document = phpQuery::newDocument($data->getCurlBody());
        }
        if ($method === 2) {
            $this->post['url'] = $data->getPhantomUrl();
            $this->post['source'] = $data->getPhantomSource();
            $document = phpQuery::newDocument($data->getPhantomBody());
        }
        //img
        foreach (pq($document)->find($rules['find']['img']) as $img) {

            if (!empty($rules['prefix'])) {
                $src = $rules['prefix'] . pq($img)->attr('src');
                pq($img)->attr('src', $src);
            }
            $newImg .= "<img class='" . $rules['property']['img'] . "' src='" . pq($img)->attr('src') . "'>";
        }
        pq($document)->find($rules['find']['img'])->remove();
        //title
        $title = pq($document)->find($rules['find']['title'])->text();
        $title = "<h1 class='" . $rules['property']['title'] . "'>$title</h1>";
        //text
        $attr = $rules['property']['text'];
        pq($document)->find($rules['find']['text'])->find('p')->removeAttr('style')->attr('class', $attr);
        if (!empty($rules['remove'])) {
            pq($document)->find($rules['remove'])->remove();
        }
        pq($document)->find('p:empty')->remove();
        $text = pq($document)->find($rules['find']['text'])->html();
        //full post
        $post = $title . $newImg . $text;
        $this->post['post'] = $post;
    }

    public function getPost() {
        return $this->post;
    }

}
