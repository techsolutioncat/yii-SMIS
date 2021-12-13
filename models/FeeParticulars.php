<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_particulars".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_fee_head_id
 * @property integer $fk_fee_plan_type
 * @property integer $fk_stu_id
 * @property string  $created_date
 * @property string  $updated_date
 * @property integer $is_paid
 *
 * @property FeeCollectionParticular[] $feeCollectionParticulars
 * @property FeeDiscounts[] $feeDiscounts
 * @property FeeHeads $fkFeeHead
 * @property StudentInfo $fkStu
 * @property FeePlanType $fkFeePlanType
 * @property Branch $fkBranch
 */
class FeeParticulars extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_particulars';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_fee_head_id', 'fk_fee_plan_type', 'fk_stu_id'], 'required'],
            [['fk_branch_id', 'fk_fee_head_id', 'fk_fee_plan_type', 'fk_stu_id' , 'is_paid'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['fk_fee_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeHeads::className(), 'targetAttribute' => ['fk_fee_head_id' => 'id']],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],
            [['fk_fee_plan_type'], 'exist', 'skipOnError' => true, 'targetClass' => FeePlanType::className(), 'targetAttribute' => ['fk_fee_plan_type' => 'id']],
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
            'fk_fee_head_id' => 'Fee Head',
            'fk_fee_plan_type' => 'Fee Plan',
            'fk_stu_id' => 'Student',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'is_paid' => 'Is Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCollectionParticulars()
    {
        return $this->hasMany(FeeCollectionParticular::className(), ['fk_fee_particular_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeDiscounts()
    {
        return $this->hasMany(FeeDiscounts::className(), ['fk_fee_particular_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeeHead()
    {
        return $this->hasOne(FeeHeads::className(), ['id' => 'fk_fee_head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeePlanType()
    {
        return $this->hasOne(FeePlanType::className(), ['id' => 'fk_fee_plan_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }


    /*system add branch automatically*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->created_date = new \yii\db\Expression('NOW()');

            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
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
