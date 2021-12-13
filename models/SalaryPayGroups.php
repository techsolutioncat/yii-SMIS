<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_pay_groups".
 *
 * @property integer $id
 * @property string $title
 * @property string $created_date
 * @property string $updated_date
 * @property integer $fk_branch_id
 * @property integer $status
 *
 * @property EmployeeSalarySelection[] $employeeSalarySelections
 * @property Branch $fkBranch
 * @property SalaryPayStages[] $salaryPayStages
 */
class SalaryPayGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_pay_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_date', 'fk_branch_id'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['fk_branch_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
           // [['title'],'unique'],
            [['title'], 'unique','message'=>'Title has already been taken','targetAttribute' => ['title', 'fk_branch_id']],
            //array('a1', 'unique', 'attributes' => array('a1', 'a2'))
        ];
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'fk_branch_id' => 'Fk Branch ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSalarySelections()
    {
        return $this->hasMany(EmployeeSalarySelection::className(), ['fk_group_id' => 'id']);
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
    public function getSalaryPayStages()
    {
        return $this->hasMany(SalaryPayStages::className(), ['fk_pay_groups' => 'id']);
    }
}
