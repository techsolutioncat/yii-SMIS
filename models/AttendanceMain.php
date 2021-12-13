<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance_main".
 *
 * @property integer $id
 * @property integer $Din
 * @property integer $fk_user_id
 * @property string $datetime
 * @property string $checktype
 * @property integer $verifymode
 *
 * @property User $fkUser
 */
class AttendanceMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Din', 'fk_user_id', 'datetime'], 'required'],
            [['Din', 'fk_user_id', 'verifymode'], 'integer'],
            [['datetime'], 'safe'],
            [['checktype'], 'string', 'max' => 8],
            [['fk_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Din' => 'Din',
            'fk_user_id' => 'Fk User ID',
            'datetime' => 'Datetime',
            'checktype' => 'Checktype',
            'verifymode' => 'Verifymode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user_id']);
    }
}
