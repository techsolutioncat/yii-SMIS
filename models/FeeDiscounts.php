<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_discounts".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_stud_id
 * @property integer $fk_fee_discounts_type_id
 * @property integer $fk_fee_head_id
 * @property integer $amount
 * @property integer $is_active
 * @property string $remarks
 *
 * @property FeeCollectionParticular[] $feeCollectionParticulars
 * @property FeeDiscountTypes $fkFeeDiscountsType
 * @property Branch $fkBranch
 * @property StudentInfo $fkStud
 * @property FeeHeads $fkFeeHead
 */
class FeeDiscounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'fk_fee_discounts_type_id',*/  'fk_fee_head_id','amount'], 'required'],
            [['fk_branch_id','fk_stud_id', 'fk_fee_discounts_type_id', 'fk_fee_head_id', 'amount','is_active'], 'integer'],
            [['remarks'], 'string', 'max' => 300],
            [['fk_fee_discounts_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeDiscountTypes::className(), 'targetAttribute' => ['fk_fee_discounts_type_id' => 'id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['fk_stud_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stud_id' => 'stu_id']],
            [['fk_fee_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeHeads::className(), 'targetAttribute' => ['fk_fee_head_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_branch_id' => 'Fk Branch ID',
            'fk_fee_discounts_type_id' => 'Discount Type',
            'fk_stud_id' => 'Fk Stud ID',
            'fk_fee_discounts_type_id' => 'Fk Fee Discounts Type ID',
            'fk_fee_head_id' => 'Fk Fee Head ID',
            'amount' => 'Amount',
            'is_active' => 'Is Active',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCollectionParticulars()
    {
        return $this->hasMany(FeeCollectionParticular::className(), ['fk_fee_discount_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeeDiscountsType()
    {
        return $this->hasOne(FeeDiscountTypes::className(), ['id' => 'fk_fee_discounts_type_id']);
    }

    public function getFkStud()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_stud_id']);
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
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
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
               // $this->created_date = new \yii\db\Expression('NOW()');
                //$this->updated_by = Yii::$app->user->id;

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
