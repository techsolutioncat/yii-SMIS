<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_allownces".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_stages_id
 * @property integer $amount
 *
 * @property SalaryPayStages $fkStages
 * @property SalaryMain[] $salaryMains
 */
class SalaryAllownces extends \yii\db\ActiveRecord
{
    public $fk_pay_group;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_allownces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_stages_id', 'amount','fk_branch_id'], 'required'],
            [['fk_stages_id', 'amount','fk_branch_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['fk_stages_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayStages::className(), 'targetAttribute' => ['fk_stages_id' => 'id']],
             [['title', 'fk_stages_id'], 'unique','message'=>'Already Assigned', 'targetAttribute' => ['title', 'fk_stages_id']],
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
            'fk_stages_id' => 'Stage',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStages()
    {
        return $this->hasOne(SalaryPayStages::className(), ['id' => 'fk_stages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryMains()
    {
        return $this->hasMany(SalaryMain::className(), ['fk_allownces_id' => 'id']);
    }
}
