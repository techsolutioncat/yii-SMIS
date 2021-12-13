<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VisitorResponseInfo;

/**
 * VisitorResponseInfoSearch represents the model behind the search form of `app\models\VisitorResponseInfo`.
 */
class VisitorResponseInfoSearch extends VisitorResponseInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_admission_vistor_id'], 'integer'],
            [['first_attempt_date', 'second_attempt_date', 'third_attempt_date', 'remarks'], 'safe'],
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
        $query = VisitorResponseInfo::find();

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
            'fk_admission_vistor_id' => $this->fk_admission_vistor_id,
            'first_attempt_date' => $this->first_attempt_date,
            'second_attempt_date' => $this->second_attempt_date,
            'third_attempt_date' => $this->third_attempt_date,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
