<?php

namespace app\modules\parser\controllers;

use Yii;
use yii\web\Controller;
use app\modules\parser\lib\PageParserCurl;
use app\modules\parser\lib\PageParserPhantom;
use app\modules\parser\lib\ContentParser;
use app\modules\parser\lib\RssParser;
use app\modules\parser\lib\MorthySearch;
use app\models\Sites;
use app\models\Category;
use app\models\PostsRss;
use app\models\Articles;
use app\models\Images;
use app\models\Tags;
use phpQuery;
use app\models\TestForm;

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
        /* $rule = [
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
          'video' => '',
          ],
          'remove' => 'i::contains("Фото"), .related-news, b::contains(\"\u0427\u0438\u0442\u0430\u0439\u0442\u0435 \u0442\u0430\u043a\u0436\u0435\"), b::contains(\"\u0427\u0438\u0442\u0430\u0439\u0442\u0435 \u043d\u0430\"), b::contains(\"\u0422\u0430\u043a\u0436\u0435 \u0447\u0438\u0442\u0430\u0439\u0442\u0435\"), b::contains(\"\u0427\u0438\u0442\u0430\u0439\u0442\u0435:\"), b::contains(\"\u0421\u043c\u043e\u0442\u0440\u0438\u0442\u0435 \u043d\u0430\"), b::contains(\"\u0421\u043c\u043e\u0442\u0440\u0438\u0442\u0435 \u0442\u0430\u043a\u0436\u0435\"), .tags span',
          'prefix' => '',
          ]; */

        /* $rule = [
          'find' => [
          'title' => '.post-item__title',
          'textShort' => '',
          'textFull' => '._ga1_on_',
          'category' => '',
          'date' => '',
          'author' => '',
          'img' => '.news_content img',
          'links' => '',
          'tags' => '',
          'video' => '',
          ],
          'remove' => 'b, p::contains("Читайте также"), p::contains("Читайте интервью:"), p::contains(\\\"\\u0427\\u0438\\u0442\\u0430\\u0439\\u0442\\u0435 \\u0442\\u0430\\u043a\\u0436\\u0435:\\")',
          'prefix' => 'http://news.liga.net',
          ]; */

        $preview = new TestForm();
        if (Yii::$app->request->isAjax) {
            $entityBody = file_get_contents('php://input');
            $data = json_decode($entityBody, TRUE);
            $rule = json_decode($data['rules'], TRUE);
            //print_r($rule);
            $url = $data['url'];
            $method = $data['method'];
            if ($method == 1) {
                $parser = new PageParserPhantom($url);
            } else {
                $parser = new PageParserCurl($url);
            }            
            $page = new ContentParser($parser, $rule);
            $article = $page->getContent();
            $img = $page->getImg();
            $tag = $page->getTags();
            if (!empty($img)) {
                $images = "Картинок найдено - " . count($img) . ", ссылки: ";
                foreach ($img as $image) {
                    $images .= $image->link_to_image . " | ";
                }
            }
            if (!empty($tag)) {
                $tags = "Тэгов найдено - " . count($tag) . ": ";
                foreach ($tag as $t) {
                    $tags .= $t->tag . " | ";
                }
            }
            $text = $article->text;
            $title = $article->title;

            $answer = [
                'title' => $title,
                'text' => $text,
                'images' => $images,
                'tags' => $tags,
                'rule' => json_encode($rule, JSON_UNESCAPED_UNICODE)
            ];
            echo (json_encode($answer));
            exit();
        }
        return $this->render('test', compact('preview'));
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
                if (!empty($rss)) {

                    $rss = $rss->getUniquePosts();

                    foreach ($rss as $rssItem) {
                        $category = Category::find()->all();
                        $newCat = $this->strProcessing($rssItem->category);
                        $k = NULL;
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
        }
        if (empty($rssItem)) {
            $rssItem = NULL;
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
                                ->select([
                                    'posts_rss.source',
                                    'posts_rss.link',
                                    'posts_rss.category',
                                    'posts_rss.date',
                                    'Articles.link_to_article'
                                ])
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
                                    $tag->tag = preg_replace("/[^\p{L}0-9 ]/iu", '', $tag->tag);
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
                            } else {
                                if (!empty($content['text'])) {

                                    $tags_from_text = MorthySearch::getTagsFromText(trim($content['text']));

                                    $tags_from_title = MorthySearch::getTagsFromTitle(trim($content['title']));


                                    $tags = array_merge($tags_from_text, $tags_from_title);

                                    foreach ($tags as $tag) {
                                        $new_tag = new Tags();
                                        $new_tag->tag = $tag;
                                        $tagId = (new \yii\db\Query())
                                                        ->select(['tag_id'])
                                                        ->from('Tags')
                                                        ->where([
                                                            'tag' => $new_tag->tag,
                                                        ])->one();
                                        if (empty($tagId)) {
                                            if ($new_tag->validate()) {
                                                $new_tag->save();
                                                $tagId = Yii::$app->db->getLastInsertID();
                                            }
                                        }
                                        $postToTag = new \app\models\ArticlesToTags();
                                        $postToTag->article_id = $contentId;
                                        $postToTag->tag_id = $tagId;
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
        }

        return $this->render('index', ['info' => $content]);
    }

    private function strProcessing($str) {
        $str = mb_strtolower($str);
        return trim($str);
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
