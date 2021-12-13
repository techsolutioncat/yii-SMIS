<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalaryMain */

$this->title = 'Create Salary Main';
//$this->params['breadcrumbs'][] = ['label' => 'Salary Mains', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-main-create content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen padd">  
		<?= $this->render('_form', [
            'model' => $model,
        ]) ?>
	</div>
</div>
