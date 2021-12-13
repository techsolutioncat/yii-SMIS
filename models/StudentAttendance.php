<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_attendance".
 *
 * @property integer $id
 * @property integer $fk_stu_id
 * @property string $date
 * @property string $leave_type
 * @property string $remarks
 *
 * @property StudentInfo $fkStu
 */
class StudentAttendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_stu_id', 'date', 'leave_type'], 'required'],
            [['fk_stu_id'], 'integer'],
            [['date'], 'safe'],
            [['leave_type'], 'string'],
            [['remarks'], 'string', 'max' => 100],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_stu_id' => 'Fk Stu ID',
            'date' => 'Date',
            'leave_type' => 'Leave Type',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_stu_id']);
    }
}
