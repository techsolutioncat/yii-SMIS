<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_main".
 *
 * @property integer $id
 * @property integer $fk_pay_stages
 * @property integer $fk_emp_id
 * @property integer $basic_salary
 * @property integer $allownces_amount
 * @property integer $bonus
 * @property integer $deduction_amount
 * @property integer $fk_tax_id
 * @property integer $gross_salary
 * @property string $salary_month
 * @property integer $is_paid
 * @property string $payment_date
 * @property integer $tax_amount
 * @property integer $salary_payable
 *
 * @property SalaryPayStages $fkPayStages
 * @property EmployeeInfo $fkEmp
 * @property SalaryTax $fkTax
 */
class SalaryMain extends \yii\db\ActiveRecord
{
    public $department;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_pay_stages', 'fk_emp_id', 'basic_salary', 'gross_salary', 'salary_month'], 'required'],
            [['fk_pay_stages', 'fk_emp_id', 'basic_salary', 'allownces_amount', 'bonus', 'deduction_amount', 'fk_tax_id', 'gross_salary', 'is_paid', 'tax_amount'], 'integer'],
            [['salary_month', 'payment_date'], 'safe'],
            [['fk_pay_stages'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayStages::className(), 'targetAttribute' => ['fk_pay_stages' => 'id']],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
            [['fk_tax_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryTax::className(), 'targetAttribute' => ['fk_tax_id' => 'id']],
            //[['fk_emp_id'], 'unique','message'=>'This Employee is Already Assigned'],
           // [['fk_emp_id'],'unique'],
           // [['salary_payable'], 'string'],
            //[['total_after_alowed_leaves', 'absent_deduction'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_pay_stages' => 'Fk Pay Stages',
            'fk_emp_id' => 'Employee',
            'basic_salary' => 'Basic Salary',
            'allownces_amount' => 'Allownces Amount',
            'bonus' => 'Bonus',
            'deduction_amount' => 'Deduction Amount',
            'fk_tax_id' => 'Tax',
            'gross_salary' => 'Gross Salary',
            'salary_month' => 'Salary Month',
            'is_paid' => 'Is Paid',
            'payment_date' => 'Payment Date',
            'tax_amount' => 'Tax Amount',
            'salary_payable' => 'Salary Payable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPayStages()
    {
        return $this->hasOne(SalaryPayStages::className(), ['id' => 'fk_pay_stages']);
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
    public function getFkTax()
    {
        return $this->hasOne(SalaryTax::className(), ['id' => 'fk_tax_id']);
    }
}
