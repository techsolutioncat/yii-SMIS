<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_province".
 *
 * @property integer $province_id
 * @property integer $country_id
 * @property string $province_name
 *
 * @property Branch[] $branches
 * @property EmployeeInfo[] $employeeInfos
 * @property RefDistrict[] $refDistricts
 * @property RefCountries $country
 * @property StudentInfo[] $studentInfos
 */
class RefProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'country_id', 'province_name'], 'required'],
            [['province_id', 'country_id'], 'integer'],
            [['province_name'], 'string', 'max' => 50],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCountries::className(), 'targetAttribute' => ['country_id' => 'country_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'country_id' => 'Country ID',
            'province_name' => 'Province Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['fk_province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefDistricts()
    {
        return $this->hasMany(RefDistrict::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(RefCountries::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['province_id' => 'province_id']);
    }
}
