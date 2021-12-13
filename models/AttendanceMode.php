<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance_mode".
 *
 * @property integer $id
 * @property string $mode
 */
class AttendanceMode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance_mode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mode'], 'required'],
            [['mode'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => 'Mode',
        ];
    }
}
