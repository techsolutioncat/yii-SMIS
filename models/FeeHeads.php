<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_heads".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $discount_head_status
 * @property integer $extera_head
 * @property integer $one_time_only
 * @property integer $promotion_head
 * @property string $title
 * @property string $description
 * @property string $created_date
 * @property string $updated_date
 * @property integer $fk_fee_method_id
 *
 * @property FeeGroup[] $feeGroups
 * @property FeePaymentMode $fkFeeMethod
 * @property FeeParticulars[] $feeParticulars
 */
class FeeHeads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_heads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title' ], 'required'],
            [['fk_branch_id', 'fk_fee_method_id','discount_head_status','extra_head','one_time_only','promotion_head'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 300],
            [['fk_fee_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeePaymentMode::className(), 'targetAttribute' => ['fk_fee_method_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_branch_id' =>  Yii::t('app','Branch ID'),
            'extra_head' =>  Yii::t('app','Extra Head'),
            'one_time_only' =>  Yii::t('app','One Time Only'),
            'title' =>  Yii::t('app','Title'),
            'description' =>  Yii::t('app','Description'),
            'created_date' =>  Yii::t('app','Created At'),
            'updated_date' =>  Yii::t('app','Updated At'),
            'fk_fee_method_id' =>  Yii::t('app','Fee Mode'),
            'discount_head_status' =>  Yii::t('app','Discount Head Status'),
            'promotion_head' => Yii::t('app','Promotion Head'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeGroups()
    {
        return $this->hasMany(FeeGroup::className(), ['fk_fee_head_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeeMethod()
    {
        return $this->hasOne(FeePaymentMode::className(), ['id' => 'fk_fee_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeParticulars()
    {
        return $this->hasMany(FeeParticulars::className(), ['fk_fee_head_id' => 'id']);
    }

    /*auto attach branch id when save*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                //$this->fk_branch_id = Yii::$app->common->getBranch();
                $this->created_date  = new \yii\db\Expression('NOW()');
                if($this->one_time_only == null){
                    $this->one_time_only = 0;
                }

            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
