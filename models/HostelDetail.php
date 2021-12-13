<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hostel_detail".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_hostel_id
 * @property integer $fk_floor_id
 * @property integer $fk_room_id
 * @property integer $fk_bed_id
 * @property string $is_booked
 * @property integer $fk_student_id
 * @property string $create_date
 *
 * @property Hostel $fkHostel
 * @property HostelFloor $fkFloor
 * @property HostelRoom $fkRoom
 * @property HostelBed $fkBed
 * @property StudentInfo $fkStudent
 */
class HostelDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hostel_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_hostel_id', 'fk_floor_id', 'fk_room_id', 'fk_bed_id','fk_student_id'], 'required','on' => 'create'],
            [['fk_hostel_id', 'fk_floor_id', 'fk_room_id', 'fk_bed_id', 'fk_student_id','fk_branch_id'], 'integer'],
            [['is_booked'], 'string'],
            [['create_date'], 'safe'],
            //[['fk_bed_id'], 'unique'],
            [['fk_hostel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hostel::className(), 'targetAttribute' => ['fk_hostel_id' => 'id']],
            [['fk_floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostelFloor::className(), 'targetAttribute' => ['fk_floor_id' => 'id']],
            [['fk_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostelRoom::className(), 'targetAttribute' => ['fk_room_id' => 'id']],
            [['fk_bed_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostelBed::className(), 'targetAttribute' => ['fk_bed_id' => 'id']],
            [['fk_student_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_student_id' => 'stu_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_hostel_id' => Yii::t('app','Hostel'),
            'fk_branch_id' => Yii::t('app','Branch'),
            'fk_floor_id' => Yii::t('app','Floor'),
            'fk_room_id' => Yii::t('app','Room'),
            'fk_bed_id' => Yii::t('app','Bed'),
            'is_booked' => Yii::t('app','Is Booked'),
            'fk_student_id' =>Yii::t('app', 'Student'),
            'create_date' =>Yii::t('app','Allotment date') ,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkHostel()
    {
        return $this->hasOne(Hostel::className(), ['id' => 'fk_hostel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkFloor()
    {
        return $this->hasOne(HostelFloor::className(), ['id' => 'fk_floor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkRoom()
    {
        return $this->hasOne(HostelRoom::className(), ['id' => 'fk_room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBed()
    {
        return $this->hasOne(HostelBed::className(), ['id' => 'fk_bed_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStudent()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_student_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->fk_branch_id = Yii::$app->common->getBranch();
            }
            elseif(!$this->isNewRecord)
            {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
