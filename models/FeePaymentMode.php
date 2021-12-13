<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_payment_mode".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property string $title
 * @property string $time_span
 *
 * @property FeeHeads[] $feeHeads
 * @property Branch $fkBranch
 */
class FeePaymentMode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_payment_mode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['fk_branch_id'], 'integer'],
            [['time_span'], 'string'],
            [['title'], 'string', 'max' => 20],
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
            'fk_branch_id' => 'Branch ID',
            'title' => 'Title',
            'time_span' => 'Month(s)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeHeads()
    {
        return $this->hasMany(FeeHeads::className(), ['fk_fee_method_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }


    /*auto attach branch id when save*/
   /* public function beforeSave($insert)
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
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        }
        else
        {
            return false;
        }
    }*/
}
