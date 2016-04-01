<?php 

use app\models\Survey;
use app\models\Question;
use app\models\QuestionOption;
use app\models\Interview;
use app\models\InterviewAnswer;
use app\models\GroupType;
use app\models\DataPieChart;

$questionType = $question->id_group_type;
$colors = [
		'#525252',
        '#e51c23',
        '#e91e63',
        '#9c27b0',
        '#673ab7',
        '#3f51b5',
        '#5677fc',
        '#03a9f4',
        '#259b24',
        '#8bc34a',
        '#ff5722',
        '#795548',
    ];
$answerNum = 0;
$answersList = [];
$answerObjList = [];
$chartJSON = '';

foreach ($interviews as $interview) {
	$answers = InterviewAnswer::find()->where(['id_interview'=>$interview->id, 'id_question'=>$question->id])->all();
	foreach ($answers as $answer) {
		if ($questionType === GroupType::$SINGLE_CHOICE 
			|| $questionType === GroupType::$TEXT_ANSWER 
			|| $questionType === GroupType::$LINEAR_SCALE ) {
			if (isset($answersList[$answer->a_text])) {
				$answersList[$answer->a_text]['quantity'] = $answersList[$answer->a_text]['quantity']+1;
			} else {
				$answersList[$answer->a_text] = ['quantity'=>1];
			}
		}
		else if ($questionType === GroupType::$MULTIPLE_CHOICE) {
			if ($answer->a_text != '*/') {
				if (isset($answersList[$answer->a_text])) {
					$answersList[$answer->a_text]['quantity'] = $answersList[$answer->a_text]['quantity']+1;
				} else {
					$answersList[$answer->a_text] = ['quantity'=>1];
				}
			}
		}
		else if ($questionType === GroupType::$TRUE_FALSE) {
			$option = QuestionOption::find()->where(['id_question'=>$answer->id_question])->all();

			$val = ($answer->a_bool) ? $option[0]->title : $option[1]->title;
			if (isset($answersList[$val])) {
				$answersList[$val]['quantity'] = $answersList[$val]['quantity']+1;
			} else {
				$answersList[$val] = ['quantity'=>1];
			}
		}
		++$answerNum;
	}
}

foreach ($answersList as $key => $val) {
	$color = array_rand($colors);
	
	$pie = new DataPieChart();
	$pie->label = $key;
	$pie->value = $val['quantity'];
	$pie->color = $colors[$color];
	$pie->highlight = $colors[$color];
	$answerObjList[] = $pie;
}

$chartJSON = json_encode($answerObjList);
?>

<table class="table table-striped table-bordered">
	<caption><?= Yii::t('app', 'This question have <b>{number}</b> answers.', ['number'=>$answerNum]) ?></caption>
	<tbody>
		<tr>
			<td>
				<canvas id="circle_chart-<?= $questionN ?>" class="pie-chart" width="300" height="300" <?= "data-json='{$chartJSON}'" ?>></canvas>
			</td>
		</tr>
	</tbody>
</table>