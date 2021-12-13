<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_info".
 *
 * @property integer $emp_id
 * @property integer $fk_branch_id
 * @property integer $user_id
 * @property string $Name_in_urdu
 * @property string $dob
 * @property string $contact_no
 * @property string $emergency_contact_no
 * @property integer $gender_type
 * @property integer $guardian_type_id
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property string $hire_date
 * @property integer $designation_id
 * @property integer $marital_status
 * @property integer $department_type_id
 * @property string $salary
 * @property integer $religion_type_id
 * @property string $location1
 * @property string $Nationality
 * @property string $location2
 * @property string $cnic
 * @property integer $district_id
 * @property integer $is_active
 * @property integer $fk_ref_country_id2
 * @property integer $fk_ref_province_id2
 * @property integer $fk_ref_district_id2
 * @property integer $fk_ref_city_id2
 *
 * @property AdditionalCategorySection[] $additionalCategorySections
 * @property EmplEducationalHistoryInfo[] $emplEducationalHistoryInfos
 * @property EmplEducationalHistoryInfo[] $emplEducationalHistoryInfos0
 * @property EmplJobHistoryInfo[] $emplJobHistoryInfos
 * @property EmployeeAllowances[] $employeeAllowances
 * @property EmployeeAttendance[] $employeeAttendances
 * @property EmployeeBankInfo[] $employeeBankInfos
 * @property EmployeeDeductions[] $employeeDeductions
 * @property RefCities $city
 * @property RefDistrict $district
 * @property RefProvince $province
 * @property RefCountries $country
 * @property RefDepartment $departmentType
 * @property RefDesignation $designation
 * @property RefGardianType $guardianType
 * @property RefReligion $religionType
 * @property Branch $fkBranch
 * @property User $user
 * @property EmployeeMonthlySection[] $employeeMonthlySections
 * @property EmployeeParentsInfo[] $employeeParentsInfos
 * @property EmployeeSalaryDeductionDetail[] $employeeSalaryDeductionDetails
 * @property Hostel[] $hostels
 * @property RefCountries $fkRefCountryId2 
* @property RefProvince $fkRefProvinceId2 
* @property RefDistrict $fkRefDistrictId2
* @property RefCities $fkRefCityId2 
 */
