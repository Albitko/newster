<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MailerForm; //добавляемая строка

class MailController extends Controller
{
//…существующий код…
    public function actionMailer()
    {
        $model = new MailerForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendEmail()) {
            Yii::$app->session->setFlash('mailerFormSubmitted');
            return $this->refresh();
        }
        return $this->render('mailer', [
            'model' => $model,
        ]);
    }
//…существующий код…
}