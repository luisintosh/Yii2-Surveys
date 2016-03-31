<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\Survey;
use app\models\SurveySection;
use app\models\Question;
use app\models\GroupType;
use app\models\QuestionOption;
use app\models\QuestionExtraitem;

/* @var $this yii\web\View */
/* @var $model app\models\Survey */
/* @var $form yii\widgets\ActiveForm */


// keys
$sectionN = 0;
$questionN = 0;
$optionN = 0;

?>

<?php Pjax::begin(['id' => 'pjax-container']) ?>

    <div class="survey-form">

        <?php $form = ActiveForm::begin(['id' => 'datasurvey', 'options' => ['data-pjax' => true ]]); ?>

        <h2 class="page-header"><?= Yii::t('app','Data') ?></h2>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $model->getAttributeLabel('title') ?></h3>
                    </div>
                    <div class="box-body">
                        <?= $form->field($model, 'title')->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $model->getAttributeLabel('logo_url') ?></h3>
                    </div>
                    <div class="box-body">
                        <?= $form->field($model, 'logo_url')->label(false) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $model->getAttributeLabel('description') ?></h3>
                    </div>
                    <div class="box-body">
                        <?= $form->field($model, 'description', ['options'=>['class' => 'wysihtml5-editor']])->textArea(['rows' => 5])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="page-header"><?= Yii::t('app','Sections') ?></h2>
        <!-- SECTIONS -->
        <div class="survey-sections">

            <?php
            $sections = SurveySection::find()->where(['id_survey' => $model->id])->all();
            if (count($sections) === 0) {
                $sections[] = SurveySection::create($model->id);
            }
            foreach($sections as $section):
                ?>

                <!-- SECTION -->
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= Yii::t('app','Section {n}',['n'=>++$sectionN]) ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Minimize section') ?>">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool survey-action" data-action="delete-section" data-survey="<?= $model->id ?>" data-section="<?= $section->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete section') ?>">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="hidden">
                            <?= $form->field($section, "[{$sectionN}]".'id')->hiddenInput() ?>

                            <?= $form->field($section, "[{$sectionN}]".'id_survey')->hiddenInput() ?>
                        </div>

                        <?= $form->field($section, "[{$sectionN}]".'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($section, "[{$sectionN}]".'description', ['options'=>['class' => 'wysihtml5-editor']])->textarea(['rows' => 5]) ?>

                        <br>

                        <!-- QUESTIONS -->
                        <div class="section-questions">

                            <h3 class="page-header"><?= Yii::t('app','Questions') ?></h3>

                            <?php
                            $questions = Question::find()->where(['id_survey_section' => $section->id])->all();
                            if (count($questions) === 0) {
                                $questions[] = Question::create($section->id, GroupType::$SINGLE_CHOICE, Yii::t('app','New question'));
                            }
                            foreach($questions as $question):
                                if ($question->id_survey_section === $section->id):
                                    ?>
                                    <!-- QUESTION -->
                                    <div class="box box-dotted">
                                        <div class="box-header with-border">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <h4>#<?= ++$questionN ?></h4>
                                                </div>
                                                <div class="col-sm-9 p-title">
                                                    <div class="hidden">
                                                        <?= $form->field($question, "[{$questionN}]".'id')->hiddenInput() ?>

                                                        <?= $form->field($question, "[{$questionN}]".'id_survey_section')->hiddenInput() ?>
                                                    </div>

                                                    <?= $form->field($question, "[{$questionN}]".'title')->textInput(['maxlength' => true])->label(false) ?>
                                                </div>
                                                <div class="col-sm-2 text-right">
                                                    <?php
                                                    $questionExtraitem = QuestionExtraitem::find()->where(['id_question'=>$question->id])->one();
                                                    if ($questionExtraitem === null) {
                                                        $questionExtraitem = QuestionExtraitem::create($question->id);
                                                    }
                                                    ?>
                                                    <div class="btn-group">
                                                        <div class="btn-group" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Question helpers') ?>">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="#" data-toggle="modal" data-target="#modal-etip<?= $questionExtraitem->id ?>"><?= Yii::t('app','Tip') ?></a></li>
                                                                <li><a href="#" data-toggle="modal" data-target="#modal-eimage_url<?= $questionExtraitem->id ?>"><?= Yii::t('app','Image') ?></a></li>
                                                                <li><a href="#" data-toggle="modal" data-target="#modal-evideoyt_url<?= $questionExtraitem->id ?>"><?= Yii::t('app','Youtube video') ?></a></li>
                                                                <li><a href="#" data-toggle="modal" data-target="#modal-esoundcloud_url<?= $questionExtraitem->id ?>"><?= Yii::t('app','Soundcloud audio') ?></a></li>
                                                            </ul>
                                                        </div>
                                                        <button type="button" class="btn btn-default" data-widget="collapse"  data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Minimize question') ?>">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default survey-action" data-widget="remove" data-action="delete-question" data-survey="<?= $model->id ?>" data-section="<?= $section->id ?>" data-question="<?= $question->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete question') ?>">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <!-- EXTRA ITEMS -->
                                            <div class="question-extra-items">
                                                <?php
                                                $extraItemLabels = $questionExtraitem->attributes();
                                                foreach ($extraItemLabels as $extraItemCve => $extraItemLabel):
                                                    ?>
                                                    <div class="modal fade" id="modal-e<?= $extraItemLabel . $questionExtraitem->id ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title"><?= $questionExtraitem->getAttributeLabel($extraItemLabel) ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?= $form->field($questionExtraitem, "[{$questionN}]".$extraItemLabel)->input('text', ['placeholder'=>$questionExtraitem->getAttributeLabel($extraItemLabel)])->label(false) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                            <div class="pregunta-opc border-bottom padding15">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <strong><?= $question->getAttributeLabel('id_group_type') ?></strong>
                                                        <p><?= GroupType::getTypeString($question->id_group_type) ?></p>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <!-- QUESTION PREFERENCES -->
                                                        <?= $form->field($question, "[{$questionN}]".'optional')->checkbox() ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ANSWERS -->
                                            <div class="container-fluid">
                                                <ul class="question-options">

                                                    <?php
                                                    $questionOptions = QuestionOption::find()->where(['id_question' => $question->id])->all();
                                                    if (count($questionOptions) === 0) {
                                                        // other option
                                                        $questionOptions[] = QuestionOption::create($question->id, QuestionOption::$other_option_id);
                                                        // normal option
                                                        $questionOptions[] = QuestionOption::create($question->id, Yii::t('app','Answer'));
                                                    }

                                                    $questionElemVisible = ($question->id_group_type == GroupType::$SINGLE_CHOICE
                                                        || $question->id_group_type == GroupType::$LINEAR_SCALE
                                                        || $question->id_group_type == GroupType::$MULTIPLE_CHOICE);

                                                    foreach($questionOptions as $questionOption):
                                                        if ($questionOption->id_question === $question->id && $questionOption->title != QuestionOption::$other_option_id):
                                                            ++$optionN;
                                                            ?>

                                                            <li>
                                                                <div class="row">
                                                                    <div class="hidden">
                                                                        <?= $form->field($questionOption, "[{$optionN}]".'id')->hiddenInput() ?>

                                                                        <?= $form->field($questionOption, "[{$optionN}]".'id_question')->hiddenInput() ?>
                                                                    </div>
                                                                    <div class="col-sm-8">

                                                                        <?= $form->field($questionOption, "[{$optionN}]".'title')->textInput(['maxlength' => true])->label(false) ?>

                                                                    </div>
                                                                    <div class="col-sm-1">
                                                                        <?php if ($questionElemVisible): ?>
                                                                        <a href="#" class="btn btn-default trash-btn survey-action" data-action="delete-option" data-survey="<?= $model->id ?>" data-section="<?= $section->id ?>" data-question="<?= $question->id ?>" data-option="<?= $questionOption->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete answer') ?>">
                                                                            <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                        <?php endif ?>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <?php
                                                        endif;
                                                    endforeach;
                                                    ?>

                                                    <li class="textbox-option" style="display: <?= ($question['add_textbox']) ? 'block':'none' ?>">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <input type="text" value="<?= Yii::t('app','Other...') ?>" maxlength="255" disabled>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <?php if($questionElemVisible): ?>
                                                <div>
                                                    <span class="btn btn-link survey-action" data-action="new-option" data-survey="<?= $model->id ?>" data-section="<?= $section->id ?>" data-question="<?= $question->id ?>" data-option="<?= $questionOption->id ?>">
                                                        <i class="fa fa-plus"></i> <?= Yii::t('app','Add answer') ?>
                                                    </span>
                                                </div>
                                                <?php endif ?>

                                                <?php if($question->id_group_type == GroupType::$SINGLE_CHOICE): ?>
                                                <div class="add-textbox-option">
                                                    <span class="btn btn-link">
                                                        <i class="fa fa-plus"></i>
                                                        <?= Yii::t('app','Add "Other" answer') ?>
                                                    </span>
                                                    <div class="hide">
                                                        <!-- ANSWER SETTINGS -->
                                                        <?= $form->field($question, "[{$questionN}]".'add_textbox')->checkbox() ?>
                                                    </div>
                                                </div>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                endif;
                            endforeach;
                            ?>
                            <!-- ADD QUESTION BUTTON -->
                            <div class="text-center text-primary add-question"  data-toggle="modal" data-target="#modal-addquestion<?= $section->id ?>">
                                <i class="fa fa-plus-circle"></i>
                                <span><?= Yii::t('app','Add question') ?></span>
                            </div>

                            <div class="modal fade" id="modal-addquestion<?= $section->id ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"><?= $question->getAttributeLabel('id_group_type') ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <!-- QUESTION TYPE -->
                                            <?php 
                                            $newQuestion = new Question();
                                            echo $form->field($newQuestion, '[selector]id_group_type')->dropDownList(GroupType::getAllTypes(), [
                                                'class'=>'form-control group-type-selector',
                                                'prompt'=>Yii::t('app','- Select a question type -'),
                                                'data-action'=>'new-question',
                                                'data-survey'=>$model->id,
                                                'data-section'=>$section->id,
                                            ])->label(false) 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /SECTION -->
                <!-- ADD SECTION BUTTON -->
                <div class="text-center text-primary add-section survey-action" data-action="new-section" data-survey="<?= $model->id ?>" data-section="<?= $section->id ?>">
                    <i class="fa fa-plus-circle"></i>
                    <span><?= Yii::t('app','Add section') ?></span>
                </div>
            <?php endforeach ?>

        </div>

        <p class="text-right">
            <button type="button" name="btn-post" class="btn btn-success survey-action" data-action="save-survey" data-survey="<?= $model->id ?>"><i class="fa fa-floppy-o"></i> <?= Yii::t('app','Save') ?></button>
            <button type="button" name="btn-post" class="btn btn-primary survey-action" data-action="publish-survey" data-survey="<?= $model->id ?>"><i class="fa fa-share"></i> <?= Yii::t('app','Publish') ?></button>
            <button type="button" name="btn-post" class="btn btn-danger survey-action" data-action="delete-survey" data-survey="<?= $model->id ?>"><i class="fa fa-times"></i> <?= Yii::t('app','Delete') ?></button>
        </p>

        <?php ActiveForm::end(); ?>

    </div>

<?php Pjax::end() ?>