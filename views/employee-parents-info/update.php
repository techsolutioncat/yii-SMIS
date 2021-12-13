<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeParentsInfo */

$this->title = 'Update Employee Parents Info: ' . $model->emp_parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->emp_parent_id, 'url' => ['view', 'id' => $model->emp_parent_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-parents-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
