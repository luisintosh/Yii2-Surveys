<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ActiveForm;
use app\models\Survey;
use app\models\SurveyDesign;

/* @var $this yii\web\View */
$this->title = Yii::t('app','{title} | Survey Design', ['title'=>$survey->title]);
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

    <h2 class="page-header"><?= Yii::t('app','Survey Design') ?></h2>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="50%"><?= $model->getAttributeLabel('color') ?></td>
                    <td>
                        <div class="input-group colorpicker">
                            <?= Html::input('text', 'SurveyDesign[color]', $model->color, ['class'=>'form-control']) ?>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('font_text') ?></td>
                    <td class="font-text-label"><?= $form->field($model, 'font_text')->dropDownList(SurveyDesign::getAllFonts())->label(false) ?></td>
                </tr>
                <tr>
                    <td><?= $model->getAttributeLabel('background_img') ?></td>
                    <td><?= $form->field($model, 'background_img')->textInput(['placeholder'=>'http://'])->label(false) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <div class="padding15 text-right">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>

<?= $this->registerJsFile('@web/js/survey_pref.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>

<?= $this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto|Oswald|Montserrat|Ubuntu|Fjalla+One|Indie+Flower|Bitter|Lobster|Bree+Serif|Chewy')?>