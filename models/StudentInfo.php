<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_info".
 *
 * @property integer $stu_id
 * @property integer $acc_no
 * @property integer $user_id
 * @property integer $fk_branch_id
 * @property string $dob
 * @property string $contact_no
 * @property string $emergency_contact_no
 * @property integer $gender_type
 * @property integer $guardian_type_id
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property string $registration_date
 * @property string $fee_generation_date
 * @property string $monthly_fee_gen_date
 * @property integer $session_id
 * @property integer $group_id
 * @property integer $shift_id
 * @property integer $class_id
 * @property integer $section_id
 * @property string $cnic
 * @property string $location1
 * @property string $location2
 * @property integer $withdrawl_no
 * @property integer $district_id
 * @property integer $religion_id
 * @property boolean $parent_status
 * @property integer $is_hostel_avail
 * @property integer $fk_stop_id
 * @property integer $is_active
 * @property integer $fk_ref_country_id2
 * @property integer $fk_ref_province_id2
 * @property integer $fk_ref_district_id2
 * @property integer $fk_ref_city_id2
 * @property integer $transport_updated
 * @property integer $hostel_updated
 * @property integer $fk_fee_plan_type
 *
 * @property FeeCollectionParticular[] $feeCollectionParticulars
 * @property FeeParticulars[] $feeParticulars
 * @property StudentAttendance[] $studentAttendances
 * @property StudentEducationalHistoryInfo[] $studentEducationalHistoryInfos
 * @property StudentFeeSection[] $studentFeeSections
 * @property StudentFeeStatus[] $studentFeeStatuses
 * @property User $user
 * @property RefSection $section
 * @property RefSession $session
 * @property RefShift $shift
 * @property Stop $fkStop
 * @property RefDistrict $district
 * @property RefCities $city
 * @property RefClass $class
 * @property RefCountries $country
 * @property RefGardianType $guardianType
 * @property RefGroup $group
 * @property RefProvince $province
 * @property RefReligion $religion
 * @property StudentParentsInfo[] $studentParentsInfos
 * @property FeeTransactionDetails[] $feeTransactionDetails
* @property HostelDetail[] $hostelDetails
* @property RefCountries $fkRefCountryId2
* @property RefProvince $fkRefProvinceId2
* @property RefDistrict $fkRefDistrictId2
* @property RefCities $fkRefCityId2
 */
class StudentInfo extends \yii\db\ActiveRecord
{
    public $zone;
    public $route;
    public $stop;
    public $permanent_address;
    public $verified_by;
    public $different;
    public $is_transport_avail;

   // public $stop;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fk_branch_id', 'dob', 'gender_type', 'shift_id', 'class_id', 'section_id','fk_fee_plan_type','religion_id'], 'required', 'on' => 'admission'],

            [['user_id', 'fk_branch_id', 'gender_type', 'guardian_type_id', 'country_id', 'province_id', 'city_id', 'session_id', 'group_id', 'shift_id', 'class_id', 'section_id', 'withdrawl_no', 'district_id', 'religion_id', 'is_hostel_avail','is_transport_avail', 'fk_stop_id', 'is_active', 'fk_ref_country_id2', 'fk_ref_province_id2', 'fk_ref_district_id2', 'fk_ref_city_id2','fk_fee_plan_type','transport_updated', 'hostel_updated','acc_no'], 'integer'],
            [['dob', 'registration_date','fee_generation_date','monthly_fee_gen_date'], 'safe'],
            [['parent_status'], 'boolean'],
            [['contact_no'], 'string', 'max' => 20],
            
