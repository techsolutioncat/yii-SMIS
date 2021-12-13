<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_tax".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property double $tax_rate
 *
 * @property SalaryMain[] $salaryMains
 */
class SalaryTax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_branch_id'], 'integer'],
            [['tax_rate'], 'required'],
            [['tax_rate'], 'number'],
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
            'tax_rate' => 'Tax Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryMains()
    {
        return $this->hasMany(SalaryMain::className(), ['fk_tax_id' => 'id']);
    }
}
