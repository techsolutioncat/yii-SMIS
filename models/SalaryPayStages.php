<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_pay_stages".
 *
 * @property integer $id
 * @property integer $fk_pay_groups
 * @property string $title
 * @property integer $amount
 *
 * @property SalaryAllownces[] $salaryAllownces
 * @property SalaryPayGroups $fkPayGroups
 */
class SalaryPayStages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_pay_stages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_pay_groups', 'title', 'amount'], 'required'],
            [['fk_pay_groups', 'amount'], 'integer'],
            [['fk_pay_groups', 'title', 'amount', 'fk_branch_id'], 'required'],
           [['fk_pay_groups', 'amount', 'fk_branch_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['fk_pay_groups'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryPayGroups::className(), 'targetAttribute' => ['fk_pay_groups' => 'id']],
            [['title', 'fk_pay_groups'], 'unique', 'targetAttribute' => ['title', 'fk_pay_groups']],
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
            'fk_pay_groups' => 'Fk Pay Groups',
            'title' => 'Title',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryAllownces()
    {
        return $this->hasMany(SalaryAllownces::className(), ['fk_stages_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPayGroups()
    {
        return $this->hasOne(SalaryPayGroups::className(), ['id' => 'fk_pay_groups']);
    }
}
