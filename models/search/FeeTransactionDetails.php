<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeTransactionDetails as FeeTransactionDetailsModel;

/**
 * FeeTransactionDetails represents the model behind the search form of `app\models\FeeTransactionDetails`.
 */
class FeeTransactionDetails extends FeeTransactionDetailsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stud_id', 'fk_fee_collection_particular', 'opening_balance', 'transaction_amount', 'fk_branch_id'], 'integer'],
            [['challan_no', 'transaction_date'], 'safe'],
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
        $query = FeeTransactionDetailsModel::find();

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
            'stud_id' => $this->stud_id,
            'fk_fee_collection_particular' => $this->fk_fee_collection_particular,
            'transaction_date' => $this->transaction_date,
            'opening_balance' => $this->opening_balance,
            'transaction_amount' => $this->transaction_amount,
            'fk_branch_id' => $this->fk_branch_id,
        ]);

        $query->andFilterWhere(['like', 'challan_no', $this->challan_no]);

        return $dataProvider;
    }
}
