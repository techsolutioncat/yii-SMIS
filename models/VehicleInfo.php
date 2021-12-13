<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_info".
 *
 * @property integer $id
 * @property string $Name
 * @property string $registration_no
 * @property string $model
 * @property integer $no_of_seats
 * @property string $vehicle_make
 *
 * @property TransportMain[] $transportMains
 */
class VehicleInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'registration_no', 'model', 'no_of_seats'], 'required'],
            [['no_of_seats','fk_branch_id'], 'integer'],
            [['Name', 'vehicle_make'], 'string', 'max' => 15],
            [['registration_no'], 'string', 'max' => 20],
            [['model'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Name' => 'Name',
            'registration_no' => 'Registration No',
            'model' => 'Model',
            'no_of_seats' => 'No Of Seats',
            'vehicle_make' => 'Vehicle Make',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportMains()
    {
        return $this->hasMany(TransportMain::className(), ['fk_vechicle_info_id' => 'id']);
    }

    /*by default add crete date on create*/
    public function beforeSave($insert)
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
    }
}
