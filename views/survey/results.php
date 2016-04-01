<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use app\models\Survey;
use app\models\SurveySection;
use app\models\Question;
use app\models\Interview;
use app\models\InterviewAnswer;
use app\models\GroupType;

/* @var $this yii\web\View */
$this->title = Yii::t('app','{title} | Survey Results', ['title'=>$survey->title]);

$sectionN = 0;
$questionN = 0;
$optionN = 0;
?>

<section class="content-header">
    <h1><?= Html::encode($survey->title) ?></h1>
</section>
<div class="content">

    <?=
    $this->render('survey_maker_menu', [
        'survey'=>$survey,
    ]);
    ?>

    <h2 class="page-header"><?= Yii::t('app','Survey Results') ?></h2>
    <?php
    $interviews = Interview::find()->where(['id_survey'=>$survey->id])->all();
    $sections = SurveySection::find()->where(['id_survey'=>$survey->id])->all();
    foreach ($sections as $section):
        ?>
        <?php ++$sectionN ?>
        <h3 class="page-header"><small><?= Yii::t('app','Section') ?>: <?= $sectionN ?>/<?= count($sections) ?></small> <?= $section->title ?></h3>
        <div class="row">
            <?php
            $questions = Question::find()->where(['id_survey_section'=>$section->id])->all();
            foreach ($questions as $question):
                ?>
                <?php ++$questionN ?>
                <div class="col-sm-12">
                    <h4><small><?= $questionN ?></small> <?= $question->title ?></h4>
                    <?php
                        $questionType = $question->id_group_type;
                        if ($questionType === GroupType::$SINGLE_CHOICE
                            || $questionType === GroupType::$LINEAR_SCALE
                            || $questionType === GroupType::$TRUE_FALSE
                            || $questionType === GroupType::$MULTIPLE_CHOICE) {

                            echo $this->render('results/circle_chart', [
                                'survey'=>$survey,
                                'interviews'=>$interviews,
                                'question'=>$question,
                                'questionN'=>$questionN,
                                ]);

                        } else {

                            echo $this->render('results/list_answers', [
                                'survey'=>$survey,
                                'interviews'=>$interviews,
                                'question'=>$question,
                                ]);

                        }
                    ?>
                </div>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>

    <br>
    <div class="padding15 text-right">
        <a href="javascript:window.print()" class="btn btn-primary"><?= Yii::t('app', 'Print') ?></a>
    </div>
</div>

<?= $this->registerJsFile('@web/js/survey_results.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>