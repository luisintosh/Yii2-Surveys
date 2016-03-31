<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Survey;
use app\models\SurveyPreferences;
use app\models\QuestionExtraitem;
use app\models\QuestionOption;
use app\models\InterviewAnswer;

/* @var $this yii\web\View */
/* @var $survey app\models\Survey */
/* @var $interview app\models\Interview */
/* @var $preferences app\models\SurveyPreferences */
/* @var $qOptions app\models\QuestionOption */
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
                                                $qOptions = $question->getQuestionOptions()->all();
                                                ?>

                                                <div class="row">
                                                    <?php if ($question->id_group_type == 1): ?>
                                                        <!-- short_answer -->
                                                        <?php
                                                        foreach ($qOptions as $qOption):
                                                            if ($qOption->title != QuestionOption::$other_option_id):
                                                                $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                                ?>
                                                                <div class="col-md-6 answer-container">
                                                                    <div class="answer-title"><?= $qOption->title ?></div>
                                                                    <?php
                                                                    ++$optionN;
                                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'a_text')->textInput()->label(false);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            endif;
                                                        endforeach; ?>
                                                    <?php elseif ($question->id_group_type == 2): ?>
                                                        <!-- long_answer -->
                                                        <?php
                                                        foreach ($qOptions as $qOption):
                                                            if ($qOption->title != QuestionOption::$other_option_id):
                                                                $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                                ?>
                                                                <div class="col-md-6 answer-container">
                                                                    <div class="answer-title"><?= $qOption->title ?></div>
                                                                    <?php
                                                                    ++$optionN;
                                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'a_text')->textarea()->label(false);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            endif;
                                                        endforeach; ?>
                                                    <?php elseif ($question->id_group_type == 3): ?>
                                                        <!-- number -->
                                                        <?php
                                                        foreach ($qOptions as $qOption):
                                                            if ($qOption->title != QuestionOption::$other_option_id):
                                                                $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                                ?>
                                                                <div class="col-md-6 answer-container">
                                                                    <div class="answer-title"><?= $qOption->title ?></div>
                                                                    <?php
                                                                    ++$optionN;
                                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'a_number')->textInput()->label(false);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            endif;
                                                        endforeach; ?>
                                                    <?php elseif ($question->id_group_type == 4): ?>
                                                        <!-- select_options -->
                                                        <div class="answer-container">
                                                            <?php
                                                            ++$optionN;
                                                            $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);

                                                            // set first value to de end of the array
                                                            $tempVal = $qOptions[0];
                                                            unset($qOptions[0]);
                                                            if ($question->add_textbox) {
                                                                $qOptions[] = $tempVal;
                                                                $GLOBALS['otherOptionNum'] = count($qOptions) - 1;
                                                            }
                                                            else {
                                                                $GLOBALS['otherOptionNum'] = -1;
                                                            }
                                                            unset($tempVal);

                                                            $GLOBALS['otherOptionAv'] = $question->add_textbox;
                                                            // save index position of the "other" value
                                                            $GLOBALS['otherOptionNum'] = count($qOptions) - 1;

                                                            $radioOptions = []; // options container
                                                            $isOptionInAnser = false;
                                                            foreach ($qOptions as $qOption) {
                                                                $radioOptions[$qOption->title] = $qOption->title;
                                                                if (!$isOptionInAnser) $isOptionInAnser = ($qOption->title === $answer->a_text) ? true : false;
                                                            }

                                                            // asign "other" value
                                                            if ($isOptionInAnser) {
                                                                $GLOBALS['otherOptionVal'] = '';
                                                            } else {
                                                                $GLOBALS['otherOptionVal'] = $answer->a_text;
                                                            }

                                                            echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                            echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'a_text')->radioList($radioOptions, [
                                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                                    $check = ($checked) ? 'checked' : '';

                                                                    if ($GLOBALS['otherOptionAv'] && $index === $GLOBALS['otherOptionNum']) {
                                                                        $check = ($checked || !empty($GLOBALS['otherOptionVal'])) ? 'checked' : '';
                                                                        $res = '<div class="col-md-3 other-option">';
                                                                        $res .= '<label>';
                                                                        $res .= '<span>Other: </span>';
                                                                        $res .= '<input type="radio" name="'.$name.'" value="'.$GLOBALS['otherOptionVal'].'" '.$check.'> ';
                                                                        $res .= '<input type="text" class="form-control other-option-text" value="'.$GLOBALS['otherOptionVal'].'" > ';
                                                                        $res .= '</label>';
                                                                        $res .= '</div>';
                                                                    }
                                                                    else {
                                                                        $res = '<div class="col-md-3">';
                                                                        $res .= '<label>';
                                                                        $res .= '<input type="radio" name="'.$name.'" value="'.$value.'" '.$check.'> ';
                                                                        $res .= $label;
                                                                        $res .= '</label>';
                                                                        $res .= '</div>';
                                                                    }

                                                                    return $res;
                                                                },
                                                            ])->label(false);
                                                            unset($GLOBALS['otherOptionAv']);
                                                            unset($GLOBALS['otherOptionNum']);
                                                            unset($GLOBALS['otherOptionVal']);
                                                            ?>
                                                        </div>
                                                    <?php elseif ($question->id_group_type == 5): ?>
                                                        <!-- multiselect_options -->
                                                        <?php
                                                        foreach ($qOptions as $qOption):
                                                            if ($qOption->title != QuestionOption::$other_option_id):
                                                                ++$optionN;
                                                                $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                                ?>
                                                                <div class="col-md-3 answer-container">
                                                                    <?php
                                                                    echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                                    echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                                    echo $form->field($answer, "[{$optionN}]".'a_text')->checkbox([], false)->label($qOption->title);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            endif;
                                                        endforeach; ?>
                                                    <?php elseif ($question->id_group_type == 6): ?>
                                                        <!-- linear_scale -->
                                                        <div class="col-lg-12 answer-container">
                                                            <table class="table table-bordered table-hover table-responsive">
                                                                <tbody>
                                                                <?php
                                                                ++$optionN;
                                                                $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                                echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                                echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                                echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                                ?>

                                                                <tr>
                                                                    <?php
                                                                    $radioOptions = [];
                                                                    foreach ($qOptions as $qOption) {
                                                                        if ($qOption->title != QuestionOption::$other_option_id) {
                                                                            $radioOptions[$qOption->title] = $qOption->title;

                                                                            echo '<td class="text-center">';
                                                                            echo $qOption->title;
                                                                            echo '</td>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="active">
                                                                    <?= $form->field($answer, "[{$optionN}]".'a_text')->radioList($radioOptions, [
                                                                        'item' => function ($index, $label, $name, $checked, $value) {
                                                                            $check = ($checked) ? 'checked' : '';

                                                                            $res = '<td class="text-center">';
                                                                            $res .= '<label>';
                                                                            $res .= '<input type="radio" name="'.$name.'" value="'.$value.'" '.$check.'> ';
                                                                            $res .= '</label>';
                                                                            $res .= '</td>';

                                                                            return $res;
                                                                        },
                                                                    ])->label(false) ?>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    <?php elseif ($question->id_group_type == 7): ?>
                                                        <!-- true_false -->
                                                        <div class="answer-container">
                                                            <?php
                                                            ++$optionN;
                                                            $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                            $radioOptions = [1=>1, 0=>0]; // true or false

                                                            echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                            echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'a_bool')->radioList($radioOptions, [
                                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                                    $check = ($checked) ? 'checked' : '';
                                                                    $offset = ($value) ? 'col-sm-offset-3' : '';
                                                                    $button = ($value) ? '<span class="btn btn-block btn-default"><i class="fa fa-check"></i></span>'
                                                                        : '<span class="btn btn-block btn-default"><i class="fa fa-times"></i></span>';

                                                                    $res = '<div class="col-md-3 '.$offset.'">';
                                                                    $res .= '<label class="show text-center">';
                                                                    $res .= '<input type="radio" name="'.$name.'" value="'.$value.'" '.$check.'> ';
                                                                    $res .= $button;
                                                                    $res .= '</label>';
                                                                    $res .= '</div>';

                                                                    return $res;
                                                                },
                                                            ])->label(false);
                                                            ?>
                                                        </div>
                                                    <?php elseif ($question->id_group_type == 8): ?>
                                                        <!-- date -->
                                                        <div class="col-md-6 col-md-offset-3 answer-container">
                                                            <div class="answer-title"><?= Yii::t('app','Date:') ?></div>
                                                            <?php
                                                            ++$optionN;
                                                            $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                            echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                            echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'a_date')->textInput(['class'=>'form-control datepicker'])->label(false);
                                                            ?>
                                                        </div>
                                                    <?php elseif ($question->id_group_type == 9): ?>
                                                        <!-- time -->
                                                        <div class="col-md-6 col-md-offset-3 answer-container">
                                                            <div class="answer-title"><?= Yii::t('app','Time:') ?></div>
                                                            <?php
                                                            ++$optionN;
                                                            $answer = InterviewAnswer::getAnswer($interview->id, $question->id, $optionN);
                                                            echo $form->field($answer, "[{$optionN}]".'id')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_interview')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'id_question')->hiddenInput()->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'number')->hiddenInput()->label(false);
                                                            echo $form->field($question, "[{$optionN}]".'optional')->hiddenInput(['class'=>'optional-value'])->label(false);
                                                            echo $form->field($answer, "[{$optionN}]".'a_time')->textInput(['class'=>'form-control timepicker'])->label(false);
                                                            ?>
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
