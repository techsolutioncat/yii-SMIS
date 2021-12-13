<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentParentsInfo;

/**
 * StudentParentsInfoSearch represents the model behind the search form of `app\models\StudentParentsInfo`.
 */
class StudentParentsInfoSearch extends StudentParentsInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_parent_id', 'stu_id', 'gender_type', 'guardian_cnic', 'guardian_contact_no'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'cnic', 'email', 'contact_no', 'profession', 'contact_no2', 'guardian_name', 'relation', 'guardian_cnic', 'organisation', 'designation', 'office_no', 'facebook_id', 'twitter_id', 'linkdin_id', 'mother_name', 'mother_profession', 'mother_designation', 'mother_organization', 'mother_contactno', 'mother_officeno', 'mother_email', 'mother_fb_id', 'mother_twitter_id', 'mother_linkedin'], 'safe'],
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
        $query = StudentParentsInfo::find();

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
            'stu_parent_id' => $this->stu_parent_id,
            'stu_id' => $this->stu_id,
            'gender_type' => $this->gender_type,
            'guardian_cnic' => $this->guardian_cnic,
            'guardian_contact_no' => $this->guardian_contact_no,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'cnic', $this->cnic])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'contact_no2', $this->contact_no2])
            ->andFilterWhere(['like', 'guardian_name', $this->guardian_name])
            ->andFilterWhere(['like', 'relation', $this->relation])
           ->andFilterWhere(['like', 'guardian_cnic', $this->guardian_cnic])
           ->andFilterWhere(['like', 'organisation', $this->organisation])
           ->andFilterWhere(['like', 'designation', $this->designation])
           ->andFilterWhere(['like', 'office_no', $this->office_no])
           ->andFilterWhere(['like', 'facebook_id', $this->facebook_id])
           ->andFilterWhere(['like', 'twitter_id', $this->twitter_id])
           ->andFilterWhere(['like', 'linkdin_id', $this->linkdin_id])
           ->andFilterWhere(['like', 'mother_name', $this->mother_name])
           ->andFilterWhere(['like', 'mother_profession', $this->mother_profession])
           ->andFilterWhere(['like', 'mother_designation', $this->mother_designation])
           ->andFilterWhere(['like', 'mother_organization', $this->mother_organization])
           ->andFilterWhere(['like', 'mother_contactno', $this->mother_contactno])
           ->andFilterWhere(['like', 'mother_officeno', $this->mother_officeno])
           ->andFilterWhere(['like', 'mother_email', $this->mother_email])
           ->andFilterWhere(['like', 'mother_fb_id', $this->mother_fb_id])
           ->andFilterWhere(['like', 'mother_twitter_id', $this->mother_twitter_id])
           ->andFilterWhere(['like', 'mother_linkedin', $this->mother_linkedin]);

        return $dataProvider;
    }
}
