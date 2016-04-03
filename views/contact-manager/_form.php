<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
    '$("document").ready(function(){
        $("#new_contact").on("pjax:end", function() {
            $.pjax.reload({container:"#contacts"});  //Reload GridView
        });
    });'
);
?>

<div class="contact-form">

    <?php yii\widgets\Pjax::begin(['id' => 'new_contact']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

    <?= $form->field($model, 'id_contact_list')->hiddenInput(['value'=>Yii::$app->request->queryParams['contactListID']])->label(false) ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
