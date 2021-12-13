<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_deduction_type".
 *
 * @property integer $id
 * @property string $title
 * @property integer $amount
 *  @property SalaryMain[] $salaryMains 
 */
 
class SalaryDeductionType extends \yii\db\ActiveRecord
{
    public $fk_pay_group;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_deduction_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'amount','fk_stages_id'], 'required'],
            [['amount', 'fk_stages_id'], 'integer'],
            [['amount'], 'integer'],
            [['title'], 'string', 'max' => 50],
             [['title', 'amount', 'fk_stages_id', 'fk_branch_id'], 'required'],
           [['amount', 'fk_stages_id', 'fk_branch_id', 'status'], 'integer'],
            //[['title'], 'unique'],
            [['title', 'fk_stages_id'], 'unique','message'=>'Already Assigned', 'targetAttribute' => ['title', 'fk_stages_id']],
            [['fk_stages_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayStages::className(), 'targetAttribute' => ['fk_stages_id' => 'id']],
           [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'amount' => 'Amount',
            'fk_stages_id' => 'Stages',
        ];
    }
    
    public function getSalaryMains() 
   { 
       return $this->hasMany(SalaryMain::className(), ['fk_deduction_tpe' => 'id']); 
   }
   public function getFkStages() 
   { 
       return $this->hasOne(SalaryPayStages::className(), ['id' => 'fk_stages_id']); 
   } 
   public function getFkBranch() 
   { 
       return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']); 
   }  

}
