<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VisitorResponseInfo */

$this->title = 'Update Visitor Response Info: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Visitor Response Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="visitor-response-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
