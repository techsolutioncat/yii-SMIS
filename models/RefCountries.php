<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_countries".
 *
 * @property integer $country_id
 * @property string $country_name
 *
 * @property EmployeeInfo[] $employeeInfos
 * @property RefProvince[] $refProvinces
 * @property StudentInfo[] $studentInfos
 */
class RefCountries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'country_name'], 'required'],
            [['country_id'], 'integer'],
            [['country_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'country_name' => 'Country Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefProvinces()
    {
        return $this->hasMany(RefProvince::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['country_id' => 'country_id']);
    }
}
