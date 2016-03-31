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
            [['tip', 'image_url', 'videoyt_url', 'soundcloud_url'], 'string', 'max' => 255],
            [['image_url', 'videoyt_url', 'soundcloud_url'], 'url'],
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
            'image_url' => Yii::t('app', 'Add Image URL'),
            'videoyt_url' => Yii::t('app', 'Add Youtube Video URL'),
            'soundcloud_url' => Yii::t('app', 'Add Soundcloud URL'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'id_question']);
    }

    public static function create($questionID)
    {
        $questionExtraitem = new QuestionExtraitem();
        $questionExtraitem->id_question = $questionID;
        $questionExtraitem->save();

        return $questionExtraitem;
    }
}
