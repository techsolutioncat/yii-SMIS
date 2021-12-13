<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dashboard".
 *
 * @property integer $id
 * @property integer $fk_branch_id
 * @property integer $sort_order
 * @property string $title
 * @property string $identifier
 * @property string $icon
 * @property string $details
 * @property string $type
 * @property integer $status
 *
 * @property Dashboard $fkBranch
 * @property Dashboard[] $dashboards
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'details', 'type','identifier'], 'required'],
            [['fk_branch_id','sort_order', 'status'], 'integer'],
            [['details', 'type'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['icon'], 'string', 'max' => 250],

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
            'title' => 'Title',
            'identifier' => 'Identifier',
            'icon' => 'Icon',
            'details' => 'Details',
            'type' => 'Type',
            'status' => 'Status',
            'sort_order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkBranch()
    {
        return $this->hasOne(Dashboard::className(), ['id' => 'fk_branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDashboards()
    {
        return $this->hasMany(Dashboard::className(), ['fk_branch_id' => 'id']);
    }

    /*added*/
    /*by default add crete date on create*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->fk_branch_id = null;//Yii::$app->common->getBranch();
            } elseif (!$this->isNewRecord) {
                //$this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        } else {
            return false;

        }
    }
}
