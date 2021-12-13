<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_section".
 *
 * @property integer $section_id
 * @property integer $fk_branch_id
 * @property string $title
 * @property integer $class_id
 * @property integer $fk_group_id
 * @property string $created_date
 * @property string $update_date
 * @property string $status
 *
 * @property RefClass $class
 * @property Branch $fkBranch
 * @property RefGroup $fkGroup
 * @property StudentInfo[] $studentInfos
 */
class RefSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'class_id', 'status'], 'required'],
            [['fk_branch_id', 'class_id', 'fk_group_id'], 'integer'],
            [['created_date', 'update_date'], 'safe'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['class_id' => 'class_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGroup::className(), 'targetAttribute' => ['fk_group_id' => 'group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_id' => 'Section ID',
            'fk_branch_id' => 'Fk Branch ID',
            'title' => 'Title',
            'class_id' => 'Class',
            'fk_group_id' => 'Fk Group ID',
            'created_date' => 'Created Date',
            'update_date' => 'Update Date',
            'status' => 'Status',
        ];
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
    public function getFkBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkGroup()
    {
        return $this->hasOne(RefGroup::className(), ['group_id' => 'fk_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['section_id' => 'section_id']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->created_date = new \yii\db\Expression('NOW()');
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->updated_date = null;
            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
            }
            return true;
        }
        else
        {
            return false;
        }
    }

}
