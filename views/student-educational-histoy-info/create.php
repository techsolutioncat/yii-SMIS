<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentEducationalHistoryInfo */

$this->title = 'Create Student Educational History Info';
$this->params['breadcrumbs'][] = ['label' => 'Student Educational History Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-educational-history-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
