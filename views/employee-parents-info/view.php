<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeeParentsInfo */

$this->title = $model->emp_parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-parents-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->emp_parent_id], ['class' => 'btn green-btn']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->emp_parent_id], [
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
            'emp_parent_id',
            'fk_branch_id',
            'first_name',
            'middle_name',
            'last_name',
            'cnic',
            'email:email',
            'contact_no',
            'profession',
            'contact_no2',
            'emp_id',
            'spouse_name',
            'no_of_children',
        ],
    ]) ?>

</div>
