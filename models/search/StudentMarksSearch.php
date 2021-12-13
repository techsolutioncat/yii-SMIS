<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentMarks;

/**
 * StudentMarksSearch represents the model behind the search form about `app\models\StudentMarks`.
 */
class StudentMarksSearch extends StudentMarks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'marks_obtained', 'fk_exam_id', 'fk_student_id'], 'integer'],
            [['remarks'], 'safe'],
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
        $query = StudentMarks::find();

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
            'marks_obtained' => $this->marks_obtained,
            'fk_exam_id' => $this->fk_exam_id,
            'fk_student_id' => $this->fk_student_id,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
