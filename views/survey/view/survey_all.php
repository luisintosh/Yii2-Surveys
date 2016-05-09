<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Survey;
use app\models\SurveyPreferences;
use app\models\QuestionExtraitem;
use app\models\QuestionOption;
use app\models\InterviewAnswer;

use app\models\GroupType;

/* @var $this yii\web\View */
/* @var $survey app\models\Survey */
/* @var $interview app\models\Interview */
/* @var $preferences app\models\SurveyPreferences */
/* @var $questionOptions app\models\QuestionOption */
/* @var $form yii\widgets\ActiveForm */

// keys
$sectionN = 0;
$questionN = 0;
$optionN = 0;

// get all sections
$sections = $survey->getSurveySections()->all();

// get preferences
$preferences = $survey->getSurveyPreferences()->one();
?>

<?php $form = ActiveForm::begin(); ?>
<section class="middle-area">
    <div class="container">
        <div id="survey-container">
            <div id="interview-data" class="hide">
                <?= $form->field($interview, 'id')->hiddenInput() ?>
                <?= $form->field($interview, 'id_survey')->hiddenInput() ?>
                <?= $form->field($interview, 'unique')->hiddenInput() ?>
                <?= $form->field($interview, 'contact_email')->hiddenInput() ?>
                <?= $form->field($interview, 'refer_url')->hiddenInput() ?>
                <?= $form->field($interview, 'country')->hiddenInput() ?>
                <?= $form->field($interview, 'web_browser')->hiddenInput() ?>
                <?= $form->field($interview, 'ip_address')->hiddenInput() ?>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="survey-header survey-bar survey-margin"></div>
                </div>
                <br>
                <div class="survey-content"> 
                    <div class="survey-margin">
                        <?= $survey->description ?>
                    </div>
                </div>
                <?php foreach ($sections as $section): ?>
                    <div class="col-lg-12">
                        <div class="survey-content">
                            <div class="survey-section section-<?= ++$sectionN ?>">
                                <div class="survey-section-header">
                                    <h2 class="survey-margin bgcolor-theme font-theme">
                                        <small><?= $sectionN ?>/<?= count($sections) ?></small>
                                        <?= $section->title ?>
                                    </h2>
                                    <div class="survey-margin"><?= $section->description ?></div>
                                </div>

                                <?php
                                $questions = $section->getQuestions()->all();
                                if ($preferences->randomize_questions) {
                                    shuffle($questions);
                                }
                                foreach ($questions as $question):
                                    ?>
                                    <div class="survey-question question-<?= ++$questionN ?> survey-margin">
                                        <?php
                                        $questionExtras = QuestionExtraitem::find()->where(['id_question'=>$question->id])->one();
                                        ?>
                                        <div class="survey-question-title">
                                            <h3 class="font-theme">
                                                <?php if ($preferences->show_question_number): ?>
                                                    <small><?= $questionN ?></small>
                                                <?php endif ?>
                                                <?= $question->title ?>
                                            </h3>
                                            <?php if(! empty($questionExtras->tip)): ?>
                                                <i class="fa fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="<?= $questionExtras->tip ?>"></i>
                                            <?php endif ?>
                                        </div>
                                        <div class="survey-question-extra">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= (! empty($questionExtras->image_url)) ? Html::img($questionExtras->image_url, ['class'=>'img-responsive']) : '' ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php if (! empty($questionExtras->video_yt)): ?>
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item" src="<?= $questionExtras->video_yt ?>" frameborder="0" allowfullscreen></iframe>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                                <div class="col-lg-12">
                                                    <?php if (! empty($questionExtras->soundcloud_url)): ?>
                                                        <iframe width="100%" height="80" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?= Html::encode($questionExtras->soundcloud_url) ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="survey-answers">
                                            <?php
                                            $questionOptions = $question->getQuestionOptions()->all();
                                            ?>

                                            <div class="row answer-container">
                                                <?php if ($question->id_group_type == GroupType::$TEXT_ANSWER): ?>
                                                    <div class="hidden">
                                                        <?php
                                                        ++$optionN;
                                                        $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $questionOptions[1]->id);
                                                        echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                        echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?= $form->field($answer, "[{$optionN}]".'a_text')->textInput()->label(false) ?>
                                                    </div>


                                                <?php elseif ($question->id_group_type == GroupType::$TEXT_BLOCK_ANSWER): ?>
                                                    <div class="hidden">
                                                        <?php
                                                        ++$optionN;
                                                        $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $questionOptions[1]->id);
                                                        echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                        echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?= $form->field($answer, "[{$optionN}]".'a_text')->textarea()->label(false) ?>
                                                    </div>


                                                <?php elseif ($question->id_group_type == GroupType::$NUMBER_ANSWER): ?>
                                                    <div class="hidden">
                                                        <?php
                                                        ++$optionN;
                                                        $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $questionOptions[1]->id);
                                                        echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                        echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?= $form->field($answer, "[{$optionN}]".'a_number')->textInput()->label(false) ?>
                                                    </div>


                                                <?php elseif ($question->id_group_type == GroupType::$SINGLE_CHOICE): ?>
                                                    <?php
                                                    ++$optionN;
                                                    $answer = new InterviewAnswer();
                                                    $answer->id_interview = $interview->id;
                                                    $answer->id_question = $question->id;

                                                    $options = [];
                                                    foreach ($questionOptions as $option) {
                                                        if (($option->title != QuestionOption::$other_option_id) || ($option->title == QuestionOption::$other_option_id && $question->add_textbox)) {
                                                            $options[$option->id] = $option->title;
                                                        }
                                                    }

                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);

                                                    $GLOBALS['tempQ'] = ['id_interview'=>$interview->id, 'id_question'=>$question->id];
                                                    echo $form->field($answer, "[{$optionN}]".'a_text')->radioList($options, [
                                                        'class' => 'radio-options',
                                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                            $answer = InterviewAnswer::find()->where(['id_interview'=>$GLOBALS['tempQ']['id_interview'], 'id_question'=>$GLOBALS['tempQ']['id_question'], 'id_question_option'=>$value])->one();
                                                            $val = $label;
                                                            if (isset($answer->a_text)) {
                                                                $val = $answer->a_text;
                                                                $checked = ($answer->a_text = $label);
                                                            }
                                                            $res = '';
                                                            $OtherOption = false;
                                                            if ($label == QuestionOption::$other_option_id) {
                                                                $val = '';
                                                                $label = Yii::t('app','Other');
                                                                $OtherOption = true;
                                                            }
                                                            $res .= Html::radio($name, $checked, ['value' =>$val, 'data-id'=>$value, 'label'=>$label, 'class'=>'radio-btn', 'data-other'=>$OtherOption]);
                                                            return $res;
                                                        },
                                                    ])->label(false);
                                                    unset($GLOBALS['tempQ']);
                                                    ?>
                                                    <?php if ($question->add_textbox): ?>
                                                        <div class="col-lg-12 form-inline text-right other-option-box">
                                                            <div class="form-group">
                                                                <label><?= Yii::t('app','Other: ') ?></label>
                                                                <input type="text" class="form-control other-option-text" placeholder="<?= Yii::t('app','Your answer') ?>">
                                                            </div>
                                                        </div>
                                                    <?php endif ?>


                                                <?php elseif ($question->id_group_type == GroupType::$MULTIPLE_CHOICE): ?>
                                                    <?php
                                                    foreach ($questionOptions as $option):
                                                        if ($option->title != QuestionOption::$other_option_id):
                                                            ++$optionN;
                                                            $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $option->id);
                                                            ?>
                                                            <div class="col-md-3 answer-container">
                                                                <?php
                                                                echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                                echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);

                                                                echo $form->field($answer, "[{$optionN}]".'a_text')->checkbox([
                                                                    'uncheck'=>'*/',
                                                                    'value'=>$option->title
                                                                ], false)->label($option->title);
                                                                ?>
                                                            </div>
                                                            <?php
                                                        endif;
                                                    endforeach; ?>

                                                <?php elseif ($question->id_group_type == GroupType::$LINEAR_SCALE): ?>
                                                    <div class="col-lg-12 answer-container">
                                                        <table class="table table-bordered table-hover table-responsive">
                                                            <tbody>
                                                            <?php
                                                            ++$optionN;
                                                            $answer = new InterviewAnswer();
                                                            $answer->id_interview = $interview->id;
                                                            $answer->id_question = $question->id;
                                                            echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                            echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                            ?>

                                                            <tr>
                                                                <?php
                                                                $radioOptions = [];
                                                                foreach ($questionOptions as $option) {
                                                                    if ($option->title != QuestionOption::$other_option_id) {
                                                                        $radioOptions[$option->id] = $option->title;

                                                                        echo '<td class="text-center">';
                                                                        echo $option->title;
                                                                        echo '</td>';
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr class="active">
                                                                <?php
                                                                $GLOBALS['tempQ'] = ['id_interview'=>$interview->id, 'id_question'=>$question->id];
                                                                echo $form->field($answer, "[{$optionN}]".'a_text')->radioList($radioOptions, [
                                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                                        $answer = InterviewAnswer::find()->where(['id_interview'=>$GLOBALS['tempQ']['id_interview'], 'id_question'=>$GLOBALS['tempQ']['id_question'], 'id_question_option'=>$value])->one();
                                                                        $val = $label;
                                                                        if (isset($answer->a_text)) {
                                                                            $val = $answer->a_text;
                                                                            $checked = ($answer->a_text = $label);
                                                                        }
                                                                        $res = '';

                                                                        $res .= '<td class="text-center">';
                                                                        $res .= Html::radio($name, $checked, ['value' =>$val, 'data-id'=>$value, 'class'=>'radio-btn']);
                                                                        $res .= '</td>';
                                                                        return $res;
                                                                    },
                                                                ])->label(false);
                                                                unset($GLOBALS['tempQ']);
                                                                 ?>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                <?php elseif ($question->id_group_type == GroupType::$TRUE_FALSE): ?>
                                                    <?php
                                                    ++$optionN;
                                                    $answer = new InterviewAnswer();
                                                    $answer->id_interview = $interview->id;
                                                    $answer->id_question = $question->id;

                                                    $options = [];
                                                    foreach ($questionOptions as $option) {
                                                        if (($option->title != QuestionOption::$other_option_id) || ($option->title == QuestionOption::$other_option_id && $question->add_textbox)) {
                                                            $options[$option->id] = $option->title;
                                                        }
                                                    }

                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                    echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);

                                                    $GLOBALS['tempQ'] = ['id_interview'=>$interview->id, 'id_question'=>$question->id];
                                                    echo $form->field($answer, "[{$optionN}]".'a_bool')->radioList($options, [
                                                        'class' => 'radio-options',
                                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                            $answer = InterviewAnswer::find()->where(['id_interview'=>$GLOBALS['tempQ']['id_interview'], 'id_question'=>$GLOBALS['tempQ']['id_question'], 'id_question_option'=>$value])->one();

                                                            $val = $label;
                                                            if (isset($answer->a_bool)) {
                                                                $val = $answer->a_bool;
                                                                $checked = ($index == 0 && $answer->a_bool == 1) || ($index == 1 && $answer->a_bool == 0);
                                                            }
                                                            $button = ($index == 0) ? '<span class="btn btn-block btn-default"><i class="fa fa-check"></i></span>'
                                                                : '<span class="btn btn-block btn-default"><i class="fa fa-times"></i></span>';
                                                            $res = Html::radio($name, $checked, ['value' =>($index == 0) ? 1 : 0, 'data-id'=>$value,
                                                                'label'=>$button, 'class'=>'radio-btn']);
                                                            return $res;
                                                        },
                                                    ])->label(false);
                                                    unset($GLOBALS['tempQ']);
                                                    ?>

                                                <?php elseif ($question->id_group_type == GroupType::$DATE_FIELD): ?>
                                                    <div class="hidden">
                                                        <?php
                                                        ++$optionN;
                                                        $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $questionOptions[1]->id);
                                                        echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                        echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?= $form->field($answer, "[{$optionN}]".'a_date')->textInput(['class'=>'form-control datepicker'])->label(false) ?>
                                                    </div>

                                                <?php elseif ($question->id_group_type == GroupType::$TIME_FIELD): ?>
                                                    <div class="hidden">
                                                        <?php
                                                        ++$optionN;
                                                        $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $questionOptions[1]->id);
                                                        echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                        echo $form->field($answer, "[{$optionN}]".'id_question_option')->hiddenInput(['class'=>'form-control id-question-option'])->label(false);
                                                        echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?= $form->field($answer, "[{$optionN}]".'a_time')->textInput(['class'=>'form-control timepicker'])->label(false) ?>
                                                    </div>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

                <div class="survey-margin survey-btns">
                    <div class="col-lg-4">
                        <?php if($preferences->sections_per_page || $preferences->questions_per_page): ?>
                            <?= Html::button(Yii::t('app', 'Previous'), ['id'=>'previous-btn', 'class'=>'btn btn-block btn-lg btn-default bgcolor-theme font-theme btn-submit']) ?>
                        <?php endif ?>
                    </div>
                    <div class="col-lg-4">
                        <?php if($preferences->sections_per_page || $preferences->questions_per_page): ?>
                            <?= Html::button(Yii::t('app', 'Next'), ['id'=>'next-btn', 'class'=>'btn btn-block btn-lg btn-default bgcolor-theme font-theme btn-submit']) ?>
                        <?php endif ?>
                    </div>

                    <div class="col-lg-4">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['id'=>'submit-btn', 'class'=>'btn btn-block btn-lg btn-default bgcolor-theme font-theme btn-submit']) ?>
                    </div>
                </div>

                <div class="col-lg-12 text-center">
                    <div class="survey-footer survey-bar survey-margin"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php ActiveForm::end(); ?>


<?php
if ($preferences->questions_per_page) {
    $this->registerJs('showByQuestions();', $this::POS_END);
} else if($preferences->sections_per_page) {
    $this->registerJs('showBySections();', $this::POS_END);
}
?>
