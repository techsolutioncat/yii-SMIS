<?php

use yii\helpers\Html; 
use yii\grid\GridView; 
use app\models\StudentParentsInfo;

/* @var $this yii\web\View */ 
/* @var $searchModel app\models\search\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */ 

//$this->title = 'Student Infos'; 
//$this->params['breadcrumbs'][] = $this->title; 
?> 
<div class="student-info-index"> 

    <!-- <h1><?//= Html::encode($this->title) ?></h1>  -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 
 

    <?= GridView::widget([ 
        'dataProvider' => $dataProvider, 
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
            [
                        //'attribute'=>'username',
                        'label'     =>'Student Registration No.',
                        'contentOptions' => ['class' => 'regClass'],
                        'headerOptions' => ['class' => 'regClassHeader'],
                        'value'     => function($data){
                            return $data->user->username;
                        }
                    ],
                    [
                    'label'=>'Full Name',
                    'format'=>'raw',
                    'contentOptions' => ['class' => 'fullnameClass'],
                    'headerOptions' => ['class' => 'fullnameClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getName($data->user_id);
                    },
                     'visible' => true,
                    ],
                     [
                    'label'=>'Parent Name',
                    'contentOptions' => ['class' => 'parntClass'],
                    'headerOptions' => ['class' => 'parntClassHeader'],
                    'value'=>function($data){
                     return Yii::$app->common->getParentName($data->stu_id);
                    }

                    ],
                    [
                    'label'=>'Class',
                    'contentOptions' => ['class' => 'classClass'],
                    'headerOptions' => ['class' => 'classClassHeader'],
                    'value'=>function($data){
                        if($data->class_id){
                      return $data->class->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Group',
                    'contentOptions' => ['class' => 'groupClass'],
                    'headerOptions' => ['class' => 'groupClassHeader'],
                    'value'=>function($data){

                      if($data->group_id){
                      return $data->group->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],

                    [
                    'label'=>'Section',
                    'contentOptions' => ['class' => 'sectionClasses'],
                    'headerOptions' => ['class' => 'sectionClassHeader'],
                    'value'=>function($data){

                      if($data->section_id){
                      return $data->section->title;

                        }else{
                            return "N/A";
                        }
                    }

                    ],
                    [
                       // 'attribute' => 'contact_no',
                        'label'=>'Parent Contact',
                        'contentOptions' => ['class' => 'contactClass'],
                        'headerOptions' => ['class' => 'contactClassHeader'],
                        'value'=>function($data,$key){
                            $name = StudentParentsInfo::find()->where(['stu_id'=>$key])->one();
                            return $name->contact_no;

                        }
                     ],

                    
                    
                    [
                        'attribute'=>'dob',
                        'filter'=>'',
                        'label'     =>'Date of birth',
                        'contentOptions' => ['class' => 'dobClass'],
                        'headerOptions' => ['class' => 'dobClassHeader'],
                        'value'     => function($data){
                            return date('d M,Y',strtotime($data->dob));
                        }
                    ],
            //'stu_id',
           // 'user_id',
           // 'fk_branch_id',
           // 'dob',
           // 'contact_no',
            // 'emergency_contact_no',
            // 'gender_type',
            // 'guardian_type_id',
            // 'country_id',
            // 'province_id',
            // 'fk_ref_province_id2',
            // 'city_id',
            // 'registration_date',
            // 'fee_generation_date',
            // 'monthly_fee_gen_date',
            // 'session_id',
            // 'group_id',
            // 'shift_id',
            // 'class_id',
            // 'section_id',
            // 'cnic',
            // 'location1',
            // 'location2',
            // 'withdrawl_no',
            // 'district_id',
            // 'religion_id',
            // 'parent_status:boolean',
            // 'is_hostel_avail',
            // 'fk_stop_id',
            // 'fk_fee_plan_type',
            // 'is_active',
            // 'fk_ref_country_id2',
            // 'fk_ref_district_id2',
            // 'fk_ref_city_id2',

            //['class' => 'yii\grid\ActionColumn'], 
                    [
                        'header'=>'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => "{delete}",
                        'buttons' => [
                           
                            
                            'delete' => function ($url, $model, $key)
                            {

                                return Html::a('<span class="glyphicon glyphicon-ok" data-placement="bottom" width="20" title="Activate Student"></span>', ['student/active-status', 'id' => $key], ['class' => 'profile-link','onclick'=>"return confirm_delete()"]);

                                /* return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-ok" data-placement="bottom" width="20" title="In Active Student"></span>'), 'active-status/'.$key, [
                                    'title' => Yii::t('yii', 'active-status'),
                                    'aria-label' => Yii::t('yii', 'active-status'),
                                    'onclick' => "
                                        if (confirm('Are You Sure You Want To active this Student...?')) {
                                            $.ajax('active-status', {
                                                type: 'POST'
                                            }).done(function(data) {
                                                $.pjax.reload({container: '#pjax-container'});
                                            });
                                        }
                                        return false;
                                    ",
                                ]);*/
                            },

                           /* 'delete' => function ($url, $model) {
                                return Html::a('', $url, [
                                    'class' => '... popup-modal', 
                                    'data-toggle' => 'modal', 
                                    'data-target' => '#modal', 
                                    'data-id' => $model->stu_id, 
                                    'id' => 'popupModal-'. $model->stu_id
                                ]);
                            },*/

                            
                             
                        ],
                        ],

        ], 
    ]); ?> 
</div> 

<?php
$script = <<< JS
 //here
function confirm_delete() {
  return confirm('are you sure?');
}
JS;
$this->registerJs($script);
?>