<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_fine_detail".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_fine_typ_id
 * @property string $remarks
 * @property string $created_date
 * @property string $updated_date
 * @property integer $amount
 * @property string $is_active
 *
 * @property FeeCollectionParticular[] $feeCollectionParticulars
 * @property FineType $fkFineTyp
 * @property Branch $fkBranch
 */
class StudentFineDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_fine_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'fk_fine_typ_id', 'amount'], 'required'],
            [['fk_branch_id', 'fk_fine_typ_id', 'amount'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['is_active'], 'string'],
            [['remarks'], 'string', 'max' => 300],
            [['fk_fine_typ_id'], 'exist', 'skipOnError' => true, 'targetClass' => FineType::className(), 'targetAttribute' => ['fk_fine_typ_id' => 'id']],
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
            'fk_branch_id' => 'Branch',
            'fk_fine_typ_id' => 'Fine Type',
            'remarks' => 'Remarks',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'amount' => 'Amount',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCollectionParticulars()
    {
        return $this->hasMany(FeeCollectionParticular::className(), ['fk_fine_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFineTyp()
    {
        return $this->hasOne(FineType::className(), ['id' => 'fk_fine_typ_id']);
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
                $this->created_date = new \yii\db\Expression('NOW()');

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
