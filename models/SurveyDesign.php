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
    public static $fontList = [
        'Default',
        'Roboto',
        'Oswald',
        'Montserrat',
        'Ubuntu',
        'Fjalla One',
        'Indie Flower',
        'Bitter',
        'Lobster',
        'Bree Serif',
        'Chewy',
    ];

    public static $colorList = [
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
            [['id_survey'], 'integer'],
            [['color', 'font_text', 'background_img'], 'string', 'max' => 255],
            [['background_img'], 'url'],
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


    public static function getAllFonts()
    {
        return array_combine(SurveyDesign::$fontList, SurveyDesign::$fontList);
    }

    public static function getAllColors()
    {
        return array_combine(SurveyDesign::$colorList, SurveyDesign::$colorList);
    }
}
