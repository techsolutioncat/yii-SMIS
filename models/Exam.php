<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exam".
 *
 * @property integer $id
 * @property integer $fk_class_id
 * @property integer $fk_group_id
 * @property integer $fk_branch_id
 * @property integer $fk_subject_id
 * @property integer $fk_section_id
 * @property integer $fk_exam_type
 * @property float $total_marks
 * @property integer $fk_subject_division_id
 * @property integer $passing_marks
 * @property string $start_date
 * @property string $end_date
 *
 * @property RefClass $fkClass
 * @property Subjects $fkSubject
 * @property RefGroup $fkGroup
 * @property RefSection $fkSection
 * @property ExamType $fkExamType
 * @property StudentMarks[] $studentMarks
 * @property Branch $fkBranch
 * @property SubjectDivision $fkSubjectDivision
 */
class Exam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_class_id', 'fk_subject_id', 'fk_section_id', 'fk_exam_type', 'total_marks'], 'required'],
            [['id', 'fk_class_id', 'fk_group_id', 'fk_subject_id', 'fk_section_id', 'fk_exam_type', 'passing_marks','fk_subject_division_id','do_not_create'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            //[['start_date','end_date'], 'date', 'format' => 'php:F d Y'],
            ['end_date','validateDates'],
            [['fk_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefClass::className(), 'targetAttribute' => ['fk_class_id' => 'class_id']],
            [['fk_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['fk_subject_id' => 'id']],
            [['fk_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefGroup::className(), 'targetAttribute' => ['fk_group_id' => 'group_id']],
            [['fk_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSection::className(), 'targetAttribute' => ['fk_section_id' => 'section_id']],
            [['fk_subject_division_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubjectDivision::className(), 'targetAttribute' => ['fk_subject_division_id' => 'id']],
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
            'fk_group_id' => Yii::t('app','Group'),
            'fk_subject_id' => Yii::t('app','Subject'),
            'fk_section_id' => Yii::t('app','Section'),
            'fk_subject_division_id' => 'Subject Division',
            'fk_exam_type' => Yii::t('app','Exam Type'),
            'total_marks' => Yii::t('app','Total Marks'),
            'passing_marks' => Yii::t('app','Passing Marks'),
            'start_date' => Yii::t('app','Start Date'),
            'end_date' => Yii::t('app','End Date'),
            'created_date' => Yii::t('app','Created Date'),
            'do_not_create'=> ' ',
        ];
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
    public function getFkSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'fk_subject_id']);
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
    public function getFkSection()
    {
        return $this->hasOne(RefSection::className(), ['section_id' => 'fk_section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkExamType()
    {
        return $this->hasOne(ExamType::className(), ['id' => 'fk_exam_type']);
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
    public function getStudentMarks()
    {
        return $this->hasMany(StudentMarks::className(), ['fk_exam_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkSubjectDivision()
    {
        return $this->hasOne(SubjectDivision::className(), ['id' => 'fk_subject_division_id']);
    }

    /*date validateion*/
    public function validateDates(){
        if(strtotime($this->end_date) <= strtotime($this->start_date)){
            //$this->addError('start_date','Please give correct Start and End dates');
            $this->addError('end_date','End Date must be greater than Start Date\'');
        }
    }

    /*by default add crete date on create*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->created_date = new \yii\db\Expression('NOW()');
            } elseif (!$this->isNewRecord) {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;

        }
    }
}
