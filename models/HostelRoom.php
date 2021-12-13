<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hostel_room".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_FLOOR_id
 *
 * @property HostelDetail[] $hostelDetails
 * @property HostelFloor $fkFLOOR
 */
class HostelRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostel_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_FLOOR_id'], 'required'],
            [['fk_FLOOR_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['title'], 'unique','message'=>'This Room is Already Assigned','targetAttribute' => ['title', 'fk_FLOOR_id']],
            [['fk_FLOOR_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostelFloor::className(), 'targetAttribute' => ['fk_FLOOR_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'fk_FLOOR_id' => 'Hostel Floor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostelDetails()
    {
        return $this->hasMany(HostelDetail::className(), ['fk_room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFLOOR()
    {
        return $this->hasOne(HostelFloor::className(), ['id' => 'fk_FLOOR_id']);
    }
}
