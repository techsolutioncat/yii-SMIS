<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_head_wise".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $transport_fare
 * @property integer $hostel_fee
 * @property integer $fk_fee_plan_type
 * @property integer $fk_stu_id
 * @property integer $fk_fee_particular_id
 * @property integer $fk_fee_head_id
 * @property integer $payment_received
 * @property integer $arrears
 * @property integer $is_paid
 * @property integer $fk_chalan_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $updated_by
 *
 * @property StudentInfo $fkStu
 * @property FeeParticulars $fkFeeParticular
 * @property Branch $fkBranch
 * @property FeeTransactionDetails $fkChalan
 * @property User $updatedBy
 */
class FeeHeadWise extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_head_wise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_stu_id', 'fk_chalan_id'], 'required'],
            [['fk_branch_id', 'fk_stu_id','arrears', 'fk_fee_head_id','fk_fee_particular_id', 'payment_received', 'fk_chalan_id', 'updated_by','is_paid','hostel_fee','transport_fare'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],
            [['fk_fee_particular_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeParticulars::className(), 'targetAttribute' => ['fk_fee_particular_id' => 'id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['fk_chalan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeTransactionDetails::className(), 'targetAttribute' => ['fk_chalan_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'fk_fee_particular_id' => 'Fk Fee Particular ID',
            'fk_fee_head_id' => 'Fee Head',
            'payment_received' => 'Payment Received',
            'arrears' => 'Arrears',
            'is_paid' => 'Is Paid',
            'fk_chalan_id' => 'Fk Chalan ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'hostel_fee' => 'Hostel Fee',
            'transport_fare' => 'Transport Fare',
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
    public function getFkFeeParticular()
    {
        return $this->hasOne(FeeParticulars::className(), ['id' => 'fk_fee_particular_id']);
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
    public function getFkChalan()
    {
        return $this->hasOne(FeeTransactionDetails::className(), ['id' => 'fk_chalan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
                $this->updated_date = Null;
                $this->updated_by = Yii::$app->user->id;


            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
                $this->updated_by = Yii::$app->user->id;
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
