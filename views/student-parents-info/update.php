<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentParentsInfo */

$this->title = 'Update Student Parents Info: ' . $model->stu_parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stu_parent_id, 'url' => ['view', 'id' => $model->stu_parent_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-parents-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
