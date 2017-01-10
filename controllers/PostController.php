<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\PostsRss;

class PostController extends Controller
{
    public function actionIndex(){
        $model = PostsRss::find()->all();
        return $this->render('index', ['model'=>$model]);
    }
}