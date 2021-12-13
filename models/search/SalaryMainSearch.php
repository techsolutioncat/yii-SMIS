<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalaryMain;

/**
 * SalaryMainSearch represents the model behind the search form of `app\models\SalaryMain`.
 */
class SalaryMainSearch extends SalaryMain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_pay_stages', 'fk_emp_id', 'basic_salary', 'bonus', 'deduction_amount', 'fk_tax_id', 'gross_salary', 'is_paid', 'tax_amount'], 'integer'],
            [['salary_month', 'payment_date'], 'safe'],
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
        $query = SalaryMain::find();

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
            'fk_pay_stages' => $this->fk_pay_stages,
            'fk_emp_id' => $this->fk_emp_id,
            'basic_salary' => $this->basic_salary,
            'bonus' => $this->bonus,
            'deduction_amount' => $this->deduction_amount,
            'fk_tax_id' => $this->fk_tax_id,
            'gross_salary' => $this->gross_salary,
            'salary_month' => $this->salary_month,
            'is_paid' => $this->is_paid,
            'payment_date' => $this->payment_date,
            'tax_amount' => $this->tax_amount,
        ]);

        return $dataProvider;
    }
}
