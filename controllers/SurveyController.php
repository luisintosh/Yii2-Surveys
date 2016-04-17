<?php

namespace app\controllers;

use app\models\InterviewAnswer;
use app\models\QuestionExtraitem;
use Yii;
use app\models\Survey;
use app\models\SurveySearch;
use app\models\Result;
use app\models\ResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;

use app\models\SurveyContacts;
use app\models\SurveyDesign;
use app\models\SurveyPreferences;
use app\models\SurveySection;
use app\models\Question;
use app\models\QuestionOption;
use app\models\Interview;

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
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?'],
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
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            if ( $model->doPreferencesNDesign() ) {
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
          Survey::saveMultipleData(QuestionExtraitem::className(), $post);

          // if is an Pjax request
          if (Yii::$app->request->isPjax && isset($post['action'])) {

              // apply action to model
              $resp = Survey::applyAction($post['action']);

              if ($post['action']['type'] === 'publish-survey' && $resp) {
                  Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Published!'));
                  return $this->redirect(['distribute', 'id' => $model->getId()]);
              }
              else if ($post['action']['type'] === 'delete-survey') {
                  Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deleted!'));
                  return $this->redirect(['index']);
              }
              else {
                  if ($resp) Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved!'));
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

    public function actionPreferences($id)
    {
        $survey = $this->findModel($id);
        $model = $survey->surveyPreferences[0];
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $model->start_at = Yii::$app->formatter->asTimestamp($post['start_at']);
            $model->end_at = Yii::$app->formatter->asTimestamp($post['end_at']);
            $model->save();

            if ( $model->save() ) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved!'));
            }
        }

        return $this->render('preferences', [
            'survey' => $survey,
            'model' => $model,
        ]);
    }

    public function actionDesign($id)
    {
        $survey = $this->findModel($id);
        $model = $survey->surveyDesigns[0];
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved!'));
        }

        return $this->render('design', [
            'survey' => $survey,
            'model' => $model,
        ]);
    }

    public function actionDistribute($id)
    {
        $model = $this->findModel($id);
        return $this->render('distribute', [
            'model' => $model,
        ]);
    }

    public function actionView($id, $u=null, $email=null)
    {
        //$survey = $this->findModel($id);
        $survey = null;
        if (($survey = Survey::findOne(Survey::numhash($id))) == null) {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
        $interview = Interview::find()->where(['unique'=>$u])->one();
        $post = Yii::$app->request->post();
        $surveySent = false;
        $preferences = $survey->getSurveyPreferences()->one();
        $today = Yii::$app->formatter->asTimestamp(time());

        if ( !($today >= $preferences->start_at) || (!empty($preferences->end_at) && !($today <= $preferences->end_at)) ) {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }

        if ($interview == null) {
            $interview = Interview::createInterview($survey->id, $email);
            if ($interview->save()) {
                $interview->unique = md5($interview->id . $interview->id_survey);
                $interview->save();
                $this->redirect(['view', 'id'=>$id, 'u'=>$interview->unique]);
            }
        }

        if (Yii::$app->request->isPost && $interview->load($post, $interview->formName())) {
            $resp = Survey::saveMultipleData(InterviewAnswer::className(), $post, true);

            if ($resp[0]) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Sent!'));
                $surveySent = true;
            }
        }

        return $this->renderPartial('view', [
            'survey' => $survey,
            'interview' => $interview,
            'surveySent' => $surveySent,
        ]);

    }

    public function actionResults($id)
    {
        $survey = $this->findModel($id);

        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $survey->id);

        return $this->render('results', [
            'survey' => $survey,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        if ((($model = Survey::findOne(Survey::numhash($id))) !== null) && (($model->id_user == Yii::$app->user->id) || ( Yii::$app->user->can('admin')) )) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
    }

}
