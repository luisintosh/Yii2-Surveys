<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "survey_preferences".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property integer $status
 * @property string $start_at
 * @property string $end_at
 * @property string $end_msg
 * @property integer $onesection_perpage
 * @property integer $can_multiple_sendings
 * @property integer $can_returnsection
 * @property integer $show_section_number
 * @property integer $random_question
 * @property integer $show_progressbar
 * @property integer $email_notifications
 * @property integer $can_social_share
 * @property integer $private
 * @property string $private_password
 * @property integer $redirection_type
 * @property string $redirection_url
 *
 * @property Survey $idSurvey
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
            [['id_survey', 'onesection_perpage', 'can_multiple_sendings', 'can_returnsection', 'show_section_number', 'random_question', 'show_progressbar', 'email_notifications', 'can_social_share', 'private', 'redirection_type'], 'integer'],
            [['start_at', 'end_at'], 'safe'],
            [['end_msg'], 'string'],
            [['private_password', 'redirection_url'], 'string', 'max' => 255]
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
            'end_msg' => Yii::t('app', 'End Msg'),
            'onesection_perpage' => Yii::t('app', 'Onesection Perpage'),
            'can_multiple_sendings' => Yii::t('app', 'Can Multiple Sendings'),
            'can_returnsection' => Yii::t('app', 'Can Returnsection'),
            'show_section_number' => Yii::t('app', 'Show Section Number'),
            'random_question' => Yii::t('app', 'Random Question'),
            'show_progressbar' => Yii::t('app', 'Show Progressbar'),
            'email_notifications' => Yii::t('app', 'Email Notifications'),
            'can_social_share' => Yii::t('app', 'Can Social Share'),
            'private' => Yii::t('app', 'Private'),
            'private_password' => Yii::t('app', 'Private Password'),
            'redirection_type' => Yii::t('app', 'Redirection Type'),
            'redirection_url' => Yii::t('app', 'Redirection Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'id_survey']);
    }
}
