<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentEducationalHistoryInfo */

$this->title = 'Update Student Educational History Info: ' . $model->edu_history_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Educational History Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->edu_history_id, 'url' => ['view', 'id' => $model->edu_history_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-educational-history-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
