<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeDiscounts as FeeDiscountsModel;

/**
 * FeeDiscounts represents the model behind the search form about `app\models\FeeDiscounts`.
 */
class FeeDiscounts extends FeeDiscountsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_fee_discounts_type_id', 'fk_fee_particular_id', 'amount', 'is_active'], 'integer'],
            [['remarks'], 'safe'],
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
        $query = FeeDiscountsModel::find();

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
            'fk_fee_discounts_type_id' => $this->fk_fee_discounts_type_id,
            'fk_fee_particular_id' => $this->fk_fee_particular_id,
            'amount' => $this->amount,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
