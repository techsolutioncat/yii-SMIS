<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leave_settings".
 *
 * @property integer $id
 * @property string $allowed_leaves
 * @property string $shortleave_policy
 * @property string $latecommer_policy
 * @property integer $branch_id
 * @property integer $status
 *
 * @property Branch $branch
 */
class LeaveSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allowed_leaves', 'branch_id'], 'required'],
            [['branch_id', 'status'], 'integer'],
            [['allowed_leaves', 'shortleave_policy', 'latecommer_policy'], 'string', 'max' => 25],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'allowed_leaves' => 'Allowed Leaves',
            'shortleave_policy' => 'Short-Leave Policy',
            'latecommer_policy' => 'Late-Comer Policy',
            'branch_id' => 'Branch ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }
}
