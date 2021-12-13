<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_parents_info".
 *
 * @property integer $stu_parent_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $cnic
 * @property string $email
 * @property string $contact_no
 * @property string $profession
 * @property string $contact_no2
 * @property integer $stu_id
 * @property integer $gender_type
 * @property resource $guardian_name
 * @property string $relation
 * @property string $guardian_cnic
 * @property integer $guardian_contact_no
 * @property string $organisation
 * @property string $designation
 * @property string $office_no
 * @property string $facebook_id
 * @property string $twitter_id
 * @property string $linkdin_id
 * @property string $mother_name
* @property string $mother_profession
* @property string $mother_designation
* @property string $mother_organization
* @property string $mother_contactno
* @property string $mother_officeno
* @property string $mother_email
* @property string $mother_fb_id
* @property string $mother_twitter_id
* @property string $mother_linkedin
 *
 * @property StudentInfo $stu
 */
class StudentParentsInfo extends \yii\db\ActiveRecord
{
    public $contact_no_mother;
    public $office_no_mother;
    public $email_mother;
    public $facebook_id_mother;
    public $twitter_id_mother;
    public $linkdin_id_mother;

    public $first_name_mother;
    public $middle_name_mother;
    public $last_name_mother;
    public $organisation_mother;
    public $profession_mother;
    public $cnic_mother;
    public $designation_mother;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_parents_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'contact_no', 'profession', 'stu_id'], 'required'],
            [['stu_id', 'gender_type', 'guardian_contact_no'], 'integer'],
            [['last_name', 'contact_no', 'profession', 'contact_no2', 'relation', 'office_no'], 'string', 'max' => 30],
            [['middle_name', 'guardian_cnic'], 'string', 'max' => 15],
            [['cnic', 'email'], 'string', 'max' => 30],
            [['guardian_name', 'organisation', 'designation', 'facebook_id', 'twitter_id', 'linkdin_id'], 'string', 'max' => 50],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['stu_id' => 'stu_id']],
            [['mother_name', 'mother_profession', 'mother_designation', 'mother_organization', 'mother_contactno', 'mother_officeno', 'mother_email', 'mother_fb_id', 'mother_twitter_id', 'mother_linkedin'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stu_parent_id' =>  Yii::t('app','Stu Parent ID'),
            'first_name' => Yii::t('app','First Name'),
            'middle_name' => Yii::t('app','Middle Name'),
            'last_name' => Yii::t('app','Last Name'),
            'cnic' =>Yii::t('app','Cnic') ,
            'email' =>Yii::t('app','Email') ,
            'contact_no' => Yii::t('app','Contact No'),
            'profession' => Yii::t('app','Profession'),
            'contact_no2' => Yii::t('app','Contact No2'),
            'stu_id' => Yii::t('app','Stu ID'),
            'gender_type' => Yii::t('app','Gender Type'),
            'guardian_name' => Yii::t('app','Guardian Name'),
            'relation' => Yii::t('app','Relation'),
            'guardian_cnic' => Yii::t('app','Guardian Cnic'),
            'guardian_contact_no' => Yii::t('app','Guardian Contact No'),
            'organisation' => Yii::t('app','Organisation'),
            'designation' => Yii::t('app','Designation'),
            'office_no' => Yii::t('app','Office No'),
            'facebook_id' => Yii::t('app','Facebook ID'),
            'twitter_id' => Yii::t('app','Twitter ID'),
            'linkdin_id' => Yii::t('app','Linkdin ID'),
            'mother_name' => Yii::t('app','Mother Name'),
           'mother_profession' => Yii::t('app','Mother Profession'),
           'mother_designation' => Yii::t('app','Mother Designation'),
           'mother_organization' =>Yii::t('app','Mother Organization') ,
           'mother_contactno' => Yii::t('app','Mother Contact No'),
           'mother_officeno' =>Yii::t('app','Mother Office No') ,
           'mother_email' => Yii::t('app','Mother Email'),
           'mother_fb_id' =>Yii::t('app', 'Mother Facebook'),
           'mother_twitter_id' => Yii::t('app','Mother Twitter'),
           'mother_linkedin' => Yii::t('app','Mother Linkedin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'stu_id']);
    }
}
