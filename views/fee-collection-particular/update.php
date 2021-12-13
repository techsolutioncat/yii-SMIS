<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeeCollectionParticular */

$this->title = 'Update Fee Collection Particular: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fee Collection Particulars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fee-collection-particular-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
