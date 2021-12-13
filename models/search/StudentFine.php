<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentFineDetail;

/**
 * StudentFine represents the model behind the search form about `app\models\StudentFineDetail`.
 */
class StudentFine extends StudentFineDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_fine_typ_id', 'amount'], 'integer'],
            [['remarks', 'created_date', 'updated_date', 'is_active'], 'safe'],
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
        $query = StudentFineDetail::find();

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
            'fk_fine_typ_id' => $this->fk_fine_typ_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
