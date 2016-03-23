<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;
use app\models\Survey;

/* @var $this yii\web\View */
$this->title = Yii::t('app','{title} | Survey Preferences', ['title'=>$survey->title]);
?>
<section class="content-header">
    <h1><?= Html::encode($survey->title) ?></h1>
</section>
<div class="content">

    <?=
    Menu::widget([
        'options' => ['class'=>'nav nav-pills nav-justified'],
        'items' => [
            ['label'=>Yii::t('app','Maker'), 'url'=>['/survey/maker', 'id'=>$survey->getId()]],
            ['label'=>Yii::t('app','Preferences'), 'url'=>['/survey/preferences', 'id'=>$survey->getId()]],
            ['label'=>Yii::t('app','Design'), 'url'=>['/survey/design', 'id'=>$survey->getId()]],
        ],
    ]);
    ?>

    <?php $form = ActiveForm::begin(['id' => 'prefsurvey',]); ?>

    <h2 class="page-header"><?= Yii::t('app','Survey Preferences') ?></h2>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="50%"><?= Yii::t('app','Survey duration') ?></td>
                    <td>
                        <div class="form-inline">
                            <div class="form-group">
                                <strong><?= Yii::t('app', 'From ') ?></strong>
                                <?php
                                $fromDate = Yii::$app->formatter->asDatetime($model->start_at, 'php:Y/m/d H:i:s');
                                echo Html::input('text', 'start_at', $fromDate, ['class'=>'form-control']);
                                ?>
                                <strong><?= Yii::t('app', ' To ') ?></strong>
                                <?php
                                $toDate = ($model->end_at) ? Yii::$app->formatter->asDatetime($model->end_at, 'php:Y/m/d H:i:s') : '';
                                echo Html::input('text', 'end_at', $toDate, ['class'=>'form-control', 'placeholder'=>'?']);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('sections_per_page') ?></td>
                    <td>
                        <span id="sections_per_page">
                            <?= $form->field($model, 'sections_per_page')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?>
                        </span>
                    </td>
                </tr>
                <tr id="questions_per_page" style="display: <?= ($model->sections_per_page) ? 'table-row' : 'none' ?>">
                    <td><?= $model->getAttributeLabel('questions_per_page') ?></td>
                    <td><?= $form->field($model, 'questions_per_page')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('allow_multi_submissions') ?></td>
                    <td><?= $form->field($model, 'allow_multi_submissions')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('show_question_number') ?></td>
                    <td><?= $form->field($model, 'show_question_number')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('randomize_questions') ?></td>
                    <td><?= $form->field($model, 'randomize_questions')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('show_progress') ?></td>
                    <td><?= $form->field($model, 'show_progress')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('send_response_notif') ?></td>
                    <td><?= $form->field($model, 'send_response_notif')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('show_share_btns') ?></td>
                    <td><?= $form->field($model, 'show_share_btns')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('password_protect') ?></td>
                    <td>
                        <span id="password_protect">
                            <?= $form->field($model, 'password_protect')->checkbox(['label'=>false,'class'=>'js-switch'])->label(false) ?>
                        </span>
                    </td>
                </tr>
                <tr id="password_string" style="display: <?= ($model->password_protect) ? 'table-row' : 'none' ?>">
                    <td><?= $model->getAttributeLabel('password_string') ?></td>
                    <td><?= $form->field($model, 'password_string')->textInput(['placeholder'=>Yii::t('app','Password')])->label(false) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="page-header"><?= Yii::t('app','Survey Exit Action') ?></h2>
    <div class="row">
        <div class="col-md-12">
            <p>
                <?= $model->getAttributeLabel('end_text') ?>
            </p>
            <div class="wysihtml5-editor">
                <?= $form->field($model, 'end_text')->textarea()->label(false) ?>
            </div>
        </div>
        <div class="col-md-12">
            <p>
                <?= $model->getAttributeLabel('end_redirect') ?>
            </p>
            <p>
                <?= $form->field($model, 'end_redirect')->textInput(['placeholder'=>Yii::t('app','http://')])->label(false) ?>
            </p>
        </div>
    </div>

    <br>
    <div class="padding15 text-right">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>

<?= $this->registerJsFile('@web/js/survey_pref.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>