<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\SurveySection;
use app\models\Question;
use app\models\GroupType;
use app\models\QuestionOption;

/* @var $this yii\web\View */
/* @var $model app\models\Survey */
/* @var $form yii\widgets\ActiveForm */
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
    <!-- sections -->
    <div class="survey-sections">

        <?php
        $sections = SurveySection::find()->where(['id_survey' => $model->id])->all();
        if (count($sections) === 0) {
            $section = new SurveySection();
            $section->id_survey = $model->id;
            $section->save();
            $sections[] = $section;
        }
        foreach($sections as $cveSection => $MSection):
        ?>

        <!-- section -->
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app','Section {n}',['n'=>$cveSection+1]) ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Minimize section') ?>">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool survey-action" data-action="delete-section" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete section') ?>">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <div class="hidden">
                    <?= $form->field($MSection, "[{$cveSection}]".'id')->hiddenInput() ?>

                    <?= $form->field($MSection, "[{$cveSection}]".'id_survey')->hiddenInput() ?>
                </div>

                <?= $form->field($MSection, "[{$cveSection}]".'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($MSection, "[{$cveSection}]".'description', ['options'=>['class' => 'wysihtml5-editor']])->textarea(['rows' => 5]) ?>

                <br>

                <!-- questions -->
                <div class="section-questions">

                    <h3 class="page-header"><?= Yii::t('app','Questions') ?></h3>

                    <?php
                    $questions = Question::find()->where(['id_survey_section' => $MSection->id])->all();
                    if (count($questions) === 0) {
                        $question = new Question();
                        $question->id_survey_section = $MSection->id;
                        $question->id_group_type = 1; // short_answer
                        $question->title = 'New question';
                        $question->save();
                        $questions[] = $question;
                    }
                    foreach($questions as $cveQuestion => $MQuestion):
                        if ($MQuestion->id_survey_section === $MSection->id):
                    ?>

                    <!-- question -->
                    <div class="box box-dotted">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-sm-1">
                                    <h4>#<?= $cveQuestion+1 ?></h4>
                                </div>
                                <div class="col-sm-9 p-title">
                                    <div class="hidden">
                                        <?= $form->field($MQuestion, "[{$cveQuestion}]".'id')->hiddenInput() ?>

                                        <?= $form->field($MQuestion, "[{$cveQuestion}]".'id_survey_section')->hiddenInput() ?>
                                    </div>

                                    <?= $form->field($MQuestion, "[{$cveQuestion}]".'title')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <div class="btn-group">
                                        <div class="btn-group" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Question helpers') ?>">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#"><?= Yii::t('app','Tip') ?></a></li>
                                                <li><a href="#"><?= Yii::t('app','Image') ?></a></li>
                                                <li><a href="#"><?= Yii::t('app','Youtube video') ?></a></li>
                                                <li><a href="#"><?= Yii::t('app','Soundcloud audio') ?></a></li>
                                            </ul>
                                        </div>
                                        <button type="button" class="btn btn-primary" data-widget="collapse"  data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Minimize question') ?>">
                                          <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary survey-action" data-widget="remove" data-action="delete-question" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>" data-question="<?= $MQuestion->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete question') ?>">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="elementos-apoyo border-bottom padding15">
                                input <br>
                                input ...
                            </div>
                            <div class="pregunta-opc border-bottom padding15">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- TIPOS DE PREGUNTA -->
                                        <?= $form->field($MQuestion, "[{$cveQuestion}]".'id_group_type')->dropDownList(GroupType::getAllTypes()) ?>

                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <!-- CONFIGURACION DE LA PREGUNTA -->
                                        <?= $form->field($MQuestion, "[{$cveQuestion}]".'optional')->checkbox() ?>

                                    </div>
                                </div>
                            </div>
                            <!-- opciones de respuesta -->
                            <div class="container-fluid">
                                <ul class="question-options">

                                    <?php
                                    $questionOptions = QuestionOption::find()->where(['id_question' => $MQuestion->id])->all();
                                    if (count($questionOptions) === 0) {
                                        $questionOption = new QuestionOption();
                                        $questionOption->id_question = $MQuestion->id;
                                        $questionOption->title = 'Answer...';
                                        $questionOption->save();
                                        $questionOptions[] = $questionOption;
                                    }
                                    foreach($questionOptions as $cveQOption => $MQOption):
                                    if ($MQOption->id_question === $MQuestion->id):
                                    ?>

                                    <li>
                                        <div class="row">
                                            <div class="hidden">
                                                <?= $form->field($MQOption, "[{$cveQOption}]".'id')->hiddenInput() ?>

                                                <?= $form->field($MQOption, "[{$cveQOption}]".'id_question')->hiddenInput() ?>
                                            </div>
                                            <div class="col-sm-8">

                                                <?= $form->field($MQOption, "[{$cveQOption}]".'title')->textInput(['maxlength' => true])->label(false) ?>

                                            </div>
                                            <div class="col-sm-1">
                                                <a href="#" class="btn btn-default trash-btn survey-action" data-action="delete-option" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>" data-question="<?= $MQuestion->id ?>" data-option="<?= $MQOption->id ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('app','Delete answer') ?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php
                                    endif;
                                    endforeach;
                                    ?>

                                    <li class="textbox-option" style="display: <?= ($MQuestion['add_textbox']) ? 'block':'none' ?>">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <input type="text" value="<?= Yii::t('app','Other...') ?>" maxlength="255" disabled>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <div>
                                    <span class="btn btn-link survey-action" data-action="new-option" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>" data-question="<?= $MQuestion->id ?>" data-option="<?= $MQOption->id ?>">
                                        <i class="fa fa-plus"></i> <?= Yii::t('app','Add answer') ?>
                                    </span>
                                </div>
                                <div class="add-textbox-option">
                                    <span class="btn btn-link">
                                        <i class="fa fa-plus"></i>
                                        <?= Yii::t('app','Add text answer') ?>
                                    </span>
                                    <div class="hide">
                                        <!-- CONFIGURACION DE LA PREGUNTA -->
                                        <?= $form->field($MQuestion, "[{$cveQuestion}]".'add_textbox')->checkbox() ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    endif;
                    endforeach;
                    ?>


                    <!-- Boton agregar pregunta -->
                    <div class="text-center text-primary add-question survey-action" data-action="new-question" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>">
                        <i class="fa fa-plus-circle"></i>
                        <span><?= Yii::t('app','Add question') ?></span>
                    </div>
                </div>

            </div>
        </div>
        <!-- /seccion -->
        <!-- Boton agregar seccion -->
        <div class="text-center text-primary add-section survey-action" data-action="new-section" data-survey="<?= $model->id ?>" data-section="<?= $MSection->id ?>">
            <i class="fa fa-plus-circle"></i>
            <span><?= Yii::t('app','Add section') ?></span>
        </div>
        <?php endforeach ?>

    </div>

    <p class="text-right">
      <button type="button" name="btn-post" class="btn btn-primary survey-action" data-action="publish-survey" data-survey="<?= $model->id ?>"><i class="fa fa-share"></i> <?= Yii::t('app','Publish') ?></button>
      <button type="button" name="btn-post" class="btn btn-danger survey-action" data-action="delete-survey" data-survey="<?= $model->id ?>"><i class="fa fa-times"></i> <?= Yii::t('app','Delete') ?></button>
    </p>

    <?php ActiveForm::end(); ?>

</div>

<?php Pjax::end() ?>