<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_plan_type".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property string $title
 * @property string $description
 * @property integer $no_of_installments
 *
 * @property FeeParticulars[] $feeParticulars
 * @property Branch $fkBranch
 */
class FeePlanType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_plan_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'no_of_installments'], 'required'],
            [['fk_branch_id', 'no_of_installments'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
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
            'fk_branch_id' => 'Branch',
            'title' => 'Title',
            'description' => 'Description',
            'no_of_installments' => 'No Of Installments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeParticulars()
    {
        return $this->hasMany(FeeParticulars::className(), ['fk_fee_plan_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }

    /*public function beforeSave($insert)
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
    }*/
}
