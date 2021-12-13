<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checkinout".
 *
 * @property integer $USERID
 * @property string $CHECKTIME
 * @property string $CHECKTYPE
 * @property integer $VERIFYCODE
 * @property string $SENSORID
 * @property string $Memoinfo
 * @property string $WorkCode
 * @property string $sn
 * @property integer $UserExtFmt
 */
class Checkinout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'checkinout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USERID', 'VERIFYCODE', 'UserExtFmt'], 'integer'],
            [['CHECKTIME'], 'safe'],
            [['CHECKTYPE'], 'string', 'max' => 1],
            [['SENSORID'], 'string', 'max' => 5],
            [['Memoinfo'], 'string', 'max' => 30],
            [['WorkCode'], 'string', 'max' => 24],
            [['sn'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USERID' => 'Userid',
            'CHECKTIME' => 'Checktime',
            'CHECKTYPE' => 'Checktype',
            'VERIFYCODE' => 'Verifycode',
            'SENSORID' => 'Sensorid',
            'Memoinfo' => 'Memoinfo',
            'WorkCode' => 'Work Code',
            'sn' => 'Sn',
            'UserExtFmt' => 'User Ext Fmt',
        ];
    }
}
