<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MainSalarySection */

$this->title = 'Create Main Salary Section';
$this->params['breadcrumbs'][] = ['label' => 'Main Salary Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-salary-section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
