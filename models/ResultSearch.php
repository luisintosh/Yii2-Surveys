<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * InterviewSearch represents the model behind the search form about `app\models\Interview`.
 */
class ResultSearch extends Result
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique','email','ip_address','country','web_browser','survey_title','section_title','question_title','answer'], 'string'],
            [['created_at','updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $surveyId)
    {
        $query = new Query();
        $query->from('survey');
        $query->select([
            'interview.unique as unique',
            'interview.contact_email as email',
            'interview.ip_address as ip_address',
            'interview.country as country',
            'interview.web_browser as web_browser',
            'interview.created_at as created_at',
            'interview.updated_at as updated_at',
            'survey.title as survey_title',
            'survey_section.title as section_title',
            'question.title as question_title',
            'IFNULL(IFNULL(IFNULL(IFNULL(interview_answer.a_text, interview_answer.a_number),interview_answer.a_bool),interview_answer.a_date),interview_answer.a_time) AS answer'
            ])
        ->innerJoin('survey_section','survey_section.id_survey = survey.id')
        ->innerJoin('question','question.id_survey_section = survey_section.id')
        ->innerJoin('interview','interview.id_survey = survey.id')
        ->innerJoin('interview_answer','interview_answer.id_interview = interview.id')
        ->where(['survey.id'=>$surveyId]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'interview.unique' => $this->unique,
            'interview.contact_email' => $this->email,
            'interview.ip_address' => $this->ip_address,
            'interview.country' => $this->country,
            'interview.web_browser' => $this->web_browser,
            'survey.title' => $this->survey_title,
            'survey_section.title' => $this->section_title,
            'question.title' => $this->question_title,
            'interview.created_at' => $this->created_at,
            'interview.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'IFNULL(IFNULL(IFNULL(IFNULL(interview_answer.a_text, interview_answer.a_number),interview_answer.a_bool),interview_answer.a_date),interview_answer.a_time)', $this->answer]);
  
        return $dataProvider;
    }
}
