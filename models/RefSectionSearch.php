<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefSection;

/**
 * RefSectionSearch represents the model behind the search form about `app\models\RefSection`.
 */
class RefSectionSearch extends RefSection
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'fk_branch_id', 'class_id'], 'integer'],
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
        $query = RefSection::find();

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
            'section_id' => $this->section_id,
            'fk_branch_id' => $this->fk_branch_id,
            'class_id' => $this->class_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
