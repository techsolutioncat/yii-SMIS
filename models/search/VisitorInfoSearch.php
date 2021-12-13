<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VisitorInfo;

/**
 * VisitorInfoSearch represents the model behind the search form of `app\models\VisitorInfo`.
 */
class VisitorInfoSearch extends VisitorInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contact_no', 'fk_adv_med_id', 'fk_class_id','is_active', 'fk_vistor_category', 'designation','fk_branch_id'], 'integer'],
            [['name', 'cnic', 'date_of_visit', 'product_name', 'product_description', 'last_degree', 'experiance', 'last_organization', 'qualification', 'reference', 'organization', 'address'], 'safe'],
            [['id', 'fk_branch_id', 'fk_adv_med_id', 'fk_class_id', 'is_active', 'fk_vistor_category', 'designation', 'mode_advertisement', 'is_admitted'], 'integer'],
           [['name', 'cnic', 'contact_no', 'date_of_visit', 'product_name', 'product_description', 'last_degree', 'experiance', 'last_organization', 'qualification', 'reference', 'organization', 'address', 'coordinator_comments', 'admin_personel_observation'], 'safe'],
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
        $query = VisitorInfo::find();

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
            'contact_no' => $this->contact_no,
            'fk_branch_id' => $this->fk_branch_id,
            'fk_adv_med_id' => $this->fk_adv_med_id,
            'fk_class_id' => $this->fk_class_id,
            'date_of_visit' => $this->date_of_visit,
            'is_active' => $this->is_active,
            'fk_vistor_category' => $this->fk_vistor_category,
            'designation' => $this->designation,
            'mode_advertisement' => $this->mode_advertisement, 
             'is_admitted' => $this->is_admitted, 
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cnic', $this->cnic])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no]) 
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_description', $this->product_description])
            ->andFilterWhere(['like', 'last_degree', $this->last_degree])
            ->andFilterWhere(['like', 'experiance', $this->experiance])
            ->andFilterWhere(['like', 'last_organization', $this->last_organization])
            ->andFilterWhere(['like', 'qualification', $this->qualification])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'coordinator_comments', $this->coordinator_comments])
            ->andFilterWhere(['like', 'admin_personel_observation', $this->admin_personel_observation]);

        return $dataProvider;
    }
}
