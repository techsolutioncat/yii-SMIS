<?php 
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalaryMain */

$this->title = 'Update Salary Main: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Salary Mains', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?> 
<div class="salary-main-update content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen padd">
		<?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    
    </div>
</div>