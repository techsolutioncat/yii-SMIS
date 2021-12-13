<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_salary_selection".
 *
 * @property integer $id
 * @property integer $fk_emp_id
 * @property integer $fk_group_id
 * @property integer $fk_pay_stages
 * @property integer $fk_allownces_id
 * @property integer $fk_fix_deduction_detail
 *
 * @property EmployeeInfo $fkEmp
 * @property SalaryPayStages $fkPayStages
 * @property SalaryAllownces $fkAllownces
 * @property SalaryPayGroups $fkGroup
 * @property SalaryDeductionType $fkFixDeductionDetail
 */
class EmployeeSalarySelection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_salary_selection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_emp_id', 'fk_group_id', 'fk_pay_stages'], 'required'],
            [['fk_emp_id', 'fk_group_id', 'fk_pay_stages', 'fk_allownces_id', 'fk_fix_deduction_detail'], 'integer'],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
            [['fk_pay_stages'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayStages::className(), 'targetAttribute' => ['fk_pay_stages' => 'id']],
            [['fk_allownces_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryAllownces::className(), 'targetAttribute' => ['fk_allownces_id' => 'id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayGroups::className(), 'targetAttribute' => ['fk_group_id' => 'id']],
            [['fk_fix_deduction_detail'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryDeductionType::className(), 'targetAttribute' => ['fk_fix_deduction_detail' => 'id']],
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
            'fk_allownces_id' => 'Fk Allownces ID',
            'fk_fix_deduction_detail' => 'Fk Fix Deduction Detail',
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
    public function getFkPayStages()
    {
        return $this->hasOne(SalaryPayStages::className(), ['id' => 'fk_pay_stages']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAllownces()
    {
        return $this->hasOne(SalaryAllownces::className(), ['id' => 'fk_allownces_id']);
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
    public function getFkFixDeductionDetail()
    {
        return $this->hasOne(SalaryDeductionType::className(), ['id' => 'fk_fix_deduction_detail']);
    }
}
