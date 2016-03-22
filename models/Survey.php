<?php

namespace app\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "survey".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $logo_url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AnswerDetail[] $answerDetails
 * @property User $idUser
 * @property SurveyComment[] $surveyComments
 * @property SurveyContacts[] $surveyContacts
 * @property SurveyDesign[] $surveyDesigns
 * @property SurveyPreferences[] $surveyPreferences
 * @property SurveySection[] $surveySections
 */
class Survey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'title'], 'required'],
            [['id_user', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'logo_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'logo_url' => Yii::t('app', 'Logo Url'),
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
    public function getAnswerDetails()
    {
        return $this->hasMany(AnswerDetail::className(), ['id_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyComments()
    {
        return $this->hasMany(SurveyComment::className(), ['id_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyContacts()
    {
        return $this->hasMany(SurveyContacts::className(), ['id_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyDesigns()
    {
        return $this->hasMany(SurveyDesign::className(), ['id_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyPreferences()
    {
        return $this->hasMany(SurveyPreferences::className(), ['id_survey' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveySections()
    {
        return $this->hasMany(SurveySection::className(), ['id_survey' => 'id']);
    }


    /**
     * Create, load and save a set of models.
     * @param $modelClass = Model::className()
     * @param $post = Yii::$app->request->post()
     * @return bool
     */
    public static function saveMultipleData($modelClass, $post) {
        $m    = new $modelClass; // new Model()
        $formName = $m->formName(); // String: Model
        $post     = $post[$formName];
        // $models   = []; // array of models
        $success  = true; // saved or no

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) { // $post: [[id=>...],[id=>...],[id=>...]]
                if (isset($item['id']) && !empty($item['id']) && $success) {
                    $model = $m::findOne($item['id']);
                    $success = $model->load($item, '');
                    $success = $success && $model->save();
                }
            }
        }
        else {
            $success = false;
        }

        return $success;
    }

    public static function applyAction(array $action = [])
    {
        $success = false;
        if ($action && is_array($action) && isset($action['type']) && isset($action['section']) && isset($action['question']) && isset($action['option'])) {

            if ($action['type'] === 'delete-section' ) {
                $success = SurveySection::findOne($action['section'])->delete();

            } else if ($action['type'] === 'new-section') {
                $m = new SurveySection();
                $m->id_survey = $action['survey'];
                $success = $m->save();

            } else if ($action['type'] === 'delete-question') {
                Question::findOne($action['question'])->delete();

            } else if ($action['type'] === 'new-question') {
                $m = new Question();
                $m->id_survey_section = $action['section'];
                $m->id_group_type = 1;
                $m->title = 'New Question...';
                $success = $m->save();

            } else if ($action['type'] === 'delete-opcion') {
                $success = QuestionOption::findOne($action['option'])->delete();

            } else if ($action['type'] === 'new-option') {
                $m = new QuestionOption();
                $m->id_question = $action['question'];
                $m->title = 'Answer...';
                $success = $m->save();

            }
            else if ($action['type'] === 'delete-survey') {
                $success = Survey::findOne($action['survey'])->delete();

            }
            else if ($action['type'] === 'publish-survey') {
                $m = Survey::findOne($action['survey']);
                $m->status = 1;
                $success = $m->save();

            }
        }

        return $success;
    }

    /*
     * ROT13 simple letter substitution cipher
     * https://en.wikipedia.org/wiki/ROT13
     */
    public static function numhash($n)
    {
        return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
    }

    public function getId()
    {
        return $this->numhash($this->id);
    }
}
