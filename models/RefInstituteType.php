<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_institute_type".
 *
 * @property integer $institute_type_id
 * @property string $Title
 *
 * @property EmplEducationalHistoryInfo[] $emplEducationalHistoryInfos
 */
class RefInstituteType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_institute_type';
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
            'institute_type_id' => 'Institute Type ID',
            'Title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEducationalHistoryInfos()
    {
        return $this->hasMany(EmplEducationalHistoryInfo::className(), ['degree_type_id' => 'institute_type_id']);
    }
}
