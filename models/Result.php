<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interview".
 */
class Result extends \yii\db\ActiveRecord
{
    // attributes
    public $unique;
    public $email;
    public $ip_address;
    public $country;
    public $web_browser;
    public $survey_title;
    public $section_title;
    public $question_title;
    public $answer;
    public $created_at;
    public $updated_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique','email','ip_address','country','web_browser','survey_title','section_title','question_title','answer'], 'string'],
            [['created_at','updated_at','safe']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unique' => Yii::t('app','ID'),
            'email' => Yii::t('app','Email'),
            'ip_address' => Yii::t('app','IP'),
            'country' => Yii::t('app','Country'),
            'web_browser' => Yii::t('app','Browser'),
            'survey_title' => Yii::t('app','Survey Title'),
            'section_title' => Yii::t('app','Section Title'),
            'question_title' => Yii::t('app','Question Title'),
            'answer' => Yii::t('app','Answer'),
            'created_at' => Yii::t('app','Created on'),
            'updated_at' => Yii::t('app','Updated on'),
        ];
    }
}
