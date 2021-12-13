<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_department".
 *
 * @property integer $department_type_id
 * @property integer $fk_branch_id
 * @property string $Title
 *
 * @property EmployeeInfo[] $employeeInfos
 */
class RefDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Title'], 'required'],
            [['Title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_type_id' => 'Department Type ID',
            'Title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['department_type_id' => 'department_type_id']);
    }

    /*ADD BRANCH AUTOMATICALLY*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->fk_branch_id = Yii::$app->common->getBranch();

            }
            elseif(!$this->isNewRecord)
            {
                //$this->updated_date = new \yii\db\Expression('NOW()');
                //$this->updated_by = Yii::$app->user->id;
            }
            return true;
        }
        else
        {
            return false;
        }
    }

}
