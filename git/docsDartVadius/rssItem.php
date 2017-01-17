<?php

/**
 * категория по умолчанию для записи в БД
 * 
 * @todo add to site setup/config file
 */
define(CATEGORY_ID_DEFAULT, 1);

/**
 * Description of rssItem
 *
 * @author DartVadius
 */
class rssItem {

    public static $tableName = 'posts_rss';
    private $post = [];

    public function __construct() {

    }

    public function __set($name, $value) {
        $this->post[$name] = $value;
    }

    public function getRssItem() {
        return $this->post;
    }

    /**
     * @todo remove pdo
     * @return boolean
     */
    public function save() {
        $pdo = PDOLib::getInstance()->getPdo();
        $arr = [];
        $cat = [];
        $k = NULL;
        if (!empty($this->post)) {
            $reqCat = 'SELECT * FROM category';
            $resCategory = $pdo->query($reqCat);
            //список категорий из БД
            $category = $resCategory->fetchAll();
            //категория из нового объекта 
            $newCat = $this->strProcessing($this->post['category']);
            
            if (!empty($newCat)) {
                //перебираем категории из БД
                foreach ($category as $value) {
                    //разбираем строку из поля "синонимы"
                    $cat = explode(',', $value['synonyms']);
                    //и обрабатываем ее
                    $cat = array_map(array($this, 'strProcessing'), $cat);
                    //ищем категорию объекта в списке синонимов
                    $k = array_search($newCat, $cat);
                    //если находим, запоминаем ID категории
                    if ($k !== NULL && $k !== FALSE) {
                        $k = $value['id'];
                        break;
                    }
                }
            }
            //если есть ID категории, заменяем категорию объекта на него 
            if ($k) {
                $this->post['category'] = $k;
            } else {
            //иначе присваимаем значение по дефолту
                $this->post['category'] = CATEGORY_ID_DEFAULT;
            }
            
            //собираем строку запроса и записываем в базу
            $req = 'INSERT INTO ' . self::$tableName . ' SET ';            
            foreach ($this->post as $key => $value) {
                $req .= "$key = :$key, ";
                $arr[$key] = $value;
            }

            $req = trim($req);
            $req = substr($req, 0, strlen($req) - 1);
            $res = $pdo->prepare($req);
            $res->execute($arr);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function strProcessing($str) {
        $str = trim($str);
        return mb_strtolower($str);
    }

}
