<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hostel_bed".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_room_id
 *
 * @property HostelRoom $fkRoom
 * @property HostelDetail[] $hostelDetails
 */
class HostelBed extends \yii\db\ActiveRecord
{
    public $Hostel_room;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostel_bed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_room_id'], 'required'],
            [['fk_room_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['title'], 'unique','message'=>'This Bed is Already Assigned','targetAttribute' => ['title', 'fk_room_id']],
            [['fk_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostelRoom::className(), 'targetAttribute' => ['fk_room_id' => 'id']],
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
            'fk_room_id' => Yii::t('app','Room'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkRoom()
    {
        return $this->hasOne(HostelRoom::className(), ['id' => 'fk_room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostelDetails()
    {
        return $this->hasMany(HostelDetail::className(), ['fk_bed_id' => 'id']);
    }
}
