<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentInfo */

$this->title = 'Update Student : ' . $model->user->first_name.' '.$model->user->middle_name .' '.$model->user->last_name;
//$this->params['breadcrumbs'][] = ['label' => 'Student Inf', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' =>$model->user->first_name.' '.$model->user->middle_name .' '.$model->user->last_name, 'url' => ['view', 'id' => $model->stu_id]];
//$this->params['breadcrumbs'][] = 'Update';
?> 
<div class="student-info-update content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="subjects-index shade">  
		<?= $this->render('_form', [
            'model'     => $model,
            'model2'    => $model2,
            'userModel' => $userModel,
            'hostelDetailModel'=>$hostelDetailModel,
            'branch_std_counter'=>$branch_std_counter
        ]) ?>  
    </div>
</div>
