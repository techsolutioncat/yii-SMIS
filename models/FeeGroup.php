<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_group".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_class_id
 * @property integer $fk_fee_head_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $is_active
 * @property integer $fk_group_id
 * @property integer $amount
 *
 * @property RefClass $fkClass
 * @property FeeHeads $fkFeeHead
 * @property RefGroup $fkGroup
 * @property Branch $fkBranch
 * @property User $updatedBy
 */
class FeeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id','fk_class_id', 'fk_fee_head_id', 'amount'], 'required'],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['fk_branch_id', 'fk_class_id', 'fk_fee_head_id', 'updated_by', 'fk_group_id', 'amount'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['is_active'],'string'],
            [['fk_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['fk_class_id' => 'class_id']],
            [['fk_fee_head_id'], 'exist', 'skipOnError' => true, 'targetClass' => FeeHeads::className(), 'targetAttribute' => ['fk_fee_head_id' => 'id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGroup::className(), 'targetAttribute' => ['fk_group_id' => 'group_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
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
            'fk_class_id' => Yii::t('app','Class'),
            'fk_fee_head_id' => Yii::t('app','Fee Head'),
            'created_date' => Yii::t('app','Added At'),
            'updated_date' => Yii::t('app','Updated Date'),
            'updated_by' => Yii::t('app','Updated By'),
            'is_active' => Yii::t('app','Active'),
            'fk_group_id' => Yii::t('app','Group'),
            'amount' => Yii::t('app','Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkClass()
    {
        return $this->hasOne(RefClass::className(), ['class_id' => 'fk_class_id']);
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
    public function getFkGroup()
    {
        return $this->hasOne(RefGroup::className(), ['group_id' => 'fk_group_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /*auto attach branch id when save*/
    /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->created_date = new \yii\db\Expression('NOW()');
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
    }*/
}
