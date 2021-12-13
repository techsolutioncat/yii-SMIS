<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_group".
 *
 * @property integer $group_id
 * @property integer $fk_branch_id
 * @property string $title
 * @property integer $fk_class_id
 * @property string $created_date
 * @property string $updated_date
 * @property string $status
 *
 * @property Branch $fkBranch
 * @property RefClass $fkClass
 * @property RefSection[] $refSections
 * @property StudentInfo[] $studentInfos
 */
class RefGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title', 'fk_class_id', 'status'], 'required'],
            [['fk_branch_id', 'fk_class_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['fk_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['fk_class_id' => 'class_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group',
            'fk_branch_id' => 'Fk Branch ID',
            'title' => 'Title',
            'fk_class_id' => 'Class',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status' => 'Status',
        ];
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
    public function getFkClass()
    {
        return $this->hasOne(RefClass::className(), ['class_id' => 'fk_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSections()
    {
        return $this->hasMany(RefSection::className(), ['fk_group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['group_id' => 'group_id']);
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
