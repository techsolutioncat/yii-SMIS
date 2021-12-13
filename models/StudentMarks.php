<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_marks".
 *
 * @property integer $id
 * @property integer $marks_obtained
 * @property integer $fk_exam_id
 * @property integer $fk_student_id
 * @property string $remarks
 *
 * @property StudentInfo $fkStudent
 * @property Exam $fkExam
 */
class StudentMarks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_marks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marks_obtained', 'fk_exam_id', 'fk_student_id'], 'required'],
            [['marks_obtained', 'fk_exam_id', 'fk_student_id'], 'integer'],
            [['remarks'], 'string', 'max' => 100],
            [['fk_student_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_student_id' => 'stu_id']],
            [['fk_exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exam::className(), 'targetAttribute' => ['fk_exam_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marks_obtained' => 'Marks Obtained',
            'fk_exam_id' => 'Fk Exam ID',
            'fk_student_id' => 'Fk Student ID',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStudent()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'fk_exam_id']);
    }
}
