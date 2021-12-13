<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stu_reg_log_association".
 *
 * @property integer $id
 * @property integer $fk_stu_id
 * @property integer $fk_class_id
 * @property string $promoted_date
 * @property string $remarks
 * @property integer $fk_group_id
 * @property integer $fk_section_id
 * @property integer $current_class_id
 * @property integer $current_group_id
 * @property integer $current_section_id
 * @property integer $fk_branch_id
 *
 * @property StudentInfo $fkStu
 */
class StuRegLogAssociation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stu_reg_log_association';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_stu_id', 'fk_class_id', 'current_class_id'], 'required'],
            [['fk_stu_id', 'fk_class_id', 'fk_group_id', 'fk_section_id', 'current_class_id', 'current_group_id', 'current_section_id', 'fk_branch_id'], 'integer'],
            [['promoted_date'], 'safe'],
            [['remarks'], 'string', 'max' => 300],
            [['fk_stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentInfo::className(), 'targetAttribute' => ['fk_stu_id' => 'stu_id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_stu_id' => 'Fk Stu ID',
            'fk_class_id' => 'Fk Class ID',
            'promoted_date' => 'Promoted Date',
            'remarks' => 'Remarks',
            'fk_group_id' => 'Fk Group ID',
            'fk_section_id' => 'Fk Section ID',
            'current_class_id' => 'Current Class ID',
            'current_group_id' => 'Current Group ID',
            'current_section_id' => 'Current Section ID',
            'fk_branch_id' => 'Fk Branch ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStu()
    {
        return $this->hasOne(StudentInfo::className(), ['stu_id' => 'fk_stu_id']);
    }



    /*by default add crete date on create*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->promoted_date = new \yii\db\Expression('NOW()');
            } elseif (!$this->isNewRecord) {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;

        }
    }
}
