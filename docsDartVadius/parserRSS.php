<?php

/**
 * @todo move to the configuration file
 * !!!important!!! keys - is a db columns names
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
 *
 * @author DartVadius
 */
class parserRSS {

    private $rss = [];

    //получаем массив объектов, каждый из которых - отдельный пост в RSS ленте
    public function __construct($data, $rules) {
        $document = phpQuery::newDocument($data->getCurlBody());
        $posts = $document->find('item');
        foreach ($posts as $post) {
            $newPost = new rssItem();
            $newPost->source = $data->getCurlSource();
            //парсим страницу по параметрам, заданным в $rules
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
        $pdo = PDOLib::getInstance()->getPdo();
        $req = 'SELECT link FROM ' . rssItem::$tableName;
        $res = $pdo->query($req);
        $links = $res->fetchAll(PDO::FETCH_COLUMN);
        foreach ($this->rss as $value) {
            if (!array_search($value->getRssItem()['link'], $links)) {
                array_push($uniqueRSS, $value);
            }
        }

        return $uniqueRSS;
    }

}
