<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Info', ['create'], ['class' => 'btn green-btn']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'stu_id',
                'label'     =>'Student Registration No.',
                'value'     => function($data){
                    return $data->user->username;
                }
            ],
            //'fk_branch_id',
            'cnic',
            [
                'attribute'=>'dob',
                'filter'=>'',
                'label'     =>'Date of birth',
                'value'     => function($data){
                    return date('d M,Y',strtotime($data->dob));
                }
            ],
            [
                'label'     =>'Email',
                'value'     => function($data){
                    return $data->user->email;
                }
            ],
            [
                'attribute'=>'registration_date',
                'filter'=>'',
                'value'     => function($data){
                    return date('d M,Y',strtotime($data->registration_date));
                }
            ],
            // 'contact_no',
            // 'emergency_contact_no',
            // 'gender_type',
            // 'guardian_type_id',
            // 'country_id',
            // 'province_id',
            // 'city_id',
            // 'session_id',
            // 'group_id',
            // 'shift_id',
            // 'class_id',
            // 'section_id',
            // 'location1',
            // 'location2',
            // 'withdrawl_no',
            // 'district_id',
            // 'religion_id',
            [
                'header'=>'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => "{addEducation} {view} {update} {delete}",
                'buttons' => [
                    'addEducation'=>function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['student-education/create','id'=>$key]);
                    },
                    'view' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['student/view','id'=>$key]);
                    },
                    'update' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['student/update','id'=>$key]));
                    },
                    'delete' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="Delete Student"></span>', ['student/delete','id'=>$model->user->id],['data'=>['placement'=>'bottom','confirm'=>'Are you sure you want to delete this Student?','method'=>'post']
                        ]);
                    }
                ],
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
