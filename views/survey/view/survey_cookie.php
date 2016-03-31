<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Survey;
use app\models\SurveyPreferences;
use app\models\QuestionExtraitem;
use app\models\QuestionOption;
use app\models\InterviewAnswer;

/* @var $this yii\web\View */
/* @var $survey app\models\Survey */
/* @var $interview app\models\Interview */

$preferences = $survey->getSurveyPreferences()->one();
?>
<section class="middle-area">
    <div class="container">
        <div id="survey-container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="survey-header survey-bar survey-margin"></div>
                </div>

                <div class="col-lg-12 text-center survey-margin font-theme">
                    <p class="fa-lg"><i class="fa fa-info-circle fa-5x"></i></p>
                    <h2><?= Yii::t('app', 'You\'ve already answered this survey, thanks!') ?></h2>
                </div>

                <div class="col-lg-12 text-center">
                    <div class="survey-footer survey-bar survey-margin"></div>
                </div>
            </div>
        </div>
    </div>
</section>
