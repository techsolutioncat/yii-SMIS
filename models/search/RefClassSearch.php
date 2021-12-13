<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefClass;

/**
 * RefClassSearch represents the model behind the search form about `app\models\RefClass`.
 */
class RefClassSearch extends RefClass
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'fk_branch_id', 'fk_session_id'], 'integer'],
            [['title','status'], 'safe'],
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
        $query = RefClass::find();

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
            'class_id' => $this->class_id,
            'fk_branch_id' => $this->fk_branch_id,
            'fk_session_id' => $this->fk_session_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'title', $this->title])
           ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
