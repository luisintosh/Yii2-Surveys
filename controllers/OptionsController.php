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
        $post = Yii::$app->request->post();
        $models = AppOptions::find()->all();

        if (Yii::$app->request->isPost) {
            AppOptions::saveMultipleData(AppOptions::className(), $post);
            return $this->redirect(['options/index']);
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }

}
