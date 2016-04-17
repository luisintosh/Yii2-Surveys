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
        $messages[] = $contact->sendInvitation($survey);
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
