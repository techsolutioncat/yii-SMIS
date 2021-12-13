<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "defult_salary_section".
 *
 * @property integer $ss_id
 * @property string $category_name
 * @property integer $id_deducted
 *
 * @property MainSalarySection[] $mainSalarySections
 */
class DefultSalarySection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'defult_salary_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'id_deducted'], 'required'],
            [['id_deducted'], 'integer'],
            [['category_name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ss_id' => 'Ss ID',
            'category_name' => 'Category Name',
            'id_deducted' => 'Id Deducted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainSalarySections()
    {
        return $this->hasMany(MainSalarySection::className(), ['ss_id' => 'ss_id']);
    }
}
