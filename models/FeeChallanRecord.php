<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_challan_record".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $hostel_fare
 * @property integer $challan_id
 * @property integer $fk_stu_id
 * @property integer $fk_fee_plan_id
 * @property integer $fk_head_id
 * @property integer $head_amount
 * @property integer $arrears
 * @property integer $fk_stop_id
 * @property integer $fare_amount
 * @property string $created_date
 * @property integer $status
 *
 * @property StudentInfo $fkStu
 * @property FeeHeads $fkHead
 * @property FeePlanType $fkFeePlan
 * @property Stop $fkStop
 * @property FeeTransactionDetails $challan
 * @property Branch $fkBranch
 */
class FeeChallanRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_challan_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['challan_id', 'fk_stu_id', 'fk_fee_plan_id', 'fk_head_id'], 'required'],
            [['fk_branch_id', 'challan_id', 'arrears', 'fk_stu_id', 'fk_fee_plan_id', 'fk_head_id', 'head_amount', 'fk_stop_id', 'fare_amount', 'status','hostel_fare'], 'integer'],
            [['created_date'], 'safe'],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],
            [['fk_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeHeads::className(), 'targetAttribute' => ['fk_head_id' => 'id']],
            [['fk_fee_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeePlanType::className(), 'targetAttribute' => ['fk_fee_plan_id' => 'id']],
            [['fk_stop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stop::className(), 'targetAttribute' => ['fk_stop_id' => 'id']],
            [['challan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeTransactionDetails::className(), 'targetAttribute' => ['challan_id' => 'id']],
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
            'challan_id' => 'Challan ID',
            'fk_stu_id' => 'Fk Stu ID',
            'fk_fee_plan_id' => 'Fk Fee Plan ID',
            'fk_head_id' => 'Fk Head ID',
            'head_amount' => 'Head Amount',
            'arrears' => 'Arrears',
            'fk_stop_id' => 'Fk Stop ID',
            'fare_amount' => 'Fare Amount',
            'created_date' => 'Created Date',
            'status' => 'Status',
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
    public function getFkHead()
    {
        return $this->hasOne(FeeHeads::className(), ['id' => 'fk_head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeePlan()
    {
        return $this->hasOne(FeePlanType::className(), ['id' => 'fk_fee_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStop()
    {
        return $this->hasOne(Stop::className(), ['id' => 'fk_stop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallan()
    {
        return $this->hasOne(FeeTransactionDetails::className(), ['id' => 'challan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }


    /*auto entry.*/
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
