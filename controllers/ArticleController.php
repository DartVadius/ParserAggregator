<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Images;
use app\models\ArticlesToTags;
use app\models\Tags;
use app\models\UsersToTags;



class ArticleController extends GlobalController {

    public function actionView($link) {
        $article = Articles::findOne(['article_id' => $link]);
        $img = Images::findAll(['article_id' => $article->article_id]);
        $tags = (new \yii\db\Query())
                ->select(['Articles.article_id', 'Tags.tag', 'Tags.tag_id'])
                ->from('Articles')
                ->leftJoin('Articles_To_Tags', 'Articles.article_id = Articles_To_Tags.article_id')
                ->leftJoin('Tags', 'Articles_To_Tags.tag_id = Tags.tag_id')
                ->where("Articles.article_id = $article->article_id")
                ->all();
        if (!empty($_SESSION['__id'])) {
            $newTag = new UsersToTags();
            $newTag->addHystory($tags);
        }
        return $this->render('article', compact('article', 'img', 'tags'));
    }   
   

}
