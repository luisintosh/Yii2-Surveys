<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\swiftmailer\Message;
use yii\widgets\ActiveForm;
use app\models\Survey;
use app\models\SurveyPreferences;
use app\models\QuestionExtraitem;
use app\models\QuestionOption;
use app\models\InterviewAnswer;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $survey app\models\Survey */
/* @var $interview app\models\Interview */
/* @var $preferences app\models\SurveyPreferences */

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
                    <?= $preferences->end_text ?>

                    <p class="fa-lg"><i class="fa fa-check fa-5x"></i></p>
                </div>

                <?php if ($preferences->show_share_btns): ?>
                <div class="col-lg-12 text-center survey-margin">
                    <div class="share-box addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?= Url::to(['survey/view', 'id'=>$survey->getId()], true) ?>" addthis:title="<?= Html::encode($survey->title) ?>">
                        <a class="addthis_button_facebook"></a>
                        <a class="addthis_button_twitter"></a>
                        <a class="addthis_button_google_plusone_share"></a>
                        <a class="addthis_button_tumblr"></a>
                        <a class="addthis_button_linkedin"></a>
                        <a class="addthis_button_compact"></a>
                    </div>
                </div>
                <?php endif ?>

                <?php if (! empty($preferences->end_redirect) ): ?>
                    <div class="col-lg-12 survey-margin">
                        <p class="text-muted">
                            <?= Yii::t('app', 'You will be redirected to {website_url} in ', ['website_url'=>$preferences->end_redirect]) ?>
                            <span id="time-redirect">0</span>
                        </p>
                    </div>

                    <script>
                        function startTimer(duration, display, redirectUrl) {
                            var timer = duration, minutes, seconds;
                            var interval = setInterval(function () {
                                minutes = parseInt(timer / 60, 10);
                                seconds = parseInt(timer % 60, 10);

                                minutes = minutes < 10 ? "0" + minutes : minutes;
                                seconds = seconds < 10 ? "0" + seconds : seconds;

                                display.textContent = minutes + ":" + seconds;

                                if (--timer < 0) {
                                    location.href = redirectUrl;
                                    clearInterval(interval);
                                }
                            }, 1000);
                        }

                        var timeSeconds = 5,
                            container = document.querySelector('#time-redirect');

                        startTimer(timeSeconds, container, '<?= $preferences->end_redirect ?>');
                    </script>
                <?php endif ?>

                <div class="col-lg-12 text-center">
                    <div class="survey-footer survey-bar survey-margin"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
// Allow multiple submissions
$cookies = Yii::$app->response->cookies;
if (! ($preferences->allow_multi_submissions)) {
    $cookies->add(new \yii\web\Cookie([
        'name' => 'unique',
        'value' => $interview->unique,
    ]));

} else {
    unset($cookies['unique']);
}

// Receive response notifications by e-mail
if ($preferences->send_response_notif) {
    try {
        $preferences->sendResponseNotification(User::findOne($survey->id_user)->email, $survey);
    }
    catch(Exception $e) {
        d($e);
    }
}
?>
