<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property integer $id
 * @property string $title
 * @property string $created_date
 * @property string $status
 *
 * @property User[] $users
 */
class UserRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['created_date'], 'safe'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['fk_role_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            /*if($this->isNewRecord)
            {
                $this->added_date = new \yii\db\Expression('NOW()');
            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
            }*/
            return true;
        }
        else
        {
            return false;
        }
    }
}
