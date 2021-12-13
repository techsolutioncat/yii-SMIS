<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeeHeadWise as FeeHeadWiseModel;

/**
 * FeeHeadWise represents the model behind the search form about `app\models\FeeHeadWise`.
 */
class FeeHeadWise extends FeeHeadWiseModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_stu_id', 'fk_fee_particular_id', 'payment_received', 'fk_chalan_id', 'updated_by'], 'integer'],
            [['is_paid', 'created_date', 'updated_date'], 'safe'],
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
        $query = FeeHeadWiseModel::find();

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
            'fk_stu_id' => $this->fk_stu_id,
            'fk_fee_particular_id' => $this->fk_fee_particular_id,
            'payment_received' => $this->payment_received,
            'fk_chalan_id' => $this->fk_chalan_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'is_paid', $this->is_paid]);

        return $dataProvider;
    }
}
