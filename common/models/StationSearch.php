<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Station;

/**
 * StationSearch represents the model behind the search form of `common\models\Station`.
 */
class StationSearch extends Station
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'installer', 'user', 'status', 'type'], 'integer'],
            [['location', 'cell', 'inverter', 'collector', 'title', 'remark'], 'safe'],
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
        $query = Station::find();

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
            'installer' => $this->installer,
            'user' => $this->user,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'type' => $this->type,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'cell', $this->cell])
            ->andFilterWhere(['like', 'inverter', $this->inverter])
            ->andFilterWhere(['like', 'collector', $this->collector])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
