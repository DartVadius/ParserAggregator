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
use app\models\UsersToTags;
use app\models\ArticlesSearch;
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
        $articles = \app\models\Articles::find()->where(['on_off' => 1])->orderBy('article_create_datetime desc');
        if (!empty($_SESSION['__id'])) {
            $tags_hystory = new UsersToTags();
            $tags = $tags_hystory->searchTagByUser();
            $articles_hystory = new ArticlesSearch();
            $sides_news = $articles_hystory->articlesByUserHystory($tags);
        } else {
            $geo = $this->geoLock('94.244.22.168');
            $sides_news = $this->getGeoData($geo);            
        }
        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', compact('model', 'pages', 'sides_news'));
    }
    public function actionTag($link) {
        $articles = (new \yii\db\Query())
            ->select(['Articles.*'])
            ->from('Articles')
            ->leftJoin('Articles_To_Tags', 'Articles.article_id = Articles_To_Tags.article_id')
            ->leftJoin('Tags', 'Articles_To_Tags.tag_id = Tags.tag_id')
            ->where(['Tags.tag_id' => $link])
            ->groupBy('Articles.article_id')
            ->orderBy('article_create_datetime desc');
        if (!empty($_SESSION['__id'])) {
            $tag = array(array('tag_id' => $link));
            $newTag = new UsersToTags();
            $newTag->addHystory($tag);
        }

        $pages = new Pagination(['totalCount' => $articles->count(), 'pageSize' => 10, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $model = $articles->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('tag', compact('model', 'pages'));
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
                Yii::$app->mailer->compose()
                    ->setFrom('Aggregator2017@gmail.com')
                    ->setTo($user->email)
                    ->setSubject('Регистрация')
//                    ->setTextBody('Текст сообщения')
                    ->setHtmlBody("\n Имя пославшего:".$user->username.
                        "\n email:".$user->email)
                    ->send();
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

    public function actionEntry() {
        $model = new EntryForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
        }
    }
}