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
     * testing parser config
     * getting preview data of parsed pages
     *
     * @return array
     */
    public function actionTest() {
        $preview = new TestForm();
        if (Yii::$app->request->isAjax) {
            $entityBody = file_get_contents('php://input');
            $data = json_decode($entityBody, TRUE);
            $rule = json_decode($data['rules'], TRUE);
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
     * parse the RSS feeds
     *
     */
    public function actionRss() {
        if ((getenv('HTTP_X_REAL_IP') == '127.0.0.1') || ((!empty($_SESSION['__id'])) && ($_SESSION['__id'] == 1))) {
            //get list of the parsing sources
            $sites = Sites::find()->where([
                        'make_parsing' => '1'
                    ])->all();
            if (!empty($sites)) {
                foreach ($sites as $site) {
                    //get the page content by a predetermined method
                    $page = $this->getPage($site->method_of_parsing, $site->source);
                    //get the collection of PostsRss objects
                    if (!empty($page->getBody())) {
                        $rss = new RssParser($page);
                    }
                    if (!empty($rss)) {
                        //get the unique (missing in the database) PostsRss objects from collection
                        $rss = $rss->getUniquePosts();

                        //redefining the category by the database settings and save PostsRss
                        foreach ($rss as $rssItem) {//
                            $rssItem->setCategory();
                            $rssItem->save();
                        }
                    }
                }
                if (empty($rssItem)) {
                    $rssItem = NULL;
                }
                return $this->render('index', ['info' => $rssItem]);
            }
        } else {
            //Yii::$app()->runAction('site/index'); //на другой контролер
            $this->redirect(\Yii::$app->urlManager->createUrl("site/index"));
        }
    }

    /**
     * iterate links to articles, parse the information and save into the database
     *
     */
    public function actionPost() {

        if ((getenv('HTTP_X_REAL_IP') == '127.0.0.1') || ((!empty($_SESSION['__id'])) && ($_SESSION['__id'] == 1))) {
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
                                } //else {
//                                ImageSearch::config()->apiKey('AIzaSyDuIBIQPF0DuQrCQaP08jO8EHth427P1cA');
//                                ImageSearch::config()->cx('002076275955567998574:xjgdm_ckmdc');
//                                print_r(ImageSearch::search($content->title, ['num' => 1, 'imgSize' => 'large']));
//                            }
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
                                    if (!empty($content['text']) && !empty($content['title'])) {

                                        //    do not delete!
                                        // $tags_from_text = MorthySearch::getTagsFromText(trim($content['text']));
                                        // $tags_from_title = MorthySearch::getTagsFromTitle(trim($content['title']));
                                        // $tags = array_merge($tags_from_text, $tags_from_title);

                                        $tags = MorthySearch::getTagsFromTitle(trim($content['title']));

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
            if (empty($content)) {
                $content = NULL;
            }
            return $this->render('index', ['info' => $content]);
        } else {
            $this->redirect(\Yii::$app->urlManager->createUrl("site/index"));
        }
    }

    /**
     * string treatment
     *
     * @param string $str
     * @return string
     */
    private function strProcessing($str) {
        $str = mb_strtolower($str);
        return trim($str);
    }

    /**
     *
     * @param string $method a method by which we get the content of the page
     * @param type $link page URL
     * @return object PageParserPhantom or PageParserCurl
     */
    private function getPage($method, $link) {
        if ($method == 'Phantom') {
            return new PageParserPhantom($link);
        }
        if ($method == 'cURL') {
            return new PageParserCurl($link);
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent :: beforeAction($action);
    }

}
