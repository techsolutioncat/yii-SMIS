<?php 
use yii\helpers\Html; 
/* @var $this yii\web\View */
/* @var $model app\models\Exam */
 
$this->title = 'Create Exam';
//$this->params['breadcrumbs'][] = ['label' => 'Exam', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="filter_wrap content_col tabs grey-form">  
    <h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="form-center shade fee-gen">
        <div class="exam-form filters_head"> 
        <?= $this->render('_exam-form', [
            'model' => $model,
        ]) ?>
        </div>
        <div  id="subject-details">
            <div id="subject-inner" class="create-exams"></div>
        </div> 
    </div>
</div>
