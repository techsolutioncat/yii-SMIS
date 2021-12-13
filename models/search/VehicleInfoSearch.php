<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VehicleInfo;
/** 
 * searchVehicleInfoSearch represents the model behind the search form about `app\models\VehicleInfo`.
 */
class VehicleInfoSearch extends VehicleInfo
{           
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'no_of_seats','fk_branch_id'], 'integer'],
            [['Name', 'registration_no', 'model', 'vehicle_make'], 'safe'],
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
        $query = VehicleInfo::find();

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
            'no_of_seats' => $this->no_of_seats,
            'fk_branch_id' => $this->fk_branch_id,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'registration_no', $this->registration_no])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'vehicle_make', $this->vehicle_make]);

        return $dataProvider;
    }
}
         