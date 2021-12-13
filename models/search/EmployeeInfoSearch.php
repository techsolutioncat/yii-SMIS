<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeInfo;

/**
 * EmployeeInfoSearch represents the model behind the search form of `app\models\EmployeeInfo`.
 */
class EmployeeInfoSearch extends EmployeeInfo
{
   // public $globalSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'fk_branch_id', 'gender_type', 'guardian_type_id', 'country_id', 'province_id', 'city_id', 'designation_id', 'marital_status', 'department_type_id', 'salary', 'religion_type_id', 'district_id'], 'integer'],
            [['dob', 'contact_no','emergency_contact_no', 'hire_date', 'location1', 'Nationality', 'location2', 'cnic','is_active'], 'safe'],
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
        $query = EmployeeInfo::find();

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
            'emp_id' => $this->emp_id,
            'fk_branch_id' => $this->fk_branch_id,
            'dob' => $this->dob,
            'gender_type' => $this->gender_type,
            'guardian_type_id' => $this->guardian_type_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'hire_date' => $this->hire_date,
            'designation_id' => $this->designation_id,
            'marital_status' => $this->marital_status,
            'department_type_id' => $this->department_type_id,
            'salary' => $this->salary,
            'religion_type_id' => $this->religion_type_id,
            'district_id' => $this->district_id,
        ]);

        
           $query->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'emergency_contact_no', $this->emergency_contact_no])
            ->andFilterWhere(['like', 'location1', $this->location1])
            ->andFilterWhere(['like', 'Nationality', $this->Nationality])
            ->andFilterWhere(['like', 'location2', $this->location2])
            ->andFilterWhere(['like', 'cnic', $this->cnic])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        // $query->andFilterWhere(['like', 'contact_no', $this->globalSearch])
        //     ->andFilterWhere(['like', 'emergency_contact_no', $this->globalSearch])
        //     ->andFilterWhere(['like', 'location1', $this->globalSearch])
        //     ->andFilterWhere(['like', 'Nationality', $this->globalSearch])
        //     ->andFilterWhere(['like', 'location2', $this->globalSearch])
        //     ->andFilterWhere(['like', 'cnic', $this->globalSearch]);

        return $dataProvider;
    }
}
