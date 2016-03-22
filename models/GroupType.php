<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_type".
 *
 * @property integer $id
 * @property integer $id_input_type
 * @property string $name
 * @property string $description
 *
 * @property InputType $idInputType
 * @property Question[] $questions
 */
class GroupType extends \yii\db\ActiveRecord
{
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
            [['id_input_type', 'name'], 'required'],
            [['id_input_type'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_input_type' => Yii::t('app', 'Id Input Type'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInputType()
    {
        return $this->hasOne(InputType::className(), ['id' => 'id_input_type']);
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
            10 => Yii::t('app','Dropdown Menu'),
        ];
    }
}