            [['emergency_contact_no'], 'string', 'max' => 30],
            [['cnic'], 'string', 'max' => 15],
            [['location1', 'location2'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSection::className(), 'targetAttribute' => ['section_id' => 'section_id']],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSession::className(), 'targetAttribute' => ['session_id' => 'session_id']],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefShift::className(), 'targetAttribute' => ['shift_id' => 'shift_id']],
            [['fk_stop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stop::className(), 'targetAttribute' => ['fk_stop_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefDistrict::className(), 'targetAttribute' => ['district_id' => 'district_id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCities::className(), 'targetAttribute' => ['city_id' => 'city_id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['class_id' => 'class_id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefCountries::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            [['guardian_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGardianType::className(), 'targetAttribute' => ['guardian_type_id' => 'gardian_type_id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGroup::className(), 'targetAttribute' => ['group_id' => 'group_id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProvince::className(), 'targetAttribute' => ['province_id' => 'province_id']],
            [['religion_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefReligion::className(), 'targetAttribute' => ['religion_id' => 'religion_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stu_id' => 'Stu ID',
            'user_id' => 'User',
            'acc_no' => Yii::t('app','Account #'),
            'fk_branch_id' => 'Branch',
            'dob' => Yii::t('app','Dob'),
            'contact_no' => Yii::t('app','Contact No'),
            'emergency_contact_no' => Yii::t('app','Emergency Contact No'),
            'gender_type' => Yii::t('app','Gender Type'),
            'guardian_type_id' => Yii::t('app','Guardian'),
            'country_id' => Yii::t('app','Country'),
            'province_id' => Yii::t('app','Province'),
            'city_id' => Yii::t('app','City'),
            'registration_date' => Yii::t('app','Registration Date'),
            'fee_generation_date' => Yii::t('app','Fee Generation Date'),
            'monthly_fee_gen_date' => Yii::t('app','Monthly Fee Generation Date'),
            'session_id' => Yii::t('app','Session'),
            'group_id' => Yii::t('app','Group'),
            'shift_id' => Yii::t('app','Shift'),
            'class_id' => Yii::t('app','Class'),
            'section_id' => Yii::t('app','Section'),
            'cnic' => Yii::t('app','Cnic'),
            'location1' => Yii::t('app','Postal Address'),
            'location2' => Yii::t('app','Permanent Address'),
            'withdrawl_no' => Yii::t('app','Withdrawl No'),
            'district_id' => Yii::t('app','District'),
            'religion_id' => Yii::t('app','Religion'),
            'parent_status' =>Yii::t('app','Parent Status') ,
            'is_hostel_avail' => Yii::t('app','Is Hostel Avail'),
            'fk_stop_id' => Yii::t('app','Stop'),
            'is_active' => Yii::t('app','Is Active'),
            'fk_ref_country_id2' => Yii::t('app','Permanent Country'),
            'fk_ref_province_id2' => Yii::t('app','Permanent Province'),
            'fk_ref_district_id2' => Yii::t('app','Permanent District'),
            'fk_ref_city_id2' => Yii::t('app','Permanent City'),
            'fk_fee_plan_type' =>Yii::t('app','Fee Plan'),
            'zone' =>Yii::t('app','Zone'),
            'stop' =>Yii::t('app','Stop'),
            'route' =>Yii::t('app','Route'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCollectionParticulars()
    {
        return $this->hasMany(FeeCollectionParticular::className(), ['fk_stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeParticulars()
    {
        return $this->hasMany(FeeParticulars::className(), ['fk_stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentAttendances()
    {
        return $this->hasMany(StudentAttendance::className(), ['fk_stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentEducationalHistoryInfos()
    {
        return $this->hasMany(StudentEducationalHistoryInfo::className(), ['stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFeeSections()
    {
        return $this->hasMany(StudentFeeSection::className(), ['stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFeeStatuses()
    {
        return $this->hasMany(StudentFeeStatus::className(), ['fk_stu_id' => 'stu_id']);
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
    public function getSection()
    {
        return $this->hasOne(RefSection::className(), ['section_id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(RefSession::className(), ['session_id' => 'session_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(RefShift::className(), ['shift_id' => 'shift_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStop()
    {
        return $this->hasOne(Stop::className(), ['id' => 'fk_stop_id']);
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
    public function getCity()
    {
        return $this->hasOne(RefCities::className(), ['city_id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(RefClass::className(), ['class_id' => 'class_id']);
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
    public function getGuardianType()
    {
        return $this->hasOne(RefGardianType::className(), ['gardian_type_id' => 'guardian_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(RefGroup::className(), ['group_id' => 'group_id']);
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
    public function getReligion()
    {
        return $this->hasOne(RefReligion::className(), ['religion_type_id' => 'religion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentParentsInfos()
    {
        return $this->hasOne(StudentParentsInfo::className(), ['stu_id' => 'stu_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
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
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getFkRefCityId2()
   {
       return $this->hasOne(RefCities::className(), ['city_id' => 'fk_ref_city_id2']);
   }
}
