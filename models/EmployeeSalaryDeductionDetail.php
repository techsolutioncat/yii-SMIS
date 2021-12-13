<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_salary_deduction_detail".
 *
 * @property integer $id
 * @property integer $fk_emp_id
 * @property integer $fk_salary_deduction_type_id
 * @property integer $amount
 * @property string $created_date
 * @property string $update_dated
 * @property integer $is_active
 *
 * @property EmployeeInfo $fkEmp
 * @property SalaryDeductionType $fkSalaryDeductionType
 */
class EmployeeSalaryDeductionDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_salary_deduction_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_emp_id', 'fk_salary_deduction_type_id', 'amount', 'created_date'], 'required'],
            [['fk_emp_id', 'fk_salary_deduction_type_id', 'amount', 'is_active'], 'integer'],
            [['created_date', 'update_dated'], 'safe'],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
            [['fk_salary_deduction_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryDeductionType::className(), 'targetAttribute' => ['fk_salary_deduction_type_id' => 'id']],
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
            'fk_salary_deduction_type_id' => 'Fk Salary Deduction Type ID',
            'amount' => 'Amount',
            'created_date' => 'Created Date',
            'update_dated' => 'Update Dated',
            'is_active' => 'Is Active',
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
    public function getFkSalaryDeductionType()
    {
        return $this->hasOne(SalaryDeductionType::className(), ['id' => 'fk_salary_deduction_type_id']);
    }
}
