<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property integer $id
 * @property integer $id_question_option
 * @property integer $a_number
 * @property string $a_text
 * @property integer $a_bool
 * @property string $a_date
 * @property string $a_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property QuestionOption $idQuestionOption
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_question_option'], 'required'],
            [['id_question_option', 'a_number', 'a_bool'], 'integer'],
            [['a_text'], 'string'],
            [['a_date', 'a_time', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_question_option' => Yii::t('app', 'Id Question Option'),
            'a_number' => Yii::t('app', 'A Number'),
            'a_text' => Yii::t('app', 'A Text'),
            'a_bool' => Yii::t('app', 'A Bool'),
            'a_date' => Yii::t('app', 'A Date'),
            'a_time' => Yii::t('app', 'A Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => function ($event) {
                    return gmdate("Y-m-d H:i:s");
                },
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuestionOption()
    {
        return $this->hasOne(QuestionOption::className(), ['id' => 'id_question_option']);
    }
}
