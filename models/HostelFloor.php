<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hostel_floor".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_hostel_info_id
 *
 * @property HostelDetail[] $hostelDetails
 * @property Hostel $fkHostelInfo
 * @property HostelRoom[] $hostelRooms
 */
class HostelFloor extends \yii\db\ActiveRecord
{
    public $Hostel_floor;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostel_floor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_hostel_info_id'], 'required'],
            [['fk_hostel_info_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['title'], 'unique','message'=>'This Floor is Already Assigned','targetAttribute' => ['title', 'fk_hostel_info_id']],
          
            [['fk_hostel_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hostel::className(), 'targetAttribute' => ['fk_hostel_info_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Name',
            'fk_hostel_info_id' => 'Hostel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostelDetails()
    {
        return $this->hasMany(HostelDetail::className(), ['fk_floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkHostelInfo()
    {
        return $this->hasOne(Hostel::className(), ['id' => 'fk_hostel_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostelRooms()
    {
        return $this->hasMany(HostelRoom::className(), ['fk_FLOOR_id' => 'id']);
    }
}
