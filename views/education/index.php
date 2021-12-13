<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EmplEducationalHistoryInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empl Educational History Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empl-educational-history-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?//= Html::a('Create Empl Educational History Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'edu_history_id',
            //'fk_branch_id',
            [
            //'attribute'=>'degree_type_id',
            'label'=>'Employee',
            'value'=>function($data){
                if($data->emp_id){
                    return $data->emp->user->first_name;
                }else{
                    return "N/A";
                }
            }
            ],
            'degree_name',
            
            /*[
            //'attribute'=>'degree_type_id',
            'label'=>'Degree Type',
            'value'=>function($data){
                if($data->degree_type_id){
                    return $data->degreeType->Title;
                }else{
                    return "N/A";
                }
            }
            ],*/
            'Institute_name',
            // 'institute_type_id',
            // 'grade',
            // 'total_marks',
             'start_date',
             'end_date',
             
            // 'marks_obtained',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
