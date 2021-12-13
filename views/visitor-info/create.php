<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VisitorInfo */

$this->title = 'Add Visitor';
//$this->params['breadcrumbs'][] = ['label' => 'Visitor Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="visitor-info-create content_col exam-form grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
   	<div class="form-center shade fee-gen pad">  
		<?= $this->render('_form', [
            'model' => $model,
            'model2' => $model2,
        ]) ?>
    </div>
</div>
