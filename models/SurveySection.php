<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "survey_section".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property string $title
 * @property string $description
 *
 * @property Survey $idSurvey
 * @property Question[] $questions
 */
class SurveySection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey'], 'required'],
            [['id_survey'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255]
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'id_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id_survey_section' => 'id']);
    }

    public static function create($surveyID)
    {
        $section = new SurveySection();
        $section->id_survey = $surveyID;
        $section->save();

        return $section;
    }
}
