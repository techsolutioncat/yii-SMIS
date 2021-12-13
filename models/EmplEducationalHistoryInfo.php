<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empl_educational_history_info".
 *
 * @property integer $edu_history_id
 * @property integer $fk_branch_id
 * @property string $degree_name
 * @property integer $degree_type_id
 * @property string $Institute_name
 * @property string $institute_type_id
 * @property string $grade
 * @property string $total_marks
 * @property string $start_date
 * @property string $end_date
 * @property integer $emp_id
 * @property string $marks_obtained
 *
 * @property EmployeeInfo $emp
 * @property RefDegreeType $degreeType
 * @property RefInstituteType $degreeType0
 * @property Branch $fkBranch
 */
class EmplEducationalHistoryInfo extends \yii\db\ActiveRecord
{
    public $degree_name1;
    public $Institute_name1;
    public $start_date1;
    public $end_date1;
    public $marks_obtained1;
    public $total_marks1;
    public $grade1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empl_educational_history_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id', 'degree_name', 'Institute_name', 'total_marks', 'start_date', 'end_date'], 'required'],
            [['fk_branch_id', 'degree_type_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['degree_name', 'Institute_name'], 'string', 'max' => 50],
            [['institute_type_id'], 'string', 'max' => 15],
            [['grade', 'total_marks', 'marks_obtained'], 'string', 'max' => 4],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
            [['degree_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDegreeType::className(), 'targetAttribute' => ['degree_type_id' => 'degree_type_id']],
            [['degree_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefInstituteType::className(), 'targetAttribute' => ['degree_type_id' => 'institute_type_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'edu_history_id' => 'Edu History ID',
            'fk_branch_id' => 'Fk Branch',
            'degree_name' => 'Degree Name',
            'degree_type_id' => 'Degree Type',
            'Institute_name' => 'Institute Name',
            'institute_type_id' => 'Institute Type',
            'grade' => 'Grade',
            'total_marks' => 'Total Marks',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'emp_id' => 'Emp',
            'marks_obtained' => 'Marks Obtained',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegreeType()
    {
        return $this->hasOne(RefDegreeType::className(), ['degree_type_id' => 'degree_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDegreeType0()
    {
        return $this->hasOne(RefInstituteType::className(), ['institute_type_id' => 'degree_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }
    public function getEmp() 
   { 
       return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'emp_id']); 
   } 
}
