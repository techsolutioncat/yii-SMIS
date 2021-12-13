<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransportMain;

/**
 * searchTransportMainSearch represents the model behind the search form about `app\models\TransportMain`.
 */
class searchTransportMainSearch extends TransportMain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_route_id', 'fk_driver_id', 'fk_vechicle_info_id'], 'integer'],
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
        $query = TransportMain::find();

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
            'fk_route_id' => $this->fk_route_id,
            'fk_driver_id' => $this->fk_driver_id,
            'fk_vechicle_info_id' => $this->fk_vechicle_info_id,
        ]);

        return $dataProvider;
    }
}
