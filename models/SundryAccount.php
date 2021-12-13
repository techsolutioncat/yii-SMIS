<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sundry_account".
 *
 * @property integer $id
 * @property integer $stu_id
 * @property integer $total_advance_bal
 * @property integer $fk_chalan_id
 * @property integer $fk_head_id
 * @property string $receipt_no
 * @property integer $status
 * @property integer $transport_fare
 * @property integer $hostel_fare
 * @property string $fee_submission_date
 * @property string $created_date
 * @property integer $fk_branch_id
 * @property FeeHeads $fkHead
 *
 * @property StudentInfo $stu
 * @property FeeTransactionDetails $fkChalan
 */
class SundryAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sundry_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stu_id', 'total_advance_bal', 'fk_branch_id'], 'required'],
            [['stu_id', 'total_advance_bal', 'fk_chalan_id', 'status','fk_head_id', 'fk_branch_id','hostel_fare','transport_fare'], 'integer'],
            [['created_date','fee_submission_date'], 'safe'],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['stu_id' => 'stu_id']],
            [['receipt_no'], 'string', 'max' => 80],
            [['fk_chalan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeTransactionDetails::className(), 'targetAttribute' => ['fk_chalan_id' => 'id']],
            [['fk_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeHeads::className(), 'targetAttribute' => ['fk_head_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'stu_id' => Yii::t('app', 'Stu ID'),
            'total_advance_bal' => Yii::t('app', 'Total Advance Bal'),
            'fk_chalan_id' => Yii::t('app', 'Fk Chalan ID'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'fk_branch_id' => Yii::t('app', 'Fk Branch ID'),
            'fk_head_id' => Yii::t('app', 'Fk Head ID'),
            'receipt_no' => Yii::t('app', 'Receipt No'),
            'receipt_no' => Yii::t('app', 'Receipt No'),
            'fee_submission_date' => Yii::t('app', 'Fee submission Date'),
            'transport_fare' => Yii::t('app', 'Transport Fare'),
            'hostel_fare' => Yii::t('app', 'Hostel Fare'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkChalan()
    {
        return $this->hasOne(FeeTransactionDetails::className(), ['id' => 'fk_chalan_id']);
    }

    public function getFkHead()
    {
        return $this->hasOne(FeeHeads::className(), ['id' => 'fk_head_id']);
    }
}
