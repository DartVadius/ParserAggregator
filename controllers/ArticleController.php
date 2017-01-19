<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Images;

/**
 * ArticleController
 *
 * @author DartVadius
 */
class ArticleController extends \yii\web\Controller {
    public function actionView($link) {
        $article = Articles::findOne(['link_to_article' => $link]);
        $img = Images::findAll(['article_id' => $article->article_id]);        
        return $this->render('article', compact('article', 'img'));
    }
}
