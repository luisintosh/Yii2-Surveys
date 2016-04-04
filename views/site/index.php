<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = Yii::t('app','Welcome');
?>
<div class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="content site-how-works">
    <h2 class="page-header"><?= Yii::t('app','Create an Online Survey') ?></h2>
    <div class="row">
        <div class="col-md-6">
            <?= Yii::t('app','You can create a survey as soon as you register in the platform and you can add your own style to each of your surveys.') ?>
        </div>
        <div class="col-md-6">
            <?= Html::img('img/site/survey.png',['class'=>'img-responsive']) ?>
        </div>
    </div>

    <h2 class="page-header"><?= Yii::t('app','Mobile-ready Surveys') ?></h2>
    <div class="row">
        <div class="col-md-6">
            <?= Html::img('img/site/responsive_design.jpg',['class'=>'img-responsive']) ?>
        </div>
        <div class="col-md-6">
            <?= Yii::t('app','Responsive Web Design makes your web page look good on all devices (desktops, tablets, and phones), We offer a tool for you to create surveys adaptable to any device.') ?>
        </div>
    </div>

    <h2 class="page-header"><?= Yii::t('app','Data Collection') ?></h2>
    <div class="row">
        <div class="col-md-6">
            <?= Yii::t('app','Reach respondents on all devices. Collect more answers. Publish a survey on your website, send it via e-mail or promote it on Facebook.') ?>
        </div>
        <div class="col-md-6">
            <?= Html::img('img/site/data_collection.png',['class'=>'img-responsive']) ?>
        </div>
    </div>
</div>

