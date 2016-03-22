<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Survey;

/**
 * SurveySearch represents the model behind the search form about `app\models\Survey`.
 */
class SurveySearch extends Survey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'status'], 'integer'],
            [['title', 'description', 'logo_url', 'created_at', 'updated_at'], 'safe'],
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
        $query = Survey::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // query
        $createdFrom = '';
        $createdTo = '';
        $updatedFrom = '';
        $updatedTo = '';

        $this->load($params);

        if (!empty($this->created_at)) {
            $createdArr = explode('-',$this->created_at);
            $createdFrom = $createdArr[0];
            $createdFrom = str_replace('/', '-', $createdFrom);
            $createdTo = $createdArr[1];
            $createdTo = str_replace('/', '-', $createdTo);
        }
        if (!empty($this->updated_at)) {
            $updatedArr = explode('-',$this->created_at);
            $updatedFrom = $updatedArr[0];
            $updatedFrom = str_replace('/', '-', $updatedFrom);
            $updatedTo = $updatedArr[1];
            $updatedTo = str_replace('/', '-', $updatedTo);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => (Yii::$app->user->can('admin')) ? '' : Yii::$app->user->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'logo_url', $this->logo_url])
            ->andFilterWhere(['between', 'created_at', $createdFrom, $createdTo])
            ->andFilterWhere(['between', 'updated_at', $updatedFrom, $updatedTo]);

        return $dataProvider;
    }
}
