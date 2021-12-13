<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeSalarySelection;

/**
 * EmployeeSalarySelectionSearch represents the model behind the search form of `app\models\EmployeeSalarySelection`.
 */
class EmployeeSalarySelectionSearch extends EmployeeSalarySelection
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_emp_id', 'fk_group_id', 'fk_pay_stages', 'fk_allownces_id', 'basic_salary'], 'integer'],
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
        $query = EmployeeSalarySelection::find();

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
            'fk_group_id' => $this->fk_group_id,
            'fk_pay_stages' => $this->fk_pay_stages,
            'fk_allownces_id' => $this->fk_allownces_id,
            'basic_salary' => $this->basic_salary,
        ]);

        return $dataProvider;
    }
}
