<?php
namespace app\components;


use app\models\FeeDiscounts;
use app\models\FeeDiscountTypes;
use app\models\FeeParticulars;
use app\models\RefClass;
use app\models\search\FineType;
use app\models\Settings;
use app\models\SmsLog;
use Yii;
use yii\base\Component;
use app\models\search\FeeHeads;
use app\models\Branch;
use app\models\search\FeePlanType;
use app\models\RefSection;
use app\models\Session;
use app\models\RefGroup;
use app\models\User;
use app\models\StudentParentsInfo;
use yii\helpers\ArrayHelper;

class FeeHelper extends Component
{

   public static function getNextMonthChallan() {
           $due_date          = date('Y-m-'.Yii::$app->common->getBranchSettings()->fee_due_date, strtotime('+1 months'));
              
    }
}




