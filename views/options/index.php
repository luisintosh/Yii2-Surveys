<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

/* Global function */
$settings = getAllSettings();

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
                                <?= Html::input('text','website_title',settings('website_title'), ['class'=>'form-control']) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Site description') ?></th>
                            <th>
                                <?= Html::input('text','website_description',settings('website_description'), ['class'=>'form-control']) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Logo URL') ?> <small>(300x100px)</small></th>
                            <th>
                                <?= Html::input('text','website_logo',settings('website_logo'), ['class'=>'form-control']) ?>
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
                            <th class="text-right config-option">Host SMTP</th>
                            <th>
                                <?= Html::input('text','mailer[mail_server]',settings('mailer')['mail_server'], ['class'=>'form-control']) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Username') ?></th>
                            <th>
                                <?= Html::input('text','mailer[username]',settings('mailer')['username'], ['class'=>'form-control']) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Password') ?></th>
                            <th>
                                <?= Html::input('password','mailer[password]',settings('mailer')['password'], ['class'=>'form-control']) ?>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-right"><?= Yii::t('app','Port') ?></th>
                            <th>
                                <?= Html::input('text','mailer[port]',settings('mailer')['port'], ['class'=>'form-control']) ?>
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
                                <?= Html::input('text','google_analytics_id',settings('google_analytics_id'), ['class'=>'form-control']) ?>
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
