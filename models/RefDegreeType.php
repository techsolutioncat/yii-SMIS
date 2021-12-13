<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_degree_type".
 *
 * @property integer $degree_type_id
 * @property string $Title
 *
 * @property EmplEducationalHistoryInfo[] $emplEducationalHistoryInfos
 */
class RefDegreeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_degree_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Title'], 'required'],
            [['Title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'degree_type_id' => 'Degree Type ID',
            'Title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEducationalHistoryInfos()
    {
        return $this->hasMany(EmplEducationalHistoryInfo::className(), ['degree_type_id' => 'degree_type_id']);
    }
}
