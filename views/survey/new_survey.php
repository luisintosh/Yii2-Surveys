<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = Yii::t('app','Create new survey');
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>

<?php $form = ActiveForm::begin() ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $model->getAttributeLabel('title') ?></h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'title')->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <?= Html::submitButton(Yii::t('app','Next'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>
