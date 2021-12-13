<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_session".
 *
 * @property integer $session_id
 * @property integer $fk_branch_id
 * @property string $title
 *
 * @property RefClass[] $refClasses
 * @property Branch $fkBranch
 * @property StudentInfo[] $studentInfos
 */
class RefSession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title'], 'required'],
            [['fk_branch_id'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'session_id' => 'Session ID',
            'fk_branch_id' => 'Fk Branch ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefClasses()
    {
        return $this->hasMany(RefClass::className(), ['fk_session_id' => 'session_id']);
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
    public function getStudentInfos()
    {
        return $this->hasMany(StudentInfo::className(), ['session_id' => 'session_id']);
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
