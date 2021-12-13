<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefDepartment;

/**
 * RefDepartmentSearch represents the model behind the search form about `app\models\RefDepartment`.
 */
class RefDepartmentSearch extends RefDepartment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_type_id','fk_branch_id'], 'integer'],
            [['Title'], 'safe'],
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
        $query = RefDepartment::find();

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
            'department_type_id' => $this->department_type_id,
            'fk_branch_id' => $this->fk_branch_id,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title]);

        return $dataProvider;
    }
}
