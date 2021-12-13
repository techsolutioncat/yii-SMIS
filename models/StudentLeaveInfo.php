<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_leave_info".
 *
 * @property integer $id
 * @property integer $stu_id
 * @property string $remarks
 * @property string $next_school
 * @property string $reason_for_leavingschool
 * @property string $created_date
 * @property integer $class_id
 * @property integer $group_id
 * @property integer $section_id
    * 
* @property StudentInfo $stu
* @property RefClass $class
* @property RefGroup $group
* @property RefSection $section
 */
class StudentLeaveInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_leave_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_id', 'remarks', 'next_school', 'reason_for_leavingschool', 'created_date'], 'required'],
            [['stu_id', 'class_id', 'group_id', 'section_id'], 'integer'],
            [['created_date'], 'safe'],
            [['remarks', 'next_school', 'reason_for_leavingschool'], 'string', 'max' => 555],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stu_id' => 'Stu ID',
            'remarks' => 'Remarks',
            'next_school' => 'Next School',
            'reason_for_leavingschool' => 'Reason For Leavingschool',
            'created_date' => 'Created Date',
            'class_id' => 'Class ID',
            'group_id' => 'Group ID',
            'section_id' => 'Section ID',
        ];
    }


     public function getStu() 
   { 
       return $this->hasOne(StudentInfo::className(), ['stu_id' => 'stu_id']); 
   } 

    public function getClass()
   {
       return $this->hasOne(RefClass::className(), ['class_id' => 'class_id']);
   }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getGroup()
   {
       return $this->hasOne(RefGroup::className(), ['group_id' => 'group_id']);
   }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getSection()
   {
       return $this->hasOne(RefSection::className(), ['section_id' => 'section_id']);
   }
}
