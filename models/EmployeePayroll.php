<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_payroll".
 *
 * @property integer $id
 * @property integer $fk_emp_id
 * @property integer $fk_group_id
 * @property integer $fk_pay_stages
 * @property integer $total_amount
 * @property integer $basic_salary
 * @property integer $total_allownce
 * @property integer $total_deductions
 * @property string $created_date
 * @property string $updated_date
 *
 * @property EmployeeAllowances[] $employeeAllowances
 * @property EmployeeInfo $fkEmp
 * @property SalaryPayGroups $fkGroup
 * @property SalaryPayStages $fkPayStages
 */
class EmployeePayroll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_payroll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_emp_id', 'fk_group_id', 'fk_pay_stages', 'created_date'], 'required'],
            [['fk_emp_id', 'fk_group_id', 'fk_pay_stages', 'total_amount', 'basic_salary', 'total_allownce', 'total_deductions'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayGroups::className(), 'targetAttribute' => ['fk_group_id' => 'id']],
            [['fk_pay_stages'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayStages::className(), 'targetAttribute' => ['fk_pay_stages' => 'id']],
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
            'fk_group_id' => 'Fk Group ID',
            'fk_pay_stages' => 'Fk Pay Stages',
            'total_amount' => 'Total Amount',
            'basic_salary' => 'Basic Salary',
            'total_allownce' => 'Total Allownce',
            'total_deductions' => 'Total Deductions',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeAllowances()
    {
        return $this->hasMany(EmployeeAllowances::className(), ['fk_payroll_id' => 'id']);
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
    public function getFkGroup()
    {
        return $this->hasOne(SalaryPayGroups::className(), ['id' => 'fk_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPayStages()
    {
        return $this->hasOne(SalaryPayStages::className(), ['id' => 'fk_pay_stages']);
    }
}