class EmployeeInfo extends \yii\db\ActiveRecord
{
     public $permanent_address;
     public $attendanceModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id', 'user_id', 'dob', 'gender_type', 'hire_date', 'designation_id', 'marital_status', 'department_type_id', 'religion_type_id'], 'required'],
            [['fk_branch_id', 'user_id', 'gender_type', 'guardian_type_id', 'designation_id', 'marital_status', 'department_type_id', 'salary', 'religion_type_id', 'is_active','different_address', 'fk_ref_country_id2', 'fk_ref_province_id2', 'fk_ref_district_id2', 'fk_ref_city_id2'], 'integer'],
            [['dob', 'hire_date'], 'safe'],
            [['Name_in_urdu'], 'string', 'max' => 300],
            [['contact_no'], 'string', 'max' => 20],
            /*[['cnic'], 'unique', 'on' => 'create'],
            [['contact_no'], 'unique', 'on' => 'create'],*/
            [['emergency_contact_no'], 'string', 'max' => 30],
            [['location1', 'location2'], 'string', 'max' => 500],
            [['Nationality'], 'string', 'max' => 50],
            [['cnic'], 'string', 'max' => 15],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCities::className(), 'targetAttribute' => ['city_id' => 'city_id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistrict::className(), 'targetAttribute' => ['district_id' => 'district_id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvince::className(), 'targetAttribute' => ['province_id' => 'province_id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCountries::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            [['department_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDepartment::className(), 'targetAttribute' => ['department_type_id' => 'department_type_id']],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDesignation::className(), 'targetAttribute' => ['designation_id' => 'designation_id']],
            [['guardian_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGardianType::className(), 'targetAttribute' => ['guardian_type_id' => 'gardian_type_id']],
            [['religion_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefReligion::className(), 'targetAttribute' => ['religion_type_id' => 'religion_type_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
             [['fk_ref_country_id2'], 'exist', 'skipOnError' => true, 'targetClass' => RefCountries::className(), 'targetAttribute' => ['fk_ref_country_id2' => 'country_id']], 
           [['fk_ref_province_id2'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvince::className(), 'targetAttribute' => ['fk_ref_province_id2' => 'province_id']], 
           [['fk_ref_district_id2'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistrict::className(), 'targetAttribute' => ['fk_ref_district_id2' => 'district_id']], 
           [['fk_ref_city_id2'], 'exist', 'skipOnError' => true, 'targetClass' => RefCities::className(), 'targetAttribute' => ['fk_ref_city_id2' => 'city_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'fk_branch_id' => 'Fk Branch ID',
            'user_id' => 'User ID',
            'Name_in_urdu' => 'Name In Urdu',
            'dob' => 'Dob',
            'contact_no' => 'Contact No',
            'emergency_contact_no' => 'Emergency Contact No',
            'gender_type' => 'Gender Type',
            'guardian_type_id' => 'Guardian',
            'country_id' => 'Country',
            'province_id' => 'Province',
            'city_id' => 'City',
            'hire_date' => 'Hire Date',
            'designation_id' => 'Designation',
            'marital_status' => 'Marital Status',
            'department_type_id' => 'Department Type',
            'salary' => 'Salary',
            'religion_type_id' => 'Religion',
            'location1' => 'Permanent address',
            'Nationality' => 'Nationality',
            'location2' => 'Postal address',
            'cnic' => 'Cnic',
            'district_id' => 'District',
            'is_active' => 'Is Active',
            'fk_ref_country_id2' => 'Country',
            'fk_ref_province_id2' => 'Province',
            'fk_ref_district_id2' => 'District',
            'fk_ref_city_id2' => 'City',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalCategorySections()
    {
        return $this->hasMany(AdditionalCategorySection::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEducationalHistoryInfos()
    {
        return $this->hasMany(EmplEducationalHistoryInfo::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplEducationalHistoryInfos0()
    {
        return $this->hasMany(EmplEducationalHistoryInfo::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmplJobHistoryInfos()
    {
        return $this->hasMany(EmplJobHistoryInfo::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeAllowances()
    {
        return $this->hasMany(EmployeeAllowances::className(), ['fk_emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeAttendances()
    {
        return $this->hasMany(EmployeeAttendance::className(), ['fk_empl_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBankInfos()
    {
        return $this->hasMany(EmployeeBankInfo::className(), ['fk_emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeDeductions()
    {
        return $this->hasMany(EmployeeDeductions::className(), ['fk_emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(RefCities::className(), ['city_id' => 'city_id']);
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
    public function getProvince()
    {
        return $this->hasOne(RefProvince::className(), ['province_id' => 'province_id']);
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
    public function getDepartmentType()
    {
        return $this->hasOne(RefDepartment::className(), ['department_type_id' => 'department_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(RefDesignation::className(), ['designation_id' => 'designation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardianType()
    {
        return $this->hasOne(RefGardianType::className(), ['gardian_type_id' => 'guardian_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReligionType()
    {
        return $this->hasOne(RefReligion::className(), ['religion_type_id' => 'religion_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeMonthlySections()
    {
        return $this->hasMany(EmployeeMonthlySection::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeParentsInfos()
    {
        return $this->hasMany(EmployeeParentsInfo::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSalaryDeductionDetails()
    {
        return $this->hasMany(EmployeeSalaryDeductionDetail::className(), ['fk_emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostels()
    {
        return $this->hasMany(Hostel::className(), ['fk_warden_id' => 'emp_id']);
    }


    public function getFkRefCountryId2() 
   { 
       return $this->hasOne(RefCountries::className(), ['country_id' => 'fk_ref_country_id2']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getFkRefProvinceId2() 
   { 
       return $this->hasOne(RefProvince::className(), ['province_id' => 'fk_ref_province_id2']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getFkRefDistrictId2() 
   { 
       return $this->hasOne(RefDistrict::className(), ['district_id' => 'fk_ref_district_id2']); 
   } 

   public function getFkRefCityId2() 
   { 
       return $this->hasOne(RefCities::className(), ['city_id' => 'fk_ref_city_id2']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
}
