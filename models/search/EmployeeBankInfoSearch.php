<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeBankInfo;

/**
 * EmployeeBankInfoSearch represents the model behind the search form of `app\models\EmployeeBankInfo`.
 */
class EmployeeBankInfoSearch extends EmployeeBankInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_emp_id', 'branch_code'], 'integer'],
            [['bank_name', 'branch_name', 'account_no'], 'safe'],
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
        $query = EmployeeBankInfo::find();

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
            'fk_emp_id' => $this->fk_emp_id,
            'branch_code' => $this->branch_code,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
            ->andFilterWhere(['like', 'account_no', $this->account_no]);

        return $dataProvider;
    }
}
