<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exam".
 *
 * @property integer $id
 * @property string $expense_head
 * @property string $expense_type
 * @property integer $amount
 * @property string $description

 */
class Expense extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense';
    }
}
