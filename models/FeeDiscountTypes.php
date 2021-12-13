<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_discount_types".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property string $title
 * @property string $description
 * @property string $created_date
 * @property string $updated_date
 * @property string $is_active
 *
 * @property Branch $fkBranch
 * @property FeeDiscounts[] $feeDiscounts
 */
class FeeDiscountTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_discount_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','is_active'], 'required'],
            [['fk_branch_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['is_active'], 'string'],
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
            'fk_branch_id' => 'Fk Branch ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_date' => 'Created At',
            'updated_date' => 'Updated At',
            'is_active' => 'Active',
        ];
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
    public function getFeeDiscounts()
    {
        return $this->hasMany(FeeDiscounts::className(), ['fk_fee_discounts_type_id' => 'id']);
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
