<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */

$this->title = 'Update Branch: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="branch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
         'model' => $model,
         'model2'  =>$model2,
         'FeePaymentMode'  =>$FeePaymentMode,
         'FeeHeads'  =>$FeeHeads,
         'settings'  =>$settings,
         'FeeGroup'  =>$FeeGroup,
         'FeePlanType'  =>$FeePlanType,
    ]) ?>

</div>
