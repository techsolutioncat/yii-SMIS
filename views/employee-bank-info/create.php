<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmployeeBankInfo */

$this->title = 'Create Employee Bank Info';
$this->params['breadcrumbs'][] = ['label' => 'Employee Bank Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-bank-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
