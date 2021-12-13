<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $fk_class_id
 * @property string $title
 * @property string $code
 * @property integer $is_division
 * @property string $status
 * @property string $created_date
 * @property integer $fk_group_id
 *
 * @property SubjectDivision[] $subjectDivisions
 * @property RefClass $fkClass
 * @property Branch $fkBranch
 * @property RefGroup $fkGroup
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_class_id', 'title', 'status'], 'required'],
            [['fk_branch_id', 'fk_class_id', 'is_division'], 'integer'],
            [['status'], 'string'],
            [['created_date','is_division'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['code'], 'string', 'max' => 20],
            [['fk_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['fk_class_id' => 'class_id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGroup::className(), 'targetAttribute' => ['fk_group_id' => 'group_id']],
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
            'fk_class_id' => Yii::t('app','Class'),
            'title' => Yii::t('app','Title'),
            'code' => Yii::t('app','Code'),
            'is_division' =>Yii::t('app','Is Division'),
            'status' => Yii::t('app','Status'),
            'created_date' => Yii::t('app','Created Date'),
            'fk_group_id' => Yii::t('app','Group'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectDivisions()
    {
        return $this->hasMany(SubjectDivision::className(), ['fk_subject_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkGroup()
    {
        return $this->hasOne(RefGroup::className(), ['group_id' => 'fk_group_id']);

    }

    /*by default add crete date on create*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->created_date = new \yii\db\Expression('NOW()');
                $this->fk_branch_id = Yii::$app->common->getBranch();
            } elseif (!$this->isNewRecord) {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;

        }
    }
}