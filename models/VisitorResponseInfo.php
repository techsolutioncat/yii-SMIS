<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor_response_info".
 *
 * @property integer $id
 * @property integer $fk_admission_vistor_id
 * @property string $first_attempt_date
 * @property string $second_attempt_date
 * @property string $third_attempt_date
 * @property string $remarks
 *
 * @property VisitorInfo $fkAdmissionVistor
 */
class VisitorResponseInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor_response_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_admission_vistor_id'], 'required'],
            [['fk_admission_vistor_id'], 'integer'],
            [['first_attempt_date', 'second_attempt_date', 'third_attempt_date'], 'safe'],
            [['remarks'], 'string', 'max' => 300],
            [['fk_admission_vistor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitorInfo::className(), 'targetAttribute' => ['fk_admission_vistor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_admission_vistor_id' => 'Fk Admission Vistor ID',
            'first_attempt_date' => 'First Attempt Date',
            'second_attempt_date' => 'Second Attempt Date',
            'third_attempt_date' => 'Third Attempt Date',
            'remarks' => 'Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdmissionVistor()
    {
        return $this->hasOne(VisitorInfo::className(), ['id' => 'fk_admission_vistor_id']);
    }
}
