<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_salary_section".
 *
 * @property integer $mss_id
 * @property string $value
 * @property integer $emp_id
 * @property integer $ss_id
 *
 * @property DefultSalarySection $ss
 * @property EmployeeInfo $emp
 */
class MainSalarySection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_salary_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'ss_id'], 'required'],
            [['emp_id', 'ss_id'], 'integer'],
            [['value'], 'string', 'max' => 7],
            [['ss_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefultSalarySection::className(), 'targetAttribute' => ['ss_id' => 'ss_id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['emp_id' => 'emp_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mss_id' => 'Mss ID',
            'value' => 'Value',
            'emp_id' => 'Emp ID',
            'ss_id' => 'Ss ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSs()
    {
        return $this->hasOne(DefultSalarySection::className(), ['ss_id' => 'ss_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'emp_id']);
    }
}
