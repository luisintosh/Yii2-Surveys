<?php 

use yii\helpers\Html;
use app\models\Survey;
use app\models\Question;
use app\models\Interview;
use app\models\InterviewAnswer;
use app\models\GroupType;

$questionType = $question->id_group_type;
$answersList = [];

foreach ($interviews as $interview) {
	$answers = InterviewAnswer::find()->where(['id_interview'=>$interview->id, 'id_question'=>$question->id])->all();
	foreach ($answers as $answer) {
		if ($questionType === GroupType::$TEXT_ANSWER || $questionType === GroupType::$TEXT_BLOCK_ANSWER ) {
			$answersList[] = $answer->a_text;
		}
		else if ($questionType === GroupType::$NUMBER_ANSWER) {
			$answersList[] = $answer->a_number;
		}
		else if ($questionType === GroupType::$DATE_FIELD) {
			$answersList[] = $answer->a_date;
		}
		else if ($questionType === GroupType::$TIME_FIELD) {
			$answersList[] = $answer->a_time;
		}
	}
}
?>
<div class="list-answers">
	<table class="table table-striped table-bordered">
		<caption><?= Yii::t('app', 'This question have <b>{number}</b> answers.', ['number'=>count($answersList)]) ?></caption>
		<tbody>
			<?php foreach($answersList as $k => $a): ?>
				<tr>
					<td><?= $a ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

