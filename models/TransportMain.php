<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transport_main".
 *
 * @property integer $id
 * @property integer $fk_route_id
 * @property integer $fk_driver_id
 * @property integer $fk_vechicle_info_id
 *
 * @property Route $fkRoute
 * @property EmployeeInfo $fkDriver
 * @property VehicleInfo $fkVechicleInfo
 */
class TransportMain extends \yii\db\ActiveRecord
{
    public $departments;
    public $zone;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_route_id', 'fk_driver_id', 'fk_vechicle_info_id'], 'required'],
            [['fk_route_id', 'fk_driver_id', 'fk_vechicle_info_id'], 'integer'],
            [['fk_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => Route::className(), 'targetAttribute' => ['fk_route_id' => 'id']],
            [['fk_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeInfo::className(), 'targetAttribute' => ['fk_driver_id' => 'emp_id']],
            [['fk_vechicle_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleInfo::className(), 'targetAttribute' => ['fk_vechicle_info_id' => 'id']],
            [['fk_route_id'], 'unique','message'=>'This Route is Already Assigned'],
            [['fk_vechicle_info_id'], 'unique','message'=>'This Vechicle is Already Assigned'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_route_id' => Yii::t('app','Route'),
            'fk_driver_id' => Yii::t('app','Driver'),
            'fk_vechicle_info_id' => Yii::t('app','Vechicle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkRoute()
    {
        return $this->hasOne(Route::className(), ['id' => 'fk_route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkDriver()
    {
        return $this->hasOne(EmployeeInfo::className(), ['emp_id' => 'fk_driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkVechicleInfo()
    {
        return $this->hasOne(VehicleInfo::className(), ['id' => 'fk_vechicle_info_id']);
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
