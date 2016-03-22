<?php

namespace app\controllers;

use Yii;
use app\models\Survey;
use app\models\SurveySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\SurveyContacts;
use app\models\SurveyDesign;
use app\models\SurveyPreferences;
use app\models\SurveySection;
use app\models\Question;
use app\models\QuestionOption;

class SurveyController extends \yii\web\Controller
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
        $searchModel = new SurveySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNewSurvey()
    {
        $model = new Survey();
        $model->id_user = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $surveyPref = new SurveyPreferences();
            $surveyPref->id_survey = $model->id;
            $surveyPref->start_at = date('Y-m-d H:i:s');

            $surveyDesign = new SurveyDesign();
            $surveyDesign->id_survey = $model->id;

            if ( $surveyPref->save() && $surveyDesign->save() ) {
                return $this->redirect(['survey/maker', 'id' => $model->getId()]);
            }
            else {
                throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
            }
        }
        else {
            return $this->render('new_survey', [
                'model' => $model,
            ]);
        }
    }

    public function actionMaker($id)
    {
      $model = $this->findModel($id);
      $post = Yii::$app->request->post();

      if (Yii::$app->request->isPost && $model->load($post, $model->formName())) {

          // link data with model
          $model->load($post, $model->formName());
          $model->save();

          Survey::saveMultipleData(SurveySection::className(), $post);
          Survey::saveMultipleData(Question::className(), $post);
          Survey::saveMultipleData(QuestionOption::className(), $post);

          // if is an Pjax request
          if (Yii::$app->request->isPjax && isset($post['action'])) {

              // apply action to model
              $res = Survey::applyAction($post['action']);

              if ($post['action']['type'] === 'publish-survey' && $res) {
                  return $this->redirect(['distribute', 'id' => $model->getId()]);
              }
              else if ($post['action']['type'] === 'delete-survey') {
                  return $this->redirect(['index']);
              }
              else {
                  return $this->render('maker_form', [
                      'model' => $model,
                  ]);
              }
          }

      } else {

          return $this->render('maker', [
              'model' => $model,
          ]);
      }
    }

    public function actionOptions()
    {
        return $this->render('options');
    }

    public function actionDesign()
    {
        return $this->render('design');
    }

    public function actionDistribute($id)
    {
        $model = $this->findModel($id);
        return $this->render('distribute', [
            'model' => $model,
        ]);
    }

    public function actionResults()
    {
        return $this->render('results');
    }

    public function actionView($id)
    {
        return $this->render('view');
    }

    public function actionPrint($id)
    {
        return $this->render('print');
    }

    public function actionSwitchSurvey($id)
    {
        $model = $this->findModel($id);
        $model->status = ($model->status) ? 0 : 1;
        $model->save();

        return $this->redirect(Yii::$app->request->getReferrer());
    }

    /**
     * Deletes an existing Survey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Encuesta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Survey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ((($model = Survey::findOne(Survey::numhash($id))) !== null) && ($model->id_user == Yii::$app->user->id) || ( Yii::$app->user->can('admin') )) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
    }

}
