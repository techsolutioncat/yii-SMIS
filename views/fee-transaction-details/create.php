<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeeTransactionDetails */

$this->title = 'Create Fee Transaction Details';
$this->params['breadcrumbs'][] = ['label' => 'Fee Transaction Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-transaction-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
