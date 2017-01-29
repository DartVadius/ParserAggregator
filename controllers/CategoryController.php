<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\Articles;
use yii\data\Pagination;

class CategoryController extends GlobalController {

    public function actionCategory($link) {

        $category = Category::findOne(['id' => $link]);
        $articles = \app\models\Articles::find()->orderBy('article_create_datetime desc')->where("Articles.category_id = $category->id");

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();
        $ip = '5.101.112.0';
        $geo = $this->geoLock($ip);
        $artGeo = $this->findArtByGeo($geo);

        return $this->render('category', compact('model', 'geo', 'pages'));
    }

}
