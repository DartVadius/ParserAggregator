<?php

namespace app\modules\parser\controllers;

use Yii;
use yii\web\Controller;
use app\modules\parser\lib\PageParserCurl;
use app\modules\parser\lib\PageParserPhantom;
use app\modules\parser\lib\ContentParser;
use app\modules\parser\lib\RssParser;
use app\models\Sites;
use app\models\Category;
use app\models\PostsRss;
use app\models\Articles;
use app\models\Images;
use app\models\Tags;
use phpQuery;

/**
 * parser
 *
 * @author DartVadius
 */
class ParserController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionTest() {
        $rule = [
            'find' => [
                'title' => '.entry-title',
                'textShort' => '',
                'textFull' => 'div.text',
                'category' => '',
                'date' => '',
                'author' => '',
                'img' => 'a.top_img_loader img',
                'links' => '',
                'tags' => '.tags a',
            ],
            'remove' => 'b::contains("Читайте также"), b::contains("Читайте на"), b::contains("Также читайте"), b::contains("Читайте:"), b::contains("Смотрите на"), b::contains("Смотрите также"), .tags span',
            'prefix' => '',
        ];
        $ex = json_encode($rule);
        $url = 'http://censor.net.ua/photo_news/424009/poroshenko_poprosil_glavu_krasnogo_kresta_maurera_o_sodeyistvii_v_osvobojdenii_ukrainskih_zalojnikov';
        $parser = new PageParserCurl($url);
        //$parser = new PageParserPhantom($url);
        $data = new ContentParser($parser, $rule);
        return $this->render('test', ['info' => $data, 'json' => $ex]);
    }

    /**
     *
     * @return type
     */
    public function actionRss() {
        /**
         *
         * @todo сделать конфиг для дефолтной категории?!
         */
        $defaultCategory = 1;

        $sites = Sites::find()->where([
                    'make_parsing' => '1'
                ])->all();
        if (!empty($sites)) {
            foreach ($sites as $site) {
                $page = $this->getPage($site->method_of_parsing, $site->source);
                if (!empty($page->getBody())) {
                    $rss = new RssParser($page);
                }

                $rss = $rss->getUniquePosts();

                foreach ($rss as $rssItem) {
                    $category = Category::find()->all();
                    $newCat = $this->strProcessing($rssItem->category);
                    if (!empty($newCat)) {
                        foreach ($category as $value) {
                            $cat = explode(',', $value['synonyms']);
                            $cat = array_map(array($this, 'strProcessing'), $cat);
                            $k = array_search($newCat, $cat);
                            if ($k !== NULL && $k !== FALSE) {
                                $k = $value['id'];
                                break;
                            }
                        }
                    }
                    if ($k) {
                        $rssItem->category = $k;
                    } else {
                        $rssItem->category = $defaultCategory;
                    }
                    $rssItem->save();
                }
            }
        }

        return $this->render('index', ['info' => $rssItem]);
    }

    public function actionPost() {
        $sites = Sites::find()->where([
                    'make_parsing' => '1'
                ])->all();

        if (!empty($sites)) {
            foreach ($sites as $site) {                
                $list = (new \yii\db\Query())
                                ->select(['posts_rss.source', 'posts_rss.link', 'posts_rss.category', 'posts_rss.date', 'Articles.link_to_article'])
                                ->from('posts_rss')
                                ->leftJoin('Articles', 'link = link_to_article')
                                ->where([
                                    'link_to_article' => null,
                                    'source' => $site->name,
                                ])->all();

                foreach ($list as $article) {
                    $page = $this->getPage($site->method_of_parsing, $article['link']);
                    if (!empty($page->getBody())) {
                        $settings = json_decode($site->parsing_settings, TRUE);
                        $post = new ContentParser($page, $settings);
                        if (!empty($post->getContent())) {
                            $content = $post->getContent();
                            $content->article_create_datetime = $article['date'];
                            $content->category_id = $article['category'];
                            $content->save();
                            $contentId = Yii::$app->db->lastInsertID;
                            if (!empty($post->getImg())) {
                                $images = $post->getImg();
                                foreach ($images as $img) {
                                    $img->article_id = $contentId;
                                    if ($img->validate()) {
                                        $img->save();
                                    }
                                }
                            }
                            if (!empty($post->getTags())) {
                                $tags = $post->getTags();
                                //add uniqe tags to tag table
                                foreach ($tags as $tag) {
                                    $tag->tag = $this->strProcessing($tag->tag);
                                    if ($tag->validate()) {
                                        $tag->save();
                                    }
                                }
                                foreach ($tags as $tag) {
                                    $tagId = (new \yii\db\Query())
                                                    ->select(['tag_id'])
                                                    ->from('Tags')
                                                    ->where([
                                                        'tag' => $tag->tag,
                                                    ])->one();
                                    $postToTag = new \app\models\ArticlesToTags();
                                    $postToTag->article_id = $contentId;
                                    $postToTag->tag_id = $tagId['tag_id'];
                                    if ($postToTag->validate()) {
                                        $postToTag->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $this->render('index', ['info' => $content]);
    }

    private function strProcessing($str) {
        $str = trim($str);
        return mb_strtolower($str);
    }

    private function getPage($method, $link) {
        if ($method == 'Phantom') {
            return new PageParserPhantom($link);
        }
        if ($method == 'cURL') {
            return new PageParserCurl($link);
        }
    }

}
