<?php

namespace app\controllers;

use app\models\EntryForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm as Login;
use app\models\Signup;
use app\models\PostsRss;
use app\models\Tags;
use app\models\ContactForm;
use app\models\Category;
use yii\data\Pagination;

class SiteController extends GlobalController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $articles = \app\models\Articles::find()->orderBy('article_create_datetime desc');
        $categories = \app\models\Category::find()->orderBy('id')->all();

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();
        $ip = '94.244.22.168';
        $geo = $this->geoLock($ip);
        $geoCity = $this->findArtByGeo($geo['city']);

        if (count($geoCity) < 10) {
            $geoRegion = $this->findArtByGeo($geo['region']);
            $geoCity = array_merge($geoCity, $geoRegion);
        }
        if (count($geoCity) < 10) {
            $geoCountry = $this->findArtByGeo($geo['country']);
            $geoCity = array_merge($geoCity, $geoCountry);
        }
//print_r($geo);
        return $this->render('index', compact('model', 'categories', 'pages', 'geoCity'));
    }

    public function actionTag($link) {

        $categories = \app\models\Category::find()->orderBy('id')->all();

        $articles = (new \yii\db\Query())
                ->select(['Articles.*'])
                ->from('Articles')
                ->leftJoin('Articles_To_Tags', 'Articles.article_id = Articles_To_Tags.article_id')
                ->leftJoin('Tags', 'Articles_To_Tags.tag_id = Tags.tag_id')
                ->where(['Tags.tag_id' => $link]);

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();        
        return $this->render('tag', compact('model', 'categories', 'pages'));

    }

    public function actionLogin() {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }




//        $model = new Login();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
//            if (Yii::$app->user->getId() == 1) {
//                return $this->redirect('/web/index.php/admin', 302);
//            }elseif(Yii::$app->user->getId() !== 1){
//                return $this->redirect('/web/index.php/user', 302);
//            }else{
//                return $this->goBack();
//            }
//        } else {
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }

        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            if (Yii::$app->user->getId() == 1) {
                return $this->redirect('/admin/sites/', 302);
            } else {
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSignup() {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Displays about page.
     *
     * @return string
     */
//    public function actionAbout()
//    {
//        return $this->render('about');
//    }




    public function actionEntry() {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
        }
    }

//    public function actionParser()
//    {
//        $array = Agregator::getAll();
//        return $this->render('parser', ['array'=>$array]);
//    }
}
