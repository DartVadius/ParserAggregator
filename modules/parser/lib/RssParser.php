<?php

namespace app\modules\parser\lib;

use phpQuery;
use app\models\PostsRss;

/**
 * RssParser
 *
 * @author DartVadius
 */
class RssParser {

    private $rss = [];

    /**
     * array with rss parser config
     * the array keys are column names in the database table
     * the array values are phpQuery selectors
     * 
     * @var array 
     */
    private $rules = [
        'title' => 'title',
        'link' => 'link',
        'category' => 'category',
        'date' => 'pubDate'
    ];

    public function __construct($data) {
        $document = phpQuery::newDocument($data->getBody());        
        $posts = $document->find('item');
        foreach ($posts as $post) {
            $rssPost = new PostsRss();
            $rssPost->source = $data->getSource();
            foreach ($this->rules as $rule => $value) {
                $tag = pq($post)->find($value);
                $rssPost->$rule = pq($tag)->text();
            }
            $rssPost->date = date('Y-m-d H:i:s', strtotime($rssPost->date));
            array_push($this->rss, $rssPost);
        }
    }

    public function getRSS() {
        return $this->rss;
    }

    /**
     * Check RSS duplication in the database and make a selection of unique links
     * 
     * @return array
     */
    public function getUniquePosts() {
        $uniqueRSS = [];
        foreach ($this->rss as $value) {
            $link = PostsRss::find()->where(['link' => $value->link])->all();
            if (empty($link)) {
                array_push($uniqueRSS, $value);
            }
        }
        return $uniqueRSS;
    }

}
