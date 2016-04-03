<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::t('app','General Settings');
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>

<?php $form = ActiveForm::begin(); ?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app','WebSite') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th class="text-right config-option"><?= Yii::t('app','Site title') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[1], '[1]id')->hiddenInput() ?>
                                    <?= $form->field($models[1], '[1]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[1], '[1]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Site description') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[2], '[2]id')->hiddenInput() ?>
                                    <?= $form->field($models[2], '[2]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[2], '[2]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Logo URL') ?> <small>(300x100px)</small></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[3], '[3]id')->hiddenInput() ?>
                                    <?= $form->field($models[3], '[3]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[3], '[3]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Anyone can register') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[4], '[4]id')->hiddenInput() ?>
                                    <?= $form->field($models[4], '[4]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[4], '[4]option_value')->radioList(['1'=>Yii::t('app','Yes'), '0'=>Yii::t('app','No')])->label(false) ?>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app','Mail server settings') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Support email') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[5], '[5]id')->hiddenInput() ?>
                                    <?= $form->field($models[5], '[5]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[5], '[5]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right config-option">Host SMTP</th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[6], '[6]id')->hiddenInput() ?>
                                    <?= $form->field($models[6], '[6]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[6], '[6]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Username') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[7], '[7]id')->hiddenInput() ?>
                                    <?= $form->field($models[7], '[7]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[7], '[7]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Password') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[8], '[8]id')->hiddenInput() ?>
                                    <?= $form->field($models[8], '[8]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[8], '[8]option_value')->textInput(['maxlength' => true])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Port') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[9], '[9]id')->hiddenInput() ?>
                                    <?= $form->field($models[9], '[9]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[9], '[9]option_value')->textInput(['maxlength' => true, 'placeholder'=>'587'])->label(false) ?>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app','Social networks') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th class="text-right config-option"><?= Yii::t('app','Facebook URL') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[10], '[10]id')->hiddenInput() ?>
                                    <?= $form->field($models[10], '[10]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[10], '[10]option_value')->textInput(['maxlength' => true, 'placeholder'=>'https://www.facebook.com/me'])->label(false) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Twitter User') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[11], '[11]id')->hiddenInput() ?>
                                    <?= $form->field($models[11], '[11]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[11], '[11]option_value')->textInput(['maxlength' => true, 'placeholder'=>'@me'])->label(false) ?>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app','Analytics') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th class="text-right config-option"><?= Yii::t('app','Google Analytics Tracking ID') ?></th>
                            <th>
                                <div class="hide">
                                    <?= $form->field($models[11], '[10]id')->hiddenInput() ?>
                                    <?= $form->field($models[11], '[10]option_name')->hiddenInput() ?>
                                </div>
                                <?= $form->field($models[11], '[10]option_value')->textInput(['maxlength' => true, 'placeholder'=>'UA-XXXXXXXX'])->label(false) ?>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group text-right">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
