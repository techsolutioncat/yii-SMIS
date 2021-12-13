<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_allowances".
 *
 * @property integer $id
 * @property integer $fk_emp_id
 * @property integer $fk_payroll_id
 * @property integer $fk_allownces_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 *
 * @property EmployeeInfo $fkEmp
 * @property EmployeePayroll $fkPayroll
 * @property SalaryAllownces $fkAllownces
 */
class EmployeeAllowances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_allowances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_emp_id', 'fk_payroll_id', 'created_date'], 'required'],
            [['fk_emp_id', 'fk_payroll_id', 'fk_allownces_id', 'status'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
            [['fk_payroll_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeePayroll::className(), 'targetAttribute' => ['fk_payroll_id' => 'id']],
            [['fk_allownces_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryAllownces::className(), 'targetAttribute' => ['fk_allownces_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_emp_id' => 'Fk Emp ID',
            'fk_payroll_id' => 'Fk Payroll ID',
            'fk_allownces_id' => 'Fk Allownces ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkEmp()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'fk_emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPayroll()
    {
        return $this->hasOne(EmployeePayroll::className(), ['id' => 'fk_payroll_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAllownces()
    {
        return $this->hasOne(SalaryAllownces::className(), ['id' => 'fk_allownces_id']);
    }
}
