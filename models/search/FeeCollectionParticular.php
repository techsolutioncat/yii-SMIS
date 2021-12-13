<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeCollectionParticular as FeeCollectionParticularModel;

/**
 * FeeCollectionParticular represents the model behind the search form of `app\models\FeeCollectionParticular`.
 */
class FeeCollectionParticular extends FeeCollectionParticularModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_stu_id', 'total_fee_amount', 'fk_fine_id', 'transport_fare', 'fk_fee_discount_id', 'fee_payable', 'is_active'], 'integer'],
            [['due_date'], 'safe'],
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
        $query = FeeCollectionParticularModel::find();

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
            'fk_stu_id' => $this->fk_stu_id,
            'fk_fee_particular_id' => $this->total_fee_amount,
            'fk_fine_id' => $this->fk_fine_id,
            'transport_fare' => $this->transport_fare,
            'fk_fee_discount_id' => $this->fk_fee_discount_id,
            'fee_payable' => $this->fee_payable,
            'is_active' => $this->is_active,
            'due_date' => $this->due_date,
        ]);

        return $dataProvider;
    }
}
