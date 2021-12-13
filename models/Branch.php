<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property string $address
 * @property integer $fk_city_id
 * @property integer $fk_district_id
 * @property integer $fk_country_id
 * @property integer $fk_province_id
 * @property string $zip
 * @property string $phone
 * @property string $website
 * @property string $email
 * @property string $status
 *
 * @property RefCities $fkCity
 * @property RefDistrict $fkDistrict
 * @property RefProvince $fkProvince
 * @property EmplEducationalHistoryInfo[] $emplEducationalHistoryInfos
 * @property EmployeeInfo[] $employeeInfos
 * @property EmployeeParentsInfo[] $employeeParentsInfos
 * @property RefClass[] $refClasses
 * @property RefGroup[] $refGroups
 * @property RefSection[] $refSections
 * @property RefSession[] $refSessions
 * @property RefShift[] $refShifts
 * @property StudentInfo[] $studentInfos
 * @property User[] $users
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $title;
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'fk_city_id', 'fk_country_id', 'fk_district_id', 'fk_province_id', 'zip', 'email'], 'required'],
            [['description', 'status'], 'string'],
            [['logo'], 'file', 'extensions' => 'jpg,png,jpeg','mimeTypes' => 'image/jpeg, image/png', 'skipOnEmpty' => true],
            //[['email'],'email'],
            [['fk_city_id', 'fk_district_id', 'fk_province_id'], 'integer'],
            [['name', 'logo', 'address', 'zip', 'phone', 'website', 'email'], 'string', 'max' => 255],
            [['fk_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCities::className(), 'targetAttribute' => ['fk_city_id' => 'city_id']],
            [['fk_district_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistrict::className(), 'targetAttribute' => ['fk_district_id' => 'district_id']],
            [['fk_province_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvince::className(), 'targetAttribute' => ['fk_province_id' => 'province_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Branch Name',
            'description' => 'Description',
            'logo' => 'Logo',
            'address' => 'Address',
            'fk_city_id' => 'City',
            'fk_district_id' => 'District',
            'fk_province_id' => 'Province',
            'fk_country_id' => 'Country',
            'zip' => 'Zip',
            'phone' => 'Phone',
            'website' => 'Website',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCity()
    {
        return $this->hasOne(RefCities::className(), ['city_id' => 'fk_city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkDistrict()
    {
        return $this->hasOne(RefDistrict::className(), ['district_id' => 'fk_district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkProvince()
    {
        return $this->hasOne(RefProvince::className(), ['province_id' => 'fk_province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEducationalHistoryInfos()
    {
        return $this->hasMany(EmplEducationalHistoryInfo::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeParentsInfos()
    {
        return $this->hasMany(EmployeeParentsInfo::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefClasses()
    {
        return $this->hasMany(RefClass::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefGroups()
    {
        return $this->hasMany(RefGroup::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSections()
    {
        return $this->hasMany(RefSection::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSessions()
    {
        return $this->hasMany(RefSession::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefShifts()
    {
        return $this->hasMany(RefShift::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['fk_branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['fk_branch_id' => 'id']);
    }
}
