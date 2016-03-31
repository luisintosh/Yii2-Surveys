<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_type".
 *
 * @property integer $id
 * @property string $input_type
 * @property string $name
 * @property string $description
 *
 * @property InputType $idInputType
 * @property Question[] $questions
 */
class GroupType extends \yii\db\ActiveRecord
{

    public static $input_types = [
        'text',
        'text_area',
        'radio',
        'checkbox',
        'date',
        'time',
    ];

    public static $TEXT_ANSWER = 1;
    public static $TEXT_BLOCK_ANSWER = 2;
    public static $NUMBER_ANSWER = 3;
    public static $SINGLE_CHOICE = 4;
    public static $MULTIPLE_CHOICE = 5;
    public static $LINEAR_SCALE = 6;
    public static $TRUE_FALSE = 7;
    public static $DATE_FIELD = 8;
    public static $TIME_FIELD = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_type', 'name'], 'required'],
            [['input_type'], 'unique'],
            [['input_type', 'name', 'description'], 'string', 'max' => 255],
            [['input_type', 'name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'input_type' => Yii::t('app', 'Input Type'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id_group_type' => 'id']);
    }


    public static function getAllTypes()
    {
        return [
            1 => Yii::t('app','Text Answer'),
            2 => Yii::t('app','Text Block Answer'),
            3 => Yii::t('app','Number Answer'),
            4 => Yii::t('app','Single Choice'),
            5 => Yii::t('app','Multiple Choice'),
            6 => Yii::t('app','Linear Scale'),
            7 => Yii::t('app','True or False'),
            8 => Yii::t('app','Date Field'),
            9 => Yii::t('app','Time Field'),
        ];
    }

    public static function getTypeString($id)
    {
        return self::getAllTypes()[$id];
    }
}
