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
    $this->render('survey_maker_menu', [
            'survey'=>$survey,
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
                        <div class="row">
                            <?= $form->field($model, 'color')->radioList(SurveyDesign::getAllColors(), [
                                'item' => function($index, $label, $name, $checked, $value) {

                                    $checkedAttr = ($checked) ? 'checked' : '';
                                    $return = '<label class="col-sm-1 col-md-2 text-center">';
                                    $return .= '<input type="radio" class="hide" name="' . $name . '" value="' . $value . '" '. $checkedAttr .'>';
                                    $return .= '<div class="circle" style="background:'. $label .'"></div>';
                                    $return .= '</label>';

                                    return $return;
                                }
                            ])->label(false) ?>
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