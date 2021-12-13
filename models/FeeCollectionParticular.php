<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_collection_particular".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_stu_id
 * @property integer $total_fee_amount
 * @property integer $hostel_fare
 * @property integer $fk_fine_id
 * @property integer $transport_fare
 * @property integer $fk_fee_discount_id
 * @property integer $fee_payable
 * @property integer $discount_amount
 * @property integer $is_active
 * @property string $due_date
 *
 * @property StudentInfo $fkStu
 * @property FeeDiscounts $fkFeeDiscount
 * @property StudentFineDetail $fkFine
 * @property Branch $fkBranch
 * @property FeeTransactionDetails[] $feeTransactionDetails
 * @property StudentFeeStatus[] $studentFeeStatuses
 */
class FeeCollectionParticular extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_collection_particular';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'fk_stu_id', 'total_fee_amount', 'due_date'], 'required'],
            [['fk_branch_id', 'fk_stu_id', 'fk_fine_id', 'fk_fee_discount_id','is_active','hostel_fare'], 'integer'],
            [['discount_amount', 'fee_payable', 'total_fee_amount', 'transport_fare'],'double'],
            [['due_date','created_date'], 'safe'],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],
            [['fk_fee_discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeDiscounts::className(), 'targetAttribute' => ['fk_fee_discount_id' => 'id']],
            [['fk_fine_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentFineDetail::className(), 'targetAttribute' => ['fk_fine_id' => 'id']],
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
            'fk_branch_id' => 'Fk Branch ID',
            'fk_stu_id' => 'Fk Stu ID',
            'total_fee_amount' => 'Total Fee Amount',
            'fk_fine_id' => 'Fk Fine ID',
            'transport_fare' => 'Transport Fare',
            'fk_fee_discount_id' => 'Fk Fee Discount ID',
            'discount_amount' => 'Discount Amount',
            'fee_payable' => 'Fee Payable',
            'is_active' => 'Is Active',
            'due_date' => 'Due Date',
            'hostel_fare' => 'Hostel Fare',
        ];
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
    public function getFkFeeDiscount()
    {
        return $this->hasOne(FeeDiscounts::className(), ['id' => 'fk_fee_discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFine()
    {
        return $this->hasOne(StudentFineDetail::className(), ['id' => 'fk_fine_id']);
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
    public function getFeeTransactionDetails()
    {
        return $this->hasMany(FeeTransactionDetails::className(), ['fk_fee_collection_particular' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFeeStatuses()
    {
        return $this->hasMany(StudentFeeStatus::className(), ['fk_fee_collection_particular_id' => 'id']);
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
                $this->created_date = new \yii\db\Expression('NOW()');
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
