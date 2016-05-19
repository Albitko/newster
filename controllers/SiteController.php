<?php

namespace app\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Login;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Signup;


//use keltstr\simplehtmldom\SimpleHTMLDom as SHD;//проверил подключение библиотеки
//$html_source = SHD::file_get_html('http://google.com');

class SiteController extends Controller
{

    public function behaviors()
    {
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

    public function actions()
    {
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

    public function actionIndex()
    {

        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных

            return $this->render('index', ['model' => $model]);
        }
    }

    public function actionSignup()
    {
        $model = new Signup();
        if(isset($_POST['Signup']))
        {
            $model->attributes = Yii::$app->request->post('Signup');
            if ($model->validate() && $model->signup())
            {
                return $this->goHome();
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {

            return $this->goHome();
        }

        $login_model= new Login();

        if (Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');

            if ($login_model->validate() )
            {
                Yii::$app->user->login($login_model->getUser());
                $this->goHome();
            }
        }

        return $this->render('login',['login_model' => $login_model]);
    }
    
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();

            return $this->redirect(['login']);
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


    


}
