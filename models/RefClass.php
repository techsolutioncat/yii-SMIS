<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_class".
 *
 * @property integer $class_id
 * @property integer $fk_branch_id
 * @property string $title
 * @property string $status
 * @property integer $fk_session_id
 * @property Exam[] $exams
 * @property RefSession $fkSession
 * @property Branch $fkBranch
 * @property RefGroup[] $refGroups
 * @property RefSection[] $refSections
 * @property StudentInfo[] $studentInfos
 * @property Subjects[] $subjects
 */
class RefClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_session_id'], 'required'],
            [['fk_branch_id', 'fk_session_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['status'], 'safe'],
            [['fk_session_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSession::className(), 'targetAttribute' => ['fk_session_id' => 'session_id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_id' => Yii::t('app','Class'),
            'fk_branch_id' => 'Branch',
            'title' => 'Title',
            'fk_session_id' => Yii::t('app','Session'),
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExams()
    {
        return $this->hasMany(Exam::className(), ['fk_class_id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkSession()
    {
        return $this->hasOne(RefSession::className(), ['session_id' => 'fk_session_id']);
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
    public function getRefGroups()
    {
        return $this->hasMany(RefGroup::className(), ['fk_class_id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSections()
    {
        return $this->hasMany(RefSection::className(), ['class_id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['class_id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subjects::className(), ['fk_class_id' => 'class_id']);
    }
    /*by default add crete date on create*/
    /*public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->fk_branch_id = Yii::$app->common->getBranch();
            } elseif (!$this->isNewRecord) {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;

        }
    }*/
}
