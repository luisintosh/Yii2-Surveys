<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interview_answer".
 *
 * @property integer $id
 * @property integer $id_interview
 * @property integer $id_question_option
 * @property integer $a_number
 * @property string $a_text
 * @property integer $a_bool
 * @property string $a_date
 * @property string $a_time
 *
 * @property QuestionOption $idQuestionOption
 * @property Interview $idInterview
 */
class InterviewAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interview_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_interview', 'id_question', 'id_question_option'], 'required'],
            [['a_text'], 'required', 'when' => function ($model) {
                $q = Question::findOne($model->id_question);
                $noOptional = ($q->optional === 0);
                $isType = ($q->id_group_type === 1 || $q->id_group_type === 2 || $q->id_group_type === 4 || $q->id_group_type === 5 || $q->id_group_type === 6);
                return ($noOptional && $isType);
            }, 'whenClient' => "function (attribute, value) {
                var optional_value = $('#'+attribute.id).closest('.answer-container').find('.optional-value').val();
                var validate = (optional_value == 1) ? false : true;
                return validate;
            }"],
            [['a_number'], 'required', 'when' => function ($model) {
                $q = Question::findOne($model->id_question);
                $noOptional = ($q->optional === 0);
                $isType = ($q->id_group_type === 3);
                return ($noOptional && $isType);
            }, 'whenClient' => "function (attribute, value) {
                var optional_value = $('#'+attribute.id).closest('.answer-container').find('.optional-value').val();
                var validate = (optional_value == 1) ? false : true;
                return validate;
            }"],
            [['a_bool'], 'required', 'when' => function ($model) {
                $q = Question::findOne($model->id_question);
                $noOptional = ($q->optional === 0);
                $isType = ($q->id_group_type === 7);
                return ($noOptional && $isType);
            }, 'whenClient' => "function (attribute, value) {
                var optional_value = $('#'+attribute.id).closest('.answer-container').find('.optional-value').val();
                var validate = (optional_value == 1) ? false : true;
                return validate;
            }"],
            [['a_date'], 'required', 'when' => function ($model) {
                $q = Question::findOne($model->id_question);
                $noOptional = ($q->optional === 0);
                $isType = ($q->id_group_type === 8);
                return ($noOptional && $isType);
            }, 'whenClient' => "function (attribute, value) {
                var optional_value = $('#'+attribute.id).closest('.answer-container').find('.optional-value').val();
                var validate = (optional_value == 1) ? false : true;
                return validate;
            }"],
            [['a_time'], 'required', 'when' => function ($model) {
                $q = Question::findOne($model->id_question);
                $noOptional = ($q->optional === 0);
                $isType = ($q->id_group_type === 9);
                return ($noOptional && $isType);
            }, 'whenClient' => "function (attribute, value) {
                var optional_value = $('#'+attribute.id).closest('.answer-container').find('.optional-value').val();
                var validate = (optional_value == 1) ? false : true;
                return validate;
            }"],
            [['id_interview', 'id_question', 'id_question_option', 'a_number'], 'integer'],
            [['a_bool'], 'boolean'],
            [['a_text'], 'string'],
            [['a_date', 'a_time'], 'safe'],
            [['id_question'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['id_question' => 'id']],
            [['id_question_option'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionOption::className(), 'targetAttribute' => ['id_question_option' => 'id']],
            [['id_interview'], 'exist', 'skipOnError' => true, 'targetClass' => Interview::className(), 'targetAttribute' => ['id_interview' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_interview' => Yii::t('app', 'Id Interview'),
            'id_question' => Yii::t('app', 'Id Question'),
            'id_question_option' => Yii::t('app', 'Id Question Option'),
            'a_number' => Yii::t('app', 'A Number'),
            'a_text' => Yii::t('app', 'A Text'),
            'a_bool' => Yii::t('app', 'A Bool'),
            'a_date' => Yii::t('app', 'A Date'),
            'a_time' => Yii::t('app', 'A Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'id_question']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionOption()
    {
        return $this->hasOne(QuestionOption::className(), ['id' => 'id_question_option']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInterview()
    {
        return $this->hasOne(Interview::className(), ['id' => 'id_interview']);
    }

    /**
     * Get an answer for any option if not exist create one
     * @param $IdInterview
     * @param $IdQuestion
     * @param $IdOption
     * @return InterviewAnswer|array|null|\yii\db\ActiveRecord
     */
    public static function getAnswer($IdInterview, $IdQuestion, $IdOption)
    {
        $answer = InterviewAnswer::find()
            ->where(['id_interview'=>$IdInterview, 'id_question'=>$IdQuestion, 'id_question_option'=>$IdOption])
            ->one();

        if ($answer === null) {
            $answer = new InterviewAnswer();
            $answer->id_interview = $IdInterview;
            $answer->id_question = $IdQuestion;
            $answer->id_question_option = $IdOption;
        }

        return $answer;
    }

}
