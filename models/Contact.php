<?php

namespace app\models;

use Yii;

use yii\helpers\Html;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $id_contact_list
 * @property string $contact_name
 * @property string $contact_email
 *
 * @property ContactList $idContactList
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_contact_list', 'contact_email'], 'required'],
            [['id_contact_list'], 'integer'],
            [['contact_name', 'contact_email'], 'string', 'max' => 255],
            [['contact_email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_contact_list' => Yii::t('app', 'Id Contact List'),
            'contact_name' => Yii::t('app', 'Contact Name'),
            'contact_email' => Yii::t('app', 'Contact Email'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdContactList()
    {
        return $this->hasOne(ContactList::className(), ['id' => 'id_contact_list']);
    }

    public function sendInvitation($survey, $surveyContacts) {
        /** @var Mailer $mailer */
        /** @var Message $message */

        // modify view path to module views
        $mailer = Yii::$app->mailer;

        // send email
        $result = $mailer->compose('mail_box', ['survey'=>$survey, 'email'=>$this->contact_email, 'surveyContacts'=>$surveyContacts])
            ->setTo($this->contact_email)
            ->setSubject($surveyContacts->mail_subject);

        return $result;
    }
}
