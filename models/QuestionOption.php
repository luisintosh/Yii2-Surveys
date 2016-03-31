<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question_option".
 *
 * @property integer $id
 * @property integer $id_question
 * @property string $title
 *
 * @property Interview[] $interviews
 * @property Question $idQuestion
 */
class QuestionOption extends \yii\db\ActiveRecord
{

    public static $other_option_id = 'other-lka0KAOdjLKlkytytNMA30';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_question', 'title'], 'required'],
            [['id_question'], 'integer'],
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
            'id_question' => Yii::t('app', 'Id Question'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['id_question_option' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'id_question']);
    }

    public static function create($questionID, $title)
    {
        $questionOption = new QuestionOption();
        $questionOption->id_question = $questionID;
        $questionOption->title = $title;
        $questionOption->save();
        return $questionOption;
    }
}
