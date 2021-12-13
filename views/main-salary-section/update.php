<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MainSalarySection */

$this->title = 'Update Main Salary Section: ' . $model->mss_id;
$this->params['breadcrumbs'][] = ['label' => 'Main Salary Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mss_id, 'url' => ['view', 'id' => $model->mss_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-salary-section-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
