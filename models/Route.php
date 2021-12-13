<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "route".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_zone_id
 *
 * @property Zone $fkZone
 * @property Stop[] $stops
 * @property TransportMain[] $transportMains
 */
class Route extends \yii\db\ActiveRecord
{
    public $zone;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_zone_id'], 'required'],
            [['fk_zone_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['fk_zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['fk_zone_id' => 'id']],
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
            'fk_zone_id' => 'Zone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'fk_zone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStops()
    {
        return $this->hasMany(Stop::className(), ['fk_route_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportMains()
    {
        return $this->hasMany(TransportMain::className(), ['fk_route_id' => 'id']);
    }
}
