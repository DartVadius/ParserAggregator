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
        $body = phpQuery::newDocument($data->getBody());

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
            pq($body)->find($rules['find']['img'])->remove();
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
            foreach (pq($body)->find('strong') as $strong) {
                if (pq($strong)->text() == '') {
                    pq($strong)->remove();
                } else {
                    $txt = pq($strong)->text();
                    pq($strong)->after($txt);
                    pq($strong)->remove();
                }
            }
            foreach (pq($body)->find('p') as $p) {
                if (trim(pq($p)->text()) == '') {
                    pq($p)->remove();
                }
            }

            foreach (pq($body)->find('div') as $div) {
                $txt = preg_replace("/[^\p{L}0-9 ]/iu", '', pq($div)->text());
                if (trim($txt) == '') {
                    pq($div)->remove();
                }
//                if (trim(pq($div)->text()) == '') {
//                    pq($div)->remove();
//                }
            }

            $txt = pq($body)->find($rules['find']['textFull']);
            pq($txt)->find('h1, h2, h3, h4, h5, h6')->wrap('<p></p>');
            foreach (pq($txt)->find('h1') as $h1) {
                $text = pq($h1)->text();
                pq($h1)->after($text);
            }
            foreach (pq($txt)->find('h2') as $h2) {
                $text = pq($h2)->text();
                pq($h2)->after($text);
            }
            foreach (pq($txt)->find('h3') as $h3) {
                $text = pq($h3)->text();
                pq($h3)->after($text);
            }
            foreach (pq($txt)->find('h4') as $h4) {
                $text = pq($h4)->text();
                pq($h4)->after($text);
            }            
            foreach (pq($txt)->find('h5') as $h5) {
                $text = pq($h5)->text();
                pq($h5)->after($text);
            } 
            foreach (pq($txt)->find('h6') as $h6) {
                $text = pq($h6)->text();
                pq($h6)->after($text);
            }            
            $h = pq($txt)->find('h1, h2, h3, h4, h5, h6')->remove();
            pq($txt)->find('p, div, span')
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
