<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MainSalarySection */

$this->title = $model->mss_id;
$this->params['breadcrumbs'][] = ['label' => 'Main Salary Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-salary-section-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->mss_id], ['class' => 'btn green-btn']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->mss_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mss_id',
            'value',
            'emp_id',
            'ss_id',
        ],
    ]) ?>

</div>
