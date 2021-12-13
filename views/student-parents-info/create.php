<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentParentsInfo */

$this->title = 'Create Student Parents Info';
$this->params['breadcrumbs'][] = ['label' => 'Student Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-parents-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
