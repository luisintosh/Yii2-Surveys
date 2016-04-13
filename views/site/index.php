<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = Yii::t('app','Welcome');
?>
<div id="carousel-home" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-home" data-slide-to="1"></li>
        <li data-target="#carousel-home" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <?= Html::img('img/slide/people-woman-girl-macbook.jpg') ?>
            <div class="carousel-caption">
                <h2><?= Yii::t('app','Create Free Survey') ?></h2>
                <p class="lead"><?= Yii::t('app','Easy-to-use survey software for Customer Satisfaction, Employee Feedback, Market Research and other online questionnaires.') ?></p>
            </div>
        </div>
        <div class="item">
            <?= Html::img('img/slide/people-coffee-tea-meeting.jpg') ?>
            <div class="carousel-caption">
                <h2><?= Yii::t('app','Create surveys easily, get answers fast') ?></h2>
                <p class="lead"><?= Yii::t('app','Build a survey with our software and Share it via link, e-mail or social media.') ?></p>
            </div>
        </div>
        <div class="item">
            <?= Html::img('img/slide/man-people-space-desk.jpg') ?>
            <div class="carousel-caption">
                <h2><?= Yii::t('app','Create attractive surveys') ?></h2>
                <p class="lead"><?= Yii::t('app','Collects and organizes all kinds of information with our software and for free.') ?></p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only"><?= Yii::t('app','Previous') ?></span>
    </a>
    <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only"><?= Yii::t('app','Next') ?></span>
    </a>
</div>

<div class="container-fluid white-box">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?= Html::img('img/site/data_collection.png',['class'=>'img-responsive']) ?>
            </div>
            <div class="col-md-6">
                <div class="lead">
                    <h3>Get the answers at the time</h3>
                    <p>
                        Plan your next camping trip, manage event registrations, prepares a quick poll, collect email addresses for a newsletter, create a quiz and more.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid default-box">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="lead">
                    <h3><?= Yii::t('app','Mobile-ready Surveys') ?></h3>
                    <p>
                        <?= Yii::t('app','Responsive Web Design makes your web page look good on all devices (desktops, tablets, and phones), We offer a tool for you to create surveys adaptable to any device.') ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <?= Html::img('img/site/responsive-design.png',['class'=>'img-responsive']) ?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid white-box">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?= Html::img('img/site/survey.png',['class'=>'img-responsive']) ?>
            </div>
            <div class="col-md-6">
                <div class="lead">
                    <h3><?= Yii::t('app','Create an Online Survey') ?></h3>
                    <p>
                        <?= Yii::t('app','You can create a survey as soon as you register in the platform and you can add your own style to each of your surveys.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>