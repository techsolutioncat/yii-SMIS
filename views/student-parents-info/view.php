<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentParentsInfo */

$this->title = $model->stu_parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Parents Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-parents-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->stu_parent_id], ['class' => 'btn green-btn']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->stu_parent_id], [
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
            'stu_parent_id',
            'first_name',
            'middle_name',
            'last_name',
            'cnic',
            'email:email',
            'contact_no',
            'profession',
            'contact_no2',
            'stu_id',
            'gender_type',
            'guardian_name',
            'relation',
            'guardian_cnic',
            'guardian_contact_no',
        ],
    ]) ?>

</div>
