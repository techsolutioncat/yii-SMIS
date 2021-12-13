<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_attendance".
 *
 * @property integer $id
 * @property integer $fk_empl_id
 * @property string $date
 * @property string $leave_type
 * @property string $remarks
 *
 * @property EmployeeInfo $fkEmpl
 */
class EmployeeAttendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_empl_id', 'date', 'leave_type'], 'required'],
            [['fk_empl_id'], 'integer'],
            [['date'], 'safe'],
            [['leave_type'], 'string'],
            [['remarks'], 'string', 'max' => 100],
            [['fk_empl_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_empl_id' => 'emp_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_empl_id' => 'Fk Empl ID',
            'date' => 'Date',
            'leave_type' => 'Leave Type',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkEmpl()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'fk_empl_id']);
    }
}
