<?php

namespace app\modules\parser\lib;

use app\models\Articles;
use app\models\Images;
use app\models\Tags;
use phpQuery;

/**
 * ContentParser
 *
 * @author DartVadius
 */
class ContentParser {

    private $content = null;
    private $textShort = null;
    private $img = [];
    private $links = [];
    private $tags = [];
    private $video = [];
    private $category = null;
    private $date = null;
    private $author = null;

    public function __construct($data, $rules) {
        $article = new Articles();
        $article->link_to_article = $data->getUrl();
        $article->sourse = $data->getSource();
        //$article->Article_JSON = json_encode($data->getBody());
        $article->Article_JSON = '{}';
        $document = phpQuery::newDocument($data->getBody());
        $body = pq($document)->find('body');

        if (!empty($rules['remove'])) {
            pq($body)->find($rules['remove'])->remove();
        }

        if (!empty($rules['find']['img'])) {
            foreach (pq($body)->find($rules['find']['img']) as $img) {
                $images = new Images();
                if (!empty($rules['prefix'])) {
                    $images->link_to_image = $rules['prefix'] . pq($img)->attr('src');
                } else {
                    $images->link_to_image = pq($img)->attr('src');
                }
                array_push($this->img, $images);
            }
        }

        if (!empty($rules['find']['video'])) {
            foreach (pq($body)->find($rules['find']['video']) as $vid) {
                array_push($this->video, pq($vid)->attr('href'));
            }
        }

        if (!empty($rules['find']['links'])) {
            foreach (pq($body)->find($rules['find']['links']) as $link) {
                array_push($this->links, pq($link)->attr('href'));
            }
        }

        if (!empty($rules['find']['tags'])) {
            foreach (pq($body)->find($rules['find']['tags']) as $tag) {
                $newTag = new Tags();
                $newTag->tag = pq($tag)->text();
                array_push($this->tags, $newTag);
            }
        }

        pq($document)->find($rules['find']['img'])->remove();
        pq($body)->find('div:empty, p:empty')->remove();

        if (!empty($rules['find']['title'])) {
            $article->title = pq($body)->find($rules['find']['title'])->text();
        }
        if (!empty($rules['find']['textShort'])) {
            $this->textShort = pq($body)->find($rules['find']['textShort'])->text();
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
        pq($body)->find('div:empty')->remove();
        if (!empty($rules['find']['textFull'])) {
            foreach (pq($body)->find('a') as $link) {
                if (pq($link)->text() == '') {
                    pq($link)->remove();
                } else {
                    $txt = pq($link)->text();
                    pq($link)->after($txt);
                    pq($link)->remove();
                }
            }
            foreach (pq($body)->find('p') as $p) {
                if (pq($p)->text() == '') {
                    pq($p)->remove();
                }
            }
            
            foreach (pq($body)->find('div') as $div) {
                if (trim(pq($div)->text()) == '') {
                    pq($div)->remove();
                }
            }

            $txt = pq($body)->find($rules['find']['textFull']);
            pq($txt)->find('h1, h2, h3, h4, h5, h6')->wrap('<p></p>');
            $h = pq($txt)->find('h1, h2, h3, h4, h5, h6')->text();
            pq($txt)->find('h1, h2, h3, h4, h5, h6')->after($h);
            $h = pq($txt)->find('h1, h2, h3, h4, h5, h6')->remove();
            pq($txt)->find('p, div')
                    ->removeAttr('itemprop')
                    ->removeAttr('class')
                    ->removeAttr('id')
                    ->removeAttr('style');
            $article->text = pq($txt)->html();
            $article->text = preg_replace('/(<br[^>]*>\s*)+/i', '\1', $article->text);
            $article->text = preg_replace("/[\t\r\n]+/", ' ', $article->text);  
        }
        $this->content = $article;
    }

    public function getContent() {
        return $this->content;
    }

    public function getImg() {
        return $this->img;
    }

    public function getTags() {
        return $this->tags;
    }

}
