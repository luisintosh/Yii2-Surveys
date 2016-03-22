<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer_detail".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property string $id_cookie
 * @property string $contact_email
 * @property string $refer_url
 * @property string $country
 * @property string $web_browser
 * @property string $platform
 *
 * @property Survey $idSurvey
 */
class AnswerDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey', 'id_cookie'], 'required'],
            [['id_survey'], 'integer'],
            [['id_cookie', 'contact_email', 'refer_url', 'country', 'web_browser', 'platform'], 'string', 'max' => 255],
            [['id_cookie'], 'unique']
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
            'id_cookie' => Yii::t('app', 'Id Cookie'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'refer_url' => Yii::t('app', 'Refer Url'),
            'country' => Yii::t('app', 'Country'),
            'web_browser' => Yii::t('app', 'Web Browser'),
            'platform' => Yii::t('app', 'Platform'),
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
