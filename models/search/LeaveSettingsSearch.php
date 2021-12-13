<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LeaveSettings;
             
                                                                   
/**
 * LeaveSettingsSearch represents the model behind the search form about `app\models\LeaveSettings`.
 */                           
class LeaveSettingsSearch extends LeaveSettings
{                         
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'branch_id', 'status'], 'integer'],
            [['allowed_leaves', 'shortleave_policy', 'latecommer_policy'], 'safe'],
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
        $query = LeaveSettings::find();

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
            'branch_id' => $this->branch_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'allowed_leaves', $this->allowed_leaves])
            ->andFilterWhere(['like', 'shortleave_policy', $this->shortleave_policy])
            ->andFilterWhere(['like', 'latecommer_policy', $this->latecommer_policy]);

        return $dataProvider;
    }
}
