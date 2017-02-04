<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\Articles;
use app\models\ArticlesSearch;
use app\models\UsersToTags;
use yii\data\Pagination;

class CategoryController extends GlobalController {

    public function actionCategory($link) {

        $category = Category::findOne(['id' => $link]);
        $articles = \app\models\Articles::find()->orderBy('article_create_datetime desc')->where("Articles.category_id = $category->id");

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();
        //$ip = '94.244.22.168';
        $geo = $this->geoLock();        
        $geoCity = $this->getGeoData($geo);

        if (!empty($_SESSION['__id'])) {
            
            $tags_hystory = new UsersToTags();
            $tags = $tags_hystory->searchTagByUser();

            $articles_search = new ArticlesSearch();
            $articles_hystory = $articles_search->articlesByUserHystory($tags);
        }

        return $this->render('category', compact('model', 'geoCity', 'pages', 'articles_hystory'));
    }

}
