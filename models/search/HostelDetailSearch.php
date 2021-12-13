<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HostelDetail;

/**
 * HostelDetailSearch represents the model behind the search form about `app\models\HostelDetail`.
 */
class HostelDetailSearch extends HostelDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_hostel_id', 'fk_floor_id', 'fk_room_id', 'fk_bed_id', 'fk_student_id','fk_branch_id'], 'integer'],
            [['is_booked', 'create_date'], 'safe'],
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
        $query = HostelDetail::find();

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
            'fk_hostel_id' => $this->fk_hostel_id,
            'fk_floor_id' => $this->fk_floor_id,
            'fk_room_id' => $this->fk_room_id,
            'fk_bed_id' => $this->fk_bed_id,
            'fk_student_id' => $this->fk_student_id,
            'create_date' => $this->create_date,
            'fk_branch_id' => $this->fk_branch_id,
        ]);

        $query->andFilterWhere(['like', 'is_booked', $this->is_booked]);

        return $dataProvider;
    }
}
