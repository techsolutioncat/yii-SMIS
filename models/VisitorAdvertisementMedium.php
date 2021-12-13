<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor_advertisement_medium".
 *
 * @property integer $id
 * @property string $title
 *
 * @property VisitorInfo[] $visitorInfos
 */
class VisitorAdvertisementMedium extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor_advertisement_medium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitorInfos()
    {
        return $this->hasMany(VisitorInfo::className(), ['fk_adv_med_id' => 'id']);
    }
}
