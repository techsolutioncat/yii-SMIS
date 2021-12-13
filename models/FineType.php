<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fine_type".
 *
 * @property integer $id
 * @property string $title
 * @property integer $fk_branch_id
 * @property string $description
 * @property string $created_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $status
 *
 * @property Branch $fkBranch
 * @property User $updatedBy
 * @property StudentFineDetail[] $studentFineDetails
 */
class FineType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fine_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description','status'], 'required'],
            [['fk_branch_id', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['fk_branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['fk_branch_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'fk_branch_id' => 'Branch',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFineDetails()
    {
        return $this->hasMany(StudentFineDetail::className(), ['fk_fine_typ_id' => 'id']);
    }

    /*ADD BRANCH AUTOMATICALLY*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Place your custom code here
            if($this->isNewRecord)
            {
                $this->fk_branch_id = Yii::$app->common->getBranch();
                $this->created_date = new \yii\db\Expression('NOW()');
                $this->updated_by = Yii::$app->user->id;

            }
            elseif(!$this->isNewRecord)
            {
                $this->updated_date = new \yii\db\Expression('NOW()');
                $this->updated_by = Yii::$app->user->id;
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
