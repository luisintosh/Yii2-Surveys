<?php

namespace app\controllers;

use Yii;
use app\models\AppOptions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class OptionsController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $settings = getAllSettings();
        $post = Yii::$app->request->post();
        
        if (Yii::$app->request->isPost) {
            foreach ($settings as $k => $v) {
                if (is_array($settings[$k]) && $k == 'mailer') {
                    $settings[$k]['mail_server'] = $post[$k]['mail_server'];
                    $settings[$k]['username'] = $post[$k]['username'];
                    $settings[$k]['password'] = $post[$k]['password'];
                    $settings[$k]['port'] = $post[$k]['port'];
                }
                elseif (!is_array($settings[$k])) {
                    $settings[$k] = $post[$k];
                }
            }
            saveAllSettings($settings);
        }

        return $this->render('index', []);
    }

}
