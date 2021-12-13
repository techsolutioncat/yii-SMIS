<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor_infos".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property string $name
 * @property string $cnic
 * @property integer $contact_no
 * @property integer $fk_adv_med_id
 * @property integer $fk_class_id
 * @property string $date_of_visit
 * @property integer $is_active
 * @property integer $fk_vistor_category
 * @property string $product_name
 * @property string $product_description
 * @property string $last_degree
 * @property string $experiance
 * @property string $last_organization
 * @property string $qualification
 * @property string $reference
 * @property integer $designation
 * @property string $organization
 * @property string $address
 * @property string $coordinator_comments
 * @property integer $mode_advertisement
 * @property string $admin_personel_observation 
 * @property integer $is_admitted
 *
 * @property VisitorAdvertisementMedium $fkAdvMed
 * @property RefClass $fkClass
 * @property Branch $fkBranch
 */
class VisitorInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id', 'name','admin_personel_observation'], 'required'],
            [['fk_branch_id', 'fk_adv_med_id', 'fk_class_id', 'is_active', 'fk_vistor_category', 'designation', 'mode_advertisement', 'is_admitted'], 'integer'],
            [['date_of_visit','admin_personel_observation'], 'safe'],
            [['name', 'product_description', 'address'], 'string', 'max' => 300],
            [['cnic'], 'string', 'max' => 15],
            [['contact_no'], 'string', 'max' => 25],
            [['product_name'], 'string', 'max' => 50],
            [['last_degree', 'experiance', 'last_organization', 'qualification', 'reference', 'organization'], 'string', 'max' => 255],
            [['coordinator_comments'], 'string', 'max' => 22],
            [['fk_adv_med_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitorAdvertisementMedium::className(), 'targetAttribute' => ['fk_adv_med_id' => 'id']],
            [['fk_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['fk_class_id' => 'class_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_branch_id' => 'Fk Branch ID',
            'name' => 'Name',
            'cnic' => 'Cnic',
            'contact_no' => 'Contact No',
            'fk_adv_med_id' => 'Mode of Knowing',
            'fk_class_id' => 'Class',
            'date_of_visit' => 'Date Of Visit',
            'is_active' => 'Is Active',
            'fk_vistor_category' => 'Visitor Category',
            'product_name' => 'Product Name',
            'product_description' => 'Product Description',
            'last_degree' => 'Last Degree',
            'experiance' => 'Experiance',
            'last_organization' => 'Last Organization',
            'qualification' => 'Qualification',
            'reference' => 'Reference',
            'designation' => 'Designation',
            'organization' => 'Organization',
            'address' => 'Address',
            'coordinator_comments' => 'Feed Back Detail',
            'mode_advertisement' => 'Mode Advertisement',
            'admin_personel_observation' => 'Admin Personel Observation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdvMed()
    {
        return $this->hasOne(VisitorAdvertisementMedium::className(), ['id' => 'fk_adv_med_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkClass()
    {
        return $this->hasOne(RefClass::className(), ['class_id' => 'fk_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }
}
