<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property integer $id_survey_section
 * @property integer $id_group_type
 * @property string $title
 * @property integer $optional
 * @property integer $add_textbox
 *
 * @property GroupType $idGroupType
 * @property SurveySection $idSurveySection
 * @property QuestionExtraitem[] $questionExtraitems
 * @property QuestionOption[] $questionOptions
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey_section', 'id_group_type', 'title'], 'required'],
            [['id_survey_section', 'id_group_type', 'optional', 'add_textbox'], 'integer'],
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
            'id_survey_section' => Yii::t('app', 'Id Survey Section'),
            'id_group_type' => Yii::t('app', 'Id Group Type'),
            'title' => Yii::t('app', 'Title'),
            'optional' => Yii::t('app', 'Optional'),
            'add_textbox' => Yii::t('app', 'Add Textbox'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGroupType()
    {
        return $this->hasOne(GroupType::className(), ['id' => 'id_group_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSurveySection()
    {
        return $this->hasOne(SurveySection::className(), ['id' => 'id_survey_section']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionExtraitems()
    {
        return $this->hasMany(QuestionExtraitem::className(), ['id_question' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionOptions()
    {
        return $this->hasMany(QuestionOption::className(), ['id_question' => 'id']);
    }
}
