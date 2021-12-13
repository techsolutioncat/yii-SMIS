<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_parents_info".
 *
 * @property integer $emp_parent_id
 * @property integer $fk_branch_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $cnic
 * @property string $email
 * @property string $contact_no
 * @property string $profession
 * @property string $contact_no2
 * @property integer $emp_id
 * @property string $spouse_name
 * @property integer $no_of_children
 *
 * @property EmployeeInfo $emp
 * @property Branch $fkBranch
 */
class EmployeeParentsInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_parents_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {  
        return [
            [['fk_branch_id', 'emp_id','first_name'], 'required'],
            [['fk_branch_id', 'emp_id', 'no_of_children','gender'], 'integer'],
             ['email', 'email'],
            [['first_name', 'last_name', 'contact_no', 'profession'], 'string', 'max' => 20],
            [['middle_name'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 30],
            [['contact_no2'], 'string', 'max' => 20],
            [['spouse_name'], 'string', 'max' => 25],
            [['first_name', 'last_name', 'cnic', 'contact_no', 'profession'], 'string', 'max' => 20],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_parent_id' => 'Emp Parent',
            'fk_branch_id' => 'Fk Branch',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'cnic' => 'Cnic',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'profession' => 'Profession',
            'contact_no2' => 'Contact Number 2',
            'emp_id' => 'Emp ID',
            'spouse_name' => 'Spouse Name',
            'no_of_children' => 'Number Of Children',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }
}
