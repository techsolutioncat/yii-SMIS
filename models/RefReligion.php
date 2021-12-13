<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_religion".
 *
 * @property integer $religion_type_id
 * @property string $Title
 *
 * @property EmployeeInfo[] $employeeInfos
 * @property StudentInfo[] $studentInfos
 */
class RefReligion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_religion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Title'], 'required'],
            [['Title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'religion_type_id' => 'Religion Type ID',
            'Title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['religion_type_id' => 'religion_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['religion_id' => 'religion_type_id']);
    }
}
