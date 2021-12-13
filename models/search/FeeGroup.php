<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeGroup as FeeGroupModel;

/**
 * FeeGroup represents the model behind the search form of `app\models\FeeGroup`.
 */
class FeeGroup extends FeeGroupModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_class_id', 'fk_fee_head_id', 'updated_by', 'is_active', 'fk_group_id', 'amount'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
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
        $query = FeeGroupModel::find();

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
            'fk_branch_id' => $this->fk_branch_id,
            'fk_class_id' => $this->fk_class_id,
            'fk_fee_head_id' => $this->fk_fee_head_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'fk_group_id' => $this->fk_group_id,
            'amount' => $this->amount,
        ]);

        return $dataProvider;
    }
}
