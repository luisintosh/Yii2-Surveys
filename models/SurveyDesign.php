<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "survey_design".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property string $color
 * @property integer $font_text
 * @property string $background_img
 *
 * @property Survey $idSurvey
 */
class SurveyDesign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_design';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey'], 'required'],
            [['id_survey', 'font_text'], 'integer'],
            [['color', 'background_img'], 'string', 'max' => 255]
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
            'color' => Yii::t('app', 'Color'),
            'font_text' => Yii::t('app', 'Font Text'),
            'background_img' => Yii::t('app', 'Background Img'),
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
