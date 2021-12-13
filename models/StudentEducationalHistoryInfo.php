<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_educational_history_info".
 *
 * @property integer $edu_history_id
 * @property string $degree_name
 * @property integer $degree_type_id
 * @property string $Institute_name
 * @property string $institute_type_id
 * @property string $grade
 * @property integer $total_marks
 * @property string $start_date
 * @property string $end_date
 * @property integer $stu_id
 * @property integer $marks_obtained
 *
 * @property StudentInfo $stu
 */
class StudentEducationalHistoryInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_educational_history_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['degree_name', 'degree_type_id', 'Institute_name', 'grade', 'total_marks', 'start_date', 'end_date'], 'required'],
            [['degree_type_id', 'total_marks', 'stu_id', 'marks_obtained'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['degree_name', 'Institute_name'], 'string', 'max' => 50],
            [['institute_type_id'], 'string', 'max' => 15],
            [['grade'], 'string', 'max' => 4],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['stu_id' => 'stu_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'edu_history_id' => Yii::t('app','Edu History'),
            'degree_name' => Yii::t('app','Degree Name'),
            'degree_type_id' => Yii::t('app','Degree Type'),
            'Institute_name' => Yii::t('app','Institute Name'),
            'institute_type_id' => Yii::t('app','Institute Type'),
            'grade' => Yii::t('app','Grade'),
            'total_marks' => Yii::t('app','Total Marks'),
            'start_date' => Yii::t('app','Start Date'),
            'end_date' => Yii::t('app','End Date'),
            'stu_id' => Yii::t('app','Stu ID'),
            'marks_obtained' => Yii::t('app','Marks Obtained'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'stu_id']);
    }

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
   public function getInstituteType() 
   { 
       return $this->hasOne(RefInstituteType::className(), ['institute_type_id' => 'institute_type_id']); 
   } 
}
