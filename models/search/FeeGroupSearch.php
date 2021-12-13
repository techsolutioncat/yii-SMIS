<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeGroup;

/**
 * FeeGroupSearch represents the model behind the search form about `app\models\FeeGroup`.
 */
class FeeGroupSearch extends FeeGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_class_id', 'fk_fee_head_id', 'updated_by', 'fk_group_id', 'amount'], 'integer'],
            [['created_date', 'updated_date', 'is_active'], 'safe'],
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
        $query = FeeGroup::find();
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => array('pageSize' => 100),
//             'sort'=> ['defaultOrder' => ['fkGroup.title' => SORT_DESC]],
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
            'fk_class_id' => $this->fk_class_id,
            'fk_fee_head_id' => $this->fk_fee_head_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'fk_group_id' => $this->fk_group_id,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
