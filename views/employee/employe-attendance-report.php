 <?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Attendance Report';
//$this->params['breadcrumbs'][] = $this->title;

?>
 
<div class="employee-info-index content_col grey-form"> 
	<h1 class="p_title"><?= Html::encode($this->title) ?></h1>
    <div class="subjects-index shade"> 
<?php Pjax::begin(['id' => 'pjax-container']) ?> <!-- ajax -->  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
            'label'=>'Full Name',
            'value'=>function($data){
             return Yii::$app->common->getName($data->user_id);
            }

            ],
            [
                'label'=>'Present',
                'value' =>function($data){
                   $query = \app\models\AttendanceMain::find()->where(['fk_user_id'=>$data->user_id])->all();
                   $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'present']);

                    //print_r($query);
                    
                   
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };

                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            [
                'label'=>'Leave',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'leave']);

                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };

                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            [
                'label'=>'late Commer',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'latecommer']);

                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };

                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            [
                'label'=>'Absent',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'absent']);

                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };

                    $presentCount = $query->count();
                    return $presentCount;
                }
            ],
            [
                'label'=>'Total Present %',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'present']);
                    
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
                     if($query->count()> 0){
                     $query1 = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'present'])->one();
                     $datemonth=date('m',strtotime($query1->date));
                     $number = cal_days_in_month(CAL_GREGORIAN, $datemonth, 2018);
                     $presnt= $query->count()/$number*100 .'%';
                     return number_format((float)$presnt, 2);
                     }else{
                        return '0';
                     }
                }
            ],
             [
                'label'=>'Total Leave %',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'leave']);

                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
                     if($query->count()> 0){
                     $query1 = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'leave'])->one();
                     $datemonth=date('m',strtotime($query1->date));
                     $number = cal_days_in_month(CAL_GREGORIAN, $datemonth, 2018);
                     $lev= $query->count()/$number*100;
                     return number_format((float)$lev, 2);
                     }else{
                        return '0';
                     }
                }
            ],
             [
                'label'=>'Total Short Leave %',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'shortleave']);

                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };

                    if($query->count()> 0){
                     $query1 = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'shortleave'])->one();
                     $datemonth=date('m',strtotime($query1->date));
                     $number = cal_days_in_month(CAL_GREGORIAN, $datemonth, 2018);
                     $shrtl= $query->count()/$number*100;
                     return number_format((float)$shrtl, 2);
                     }else{
                        return '0';
                     }
                }
            ],
            [
                'label'=>'Total Absent %',
                'value' =>function($data){
                    $query = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'absent']);
                    
                    /*if type is year mont that follwoing query will be executed*/
                    //if($attendance_type == 'year-month'){
                    //    $query->andWhere(['=','DATE_FORMAT(date, "%Y-%m")',$year_month]);
                   // };
                
                     if($query->count()> 0){
                     $query1 = \app\models\EmployeeAttendance::find()->where(['fk_empl_id'=>$data->emp_id,'leave_type'=>'absent'])->one();
                     $datemonth=date('m',strtotime($query1->date));
                     $number = cal_days_in_month(CAL_GREGORIAN, $datemonth, 2018);
                    $absnt= $query->count()/$number*100 .' %';
                     return number_format((float)$absnt, 2);
                      
                     }else{
                        return '0';
                     }
                    
                    
                }
            ],
            
            /*[
            'label'=>'Parent Name',
            'value'=>function($data){
             return Yii::$app->common->getParentName($data->user_id);
            }

            ],*/
             
            // 'employeeParentsInfos.first_name',
            //  [
            //     'attribute'=>'first_name',
            //     'label'     =>'Parent Name',
            //     'value'=> function ($data){
            //      return $data->employeeParentsInfos->first_name;
                    
            //     }
            //    // 'value'=>'employeeParentsInfos.first_name',
                
                
            // ],
    //          [
    //     'attribute'=>'parent.first_name',
    //     'value'=>function ($model, $key, $index, $column) {
    //         return $model->parent->first_name;
    //     },
    // ],
            // 'dob',
           // 'user.email',
           //  'contact_no',
            // 'emergency_contact_no',
            // 'gender_type',
            // 'guardian_type_id',
            // 'country_id',
            // 'province_id',
            // 'city_id',
            // 'hire_date',
            // 'designation_id',
             //'marital_status',
             // 'rowOptions'=>function($model){
             //    if($model->marital_status == 1){
             //        echo 'Married';
             //    }else{
             //        echo 'Single';
             //    }
             // },
            // 'department_type_id',
            // 'salary',
            // 'religion_type_id',
            // 'location1',
            // 'Nationality',
            // 'location2',
             //'cnic',
            // 'district_id',
        //      [
        //     'attribute'=>'Image',
        //     'format'=>'raw',
        //     'value'     => function($data){
        //         if(!empty($data->user->Image)){
        //         $img= '<img width="40" height="40" src="'.Yii::$app->request->BaseUrl.'/uploads/'.$data->user->Image.'">';
        //         return $img;
        //     }else{
        //         return 'N/A';
        //     }
        // }
        //     ],
           

             [
                'header'=>'Actions',
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
                'buttons' => [
                    'addEducation'=>function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-education toltip" data-placement="bottom" width="20"  title="Add Student Education"></span>', ['education/create','id'=>$key]);
                    },
                    'view' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-eye-open toltip" data-placement="bottom" width="20"  title="View Student"></span>', ['employee/view','id'=>$key]);
                    },
                    'update' => function ($url, $model, $key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-pencil toltip" data-placement="bottom" width="20"  title="Update Student"></span>',Url::to(['employee/update','id'=>$key]));
                    },
                   
                    'delete' => function ($url, $model, $key)
                    {

                        return Html::a(Yii::t('yii', '<span class="glyphicon glyphicon-trash toltip" data-placement="bottom" width="20" title="In Active Employee"></span>'), 'update-status/'.$model->emp_id.'', [
                            'title' => Yii::t('yii', 'update-status'),
                            'aria-label' => Yii::t('yii', 'update-status'),
                            'onclick' => "
                                if (confirm('Are You Sure You Want To In active this Employee...?')) {
                                    $.ajax('$url', {
                                        type: 'POST'
                                    }).done(function(data) {
                                        $.pjax.reload({container: '#pjax-container'});
                                    });
                                }
                                return false;
                            ",
                        ]);

                    },
                     'pdf'=>function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-file" data-placement="bottom" width="20"  title="Generate pdf"></span>', ['employee/create-mpdf','id'=>$key]);
                    },

                ],
            ],
        ],
    ]); ?>
     <?php Pjax::end() ?>   <!-- end of ajax -->
</div>
</div>