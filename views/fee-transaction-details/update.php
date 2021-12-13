<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeeTransactionDetails */

$this->title = 'Update Fee Transaction Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fee Transaction Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fee-transaction-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
