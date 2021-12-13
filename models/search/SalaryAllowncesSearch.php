<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalaryAllownces;

/**
 * SalaryAllowncesSearch represents the model behind the search form about `app\models\SalaryAllownces`.
 */
class SalaryAllowncesSearch extends SalaryAllownces
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_stages_id', 'amount'], 'integer'],
            [['id', 'fk_stages_id', 'amount', 'fk_branch_id', 'status'], 'integer'],
            [['title'], 'safe'],
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
        $query = SalaryAllownces::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fk_stages_id' => $this->fk_stages_id,
            'amount' => $this->amount,
            'fk_branch_id' => $this->fk_branch_id, 
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
