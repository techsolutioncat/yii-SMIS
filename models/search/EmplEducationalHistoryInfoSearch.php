<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmplEducationalHistoryInfo;

/**
 * EmplEducationalHistoryInfoSearch represents the model behind the search form of `app\models\EmplEducationalHistoryInfo`.
 */
class EmplEducationalHistoryInfoSearch extends EmplEducationalHistoryInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['edu_history_id', 'fk_branch_id', 'degree_type_id', 'emp_id'], 'integer'],
            [['degree_name', 'Institute_name', 'institute_type_id', 'grade', 'total_marks', 'start_date', 'end_date', 'marks_obtained'], 'safe'],
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
        $query = EmplEducationalHistoryInfo::find();

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
            'edu_history_id' => $this->edu_history_id,
            'fk_branch_id' => $this->fk_branch_id,
            'degree_type_id' => $this->degree_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'emp_id' => $this->emp_id,
        ]);

        $query->andFilterWhere(['like', 'degree_name', $this->degree_name])
            ->andFilterWhere(['like', 'Institute_name', $this->Institute_name])
            ->andFilterWhere(['like', 'institute_type_id', $this->institute_type_id])
            ->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'total_marks', $this->total_marks])
            ->andFilterWhere(['like', 'marks_obtained', $this->marks_obtained]);

        return $dataProvider;
    }
}
