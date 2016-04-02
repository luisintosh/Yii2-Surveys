<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use app\models\Survey;
use app\models\SurveySection;
use app\models\Question;
use app\models\Interview;
use app\models\InterviewAnswer;
use app\models\GroupType;
use kartik\export\ExportMenu;

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
    <h2 class="page-header"><?= Yii::t('app','Export Results') ?></h2>
    <div class="row">
        <div class="col-lg-12">
            <?php 
            // Renders a export dropdown menu
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute'=>'unique', 'label'=>'ID'],
                    ['attribute'=>'email', 'label'=>Yii::t('app','Email')],
                    ['attribute'=>'ip_address', 'label'=>Yii::t('app','IP')],
                    ['attribute'=>'country', 'label'=>Yii::t('app','Country')],
                    ['attribute'=>'web_browser', 'label'=>Yii::t('app','Browser')],
                    ['attribute'=>'survey_title', 'label'=>Yii::t('app','Survey Title')],
                    ['attribute'=>'section_title', 'label'=>Yii::t('app','Section Title')],
                    ['attribute'=>'question_title', 'label'=>Yii::t('app','Question Title')],
                    ['attribute'=>'answer', 'label'=>Yii::t('app','Answer')],
                    [
                        'attribute'=>'created_at',
                        'label' => Yii::t('app','Created on'),
                        'format' => ['date', 'php:Y-m-d H:i:s']
                    ],
                    [
                        'attribute'=>'updated_at',
                        'label' => Yii::t('app','Updated on'),
                        'format' => ['date', 'php:Y-m-d H:i:s']
                    ],
                ]
            ]);

            // You can choose to render your own GridView separately
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute'=>'email', 'label'=>Yii::t('app','Email')],
                    ['attribute'=>'survey_title', 'label'=>Yii::t('app','Survey Title')],
                    ['attribute'=>'section_title', 'label'=>Yii::t('app','Section Title')],
                    ['attribute'=>'question_title', 'label'=>Yii::t('app','Question Title')],
                    ['attribute'=>'answer', 'label'=>Yii::t('app','Answer')],
                ]
            ]);
            ?>
        </div>
    </div>

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
</div>

<?= $this->registerJsFile('@web/js/survey_results.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>