<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeParticulars as FeeParticularsModel;

/**
 * FeeParticulars represents the model behind the search form about `app\models\FeeParticulars`.
 */
class FeeParticulars extends FeeParticularsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_fee_head_id', 'fk_fee_plan_type', 'fk_stu_id'], 'integer'],
            [['created_date', 'updated_date', 'is_paid'], 'safe'],
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
        $query = FeeParticularsModel::find();

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
            'fk_branch_id' => $this->fk_branch_id,
            'fk_fee_head_id' => $this->fk_fee_head_id,
            'fk_fee_plan_type' => $this->fk_fee_plan_type,
            'fk_stu_id' => $this->fk_stu_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'is_active', $this->is_paid]);

        return $dataProvider;
    }
}
