<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hostel".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property string $Name
 * @property string $address
 * @property string $contact_no
 * @property integer $fk_warden_id
 * @property integer $amount
 *
 * @property EmployeeInfo $fkWarden
 * @property Branch $fkBranch
 * @property HostelDetail[] $hostelDetails
 */
class Hostel extends \yii\db\ActiveRecord
{
    public $department;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id', 'Name', 'address', 'contact_no', 'fk_warden_id', 'amount'], 'required'],
            [['fk_branch_id', 'fk_warden_id', 'amount'], 'integer'],
            [['Name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 250],
            [['Name'], 'unique','message'=>'This Name is Already Assigned'],
            [['contact_no'], 'string', 'max' => 20],
            [['fk_warden_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_warden_id' => 'emp_id']],
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
            'fk_branch_id' => Yii::t('app','Fk Branch ID') ,
            'Name' => Yii::t('app','Name'),
            'address' => Yii::t('app','Address'),
            'contact_no' => Yii::t('app','Contact No'),
            'fk_warden_id' => Yii::t('app','Warden'),
            'amount' => Yii::t('app','Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkWarden()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'fk_warden_id']);
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
    public function getHostelDetails()
    {
        return $this->hasMany(HostelDetail::className(), ['fk_hostel_id' => 'id']);
    }
}
