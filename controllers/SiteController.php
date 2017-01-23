<?php

namespace app\controllers;

use app\models\EntryForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm as Login;
use app\models\Signup;
use app\models\PostsRss;
use app\models\ContactForm;


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
        $model = \app\models\Articles::find()->orderBy('article_create_datetime desc')->all();        
        $ip = '5.101.112.0';
        $geo = $this->geoLock($ip);        
        $artGeo = $this->findArtByGeo($geo);
        print_r ($artGeo);
        return $this->render('index', compact('model', 'geo'));
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
