<?php

use yii\helpers\Html;
use app\widgets\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\Settings */

$this->title = 'Branch Settings';
//$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<?=Alert::widget();?> 
<div class="free-generator content_col exam-form grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1> 
   	<div class="form-center shade fee-gen">   
        <?= $this->render('_form', [
            'model' => $model,
            'modelHead' => $modelHead,
            'modelFeeHeads' => $modelFeeHeads,

        ]) ?>
    </div>
</div>
