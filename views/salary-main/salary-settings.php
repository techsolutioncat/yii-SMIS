 <?php

use yii\helpers\Html;
use yii\grid\GridView;
?>
<div style="height: 20px"></div>
 <p>

  <!-- <?//= Html::a('Create Salary Main', ['create'], ['class' => 'btn green-btn']) ?>&nbsp; -->
  <?= Html::a('Salary Pay Groups', ['/salary-pay-groups'], ['class' => 'btn green-btn']) ?>
  <?= Html::a('Salary Pay Stages', ['/salary-pay-stages'], ['class' => 'btn green-btn']) ?>&nbsp;
  <?= Html::a('Salary Allownces', ['/salary-allownces'], ['class' => 'btn green-btn']) ?>&nbsp;
  <?= Html::a('Salary Deduction', ['/salary-deduction-type'], ['class' => 'btn green-btn']) ?>&nbsp;
  <?= Html::a('Salary Tax', ['/salary-tax'], ['class' => 'btn green-btn']) ?>
  <?= Html::a('Payment Method', ['/payment-method'], ['class' => 'btn green-btn']) ?>
  <?= Html::a('Leave Settings', ['/leave-settings'], ['class' => 'btn green-btn']) ?>
  <?= Html::a('Employee Salary Payslip', ['/salary-main/leave-department'], ['class' => 'btn green-btn']) ?>
    </p>