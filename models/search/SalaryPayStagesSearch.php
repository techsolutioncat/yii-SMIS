<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalaryPayStages;

/**
 * SalaryPayStagesSearch represents the model behind the search form about `app\models\SalaryPayStages`.
 */
class SalaryPayStagesSearch extends SalaryPayStages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_pay_groups', 'amount'], 'integer'],
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
        $query = SalaryPayStages::find();

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
            'fk_pay_groups' => $this->fk_pay_groups,
            'amount' => $this->amount,
            'fk_branch_id' => $this->fk_branch_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
