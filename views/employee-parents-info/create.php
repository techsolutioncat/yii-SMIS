<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployeeParentsInfo */

$this->title = 'Create Employee Parents Info';
$this->params['breadcrumbs'][] = ['label' => 'Employee Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-parents-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
