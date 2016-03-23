<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "survey_preferences".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property string $start_at
 * @property string $end_at
 * @property integer $sections_per_page
 * @property integer $questions_per_page
 * @property integer $allow_multi_submissions
 * @property integer $show_question_number
 * @property integer $randomize_questions
 * @property integer $show_progress
 * @property integer $send_response_notif
 * @property integer $show_share_btns
 * @property integer $password_protect
 * @property string $password_string
 * @property string $end_text
 * @property string $end_redirect
 */
class SurveyPreferences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_preferences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey', 'start_at'], 'required'],
            [['id_survey', 'sections_per_page', 'questions_per_page', 'allow_multi_submissions', 'show_question_number', 'randomize_questions', 'show_progress', 'send_response_notif', 'show_share_btns', 'password_protect'], 'integer'],
            [['start_at', 'end_at'], 'safe'],
            [['end_text'], 'string'],
            [['password_string', 'end_redirect'], 'string', 'max' => 255],
            [['id_survey'], 'exist', 'skipOnError' => true, 'targetClass' => Survey::className(), 'targetAttribute' => ['id_survey' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_survey' => Yii::t('app', 'Id Survey'),
            'start_at' => Yii::t('app', 'Start At'),
            'end_at' => Yii::t('app', 'End At'),
            'sections_per_page' => Yii::t('app', 'Display one section per page?'),
            'questions_per_page' => Yii::t('app', 'Display one question per page?'),
            'allow_multi_submissions' => Yii::t('app', 'Allow multiple submissions?'),
            'show_question_number' => Yii::t('app', 'Display question numbers?'),
            'randomize_questions' => Yii::t('app', 'Randomize questions order?'),
            'show_progress' => Yii::t('app', 'Show progress bar?'),
            'send_response_notif' => Yii::t('app', 'Receive response notifications by e-mail?'),
            'show_share_btns' => Yii::t('app', 'Show social networks sharing plugin?'),
            'password_protect' => Yii::t('app', 'Password protection?'),
            'password_string' => Yii::t('app', 'Set your password'),
            'end_text' => Yii::t('app', 'Show custom "Thank you" text'),
            'end_redirect' => Yii::t('app', 'Redirect to own webpage (URL)'),
        ];
    }

}
