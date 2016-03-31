<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "interview".
 *
 * @property integer $id
 * @property integer $id_survey
 * @property string $unique
 * @property string $contact_email
 * @property string $refer_url
 * @property string $country
 * @property string $web_browser
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Survey $idSurvey
 * @property InterviewAnswer[] $interviewAnswers
 */
class Interview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interview';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_survey'], 'required'],
            [['id_survey', 'created_at', 'updated_at'], 'integer'],
            [['unique', 'contact_email', 'refer_url', 'country', 'web_browser'], 'string', 'max' => 255],
            [['id_survey'], 'exist', 'skipOnError' => true, 'targetClass' => Survey::className(), 'targetAttribute' => ['id_survey' => 'id']],
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
            'unique' => Yii::t('app', 'Unique'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'refer_url' => Yii::t('app', 'Refer Url'),
            'country' => Yii::t('app', 'Country'),
            'web_browser' => Yii::t('app', 'Web Browser'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'id_survey']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewAnswers()
    {
        return $this->hasMany(InterviewAnswer::className(), ['id_interview' => 'id']);
    }

    public static function createInterview($surveyId, $email)
    {
        $interview = new Interview();
        $interview->id_survey = $surveyId;
        $interview->contact_email = $email;
        $interview->refer_url = Yii::$app->request->getHeaders()['referer'];
        $interview->country = '';
        $interview->web_browser = '';

        return $interview;
    }

    public static function getAllResponses($userId)
    {
        $totalResponses = (new Query())->select('')->from('survey s')
            ->andFilterWhere(['id_user'=>$userId])
            ->innerJoin('interview int', 'int.id_survey = s.id')
            ->select('int.*')->count();

        return $totalResponses;
    }

    public static function getAllResponsesThisWeek($userId)
    {
        $totalResponses = (new Query())->select('')->from('survey s')
            ->andFilterWhere(['id_user'=>$userId])
            ->innerJoin('interview int', 'int.id_survey = s.id')
            ->select('int.*')
            ->where(['between', 'int.created_at', Yii::$app->formatter->asTimestamp(time()-(7 * 24 * 60 * 60)), Yii::$app->formatter->asTimestamp(time())])
            ->count();

        return $totalResponses;
    }

}
