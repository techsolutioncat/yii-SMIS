<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stop".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_route_id
 * @property integer $fare
 *
 * @property Route $fkRoute
 */
class Stop extends \yii\db\ActiveRecord
{
    public $route;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'fk_route_id','fk_branch_id'], 'required'],
            [['fk_route_id', 'fare'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['fk_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => Route::className(), 'targetAttribute' => ['fk_route_id' => 'id']],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'fk_route_id' => Yii::t('app','Route'),
            'fare' => Yii::t('app','Fare'),
            'fk_branch_id' => Yii::t('app','Fk Branch ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkRoute()
    {
        return $this->hasOne(Route::className(), ['id' => 'fk_route_id']);
    }
     public function getFkBranch()
   {
       return $this->hasOne(Branch::className(), ['id' => 'fk_branch_id']);
   }
}
