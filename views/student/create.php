<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentInfo */

$this->title = 'Create Student';
//$this->params['breadcrumbs'][] = ['label' => 'Student Information', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-profile-index content_col">
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="student-info-create form-center shade grey-form ">  
        <?= $this->render('_form', [
            'model'     => $model,
            'model2'    => $model2,
            'userModel' => $userModel,
            'hostelDetailModel' => $hostelDetailModel,
            'branch_std_counter'=> $branch_std_counter
        ]) ?> 
    </div>
</div>
