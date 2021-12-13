<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fee_transaction_details".
 *
 * @property integer $id
 * @property string $challan_no
 * @property string $manual_recept_no
 * @property integer $stud_id
 * @property integer $fk_fee_collection_particular
 * @property string $transaction_date
 * @property integer $opening_balance
 * @property integer $transaction_amount
 * @property integer $status
 * @property integer $fk_branch_id
 *
 * @property StudentInfo $stud
 * @property FeeCollectionParticular $fkFeeCollectionParticular
 * @property Branch $fkBranch
 */
class FeeTransactionDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fee_transaction_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stud_id', 'fk_fee_collection_particular'], 'required'],
            [['stud_id', 'fk_fee_collection_particular', 'fk_branch_id','status'], 'integer'],
            [['transaction_amount','opening_balance'], 'double'],
            [['transaction_date'], 'safe'],
            [['challan_no','manual_recept_no'], 'string', 'max' => 25],
            [['stud_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['stud_id' => 'stu_id']],
            [['fk_fee_collection_particular'], 'exist', 'skipOnError' => true, 'targetClass' => FeeCollectionParticular::className(), 'targetAttribute' => ['fk_fee_collection_particular' => 'id']],
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
            'challan_no' => Yii::t('app','Challan No'),
            'stud_id' => Yii::t('app','Stud ID'),
            'fk_fee_collection_particular' => Yii::t('app','Fee Collection Particular'),
            'transaction_date' => Yii::t('app','Transaction Date'),
            'opening_balance' => Yii::t('app','Opening Balance'),
            'transaction_amount' => Yii::t('app','Transaction Amount'),
            'fk_branch_id' => 'Fk Branch ID',
            'status' => Yii::t('app','status'),
            'manual_recept_no' => Yii::t('app','Manual Receipt #'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStud()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'stud_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFeeCollectionParticular()
    {
        return $this->hasOne(FeeCollectionParticular::className(), ['id' => 'fk_fee_collection_particular']);
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
                $branch=  Branch::findOne(Yii::$app->common->getBranch());
                $count= FeeTransactionDetails::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->count();
                $branch_name = $branch->name;
                $id = $count+1;
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->challan_no = $branch_name.'-Ch-'.$id;

                //$this->created_date = new \yii\db\Expression('NOW()');
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
