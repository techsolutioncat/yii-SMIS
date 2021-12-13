<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_gardian_type".
 *
 * @property integer $gardian_type_id
 * @property string $Title
 *
 * @property EmployeeInfo[] $employeeInfos
 * @property StudentInfo[] $studentInfos
 */
class RefGardianType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_gardian_type';
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
            'gardian_type_id' => 'Gardian Type ID',
            'Title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['guardian_type_id' => 'gardian_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['guardian_type_id' => 'gardian_type_id']);
    }
}
