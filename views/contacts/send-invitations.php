<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\ContactList;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Send invitations');


if (Yii::$app->request->isPost && isset(Yii::$app->request->queryParams['contactListID'])) {
    $messages = [];
    $contactListID = Yii::$app->request->queryParams['contactListID'];
    $contacts = ContactList::findOne($contactListID)->getContacts()->all();

    foreach ($contacts as $contact) {
        $messages[] = Yii::$app->mailer->compose()
            ->setFrom(['user@mail.com'=>settings('website_title')])
            ->setTo($contact->contact_email)
            ->setSubject(Yii::t('app', 'You have a new request to answer a survey'))
            ->setTextBody(Yii::t('app', 'You have a new request to answer a survey: {survey_title}, URL: {survey_url}', ['survey_title'=>Html::encode($survey->title),'survey_url'=>\yii\helpers\Url::to(['/survey/results', 'id'=>$survey->getId()])]))
            ->setHtmlBody('
            <h3>'.Yii::t('app', 'You have a new request to answer a survey: {survey_title}', ['survey_title'=>Html::encode($survey->title)]).'</h3>
            '.Html::a(Yii::t('app', 'Click here to answer now'), ['/survey/results', 'id'=>$survey->getId()]));
    }

    try {
        Yii::$app->mailer->sendMultiple($messages);
    }
    catch(Exception $e) {
        d($e);
    }
}

?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<div class="content contact-list-update">

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
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-eye"></i>', ['/contact-manager', 'contactListID'=>$model->id], ['title'=>Yii::t('app','View contacts'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default']);
                    },
                    'select' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-paper-plane"></i>', ['send-invitations', 'surveyID'=>Yii::$app->request->queryParams['surveyID'], 'contactListID'=>$model->id], ['title'=>Yii::t('app','Send invitations to this list'), 'data-toggle'=>'tooltip', 'class'=>'btn btn-default', 'data' => [
                            'confirm' => Yii::t('app','Are you sure you want to send invitations to this list?'),
                            'method' => 'post',
                        ],]);
                    },
                ],
                'template' => '<div class="btn-group" role="group">{view} {select}</div>',
            ],
        ],
    ]); ?>

</div>
