<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_designation".
 *
 * @property integer $designation_id
 * @property integer $fk_branch_id
 * @property string $Title
 * @property integer $fk_department_id
 *
 * @property EmployeeInfo[] $employeeInfos
 * @property Branch $fkBranch
 * @property RefDepartment $fkDepartment
 */
class RefDesignation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_designation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id', 'Title', 'fk_department_id'], 'required'],
            [['fk_branch_id', 'fk_department_id'], 'integer'],
            [['Title'], 'string', 'max' => 20],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['fk_department_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDepartment::className(), 'targetAttribute' => ['fk_department_id' => 'department_type_id']],
            //[['Title'],'unique'],
            [['Title', 'fk_department_id'], 'unique','message'=>'Already Assigned', 'targetAttribute' => ['Title', 'fk_department_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'designation_id' => 'Designation',
            'fk_branch_id' => 'Fk Branch ID',
            'Title' => 'Title',
            'fk_department_id' => 'Department',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['designation_id' => 'designation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkDepartment()
    {
        return $this->hasOne(RefDepartment::className(), ['department_type_id' => 'fk_department_id']);
    }
}
