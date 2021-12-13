<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefDesignation;

/**
 * refDesignationSearch represents the model behind the search form about `app\models\RefDesignation`.
 */
class refDesignationSearch extends RefDesignation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation_id', 'fk_branch_id', 'fk_department_id'], 'integer'],
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
        $query = RefDesignation::find();

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
            'designation_id' => $this->designation_id,
            'fk_branch_id' => $this->fk_branch_id,
            'fk_department_id' => $this->fk_department_id,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title]);

        return $dataProvider;
    }
}
