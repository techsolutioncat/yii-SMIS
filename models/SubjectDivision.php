<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject_division".
 *
 * @property integer $id
 * @property integer $fk_subject_id
 * @property string $title
 * @property string $status
 * @property string $created_date
 *
 * @property Subjects $fkSubject
 */
class SubjectDivision extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject_division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_subject_id', 'title', 'status'], 'required'],
            [['fk_subject_id'], 'integer'],
            [['status'], 'string'],
            [['created_date'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['fk_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['fk_subject_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_subject_id' => 'Subject',
            'title' => 'Title',
            'status' => 'Status',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'fk_subject_id']);
    }

    /*by default add crete date on create*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
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
