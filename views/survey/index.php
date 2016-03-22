<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\db\Query;

/* @var $this yii\web\View */

$this->title = Yii::t('app','Surveys');
// store user id only it's not an admin
$idIfUser = (Yii::$app->user->can('admin')) ? '' : Yii::$app->user->id;

// init query
$query = (new Query())->select('')->from('survey s')
    ->andFilterWhere(['id_user'=>$idIfUser])
    ->innerJoin('survey_section sc', 'sc.id_survey = s.id')
    ->innerJoin('question q', 'q.id_survey_section = sc.id');

// Total Questions
$totalQuestions = $query;
$totalQuestions = $totalQuestions->select('q.*')->count();

// Total Responses
$query = $query
    ->innerJoin('question_option qo', 'qo.id_question = q.id')
    ->innerJoin('answer a', 'a.id_question_option = qo.id');

$totalResponses = $query;
$totalResponses = $totalResponses->select('a.*')->count();

// Total Responses this Week
$totalResponsesWeek = $query;
$totalResponsesWeek = $totalResponsesWeek->select('a.*')
    ->where(['between', 'a.created_at', date('Y-m-d H:i:s', time()-(7 * 24 * 60 * 60)), date('Y-m-d H:i:s')])
    ->count();

?>
<div class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="content">
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>
              <?= $dataProvider->count?>
          </h3>
          <p><?= Yii::t('app','Total Surveys') ?></p>
          <div class="icon">
            <i class="fa fa-sticky-note"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>
              <?= $totalQuestions ?>
          </h3>
          <p><?= Yii::t('app','Total Questions') ?></p>
          <div class="icon">
            <i class="fa fa-certificate"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $totalResponses ?></h3>
          <p><?= Yii::t('app','Total Responses') ?></p>
          <div class="icon">
            <i class="fa fa-check"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= $totalResponsesWeek ?></h3>
          <p><?= Yii::t('app','Total Responses this Week') ?></p>
          <div class="icon">
            <i class="fa fa-fire"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <p class="col-sm-12 text-right">
            <?= Html::a(Yii::t('app','New Survey'), ['survey/new-survey'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="col-sm-12">
            <div class="box">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function($model, $index, $widget) {
                                return Yii::$app->formatter->asDatetime($model->created_at);
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => 'raw',
                            'value' => function($model, $index, $widget) {
                                return Yii::$app->formatter->asDatetime($model->updated_at);
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filter' => ['1'=>'Enabled','0'=>'Disabled'],
                            'value' => function($model, $index, $widget) {
                                $mdlOptions = ['value' => '0', 'class'=>'js-switch'];
                                if ($model->status) {
                                    $mdlOptions['checked'] = '';
                                }
                                $i = $index-1;
                                return Html::a(Html::checkbox("status[{$index}]", $model->status, $mdlOptions), ['switch-survey', 'id'=>$model->getId()], ['data-method'=>'post']);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-eye"></i>', ['view', 'id'=>$model->getId()], ['title'=>Yii::t('app','View'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                                },
                                'results' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-line-chart"></i>', ['results', 'id'=>$model->getId()], ['title'=>Yii::t('app','Results'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                                },
                                'maker' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-pencil"></i>', ['maker', 'id'=>$model->getId()], ['title'=>Yii::t('app','Edit'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                                },
                                'distribute' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-share"></i>', ['distribute', 'id'=>$model->getId()], ['title'=>Yii::t('app','Distribute'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                                },
                                'delete' => function ($url, $model, $key) {
                                  return Html::a('<i class="fa fa-trash"></i>', ['delete', 'id'=>$model->getId()], ['title'=>Yii::t('app','Delete'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default', 'data' => [
                                      'confirm' => Yii::t('app','Are you sure you want to delete profile?'),
                                      'method' => 'post',
                                  ],]);
                                },
                            ],
                            'template' => '<div class="btn-group" role="group">{view} {results} {maker} {distribute} {delete}</div>',
                        ],
                        ['class' => 'yii\grid\CheckboxColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>


</div>

<?= $this->registerJsFile('@web/js/survey_index.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>