<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vistor_category".
 *
 * @property integer $id
 * @property string $TYPE
 *
 * @property VisitorInfo[] $visitorInfos
 */
class VistorCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vistor_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitorInfos()
    {
        return $this->hasMany(VisitorInfo::className(), ['fk_vistor_category' => 'id']);
    }
}
