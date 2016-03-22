<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question_extraitem".
 *
 * @property integer $id
 * @property integer $id_question
 * @property string $tip
 * @property string $image_url
 * @property string $videoyt_url
 * @property string $soundcloud_url
 *
 * @property Question $idQuestion
 */
class QuestionExtraitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_extraitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_question'], 'required'],
            [['id_question'], 'integer'],
            [['tip', 'image_url', 'videoyt_url', 'soundcloud_url'], 'string', 'max' => 255]
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
            'tip' => Yii::t('app', 'Tip'),
            'image_url' => Yii::t('app', 'Image Url'),
            'videoyt_url' => Yii::t('app', 'Videoyt Url'),
            'soundcloud_url' => Yii::t('app', 'Soundcloud Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'id_question']);
    }
}
