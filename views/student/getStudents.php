<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\StudentInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-info-index">
    <?php
    
    $class_array=StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'section_id'=>$_GET['id']])->one();
    $claname= $class_array->class->title;
    $grp= $class_array->group->title;
    $sctn= $class_array->section->title;

    ?>
    <!-- <h1><?//= Html::encode($this->title) ?></h1> -->
    <center><h3>Student List For <?= $claname .' '. $grp .' '. $sctn?></h3></center>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?//= Html::a('Create Student Info', ['create'], ['class' => 'btn green-btn']) ?> -->
    </p>
     <?php Pjax::begin(['enablePushState' => false, 'id'=>'pjax-container'
    ]); ?>

    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
            'label'=>'Full Name',
            'value'=>function($data){
             return $data->user->first_name ." ".$data->user->middle_name  . " " . $data->user->last_name;
            }

            ],
            [
                'label'=>'Parent Name',
                'value'=>function($data){
                 return Yii::$app->common->getParentName($data->stu_id);
                }
    
                ],

            /*[   
                'label'=>'Class',
                'value'     => function($data){
                    if($data->class_id){
                        return ucfirst($data->class->title);
                    }else{
                        return 'N/A';
                    }
                }
            ],
            [
            'label'=>'Group',
            'value'     => function($data){
                if($data->group_id){
                    return ucfirst($data->group->title);
                }else{
                    return 'N/A';

                }

            }
            ],
            [
                'label'=>'Section',
                'value'     => function($data){
                    if($data->section_id) {
                        return ucfirst($data->section->title);
                    }else{
                        return 'N/A';
                    }
                }
            ],*/
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
             'contact_no',
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
                        return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Student"></span>'), 'update-status/'.$model->stu_id.'', [
                                    'title' => Yii::t('yii', 'update-status'),
                                    'aria-label' => Yii::t('yii', 'update-status'),
                                    'onclick' => "
                                        if (confirm('Are You Sure You Want To In active this user...?')) {
                                            $.ajax('$url', {
                                                type: 'POST'
                                            }).done(function(data) {
                                                $.pjax.reload({container: '#pjax-container'});
                                            });
                                        }
                                        return false;
                                    ",
                                ]);
                    }
                    /*{
                        return Html::a('<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="Delete Student"></span>', ['student/delete','id'=>$model->user->id],['data'=>['placement'=>'bottom','confirm'=>'Are you sure you want to delete this Student?','method'=>'post']
                        ]);
                    }*/
                ],
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
