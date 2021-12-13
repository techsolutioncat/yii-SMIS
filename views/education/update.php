<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\EmplEducationalHistoryInfo */


$this->title = 'Update Empl Educational History Info: ' . $model->edu_history_id;

//$this->params['breadcrumbs'][] = ['label' => 'Back', 'url' => ['../employee/view?id='.$u_id]];
//$this->params['breadcrumbs'][] = ['label' => $model->edu_history_id, 'url' => ['view', 'id' => $model->edu_history_id]];
//$this->params['breadcrumbs'][] = 'Update';
//echo $u_id;die;
//echo '<pre>';print_r($model);die;
//echo $model->edu_history_id;die;
?>
<div class="row">
<div class="col-md-10"> 
<a href="../employee/view?id=<?= $u_id?>" class="btn btn-success pull-right">Back</a>
</div>
</div>
<div class="empl-educational-history-info-update content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen padd">   
		<?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
