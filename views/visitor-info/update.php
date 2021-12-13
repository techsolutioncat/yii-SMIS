<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VisitorInfo */

$this->title = 'Update Visitor Info: ' . $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Visitor Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?> 
<div class="visitor-info-index content_col exam-form grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="subjects-index"> 
        <div class="form-center shade fee-gen pad">
            <?= $this->render('_formA', [
                'model' => $model,
                'model2' => $model2, 
            ]) ?>
        
        </div>
</div>
</div>
