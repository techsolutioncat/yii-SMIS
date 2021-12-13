<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Exam;

/**
 * ExamsSearch represents the model behind the search form about `app\models\Exam`.
 */
class ExamsSearch extends Exam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_branch_id', 'fk_class_id', 'fk_group_id', 'fk_subject_id', 'fk_section_id', 'fk_exam_type', 'total_marks', 'passing_marks'], 'integer'],
            [['start_date', 'end_date', 'created_date'], 'safe'],
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
        $query = Exam::find();

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
            'fk_branch_id' => $this->fk_branch_id,
            'fk_class_id' => $this->fk_class_id,
            'fk_group_id' => $this->fk_group_id,
            'fk_subject_id' => $this->fk_subject_id,
            'fk_section_id' => $this->fk_section_id,
            'fk_exam_type' => $this->fk_exam_type,
            'total_marks' => $this->total_marks,
            'passing_marks' => $this->passing_marks,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_date' => $this->created_date,
        ]);

        return $dataProvider;
    }
}
