<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Branch */

//$this->title = 'Create Branch';
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">

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
