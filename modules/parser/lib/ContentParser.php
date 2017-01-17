<?php

namespace app\modules\parser\lib;

use phpQuery;

/* $rule = [
  'find' => [
  'title' => '.news_content h1',
  'textShort' => '',
  'textFull' => '._ga1_on_',
  'category' => '',
  'date' => '',
  'author' => '',
  'img' => '#material-image',
  'links' => '',
  ],
  'remove' => 'b, a, p::contains("Читайте также:")',
  'prefix' => 'http://news.liga.net',
  ]; */

/**
 * ContentParser
 *
 * @author DartVadius
 */
class ContentParser {

    private $url = null;
    private $source = null;
    private $html = null;
    private $title = null;
    private $textShort = null;
    private $textFull = null;
    private $img = [];
    private $links = [];
    private $category = null;
    private $date = null;
    private $author = null;

    public function __construct($data, $rules) {

        $this->url = $data->getUrl();
        $this->source = $data->getSource();
        //$this->html = 
        $document = phpQuery::newDocument($data->getBody());
        $body = pq($document)->find('body');        
        if (!empty($rules['find']['img'])) {            
            foreach (pq($body)->find($rules['find']['img']) as $img) {
                
                if (!empty($rules['prefix'])) {
                    $src = $rules['prefix'] . pq($img)->attr('src');
                }
                array_push($this->img, $src);
            }
        }
        
        if (!empty($rules['find']['links'])) {            
            foreach (pq($body)->find($rules['find']['links']) as $link) {
                array_push($this->links, pq($link)->attr('href'));
            }
        }        
        
        pq($document)->find($rules['find']['img'])->remove();
        
        if (!empty($rules['remove'])) {
            pq($body)->find($rules['remove'])->remove();
        }
        pq($body)->find('*:empty')->remove();        

        if (!empty($rules['find']['title'])) {
            $this->title = pq($body)->find($rules['find']['title'])->text();
        }
        if (!empty($rules['find']['textShort'])) {
            $this->textShort = pq($body)->find($rules['find']['textShort'])->text();
        }
        if (!empty($rules['find']['textFull'])) {
            pq($body)->find('a')->attr('href', '#');
            $this->textFull = pq($body)->find($rules['find']['textFull'])->html();
        }
        if (!empty($rules['find']['category'])) {
            $this->category = pq($body)->find($rules['find']['category'])->text();
        }
        if (!empty($rules['find']['date'])) {
            $this->date = pq($body)->find($rules['find']['date'])->text();
        }
        if (!empty($rules['find']['author'])) {
            $this->author = pq($body)->find($rules['find']['author'])->text();
        }        
    }

}
