<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property EmployeeAttendance[] $employeeAttendances
 * @property StudentAttendance[] $studentAttendances
 */
class AttendanceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeAttendances()
    {
        return $this->hasMany(EmployeeAttendance::className(), ['fk_attendance_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentAttendances()
    {
        return $this->hasMany(StudentAttendance::className(), ['fk_attendance_type_id' => 'id']);
    }
}
