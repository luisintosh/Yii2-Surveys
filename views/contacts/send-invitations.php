<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use app\models\ContactList;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Send invitations');


if ($sendMails) {

    $this->registerCss('#loading {display:block};');
    $messages = [];
    $contacts = ContactList::findOne($surveyContacts->id_contact_list)->getContacts()->all();

    foreach ($contacts as $contact) {
        $messages[] = $contact->sendInvitation($survey, $surveyContacts);
    }

    $message = '';
    try {
        Yii::$app->mailer->sendMultiple($messages);

        $messages = Yii::t('app','All emails have been submitted successufully!');
        $this->registerCss('#loading {display:none};');
    }
    catch(Exception $e) {
        //d($e);
        $messages = Yii::t('app','Could not send emails');
        $this->registerCss('#loading {display:none};');
    }

    $this->registerJs("alert('{$messages}');", $this::POS_END);
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
                        return Html::a('<i class="fa fa-paper-plane"></i>', ['send-invitations', 'surveyID'=>Yii::$app->request->queryParams['surveyID'], 'contactListID'=>$model->id], ['title'=>Yii::t('app','Send invitations to this list'), 'data-toggle'=>'tooltip', 'data-contactlist'=>$model->id, 'class'=>'btn btn-default btn-sendmail',]);
                    },
                ],
                'template' => '<div class="btn-group" role="group">{view} {select}</div>',
            ],
        ],
    ]); ?>

</div>

<div id="modal-sendmail" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('app','Compose e-mail') ?></h4>
      </div>
      <?php $form = ActiveForm::begin(); ?>
      <div class="modal-body">
        <div class="hide">
            <?= $form->field($surveyContacts, 'id_survey')->textInput(['value'=>$survey->id]) ?>
            <?= $form->field($surveyContacts, 'id_contact_list') ?>
        </div>
        <p>
            <?= $form->field($surveyContacts, 'mail_subject')->textInput(['value'=>Yii::t('app', 'You have a new request to answer a survey: {survey_title}', ['survey_title' => Html::encode($survey->title)])]) ?>
        </p>
        <div class="wysihtml5-editor">
            <?= $form->field($surveyContacts, 'mail_message')->textArea(['rows' => 5]) ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" id="btn-sendmail-form" class="btn btn-primary" value="<?= Yii::t('app','Submit') ?>"></input>
      </div>
      <?php ActiveForm::end(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->