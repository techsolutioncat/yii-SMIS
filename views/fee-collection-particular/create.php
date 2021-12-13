<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeeCollectionParticular */

$this->title = 'Create Fee Collection Particular';
$this->params['breadcrumbs'][] = ['label' => 'Fee Collection Particulars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-collection-particular-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
