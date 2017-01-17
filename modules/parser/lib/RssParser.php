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
     * проверяем объекты на уникальность по записям в БД
     * получаем массив уникальных объектов
     * нужно для записи в БД, чтобы не делать дубли новостей
     *
     * @todo remove pdo
     * @return array
     */
    public function getUniquePosts() {
        $uniqueRSS = [];
        $links = PostsRss::find()->select('link')->column();        
        foreach ($this->rss as $value) {
            if (!array_search($value->link, $links)) {
                array_push($uniqueRSS, $value);
            }
        }        
        return $uniqueRSS;
    }
}
