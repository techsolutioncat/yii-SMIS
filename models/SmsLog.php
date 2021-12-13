<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property integer $id
 * @property string $SMS_body
 * @property integer $fk_user_id
 * @property string $sms_title
 * @property string $sent_date_time
 * @property string $status
 * @property integer $fk_branch_id
 * @property string $receiver_no
 *
 * @property Branch $fkBranch
 */
class SmsLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_user_id', 'sent_date_time', 'fk_branch_id'], 'required'],
            [['fk_user_id', 'fk_branch_id'], 'integer'],
            [['sent_date_time'], 'safe'],
            [['SMS_body'], 'string', 'max' => 500],
            [['sms_title', 'receiver_no'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 255],
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
            'SMS_body' => 'Sms Body',
            'fk_user_id' => 'Fk User ID',
            'sms_title' => 'Sms Title',
            'sent_date_time' => 'Sent Date Time',
            'status' => 'Status',
            'fk_branch_id' => 'Fk Branch ID',
            'receiver_no' => 'Receiver No',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }
}
