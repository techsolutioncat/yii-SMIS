<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_cities".
 *
 * @property integer $city_id
 * @property string $city_name
 * @property integer $district_id
 *
 * @property Branch[] $branches
 * @property EmployeeInfo[] $employeeInfos
 * @property RefDistrict $district
 * @property StudentInfo[] $studentInfos
 */
class RefCities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'city_name', 'district_id'], 'required'],
            [['city_id', 'district_id'], 'integer'],
            [['city_name'], 'string', 'max' => 50],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistrict::className(), 'targetAttribute' => ['district_id' => 'district_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'district_id' => 'District ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['fk_city_id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['city_id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(RefDistrict::className(), ['district_id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['city_id' => 'city_id']);
    }
}
