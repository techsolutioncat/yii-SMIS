<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_district".
 *
 * @property integer $district_id
 * @property string $District_Name
 * @property integer $province_id
 *
 * @property Branch[] $branches
 * @property EmployeeInfo[] $employeeInfos
 * @property RefCities[] $refCities
 * @property RefProvince $province
 * @property StudentInfo[] $studentInfos
 */
class RefDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['district_id', 'District_Name', 'province_id'], 'required'],
            [['district_id', 'province_id'], 'integer'],
            [['District_Name'], 'string', 'max' => 50],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvince::className(), 'targetAttribute' => ['province_id' => 'province_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'district_id' => 'District ID',
            'District_Name' => 'District  Name',
            'province_id' => 'Province ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['fk_district_id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['district_id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefCities()
    {
        return $this->hasMany(RefCities::className(), ['district_id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(RefProvince::className(), ['province_id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['district_id' => 'district_id']);
    }
}
