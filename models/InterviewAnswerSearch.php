<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InterviewAnswer;

/**
 * InterviewAnswerSearch represents the model behind the search form about `app\models\InterviewAnswer`.
 */
class InterviewAnswerSearch extends InterviewAnswer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_interview', 'id_question', 'number', 'a_number', 'a_bool'], 'integer'],
            [['a_text', 'a_date', 'a_time'], 'safe'],
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
    public function search($params)
    {
        $query = InterviewAnswer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_interview' => $this->id_interview,
            'id_question' => $this->id_question,
            'number' => $this->number,
            'a_number' => $this->a_number,
            'a_bool' => $this->a_bool,
            'a_date' => $this->a_date,
            'a_time' => $this->a_time,
        ]);

        $query->andFilterWhere(['like', 'a_text', $this->a_text]);

        return $dataProvider;
    }
}
