<?php

/**
 * @todo move to the configuration file
 */
$rules = [
    'title' => 'title',
    'link' => 'link',
    'category' => 'category',
    'date' => 'pubDate'
];

/**
 * parse RSS feeds
 *
 * @author DartVadius
 */
class parserRSS {

    private $rss = [];

    public function __construct($data, $rules) {
        $document = phpQuery::newDocument($data->getCurlBody());
        $posts = $document->find('item');
        foreach ($posts as $post) {
            $newPost = new rssItem();
            $newPost->source = $data->getCurlSource();
            foreach ($rules as $rule => $value) {
                $tag = pq($post)->find($value);
                $newPost->$rule = pq($tag)->text();
            }
            array_push($this->rss, $newPost);
        }
    }

    public function getRSS() {
        return $this->rss;
    }
    
    public function getUniquePosts() {
        $pdo = PDOLib::getInstance()->getPdo();
    }

}
