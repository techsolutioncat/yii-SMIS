<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_bank_info".
 *
 * @property integer $id
 * @property integer $fk_emp_id
 * @property string $bank_name
 * @property string $branch_name
 * @property integer $branch_code
 * @property string $account_no
 *
 * @property EmployeeInfo $fkEmp
 */
class EmployeeBankInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_bank_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_emp_id', 'bank_name', 'branch_name', 'branch_code', 'account_no'], 'required'],
            [['fk_emp_id', 'branch_code'], 'integer'],
            [['bank_name'], 'string', 'max' => 50],
            [['branch_name'], 'string', 'max' => 300],
            [['account_no'], 'string', 'max' => 20],
            [['fk_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_emp_id' => 'emp_id']],
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
            'bank_name' => 'Bank Name',
            'branch_name' => 'Branch Name',
            'branch_code' => 'Branch Code',
            'account_no' => 'Account No',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkEmp()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'fk_emp_id']);
    }
}
