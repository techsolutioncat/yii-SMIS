<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmployeeParentsInfo;

/**
 * EmployeeParentsInfoSearch represents the model behind the search form of `app\models\EmployeeParentsInfo`.
 */
class EmployeeParentsInfoSearch extends EmployeeParentsInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_parent_id', 'fk_branch_id', 'cnic', 'emp_id', 'no_of_children'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'contact_no', 'profession', 'contact_no2', 'spouse_name'], 'safe'],
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
        $query = EmployeeParentsInfo::find();

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
            'emp_parent_id' => $this->emp_parent_id,
            'fk_branch_id' => $this->fk_branch_id,
            'cnic' => $this->cnic,
            'emp_id' => $this->emp_id,
            'no_of_children' => $this->no_of_children,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'contact_no2', $this->contact_no2])
            ->andFilterWhere(['like', 'spouse_name', $this->spouse_name]);

        return $dataProvider;
    }
}
