<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "survey_contacts".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property integer $id_contact_list
 *
 * @property ContactList $idContactList
 * @property Survey $idSurvey
 */
class SurveyContacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey', 'id_contact_list'], 'required'],
            [['id_survey', 'id_contact_list'], 'integer']
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
            'id_contact_list' => Yii::t('app', 'Id Contact List'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdContactList()
    {
        return $this->hasOne(ContactList::className(), ['id' => 'id_contact_list']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'id_survey']);
    }
}
