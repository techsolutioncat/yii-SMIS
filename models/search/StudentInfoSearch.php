<?php

namespace app\models\search; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use app\models\StudentInfo; 

/** 
 * StudentInfoSearch represents the model behind the search form of `app\models\StudentInfo`. 
 */ 
class StudentInfoSearch extends StudentInfo 
{ 
    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [ 
            [['stu_id', 'user_id', 'fk_branch_id', 'gender_type', 'guardian_type_id', 'country_id', 'province_id', 'fk_ref_province_id2', 'city_id', 'session_id', 'group_id', 'shift_id', 'class_id', 'section_id', 'withdrawl_no', 'district_id', 'religion_id', 'is_hostel_avail', 'fk_stop_id', 'fk_fee_plan_type', 'is_active', 'fk_ref_country_id2', 'fk_ref_district_id2', 'fk_ref_city_id2'], 'integer'],
            [['dob', 'contact_no', 'emergency_contact_no', 'registration_date', 'fee_generation_date', 'monthly_fee_gen_date', 'cnic', 'location1', 'location2'], 'safe'],
            [['parent_status'], 'boolean'], 
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
        $query = StudentInfo::find(); 

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
            'stu_id' => $this->stu_id,
            'user_id' => $this->user_id,
            'fk_branch_id' => $this->fk_branch_id,
            'dob' => $this->dob,
            'gender_type' => $this->gender_type,
            'guardian_type_id' => $this->guardian_type_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'fk_ref_province_id2' => $this->fk_ref_province_id2,
            'city_id' => $this->city_id,
            'registration_date' => $this->registration_date,
            'fee_generation_date' => $this->fee_generation_date,
            'monthly_fee_gen_date' => $this->monthly_fee_gen_date,
            'session_id' => $this->session_id,
            'group_id' => $this->group_id,
            'shift_id' => $this->shift_id,
            'class_id' => $this->class_id,
            'section_id' => $this->section_id,
            'withdrawl_no' => $this->withdrawl_no,
            'district_id' => $this->district_id,
            'religion_id' => $this->religion_id,
            'parent_status' => $this->parent_status,
            'is_hostel_avail' => $this->is_hostel_avail,
            'fk_stop_id' => $this->fk_stop_id,
            'fk_fee_plan_type' => $this->fk_fee_plan_type,
            'is_active' => $this->is_active,
            'fk_ref_country_id2' => $this->fk_ref_country_id2,
            'fk_ref_district_id2' => $this->fk_ref_district_id2,
            'fk_ref_city_id2' => $this->fk_ref_city_id2,
        ]);

        $query->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'emergency_contact_no', $this->emergency_contact_no])
            ->andFilterWhere(['like', 'cnic', $this->cnic])
            ->andFilterWhere(['like', 'location1', $this->location1])
            ->andFilterWhere(['like', 'location2', $this->location2]);

        return $dataProvider; 
    } 
} 